<?php
require_once('abstract.php');
/*
* @author SM
*/
class Wallets_darkcoin extends Wallets_Abstract {

    public function __construct($label, $address) {
        parent::__construct($label, $address);
// $this->_apiURL = 'http://blockchain.info/address/' . $address . '?format=json&limit=0';
        $this->_apiURL = 'http://chainz.cryptoid.info/drk/api.dws?q=getbalance&a=' . $address;
        $this->_fileHandler = new FileHandler('wallets/darkcoin/' . $this->_address . '.json');
    }
    
    public function update() {
        if ($CACHED == false || $this->_fileHandler->lastTimeModified() >= 3600) { // updates every 60 minutes. How much are you being paid out that this must change? We take donations :)
            $curl = curl_init($this->_apiURL);
            curl_setopt($curl, CURLOPT_FAILONERROR, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; cryptoGlance ' . CURRENT_VERSION . '; PHP/' . phpversion() . ')');
            //$walletData = json_decode(curl_exec($curl), true);
            $walletBalance = curl_exec($curl);
			
			
            $data = array (
                'label' => $this->_label,
                'address' => $this->_address,
// 'balance' => (float) $walletData['final_balance']/100000000 // for blockchain
// 'balance' => (float) $walletData['data']['balance'] // for blockr.io
				'balance' => (float) $walletBalance // for cryptoid
            );
            
            $this->_fileHandler->write(json_encode($data));
            return $data;
        }
        
        return json_decode($this->_fileHandler->read(), true);
    }

}
