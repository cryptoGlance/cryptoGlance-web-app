<?php
require_once('classes/filehandler.php');
class CryptoGlance {

    private $_configTypes = array(
        'cryptoglance',
        'miners',
        'pools',
        'wallets',
    );
    
    private $_config;

    public function __construct() {
        foreach ($this->_configTypes as $configType) {
            $fh = $fileHandler = new Class_FileHandler('configs/' . $configType . '.json');
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
            http_response_code(406); // not accepted
            return null;
        }
        
        foreach ($this->_config['miners'] as $rig) {
            if ($ipAddress == $rig['host'] && $port == $rig['port']) {
                http_response_code(409); // conflict
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
        $fh = $fileHandler = new Class_FileHandler('configs/miners.json');
        $fh->write(json_encode($this->_config['miners']));
        http_response_code(202); // accepted
    }
    public function removeRig(){
        $rigId = intval($_POST['id']);
        
        if ($rigId == 0 || empty($this->_config['miners'][$rigId-1])) {
            http_response_code(406); // not accepted
            return null;
        }
        $rigId -= 1;
        
        unset($this->_config['miners'][$rigId]);
        $this->_config['miners'] = array_values($this->_config['miners']);
        $fh = $fileHandler = new Class_FileHandler('configs/miners.json');
        $fh->write(json_encode($this->_config['miners']));
        http_response_code(202); // accepted
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
        if ($type == 'mpos' && !(empty($url) || empty($api) || empty($userid))) {
            $pool = array(
                'type' => 'mpos',
                'name' => ($label ? $label : preg_replace('#^https?://#', '', $url)),
                'apiurl' => $url,
                'apikey' => $api,
                'userid' => $userid,
            );
        } else if ($type == 'wafflepool' && !empty($address)) {
            $pool = array(
                'type' => 'wafflepool',
                'name' => ($label ? $label : 'WafflePool'),
                'address' => $address,
            );
        } else {
            http_response_code(406); // not accepted
            return null;
        }
        
        $this->_config['pools'][] = $pool;
        $fh = $fileHandler = new Class_FileHandler('configs/pools.json');
        $fh->write(json_encode($this->_config['pools']));
        http_response_code(202); // accepted
    }
    public function removePool(){
        $poolId = intval($_POST['id']);
        
        if ($poolId == 0 || empty($this->_config['pools'][$poolId-1])) {
            http_response_code(406); // not accepted
            return null;
        }
        $poolId -= 1;
        
        unset($this->_config['pools'][$poolId]);
        $this->_config['pools'] = array_values($this->_config['pools']);
        $fh = $fileHandler = new Class_FileHandler('configs/pools.json');
        $fh->write(json_encode($this->_config['pools']));
        http_response_code(202); // accepted
    }
    
    
    //////////////
    // Wallets //
    /////////////
    public function getCurrencies() {
        $wallet = new Class_Wallets();
        return $wallet->getCurrencies();
    }
    public function getWallets() {
        return $this->_config['wallets'];
    }
    public function addWallet() {
//        $label = $_POST['label'];
//        $type = $_POST['currency'];
    }
    public function removeWallet() {
    
    }
    public function addAddress() {
        $walletId = intval($_POST['walletId']);
        $addrId = intval($_POST['addrId']); // if addrID exist, edit address, not make new one
        $newLabel = $_POST['label'];
        $newAddress = $_POST['address'];
        
        if ($walletId == 0 || empty($this->_config['wallets'][$walletId-1])) {
            http_response_code(406); // not accepted
            return null;
        }
        $walletId -= 1;
        
        if ($addrId != 0) {
            // editing existing address
            $addrId -= 1;
            if (empty($this->_config['wallets'][$walletId]['addresses'][$addrId]) || empty($newLabel)) {
                http_response_code(406); // not accepted
                return null;
            }
            
            $this->_config['wallets'][$walletId]['addresses'][$addrId]['label'] = $newLabel;
        }  else {
            // adding new address
            if (empty($newLabel) || empty($newAddress)) {
                http_response_code(406); // not accepted
                return null;
            }
            
            $this->_config['wallets'][$walletId]['addresses'][] = array(
                'label' => $newLabel,
                'address' => $newAddress,
            );            
        }

        $fh = $fileHandler = new Class_FileHandler('configs/wallets.json');
        $fh->write(json_encode($this->_config['wallets']));
        http_response_code(202); // accepted
    }
    public function removeAddress() {
        $walletId = intval($_POST['walletId']);
        $addrId = intval($_POST['addrId']);
        
        if ($walletId == 0 || empty($this->_config['wallets'][$walletId-1]) || $addrId == 0 || empty($this->_config['wallets'][$walletId-1]['addresses'][$addrId-1])) {
            http_response_code(406); // not accepted
            return null;
        }
        $walletId -= 1;
        $addrId -= 1;
        
        unset($this->_config['wallets'][$walletId]['addresses'][$addrId]);
        $this->_config['wallets'][$walletId]['addresses'] = array_values($this->_config['wallets'][$walletId]['addresses']);
        $fh = $fileHandler = new Class_FileHandler('configs/wallets.json');
        $fh->write(json_encode($this->_config['wallets']));
        http_response_code(202); // accepted
    }
    
    
    ///////////////
    // Settings //
    //////////////
    public function getSettings() {
        return $this->_config['cryptoglance'];
    }
    
    public function saveSettings($data) {
        $fh = $fileHandler = new Class_FileHandler('configs/cryptoglance.json');
        $settings = json_decode($fh->read(), true);
        
        if ($data['general']) {
            $settings['general'] = array(
                'temps' => array(
                    'warning' => $data['general']['tempWarning'],
                    'danger' => $data['general']['tempDanger'],
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
        
        $fh->write(json_encode($settings));
    }

}
?>