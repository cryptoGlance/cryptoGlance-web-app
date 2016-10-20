<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Wallets_Peercoin extends Wallets_Abstract {

    public function __construct($label, $address) {
        parent::__construct($label, $address);
//        $this->_apiURL = 'http://blockchain.info/address/' . $address . '?format=json&limit=0';
        $this->_apiURL = 'http://ppc.blockr.io/api/v1/address/balance/' . $address;
        $this->_fileHandler = new FileHandler('wallets/peercoin/' . $this->_address . '.json');
    }
    
    public function update() {
        if ($GLOBALS['cached'] == false || $this->_fileHandler->lastTimeModified() >= 3600) { // updates every 60 minutes. How much are you being paid out that this must change? We take donations :)
            $walletData = curlCall($this->_apiURL);
            
            $data = array (
                'label' => $this->_label,
                'address' => $this->_address,
                // 'balance' => (float) $walletData['final_balance']/100000000 // for blockchain
                'balance' => (float) $walletData['data']['balance'] // for blockr.io
            );
            
            $this->_fileHandler->write(json_encode($data));
            return $data;
        }
        
        return json_decode($this->_fileHandler->read(), true);
    }

}
