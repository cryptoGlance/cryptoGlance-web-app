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
            $rigId = intval($_GET['id']);
            $this->addRig($rigs[$rigId]['type'], $rigs[$rigId]['host'], $rigs[$rigId]['port']);
        } else if (!empty($rigs)) {
            foreach ($rigs as $rigType => $rig) {
                $name = (!empty($rig['name']) ? $rig['name'] : $rig['host']);
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
    
    // Get Overview of all Rigs
    public function getOverview() {
        $data = array();
        foreach ($this->_rigs as $rig) {
            $data[] = $rig->overview();
        }
        
        return json_encode($data);
    }
    
}