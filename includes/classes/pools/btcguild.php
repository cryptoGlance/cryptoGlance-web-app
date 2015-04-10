<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Pools_Btcguild extends Pools_Abstract {

    // Pool Information
    protected $_apiKey;
    protected $_type = 'btcguild';

    public function __construct($params) {
        parent::__construct(array('apiurl' => 'https://www.btcguild.com'));
        $this->_apiKey = $params['apikey'];
        $this->_fileHandler = new FileHandler('pools/' . $this->_type . '/'. hash('md4', $params['address']) .'.json');
    }

    public function update() {
        if ($GLOBALS['cached'] == false || $this->_fileHandler->lastTimeModified() >= 30) { // updates every 30 seconds

            $poolData = curlCall($this->_apiURL  . '/api.php?api_key='. $this->_apiKey);

            // Offline Check
            if (empty($poolData)) {
                return;
            }

            // Data Order
            $data['type'] = $this->_type;

            // Pool Speed
            $data['pool_hashrate'] = formatHashRate($poolData['pool']['pool_speed']*1000000000);
            $data['user_hashrate'] = 0;

            // BTC Payout
            // $data['total_BTC'] = $poolData['user']['total_rewards'];
            $data['paid_BTC'] = $poolData['user']['paid_rewards'];
            $data['unpaid_BTC'] = $poolData['user']['unpaid_rewards'];
            $data['past_24h_BTC'] = $poolData['user']['past_24h_rewards'];
            $data['BTC_difficulty'] = $poolData['pool']['difficulty'];
            $data['valid_BTC_shares'] = 0;
            $data['stale_BTC_shares'] = 0;
            $data['duplicate_BTC_shares'] = 0;
            $data['unknown_BTC_shares'] = 0;

            // NMC Payout
            // $data['total_NMC'] = $poolData['user']['total_rewards_nmc'];
            $data['paid_NMC'] = $poolData['user']['paid_rewards_nmc'];
            $data['unpaid_NMC'] = $poolData['user']['unpaid_rewards_nmc'];
            $data['past_24h_NMC'] = $poolData['user']['past_24h_rewards_nmc'];
            $data['NMC_difficulty'] = $poolData['pool']['difficulty_nmc'];
            $data['valid_NMC_shares'] = 0;
            $data['stale_NMC_shares'] = 0;
            $data['duplicate_NMC_shares'] = 0;
            $data['unknown_NMC_shares'] = 0;

            foreach ($poolData['workers'] as $worker) {
                $data['user_hashrate'] += $worker['hashrate'];

                // BTC
                $data['valid_BTC_shares'] += $worker['valid_shares'];
                $data['stale_BTC_shares'] += $worker['stale_shares'];
                $data['duplicate_BTC_shares'] += $worker['duplicate_shares'];
                $data['unknown_BTC_shares'] += $worker['unknown_shares'];

                // NMC
                $data['valid_NMC_shares'] += $worker['valid_shares_nmc'];
                $data['stale_NMC_shares'] += $worker['stale_shares_nmc'];
                $data['duplicate_NMC_shares'] += $worker['duplicate_shares_nmc'];
                $data['unknown_NMC_shares'] += $worker['unknown_shares_nmc'];
            }

            $data['active_workers'] = 0;
            if (!empty($poolData['workers'])) {
                foreach($poolData['workers'] as $worker) {
                    if ($worker['hash_rate'] != 0) {
                        $data['active_workers']++;
                    }

                }
            }

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
