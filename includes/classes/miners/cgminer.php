<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Miners_Cgminer extends Miners_Abstract {

    // Miner Memebers
    protected $_host;
    protected $_port;

    // Data
    protected $_summary = array();
    protected $_devs = array();
    protected $_devStatus = array();
    protected $_pools = array();


    // PUBLIC
    public function __construct($host, $port, $name, $settings) {
        parent::__construct($name, $settings);
        $this->_host = $host;
        $this->_port = $port;
        
        if (is_null($this->fetchData())) {
            return null;
        }
    }
    
    public function overview() {
        $data = array();
        $totalHashrate = 0;
        
        foreach ($this->_devs as $devKey => $dev) {
            $totalHashrate += $dev['MHS 5s'];
        }
        
        $rigStatus = $this->getRigStatus();
        
        $hashrate5s = $this->getFormattedHashrate($totalHashrate);
        $activePool = $this->getActivePool();
        $uptime = $this->getUptime();
        
        return array('overview' => array(
                'name' => $this->_name,
                'status_colour' => $rigStatus['colour'],
                'status_icon' => $rigStatus['icon'],
                'hashrate_5s' => $hashrate5s,
                'active_pool' => $activePool,
                'uptime' => $uptime,
            )
        );
    }
    
    public function update() {
        $data = array(
            'overview' => $this->overview(),
            'summary' => array(),
            'devs' => array(),
        );
        
        return $data;
    }
    
    
    // PRIVATE
    private function cmd($cmd) {
        $response = '';
        $socket = stream_socket_client('tcp://'.$this->_host.':'.$this->_port, $errno, $errstr, 1);
                
        if (!$socket || $errno != 0) {
            return null;
        } else {
            fwrite($socket, $cmd);
            while (!feof($socket)) {
                $response .= fgets($socket);
            }
            fclose($socket);
        }
        
        return str_replace("\0", '', $response); // JSON response has ASCII BOM at the begining. 
    }
    
    private function getActivePool() {
        foreach ($this->_pools as $pool) {
            if ($pool['Priority'] == 0) {
                return array(
                    'id' => $pool['POOL'],
                    'url' => $pool['Stratum URL'],
                );
            }
        }
        
        if (!empty($this->_pools)) {        
            return array(
                'id' => $this->_pools[0]['POOL'],
                'url' => $this->_pools[0]['Stratum URL'],
            );
        }
        
        return array();
    }
    
    private function getDevStatus() {
        foreach ($this->_devs as $devKey => $dev) {
            $status = array();
            
            // Start with hardware errors
            if ($this->_settings['hwErrors']['enabled']) {
                if (
                    ($this->_settings['hwErrors']['type'] == 'number' && $this->_settings['hwErrors']['danger']['number'] >= $dev['Hardware Errors']) || 
                    (
                        $this->_settings['hwErrors']['type'] == 'percent' &&
                        $this->_settings['hwErrors']['danger']['percent'] <= (($dev['Hardware Errors'] / ($dev['Difficulty Accepted'] + $dev['Difficulty Rejected'] + $dev['Hardware Errors'])) * 100)
                    )
                ) {
                    $status = array (
                        'colour' => 'red',
                        'icon' => 'danger'
                    );
                } else if (
                    ($this->_settings['hwErrors']['type'] == 'number' && $this->_settings['hwErrors']['warning']['number'] >= $dev['Hardware Errors']) || 
                    (
                        $this->_settings['hwErrors']['type'] == 'percent' &&
                        $this->_settings['hwErrors']['warning']['percent'] <= (($dev['Hardware Errors'] / ($dev['Difficulty Accepted'] + $dev['Difficulty Rejected'] + $dev['Hardware Errors'])) * 100)
                    )
                ) {
                    $status = array (
                        'colour' => 'orange',
                        'icon' => 'warning-sign'
                    );
                }
            }
            
            // If no hardware errors, check the health
            if (empty($status)) {
                if ($dev['Status'] == 'Dead') {
                    $status = array(
                        'colour' => 'red',
                        'icon' => 'danger'
                    );
                } else if ($dev['Status'] == 'Sick') {
                    $status = array(
                        'colour' => 'orange',
                        'icon' => 'warning-sign'
                    );
                }
            }
            
            // If no hardware errors and health is okay, do temperatures
            if (empty($status) && $this->_settings['temps']['enabled'] && $dev['Temperature'] != '0') {
                if ($this->_settings['temps']['danger'] >= $dev['Temperature']) {
                    $status = array (
                        'colour' => 'red',
                        'icon' => 'hot'
                    );
                } else if ($this->_settings['temps']['warning'] >= $dev['Temperature']) {
                    $status = array (
                        'colour' => 'orange',
                        'icon' => 'fire'
                    );
                }
            }
            
            // If all pass somehow... Mark it good to go!
            if (empty($status) && $dev['Enabled'] == 'Y') {
                $status = array(
                    'colour' => 'green',
                    'icon' => 'cpu-processor'
                );
            }
            
            // If still empty, we must be offline
            if (empty($status)) {
                $status = array(
                    'colour' => 'grey',
                    'icon' => 'ban-circle',
                );
            }
            
            $this->_devStatus[$devKey] = $status;
        }
    }
    private function getRigStatus() {
        $rigStatus = array(
            'colour' => 'grey',
            'icon' => 'ban-circle',
        );
        
        foreach ($this->_devStatus as $status) {
            if ($status['colour'] == 'red') {
                $rigStatus = array(
                    'colour' => 'red',
                    'icon' => $status['icon'],
                );
            } else if ($status['colour'] == 'orange' && $rigStatus['colour'] != 'red') {
                $rigStatus = array(
                    'colour' => 'orange',
                    'icon' => $status['icon'],
                );
            } else if ($status['colour'] == 'green' && $rigStatus['colour'] != 'red' && $rigStatus['colour'] != 'orange') {
                $rigStatus = array(
                    'colour' => 'green',
                    'icon' => $status['icon'],
                );
            }
        }
        
        return $rigStatus;
    }
    
    private function getFormattedHashrate($hashrate) {
        $hashrate *= 1000;
        
        // Math Stuffs
        $units = array('KH', 'MH', 'GH', 'TH', 'PH');
        
        $pow = min(floor(($hashrate ? log($hashrate) : 0) / log(1000)), count($units) - 1);
        $hashrate /= pow(1000, $pow);
        $hashrate = round($hashrate, 2) . ' ' . $units[$pow] . '/s';
        
        return $hashrate;
    }
    
    private function getUptime() {
        if (isset($this->_summary[0]['Elapsed'])) {
            $seconds = $this->_summary[0]['Elapsed'];
            
            $from = new DateTime("@0");
            $to = new DateTime("@$seconds");
            
            if ($seconds < 86400) {
                $format = '%hH %iM %sS';
            } else if ($seconds <= 604800) {
                $format = '%aD %hH %iM';
            } else {
                $format = '%wW %aD %hH';
            }
            
            $uptime = $from->diff($to)->format($format);
            
            return $uptime;
        }
        
        return null;
    }
    
    private function onlineCheck() {
        return $this->cmd('{"command":"version"}');
    }
    
    private function fetchData() {
        if ($this->onlineCheck() != null) {
            $summary = json_decode($this->cmd('{"command":"summary"}'), true);
            $this->_summary = $summary['SUMMARY'];

            $dev = json_decode($this->cmd('{"command":"devs"}'), true);
            $this->_devs = $dev['DEVS'];
            $this->getDevStatus(); // gets status of each device
        
            $pools = json_decode($this->cmd('{"command":"pools"}'), true);
            $this->_pools = $pools['POOLS'];
    
            return true;
        }
        
        return null;
    }
}
