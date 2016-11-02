<?php
require_once('abstract.php');
/*
 * @author Don Steele
 * Misc changes made by Stoyvo
 */
class Pools_Slush extends Pools_Abstract {

    // Pool Information
    protected $_apiKey;
    protected $_type = 'slush';

    public function __construct($params) {
        parent::__construct(array('apiurl' => 'https://slushpool.com'));
        $this->_apiKey = $params['apikey'];
        $this->_fileHandler = new FileHandler('pools/' . $this->_type . '/'. hash('md4', $params['apikey']) .'.json');
    }

    public function update() {
        if ($CACHED == false || $this->_fileHandler->lastTimeModified() >= 30) { // updates every 30 seconds
            $poolData = array();
            $poolData['global'] = curlCall($this->_apiURL  . '/stats/json/'. $this->_apiKey);
            $poolData['user'] = curlCall($this->_apiURL  . '/accounts/profile/json/'. $this->_apiKey);

            // Offline Check
            if (empty($poolData['global']) || empty($poolData['user'])) {
                return;
            }

            $data = array();

            $data['type'] = $this->_type;

            $data['confirmed_balance'] = $poolData['user']['confirmed_reward'];
            $data['unconfirmed_balance'] = $poolData['user']['unconfirmed_reward'];
            $data['estimated_balance'] = $poolData['user']['estimated_reward'];

            $data['pool_hashrate'] = formatHashrate($poolData['global']['ghashes_ps']*1000000);
            $data['user_hashrate'] = formatHashrate($poolData['user']['hashrate']*1000);

            $data['workers'] = count($poolData['user']['workers']);

            $roundDuration = 0;
            $roundDurationVal = explode(':', $poolData['global']['round_duration']);
            $roundDuration += intval($roundDurationVal[0] * 60 * 60);
            $roundDuration += intval($roundDurationVal[1] * 60);
            $roundDuration += intval($roundDurationVal[2]);
            $data['round_duration'] = formatTimeElapsed($roundDuration);

            $data['username'] = $poolData['user']['username'];

            $data['url'] = $this->_apiURL;

            $this->_fileHandler->write(json_encode($data));

            return $data;
        }

        return json_decode( $this->_fileHandler->read(), true );
    }

}
