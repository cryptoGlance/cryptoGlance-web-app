<?php

/*
 * @author Stoyvo
 */
class Miners_Cgminer {

    // socket things
    protected $_host;
    protected $_port;

    // data
    protected $_summary;
    protected $_type;
    protected $_devs = array();
    protected $_pools = array();

    public function __construct($host, $port) {
        $this->_host = $host;
        $this->_port = $port;

        if (!extension_loaded('sockets')) {
            die('The sockets extension is not loaded.');
        }
    }

    private function getData($cmd) {
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
        
        return str_replace("\0", '', $response); // It took 4+ hours to find this solution... JSON response has ASCII BOM at the begining. 
    }
    
    private function getDataGPU($devId) {
        $devData = $this->_devs[$devId];
        
        $data = array();
        $data = array(
            'id' => $devData['GPU'],
            'enabled' => $devData['Enabled'],
            'health' => $devData['Status'],
            'hashrate_avg' => round($devData['MHS av'], 3),
            'hashrate_5s' => round($devData['MHS 5s'], 3),
            'intensity' => $devData['Intensity'],
            'temperature' => $devData['Temperature'],
            'fan_speed' => $devData['Fan Speed'] . ' RPM',
            'fan_percent' => $devData['Fan Percent'] . '%',
            'engine_clock' => $devData['GPU Clock'],
            'memory_clock' => $devData['Memory Clock'],
            'gpu_voltage' => $devData['GPU Voltage']  . 'V',
            'powertune' => $devData['Powertune']  . '%',
//            'accepted' => $devData['Accepted'],
            'accepted' => round($devData['Difficulty Accepted']),
//            'rejected' => $devData['Rejected'],
            'rejected' => round($devData['Difficulty Rejected']),
            'hw_errors' => $devData['Hardware Errors'],
            'utility' => $devData['Utility'] . '/m',
        );
    
        return $data;
    }
    
    private function getDataASC($devId) {
        $devData = $this->_devs[$devId];
        
        $data = array();
        $data = array(
            'id' => $devId,
            'type' => 'ASC',
            'enabled' => $devData['Enabled'],
            'health' => $devData['Status'],
            'hashrate_avg' => $devData['MHS av'],
            'hashrate_5s' => $devData['MHS 5s'],
//            'accepted' => $devData['Accepted'],
            'accepted' => round($devData['Difficulty Accepted']),
//            'rejected' => $devData['Rejected'],
            'rejected' => round($devData['Difficulty Rejected']),
            'hw_errors' => $devData['Hardware Errors'],
            'utility' => $devData['Utility'] . '/m',
        );
    
        return $data;
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
        
        return array(
            'id' => $this->_pools[0]['POOL'],
            'url' => $this->_pools[0]['Stratum URL'],
        );
    }
    
    private function getSummaryData() {
        $summaryData = $this->_summary[0];
        $data = array();
        
        $activePool = $this->getActivePool();
        
        if ($summaryData['Elapsed'] <= 86400) { // Less than a day
            $upTime = gmdate('H\H i\M s\S', $summaryData['Elapsed']);
        } else if ($summaryData['Elapsed'] <= 604800) { // Less than a week
            $upTime = gmdate('d\D H\H i\M', $summaryData['Elapsed']);
        } else {  // A Month!?
            $upTime = gmdate('W\W d\D H\H', $summaryData['Elapsed']);
        }
        
        $data = array(
            'uptime' => $upTime,
            'hashrate_avg' => (!empty($summaryData['GHS av'])) ? round($summaryData['GHS av']*1000, 3) : round($summaryData['MHS av'], 3),
            'hashrate_5s' => (!empty($summaryData['GHS 5s'])) ? round($summaryData['GHS 5s']*1000, 3) : round($summaryData['MHS 5s'], 3),
            'blocks_found' => $summaryData['Found Blocks'],
//            'accepted' => $summaryData['Accepted'],
            'accepted' => round($summaryData['Difficulty Accepted']),
//            'rejected' => $summaryData['Rejected'],
            'rejected' => round($summaryData['Difficulty Rejected']),
//            'stale' => $summaryData['Stale'],
            'stale' => round($summaryData['Difficulty Stale']),
            'hw_errors' => $summaryData['Hardware Errors'],
            'utility' => $summaryData['Utility'] . '/m',
//            'utility' => $summaryData['Work Utility'] . '/m',
            'active_mining_pool' => $activePool['url'],
        );
        
        return $data;
    }
    
    private function getAllData() {
        $data = array();
        
        // Get Device Summary
        $data['summary'] = $this->getSummaryData();
        
        // Get All Device data
        foreach ($this->_devs as $devKey => $dev) {
            if (isset($this->_devs[$devKey]['GPU'])) {
                $data['devs']['GPU'][] = $this->getDataGPU($devKey);
            } elseif (isset($this->_devs[$devKey]['ASC']) || isset($this->_devs[$devKey]['PGA'])) {
                $data['devs']['ASC'][] = $this->getDataASC($devKey);
            }
        }

        return $data;
    }
    
    private function onlineCheck() {
        return $this->getData('{"command":"version"}');
    }
    
    // Pools
    public function getPools() {
        if ($this->onlineCheck() != null) {
            $pools = json_decode($this->getData('{"command":"pools"}'), true);
            $this->_pools = $pools['POOLS'];
            
            $activePool = $this->getActivePool();
            
            $poolData = array();
            foreach ($this->_pools as $pool) {
                $poolData[] = array(
                    'id' => $pool['POOL'],
                    'active' => ($pool['POOL'] == $activePool['id']) ? 1 : 0,
                    'url' => $pool['URL'],
                    'alive' => ($pool['Status'] == 'Alive') ? 1 : 0,
                    'Priority' => $pool['Priority'],
                );
            }
            
            // sort array based on priority
            usort($poolData, array('Miners_Cgminer','poolPrioritySort'));
            
            return $poolData;
        }
        
        return null;
    }
    public function switchPool($poolId) {
        return $this->getData('{"command":"switchpool","parameter":"'. $poolId .'"}');
    }
    public function prioritizePools($poolId, $newPriority) {
        $pools = $this->getPools();
        $poolCount = count($pools);
        
        foreach ($pools as $pKey => $pool) {
            if ($pool['id'] == $poolId) {
                unset($pools[$pKey]);
            }
        }
        
        $pools = array_values($pools);
        
        $orderedPoolIds = null;
        for ($i = 0; $i < $poolCount; $i++) {
            if ($i == $newPriority) {
                $orderedPoolIds .= $poolId;
            } else if ($i > $newPriority) {
                $orderedPoolIds .= $pools[$i-1]['id'];
            } else {
                $orderedPoolIds .= $pools[$i]['id'];
            }
            
            if (($poolCount-$i) > 1) {
                $orderedPoolIds .= ',';
            }
        }
        
        return $this->getData('{"command":"poolpriority","parameter":"'. $orderedPoolIds .'"}');
    }
    
    // Dev State
    public function setDevState($devType, $devId, $state) { // 1 = on, 0 = off;        
        $devType = strtolower($devType);
        if ($state == 0) {
            if ($devType == 'gpu') {
                $command = 'gpudisable';
            } else if ($devType == 'asc') {
                $command = 'ascdisable';
            }
            return $this->getData('{"command":"'.$command.'","parameter":"'. $devId .'"}');
        } else if ($state == 1) {
            if ($devType == 'gpu') {
                $command = 'gpuenable';
            } else if ($devType == 'asc') {
                $command = 'ascenable';
            }
            return $this->getData('{"command":"'.$command.'","parameter":"'. $devId .'"}');
        }
        
        return null;        
    }
    
    // Restart
    public function restart() {
            return $this->getData('{"command":"restart"}');
    }
    
    public function getSettings() {
        if ($this->onlineCheck() != null) {
            //$config = $this->getData('{"command":"config"}');
            
            $data = $this->update();
            
            $rigData['devs'] = $data['devs'];
            $rigData['pools'] = $this->_pools;
            
            // sort array based on priority
            usort($rigData['pools'], array('Miners_Cgminer','poolPrioritySort'));
            
            $rigData['active_pool'] = $this->getActivePool();
        
            return $rigData;
        }
        
        return null;
    }

    public function update() {
        if ($this->onlineCheck() != null) {
            $summary = json_decode($this->getData('{"command":"summary"}'), true);
            $this->_summary = $summary['SUMMARY'];

            $dev = json_decode($this->getData('{"command":"devs"}'), true);
            $this->_devs = $dev['DEVS'];
        
            $pools = json_decode($this->getData('{"command":"pools"}'), true);
            $this->_pools = $pools['POOLS'];
            
    
            return $this->getAllData();
        }
        
        return null;
    }
    
    // misc
    private static function poolPrioritySort($a,$b) {
        return ($a['Priority'] < $b['Priority']) ? -1 : 1;
    }

}
