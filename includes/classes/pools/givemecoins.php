<?php
require_once('abstract.php');
/*
 * @author Blonďák
 */
class Pools_GiveMeCoins extends Pools_Abstract {
	
	// Pool Information
	protected $_type = 'give-me-coins';
	
	public function __construct($params) {
		parent::__construct($params);
		$this->_fileHandler = new FileHandler('pools/' . $this->_type . '/'. hash('md4', $this->_apiURL) .'.json');
	}
	
	public function update() {
		if (true || GLOBALS['cached'] == false || $this->_fileHandler->lastTimeModified() >= 30) {
			$poolData = curlCall($this->_apiURL);
	
			if (empty($poolData)) {
				return;
			}
	
			$data['type'] = $this->_type;
			$data['user_hashrate'] = formatHashrate($poolData['total_hashrate']/1000);
			$data['username'] = $poolData['username'];
			
			$data['confirmed_balance'] = $poolData['confirmed_rewards'];
			$data['estimated_balance'] = $poolData['round_estimate'];
			$data['payout_history'] = $poolData['payout_history'];
			$data['round_shares'] = $poolData['round_shares'];
				
			$data['workers'] = 0;
			foreach ($poolData['workers'] as $worker => $wd){
				if ($wd['alive']){
					$data[$worker] = formatHashrate($wd['hashrate']);
					$data['workers'] += $wd['alive'];
				}
			}
			$data['url'] = preg_replace('/[^\/]*$/', '', $this->_apiURL);
	
			$this->_fileHandler->write(json_encode($data));
			return $data;
		}
	
		return json_decode($this->_fileHandler->read(), true);
	}
	
}