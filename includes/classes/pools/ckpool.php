<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Pools_Ckpool extends Pools_Abstract {

    // Pool Information
    protected $_btcaddess;
    protected $_type = 'ckpool';

    public function __construct($params) {
        parent::__construct($params);
        $this->_address = $params['address'];
        $this->_fileHandler = new FileHandler('pools/' . $this->_type . '/'. hash('md4', $params['address']) .'.json');
    }

    public function update() {
        if ($GLOBALS['cached'] == false || $this->_fileHandler->lastTimeModified() >= 30) { // updates every 30 seconds
            $poolData = array();
            $poolData = curlCall($this->_apiURL  . '/address.php?a='.$this->_address);

            // For some reason CKPool returns information with HTML...
            $poolData = strstr($poolData, '{');
            $poolData = substr($poolData, 0, strrpos($poolData, '}')).'}';

            $poolData = json_decode($poolData, true);

            // Data Order
            $data['type'] = $this->_type;

            $data['1_minute_hashrate'] = preg_replace('/(?<=[a-z])(?=\d)|(?<=\d)(?=[a-z])/i', ' ', $poolData['hashrate1m']).'H/S';
            $data['5_minutes_hashrate'] = preg_replace('/(?<=[a-z])(?=\d)|(?<=\d)(?=[a-z])/i', ' ', $poolData['hashrate5m']).'H/S';
            $data['1_hour_hashrate'] = preg_replace('/(?<=[a-z])(?=\d)|(?<=\d)(?=[a-z])/i', ' ', $poolData['hashrate1hr']).'H/S';
            $data['1_day_hashrate'] = preg_replace('/(?<=[a-z])(?=\d)|(?<=\d)(?=[a-z])/i', ' ', $poolData['hashrate1d']).'H/S';
            $data['7_day_hashrate'] = preg_replace('/(?<=[a-z])(?=\d)|(?<=\d)(?=[a-z])/i', ' ', $poolData['hashrate7d']).'H/S';
            $data['workers'] = $poolData['workers'];

            $data['url'] = $this->_apiURL;

            $this->_fileHandler->write(json_encode($data));
            return $data;
        }

        return json_decode($this->_fileHandler->read(), true);
    }

}
