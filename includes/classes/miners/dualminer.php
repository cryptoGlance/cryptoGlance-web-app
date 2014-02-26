<?php

/*
 *
 * @author Stoyvo
 */
class Class_Miners_Dualminer {

    protected $_host;
    protected $_port;
    protected $_summary;
//    protected $_stats;

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
        
        if (!$socket) {
            return null;
        } else {
            fwrite($socket, $cmd);
            while (!feof($socket)) {
                $response .= fgets($socket, 1024);
            }
            fclose($socket);
        }
        
        return str_replace("\0", '', $response); // It took 4+ hours to find this solution... JSON response has ASCII BOM at the begining. 
    }
    
    private function getDevData ($devId) {
        if (is_null($devId)) {
            return null;
        }
        $devId = intval($devId); // simple sanitizing
        $devData = $this->_devs[$devId];
        
        // Building Summary stats
        $this->_summary[0]['MHS 5s'] += (float) $devData['MHS 5s'];

        $data = array();

        $data = array(
            'id' => $devId,
            'enabled' => $devData['Enabled'],
            'health' => $devData['Status'],
            'hashrate_avg' => $devData['MHS av'],
            'hashrate_5s' => $devData['MHS 5s'],
            'accepted' => $devData['Accepted'],
            'rejected' => $devData['Rejected'],
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
            'type' => 'dualminer',
            'uptime' => $upTime,
            'hashrate_avg' => $summaryData['MHS av'],
            'hashrate_5s' => $summaryData['MHS 5s'],
            'blocks_found' => $summaryData['Found Blocks'],
            'accepted' => $summaryData['Accepted'],
            'rejected' => $summaryData['Rejected'],
            'stale' => $summaryData['Stale'],
            'hw_errors' => $summaryData['Hardware Errors'],
            'utility' => $summaryData['Utility'] . '/m',
            'active_mining_pool' => $activePool['url'],
        );
        
        return $data;
    }
    
    private function getAllData() {
        $data = array();
        
        // Get All Device data
        foreach ($this->_devs as $dev) {
            $data['devs'][] = $this->getDevData($dev['PGA']);
        }
        
        // Get GPU Summary
        $data['summary'] = $this->getSummaryData();
        
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
                );
            }
            
            return $poolData;
        }
        
        return null;
    }
    public function switchPool($poolId) {
        return $this->getData('{"command":"switchpool","parameter":"'. $poolId .'"}');
    }
        
    // Restart
    public function restart() {
        return $this->getData('{"command":"restart"}');
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

}
