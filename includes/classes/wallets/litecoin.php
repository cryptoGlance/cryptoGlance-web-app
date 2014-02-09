<?php

/*
 * @author Stoyvo
 */
class Class_Wallets_Litecoin extends Class_Wallets_Abstract {

    protected $_apiURL;

    public function __construct($label, $address) {
        parent::__construct($label, $address);
        $this->_apiURL = 'http://ltc.blockr.io/api/v1/address/balance/' . $address;
    }
    
    public function update($cached) {
        $fileHandler = new Class_FileHandler(
                'wallets/litecoin/' . sha1($this->_address) . '.json'
        );

        if ($cached == false || $fileHandler->lastTimeModified() >= 1800) { // updates every 30 minutes. How much are you being paid out that this must change? We take donations :)
            $curl = curl_init($this->_apiURL);
            curl_setopt($curl, CURLOPT_FAILONERROR, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; RigWatch ' . CURRENT_VERSION . '; PHP/' . phpversion() . ')');
            $walletData = json_decode(curl_exec($curl), true);
            
            $data = array (
                'currency' => 'litecoin',
                'currency_code' => 'LTC',
                'label' => $this->_label,
                'address' => $this->_address,
                'balance' => (float) $walletData['data']['balance']
            );
            
            $fileHandler->write(json_encode($data));
        }
        
        return json_decode($fileHandler->read());
    }

}
