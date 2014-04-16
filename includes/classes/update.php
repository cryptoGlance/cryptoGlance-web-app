<?php
/*
 * @author Stoyvo
 */
class Update {

    public function all() {
        $data = array();
        $data['rigs'] = $this->getRigs();
        $data['pools'] = $this->getPools();
        $data['wallets'] = $this->getWallets();

        echo json_encode($data);
    }
    
    public function rig() {
        $data['rigs'] = $this->getRigs(intval($_GET['attr']));
        
        echo json_encode($data);
    }
    
    public function pool() {
        $data['pools'] = $this->getPools(intval($_GET['attr']));
        
        echo json_encode($data);
    }
    
    public function wallet() {
        $data['wallets'] = $this->getWallets(intval($_GET['attr']));
        
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

    private function getRigs($rigId = null) {
        $rigs = new Miners(); // Miners actually means Rigs
        $data = $rigs->update($rigId);

        return $data;
    }
    
    private function getWallets($walletId = null) {
        $wallets = new Wallets();
        $data = $wallets->update($walletId);
        
        return $data;
    }

}
