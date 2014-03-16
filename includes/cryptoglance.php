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
    
    private $_configs;

    public function __construct() {
        foreach ($this->_configTypes as $configType) {
            $fh = $fileHandler = new Class_FileHandler('configs/' . $configType . '.json');
            $this->_configs[$configType] = json_decode($fh->read(), true);
        }
    }
    
    public function getMiners() {
        return $this->_configs['miners'];
    }    
    public function getPools() {
        return $this->_configs['pools'];
    }
    
    public function getWallets() {
        return $this->_configs['wallets'];
    }
    
    public function getSettings() {
        return $this->_configs['cryptoglance'];
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
        
        }
        
        $this->_configs['cryptoglance'] = $settings;
        
        $fh->write(json_encode($settings));
    }

}
?>