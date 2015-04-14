<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Pools_Wafflepool extends Pools_Abstract {

    // Pool Information
    protected $_btcaddess;
    protected $_type = 'wafflepool';

    public function __construct($params) {
        parent::__construct(array('apiurl' => 'http://wafflepool.com'));
        $this->_btcaddess = $params['address'];
        $this->_fileHandler = new FileHandler('pools/' . $this->_type . '/'. hash('md4', $params['address']) .'.json');
    }

    public function update() {
        if ($GLOBALS['cached'] == false || $this->_fileHandler->lastTimeModified() >= 30) { // updates every 30 seconds
            $poolData = curlCall($this->_apiURL  . '/tmp_api?address='. $this->_btcaddess);

            // Offline Check
            if (empty($poolData)) {
                return;
            }

            // Data Order
            $data['type'] = $this->_type;

            $data['sent'] = $poolData['balances']['sent'];
            $data['balance'] = $poolData['balances']['confirmed'];
            $data['unconfirmed_balance'] = number_format($poolData['balances']['unconverted'], 8);

            $data['hashrate'] = formatHashrate($poolData['hash_rate']/1000);

            $activeWorkers = 0;
            foreach ($poolData['worker_hashrates'] as $worker) {
                if ($worker['hashrate'] != 0) {
                    $activeWorkers++;
                    continue;
                }
            }
            $data['active_worker(s)'] = $activeWorkers;

            $data['url'] = $this->_apiURL;

            $this->_fileHandler->write(json_encode($data));
            return $data;
        }

        return json_decode($this->_fileHandler->read(), true);
    }

}
