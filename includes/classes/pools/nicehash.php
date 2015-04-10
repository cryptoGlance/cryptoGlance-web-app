<?php
require_once('abstract.php');
/*
 * @author Don Steele
 * Misc changes made by Stoyvo
 */
class Pools_Nicehash extends Pools_Abstract {

    // Pool Information
    protected $_btcaddess;
    protected $_type = 'nicehash';

    public function __construct($params) {
        parent::__construct($params);
        $this->_btcaddess = $params['address'];
        $this->_fileHandler = new FileHandler('pools/' . $this->_type . '/'. hash('md4', $params['address']) .'.json');
    }

    function getAlgo($algoId) {
        /*
          according to https://nicehash.com/?p=api
          values are

            0 = Scrypt
            1 = SHA256
            2 = Scrypt-A.-Nf.
            3 = X11
            4 = X13
            5 = Keccak
            6 = X15
            7 = Nist5
            8 = NeoScrypt
            9 = Lyra2RE
            100 = Multi-algorithm (only valid for global statistics)
        */
        $algoTypes = array (
            0 => 'Scrypt',
            1 => 'SHA256',
            2 => 'Scrypt-A.-Nf.',
            3 => 'X11',
            4 => 'X13',
            5 => 'Keccak',
            6 => 'X15',
            7 => 'Nist5',
            8 => 'NeoScrypt',
            9 => 'Lyra2RE',
            100=>'Multi-algorithm'
        );
        if (array_key_exists($algoId, $algoTypes)) {
            return $algoTypes[$algoId];
        } else {
            return "Undefined";
        }
    }

    public function update() {
        if ($CACHED == false || $this->_fileHandler->lastTimeModified() >= 30) { // updates every 30 seconds
            $poolData = array();
            $poolData['user'] = curlCall($this->_apiURL  . '/api?method=stats.provider&addr='. $this->_btcaddess);
            $poolData['global'] = curlCall($this->_apiURL  . '/api?method=stats.global.current');


            // Offline Check
            if (empty($poolData['user']) || empty($poolData['global'])) {
                return;
            }

            $algoNetSpeed = array();
            foreach ($poolData['global']['result']['stats'] as $values) {
                $algoNetSpeed[$values['algo']] = $values['speed'];
            }

            $data = array();

            $data['type'] = $this->_type;

            $data['total_balance'] = 0;

            foreach ($poolData['user']['result']['stats'] as $stats => $values) {
                if ($values['accepted_speed'] > 0 || $values['balance'] > 0.00000000) {
                    $algo = $this->getAlgo($values['algo']);
                    $data['total_balance'] += $values['balance'];
                    $data[$algo.'_balance'] = $values['balance'] . ' BTC';
                    $data[$algo.'_accepted'] = formatHashrate($values['accepted_speed'] * 1000000);
                    $data[$algo.'_rejected'] = formatHashrate($values['rejected_speed'] * 1000000);
                    $data[$algo.'_network_speed'] = formatHashrate($algoNetSpeed[$values['algo']] * 1000000);
                }
            }

            $data['total_balance'] = number_format($data['total_balance'], 8) . ' BTC';

            $data['address'] = $this->_btcaddess;

            $data['url'] = $this->_apiURL;

            $this->_fileHandler->write(json_encode($data));

            return $data;
        }

        return json_decode( $this->_fileHandler->read(), true );
    }

}
