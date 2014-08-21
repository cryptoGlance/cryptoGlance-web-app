<?php

/**
 * Description of rigs
 *
 * @author Stoyvo
 */

class Rigs extends Config_Rigs {

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


    /*
     * POST
     */

    public function restart() {
        $this->_objs[0]->restart();
    }

    public function switchPool() {
        return $this->_objs[0]->switchPool(intval($_POST['pool'])-1);
    }
    public function resetStats() {
        $this->_objs[0]->resetStats();
    }


    /*
     * GET
     */

    public function getPools() {
        $data = array();
        foreach ($this->_objs as $rig) {
            $data[] = $rig->pools();
        }

        return $data;
    }

    public function getDevices() {
        $data = array();
        foreach ($this->_objs as $rig) {
            $data[] = $rig->devices();
        }

        return $data;
    }

    public function getSettings() {
        $data = array();
        foreach ($this->_objs as $rig) {
            $data[] = $rig->getSettings();
        }

        return $data;
    }

    // Get Overview of Rigs
    public function getOverview() {
        $data = array();
        foreach ($this->_objs as $rig) {
            $data[] = $rig->overview();
        }

        return array('overview' => $data);
    }

    public function getUpdate() {
        foreach ($this->_objs as $rig) {
            $data = $rig->update();
        }

        return $data;
    }

}
