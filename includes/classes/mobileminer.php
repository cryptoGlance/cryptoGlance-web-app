<?php
/**
 * Description of MobileMiner | http://www.mobileminerapp.com/
 *
 * The MobileMiner apps allow you to remotely monitor and control your Bitcoin, Litecoin, and other crypto-currency mining rigs.
 *
 * ---------------------------------------------------------------------------------------------------------------
 *
 * This class uses the MobileMiner API | http://www.mobileminerapp.com/#api
 *
 * @author Stoyvo
 */
class MobileMiner {

    // Settings
    protected $_url = 'https://api.mobileminerapp.com';
    protected $_username = '';
    protected $_apiKey = '';

    // cryptoGlance Specific
    protected $_appKey = 'ozhjiY941gooFo';

    // Rig Data
    protected $_rigs = array();

    public function __construct() {
        $this->_username = $GLOBALS['settings']['general']['mobileminer']['username'];
        $this->_apiKey = $GLOBALS['settings']['general']['mobileminer']['apikey'];
        $this->_rigs = new Rigs();
    }

    // The app will simply update all the device data to the mobileminer api
    public function getUpdate() {

        $data = curlCall('https://api.mobileminerapp.com/MiningStatisticsInput?emailAddress=email@address.com&applicationKey=appkey&apiKey=apikey');
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        die();

        // Do nothing if it's not enabled
        if (!$GLOBALS['settings']['general']['mobileminer']['enabled']) {
            return;
        }

        // Listen for response from server
        $this->_listen();

        // Get all device data
        $rigData = $this->_rigs->getUpdate();

        // Start building request
        // $this->_postStatistics();
        // $this->_postPools();
        // $this->_postNotifications();

        // Done.
    }

    protected function _listen() {
        // call server for any changes
    }

    protected function _postStatistics() {
        // build out machine statistics
    }

    protected function _postPools() {
        // Post all the pools for each machine
    }

    protected function _postNotifications() {
        // If anything serious has happened, post notifications to the API
    }


}
