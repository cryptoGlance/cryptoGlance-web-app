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
    protected $_eStats = array();
    protected $_pools = array();

    // Common Data
    protected $_devStatus = array();
    protected $_rigStatus = 'offline';
    protected $_rigHashrate_5s = 0;
    protected $_rigHashrate_avg = 0;
    protected $_activePool = array();
    protected $_upTime;

    // Version Handling
    protected $_shareTypePrefix = ''; // This will set shares to 'Difficulty Accepted' or just 'Accepted'

    // PUBLIC
    public function __construct($rig) {
        parent::__construct($rig);
        $this->_host = $rig['host'];
        $this->_port = $rig['port'];

        if ($this->fetchData() === false) {
            return null;
        }
    }

    public function overview() {
        return array(
            'name' => $this->_name,
            'status' => $this->_rigStatus,
            'algorithm' => $this->_settings['algorithm'],
            'hashrate_avg' => $this->_rigHashrate_avg,
            'hashrate_5s' => $this->_rigHashrate_5s,
            'active_pool' => $this->_activePool,
            'uptime' => $this->_upTime,
        );
    }

    public function summary() {
        if ($this->_summary['Difficulty Accepted'] > $this->_summary['Accepted']) {
            $this->_shareTypePrefix = 'Difficulty ';
        }

        $totalShares = $this->_summary[$this->_shareTypePrefix.'Accepted'] + $this->_summary[$this->_shareTypePrefix.'Rejected'] + $this->_summary[$this->_shareTypePrefix.'Stale'];

        if (!isset($this->_summary['Device Hardware%'])) {
            $hePercent = $this->calculateHwPercent($this->_summary['Hardware Errors'], $this->_summary[$this->_shareTypePrefix.'Accepted'], $this->_summary[$this->_shareTypePrefix.'Rejected']);
        } else {
            $hePercent = $this->_summary['Device Hardware%'];
        }

        return array(
            'algorithm' => $this->_settings['algorithm'],
            'hashrate_avg' => (isset($this->_summary['MHS av'])) ? $this->_summary['MHS av'] : $this->_summary['GHS av']*1000,
            'blocks_found' => $this->_summary['Found Blocks'],
            'accepted' => array(
                'raw' => round($this->_summary[$this->_shareTypePrefix.'Accepted']),
                'percent' => round(($this->_summary[$this->_shareTypePrefix.'Accepted']/$totalShares)*100, 2),
            ),
            'rejected' => array(
                'raw' => round($this->_summary[$this->_shareTypePrefix.'Rejected']),
                'percent' => round(($this->_summary[$this->_shareTypePrefix.'Rejected']/$totalShares)*100, 2),
            ),
            'stale' => array(
                'raw' => round($this->_summary[$this->_shareTypePrefix.'Stale']),
                'percent' => round(($this->_summary[$this->_shareTypePrefix.'Stale']/$totalShares)*100, 2),
            ),
            'hw_errors' => array(
                'raw' => $this->_summary['Hardware Errors'],
                'percent' => round($hePercent,3),
            ),
            'work_utility' => $this->_summary['Work Utility'] . '/m',
            'best_share' => $this->_summary['Best Share'],
            'active_pool' => (empty($this->_activePool) ? array('url' => '--') : $this->_activePool),
        );
    }

    public function devices() {
        $devices = array();

        foreach ($this->_devs as $devKey => $dev) {
            $totalShares = $dev[$this->_shareTypePrefix.'Accepted'] + $dev[$this->_shareTypePrefix.'Rejected'];

            if (!isset($dev['Device Hardware%'])) {
                $hePercent = $this->calculateHwPercent($dev['Hardware Errors'], $dev[$this->_shareTypePrefix.'Accepted'], $dev[$this->_shareTypePrefix.'Rejected']);
            } else {
                $hePercent = $dev['Device Hardware%'];
            }

            if (isset($dev['GPU'])) {
                $devices[] = array(
                    'id' => $devKey,
                    'type' => 'GPU',
                    'name' => 'GPU',
                    'status' => $this->_devStatus[$devKey],
                    'enabled' => $dev['Enabled'],
                    'health' => $dev['Status'],
                    'hashrate_avg' => $dev['MHS av'],
                    'hashrate_5s' => ($dev['MHS 5s'] ? $dev['MHS 5s'] : $dev['MHS 20s']),
                    'intensity' => $dev['Intensity'],
                    'temperature' => array(
                        'celsius' => $dev['Temperature'],
                        'fahrenheit' => ((($dev['Temperature']*9)/5)+32),
                    ),
                    'fan_speed' => array(
                        'raw' => $dev['Fan Speed'],
                        'percent' => $dev['Fan Percent'],
                    ),
                    'engine_clock' => $dev['GPU Clock'],
                    'memory_clock' => $dev['Memory Clock'],
                    'gpu_voltage' => $dev['GPU Voltage'] . 'V',
                    'powertune' => $dev['Powertune'] . '%',
                    'accepted' => array(
                        'raw' => round($dev[$this->_shareTypePrefix.'Accepted']),
                        'percent' => round(($dev[$this->_shareTypePrefix.'Accepted']/$totalShares)*100, 2),
                    ),
                    'rejected' => array(
                        'raw' => round($dev[$this->_shareTypePrefix.'Rejected']),
                        'percent' => round(($dev[$this->_shareTypePrefix.'Rejected']/$totalShares)*100, 2),
                    ),
                    'hw_errors' => array(
                        'raw' => $dev['Hardware Errors'],
                        'percent' => round($hePercent,3),
                    ),
                    'utility' => $dev['Utility'] . '/m',
                );
            } else if (isset($dev['ASC']) || isset($dev['PGA'])) {
                $data = array(
                    'id' => $devKey,
                    'type' => (isset($dev['ASC']) ? 'ASC' : 'PGA'),
                    'name' => (isset($dev['ASC']) ? 'ASC' : 'PGA'),
                    'status' => $this->_devStatus[$devKey],
                    'enabled' => $dev['Enabled'],
                    'health' => $dev['Status'],
                    'hashrate_avg' => $dev['MHS av'],
                    'hashrate_5s' => ($dev['MHS 5s'] ? $dev['MHS 5s'] : $dev['MHS 20s']),
                    'temperature' => array(
                        'celsius' => ($dev['Temperature'] ? $dev['Temperature'] : 0),
                        'fahrenheit' => ((($dev['Temperature']*9)/5)+32),
                    ),
                    'frequency' => (isset($dev['Frequency']) ? $dev['Frequency'] : null),
                    'accepted' => array(
                        'raw' => round($dev[$this->_shareTypePrefix.'Accepted']),
                        'percent' => round(($dev[$this->_shareTypePrefix.'Accepted']/$totalShares)*100, 2),
                    ),
                    'rejected' => array(
                        'raw' => round($dev[$this->_shareTypePrefix.'Rejected']),
                        'percent' => round(($dev[$this->_shareTypePrefix.'Rejected']/$totalShares)*100, 2),
                    ),
                    'hw_errors' => array(
                        'raw' => $dev['Hardware Errors'],
                        'percent' => round($hePercent,3),
                    ),
                    'utility' => $dev['Utility'] . '/m',
                );
                $data['name'] = (isset($dev['Name']) ? $dev['Name'] : $data['name']);

                // Custom Handling based on eStats
                if ($dev['fan_speeds']) {
                    foreach ($dev['fan_speeds'] as $fKey => $fanSpeed) {
                        $data['fan_'.($fKey+1)] = $fanSpeed;
                    }
                }
                if ($dev['temperatures']) {
                    foreach ($dev['temperatures'] as $tKey => $temperature) {
                        $data['temperature_'.($tKey+1)] = array(
                            'celsius' => $temperature,
                            'fahrenheit' => ((($temperature*9)/5)+32),
                        );
                    }
                }

                if (!$data['frequency']) {
                    unset($data['frequency']);
                }

                $devices[] = $data;
            }
        }

        return $devices;
    }

    public function pools() {
        $pools = array();
        foreach ($this->_pools as $pool) {
            $pools[$pool['Priority']] = array(
                'id' => $pool['POOL'],
                'status' => ($pool['Status'] == 'Alive') ? 1 : 0,
                'active' => ($pool['POOL'] == $this->_activePool['id']) ? 1 : 0,
                'url' => $pool['URL'],
                'user' => $pool['User'],
                'priority' => $pool['Priority'],
            );
        }

        ksort($pools);

        return $pools;
    }

    public function restart() {
        $this->cmd('{"command":"restart"}');
    }

    public function switchPool($poolId) {
        return $this->cmd('{"command":"switchpool","parameter":"'. $poolId .'"}');
    }

    public function enablePool($poolId) {
        return $this->cmd('{"command":"enablepool","parameter":"'. $poolId .'"}');
    }

    public function disablePool($poolId) {
        return $this->cmd('{"command":"disablepool","parameter":"'. $poolId .'"}');
    }

    public function enablePools() {
        foreach ($this->pools() as $pool) {
            $this->enablePool($pool['id']);
        }
    }

    public function disablePools() {
        foreach ($this->pools() as $pool) {
            $this->disablePool($pool['id']);
        }
    }

    public function removePool($poolId) {
        return $this->cmd('{"command":"removepool","parameter":"'. $poolId .'"}');
    }

    public function addPool($values) {
        $poolPriority = end($values);
        array_pop($values);
        $this->cmd('{"command":"addpool","parameter":"'. implode(',', $values) .'"}');

        // Now prioritize
        $this->fetchPools();
        $pools = $this->_pools;
        $currentPool = end($pools);
        $poolId = $currentPool['POOL'];

        $this->prioritizePools($poolPriority, $poolId);

        return;
    }

    public function editPool($poolId, $values) {
        $this->removePool($poolId);
        $this->addPool($values);

        return;
    }

    public function prioritizePools($poolPriority, $poolId) {
        foreach ($this->_pools as $key => $pool) {
            if ($pool['Priority'] == $poolPriority) {
                $this->_pools[$key]['Priority']++;
            }
            if ($pool['POOL'] == $poolId) {
                $this->_pools[$key]['Priority'] = $poolPriority;
                break;
            }
        }

        usort($this->_pools, array('Miners_Cgminer','prioritySort'));

        $priorityList = array();
        foreach ($this->_pools as $key => $pool) {
            $priorityList[] = $pool['POOL'];
        }

        $this->cmd('{"command":"poolpriority","parameter":"'. implode(',', $priorityList) .'"}');

        return;
    }


    public function enableDevice($devType, $devId) {
        return $this->cmd('{"command":"'.$devType.'enable","parameter":"'. $devId .'"}');
    }

    public function disableDevice($devType, $devId) {
        return $this->cmd('{"command":"'.$devType.'disable","parameter":"'. $devId .'"}');
    }

    public function updateDevice($deviceData) {
        foreach ($deviceData as $devId => $settings) {
            foreach ($settings as $key => $val) {
                switch ($key) {
                    case "frequency":
                        // Currently no options for frequencies
                        break;
                    case "intensity":
                        $this->cmd('{"command":"gpuintensity","parameter":"'. $devId .', '. $val .'"}');
                        break;
                    case "fan_percent":
                        $this->cmd('{"command":"gpufan","parameter":"'. $devId .', '. $val .'"}');
                        break;
                    case "engine_clock":
                        $this->cmd('{"command":"gpuengine","parameter":"'. $devId .', '. $val .'"}');
                        break;
                    case "memory_clock":
                        $this->cmd('{"command":"gpumem","parameter":"'. $devId .', '. $val .'"}');
                        break;
                    case "gpu_voltage":
                        $this->cmd('{"command":"gpuvddc","parameter":"'. $devId .', '. $val .'"}');
                        break;
                }
            }
        }
    }

    public function resetStats() {
        $this->cmd('{"command":"zero","parameter":"all,false"}');
    }

    public function update() {
        $data = array(
            'overview' => $this->overview(),
            'summary' => $this->summary(),
            'devs' => $this->devices(),
        );

        return $data;
    }

    public function getSettings() {
        $settings = parent::getSettings();
        $settings['host'] = $this->_host;
        $settings['port'] = $this->_port;

        return $settings;
    }


    // PRIVATE
    private function cmd($cmd) {
        $response = '';
        $socket = stream_socket_client('tcp://'.$this->_host.':'.$this->_port, $errno, $errstr, 2);

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
        $pools = array();
        foreach ($this->_pools as $pool) {
            if ($pool['Status'] == 'Alive' && $pool['Stratum Active'] == '1') {
                $pools[] = $pool;
            }
        }

        $activePool = array();
        $activePool['Last Share Time'] = 0;
        $totalPools = count($pools);
        foreach ($pools as &$pool) {
            if (strpos($pool['Last Share Time'], ':') !== FALSE) {
                $pool['Last Share Time'] = preg_replace("/[^0-9]/", "", $pool['Last Share Time']);
            }
            if (
                ($totalPools > 1 && $pool['Last Share Time'] > $activePool['Last Share Time'])
                ||
                ($totalPools == 1)
                ||
                ($pool['Priority'] == 0)
            ) {
                $activePool = array(
                    'id' => $pool['POOL'],
                    'url' => ltrim(stristr($pool['URL'], '//'), '//'),
                    'Last Share Time' => $pool['Last Share Time'],
                    'algorithm' => (array_key_exists('Algorithm Type', $pool) ? $pool['Algorithm Type'] : null),
                );
            }
        }

        unset($activePool['Last Share Time']);
        $this->_activePool = $activePool;
    }

    private function getDevStatus() {
        foreach ($this->_devs as $devKey => $dev) {
            // Might as well get the hashrate
            $this->_rigHashrate_5s += ($dev['MHS 5s'] ? $dev['MHS 5s'] : $dev['MHS 20s']);
            $this->_rigHashrate_avg += ($dev['MHS av'] ? $dev['MHS av'] : $dev['MHS av']);

            $status = array();

            // Start with hardware errors
            $status = $this->statusHardwareErrors($dev);

            // If rejects are higher than accepted
            if (empty($status)) {
                $shareTypePrefix = '';
                if ($this->_summary['Difficulty Accepted'] > $this->_summary['Accepted']) {
                    $shareTypePrefix = 'Difficulty ';
                }
                $totalShares = $dev[$shareTypePrefix.'Accepted'] + $dev[$shareTypePrefix.'Rejected'];
                $acceptedPercent = round(($dev[$shareTypePrefix.'Accepted']/$totalShares)*100, 2);
                $rejectedPercent = round(($dev[$shareTypePrefix.'Rejected']/$totalShares)*100, 2);

                if ($rejectedPercent > $acceptedPercent) {
                    $status = array (
                        'colour' => 'red',
                        'icon' => 'awstats'
                    );
                }
            }

            // Check temperatures limits
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
            'panel' => 'panel-offline',
        );

        if (count($this->_devStatus) > 0) {
            foreach ($this->_devStatus as $status) {
                if ($status['colour'] == 'red') {
                    $rigStatus = array(
                        'colour' => 'red',
                        'icon' => $status['icon'],
                        'panel' => 'panel-danger',
                    );
                } else if ($status['colour'] == 'orange' && $rigStatus['colour'] != 'red') {
                    $rigStatus = array(
                        'colour' => 'orange',
                        'icon' => $status['icon'],
                        'panel' => 'panel-warning',
                    );
                } else if ($status['colour'] == 'green' && $rigStatus['colour'] != 'red' && $rigStatus['colour'] != 'orange') {
                    $rigStatus = array(
                        'colour' => 'green',
                        'icon' => $status['icon'],
                        'panel' => '',
                    );
                }
            }
        } else {
            $rigStatus = $this->statusHardwareErrors($this->_summary);
            if ($rigStatus === false) {
                $rigStatus = array(
                    'colour' => 'green',
                    'icon' => 'cpu-processor',
                    'panel' => '',
                );
            }
        }

        $this->_rigStatus = $rigStatus;
    }

    private function calculateHwPercent($hwErrors, $diffA, $diffR ) {
        return ($hwErrors / ($diffA + $diffR + $hwErrors)) * 100;
    }

    private function onlineCheck() {
        return $this->cmd('{"command":"version"}');
    }

    // Returns status or false if hardware errors exceed limit
    private function statusHardwareErrors($data) {
        // Start with hardware errors
        if ($this->_settings['hwErrors']['enabled']) {
            if (
                ($this->_settings['hwErrors']['type'] == 'int' && $this->_settings['hwErrors']['danger']['int'] <= $data['Hardware Errors']) ||
                ($this->_settings['hwErrors']['type'] == 'percent' && $this->_settings['hwErrors']['danger']['percent'] <= $data['Device Hardware%'])
            ) {
                return array (
                    'colour' => 'red',
                    'icon' => 'danger',
                    'panel' => 'panel-danger'
                );
            } else if (
                ($this->_settings['hwErrors']['type'] == 'int' && $this->_settings['hwErrors']['warning']['int'] <= $data['Hardware Errors']) ||
                ($this->_settings['hwErrors']['type'] == 'percent' && $this->_settings['hwErrors']['warning']['percent'] <= $data['Device Hardware%'])
            ) {
                return array (
                    'colour' => 'orange',
                    'icon' => 'warning-sign',
                    'panel' => 'panel-warning'
                );
            }
        }

        return false;
    }

    private function fetchData() {
        if ($this->onlineCheck() != null) {
            // Cgminer Summary
            $summary = json_decode($this->cmd('{"command":"summary"}'), true);
            $this->_summary = $summary['SUMMARY'][0];

            // Devices
            $this->fetchDevices();
            // Device Details
            $this->fetchDeviceDetails();

            // Pools
            $this->fetchPools();

            //Misc data
            $this->_upTime = formatTimeElapsed($this->_summary['Elapsed']);
            if (empty($this->_rigHashrate_5s)) {
                if (isset($this->_summary['MHS av'])) {
                    $this->_rigHashrate_5s = $this->_summary['MHS av'];
                } else if (isset($this->_summary['GHS av'])) {
                    $this->_rigHashrate_5s = $this->_summary['GHS av']*1000;
                }
            }
            if (empty($this->_rigHashrate_avg)) {
                if (isset($this->_summary['MHS av'])) {
                    $this->_rigHashrate_avg = $this->_summary['MHS av'];
                } else if (isset($this->_summary['GHS av'])) {
                    $this->_rigHashrate_avg = $this->_summary['GHS av']*1000;
                }
            }

            return true;
        }

        return false;
    }

    private function fetchDevices() {
        $dev = json_decode($this->cmd('{"command":"devs"}'), true);
        $this->_devs = $dev['DEVS'];
        $this->getDevStatus(); // gets status of each device
        $this->getRigStatus(); // Determins the rigs status
    }
    private function fetchDeviceDetails() {
        $eStats = json_decode($this->cmd('{"command":"estats","parameter":1}'), true);
        $eStats = (is_array($eStats['STATS']) ? $eStats['STATS'] : array());
        $this->_eStats = $eStats;

        // Add device details to dev data
        foreach ($this->_devs as $dKey => $dev) {
            $devId = $dev['Name'].$dev['ID'];
            foreach ($eStats as $eKey => $stat) {
                if ($devId = $stat['ID']) {
                    if ($stat['frequency']) {
                        $this->_devs[$dKey]['Frequency'] = $stat['frequency'];
                    }

                    // Get all fan speeds
                    if ($stat['fan_num'] && $stat['fan_num'] > 0) {
                        $this->_devs[$dKey]['fan_speeds'] = array();
                        for ($i = 1; $i <= $stat['fan_num']; $i++) {
                            if ($stat['fan'.$i] && $stat['fan'.$i] > 0) {
                                $this->_devs[$dKey]['fan_speeds'][] = $stat['fan'.$i];
                            }
                        }
                    }

                    // Get all temperatures reported
                    if ($stat['temp_num'] && $stat['temp_num'] > 0) {
                        $this->_devs[$dKey]['temperatures'] = array();
                        for ($i = 1; $i <= $stat['temp_num']; $i++) {
                            if ($stat['temp'.$i] && $stat['temp'.$i] > 0) {
                                $this->_devs[$dKey]['temperatures'][] = $stat['temp'.$i];
                            }
                        }
                    }

                    unset($eStats[$eKey]);
                    break 1;
                }
            }
        }
    }

    private function fetchPools() {
        $pools = json_decode($this->cmd('{"command":"pools"}'), true);
        $this->_pools = $pools['POOLS'];
        $this->getActivePool();
    }


    /* Private functions for independant product types. EG: Bitmain */
    private function _checkBitmain() {
        if (!empty($this->_eStats)) {
            foreach ($this->_eStats as $eStats) {
                // if a bitmain asic has an 'x' in it's data, that means an asic chip has failed
                // and we will restart it automatically
                for ($i=1; $eStats['miner_count'] >=$i; $i++) {
                    if (strpos($eStats['chain_acs'.$i], 'x') !== false) {
                        $this->restart();
                    }
                }
            }
        }
    }

    /* Private functions for things such as sorting */
    private function prioritySort($a,$b) {
        return ($a['Priority'] < $b['Priority']) ? -1 : 1;
    }
}
