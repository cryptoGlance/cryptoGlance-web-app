<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Pools_CkpoolSolo extends Pools_Abstract {

    // Pool Information
    protected $_btcaddess;
    protected $_type = 'ckpool-solo';

    public function __construct($params) {
        parent::__construct(array('apiurl' => 'http://solo.ckpool.org'));
        $this->_btcaddess = $params['address'];
        $this->_fileHandler = new FileHandler('pools/' . $this->_type . '/'. hash('md4', $params['address']) .'.json');
    }

    public function update() {
        if ($GLOBALS['cached'] == false || $this->_fileHandler->lastTimeModified() >= 30) { // updates every 30 seconds
            $userData = array();
            $userData = curlCall($this->_apiURL . '/users/' . $this->_btcaddess);

            // Offline Check
            if (empty($userData)) {
                return;
            }

            // Data Order
            $data['type'] = $this->_type;

            $data['user_hashrate1M'] = formatHashrate($this->normalizeHashrate($userData['hashrate1m']));
            $data['user_hashrate5M'] = formatHashrate($this->normalizeHashrate($userData['hashrate5m']));
	        $data['user_hashrate1Hr'] = formatHashrate($this->normalizeHashrate($userData['hashrate1hr']));
            $data['user_hashrate1D'] = formatHashrate($this->normalizeHashrate($userData['hashrate1d']));
	        $data['user_hashrate7D'] = formatHashrate($this->normalizeHashrate($userData['hashrate7d']));
            $data['user_workers'] = $userData['workers'];
            $data['user_best_share'] = number_format($userData['bestshare'], 1);

            $data['user_last_update'] = formatTimeElapsed(time() - $userData['lastupdate']);

            $data['url'] = $this->_apiURL;

            $this->_fileHandler->write(json_encode($data));
            return $data;
        }

        return json_decode($this->_fileHandler->read(), true);
    }

    private function normalizeHashrate($hashrate) {
        $lastChar = substr($hashrate, -1);
        $hashrate = rtrim($hashrate, $lastChar);

        switch($lastChar) {
            case 'M':
                $hashrate *= 1000;
                break;
            case 'G':
                $hashrate *= 1000000;
                break;
            case 'T':
                $hashrate *= 1000000000;
                break;
            case 'T':
                $hashrate *= 1000000000000;
                break;
        }

        return $hashrate;
    }

}
