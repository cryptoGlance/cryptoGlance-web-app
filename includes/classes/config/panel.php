<?php
require_once('abstract.php');
/**
 * Configuring PoolPicker
 *
 * @author Stoyvo
 */

class Config_Panel extends Config_Abstract {

    // Settings
    protected $_config = 'configs/panel.json';

    /*
     * Specific to class
     */

    public function getConfig() {
        return $this->_data;
    }

    public function remove() {
        return $this->_fileHandler->delete();
    }
    
    public function add($data) {
    }
    
}
