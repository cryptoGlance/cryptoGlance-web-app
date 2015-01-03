<?php

/*
 * @author Stoyvo
 */
class Rss_Abstract {
    
    protected $_url;
    protected $_fileHandler;
    
    public function __construct($params) {
        $this->_url = $params['url'];
    }
    
}