<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Pools_Antpool extends Pools_Abstract {

    // Pool Information
    protected $_apiKey;
    protected $_apiSecret;
    protected $_userId;
    protected $_type = 'antpool';

    // api calls to make
    protected $_actions = array(
        'poolStats',
        'account',
        'hashrate',
        // 'workers',
        // 'paymentHistory',
    );

    public function __construct($params) {
        parent::__construct(array('apiurl' => 'https://antpool.com'));
        $this->_apiKey = $params['apikey'];
        $this->_apiSecret = $params['apisecret'];
        $this->_userId = $params['userid'];
        $this->_fileHandler = new FileHandler('pools/' . $this->_type . '/'. $this->_type . '/' . hash('md4', $params['apikey']) .'.json');
    }

    public function update() {
        if ($GLOBALS['cached'] == false || $this->_fileHandler->lastTimeModified() >= 30) { // updates every 30 seconds
            $poolData = array();
            foreach ($this->_actions as $action) {
                $nonce = number_format((time()*mt_rand()), 0, '', '');
                $hmacSig = strtoupper(hash_hmac(
                    'sha256',
                    ($this->_userId.$this->_apiKey.$nonce),
                    $this->_apiSecret
                ));

                $postParams = http_build_query(array(
                    'key' => $this->_apiKey,
                    'nonce' => $nonce,
                    'signature' => $hmacSig
                ));

                $poolData[$action] = curlCall(
                    $this->_apiURL  . '/api/'.$action.'.htm',
                    $postParams,
                    'application/x-www-form-urlencoded',
                    array(
                        'key' => $this->_apiKey,
                        'sig' => $hmacSig
                    )
                );
                $poolData[$action] = $poolData[$action]['data'];
            }

            // Offline Check
            if (empty($poolData[$this->_actions[0]])) {
                return;
            }

            // Data Order
            $data['type'] = $this->_type;

            $data['sent'] = number_format($poolData['account']['paidOut'], 8);
            $data['balance'] = number_format($poolData['account']['balance'], 8);
            $data['current_earnings'] = number_format($poolData['account']['earnTotal'], 8);

            $data['pool_hashrate'] = formatHashrate($poolData['poolStats']['poolHashrate']*1000);

            // User Hashrate
            $data['user_hashrate_(1_day)'] = formatHashrate($poolData['hashrate']['last1d']*1000);
            $data['user_hashrate_(1_hour)'] = formatHashrate($poolData['hashrate']['last1h']*1000);
            $data['user_hashrate_(10_minutes)'] = formatHashrate($poolData['hashrate']['last10m']*1000);

            $data['eta_on_block'] = formatTimeElapsed($poolData['poolStats']['estimateTime']);

            $data['url'] = $this->_apiURL;

            $this->_fileHandler->write(json_encode($data));
            return $data;
        }

        return json_decode($this->_fileHandler->read(), true);
    }

}
