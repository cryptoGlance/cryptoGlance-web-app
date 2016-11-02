<?php
class Exchanger_SimpleCoin implements IExchanger {

	protected $_url = 'https://simplecoin.cz/';
	
	
    protected function supportedCurrencies(){
    	return array(
    		'CZK' => 'Czech Republic Koruna'
    	);
    }

    public function getFiat(){
        return $this->supportedCurrencies();
    }

    public function getCurrencies(){
        return array(
            'BTC' => 'Bitcoin',
        );
    }

    public function convert($to, $from) {
        $fileHandler = new FileHandler('fiat/simplecoin/rates-'. $from.'-'.$to.'.json');

        if ($GLOBALS['cached'] == false || $fileHandler->lastTimeModified() >= 3600) { // updates every 1 minute
            $data = array();
            $data = curlCall($this->_url . 'ticker/');
            $data = array(
                'result' => array(
                    'conversion' => $data['offer'],
                ),
            );
            $fileHandler->write(json_encode($data));
            return $data;
        }

        return json_decode($fileHandler->read(), true);
    }
    
    public function getDisclaimer(){
        return '<a href="https://simplecoin.cz/" target="_external">https://simplecoin.cz/</a>';
    }
    
    public static function getName(){
    	return 'SimpleCoin';
    }
}
