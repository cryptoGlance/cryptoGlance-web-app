<?php
/*
 * @author Stoyvo
 */
class Class_Update {

    public function all() {
        $data = array();
        $data['rigs'] = $this->getRigs();
        $data['pools'] = $this->getPools();
        $data['wallets'] = $this->getWallets();

        echo json_encode($data);
    }
    
    public function rig() {
        // Handling the notice PHP spits out.
        $id = null;
        if (isset($_GET['attr'])) {
            $id = intval($_GET['attr']);
        }
        
        $data['rigs'] = $this->getRigs($id);
        
        echo json_encode($data);
    }
    
    public function pool() {
        $id = null;
        if (isset($_GET['attr'])) {
            $id = intval($_GET['attr']);
        }
    
        $data['pools'] = $this->getPools($id);
        
        echo json_encode($data);
    }
    
    public function wallet() {
        $id = null;
        if (isset($_GET['attr'])) {
            $id = intval($_GET['attr']);
        }
        
        $data['wallets'] = $this->getWallets($id);
        
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
        $pools = new Class_Pools();
        $data = $pools->update($poolId);
        
        return $data;
    }

    private function getRigs($rigId = null) {
        $rigs = new Class_Miners(); // Rigs have Miners
        $data = $rigs->update($rigId);

        return $data;
    }
    
    private function getWallets($walletId = null) {
        $wallets = new Class_Wallets();
        $data = $wallets->update($walletId);
        
        return $data;
    }

}
