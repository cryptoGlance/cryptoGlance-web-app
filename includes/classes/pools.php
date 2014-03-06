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
        $pools = json_decode($fh->read(), true);
        
        if (!empty($pools)) {
            foreach ($pools as $pool) {
                $this->addPool($pool);
            }
        }
    }

    private function addPool($pool) {
        if (empty($pool['type']) || empty($pool['apiurl']) || empty($pool['apikey']) || empty($pool['userid'])) {
            return false;
        }

        $class = 'Class_Pools_' . ucwords(strtolower($pool['type']));
        $obj = new $class($pool);
        $this->_pools[] = $obj;
    }
    
    public function update($poolId = null) {
        if (!empty($poolId) && $poolId != 0) {
            $poolId -= 1; // Arrays start at 0... 1 less than the ID on frontend
            if (!empty($this->_pools[$poolId])) {
                $data[] = $this->_pools[$poolId]->update(false);
            }
        } else {        
            foreach ($this->_pools as $pool) {
                $data[] = $pool->update(true);
            }
        }
        
        return $data;
    }

}
