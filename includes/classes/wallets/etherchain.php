<?php
/*
 * @author Blonďák
 */
class Wallets_Etherchain extends Wallets_Abstract implements IWallet {

	public static function getSupportedWallets(){
		return array(
			'ETH',
		);
	}
	
    public function __construct($label, $address, $currency) {
        parent::__construct($label, $address);
        $this->_apiURL = 'https://etherchain.org/api/account/' . $address;
        $this->_fileHandler = new FileHandler('wallets/'.$currency.'/' . $this->_address . '.json');
    }
    
    public function update() {
        if ($GLOBALS['cached'] == false || $this->_fileHandler->lastTimeModified() >= 3600) { // updates every 60 minutes. How much are you being paid out that this must change? We take donations :)
            $walletData = curlCall($this->_apiURL);
            
            $walletData = reset($walletData['data']);
            
            $data = array (
                'label' => $this->_label,
                'address' => $this->_address,
                'balance' => $walletData['balance'] / 1E+18,
            );
            
            $this->_fileHandler->write(json_encode($data));
            return $data;
        }
        
        return json_decode($this->_fileHandler->read(), true);
    }

}
