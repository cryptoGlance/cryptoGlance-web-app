<?php

/**
 * Description of rigs
 *
 * @author Stoyvo
 */

class Rigs extends Config_Rigs {

    /*
     * POST
     */

    public function restart() {
        $this->_objs[0]->restart();
    }

    public function switchPool() {
        $result = $this->_objs[0]->switchPool(intval($_POST['pool'])-1);

        if ($_POST['reset']) {
            $this->_objs[0]->resetStats();
        }

        return $result;
    }

    public function addPool() {
        $poolValues = $_POST['values'];
        $result = $this->_objs[0]->addPool($poolValues);
        if (!empty($poolValues[3])) {
            $result = $this->_objs[0]->prioritizePools($poolValues[3], null);
        }

        return $result;
    }

    public function editPool() {
        $result = $this->_objs[0]->editPool($_POST['poolId'], $_POST['values']);

        return $result;
    }

    public function removePool() {
        $result = $this->_objs[0]->removePool($_POST['poolId']);

        return $result;
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
            $data[] = $rig->update();
        }

        if (count($data) > 1) {
            return $data;
        }

        return $data[0];
    }

}
