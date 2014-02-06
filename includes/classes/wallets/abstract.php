<?php

/*
 * @author Stoyvo
 */
class Class_Wallets_Abstract {

    protected $_label;
    protected $_address;
        
    public function __construct($label, $address) {
        $this->_label = $label;
        $this->_address = $address;
    }
}
?>