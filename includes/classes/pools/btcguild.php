<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Pools_Btcguild extends Pools_Abstract {

    // Pool Information
    protected $_apiKey; // 7d717abbe83e8304e83c2691d800f144

    public function __construct($params) {
        parent::__construct(array('apiurl' => 'https://www.btcguild.com')); // /api.php?api_key=
        $this->_apiKey = $params['apikey'];
        $this->_fileHandler = new FileHandler('pools/btcguild/'. $params['address'] .'.json');
    }

    public function update() {
        if ($CACHED == false || $this->_fileHandler->lastTimeModified() >= 60) { // updates every minute
            $curl = curl_init($this->_apiURL  . '/api.php?api_key='. $this->_apiKey);
            
            curl_setopt($curl, CURLOPT_FAILONERROR, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSLVERSION, 3);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; cryptoGlance ' . CURRENT_VERSION . '; PHP/' . phpversion() . ')');
            
            $poolData = json_decode(curl_exec($curl), true);
            curl_close($curl);
            
            // Math Stuffs
            $units = array('MH', 'GH', 'TH');
            $units2 = array('GH', 'TH');
            
            // Data Order
            $data['type'] = 'btcguild';

            // Pool Speed
            $pow = min(floor(($poolData['pool']['pool_speed'] ? log($poolData['pool']['pool_speed']) : 0) / log(1024)), count($units) - 1);
            $poolData['pool']['pool_speed'] /= pow(1024, $pow);
            $data['pool_hashrate'] = round($poolData['pool']['pool_speed'], 2) . ' ' . $units[$pow] . '/s';
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
            
            $data['active_workers'] = count($poolData['workers']);
            
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