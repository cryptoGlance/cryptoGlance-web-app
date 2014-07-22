<?php

/*
 * @author Stoyvo
 */
class Config_Abstract {

    protected $_objs;
    
    public function __construct() {
        $fh = new FileHandler($this->_config);
        $objs = json_decode($fh->read(), true);

        if (isset($_GET['id']) || isset($_POST['id'])) {
            $id = ($_GET['id']) ? $_GET['id'] : $_POST['id'];
            $id = intval($id)-1;
            $this->add($objs[$id]);
        } else if (!empty($objs)) {
            foreach ($objs as $id => $obj) {
                $this->add($obj);
            }
        }
    }
    
}