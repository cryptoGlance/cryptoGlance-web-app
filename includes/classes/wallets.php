<?php
/**
 * Description of wallets
 *
 * @author Timothy.Stoyanovski
 */

class Class_Wallets {

    protected $_wallets = array();

    public function __construct() {
        $fh = new Class_FileHandler('configs/wallets.json');
        $wallets = json_decode($fh->read(), true);

        if (!empty($wallets)) {
            foreach ($wallets as $wallet) {
                $walletArray = $wallet;
                $this->addWallet($walletArray['currency'], $walletArray['label'], $walletArray['address']);
            }
        }
    }

    private function addWallet($currency, $label, $address) {
        if (empty($currency) || empty($address)) {
            return false;
        }

        $class = 'Class_Wallets_' . ucwords(strtolower($currency));
        $obj = new $class($label, $address);
        $this->_wallets[] = $obj;
    }

    public function getData() {
        // Requires param for type of data:
        foreach ($this->_wallets as $wallet) {
            $wallet->$_GET['funct']();
        }
    }
    
    public function update($cached) {
        $data = array();
        foreach ($this->_wallets as $wallet) {
            $data[] = $wallet->update($cached);
        }
        
        return $data;
    }

}
