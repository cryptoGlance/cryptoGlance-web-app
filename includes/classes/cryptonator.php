<?php
class Cryptonator implements IExchanger {

    // Settings
    protected $_url = 'https://www.cryptonator.com/api';

    protected function getSupportedCryptoCurrencies(){
        $fileHandler = new FileHandler('crypto/cryptonator/currencies.json');
        if ($GLOBALS['cached'] == false || $fileHandler->lastTimeModified() >= 3600){
            $data = curlCall($z = $this->_url . '/currencies');
            if (!is_array($data)){
                return json_decode($fileHandler->read(), true);
            }
            $data = array_filter($data['rows'], function($a){ return in_array('primary', $a['statuses']);});
            $data = array_combine(array_map(function($a){return $a['code'];}, $data), array_map(function($a){return $a['name'];}, $data));
            $fileHandler->write(json_encode($data));
            return $data;
        }
        return json_decode($fileHandler->read(), true);
    }

    protected function supportedCurrencies(){
        $fileHandler = new FileHandler('fiat/cryptonator/currencies.json');
        if ($GLOBALS['cached'] == false || $fileHandler->lastTimeModified() >= 3600){
            $data = curlCall($z = $this->_url . '/currencies');
            if (!is_array($data)){
                return json_decode($fileHandler->read(), true);
            }
            $data = array_filter($data['rows'], function($a){ return in_array('secondary', $a['statuses']);});
            $data = array_combine(array_map(function($a){return $a['code'];}, $data), array_map(function($a){return $a['name'];}, $data));
            $fileHandler->write(json_encode($data));
            return $data;
        }
        return json_decode($fileHandler->read(), true);
    }

    public function getFiat(){
        return $this->supportedCurrencies();
    }

    public function getCurrencies(){
        return $this->getSupportedCryptoCurrencies();
    }

    public function convert($to, $from) {
        $fileHandler = new FileHandler('fiat/cryptonator/rates-'. $from.'-'.$to.'.json');

        if ($GLOBALS['cached'] == false || $fileHandler->lastTimeModified() >= 3600) { // updates every 1 minute
            $data = array();
            $data = curlCall($this->_url . '/ticker/'.$from.'-'.$to);
            if (!is_array($data)){
                 return json_decode($fileHandler->read(), true);
            }
            $data = array(
                'result' => array(
                    'conversion' => $data['ticker']['price'],
                ),
            );
            $fileHandler->write(json_encode($data));
            return $data;
        }

        return json_decode($fileHandler->read(), true);
    }
    
    public function getDisclaimer(){
        return 'Conversions powered by <a href="https://www.cryptonator.com/" target="_external">https://www.cryptonator.com/</a>';
    }
}
