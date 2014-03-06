<?php
require_once('classes/filehandler.php');
class RigWatch {

    private $_configTypes = array(
        'currency',
        'miners',
        'pools',
        'rigwatch',
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

}
?>