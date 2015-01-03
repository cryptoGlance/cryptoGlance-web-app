<?php

/**
 * Description of pools
 *
 * @author Stoyvo
 */

class Pools extends Config_Pools {

    protected $_config = 'configs/pools.json';

    /*
     * POST
     */


    /*
     * GET
     */

    public function getUpdate($poolId = null) {
        $data = array();
        if (!empty($poolId) && $poolId != 0) {
            $poolId -= 1; // Arrays start at 0... 1 less than the ID on frontend
            if (!empty($this->_objs[$poolId])) {
                $data[] = $this->_objs[$poolId]->update();
            }
        } else {
            foreach ($this->_objs as $pool) {
                $data[] = $pool->update();
            }
        }

        return $data;
    }

}
