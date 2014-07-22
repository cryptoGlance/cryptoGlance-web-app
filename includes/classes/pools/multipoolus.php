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

            $data = array();
            $data['total_hash_rate'] = 0 ;


            foreach ($poolData['currency'] as $coin => $values) {
                if (!$values['round_shares'] === false) {
                    $data[$coin.'_reward'] = $values['estimated_rewards'];
                    $data[$coin.'_hashrate'] =  formatHashrate($values['hashrate']);
                    $data['total_hash_rate'] = $data['total_hash_rate'] + $values['hashrate'];
                }
            }
            $data['total_hash_rate'] = formatHashrate($data['total_hash_rate']);

            // Clear data if it's missing
            foreach ( $data as $key => $value ) {
                if ( $value == 0 ) {
                    unset( $data[$key] );
                }
            }

            $this->_fileHandler->write(json_encode($data));
            
            return $data;
        }

        return json_decode($this->_fileHandler->read(), true);
    }

}
