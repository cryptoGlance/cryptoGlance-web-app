<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Wallets_Burstcoin extends Wallets_Abstract {

    public function __construct($label, $address) {
        parent::__construct($label, $address);
        $this->_apiURL = 'http://api.burstcoin.eu/account/balance';
        $this->_fileHandler = new FileHandler('wallets/burstcoin/' . $this->_address . '.json');
    }

    public function update() {
        if ($GLOBALS['cached'] == false || $this->_fileHandler->lastTimeModified() >= 3600) { // updates every 60 minutes. How much are you being paid out that this must change? We take donations :)
            $data = curlCall($this->_apiURL, http_build_query(array('account' => $this->_address)), 'application/x-www-form-urlencoded');

            $data = array (
                'label' => $this->_label,
                'address' => $this->_address,
                'balance' => (float) $data['balanceNQT']/100000000
            );

            $this->_fileHandler->write(json_encode($data));
            return $data;
        }

        return json_decode($this->_fileHandler->read(), true);
    }

}
