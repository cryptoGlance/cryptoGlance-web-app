<?php

/**
 * TO-DO:
 * - Ability to pull single pool by ID
 * - Ability to pull all pools
 */
/**
 * Description of pools
 *
 * @author Timothy.Stoyanovski
 */

class Class_Pools {

    protected $_pools = array();

    public function __construct() {
        $fh = new Class_FileHandler('configs/pools.json');
        $pools = json_decode($fh->read());

        if (!empty($pools)) {
            foreach ($pools as $poolType => $pool) {
                $this->addPool($poolType, $pool[0]->apiKey, $pool[0]->apiURL);
            }
        }
    }

    private function addPool($type, $apiKey, $apiURL) {
        if (empty($type) || empty($apiKey) || empty($apiURL)) {
            return false;
        }

        $class = 'Class_Pools_' . ucwords(strtolower($type));
        $obj = new $class($apiKey, $apiURL);
        $this->_pools[] = $obj;
    }

    public function getData() {
        // Requires param for type of data:
        foreach ($this->_pools as $pool) {
            $pool->$_GET['funct']();
        }
    }

    public function update() {

        foreach ($this->_pools as $pool) {
            $pool->update();
        }
    }

}
