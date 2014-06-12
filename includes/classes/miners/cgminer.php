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
    protected $_pools = array();
    
    // Common Data
    protected $_devStatus = array();
    protected $_rigStatus = array();
    protected $_rigHashrate = 0;
    protected $_activePool = array();
    protected $_upTime;


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
        return array(
            'name' => $this->_name,
            'status' => $this->_rigStatus,
            'hashrate_5s' => $this->getFormattedHashrate($this->_rigHashrate),
            'raw_hashrate' => $this->_rigHashrate,
            'active_pool' => $this->_activePool,
            'uptime' => $this->_upTime,
        );
    }
    
    public function summary() {
        $totalShares = $this->_summary['Difficulty Accepted'] + $this->_summary['Difficulty Rejected'] + $this->_summary['Difficulty Stale'];
        $hePercent = round(($this->_summary['Hardware Errors'] / ($this->_summary['Difficulty Accepted'] + $this->_summary['Difficulty Rejected'] + $this->_summary['Hardware Errors'])) * 100, 3);
        
        return array(
            'hashrate_avg' => $this->getFormattedHashrate($this->_summary['MHS av']),
            'blocks_found' => $this->_summary['Found Blocks'],
            'accepted' => $this->_summary['Difficulty Accepted'] . ' ('. round(($this->_summary['Difficulty Accepted']/$totalShares)*100, 3) .'%)',
            'rejected' => $this->_summary['Difficulty Rejected'] . ' ('. round(($this->_summary['Difficulty Rejected']/$totalShares)*100, 3) .'%)',
            'stale' => $this->_summary['Difficulty Stale'] . ' ('. round(($this->_summary['Difficulty Stale']/$totalShares)*100, 3) .'%)',
            'hw_errors' => $this->_summary['Hardware Errors'] . ' ('.$hePercent.'%)',
            'work_utility' => $this->_summary['Work Utility'] . '/m',
        );
    }
    
    public function devices() {
        $devices = array();

        foreach ($this->_devs as $devKey => $dev) {
            $totalShares = $dev['Difficulty Accepted'] + $dev['Difficulty Rejected'];
            $hePercent = round(($dev['Hardware Errors'] / ($dev['Difficulty Accepted'] + $dev['Difficulty Rejected'] + $dev['Hardware Errors'])) * 100, 3);
            
            if (isset($dev['GPU'])) {
                $devices[] = array(
                    'id' => $dev['GPU'],
                    'status' => $this->_devStatus[$devKey],
                    'enabled' => $dev['Enabled'],
                    'health' => $dev['Status'],
                    'hashrate_avg' => $this->getFormattedHashrate($dev['MHS av']),
                    'hashrate_5s' => $this->getFormattedHashrate($dev['MHS 5s']),
                    'intensity' => $dev['Intensity'],
                    'temperature' => $dev['Temperature'],
                    'fan_speed' => $dev['Fan Speed'] . ' RPM ('.$dev['Fan Percent'] . '%'.')',
                    'engine_clock' => $dev['GPU Clock'],
                    'memory_clock' => $dev['Memory Clock'],
                    'gpu_voltage' => $dev['GPU Voltage']  . 'V',
                    'powertune' => $dev['Powertune']  . '%',
                    'accepted' => $dev['Difficulty Accepted'] . ' ('. round(($dev['Difficulty Accepted']/$totalShares)*100, 3) .'%)',
                    'rejected' => $dev['Difficulty Rejected'] . ' ('. round(($dev['Difficulty Rejected']/$totalShares)*100, 3) .'%)',
                    'hw_errors' => $dev['Hardware Errors'] . ' ('.$hePercent.'%)',
                    'utility' => $dev['Utility'] . '/m',
                );
            } else if (isset($dev['ASC']) || isset($dev['PGA'])) {
                $devices[] = array(
                    'id' => (isset($dev['ASC']) ? $dev['ASC'] : $dev['PGA']),
                    'status' => $this->_devStatus[$devKey],
                    'enabled' => $dev['Enabled'],
                    'health' => $dev['Status'],
                    'hashrate_avg' => $this->getFormattedHashrate($dev['MHS av']),
                    'hashrate_5s' => $this->getFormattedHashrate($dev['MHS 5s']),
                    'temperature' => $dev['Temperature'],
                    'accepted' => $dev['Difficulty Accepted'] . ' ('. round(($dev['Difficulty Accepted']/$totalShares)*100, 3) .'%)',
                    'rejected' => $dev['Difficulty Rejected'] . ' ('. round(($dev['Difficulty Rejected']/$totalShares)*100, 3) .'%)',
                    'hw_errors' => $dev['Hardware Errors'] . ' ('.$hePercent.'%)',
                    'utility' => $dev['Utility'] . '/m',
                    'frequency' => (isset($dev['Frequency']) ? $dev['Frequency'] : null),
                );
            }
        }
        
        return $devices;
    }
    
    public function update() {
        $data = array(
            'overview' => $this->overview(),
            'summary' => $this->summary(),
            'devs' => $this->devices(),
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
                $this->_activePool = array(
                    'id' => $pool['POOL'],
                    'url' => $pool['Stratum URL'],
                );
                return true;
            }
        }
        
        if (!empty($this->_pools)) {        
            $this->_activePool = array(
                'id' => $this->_pools[0]['POOL'],
                'url' => $this->_pools[0]['Stratum URL'],
            );
            
            return true;
        }
        
        return array();
    }
    
    private function getDevStatus() {
        foreach ($this->_devs as $devKey => $dev) {
            // Might as well get the hashrate
            $this->_rigHashrate += $dev['MHS 5s'];
        
            $status = array();
            
            // Start with hardware errors
            if ($this->_settings['hwErrors']['enabled']) {
                if (
                    ($this->_settings['hwErrors']['type'] == 'number' && $this->_settings['hwErrors']['danger']['number'] <= $dev['Hardware Errors']) || 
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
                    ($this->_settings['hwErrors']['type'] == 'number' && $this->_settings['hwErrors']['warning']['number'] <= $dev['Hardware Errors']) || 
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
                if ($dev['Temperature'] >= $this->_settings['temps']['danger']) {
                    $status = array (
                        'colour' => 'red',
                        'icon' => 'hot'
                    );
                } else if ($dev['Temperature'] >= $this->_settings['temps']['warning']) {
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
            'panel' => 'offline',
        );
        
        foreach ($this->_devStatus as $status) {
            if ($status['colour'] == 'red') {
                $rigStatus = array(
                    'colour' => 'red',
                    'icon' => $status['icon'],
                    'panel' => 'danger',
                );
            } else if ($status['colour'] == 'orange' && $rigStatus['colour'] != 'red') {
                $rigStatus = array(
                    'colour' => 'orange',
                    'icon' => $status['icon'],
                    'panel' => 'warning',
                );
            } else if ($status['colour'] == 'green' && $rigStatus['colour'] != 'red' && $rigStatus['colour'] != 'orange') {
                $rigStatus = array(
                    'colour' => 'green',
                    'icon' => $status['icon'],
                    'panel' => '',
                );
            }
        }
        
        $this->_rigStatus = $rigStatus;
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
        if (isset($this->_summary['Elapsed'])) {
            $seconds = $this->_summary['Elapsed'];
            
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
            
            $this->_upTime = $uptime;
            
            return true;
        }
        
        return null;
    }
    
    private function onlineCheck() {
        return $this->cmd('{"command":"version"}');
    }
    
    private function fetchData() {
        if ($this->onlineCheck() != null) {
            // Cgminer Summary
            $summary = json_decode($this->cmd('{"command":"summary"}'), true);
            $this->_summary = $summary['SUMMARY'][0];

            // Devices
            $dev = json_decode($this->cmd('{"command":"devs"}'), true);
            $this->_devs = $dev['DEVS'];
            $this->getDevStatus(); // gets status of each device
            $this->getRigStatus(); // Determins the rigs status
        
            // Pools
            $pools = json_decode($this->cmd('{"command":"pools"}'), true);
            $this->_pools = $pools['POOLS'];
            $this->getActivePool();
    
            //Misc data
            $this->getUptime();
            return true;
        }
        
        return null;
    }
}
