<?php
/**
 * Description of MobileMiner | http://www.mobileminerapp.com/
 *
 * The MobileMiner apps allow you to remotely monitor and control your Bitcoin, Litecoin, and other crypto-currency mining rigs.
 *
 * ---------------------------------------------------------------------------------------------------------------
 *
 * This class uses the MobileMiner API | http://www.mobileminerapp.com/#api
 *
 * @author Stoyvo
 */
class MobileMiner {

    // Settings
    protected $_username = '';
    protected $_appKey = '';

    // cryptoGlance Specific
    protected $_apiKey = 'ozhjiY941gooFo';

    // API Specific
    protected $_url = 'https://api.mobileminerapp.com/';
    protected $_urlParams = '';

    // Rig Data
    protected $_rigs = array();

    public function __construct() {
        $this->_username = $GLOBALS['settings']['general']['mobileminer']['username'];
        $this->_appKey = $GLOBALS['settings']['general']['mobileminer']['appkey'];
        $this->_urlParams = '?apiKey='.$this->_apiKey . '&emailAddress='.$this->_username . '&applicationKey='.$this->_appKey;
        $this->_rigs = new Rigs();
    }

    // The app will simply update all the device data to the mobileminer api
    public function getUpdate() {
        // Do nothing if it's not enabled
        if (!$GLOBALS['settings']['general']['mobileminer']['enabled']) {
            return;
        }

        // Listen for response from server
        $this->_listen();

        // Post Pools
        $this->_postPools();

        // Post Stats
        $this->_postStatistics();

        return;
    }

    protected function _listen() {
        // call server for any changes
        foreach ($this->_rigs->getSettings() as $rigId => $rig) {
            $data = curlCall($this->_url . 'RemoteCommands' . $this->_urlParams . '&machineName=' . urlencode($rig['name']));
            if (!empty($data) && !empty($data[0])) {
                $command = explode('|', $data[0]['CommandText']);
                $value = null;
                if (is_array($command)) {
                    $value = $command[1];
                    $command = $command[0];
                }
                switch ($command) {
                    case 'SWITCH':
                        $poolId = $this->_findPoolIdFromName($this->_rigs->_objs[$rigId]->pools(), $value);
                        if (!is_null($poolId)) {
                            $this->_rigs->_objs[$rigId]->switchPool($poolId);
                        }
                        break;
                    case 'RESTART':
                        $this->_rigs->_objs[$rigId]->restart();
                        break;
                    case 'START':
                        $this->_rigs->_objs[$rigId]->enablePools();
                        break;
                    case 'STOP':
                        $this->_rigs->_objs[$rigId]->disablePools();
                        break;
                }
                curlCall(
                    $this->_url .'RemoteCommands'. $this->_urlParams .'&machineName='. urlencode($rig['name']) .'&commandId='. $data[0]['Id'],
                    null,
                    'application/json',
                    array('custom_request' => 'DELETE')
                );
            }
        }
    }

    protected function _postStatistics() {
        $cryptoglance = new CryptoGlance();
        $algorithms = $cryptoglance->supportedAlgorithms();

        // build out machine statistics
        $postData = array();
        foreach ($this->_rigs->getUpdate() as $rigId => $rig) {
            // Each device needs to be posted as a whole different machine.
            foreach ($rig['devs'] as $devId => $dev) {
                $rigData = array();
                $rigData['MachineName'] = $rig['overview']['name'];
                $rigData['MinerName'] = 'CryptoGlance';
                $rigData['CoinSymbol'] = '';
                $rigData['CoinName'] = '';
                $rigData['Algorithm'] = $algorithms[$rig['overview']['algorithm']];

                // Device Specific
                $rigData['Kind'] = $dev['type'];
                $rigData['Name'] = $dev['name'];
                $rigData['FullName'] = $dev['name'] . ' ' . $dev['id'];
                $rigData['PoolIndex'] = $rig['summary']['active_pool']['id'];
                $rigData['PoolName'] = $rig['summary']['active_pool']['url'];
                $rigData['Index'] = $devId;
                $rigData['DeviceID'] = $dev['id'];
                $rigData['Enabled'] = ($dev['enabled'] == 'Y') ? 'true':'false';
                $rigData['Status'] = $dev['health'];
                $rigData['Temperature'] = $dev['temperature']['celsius'];

                // GPU STUFF
                $rigData['FanSpeed'] = $dev['fan_speed']['raw'];
                $rigData['FanPercent'] = $dev['fan_speed']['percent'];
                $rigData['GpuClock'] = $dev['engine_clock'];
                $rigData['MemoryClock'] = $dev['memory_clock'];
                $rigData['GpuVoltage'] = $dev['gpu_voltage'];
                $rigData['GpuActivity'] = 0;
                $rigData['PowerTune'] = $dev['powertune'];
                // END GPU STUFF

                $rigData['AverageHashrate'] = $dev['hashrate_avg']*1000;
                $rigData['CurrentHashrate'] = $dev['hashrate_5s']*1000;
                $rigData['AcceptedShares'] = $dev['accepted']['raw'];
                $rigData['RejectedShares'] = $dev['rejected']['raw'];
                $rigData['HardwareErrors'] = $dev['hw_errors']['raw'];
                $rigData['Utility'] = $dev['utility'];
                $rigData['Intensity'] = null;
                // $rigData['AcceptedSharesPercent'] = $dev['accepted']['percent'];
                $rigData['RejectedSharesPercent'] = $dev['rejected']['percent'];
                $rigData['HardwareErrorsPercent'] = $dev['hw_errors']['percent'];
                $postData[] = $rigData;
                unset($rigData);
            }

        }

        $url = $this->_url . 'MiningStatisticsInput' . $this->_urlParams;
        curlCall($url, json_encode($postData));
    }

    protected function _postPools() {
        // Post all the pools for each machine
        foreach ($this->_rigs->getSettings() as $rigId => $rig) {
            $url = $this->_url . 'PoolsInput' . $this->_urlParams . '&machineName=' . urlencode($rig['name']);

            $pools = $this->_rigs->_objs[$rigId]->pools();
            $poolData = array();
            foreach ($pools as $pool) {
                $poolData[] = substr($pool['url'], strpos($pool['url'], '//') + 2);
            }
            curlCall($url, json_encode($poolData));
        }
    }

    protected function _postNotifications() {
        // If anything serious has happened, post notifications to the API
    }

    protected function _findPoolIdFromName($pools, $name) {
        $poolId = null;
        foreach ($pools as $pool) {
            if (strpos($pool['url'], $name) !== false) {
                return $pool['id'];
            }
        }
        return $poolId;
    }

}
