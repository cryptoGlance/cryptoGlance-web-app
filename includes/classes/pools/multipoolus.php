<?php
require_once('abstract.php');
/*
 * @author Don Steele
 * - Modified by Stoyvo
 */
class Pools_MultiPoolUS extends Pools_Abstract {

    // Pool Information
    protected $_apiKey;
    protected $_type = 'multipoolus';

    public function __construct($params) {
        parent::__construct(array('apiurl' => 'http://api.multipool.us/api.php'));
        $this->_apiKey = $params['apikey'];
        $this->_fileHandler = new FileHandler('pools/' . $this->_type . '/'. hash('md4', $params['apikey']) . '.json');
    }

    public function update() {
        if ($GLOBALS['cached'] == false || $this->_fileHandler->lastTimeModified() >= 30) { // updates every 30 seconds
            $poolData =  curlCall($this->_apiURL  . '?api_key='. $this->_apiKey);

            // Payout Information
            $data['type'] = $this->_type;
            
            $poolHashrate = 0;
            $userHashrate = 0;
            foreach ($poolData['currency'] as $coin => $values) {
                if (!empty($values['round_shares'])) {
                    $data[$coin.'_balance'] = $values['estimated_rewards'];
                    // removed until we find a better way to display this information. Right now it's way too cluttered
                    // if ($values['hashrate'] != '0') {
                    //     $data[$coin.'_hashrate'] =  formatHashrate($values['hashrate']);
                    // }
                    $userHashrate += $values['hashrate'];
                    $poolHashrate += $values['pool_hashrate'];
                }
            }
            
            $data['pool_hashrate'] = $poolHashrate;
            $data['user_hashrate'] = $userHashrate;
            
            $userWorkers = array();
            foreach ($poolData['workers'] as $coin => $workers) {
                foreach ($workers as $name => $worker) {
                    if ($worker['hashrate'] != 0) {
                        $userWorkers[$name] += $worker['hashrate'];
                    }
                }
            }
            
            foreach ($userWorkers as $name => $worker) {
                $name = explode('.', $name);
                $data['worker_'.$name[1]] = formatHashrate($worker);
            }
            
            $data['pool_hashrate'] = formatHashrate($data['pool_hashrate']);
            $data['user_hashrate'] = formatHashrate($data['user_hashrate']);
            
            $data['url'] = $this->_apiURL;
            
            $this->_fileHandler->write(json_encode($data));
            
            return $data;
        }

        return json_decode($this->_fileHandler->read(), true);
    }

}
