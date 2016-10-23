<?php
require_once('abstract.php');
/*
 * @author Blonďák
 */
class Pools_GiveMeCoins extends Pools_Abstract {
	
	// Pool Information
	protected $_type = 'give-me-coins';
	protected $_overalDataUrl;
	
	public function __construct($params) {
		parent::__construct($params);
		$this->_fileHandler = new FileHandler('pools/' . $this->_type . '/'. hash('md4', $this->_apiURL) .'.json');
		$this->_overalDataUrl = preg_replace('/[^?]*$/', '', $this->_apiURL);
	}
	
	public function update() {
		if (GLOBALS['cached'] == false || $this->_fileHandler->lastTimeModified() >= 30) {
			$poolData = curlCall($this->_apiURL);
			$overalData = curlCall($this->_overalDataUrl);
	
			if (empty($poolData)) {
				return;
			}
	
			$data['type'] = $this->_type;
			$data['user_hashrate'] = formatHashrate($poolData['total_hashrate']/1000);
			$data['username'] = $poolData['username'];
			
			$data['confirmed_balance'] = $poolData['confirmed_rewards'];
			$data['estimated_balance'] = $poolData['round_estimate'];
			$data['payout_history'] = $poolData['payout_history'];
				
			$data['pool_hashrate'] = formatHashrate($overalData['hashrate']/1000);
			$data['pool_workers'] = $overalData['workers'];
			$data['network_hashrate'] = formatHashrate($overalData['netGhps'] * 1000000);
			$data['last_block_reward'] = $overalData['last_block_reward'];
			$data['difficulty'] = $overalData['difficulty'];
			$data['shares_this_round'] = $overalData['shares_this_round'];
			
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