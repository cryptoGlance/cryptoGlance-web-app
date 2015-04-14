<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Pools_Eligius extends Pools_Abstract {

    // Pool Information
    protected $_btcaddess;
    protected $_type = 'eligius';

    // api calls to make
    protected $_actions = array(
        'getuserstat',
        'gethashrate',
        'getuserhashrate', // this is custom... Pool and user hashrate are the same cmd, except user stats need btc address
        'livedata', // This is a different URL
    );

    public function __construct($params) {
        parent::__construct(array('apiurl' => 'http://eligius.st/~wizkid057/newstats'));
        $this->_btcaddess = $params['address'];
        $this->_fileHandler = new FileHandler('pools/' . $this->_type . '/'. hash('md4', $params['address']) .'.json');
    }

    public function update() {
        if ($GLOBALS['cached'] == false || $this->_fileHandler->lastTimeModified() >= 30) { // updates every 30 seconds
            $poolData = array();
            foreach ($this->_actions as $action) {
                if ($action == 'livedata') {
                    $poolData[$action] = curlCall($this->_apiURL  . '/instant.php/livedata.json');
                    continue;
                }

                $actionParam = $action;
                if ($action == 'getuserhashrate' || $action == 'getuserstat') {
                    if ($action == 'getuserhashrate') {
                        $actionParam = 'gethashrate';
                    }
                    $actionParam .= '&username=' . $this->_btcaddess;
                }
                $poolData[$action] = curlCall($this->_apiURL  . '/api.php?cmd='.$actionParam);
            }

            // Offline Check
            if (empty($poolData[$this->_actions[0]])) {
                return;
            }

            // Data Order
            $data['type'] = $this->_type;

            $data['sent'] = number_format($poolData['getuserstat']['output']['everpaid']*0.00000001, 8);
            $data['balance'] = number_format($poolData['getuserstat']['output']['lbal']*0.00000001, 8);
            $data['unconfirmed_balance'] = number_format(($poolData['getuserstat']['output']['bal'] - $poolData['getuserstat']['output']['lbal'])*0.00000001, 8);
            $data['total_balance'] = number_format($data['balance']+$data['unconfirmed_balance'], 8);

            $data['pool_hashrate_(64 seconds)'] = $poolData['gethashrate']['output']['av64']['pretty'];

            $data['user_hashrate_(3_hours)'] = $poolData['getuserhashrate']['output']['av10800']['pretty'];
            $data['user_hashrate_(22.5_minutes)'] = $poolData['getuserhashrate']['output']['av1350']['pretty'];
            $data['user_hashrate_(128_seconds)'] = $poolData['getuserhashrate']['output']['av128']['pretty'];

            $data['round_duration'] = formatTimeElapsed($poolData['livedata']['roundduration']);
            $data['round_luck'] = round(round(($poolData['livedata']['network_difficulty']*1000) / $poolData['livedata']['roundsharecount'], 2) / 10, 2).'%';

            $data['last_block'] = $poolData['livedata']['lastblockheight'];
            $data['last_block_url'] = $this->_apiURL  . '/blocks.php';

            $data['url_name'] = 'http://eligius.st';
            $data['url'] = $this->_apiURL . '/userstats.php/' . $this->_btcaddess;

            $this->_fileHandler->write(json_encode($data));
            return $data;
        }

        return json_decode($this->_fileHandler->read(), true);
    }

}
