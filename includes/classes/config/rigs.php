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

    // validate posted data for rig
    protected function postValidate($dataType, $data) {
        // TO-DO: Rethink this... Maybe some kind of validator class that returns true/false

        if ($dataType == 'details' &&
            (empty($data['ip_address']) || empty($data['port']))
        ) {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted
            return 'Missing ' . (empty($data['ip_address']) ? 'IP Address' : 'Port');
        } else if ($dataType == 'thresholds' && $data['temperatureEnabled'] == 'on' &&
            (empty($data['tempWarning']) || empty($data['tempDanger']))
        ) {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted
            return 'Temperature Warning and Danager values must be set!';
        } else if ($dataType == 'thresholds' && $data['hwErrorsEnabled'] == 'on' && empty($data['hwErrorsType'])) {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted
            return 'Hardware errors require a Percent or Integer display type!';
        } else if ($dataType == 'thresholds' && $data['hwErrorsEnabled'] == 'on' && $data['hwErrorsType'] == 'int' &&
            (empty($data['int']['hwWarning']) || empty($data['int']['hwDanger']))
        ) {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted
            return 'An integer value must be set!';
        } else if ($dataType == 'thresholds' && $data['hwErrorsEnabled'] == 'on' && $data['hwErrorsType'] == 'percent' &&
            (empty($data['percent']['hwWarning']) || empty($data['percent']['hwDanger']))
        ) {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted
            return 'An percent value must be set!';
        }

        return true;
    }
    protected function isUnique($dataType, $data) {
        if ($dataType == 'details') {
            foreach ($this->_data as $rig) {
                if ($data['ip_address'] == $rig['host'] && $data['port'] == $rig['port']) {
                    header("HTTP/1.0 409 Conflict"); // conflict
                    return 'This rig already exists as ' . (!empty($rig['name']) ? $rig['name'] : $rig['host'].':'.$rig['port']);
                }
            }
        }

        return true;
    }

    public function create() {
        $isValid = $this->postValidate(array('details' => $_POST));
        if ($isValid !== true) {
            return $isValid;
        }

        $isUnique = $this->isUnique(array('details' => $_POST));
        if ($isUnique !== true) {
            return $isUnique;
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

    public function update() {
        $id = intval($_GET['id'])-1;

        foreach ($_POST as $dataType => $data) {
            $name = 'update' . ucfirst($dataType);
            $this->$name($id, $dataType, $data);
        }
    }

    private function updateDetails($id, $dataType, $data) {
        $isValid = $this->postValidate($dataType, $data);
        if ($isValid !== true) {
            return $isValid;
        }

        $rig = array(
            'name' => (!empty($data['label']) ? $data['label'] : $data['ip_address']),
            'type' => 'cgminer',
            'host' => $data['ip_address'],
            'port' => $data['port'],
            'settings' => array(
                'algorithm' => $data['algorithm']
            ),
        );

        $this->_data[$id] = array_replace_recursive($this->_data[$id], $rig);

        $this->write();

        return true;
    }

    private function updateThresholds($id, $dataType, $data) {
        $isValid = $this->postValidate($dataType, $data);
        if ($isValid !== true) {
            return $isValid;
        }

        print_r($data);
        die('---');

        // $rig = array(
        //     'name' => (!empty($data['label']) ? $data['label'] : $data['ip_address']),
        //     'type' => 'cgminer',
        //     'host' => $data['ip_address'],
        //     'port' => $data['port'],
        //     'settings' => array(
        //         'algorithm' => $data['algorithm']
        //     ),
        // );
        //
        // $this->_data[$id] = array_replace_recursive($this->_data[$id], $rig);
        //
        // $this->write();

        return true;
    }

}
