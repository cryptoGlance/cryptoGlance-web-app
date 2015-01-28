<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Wallets_Darkcoin extends Wallets_Abstract {

    public function __construct($label, $address) {
        parent::__construct($label, $address);
        $this->_apiURL = 'http://explorer.darkcoin.io/chain/Darkcoin/q/addressbalance/' . $address;
        $this->_fileHandler = new FileHandler('wallets/darkcoin/' . $this->_address . '.json');
    }

    public function update() {
        if ($GLOBALS['cached'] == false || $this->_fileHandler->lastTimeModified() >= 3600) {
            // updates every 60 minutes. How much are you being paid out that this must change? We take donations :)
            $walletBalance = curlCall($this->_apiURL);

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
