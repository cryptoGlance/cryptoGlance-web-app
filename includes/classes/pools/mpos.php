<?php

/*
 * @author Stoyvo
 */
class Class_Pools_Mpos extends Class_Pools_Abstract {

    // Pool Information
    protected $_apiKey;
    protected $_userId;
    
    // api calls to make
    protected $_actions = array(
        'public',
        'getpoolstatus',
        'getblockstats',
        'getuserbalance',
        'getuserstatus',
    );

    public function __construct($params) {
        parent::__construct($params);
        $this->_apiKey = $params['apikey'];
        $this->_userId = $params['userid'];
        $this->_fileHandler = new Class_FileHandler('pools/mpos/'. $params['apikey'] .'.json');
    }

    public function update() {
        if ($CACHED == false || $this->_fileHandler->lastTimeModified() >= 60) { // updates every minute
            $poolData = array();
            foreach ($this->_actions as $action) {
                $curl = curl_init($this->_apiURL  . '/index.php?page=api&id='. $this->_userId .'&api_key='. $this->_apiKey . '&action=' . $action);
                
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
                
                if ($action == 'getpoolstatus') {
                    $poolData[$action] = $poolData[$action]['getpoolstatus']['data'];
                } else if ($action == 'getblockstats') {
                    $poolData[$action] = $poolData[$action]['getblockstats']['data'];
                } else if ($action == 'getuserbalance') {
                    $poolData[$action] = $poolData[$action]['getuserbalance']['data'];
                } else if ($action == 'getuserstatus') {
                    $poolData[$action] = $poolData[$action]['getuserstatus']['data'];
                }
            }
            
            // Math Stuffs
            $units = array('H', 'KH', 'MH', 'GH', 'TH'); 
            $units2 = array('KH', 'MH', 'GH', 'TH'); 
            
            // Data Order
            $data['type'] = 'mpos';
//            $data['pool_name'] = $poolData['public']['pool_name'];
            $data['balance'] = $poolData['getuserbalance']['confirmed'];
            $data['unconfirmed_balance'] = $poolData['getuserbalance']['unconfirmed'];
            
            $pow = min(floor(($poolData['getpoolstatus']['nethashrate'] ? log($poolData['getpoolstatus']['nethashrate']) : 0) / log(1024)), count($units) - 1);
            $poolData['getpoolstatus']['nethashrate'] /= pow(1024, $pow);
            $data['network_hashrate'] = round($poolData['getpoolstatus']['nethashrate'], 2) . ' ' . $units[$pow] . '/s';
            
            $pow = min(floor(($poolData['getpoolstatus']['hashrate'] ? log($poolData['getpoolstatus']['hashrate']) : 0) / log(1024)), count($units2) - 1);
            $poolData['getpoolstatus']['hashrate'] /= pow(1024, $pow);
            $data['pool_hashrate'] = round($poolData['getpoolstatus']['hashrate'], 2) . ' ' . $units2[$pow] . '/s';
            
            $pow = min(floor(($poolData['getuserstatus']['hashrate'] ? log($poolData['getuserstatus']['hashrate']) : 0) / log(1024)), count($units2) - 1);
            $poolData['getuserstatus']['hashrate'] /= pow(1024, $pow);
            $data['user_hashrate'] = round($poolData['getuserstatus']['hashrate'], 2) . ' ' . $units2[$pow] . '/s';
            
            $data['pool_workers'] = $poolData['getpoolstatus']['workers'];
            $data['efficiency'] = $poolData['getpoolstatus']['efficiency'] . '%';
            $data['accepted'] = $poolData['public']['shares_this_round'];
            $data['rejected'] = round($poolData['public']['shares_this_round'] - ($poolData['public']['shares_this_round'] * ($poolData['getpoolstatus']['efficiency']/100)));
            $data['difficulty'] = round($poolData['getpoolstatus']['networkdiff'], 5);
            
            if ($poolData['getpoolstatus']['timesincelast'] <= 86400) { // Less than a day
                $timeSinceLastBlock = gmdate('H\H i\M s\S', $poolData['getpoolstatus']['timesincelast']);
            } else if ($poolData['getpoolstatus']['timesincelast'] <= 604800) { // Less than a week
                $timeSinceLastBlock = gmdate('d\D H\H i\M', $poolData['getpoolstatus']['timesincelast']);
            }
            $data['time_since_last_block'] = $timeSinceLastBlock;
            $data['%_of_expected'] = round(($poolData['public']['shares_this_round'] / $poolData['getpoolstatus']['estshares']) * 100, 2) . '%';
            $data['current_block'] = $poolData['getpoolstatus']['currentnetworkblock'];
            $data['last_block'] = $poolData['getpoolstatus']['lastblock'];
            $data['blocks_pool_found'] = $poolData['getblockstats']['TotalValid'];
//            $data['next_(est.)_difficulty'] = $poolData['getblockstats']['getpoolstatus']['nextnetworkblock'];
            $data['url'] = $this->_apiURL;
            $data['username'] = $poolData['getuserstatus']['username'];
            
            $this->_fileHandler->write(json_encode($data));
            return $data;
        }
        
        return json_decode($this->_fileHandler->read(), true);
    }

}
