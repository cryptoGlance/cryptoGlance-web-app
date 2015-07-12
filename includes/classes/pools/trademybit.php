<?php
require_once('abstract.php');
/*
 * @author Don Steele
 * - Modified by Stoyvo
 */
class Pools_TradeMyBit extends Pools_Abstract {

    // Pool Information
    protected $_apiKey;
    protected $_type = 'trademybit';

    public function __construct($params) {
        parent::__construct(array('apiurl' => 'https://pool.trademybit.com'));
        $this->_apiKey = $params['apikey'];
        $this->_fileHandler = new FileHandler('pools/' . $this->_type . '/'. hash('md4', $params['apikey']) .'.json');
    }

    public function update() {
        if ($GLOBALS['cached'] == false || $this->_fileHandler->lastTimeModified() >= 30) { // updates every 30 seconds
            $payoutData = curlCall($this->_apiURL  . '/api/balance?key='. $this->_apiKey);
            $poolData = curlCall($this->_apiURL  . '/api/hashinfo?key='. $this->_apiKey);

            // Offline Check
            if (empty($poolData)) {
                return;
            }

            // Payout Information
            $data['type'] = $this->_type;
            $data['unexchanged'] = $payoutData['autoexchange']['unexchanged'];
            $data['exchanged'] = $payoutData['autoexchange']['exchanged'];

            $data['est_payout'] = $payoutData['autoexchange']['est_total'];

            // Pool Speed
            $data['user_hash'] =  formatHashRate($poolData['user_hash']*1000);


            // Clear data if it's missing
            foreach ($data as $key => $value) {
                if ($value == 0) {
                    unset($data[$key]);
                }
            }

            $data['url'] = $this->_apiURL;

            $this->_fileHandler->write(json_encode($data));
            return $data;
        }

        return json_decode($this->_fileHandler->read(), true);
    }

}
