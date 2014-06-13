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
        
        if (isset($_GET['id'])) {
            $rigId = intval($_GET['id'])-1;
            $this->addRig($rigs[$rigId]['type'], $rigs[$rigId]['host'], $rigs[$rigId]['port']);
        } else if (!empty($rigs)) {
            foreach ($rigs as $rigId => $rig) {
                $name = (!empty($rig['name']) ? $rig['name'] : $rig['host']);
                if (empty($rig['settings'])) {
                    $rig['settings'] = array();
                }
                $this->addRig($rig['type'], $rig['host'], $rig['port'], $name, $rig['settings']);
            }
        }
    }

    private function addRig($type, $host, $port, $name, $settings) {
        if (empty($type) || empty($host) || empty($port)) {
            return false;
        }

        $class = 'Miners_' . ucwords(strtolower($type));
        $obj = new $class($host, $port, $name, $settings);
        $this->_rigs[] = $obj;
    }
    
    // Get Overview of Rigs
    public function getOverview() {
        $data = array();
        foreach ($this->_rigs as $rig) {
            $data[] = $rig->overview();
        }
        
        echo json_encode(array('overview' => $data));
    }
    
    public function getUpdate() {
        $data = array();
        foreach ($this->_rigs as $rig) {
            $data[] = $rig->update();
        }
        
        echo json_encode($data);
    }
    
}