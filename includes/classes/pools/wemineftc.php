<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Pools_Wemineftc extends Pools_Abstract {

    // Pool Information
    protected $_apiKey; // 7d717abbe83e8304e83c2691d800f144

    public function __construct($params) {
        parent::__construct(array('apiurl' => 'https://wemineftc.com')); // /pool/api-ftc?api_key=
        $this->_apiKey = $params['apikey'];
        $this->_fileHandler = new FileHandler('pools/wemineftc/'. $params['address'] .'.json');
    }

    public function update() {
        if ($CACHED == false || $this->_fileHandler->lastTimeModified() >= 60) { // updates every minute
            $user_curl = curl_init($this->_apiURL  . '/api?api_key='. $this->_apiKey);
            curl_setopt($user_curl, CURLOPT_FAILONERROR, true);
            curl_setopt($user_curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($user_curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($user_curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($user_curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($user_curl, CURLOPT_SSLVERSION, 3);
            curl_setopt($user_curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($user_curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; cryptoGlance ' . CURRENT_VERSION . '; PHP/' . phpversion() . ')');
            
            //$poolData = json_decode(curl_exec($pool_curl), true);
            $userData = json_decode(curl_exec($user_curl), true);
            curl_close($user_curl);
            //curl_close($pool_curl);
            
            // Math Stuffs
            $units = array('MH', 'GH', 'TH');
            $units2 = array('GH', 'TH');
            
            // Data Order
            $data['type'] = 'wemineftc';

            // Pool Speed
            //$pow = min(floor(($poolData['pool']['pool_speed'] ? log($poolData['pool']['pool_speed']) : 0) / log(1000)), count($units) - 1);
            //$poolData['pool']['pool_speed'] /= pow(1000, $pow);
            $data['total_hashrate'] = $userData['total_hashrate'] . ' KHS';
            // FTC Payout            
            $data['total_payout'] = $userData['payout_history'];
            $data['confirmed'] = $userData['confirmed_rewards'];
            $data['unconfirmed'] = $userData['round_estimate'];
            $data['active_workers'] = count($userData['workers']);
            // Pool Stats
            //$data['pool_hashrate'] = $poolData['hashrate'];
            //$data['pool_difficulty'] = $poolData['difficulty'];

            foreach ($userData['workers'] as $worker) {
                $data['user_hashrate'] += $worker['hashrate'];
                
                // BTC
                //$data['valid_BTC_shares'] += $worker['valid_shares'];
                //$data['stale_BTC_shares'] += $worker['stale_shares'];
                //$data['duplicate_BTC_shares'] += $worker['duplicate_shares'];
                //$data['unknown_BTC_shares'] += $worker['unknown_shares'];
                
                // NMC
                //$data['valid_NMC_shares'] += $worker['valid_shares_nmc'];
                //$data['stale_NMC_shares'] += $worker['stale_shares_nmc'];
                //$data['duplicate_NMC_shares'] += $worker['duplicate_shares_nmc'];
                //$data['unknown_NMC_shares'] += $worker['unknown_shares_nmc'];
            }
            
            
            // Clear data if it's missing
            foreach ($data as $key => $value) {
                if ($value == 0) {
                    unset($data[$key]);
                }
            }

            $this->_fileHandler->write(json_encode($data));
            return $data;
        }
        
        return json_decode($this->_fileHandler->read(), true);
    }

}
