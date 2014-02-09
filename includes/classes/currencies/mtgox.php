<?php

/*
 * @author Stoyvo
 */
class Class_Currency_Mtgox {

    // Exchange Information
    protected $_apiURL = 'https://data.mtgox.com/api/2/';
    protected $_apiKey;
    protected $_apiSecret;

    public function __construct($apiKey, $apiSecret) {
        $this->_apiKey = $apiKey;
        $this->_apiSecret = $apiSecret;
    }

    public function update($pair) {
        $fileHandler = new Class_FileHandler(
                'currency/' . sha1($this->_apiURL . '.' . $this->_apiKey) . '/' . $pair . '.json'
        );

        if ($fileHandler->lastTimeModified() >= 30) { // 30 = seconds...
            $url = $this->_apiURL
                    . strtoupper($pair)
                    . '/money/ticker';
            $curl = curl_init($url);
            
            // Parts of this were taken from https://github.com/pathaksa/MtGox-PHP-API-V2
            // Thank you Pathaksa!
            
            // generate a nonce as micro-time, with as-string handling to avoid problems with 32bits systems
            $mt = explode(' ', microtime());
            $request['nonce'] = $mt[1] . substr($mt[0], 2, 6);
    
            // generate Rest Signature
            $restSign = base64_encode(
                hash_hmac(
                    'sha512',
                    strtoupper($pair). '/money/ticker',
                    base64_decode($this->_apiSecret),
                    true
                )
            );
    
            // generate the extra headers
            $headers = array(
                'Rest-Key: ' . $this->_apiKey,
                'Rest-Sign: ' . $restSign,
                'Content-type', 'application/x-www-form-urlencoded',
                'Content-Length', 0
            );
            
            curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
            curl_setopt($curl, CURLOPT_FAILONERROR, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; RigWatch ' . CURRENT_VERSION . '; PHP/' .
                phpversion() . ')');
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            
            $fileHandler->write(curl_exec($curl));
        }
        
        return $fileHandler->read();
    }

}
