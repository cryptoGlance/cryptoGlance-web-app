<?php

// Is this used anymore?

/*
 * @author Stoyvo
 */
class Update {

    public function all() {
        $data = array();
        $data['pools'] = $this->getPools();

        echo json_encode($data);
    }

    public function pool() {
        $data['pools'] = $this->getPools(intval($_GET['attr']));

        echo json_encode($data);
    }

    public function addConfig() {
        if (isset($_POST['type'])) {
            $action = 'add' . ucwords(strtolower($_POST['type']));
            require_once(dirname(__FILE__).'/../cryptoglance.php');
            $cryptoglance = new CryptoGlance();

            $cryptoglance->$action();
        }
    }

    public function editConfig() {
        if (isset($_POST['type'])) {
            $action = 'edit' . ucwords(strtolower($_POST['type']));
            require_once(dirname(__FILE__).'/../cryptoglance.php');
            $cryptoglance = new CryptoGlance();
            $cryptoglance->$action();
        }
    }

    public function removeConfig() {
        if (isset($_POST['type'])) {
            $action = 'remove' . ucwords(strtolower($_POST['type']));
            require_once(dirname(__FILE__).'/../cryptoglance.php');
            $cryptoglance = new CryptoGlance();
            $cryptoglance->$action();
        }
    }

    // Private
    private function getPools($poolId = null) {
        $pools = new Pools();
        $data = $pools->update($poolId);

        return $data;
    }

}
