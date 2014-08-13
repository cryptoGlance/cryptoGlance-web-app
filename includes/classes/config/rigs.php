<?php
require_once('abstract.php');
/**
 * Configuring rigs
 *
 * @author Stoyvo
 */

class Config_Rigs extends Config_Abstract {

    protected $_config = 'configs/miners.json';


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

    public function create() {
        if (empty($_POST['ip_address']) || empty($_POST['port'])) {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted

            return 'Missing ' . (empty($_POST['ip_address']) ? 'IP Address' : 'Port');
        }

        foreach ($this->_data as $rig) {
            if ($_POST['ip_address'] == $rig['host'] && $_POST['port'] == $rig['port']) {
                header("HTTP/1.0 409 Conflict"); // conflict
                return 'This rig already exists as ' . (!empty($rig['name']) ? $rig['name'] : $rig['host'].':'.$rig['port']);
            }
        }

        $this->_data[] = array(
            'name' => (!empty($_POST['label']) ? $_POST['label'] : $_POST['ip_address']),
            'type' => 'cgminer',
            'host' => $_POST['ip_address'],
            'port' => $_POST['port'],
            'settings' => array(
                'algorithm' => $_POST['algorithm']
            ),
        );

        return $this->write();
    }

}
