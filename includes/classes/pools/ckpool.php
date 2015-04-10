<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Pools_Ckpool extends Pools_Abstract {

    // Pool Information
    protected $_apiKey;
    protected $_userId;
    protected $_type = 'ckpool';

    public function __construct($params) {
        parent::__construct($params);
        $this->_apiKey = $params['apikey'];
        $this->_userId = $params['userid'];
        $this->_fileHandler = new FileHandler('pools/' . $this->_type . '/'. hash('md4', $params['apikey']) .'.json');
    }

    public function update() {
        if ($GLOBALS['cached'] == false || $this->_fileHandler->lastTimeModified() >= 30) { // updates every 30 seconds
            $poolData = array();
            $poolData['user'] = curlCall($this->_apiURL  . '/index.php?k=api&json=y&username='.$this->_userId.'&api='.$this->_apiKey);
            $poolData['workers'] = curlCall($this->_apiURL  . '/index.php?k=api&json=y&work=y&username='.$this->_userId.'&api='.$this->_apiKey);

            // Offline Check
            if (empty($poolData['user']) || empty($poolData['workers'])) {
                return;
            }

            // Data Order
            $data['type'] = $this->_type;

            $data['user_hashrate'] = formatHashrate($poolData['user']['u_hashrate5m']/1000);
            $data['pool_hashrate'] = formatHashrate($poolData['user']['p_hashrate5m']/1000);

            for ($i=0; $poolData['workers']['rows'] > $i; $i++) {
                $data[$poolData['workers']['workername:'.$i]] = formatHashrate($poolData['workers']['w_hashrate5m:'.$i]/1000);
            }
            $data['workers'] = $poolData['workers']['rows'];

            $data['round_duration'] = formatTimeElapsed(time() - $poolData['user']['lastblock']);

            $data['url'] = $this->_apiURL;

            $this->_fileHandler->write(json_encode($data));
            return $data;
        }

        return json_decode($this->_fileHandler->read(), true);
    }

}
