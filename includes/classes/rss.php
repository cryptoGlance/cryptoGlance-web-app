<?php

/**
 * Description of rss feeds
 *
 * @author Stoyvo
 */

class Rss extends Config_Rss {

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

    
    /*
     * POST
     */
         
    public function addFeed() {
        //$this->_rigs[0]->restart();
    }
    
    /*
     * GET
     */

    public function getFeeds() {
//        $data = array();
//        foreach ($this->_rigs as $rig) {
//            $data[] = $rig->pools();
//        }
//
//        return $data;
    }

}