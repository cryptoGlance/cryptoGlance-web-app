<?php
require_once('abstract.php');
/*
 * @author Stoyvo
 */
class Pools_Ghash extends Pools_Abstract {

    // Pool Information
    protected $_apiKey;
    protected $_apiSecret;
    protected $_userId;
    protected $_type = 'ghash';
    protected $_nonce;

    // api calls to make
    protected $_actions = array(
        'balance' => 'balance',
        'hashrate' => 'ghash.io/hashrate',
        'workers' => 'ghash.io/workers',
    );

    public function __construct($params) {
        parent::__construct(array('apiurl' => 'https://cex.io'));
        $this->_apiKey = $params['apikey'];
        $this->_apiSecret = $params['apisecret'];
        $this->_userId = $params['userid'];
        $this->_nonce = time()+100;
        $this->_fileHandler = new FileHandler('pools/' . $this->_type . '/'. $this->_type . '/' . hash('md4', $params['apikey']) .'.json');
    }

    public function update() {
        if ($GLOBALS['cached'] == false || $this->_fileHandler->lastTimeModified() >= 30) { // updates every 30 seconds
            $poolData = array();
            foreach ($this->_actions as $actionKey => $action) {
                $this->_nonce++;
                $hmacSig = strtoupper(hash_hmac(
                    'sha256',
                    ($this->_nonce . $this->_userId . $this->_apiKey),
                    $this->_apiSecret
                ));

                $postParams = http_build_query(array(
                    'key' => $this->_apiKey,
                    'signature' => $hmacSig,
                    'nonce' => $this->_nonce,
                ));

                $poolData[$actionKey] = curlCall(
                    $this->_apiURL  . '/api/'.$action,
                    $postParams,
                    'application/x-www-form-urlencoded',
                    array(
                        'key' => $this->_apiKey,
                        'sig' => $hmacSig
                    )
                );
            }

            // Offline Check
            if (empty($poolData['hashrate'])) {
                return;
            }

            // Data Order
            $data['type'] = $this->_type;

            foreach ($poolData['balance'] as $coin => $balance) {
                if (!is_array($balance)) {
                    continue;
                } else if (!empty($balance['available'])) {
                    $data[$coin.'_available'] = number_format($balance['available'], 8);
                } else if (!empty($balance['orders'])) {
                    $data[$coin.'_orders'] = number_format($balance['orders'], 8);
                }
            }

            // $data['pool_hashrate'] = formatHashrate($poolData['poolStats']['poolHashrate']*1000); // Doesn't exist

            // User Hashrate
            $data['user_hashrate_(1_day)'] = formatHashrate($poolData['hashrate']['last1d']*1000);
            $data['user_hashrate_(1_hour)'] = formatHashrate($poolData['hashrate']['last1h']*1000);
            $data['user_hashrate_(15_minutes)'] = formatHashrate($poolData['hashrate']['last15m']*1000);

            $data['workers'] = count($poolData['workers']);

            $data['url'] = $this->_apiURL;

            $this->_fileHandler->write(json_encode($data));
            return $data;
        }

        return json_decode($this->_fileHandler->read(), true);
    }

}
