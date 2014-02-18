<?php

/**
 * This class is not final... This was the first attempt of retrieving cgminer data.
 *
 * @author Stoyvo
 */
class Class_Miners_Cgminer {

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
        $socket = $this->getSock($this->_host, $this->_port);
        if (empty($socket)) {
            return null;
        }
        
        // This will cause the page to load not load quickly if miner is offline. Need to handle this somehow.
        socket_write($socket, $cmd, strlen($cmd));
        $line = $this->readSockLine($socket);
        socket_close($socket);
        return $line;
    }

    private function getSock($addr, $port) {
        $socket = null;
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 1, 'usec' => 0));
        
        if ($socket === false || $socket === null) {
            return null;
        }
        
        if (!socket_connect($socket, $addr, $port)) {
            socket_close($socket);
            return null;
        }
        
        return $socket;
    }

    private function readSockLine($socket) {
        $line = '';
        while (true) {
            $byte = socket_read($socket, 1);
            if ($byte === false || $byte === '') {
                break;
            }
            if ($byte === "\0") {
                break;
            }
            $line .= $byte;
        }
        return $line;
    }
    
    private function getDevData ($devId) {
        $devId = intval($devId); // simple sanitizing
        $devData = $this->_devs[$devId];
        
        // TODO:
        // Return NULL if the gpuId exist or not
        //
        
        $data = array();

        $data = array(
            'id' => $devData['GPU'],
            'enabled' => $devData['Enabled'],
            'health' => $devData['Status'],
            'hashrate_avg' => $devData['MHS av'],
            'hashrate_5s' => $devData['MHS 5s'],
            'intensity' => $devData['Intensity'],
            'temperature' => $devData['Temperature'],
            'fan_speed' => $devData['Fan Speed'] . ' RPM',
            'fan_percent' => $devData['Fan Percent'] . '%',
            'engine_clock' => $devData['GPU Clock'],
            'memory_clock' => $devData['Memory Clock'],
            'gpu_voltage' => $devData['GPU Voltage']  . 'V',
            'powertune' => $devData['Powertune']  . '%',
            'accepted' => $devData['Accepted'],
            'rejected' => $devData['Rejected'],
            'hw_errors' => $devData['Hardware Errors'],
            'utility' => $devData['Utility'] . '/m',
        );
    
        return $data;
    }
    
    private function getActivePool() {
        $activePool = array();
        $lastShareTime = null;
        foreach ($this->_pools as $pool) {
            $poolData = $pool;
            if (is_null($lastShareTime)) {
                $activePool['id'] = $poolData['POOL'];
                $activePool['url'] = $poolData['Stratum URL'];
                $lastShareTime = $poolData['Last Share Time'];
            } else if ($lastShareTime < $poolData['Last Share Time']) {
                $activePool['id'] = $poolData['POOL'];
                $activePool['url'] = $poolData['Stratum URL'];
                $lastShareTime = $poolData['Last Share Time'];                
            }
        }
        
        return $activePool;
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
            'type' => 'cgminer',
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
        
        // Get GPU Summary
        $data['summary'] = $this->getSummaryData();
        
        // Get All Device data
        foreach ($this->_devs as $dev) {
            $data['devs'][] = $this->getDevData($dev['GPU']);
        }
        
        return $data;
    }
    
    // Pools
    public function getPools() {
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
    public function switchPool($poolId) {
        return $this->getData('{"command":"switchpool","parameter":"'. $poolId .'"}');
    }

    public function update() {
        // TODO:
        // - Determin if we need to update a json file or just do socket data returns. we dont have limitations on the amount of calls we make
        
        $summary = json_decode($this->getData('{"command":"summary"}'), true);
        $this->_summary = $summary['SUMMARY'];
        
        $dev = json_decode($this->getData('{"command":"devs"}'), true);
        $this->_devs = $dev['DEVS'];
        
        $pools = json_decode($this->getData('{"command":"pools"}'), true);
        $this->_pools = $pools['POOLS'];
        
        return $this->getAllData();
    }

}
