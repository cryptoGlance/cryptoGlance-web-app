<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Pools_Eclipse extends Pools_Abstract {

    // Pool Information
    protected $_apiKey;
    protected $_type = 'eclipse';

    // api calls to make
    protected $_actions = array(
        'poolstats',
        'userstats',
    );

    public function __construct($params) {
        parent::__construct(array('apiurl' => 'https://eclipsemc.com'));
        // https://eclipsemc.com
        $this->_apiKey = $params['apikey'];
        $this->_fileHandler = new FileHandler('pools/' . $this->_type . '/'. hash('md4', $params['apikey']) .'.json');
    }

    public function update() {
        if ($GLOBALS['cached'] == false || $this->_fileHandler->lastTimeModified() >= 30) { // updates every 30 seconds
            $poolData = array();
            foreach ($this->_actions as $action) {
                $poolData[$action] = curlCall($this->_apiURL  . '/api.php?key='.$this->_apiKey.'&action='. $action);
            }

            // Offline Check
            if (empty($poolData[$this->_actions[0]])) {
                return;
            }

            // Data Order
            $data['type'] = $this->_type;

            $data['total_sent'] = $poolData['userstats']['data']['user']['total_payout'];
            $data['balance'] = $poolData['userstats']['data']['user']['confirmed_rewards'];
            $data['unconfirmed_balance'] = $poolData['userstats']['data']['user']['unconfirmed_rewards'];
            $data['estimated_rewards'] = $poolData['userstats']['data']['user']['estimated_rewards'];

            $data['pool_hashrate'] = $poolData['poolstats']['hashrate'];


            $data['user_hashrate'] = 0;
            $speedMultiplier = array(
                'GH/s' => 1000,
                'TH/s' => 1000000,
            );
            foreach ($poolData['userstats']['workers'] as $worker) {
                if (!empty($worker['hash_rate'])) {
                    $hashrate = strtok($worker['hash_rate'], ' ');
                    $hashspeed = substr(strrchr($worker['hash_rate'], ' '), 1);
                    $data['user_hashrate'] += $hashrate * $speedMultiplier[$hashspeed];
                }
            }

            $data['user_hashrate'] = formatHashRate($data['user_hashrate']*1000);

            $data['pool_workers'] = $poolData['poolstats']['active_workers'];

            // how to get active user workers and total hashrate?
            $data['time_since_last_block'] = $poolData['poolstats']['round_duration']; // Would love to format this one day
//            $data['time_since_last_block'] = formatTimeElapsed(); // how to format? 00:52:44

            $data['url'] = $this->_apiURL;

            $this->_fileHandler->write(json_encode($data));
            return $data;
        }

        return json_decode($this->_fileHandler->read(), true);
    }

}
