<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Pools_Bitminter extends Pools_Abstract {

    // Pool Information
    protected $_apiKey;
    protected $_userId;
    protected $_type = 'bitminter';

    public function __construct($params) {
        parent::__construct(array('apiurl' => 'https://bitminter.com'));
        $this->_apiKey = $params['apikey'];
        $this->_userId = $params['userid'];
        $this->_fileHandler = new FileHandler('pools/' . $this->_type . '/'. hash('md4', $params['apikey']) .'.json');
    }

    public function update() {
        if ($GLOBALS['cached'] == false || $this->_fileHandler->lastTimeModified() >= 30) { // updates every 30 seconds
            $poolData['global'] = curlCall($this->_apiURL  . '/api/pool/stats');
            $poolData['user'] = curlCall($this->_apiURL  . '/api/users/'.$this->_userId.'?key='. $this->_apiKey);


            // Offline Check
            if (empty($poolData['global']) || empty($poolData['user'])) {
                return;
            }

            // Payout Information
            $data['type'] = $this->_type;

            // Balances?
            $data['btc_balance'] = number_format($poolData['user']['balances']['BTC'], 8);
            $data['nmc_balance'] = number_format($poolData['user']['balances']['NMC'], 8);

            $data['user_hashrate'] =  formatHashRate($poolData['user']['hash_rate']*1000);

            $data['network_hashrate'] =  formatHashRate($poolData['global']['hash_rate']*1000000);

            $data['workers'] = $poolData['user']['active_workers'];

            $data['round_duration'] = formatTimeElapsed($poolData['user']['now']-$poolData['user']['round_start']['BTC']);

            $data['username'] = $poolData['user']['name'];

            $data['url'] = $this->_apiURL;

            $this->_fileHandler->write(json_encode($data));
            return $data;
        }

        return json_decode($this->_fileHandler->read(), true);
    }

}
