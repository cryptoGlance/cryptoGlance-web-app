<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Pools_Givemecoins extends Pools_Abstract {

    // Pool Information
    protected $_apiKey; // 7d717abbe83e8304e83c2691d800f144

    public function __construct($params) {
        parent::__construct(array('apiurl' => 'https://give-me-coins.com')); // /api.php?api_key=
        $this->_apiKey = $params['apikey'];
        $this->_poolType = $params['pooltype'];
        $this->_coinType = $params['cointype'];
        $this->_fileHandler = new FileHandler('pools/givemecoins/'. $params['address'] .'.json');
    }

    public function update() {
        switch ($coinType) {
            case "LTC":
                $apiURI ="/pool/api-ltc"; 
                break;
            case "uLTC":
                $apiURI ="/pool/api-ultc"; 
                break;
            case "FTC":
                $apiURI ="/pool/api-ftc"; 
                break;
            case "PTC":
                $apiURI ="/pool/api-ptc"; 
                break;
            case "VTC":
                $apiURI ="/pool/api-vtc"; 
                break;
            case "MON":
                $apiURI ="/pool/api-mon"; 
                break;
            case "PLX":
                $apiURI ="/pool/api-plx"; 
                break;
            case "PPC":
                $apiURI ="/pool/api-ppc"; 
                break;
        }

        if ($CACHED == false || $this->_fileHandler->lastTimeModified() >= 60) { // updates every minute
            $userCurl = curl_init($this->_apiURL  . $this->_apiUri . '?api_key='. $this->_apiKey);
            $poolCurl = curl_init($this->_apiURL  . $this->_apiUri);
            
            $curlOptions = array(CURLOPT_FAILONERROR => true,
                                 CURLOPT_FOLLOWLOCATION => true,
                                 CURLOPT_RETURNTRANSFER => true,
                                 CURLOPT_SSL_VERIFYHOST => false,
                                 CURLOPT_SSL_VERIFYPEER => false,
                                 CURLOPT_SSLVERSION => 3,
                                 CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
                                 CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; cryptoGlance ' . CURRENT_VERSION . '; PHP/' . phpversion() . ')');

            curl_setopt_array($userCurl, $curlOptions);
            curl_setopt_array($poolCurl, $curlOptions);
            
            $userData = json_decode(curl_exec($userCurl), true);
            $poolData = json_decode(curl_exec($poolCurl), true);

            curl_close($userCurl);
            curl_close($poolCurl);
            
            // Data Order
            $data['type'] = 'givemecoins';

            // Pool Speed
            $data['pool_hashrate'] = $poolData['hashrate'];
            $data['user_hashrate'] = $userData['total_hashrate'];
            
            // GMC Payout            
            $data['total_payout'] = $userData['payout_history'];
            $data['paid_'.$coinType] = $userData['confirmed_rewards'];
            $data['unpaid_'.$coinType] = $userData['round_estimate'];
            $data[$coinType.'_difficulty'] = $poolData['difficulty'];
            $data['round_shares'] = $userData['round_shares'];
                        
            $liveWorkers = 0;
            foreach ($userData['workers'] as $worker) {
                $data['worker_hashrate'] += $worker['hashrate'];
                if ($worker['alive'] == 1 ){
                    $liveWorkers++; 
                }
            }
            
            $data['active_workers'] = $liveWorkers;
            
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
