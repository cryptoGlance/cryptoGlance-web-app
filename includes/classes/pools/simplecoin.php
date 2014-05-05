<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Pools_Simplecoin extends Pools_Abstract {

    // Pool Information
    protected $_apiKey;
    
    // api calls to make
    protected $_actions = array(
        'pool_stats',
    );
    
    public function __construct($params) {
        parent::__construct($params);
        $this->_apiKey = $params['apikey'];
        $this->_actions[] = $this->_apiKey;
        $this->_fileHandler = new FileHandler('pools/simplecoin/'. $params['apikey'] .'.json');
    }

    public function update() {
        if ($CACHED == false || $this->_fileHandler->lastTimeModified() >= 60) { // updates every minute
            $poolData = array();
            foreach ($this->_actions as $action) {
                $curl = curl_init($this->_apiURL  . '/api/'. $action);
                
                curl_setopt($curl, CURLOPT_FAILONERROR, true);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSLVERSION, 3);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; cryptoGlance ' . CURRENT_VERSION . '; PHP/' . phpversion() . ')');
                
                $poolData[$action] = array();
                $poolData[$action] = json_decode(curl_exec($curl), true);
                curl_close($curl);
            }
                
            // Math Stuffs
            $units = array('KH', 'MH', 'GH', 'TH'); 
            $units2 = array('MH', 'GH', 'TH'); 
            
            // Data Order
            $data['type'] = 'simplevert';
            
            $data['total_paid'] = (!empty($poolData[$this->_apiKey]['total_paid']) ? $poolData[$this->_apiKey]['total_paid']/100000000 : 0);
            
            $data['balance'] = (!empty($poolData[$this->_apiKey]['balance']) ? $poolData[$this->_apiKey]['balance']/100000000 : 0);
            $data['unconfirmed_balance'] = (!empty($poolData[$this->_apiKey]['unconfirmed_balance']) ? $poolData[$this->_apiKey]['unconfirmed_balance']/100000000 : 0);
            $data['estimated_round_payout'] = (!empty($poolData[$this->_apiKey]['est_round_payout']) ? number_format($poolData[$this->_apiKey]['est_round_payout'], 8) : 0);
            
            $pow = min(floor(($poolData['pool_stats']['hashrate'] ? log($poolData['pool_stats']['hashrate']) : 0) / log(1024)), count($units) - 1);
            $poolData['pool_stats']['hashrate'] /= pow(1024, $pow);
            $data['pool_hashrate'] = round($poolData['pool_stats']['hashrate'], 2) . ' ' . $units[$pow] . '/s';

            $pow = min(floor(($poolData[$this->_apiKey]['last_10_hashrate'] ? log($poolData[$this->_apiKey]['last_10_hashrate']) : 0) / log(1024)), count($units2) - 1);
            $poolData[$this->_apiKey]['last_10_hashrate'] /= pow(1024, $pow);
            $data['user_hashrate'] = round($poolData[$this->_apiKey]['last_10_hashrate'], 2) . ' ' . $units2[$pow] . '/s';
            
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
