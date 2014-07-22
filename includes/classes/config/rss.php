<?php
require_once('abstract.php');
/**
 * Configuring rss feeds
 *
 * @author Stoyvo
 */

class Config_Rss extends Config_Abstract {

    protected $_config = 'configs/rss-feeds.json';
    
    
    /*
     * Specific to class
     */
     
    protected function add($rss) {

//        if (empty($rig['type']) || empty($rig['host']) || empty($rig['port'])) {
//            return false;
//        }
//
//        $name = (!empty($rig['name']) ? $rig['name'] : $rig['host']);
//        if (empty($rig['settings'])) {
//            $rig['settings'] = array();
//        }
//
//        $class = 'Rss_' . ucwords(strtolower($rig['type']));
//        $obj = new $class($rig);
//        $this->_rigs[] = $obj;
    }

}