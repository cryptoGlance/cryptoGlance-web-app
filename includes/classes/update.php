<?php
/*
 * @author Stoyvo
 */
class Class_Update {

    public function all() {
        $data = array();
//        $data[] = $this->pools();
        $data['rigs'] = $this->getMiners();
//        $data[] = $this->currencies();
        $data['wallets'] = $this->getWallets();

        echo json_encode($data);
    }
    
    public function miner() {
        // Handling the notice PHP spits out.
        $id = null;
        if (isset($_GET['attr'])) {
            $id = intval($_GET['attr']);
        }
        
        $data['rigs'] = $this->getMiners($id);
        
        echo json_encode($data);
    }
    
    public function wallet() {
        $cached = null;
        if (isset($_GET['attr'])) {
            $cached = ($_GET['attr'] == 'false') ? false : true;
        }
        
        $data['wallets'] = $this->getWallets($cached);
        
        echo json_encode($data);
    }

    // Private
    private function getPools() {
        $pools = new Class_Pools();
        $data = array('pools' => $pools->update());
        
        return $data;
    }

    private function getMiners($minerId = null) {
        $miners = new Class_Miners();
        $data = $miners->update($minerId);

        return $data;
    }

    private function getCurrencies() {
        $currencies = new Class_Currency();
        $data = array('currencies' => $currencies->update());

        return $data;
    }
    
    private function getWallets($cached = true) {
        $wallets = new Class_Wallets();
        $data = $wallets->update($cached);
        
        return $data;
    }

}
