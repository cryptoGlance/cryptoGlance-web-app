<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Pools_MagicPool extends Pools_Abstract {

    // Pool Information
    protected $_btcaddess;
    protected $_type = 'magicpool';

    public function __construct($params) {
        parent::__construct(array('apiurl' => 'https://magicpool.org'));
        $this->_btcaddess = $params['address'];
        $this->_fileHandler = new FileHandler('pools/' . $this->_type . '/'. hash('md4', $params['address']) .'.json');
    }

    public function update() {
        if ($GLOBALS['cached'] == false || $this->_fileHandler->lastTimeModified() >= 30) { // updates every 30 seconds
            $poolData['pool'] = curlCall($this->_apiURL  . '/api.php');
            $poolData['user'] = curlCall($this->_apiURL  . '/api.php?user='.$this->_btcaddess);

            // Offline Check
            if (empty($poolData['pool']) || empty($poolData['user'])) {
                return;
            }

            // Data Order
            $data['type'] = $this->_type;

            $data['total_paid'] = number_format($poolData['user']['totalPaid'], 8);
            $data['balance'] = number_format($poolData['user']['pending'], 8);

            $data['profitability_(BTC/MHs/day)'] = number_format($poolData['user']['lastProf'], 8);

            $data['pool_hashrate'] = formatHashrate($poolData['pool']['poolhashrate']*1000);
            $data['user_hashrate'] = formatHashrate($poolData['user']['hashrate']*1000);

            $data['url'] = $this->_apiURL;

            $this->_fileHandler->write(json_encode($data));

            return $data;
        }

        return json_decode($this->_fileHandler->read(), true);
    }

}
