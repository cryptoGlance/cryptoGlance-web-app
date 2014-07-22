<?php

/*
 * @author Stoyvo
 */
class Pools_Abstract {
    
    protected $_apiURL;
    protected $_fileHandler;
    
    public function __construct($params) {
        $this->_apiURL = $params['apiurl'];
    }
    
}