<?php
require_once('classes/filehandler.php');
class CryptoGlance {

    private $_configTypes = array(
        'cryptoglance',
        'miners',
        'pools',
//        'rss',
        'wallets',
    );
    
    private $_config;

    public function __construct() {
        foreach ($this->_configTypes as $configType) {
            $fh = $fileHandler = new FileHandler('configs/' . $configType . '.json');
            $this->_config[$configType] = json_decode($fh->read(), true);
        }
    }
    
    //////////
    // Rigs //
    //////////
    public function getMiners() {
        return $this->_config['miners'];
    }
    public function addRig() {
        $label = $_POST['label'];
//        $type = $_POST['minerType'];
        $ipAddress = $_POST['ip_address'];
        $port = intval($_POST['port']);
        
//        if (empty($type) || empty($ipAddress) || empty($port)) {
        if (empty($ipAddress) || empty($port)) {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted
            return null;
        }
        
        foreach ($this->_config['miners'] as $rig) {
            if ($ipAddress == $rig['host'] && $port == $rig['port']) {
                header("HTTP/1.0 409 Conflict"); // conflict
                return null;
            }
        }
        
        $rig = array(
            'name' => (!empty($label) ? $label : $ipAddress),
//            'type' => $type, // can be dynamic. cgminer will work for the majority
            'type' => 'cgminer',
            'host' => $ipAddress,
            'port' => $port,
        );
        
        $this->_config['miners'][] = $rig;
        $fh = $fileHandler = new FileHandler('configs/miners.json');
        $fh->write(json_encode($this->_config['miners']));
        header("HTTP/1.0 202 Accepted"); // accepted
    }
    public function removeRig(){
        $rigId = intval($_POST['id']);
        
        if ($rigId == 0 || empty($this->_config['miners'][$rigId-1])) {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted
            return null;
        }
        $rigId -= 1;
        
        unset($this->_config['miners'][$rigId]);
        $this->_config['miners'] = array_values($this->_config['miners']);
        $fh = $fileHandler = new FileHandler('configs/miners.json');
        $fh->write(json_encode($this->_config['miners']));
        header("HTTP/1.0 202 Accepted"); // accepted
    }
    
    ///////////
    // Pools //
    ///////////
    public function getPools() {
        return $this->_config['pools'];
    }
    public function addPool() {
        $label = $_POST['label'];
        $type = $_POST['poolType'];
        $url = rtrim($_POST['url'], '/');
        $address = $_POST['address'];
        $api = $_POST['api'];
        $userid = $_POST['userid'];
        
        $pool = array();
         if ($type == 'btcguild' && !empty($api)) {
            $pool = array(
                'type' => $type,
                'name' => ($label ? $label : 'BTC Guild'),
                'apikey' => $api,
            );
        } else if ($type == 'eclipse' && !empty($api)) {
            $pool = array(
                'type' => $type,
                'name' => ($label ? $label : 'Eclipse'),
                'apikey' => $api,
            );
        } else if ($type == 'mpos' && !empty($url) && !empty($api) && !empty($userid)) {
            $pool = array(
                'type' => $type,
                'name' => ($label ? $label : preg_replace('#^https?://#', '', $url)),
                'apiurl' => rtrim($url, '/'),
                'apikey' => $api,
                'userid' => $userid,
            );
        } else if ($type == 'simplecoin' && !empty($api) && !empty($url)) {
            $pool = array(
                'type' => $type,
                'name' => ($label ? $label : preg_replace('#^https?://#', '', $url)),
                'apiurl' => rtrim($url, '/'),
                'apikey' => $api,
            );
        } else if ($type == 'wafflepool' && !empty($address)) {
            $pool = array(
                'type' => $type,
                'name' => ($label ? $label : 'WafflePool'),
                'address' => $address,
            );
        } else if ($type == 'trademybit' && !empty($api)) {
            $pool = array(
                'type' => $type,
                'name' => ($label ? $label : 'TradeMyBit'),
                'apikey' => $api,
            );
          } else if ($type == 'multipoolus' && !empty($api)) {
            $pool = array(
                'type' => $type,
                'name' => ($label ? $label : 'MultiPool.us'),
                'apikey' => $api,
            );

        } else {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted
            return null;
        }
        
        $this->_config['pools'][] = $pool;
        $fh = $fileHandler = new FileHandler('configs/pools.json');
        $fh->write(json_encode($this->_config['pools']));
        header("HTTP/1.0 202 Accepted"); // accepted
    }
    public function removePool(){
        $poolId = intval($_POST['id']);
        
        if ($poolId == 0 || empty($this->_config['pools'][$poolId-1])) {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted
            return null;
        }
        $poolId -= 1;
        
        unset($this->_config['pools'][$poolId]);
        $this->_config['pools'] = array_values($this->_config['pools']);
        $fh = $fileHandler = new FileHandler('configs/pools.json');
        $fh->write(json_encode($this->_config['pools']));
        header("HTTP/1.0 202 Accepted"); // accepted
    }
    
    
    //////////////
    // Wallets //
    /////////////
    public function getCurrencies() {
        $wallet = new Wallets();
        return $wallet->getCurrencies();
    }
    public function getWallets() {
        return $this->_config['wallets'];
    }
    public function addWallet() {
        $walletId = intval($_POST['walletId']);
        $label = $_POST['label'];
        $currency = $_POST['currency'];
        
        if ($walletId != 0) {
            $walletId -= 1;
            if (empty($label)) {
                header("HTTP/1.0 406 Not Acceptable"); // not accepted
                return null;
            }
            $this->_config['wallets'][$walletId]['label'] = $label;
        } else {
            if (empty($label) || empty($currency)) { // new wallets need label and option from currency dropdown
                header("HTTP/1.0 406 Not Acceptable"); // not accepted
                return null;
            }
            $this->_config['wallets'][] = array(
                'currency' => $currency,
                'label' => $label,
                'addresses' => array()
            );        
        }
        
        $fh = $fileHandler = new FileHandler('configs/wallets.json');
        $fh->write(json_encode($this->_config['wallets']));
        header("HTTP/1.0 202 Accepted"); // accepted
        echo count($this->_config['wallets']);
    }
    public function removeWallet() {
        $walletId = intval($_POST['walletId']);
        
        if ($walletId == 0 || empty($this->_config['wallets'][$walletId-1])) {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted
            return null;
        }
        $walletId -= 1;
        
        unset($this->_config['wallets'][$walletId]);
        $this->_config['wallets'] = array_values($this->_config['wallets']);
        $fh = $fileHandler = new FileHandler('configs/wallets.json');
        $fh->write(json_encode($this->_config['wallets']));
        header("HTTP/1.0 202 Accepted"); // accepted
    }
    public function addAddress() {
        $walletId = intval($_POST['walletId']);
        $newLabel = $_POST['label'];
        $newAddress = $_POST['address'];
        
        if ($walletId == 0 || empty($this->_config['wallets'][$walletId-1]) || empty($newLabel) || empty($newAddress)) {
            hheader("HTTP/1.0 406 Not Acceptable"); // not accepted
            return null;
        }
        
        $walletId -= 1;
        
        foreach ($this->_config['wallets'][$walletId]['addresses'] as $address) {
            if ($newAddress == $address['address']) {
                header("HTTP/1.0 409 Conflict"); // not accepted
                return null;
            }
        }
        
        $this->_config['wallets'][$walletId]['addresses'][] = array(
            'label' => $newLabel,
            'address' => $newAddress,
        );            

        $fh = $fileHandler = new FileHandler('configs/wallets.json');
        $fh->write(json_encode($this->_config['wallets']));
        header("HTTP/1.0 202 Accepted"); // accepted
    }
    public function editAddress() {
        $walletId = intval($_POST['walletId']);
        $addrId = intval($_POST['addrId']);
        $newLabel = $_POST['label'];
        
        if ($walletId == 0 || $addrId == 0 || empty($this->_config['wallets'][$walletId-1]['addresses'][$addrId-1]) || empty($newLabel)) {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted
            return null;
        }

        $walletId -= 1;
        $addrId -= 1;
        
        $this->_config['wallets'][$walletId]['addresses'][$addrId]['label'] = $newLabel;

        $fh = $fileHandler = new FileHandler('configs/wallets.json');
        $fh->write(json_encode($this->_config['wallets']));
        header("HTTP/1.0 202 Accepted"); // accepted
    }
    public function removeAddress() {
        $walletId = intval($_POST['walletId']);
        $addrId = intval($_POST['addrId']);
        
        if ($walletId == 0 || empty($this->_config['wallets'][$walletId-1]) || $addrId == 0 || empty($this->_config['wallets'][$walletId-1]['addresses'][$addrId-1])) {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted
            return null;
        }
        $walletId -= 1;
        $addrId -= 1;
        
        unset($this->_config['wallets'][$walletId]['addresses'][$addrId]);
        $this->_config['wallets'][$walletId]['addresses'] = array_values($this->_config['wallets'][$walletId]['addresses']);
        $fh = $fileHandler = new FileHandler('configs/wallets.json');
        $fh->write(json_encode($this->_config['wallets']));
        header("HTTP/1.0 202 Accepted"); // accepted
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
        if (empty($settings['general']['temps']['warning'])) {
            $settings['general']['temps']['warning'] = 75;
        }
        if (empty($settings['general']['temps']['danger'])) {
            $settings['general']['temps']['danger'] = 85;
        }
        if (empty($settings['general']['hardwareErrors']['enabled'])) {
            $settings['general']['hardwareErrors']['enabled'] = 1;
        }
        if (empty($settings['general']['hardwareErrors']['warning'])) {
            $settings['general']['hardwareErrors']['warning'] = 5;
        }
        if (empty($settings['general']['hardwareErrors']['danger'])) {
            $settings['general']['hardwareErrors']['danger'] = 15;
        }
        if (empty($settings['general']['updateTimes']['rig'])) {
            $settings['general']['updateTimes']['rig'] = 3000;
        }
        if (empty($settings['general']['updateTimes']['pool'])) {
            $settings['general']['updateTimes']['pool'] = 120000;
        }
        if (empty($settings['general']['updateTimes']['wallet'])) {
            $settings['general']['updateTimes']['wallet'] = 600000;
        }

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
                'temps' => array(
                    'warning' => $data['general']['tempWarning'],
                    'danger' => $data['general']['tempDanger'],
                ),
                'hardwareErrors' => array(
                    'enabled' => $data['general']['hwErrorsEnabled'],
                    'warning' => $data['general']['hwWarning'],
                    'danger' => $data['general']['hwDanger'],
                ),
                'updateTimes' => array(
                    'rig' => $data['general']['rigUpdateTime']*1000,
                    'pool' => $data['general']['poolUpdateTime']*1000,
                    'wallet' => $data['general']['walletUpdateTime']*1000,
                )
            );
        }
        
        if ($data['email']) {
            // add logic eventually
        }
        
        $this->_config['cryptoglance'] = $settings;
        
        if ($fh->write(json_encode($settings)) !== false) {
            return true;
        } else {
            return false;
        }
    }

}
?>
