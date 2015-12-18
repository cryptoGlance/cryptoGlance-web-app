<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Pools_P2Pool extends Pools_Abstract {

    // Pool Information
    protected $_addess;
    protected $_type = 'p2pool';

    // api calls to make
    protected $_actions = array(
        'current_payouts', // payout of this round
        'global_stats',
        'local_stats',
        'web/currency_info',
    );

    public function __construct($params) {
        parent::__construct($params);
        $this->_addess = $params['address'];
        $this->_fileHandler = new FileHandler('pools/' . $this->_type . '/'. hash('md4', $params['address']) .'.json');
    }

    public function update() {
        if ($GLOBALS['cached'] == false || $this->_fileHandler->lastTimeModified() >= 30) { // updates every 30 seconds
            $poolData = array();
            foreach ($this->_actions as $action) {
                $poolData[$action] = curlCall($this->_apiURL  . '/' . $action);
            }
            
            // Offline Check
            if (empty($poolData[$this->_actions[0]])) {
                return;
            }

            // Data Order
            $data['type'] = $this->_type;

            $data['coin'] = $poolData['web/currency_info']['symbol'];

            $data['balance'] = number_format($poolData['current_payouts'][$this->_addess], 8);

            $data['user_hashrate'] = formatHashrate($poolData['local_stats']['miner_hash_rates'][$this->_addess]/1000);
            $data['pool_hashrate'] = formatHashrate($poolData['global_stats']['pool_nonstale_hash_rate']/1000);

            $data['pool_uptime'] = formatTimeElapsed($poolData['local_stats']['uptime']);

            $data['pool_fee'] = $poolData['local_stats']['fee'] . '%';

            $data['peers_in'] = $poolData['local_stats']['peers']['incoming'];
            $data['peers_out'] = $poolData['local_stats']['peers']['outgoing'];

            $data['url'] = $this->_apiURL;

            $this->_fileHandler->write(json_encode($data));
            return $data;
        }

        return json_decode($this->_fileHandler->read(), true);
    }

}
