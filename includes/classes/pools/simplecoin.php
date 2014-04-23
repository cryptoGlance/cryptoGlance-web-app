<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Pools_Simplecoin extends Pools_Abstract {

    // Pool Information
    protected $_apiKey;
    
    public function __construct($params) {
        parent::__construct($params);
        $this->_apiKey = $params['apikey'];
        $this->_fileHandler = new FileHandler('pools/simplevert/'. $params['apikey'] .'.json');
    }

    public function update() {
        if ($CACHED == false || $this->_fileHandler->lastTimeModified() >= 60) { // updates every minute
            $poolData = array();
            $curl = curl_init($this->_apiURL  . '/api/'. $this->_apiKey);
            
            curl_setopt($curl, CURLOPT_FAILONERROR, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSLVERSION, 3);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; cryptoGlance ' . CURRENT_VERSION . '; PHP/' . phpversion() . ')');
            
            $poolData = array();
            $poolData = json_decode(curl_exec($curl), true);
            curl_close($curl);
                
            // Math Stuffs
            $units = array('KH', 'MH', 'GH', 'TH'); 
            $units2 = array('MH', 'GH', 'TH'); 
            
            // Data Order
            $data['type'] = 'simplevert';
            
            $data['total_paid'] = (!empty($poolData['total_paid']) ? $poolData['total_paid']/100000000 : 0);
            
            $data['balance'] = (!empty($poolData['balance']) ? $poolData['balance']/100000000 : 0);
            $data['unconfirmed_balance'] = (!empty($poolData['unconfirmed_balance']) ? $poolData['unconfirmed_balance']/100000000 : 0);
            $data['estimated_round_payout'] = (!empty($poolData['est_round_payout']) ? number_format($poolData['est_round_payout'], 8) : 0);

            $data['user_hashrate'] = $poolData['last_10_hashrate'];
            $pow = min(floor(($poolData['last_10_hashrate'] ? log($poolData['last_10_hashrate']) : 0) / log(1024)), count($units2) - 1);
            $poolData['last_10_hashrate'] /= pow(1024, $pow);
            $data['user_hashrate'] = round($poolData['last_10_hashrate'], 2) . ' ' . $units2[$pow] . '/s';

            $data['accepted'] = 0;
            $data['rejected'] = 0;
            $data['efficiency'] = 0;
            $data['active_worker(s)'] = 0;
            foreach ($poolData['workers'] as $worker) {
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
            
            $this->_fileHandler->write(json_encode($data));
            return $data;
        }
        
        return json_decode($this->_fileHandler->read(), true);
    }

}
