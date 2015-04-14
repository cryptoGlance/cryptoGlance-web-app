<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Pools_Nomp extends Pools_Abstract {

    // Pool Information
    protected $_address;
    protected $_type = 'nomp';
    protected $_coin;

    public function __construct($params) {
        parent::__construct($params);
        $this->_address = $params['address'];
        $this->_coin = $params['coin'];
        $this->_fileHandler = new FileHandler('pools/' . $this->_type . '/'. $this->_apiURL . '/' . hash('md4', $params['address']) .'.json');
    }

    public function update() {
        if ($GLOBALS['cached'] == false || $this->_fileHandler->lastTimeModified() >= 30) { // updates every 30 seconds
            $poolData = array();
            $poolData = curlCall($this->_apiURL  . '/api/stats');


            // Offline Check
            if (empty($poolData)) {
                return;
            }

            if (empty($this->_coin)) {
                $this->findCoin($poolData);
            }
            $poolData = $poolData['pools'][$this->_coin];

            $totalValidShares = 0;
            $totalInValidShares = 0;
            foreach ($poolData['workers'] as $address => $values) {
                $totalValidShares += $values['shares'];
                $totalInValidShares += $values['invalidshares'];
            }
            $totalShares = $totalValidShares+$totalInValidShares;

            // Data Order
            $data['type'] = $this->_type;

            $data['algorithm'] = $poolData['algorithm'];
            $data['coin'] = $poolData['name'] . ' (' . $poolData['symbol'] . ')';

            $data['pool_hashrate'] = $poolData['hashrateString'];
            $data['pool_valid_shares'] = $totalValidShares;
            $data['pool_invalid_shares'] = $totalInValidShares;
            $data['pool_workers'] = $poolData['workerCount'];

            $data['user_hashrate'] = $poolData['workers'][$this->_address]['hashrateString'];
            $data['user_valid_shares'] = $poolData['workers'][$this->_address]['shares'];
            $data['user_invalid_shares'] = $poolData['workers'][$this->_address]['invalidshares'];

            $userTotalShares = $poolData['workers'][$this->_address]['shares']+$poolData['workers'][$this->_address]['invalidshares'];
            $data['round_share_%'] = round(($userTotalShares/$totalShares)*100, 4);

            $data['blocks_pool_found'] = $poolData['poolStats']['validBlocks'];
            $data['blocks_confirmed'] = $poolData['blocks']['confirmed'];
            $data['blocks_pending'] = $poolData['blocks']['pending'];

            if ($poolData['blocks']['orphaned'] != 0) {
                $data['blocks_orphaned'] = $poolData['blocks']['orphaned'];
            }

            $data['url'] = $this->_apiURL;

            $this->_fileHandler->write(json_encode($data));
            return $data;
        }

        return json_decode($this->_fileHandler->read(), true);
    }

    private function findCoin($poolData) {
        foreach ($poolData['pools'] as $coin => $coinData) {
            if (array_key_exists($this->_address, $coinData['workers'])) {
                $this->_coin = $coin;
                return;
            }
        }
    }

}
