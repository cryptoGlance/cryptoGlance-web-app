<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Wallets_Reddcoin extends Wallets_Abstract {

    public function __construct($label, $address) {
        parent::__construct($label, $address);
        $this->_apiURL = 'http://cryptexplorer.com/chain/ReddCoin/q/addressbalance/' . $address;
        
        $this->_fileHandler = new FileHandler('wallets/reddcoin/' . $this->_address . '.json');
    }
    
    public function update() {
        if ($CACHED == false || $this->_fileHandler->lastTimeModified() >= 3600) { // updates every 60 minutes. How much are you being paid out that this must change? We take donations :)
            $addressBalance = $this->apiCall($this->_apiURL);
            
            $data = array (
                'label' => $this->_label,
                'address' => $this->_address,
                'balance' => (float) $addressBalance
            );
            
            $this->_fileHandler->write(json_encode($data));
            return $data;
        }
        
        return json_decode($this->_fileHandler->read(), true);
    }

}
