<?php

/*
 * @author Stoyvo
 */
class Wallets_Abstract {
    
    protected $_apiURL;
    protected $_label;
    protected $_address;
    protected $_fileHandler;
        
    public function __construct($label, $address) {
        $this->_label = $label;
        $this->_address = $address;
    }
    
    protected function apiCall($url) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; cryptoGlance ' . CURRENT_VERSION . '; PHP/' . phpversion() . ')');
        
        return json_decode(curl_exec($curl), true);
    }
}
?>