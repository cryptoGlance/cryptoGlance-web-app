<?php
require_once('classes/filehandler.php');
class CryptoGlance {

    private $_configTypes = array(
        'currency',
        'miners',
        'pools',
        'cryptoglance',
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
        
        if (empty($rigId) || $rigId == 0) {
            http_response_code(406); // not accepted
            return null;
        }
        $rigId = $rigId-1;
        
        unset($this->_config['miners'][$rigId]);
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
    // NOT DONE
        $label = $_POST['label'];
        $type = $_POST['poolType'];
        $ipAddress = $_POST['ip_address'];
        $port = intval($_POST['port']);
        
        if (empty($type) || empty($ipAddress) || empty($port)) {
            http_response_code(406); // not accepted
            return null;
        }
        
        foreach ($this->_config['pools'] as $rig) {
            if ($ipAddress == $rig['host'] && $port == $rig['port']) {
                http_response_code(409); // conflict
                return null;
            }
        }
        
        $pool = array(
        
        );
        
        $this->_config['pools'][] = $pool;
        $fh = $fileHandler = new Class_FileHandler('configs/pools.json');
        $fh->write(json_encode($this->_config['pools']));
        http_response_code(202); // accepted
    }
    public function removePool(){
        $poolId = intval($_POST['id']);
        
        if (empty($poolId) || $poolId == 0) {
            http_response_code(406); // not accepted
            return null;
        }
        $poolId = $poolId-1;
        
        unset($this->_config['pools'][$poolId]);
        $fh = $fileHandler = new Class_FileHandler('configs/pools.json');
        $fh->write(json_encode($this->_config['pools']));
        http_response_code(202); // accepted
    }
    
    
    //////////////
    // Wallets //
    /////////////
    public function getWallets() {
        return $this->_config['wallets'];
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