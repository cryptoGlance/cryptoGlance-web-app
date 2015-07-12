<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Pools_Simplecoin extends Pools_Abstract {

    // Pool Information
    protected $_apiKey;
    protected $_type = 'simplecoin';

    // api calls to make
    protected $_actions = array(
        'pool_stats',
    );

    public function __construct($params) {
        parent::__construct($params);
        $this->_apiKey = $params['apikey'];
        $this->_actions[] = $this->_apiKey;
        $this->_fileHandler = new FileHandler('pools/' . $this->_type . '/'. hash('md4', $params['apikey']) .'.json');
    }

    public function update() {
        if ($GLOBALS['cached'] == false || $this->_fileHandler->lastTimeModified() >= 30) { // updates every 30 seconds
            $poolData = array();
            foreach ($this->_actions as $action) {
                $poolData[$action] = curlCall($this->_apiURL  . '/api/'. $action);
            }

            // Offline Check
            if (empty($poolData[$this->_actions[0]])) {
                return;
            }

            // Data Order
            $data['type'] = $this->_type;

            $data['total_paid'] = (!empty($poolData[$this->_apiKey]['total_paid']) ? $poolData[$this->_apiKey]['total_paid']/100000000 : 0);

            $data['balance'] = (!empty($poolData[$this->_apiKey]['balance']) ? $poolData[$this->_apiKey]['balance']/100000000 : 0);
            $data['unconfirmed_balance'] = (!empty($poolData[$this->_apiKey]['unconfirmed_balance']) ? $poolData[$this->_apiKey]['unconfirmed_balance']/100000000 : 0);
            $data['estimated_round_payout'] = (!empty($poolData[$this->_apiKey]['est_round_payout']) ? number_format($poolData[$this->_apiKey]['est_round_payout'], 8) : 0);

            $data['pool_hashrate'] = formatHashrate($poolData['pool_stats']['hashrate']);

            $data['user_hashrate'] = formatHashrate($poolData[$this->_apiKey]['last_10_hashrate'] * 1000);

            $data['pool_workers'] = $poolData['pool_stats']['workers'];

            $data['accepted'] = 0;
            $data['rejected'] = 0;
            $data['efficiency'] = 0;
            $data['active_worker(s)'] = 0;
            foreach ($poolData[$this->_apiKey]['workers'] as $worker) {
                if ($worker['online']) {
                    $data['efficiency'] += $worker['efficiency'];
                    $data['accepted'] += $worker['accepted'];
                    $data['rejected'] += $worker['rejected'];
                    $data['active_worker(s)']++;
                }
            }
            if ($data['active_worker(s)'] > 0) {
                $data['efficiency'] = number_format($data['efficiency'] / $data['active_worker(s)'], 2);
            } else {
                $data['efficiency'] = 0.00;
            }
            $data['efficiency'] .= '%';

            $data['time_since_last_block'] = gmdate('H\H i\M s\S', $poolData['pool_stats']['round_duration']);

            $data['last_block_found'] = $poolData['pool_stats']['last_block_found'];

            $data['url'] = $this->_apiURL;

            $this->_fileHandler->write(json_encode($data));

            return $data;
        }

        return json_decode($this->_fileHandler->read(), true);
    }

}
