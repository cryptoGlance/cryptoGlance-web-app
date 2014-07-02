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
    public function __construct($rig) {
        parent::__construct($rig);
        $this->_host = $rig['host'];
        $this->_port = $rig['port'];

        if ($this->fetchData() == null) {
            return null;
        }
    }

    public function overview() {
        return array(
            'name' => $this->_name,
            'status' => $this->_rigStatus,
            'algorithm' => $this->_settings['algorithm'],
            'hashrate_5s' => $this->getFormattedHashrate($this->_rigHashrate),
            'raw_hashrate' => $this->_rigHashrate,
            'active_pool' => $this->_activePool,
            'uptime' => $this->_upTime,
        );
    }

    public function summary() {
        $totalShares = $this->_summary['Difficulty Accepted'] + $this->_summary['Difficulty Rejected'] + $this->_summary['Difficulty Stale'];

        if (!isset($this->_summary['Device Hardware%'])) {
            $hePercent = $this->calculateHwPercent($this->_summary['Hardware Errors'], $this->_summary['Difficulty Accepted'], $this->_summary['Difficulty Rejected']);
        } else {
            $hePercent = $this->_summary['Device Hardware%'];
        }

        return array(
            'hashrate_avg' => $this->getFormattedHashrate($this->_summary['MHS av']),
            'blocks_found' => $this->_summary['Found Blocks'],
            'accepted' => array(
                'raw' => round($this->_summary['Difficulty Accepted']),
                'percent' => round(($this->_summary['Difficulty Accepted']/$totalShares)*100, 2) . '%',
            ),
            'rejected' => array(
                'raw' => round($this->_summary['Difficulty Rejected']),
                'percent' => round(($this->_summary['Difficulty Rejected']/$totalShares)*100, 2) . '%',
            ),
            'stale' => array(
                'raw' => round($this->_summary['Difficulty Stale']),
                'percent' => round(($this->_summary['Difficulty Stale']/$totalShares)*100, 2) . '%',
            ),
            'hw_errors' => array(
                'raw' => $this->_summary['Hardware Errors'],
                'percent' => round($hePercent,3) . '%',
            ),
            'work_utility' => $this->_summary['Work Utility'] . '/m',
        );
    }

    public function devices() {
        $devices = array();

        foreach ($this->_devs as $devKey => $dev) {
            $totalShares = $dev['Difficulty Accepted'] + $dev['Difficulty Rejected'];

            if (!isset($dev['Device Hardware%'])) {
                $hePercent = $this->calculateHwPercent($dev['Hardware Errors'], $dev['Difficulty Accepted'], $dev['Difficulty Rejected']);
            } else {
                $hePercent = $dev['Device Hardware%'];
            }

            if (isset($dev['GPU'])) {
                $devices[] = array(
                    'id' => $dev['GPU'],
                    'type' => 'GPU',
                    'name' => 'GPU',
                    'status' => $this->_devStatus[$devKey],
                    'enabled' => $dev['Enabled'],
                    'health' => $dev['Status'],
                    'hashrate_avg' => $this->getFormattedHashrate($dev['MHS av']),
                    'hashrate_5s' => $this->getFormattedHashrate($dev['MHS 5s']),
                    'intensity' => $dev['Intensity'],
                    'temperature' => array(
                        'celsius' => $dev['Temperature'],
                        'fahrenheit' => ((($dev['Temperature']*9)/5)+32),
                    ),
                    'fan_speed' => array(
                        'raw' => $dev['Fan Speed'] . ' RPM',
                        'percent' => $dev['Fan Percent'],
                    ),
                    'engine_clock' => $dev['GPU Clock'],
                    'memory_clock' => $dev['Memory Clock'],
                    'gpu_voltage' => $dev['GPU Voltage'] . 'V',
                    'powertune' => $dev['Powertune'] . '%',
                    'accepted' => array(
                        'raw' => round($dev['Difficulty Accepted']),
                        'percent' => round(($dev['Difficulty Accepted']/$totalShares)*100, 2) . '%',
                    ),
                    'rejected' => array(
                        'raw' => round($dev['Difficulty Rejected']),
                        'percent' => round(($dev['Difficulty Rejected']/$totalShares)*100, 2) . '%',
                    ),
                    'hw_errors' => array(
                        'raw' => $dev['Hardware Errors'],
                        'percent' => round($hePercent,3) . '%',
                    ),
                    'utility' => $dev['Utility'] . '/m',
                );
            } else if (isset($dev['ASC']) || isset($dev['PGA'])) {
                $data = array(
                    'id' => (isset($dev['ASC']) ? $dev['ASC'] : $dev['PGA']),
                    'type' => (isset($dev['ASC']) ? 'ASC' : 'PGA'),
                    'name' => (isset($dev['ASC']) ? 'ASC' : 'PGA'),
                    'status' => $this->_devStatus[$devKey],
                    'enabled' => $dev['Enabled'],
                    'health' => $dev['Status'],
                    'hashrate_avg' => $this->getFormattedHashrate($dev['MHS av']),
                    'hashrate_5s' => $this->getFormattedHashrate($dev['MHS 5s']),
                    'temperature' => array(
                        'celsius' => $dev['Temperature'],
                        'fahrenheit' => ((($dev['Temperature']*9)/5)+32),
                    ),
                    'frequency' => (isset($dev['Frequency']) ? $dev['Frequency'] : null),
                    'accepted' => array(
                        'raw' => round($dev['Difficulty Accepted']),
                        'percent' => round(($dev['Difficulty Accepted']/$totalShares)*100, 2) . '%',
                    ),
                    'rejected' => array(
                        'raw' => round($dev['Difficulty Rejected']),
                        'percent' => round(($dev['Difficulty Rejected']/$totalShares)*100, 2) . '%',
                    ),
                    'hw_errors' => array(
                        'raw' => $dev['Hardware Errors'],
                        'percent' => round($hePercent,3) . '%',
                    ),
                    'utility' => $dev['Utility'] . '/m',
                );
                $data['name'] = (isset($dev['Name']) ? $dev['Name'] : $data['name']);
                $devices[] = $data;
            }
        }

        return $devices;
    }

    public function pools() {
        $pools = array();
        foreach ($this->_pools as $pool) {
            $pools[] = array(
                'id' => $pool['POOL'],
                'active' => ($pool['POOL'] == $this->_activePool['id']) ? 1 : 0,
                'url' => $pool['URL'],
                'user' => $pool['User'],
                'alive' => ($pool['Status'] == 'Alive') ? 1 : 0,
                'priority' => $pool['Priority'],
            );
        }

        return $pools;
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
            'panel' => 'panel-offline',
        );

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

    private function calculateHwPercent($hwErrors, $diffA, $diffR ) {
        return ($hwErrors / ($diffA + $diffR + $hwErrors)) * 100;
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
