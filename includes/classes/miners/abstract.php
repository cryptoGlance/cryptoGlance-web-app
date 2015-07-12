<?php

/*
 * @author Stoyvo
 */
class Miners_Abstract {

    // Miner Memebers
    protected $_host;
    protected $_port;

    // Data
    protected $_summary = array();
    protected $_devs = array();
    protected $_eStats = array();
    protected $_pools = array();

    // Common Data
    protected $_devStatus = array();
    protected $_rigStatus = 'offline';
    protected $_highTemp = 0;
    protected $_rigHashrate_avg = 0;
    protected $_activePool = array();
    protected $_upTime;

    protected $_name;
    protected $_settings = array(
        'algorithm' => 'SHA256',
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
        )
    );

    public function __construct($rig) {
        $this->_name = $rig['name'];
        $this->_settings = array_merge($this->_settings, $rig['settings']);
    }

    public function getSettings() {
        return array(
            'name' => $this->_name,
            'settings' => $this->_settings
        );
    }

}
