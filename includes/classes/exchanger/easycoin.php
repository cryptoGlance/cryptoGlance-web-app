<?php
class Exchanger_EasyCoin implements IExchanger {

	protected $_url = 'https://www.easycoin.cz/';
	
	
    protected function supportedCurrencies(){
    	return array(
    		'CZK-CA' => 'Czech Republic Koruna - Cash',
    		'CZK' => 'Czech Republic Koruna - Cashless',
    		'CZK-BA' => 'Czech Republic Koruna - Banking',
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
        $fileHandler = new FileHandler('fiat/easycoin/rates.json');

        if ($GLOBALS['cached'] == false || $fileHandler->lastTimeModified() >= 3600) { // updates every 1 minute
        	$data = array();

        	$document = new DOMDocument();
            $libxml_previous_state = libxml_use_internal_errors(true);
            //Doesnt work with cURL
            $document->loadHTML(mb_convert_encoding(file_get_contents($this->_url), 'HTML-ENTITIES', "UTF-8"));
            libxml_clear_errors();
            libxml_use_internal_errors($libxml_previous_state);

            $xpath = new DOMXPath($document);
            $pairs = array_keys($this->supportedCurrencies());
            foreach ($xpath->query('//table[@id="btc-current-rates"]//tr[position()>1]') as $i => $node){
            	$data[$pairs[$i]] = floatval($xpath->query('td[2]', $node)->item(0)->nodeValue);
            }
            $fileHandler->write(json_encode($data));
            return array('result'=>array('conversion' => $data[$to]));
        }
        $data = json_decode($fileHandler->read(), true);
		return array('result'=>array('conversion' => $data[$to]));
    }
    
    public function getDisclaimer(){
        return '<a href="https://simplecoin.cz/" target="_external">https://simplecoin.cz/</a>';
    }
    
    public static function getName(){
    	return 'EasyCoin';
    }
}
