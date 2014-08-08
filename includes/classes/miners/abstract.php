<?php

/*
 * @author Stoyvo
 */
class Miners_Abstract {
    
    protected $_name;
    protected $_settings;
    
    public function __construct($rig) {
        $this->_name = $rig['name'];
        $this->_settings = $rig['settings'];
        
        if (empty($this->_settings)) {
            // defining default values for settings if not set
            $this->_settings = array(
                'algorithm' => 'sha256',
                'hwErrors' => array(
                    'enabled' => 1,
                    'type' => 'percent',
                    'danger' => array(
                        'percent' => '10',
                        'int' => '10',
                    ),
                    'warning' => array(
                        'percent' => '5',
                        'int' => '5',
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
    
    public function getSettings() {
        return array(
            'name' => $this->_name,
            'settings' => $this->_settings
        );
    }
    
}