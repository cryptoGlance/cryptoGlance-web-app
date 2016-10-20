<?php
/**
 * Description of First Rally | https://firstrally.com
 *
 * First Rally is a live feed of coin prices/values developed by Tim Coulter (http://twitter.com/timothyjcoulter)
 * Show support to this amazing project by donating: https://firstrally.com/donate.html
 *
 * ---------------------------------------------------------------------------------------------------------------
 *
 * This class uses the First Rally API
 *
 * @author Stoyvo
 */
class FirstRally implements IExchanger {

    protected $_currencies = array(
        'BTC' => 'bitcoin',
        'BURST' => 'burstcoin',
        'DRK' => 'darkcoin',
        'DOGE' => 'dogecoin',
        'DOGED' => 'dogecoindark',
        'LTC' => 'litecoin',
        'NEOS' => 'neoscoin',
        'XPY' => 'paycoin',
        'RDD' => 'reddcoin',
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

    // Settings
    protected $_url = 'https://firstrally.com/api';

    public function convert($to, $from) {
        $fileHandler = new FileHandler('fiat/firstrally/' . strtolower($to) . '_' . strtolower($from) . '.json');

        if ($GLOBALS['cached'] == false || $fileHandler->lastTimeModified() >= 3600) { // updates every 1 minute
            $data = array();

            $data = curlCall($this->_url . '/v0.1/conversions/' . strtolower($from) . '/' . strtolower($to)); // /v0.1/conversions/:from/:to

            $fileHandler->write(json_encode($data));
            return $data;
        }

        return json_decode($fileHandler->read(), true);
    }

    public function getDisclaimer(){
        return 'Conversions powered by <a href="https://firstrally.com/" target="_external">https://firstrally.com/</a>';
    }

}
