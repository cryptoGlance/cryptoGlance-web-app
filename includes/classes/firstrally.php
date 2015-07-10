<?php
/**
 * Description of First Rally | https://firstrally.com
 *
 * First Rally is a live feed of coin prices/values developed by Tim Coulter (http://twitter.com/timothyjcoulter)
 * Show support to this amazing project by donating: https://firstrally.com/donate.html
 *
 * ---------------------------------------------------------------------------------------------------------------
 *
 * This class uses the First Rally API
 *
 * @author Stoyvo
 */
class FirstRally {

    // Settings
    protected $_url = 'https://firstrally.com/api';

    public function convert($to, $from) {
        $fileHandler = new FileHandler('fiat/firstrally/' . strtolower($to) . '_' . strtolower($from) . '.json');

        if ($GLOBALS['cached'] == false || $fileHandler->lastTimeModified() >= 3600) { // updates every 1 minute
            $data = array();

            $data = curlCall($this->_url . '/v0.1/conversions/' . strtolower($from) . '/' . strtolower($to)); // /v0.1/conversions/:from/:to

            $fileHandler->write(json_encode($data));
            return $data;
        }

        return json_decode($fileHandler->read(), true);
    }


}
