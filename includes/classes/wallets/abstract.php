<?php
/*
 * @author Stoyvo
 */
if (!defined('__Wallets_Abstract')){
	define('__Wallets_Abstract', true);
	class Wallets_Abstract {
	    
	    protected $_apiURL;
	    protected $_label;
	    protected $_address;
	    protected $_fileHandler;
	        
	    public function __construct($label, $address) {
	        $this->_label = $label;
	        $this->_address = $address;
	    }
	}
}