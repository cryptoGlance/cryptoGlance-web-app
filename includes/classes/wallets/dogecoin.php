<?php

/*
 * @author Stoyvo
 */
class Wallets_Dogecoin extends Wallets_Abstract {

    public function __construct($label, $address) {
        parent::__construct($label, $address);
        $this->_apiURL = 'http://dogechain.info/chain/Dogecoin/q/addressbalance/' . $address;
        $this->_fileHandler = new FileHandler('wallets/dogecoin/' . $this->_address . '.json');
    }
    
    public function update() {
        if ($CACHED == false || $this->_fileHandler->lastTimeModified() >= 3600) { // updates every 60 minutes. How much are you being paid out that this must change? We take donations :)
            $curl = curl_init($this->_apiURL);
            curl_setopt($curl, CURLOPT_FAILONERROR, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; RigWatch ' . CURRENT_VERSION . '; PHP/' . phpversion() . ')');
            $walletBalance = curl_exec($curl); // this comes back as a single value (total doge in the wallet)
            
            $data = array (
                'label' => $this->_label,
                'address' => $this->_address,
                'balance' => (float) $walletBalance
            );
            
            $this->_fileHandler->write(json_encode($data));
            return $data;
        }
        
        return json_decode($this->_fileHandler->read(), true);
    }

}
