<?php

/*
 * @author Stoyvo
 */
class Class_Pools_Wafflepool extends Class_Pools_Abstract {

    // Pool Information
    protected $_btcaddess;

    public function __construct($params) {
        parent::__construct(array('apiurl' => 'http://wafflepool.com'));
        $this->_btcaddess = $params['address'];
        $this->_fileHandler = new Class_FileHandler('pools/wafflepool/'. $params['address'] .'.json');
    }

    public function update() {
        if ($CACHED == false || $this->_fileHandler->lastTimeModified() >= 60) { // updates every minute
            $curl = curl_init($this->_apiURL  . '/tmp_api?address='. $this->_btcaddess); // temporaary since 
            curl_setopt($curl, CURLOPT_FAILONERROR, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; RigWatch ' . CURRENT_VERSION . '; PHP/' . phpversion() . ')');
            $poolData = json_decode(curl_exec($curl), true);
            
            // Math Stuffs
            $units = array('H', 'KH', 'MH', 'GH', 'TH');
            $units2 = array('KH', 'MH', 'GH', 'TH');
            
            // Data Order
            $data['type'] = 'wafflepool';
            
//            $data['pool_name'] = $poolData['public']['pool_name'];
            $data['sent'] = $poolData['balances']['sent'];
            $data['balance'] = $poolData['balances']['confirmed'];
            $data['unconfirmed_balance'] = $poolData['balances']['unconverted'];
            
            $pow = min(floor(($poolData['hash_rate'] ? log($poolData['hash_rate']) : 0) / log(1024)), count($units) - 1);
            $poolData['hash_rate'] /= pow(1024, $pow);
            $data['hashrate'] = round($poolData['hash_rate'], 2) . ' ' . $units[$pow] . '/s';
            
            $activeWorkers = 0;
            foreach ($poolData['worker_hashrates'] as $worker) {
                if ($worker['hashrate'] != 0) {
                    $activeWorkers++;
                    continue;
                }
            }
            $data['active_worker(s)'] = $activeWorkers;
            
            $this->_fileHandler->write(json_encode($data));
            return $data;
        }
        
        return json_decode($this->_fileHandler->read(), true);
    }

}
