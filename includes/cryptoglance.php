<?php
require_once('classes/filehandler.php');
class CryptoGlance {

    private $_configTypes = array(
        'cryptoglance',
        'miners',
        'panels',
        'pools',
        'poolpicker',
        'wallets',
    	'panel',
    	'messages',
    );

    private $_algorithms = array(
        'BLAKE256'  =>  'Blake-256',
        'FRESH'     =>  'Fresh',
        'FUGUE'     =>  'Fugue-256',
        'GROESTL'   =>  'Groestl',
        'JHA'       =>  'Jackpot',
        'KECCAK'    =>  'Keccak',
        'LYRA2RE'   =>  'Lyra2RE',
        'NEOSBLAKE' =>  'Neos-Blake',
        'NEOSCRYPT' =>  'NeoScrypt',
        'NIST'      =>  'Nist5',
        'QUARK'     =>  'Quark',
        'SCRYPT'    =>  'Scrypt',
        'NSCRYPT'   =>  'Scrypt-N',
        'SHA256'    =>  'SHA-256',
        'TWE'       =>  'Twecoin',
        'UNK'       =>  'Unknown',
        'WHIRL'     =>  'WHIRL',
        'X11'       =>  'X11',
        'X13'       =>  'X13',
        'X14'       =>  'X14',
        'X15'       =>  'X15',
        'X17'       =>  'X17',
    );

    private $_config;

    public function __construct() {
        foreach ($this->_configTypes as $configType) {
            $fh = $fileHandler = new FileHandler('configs/' . $configType . '.json');
            $this->_config[$configType] = json_decode($fh->read(), true);
        }
    }

    public function supportedAlgorithms($reversed = false) {
        if ($reversed) {
            return array_flip($this->_algorithms);
        }
        return $this->_algorithms;
    }

    public function isConfigAvailable($panel) {
        return $this->_config[$panel];
    }

    ///////////
    // Panels //
    ///////////
    public function getPanels() {
        $panels = $this->_config;
        unset($panels['cryptoglance']);

        return $panels;
    }
    public function isNoPanels() {
        foreach ($this->getPanels() as $panel) {
            if ($panel) {
                return false;
            }
        }
        return true;
    }

    //////////
    // Rigs //
    //////////
    public function getOverview() {
        return $this->_config['panels']['overview'];
    }
    public function getMiners() {
        return $this->_config['miners'];
    }

    ///////////
    // Pools //
    ///////////
    public function getPools() {
        return $this->_config['pools'];
    }

    public function getMessages(){
    	return $this->_config['messages'];
    }
    
    private $panel = null;
    public function getPanel(){
    	if ($this->panel === null){
    		require_once('includes/autoloader.inc.php');
    		$this->panel = new Panel();
    	}
    	return $this->panel;
    }
    
    ////////////////
    // PoolPicker //
    ////////////////
    public function getPoolPicker() {
        $config = array();
        $config['data'] = $this->_config['poolpicker'];
        $config['panel'] = $this->_config['panels']['pool-picker'];

        return $config;
    }

    //////////////
    // Wallets //
    /////////////
    public function getWallets() {
        $config = array();
        $config['data'] = $this->_config['wallets'];
        $config['panel'] = $this->_config['panels']['wallets'];

        return $config;
    }


    ///////////////
    // Settings //
    //////////////
    public function getSettings() {
        $settings = $this->_config['cryptoglance'];

        if (empty($settings['general']['updates']['enabled']) && $settings['general']['updates']['enabled'] != 0) {
            $settings['general']['updates']['enabled'] = 1;
        }
        if (empty($settings['general']['updates']['type'])) {
            $settings['general']['updates']['type'] = 'release';
        }
        if (empty($settings['general']['updateTimes']['rig'])) {
            $settings['general']['updateTimes']['rig'] = 3000;
        }
        if (empty($settings['general']['updateTimes']['message'])) {
            $settings['general']['updateTimes']['message'] = 600000;
        }
        if (!empty($settings['general']['updateTimes']['rig_delay'])) {
            define('RIG_UPDATE_DELAY', intval($settings['general']['updateTimes']['rig_delay']));
        } else {
            define('RIG_UPDATE_DELAY', 2);
        }
        if (empty($settings['general']['updateTimes']['pool'])) {
            $settings['general']['updateTimes']['pool'] = 120000;
        }
        if (empty($settings['general']['updateTimes']['wallet'])) {
            $settings['general']['updateTimes']['wallet'] = 600000;
        }
        // if (empty($settings['general']['mobileminer']['enabled'])) {
        //     $settings['general']['mobileminer']['enabled'] = 0;
        // }
        // if (empty($settings['general']['mobileminer']['username'])) {
        //     $settings['general']['mobileminer']['username'] = '';
        // }
        // if (empty($settings['general']['mobileminer']['apikey'])) {
        //     $settings['general']['mobileminer']['apikey'] = '';
        // }

        return $settings;
    }

    public function saveSettings($data) {
        $fh = $fileHandler = new FileHandler('configs/cryptoglance.json');
        $settings = json_decode($fh->read(), true);

        if ($data['general']) {
            $settings['general'] = array(
                'updates' => array(
                    'enabled' => $data['general']['update'],
                    'type' => $data['general']['updateType'],
                ),
                'updateTimes' => array(
                    'rig' => $data['general']['rigUpdateTime']*1000,
                    'rig_delay' => $data['general']['rigUpdateDelay'],
                    'pool' => $data['general']['poolUpdateTime']*1000,
                    'wallet' => $data['general']['walletUpdateTime']*1000,
                    'message' => $data['general']['messageUpdateTime']*1000,
                ),
                // 'mobileminer' => array(
                //     'enabled' => $data['general']['mobileminer'],
                //     'username' => $data['general']['mobileminerUsername'],
                //     'appkey' => $data['general']['mobileminerAppKey'],
                // ),
            );
        }

        $this->_config['cryptoglance'] = $settings;

        if ($fh->write(json_encode($settings)) !== false) {
            if (isset($_COOKIE['cryptoglance_version'])) {
                unset($_COOKIE['cryptoglance_version']);
                setcookie('cryptoglance_version', null, -1, '/');
            }

            return true;
        } else {
            return false;
        }
    }

}
?>
