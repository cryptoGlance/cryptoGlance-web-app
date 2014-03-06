<?php

/*
 * @author Stoyvo
 */
class Class_Wallets_Vertcoin extends Class_Wallets_Abstract {

    public function __construct($label, $address) {
        parent::__construct($label, $address);
        $this->_apiURL = 'http://explorer.vertcoin.org/chain/Vertcoin/q/addressbalance/' . $address;
        $this->_fileHandler = new Class_FileHandler('wallets/vertcoin/' . $this->_address . '.json');
    }
    
    public function update($cached) {

        if ($cached == false || $this->_fileHandler->lastTimeModified() >= 3600) { // updates every 60 minutes. How much are you being paid out that this must change? We take donations :)
            $curl = curl_init($this->_apiURL);
            curl_setopt($curl, CURLOPT_FAILONERROR, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; RigWatch ' . CURRENT_VERSION . '; PHP/' . phpversion() . ')');
            $addressBalance = curl_exec($curl);
            
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
