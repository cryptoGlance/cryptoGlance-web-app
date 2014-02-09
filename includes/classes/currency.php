<?php
/*
 * @author Stoyvo
 */

class Class_Currency {

    protected $_exchange;
    protected $_pairs = array();
    
    // cache results
    protected $_results = array();

    public function __construct() {
        $fh = new Class_FileHandler('configs/currency.json');
        $currency = json_decode($fh->read());
        
        if (!empty($currency->exchange)) {
            $class = 'Class_Currency_' . ucwords(strtolower($currency->exchange->name));
            $this->_exchange = new $class($currency->exchange->apiKey, $currency->exchange->apiSecret);
        }

        if (!empty($currency->pairs)) {
            $this->_pairs = $currency->pairs;
        }
    }

    // Not used...
    public function getData() {
        return $this->_results;
    }
    //////////////

    public function update() {    
        $this->_results = array();
        foreach ($this->_pairs as $pair) {
            $this->_results[] = $this->_exchange->update($pair);
        }
        
        return $this->_results;
    }

}
