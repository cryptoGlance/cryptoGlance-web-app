<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Pools_Burstninja extends Pools_Abstract {

    // Pool Information
    protected $_userId;
    protected $_type = 'burstninja';

    public function __construct($params) {
        parent::__construct(array('apiurl' => 'http://burst.ninja/webAPI/pool'));
        $this->_userId = $params['userid'];
        $this->_fileHandler = new FileHandler('pools/' . $this->_type . '/'. hash('md4', $params['userid']) .'.json');
    }

    public function update() {
        if ($GLOBALS['cached'] == false || $this->_fileHandler->lastTimeModified() >= 30) { // updates every 30 seconds
            $poolData = array();
            $poolData = curlCall($this->_apiURL  . '?accountId='.$this->_userId);

            // Offline Check
            if (empty($poolData)) {
                return;
            }

            // Data Order
            $data['type'] = $this->_type;

            $data['sent'] = $poolData['miner']['totalEarned'];
            $data['unconfirmed_balance'] = $poolData['miner']['unconfirmedPayouts'];

            $data['user_capacity'] = formatCapacity($poolData['miner']['estimatedCapacity']*1000000);
            $data['pool_capacity'] = formatCapacity($poolData['pool']['estimatedCapacity']*1000000);
            $data['pool_miners'] = $poolData['pool']['totalMiners'];

            $data['current_block'] = $poolData['current']['block'];
            $data['nonces_submitted'] = $poolData['current']['noncesSubmitted'];
            $data['best_deadline'] = formatTimeElapsed($poolData['current']['bestDeadline']);
            $data['round_duration'] = formatTimeElapsed(time()-$poolData['current']['timeBlockStarted']);
            $data['pool_blocks_won'] = $poolData['pool']['blocksWon'];

            $data['url'] = "http://burst.ninja";

            $this->_fileHandler->write(json_encode($data));
            return $data;
        }

        return json_decode($this->_fileHandler->read(), true);
    }

}
