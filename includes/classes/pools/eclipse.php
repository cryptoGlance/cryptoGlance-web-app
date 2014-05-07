<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Pools_Eclipse extends Pools_Abstract {

    // Pool Information
    protected $_apiKey;
    
    // api calls to make
    protected $_actions = array(
        'poolstats',
        'userstats',
    );
    
    public function __construct($params) {
        parent::__construct(array('apiurl' => 'https://eclipsemc.com'));
        // https://eclipsemc.com
        $this->_apiKey = $params['apikey'];
        $this->_fileHandler = new FileHandler('pools/eclipse/'. $params['apikey'] .'.json');
    }

    public function update() {
        if ($CACHED == false || $this->_fileHandler->lastTimeModified() >= 60) { // updates every minute
            $poolData = array();
            foreach ($this->_actions as $action) {
                $curl = curl_init($this->_apiURL  . '/api.php?key='.$this->_apiKey.'&action='. $action);
                
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
            $data['type'] = 'eclipse';
            
            $data['total_sent'] = $poolData['userstats']['data']['user']['total_payout'];
            $data['balance'] = $poolData['userstats']['data']['user']['confirmed_rewards'];
            $data['unconfirmed_balance'] = $poolData['userstats']['data']['user']['unconfirmed_rewards'];
            $data['estimated_rewards'] = $poolData['userstats']['data']['user']['estimated_rewards'];
            
            $data['pool_hashrate'] = $poolData['poolstats']['hashrate'];
            $data['user_hashrate'] = '---';
            
            $data['pool_workers'] = $poolData['poolstats']['active_workers'];
            
            // how to get active user workers and total hashrate?
            
            $data['time_since_last_block'] = gmdate('H\H i\M s\S', strtotime('t'.$poolData['poolstats']['round_duration'])); // how to format? 00:52:44
            
            $data['url'] = $this->_apiURL;
            
            $this->_fileHandler->write(json_encode($data));
            return $data;
        }
        
        return json_decode($this->_fileHandler->read(), true);
    }

}
