<?php
/**
 * Description of Wallet API | http://walletapi.cryptoglance.info
 *
 * Wallet API is a service hosted free of charge by CryptoGlance devs.
 * Development support was provided by Tim Coulter (http://twitter.com/timothyjcoulter)
 *
 * ---------------------------------------------------------------------------------------------------------------
 *
 * This class uses the CryptoGlance Wallet API
 *
 * @author Stoyvo
 */
class Exchanger_Walletapi implements IExchanger {

    // Settings
    protected $_url = 'http://walletapi.cryptoglance.info';

    protected $_currencies = array(
    		'BTC' => 'Bitcoin',
    		'BURST' => 'Burstcoin',
    		'DRK' => 'Darkcoin',
    		'DOGE' => 'Dogecoin',
    		'DOGED' => 'Dogecoin Dark',
    		'LTC' => 'Litecoin',
    		'NEOS' => 'Neoscoin',
    		'XPY' => 'Paycoin',
    		'RDD' => 'Reddcoin',
    		// 'VTC'  => 'vertcoin', // Disabled until blockchain explorer works
    );
    
    protected $_fiat = array(
    		'CAD'   => 'Canadian Dollar',
    		'EUR'   => 'Euro',
    		'GBP'   => 'British Pound',
    		'NZD'   => 'New Zealand Dollar',
    		'USD'   => 'US Dollar',
    );
    
    public function getFiat(){
    	return $this->_fiat;
    }
    
    public function getCurrencies(){
    	return $this->_currencies;
    }
    
    public function convert($to, $from) {
        $fileHandler = new FileHandler('fiat/walletapi/' . strtolower($to) . '_' . strtolower($from) . '.json');

        if ($GLOBALS['cached'] == false || $fileHandler->lastTimeModified() >= 3600) { // updates every 1 minute
            $data = array();

            $data = curlCall($this->_url . '/?from=' . strtolower($from) . '&to=' . strtolower($to));

            $fileHandler->write(json_encode($data));
            return $data;
        }

        return json_decode($fileHandler->read(), true);
    }

    public function getDisclaimer(){
    	return '<b>cryptoGlance Team</b>! <a href="bitcoin:12PqYifLLTHuU2jRxTtbbJBFjkuww3zeeE?label=cryptoGlance" data-toggle="modal" data-target="#qrDonateBTC" title="Donate Bitcoin (BTC)">Donations keep us online!</a>';
    }
    
    public static function getName(){
    	return 'Walletapi';
    }
    
}
