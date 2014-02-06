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
        socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 2, 'usec' => 0));
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
    
    private function getGPUData ($gpuId) {
        $gpuId = intval($gpuId); // simple sanitizing
        $gpuData = $this->_devs[$gpuId];
        
        // TODO:
        // Return NULL if the gpuId exist or not
        //
        
        $data = array();

        $data = array(
            'id' => $gpuData['GPU'],
            'enabled' => $gpuData['Enabled'],
            'health' => $gpuData['Status'],
            'hashrate_avg' => $gpuData['MHS av']  . ' MH/S',
            'hashrate_5s' => $gpuData['MHS 5s']  . ' MH/S',
            'intensity' => $gpuData['Intensity'],
            'temperature' => $gpuData['Temperature'],
            'fan_speed' => $gpuData['Fan Speed'] . ' RPM',
            'fan_percent' => $gpuData['Fan Percent'] . '%',
            'engine_clock' => $gpuData['GPU Clock'],
            'memory_clock' => $gpuData['Memory Clock'],
            'gpu_voltage' => $gpuData['GPU Voltage']  . 'V',
            'powertune' => $gpuData['Powertune']  . '%',
            'accepted' => $gpuData['Accepted'],
            'rejected' => $gpuData['Rejected'],
            'hw_errors' => $gpuData['Hardware Errors'],
            'utility' => $gpuData['Utility'] . '/m',
        );
    
        return $data;
    }
    
    private function getSummaryData() {
        $summaryData = $this->_summary[0];
        $data = array();

        $activePool = null;
        $lastShareTime = null;
        foreach ($this->_pools as $pool) {
            $poolData = $pool;
            if (is_null($lastShareTime)) {
                $activePool = $poolData['Stratum URL'];
                $lastShareTime = $poolData['Last Share Time'];
            } else if ($lastShareTime < $poolData['Last Share Time']) {
                $activePool = $poolData['Stratum URL'];
                $lastShareTime = $poolData['Last Share Time'];                
            }
        }
        
        $data = array(
            'uptime' => date('H\H i\M s\S', $summaryData['Elapsed']),
            'hashrate_avg' => $summaryData['MHS av'] . ' MH/s',
            'hashrate_5s' => $summaryData['MHS 5s'] . ' MH/s',
            'blocks_found' => $summaryData['Found Blocks'],
            'accepted' => $summaryData['Accepted'],
            'rejected' => $summaryData['Rejected'],
            'stale' => $summaryData['Stale'],
            'hw_errors' => $summaryData['Hardware Errors'],
            'utility' => $summaryData['Utility'],
            'active_mining_pool' => $activePool,
        );
        
        return $data;
    }
    
    private function getAllData() {
        $data = array();
        
        // Get GPU Summary
        $data['summary'] = $this->getSummaryData();
        
        // Get All GPU data
        foreach ($this->_devs as $dev) {
            $data['gpus'][] = $this->getGPUData($dev['GPU']);
        }
        
        return $data;
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
