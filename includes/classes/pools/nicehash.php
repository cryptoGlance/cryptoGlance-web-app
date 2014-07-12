<?php
require_once 'abstract.php';
/*
 * @author Don Steele
 */
class Pools_Nicehash extends Pools_Abstract {

    // Pool Information
    protected $_btcaddess;

    public function __construct( $params ) {
        
        parent::__construct( array( 'apiurl' => 'https://www.nicehash.com/api' ) );
        $this->_btcaddess = $params['address'];
        $this->_fileHandler = new FileHandler( 'pools/nicehash/'. hash( 'sha256', $params['address'] ) .'.json' );
    }

    function curlDownload( $url ) {
        $curl = curl_init( $url );

        curl_setopt( $curl, CURLOPT_FAILONERROR, true );
        curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, false );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $curl, CURLOPT_SSLVERSION, 3 );
        curl_setopt( $curl, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json' ) );
        curl_setopt( $curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; cryptoGlance ' . CURRENT_VERSION . '; PHP/' . phpversion() . ')' );

        $Data = json_decode( curl_exec( $curl ), true );

        curl_close( $curl );
        $curl='';
        return $Data;

    }

    function getAlgo( $algoID ) {
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
            100 = Multi-algorithm (only valid for global statistics)
        */
        $algoTypes = array (
            0=>'Scrypt',
            1=>'SHA256',
            2=>'Scrypt-A.-Nf.',
            3=>'X11',
            4=>'X13',
            5=>'Keccak',
            6=>'X15',
            7=>'Nist5',
            100=>'Multi-algorithm'
        );
        if ( array_key_exists( $algoID, $algoTypes ) ) {
            return $algoTypes[$algoID];
        } else {
            return "Undefined";
        }
    }

    public function update() {
        if ( $CACHED == false || $this->_fileHandler->lastTimeModified() >= 60 ) { // updates every minute

            $poolData =  $this->curlDownload( $this->_apiURL  . '?method=stats.provider&addr='. $this->_btcaddess ) ;

            $data=array();

            $data['type'] = 'nicehash';

            foreach ( $poolData['result']['stats'] as $stats => $values ) {
                if ( $values['accepted_speed'] > 0 ) {
                    $algo = $this->getAlgo( $values['algo'] );
                    $data[$algo.'_balance'] = $values['balance'] . ' BTC';
                    $data[$algo.'_accepted'] = $values['accepted_speed'] * 1000 . ' Mh/s'; //values are given in GH/s
                    $data[$algo.'_rejected'] = $values['rejected_speed'] * 1000 . ' Mh/s'; //values are given in GH/s

                }
            }

            $this->_fileHandler->write( json_encode( $data ) );
            return $data;
        }

        return json_decode( $this->_fileHandler->read(), true );
    }

}
