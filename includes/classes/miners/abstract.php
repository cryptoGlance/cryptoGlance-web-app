<?php

/*
 * @author Stoyvo
 */
class Miners_Abstract {
    
    protected $_name;
    protected $_settings;
    
    public function __construct($name, $settings) {
        $this->_name = $name;
        $this->_settings = $settings;
        
        if (empty($this->_settings)) {
            // defining default values for settings if not set
            $this->_settings = array(
                'algorithm' => 'sha256', // scrypt, scrypt-n, x11
                'hwErrors' => array(
                    'enabled' => 1,
                    'type' => 'percent',
                    'danger' => array(
                        'percent' => '10',
                        'number' => '10',
                    ),
                    'warning' => array(
                        'percent' => '5',
                        'number' => '5',
                    ),
                ),
                'temps' => array(
                    'enabled' => 1,
                    'danger' => '80',
                    'warning' => '75',
                ),
            );
        }
    }
    
}
?>