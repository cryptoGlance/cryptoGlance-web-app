<?php
require_once('abstract.php');
/**
 * Configuring pools
 *
 * @author Stoyvo
 */

class Config_Pools extends Config_Abstract {

    protected $_config = 'configs/pools.json';


    /*
     * Specific to class
     */

    protected function add($pool) {
    
        if (empty($pool['type'])) {
            return false;
        }

        $class = 'Pools_' . ucwords(strtolower($pool['type']));
        $obj = new $class($pool);
        $this->_objs[] = $obj;
    }

}
