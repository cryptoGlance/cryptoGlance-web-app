<?php
require_once('abstract.php');
/**
 * Configuring rigs
 *
 * @author Stoyvo
 */

class Config_Rigs extends Config_Abstract {

    protected $_config = 'configs/miners.json';
    
    
    /*
     * Specific to class
     */

    protected function add($rig) {

        if (empty($rig['type']) || empty($rig['host']) || empty($rig['port'])) {
            return false;
        }

        $name = (!empty($rig['name']) ? $rig['name'] : $rig['host']);
        if (empty($rig['settings'])) {
            $rig['settings'] = array();
        }

        $class = 'Miners_' . ucwords(strtolower($rig['type']));
        $obj = new $class($rig);
        $this->_objs[] = $obj;
    }
    
}