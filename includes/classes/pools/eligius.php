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
                $actionParam = $action;
                if ($action == 'getuserhashrate' || $action == 'getuserstat') {
                    if ($action == 'getuserhashrate') {
                        $actionParam = 'gethashrate';
                    }
                    $actionParam .= '&username=' . $this->_btcaddess;
                }
                $poolData[$action] = curlCall($this->_apiURL  . '/api.php?cmd='.$actionParam);
            }
            
            // Data Order
            $data['type'] = $this->_type;
            
            $data['sent'] = number_format($poolData['getuserstat']['output']['everpaid']*0.00000001, 8);
            $data['balance'] = number_format($poolData['getuserstat']['output']['lbal']*0.00000001, 8);
            $data['unconfirmed_balance'] = number_format(($poolData['getuserstat']['output']['bal'] - $poolData['getuserstat']['output']['lbal'])*0.00000001, 8);
            
            $data['pool hashrate (64 seconds)'] = $poolData['gethashrate']['output']['av64']['pretty'];
            
            $data['user hashrate (3 hours)'] = $poolData['getuserhashrate']['output']['av10800']['pretty'];
            $data['user hashrate (22.5 minutes)'] = $poolData['getuserhashrate']['output']['av1350']['pretty'];
            $data['user hashrate (128 seconds)'] = $poolData['getuserhashrate']['output']['av128']['pretty'];
            
            $data['url'] = $this->_apiURL;
            
//            $this->_fileHandler->write(json_encode($data));
            return $data;
        }
        
        return json_decode($this->_fileHandler->read(), true);
    }

}
