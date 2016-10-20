<?php
class CoinDesk implements IExchanger {

    // Settings
    protected $_url = 'https://api.coindesk.com/v1';

    protected function downloadRates(){

        $fileHandler = new FileHandler('fiat/coindesk/rates.json');
        if (true || $GLOBALS['cached'] == false || $fileHandler->lastTimeModified() >= 3600){
            $data = curlCall($z = $this->_url . '/v0.1/conversions/' . strtolower($from) . '/' . strtolower($to)); // /v0.1/conversions/:from/:to
        }
        return json_decode($fileHandler->read(), true);

    }


    protected function supportedCurrencies(){
        $fileHandler = new FileHandler('fiat/coindesk/currencies.json');
        if ($GLOBALS['cached'] == false || $fileHandler->lastTimeModified() >= 3600){
            $data = curlCall($this->_url . '/bpi/supported-currencies.json');
            $data = array_combine(array_map(function($a){return $a['currency'];}, $data), array_map(function($a){return $a['country'];}, $data));
            $fileHandler->write(json_encode($data));
            return $data;
        }
        return json_decode($fileHandler->read(), true);
    }

    public function getFiat(){
        return $this->supportedCurrencies();
    }

    public function getCurrencies(){
        return array(
            'bitcoin' => 'BTC',
            'peercoin' => 'PPC',
            'litecoin' => 'LTC',
        );
    }

    public function convert($to, $from) {
        $fileHandler = new FileHandler('fiat/coindesk/rates-'. $from.'-'.$to.'.json');

        if ($GLOBALS['cached'] == false || $fileHandler->lastTimeModified() >= 3600) { // updates every 1 minute
            $data = array();
            $data = curlCall($this->_url . '/bpi/currentprice/'.$to.'.json');
            $data = array(
                'result' => array(
                    'conversion' => $data['bpi'][$to]['rate_float'],
                ),
            );
            $fileHandler->write(json_encode($data));
            return $data;
        }

        return json_decode($fileHandler->read(), true);
    }
    
    public function getDisclaimer(){
        return 'Conversions powered by <a href="https://coindesk.com/" target="_external">https://coindesk.com/</a>';
    }
}
