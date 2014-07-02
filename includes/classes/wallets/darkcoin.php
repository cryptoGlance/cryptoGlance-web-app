<?php
require_once('abstract.php');
/*
 * @author Arnaud Tanchoux - http://blog.tanchoux.fr
 */
class Wallets_Darkcoin extends Wallets_Abstract {

    public function __construct($label, $address) {
        parent::__construct($label, $address);
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
            $walletData = curl_exec($curl);

            $data = array (
                'label' => $this->_label,
                'address' => $this->_address,
                'balance' => (float) $walletData
            );

            $this->_fileHandler->write(json_encode($data));
            return $data;
        }

        return json_decode($this->_fileHandler->read(), true);
    }

}
