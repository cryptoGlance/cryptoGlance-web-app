<?php

/**
 * Description of rigs
 *
 * @author Stoyvo
 */

class Rigs extends Config_Rigs {

    public function __construct() {
        parent::__construct();
        set_time_limit(count($this->_objs)*3); // Total Rigs * 3 seconds
    }

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
        $isValid = $this->postValidate('pools', $_POST['values']);
        if ($isValid !== true) {
            return $isValid;
        }

        $result = $this->_objs[0]->addPool($_POST['values']);
        return $result;
    }
    public function prioritizePool() {
        $result = $this->_objs[0]->prioritizePools($_POST['priority'], $_POST['poolId']);
        return $result;
    }
    public function editPool() {
        $isValid = $this->postValidate('pools', $_POST['values']);
        if ($isValid !== true) {
            return $isValid;
        }

        $result = $this->_objs[0]->editPool($_POST['poolId'], $_POST['values']);
        return $result;
    }
    public function removePool() {
        $result = $this->_objs[0]->removePool($_POST['poolId']);
        return $result;
    }
    public function changePoolStatus() {
        if ($_POST['active'] == 'true') {
            $result = $this->_objs[0]->enablePool($_POST['poolId']);
        } else {
            $result = $this->_objs[0]->disablePool($_POST['poolId']);
        }
        return $result;
    }

    public function changeDeviceStatus() {
        if ($_POST['enable'] == 'true') {
            $result = $this->_objs[0]->enableDevice(strtolower($_POST['devType']), $_POST['devId']);
        } else {
            $result = $this->_objs[0]->disableDevice(strtolower($_POST['devType']), $_POST['devId']);
        }
        return $result;
    }

    public function updateDevices() {
        if ($_POST['devices']) {
            return $this->_objs[0]->updateDevice($_POST['devices']);
        }
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
