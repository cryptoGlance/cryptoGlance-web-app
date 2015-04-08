<?php

/*
 * @author Stoyvo
 */
class Config_Abstract {

    // Data
    protected $_fileHandler;
    protected $_data;

    // Objects
    private $_objs;

    public function __construct() {
        $this->_fileHandler = new FileHandler($this->_config);
        $this->_data = json_decode($this->_fileHandler->read(), true);

        if (isset($_GET['id']) || isset($_POST['id'])) {
            $id = (isset($_GET['id']) ? $_GET['id'] : $_POST['id']);
            $id = intval($id)-1;
            $this->add($this->_data[$id]);
        } else if (!empty($this->_data)) {
            foreach ($this->_data as $id => $obj) {
                $this->add($obj);
            }
        }
    }

    public function remove() {
        // Remove functionality is only available one at a time
        if (!isset($_POST['id'])) {
            header("HTTP/1.0 406 Not Acceptable");
            return false;
        }

        $id = intval($_POST['id'])-1;

        unset($this->_data[$id]);
        $this->_data = array_values($this->_data);

        return $this->write();
    }

    public function write() {
        $this->_fileHandler->write(json_encode($this->_data));

        header("HTTP/1.0 202 Accepted");
        return true;
    }

}
