<?php

/**
 * Description of rigs
 *
 * @author Timothy.Stoyanovski
 */

class Rigs {

    protected $_rigs = array();

    public function __construct() {
        $fh = new FileHandler('configs/miners.json');
        $rigs = json_decode($fh->read(), true);

        if (isset($_GET['id']) || isset($_POST['id'])) {
            $rigId = ($_GET['id']) ? $_GET['id'] : $_POST['id'];
            $rigId = intval($rigId)-1;
            $this->addRig($rigs[$rigId]);
        } else if (!empty($rigs)) {
            foreach ($rigs as $rigId => $rig) {
                $this->addRig($rig);
            }
        }
    }
    
    /*
     * Specific to class
     */

    private function addRig($rig) {

        if (empty($rig['type']) || empty($rig['host']) || empty($rig['port'])) {
            return false;
        }

        $name = (!empty($rig['name']) ? $rig['name'] : $rig['host']);
        if (empty($rig['settings'])) {
            $rig['settings'] = array();
        }

        $class = 'Miners_' . ucwords(strtolower($rig['type']));
        $obj = new $class($rig);
        $this->_rigs[] = $obj;
    }

    
    /*
     * POST
     */
         
    public function restart() {
        $this->_rigs[0]->restart();
    }
    
    /*
     * GET
     */

    public function getPools() {
        $data = array();
        foreach ($this->_rigs as $rig) {
            $data[] = $rig->pools();
        }

        return $data;
    }

    public function getDevices() {
        $data = array();
        foreach ($this->_rigs as $rig) {
            $data[] = $rig->devices();
        }

        return $data;
    }

    public function getSettings() {
        $data = array();
        foreach ($this->_rigs as $rig) {
            $data[] = $rig->getSettings();
        }

        return $data;
    }

    // Get Overview of Rigs
    public function getOverview() {
        $data = array();
        foreach ($this->_rigs as $rig) {
            $data[] = $rig->overview();
        }

        return array('overview' => $data);
    }

    public function getUpdate() {
        // $data = array();
        // $data;
        foreach ($this->_rigs as $rig) {
            // $data[] = $rig->update();
            $data = $rig->update();
        }

        return $data;
    }

}