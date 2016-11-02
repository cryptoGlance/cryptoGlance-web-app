<?php
/*
 * @author Stoyvo
 */
class Wallets_Reddcoin extends Wallets_Abstract implements IWallet {
	
	public static function getSupportedWallets(){
		return array(
			'RDD',	
		);
	}

    public function __construct($label, $address) {
        parent::__construct($label, $address);
        $this->_apiURL = 'http://live.reddcoin.com/api/addr/' . $address . '/balance';

        $this->_fileHandler = new FileHandler('wallets/reddcoin/' . $this->_address . '.json');
    }

    public function update() {
        if ($GLOBALS['cached'] == false || $this->_fileHandler->lastTimeModified() >= 3600) { // updates every 60 minutes. How much are you being paid out that this must change? We take donations :)
            $addressBalance = curlCall($this->_apiURL);

            $data = array (
                'label' => $this->_label,
                'address' => $this->_address,
                'balance' => (float) $addressBalance/100000000
            );

            $this->_fileHandler->write(json_encode($data));
            return $data;
        }

        return json_decode($this->_fileHandler->read(), true);
    }

}
