<?php
require_once('abstract.php');
/**
 * Configuring Messages
 *
 * @author Blonďák
 */

class Config_Messages extends Config_Abstract {

    // Settings
    protected $_config = 'configs/messages.json';

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
