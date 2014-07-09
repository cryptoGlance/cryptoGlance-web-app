<?php
require_once 'abstract.php';
/*
 * @author Don Steele
 */
class Pools_TradeMyBit extends Pools_Abstract {

    // Pool Information
    protected $_apiKey; // 7d717abbe83e8304e83c2691d800f144

    public function __construct( $params ) {
        parent::__construct( array( 'apiurl' => 'https://pool.trademybit.com/' ) ); // /api.php?api_key=
        $this->_apiKey = $params['apikey'];
        $this->_fileHandler = new FileHandler( 'pools/trademybit/'. hash('sha256',$params['apikey']) .'.json' );
    }

    function formatHashRate( $hashRate, $precision = 2 ) {
        $units = array( 'h/s', 'Kh/s', 'Mh/s', 'Gh/s', 'Th/s' );
        $hashRate = max( $hashRate, 0 );
        $pow = floor( ( $hashRate ? log( $hashRate ) : 0 ) / log( 1024 ) );
        $pow = min( $pow, count( $units ) - 1 );

        $hashRate = $hashRate / pow( 1000, $pow );
        return round( $hashRate, $precision ) . ' ' . $units[$pow];
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
    public function update() {
        if ( $CACHED == false || $this->_fileHandler->lastTimeModified() >= 60 ) { // updates every minute

            $payoutData =  $this->curlDownload( $this->_apiURL  . '/api/balance?key='. $this->_apiKey ) ;

            $poolData = $this->curlDownload( $this->_apiURL  . '/api/hashinfo?key='. $this->_apiKey );

            // Payout Information
            $data['type'] = 'trademybit';
            $data['unexchanged'] = $payoutData['autoexchange']['unexchanged'];
            $data['exchanged'] = $payoutData['autoexchange']['exchanged'];

            $data['est_payout'] = $payoutData['autoexchange']['est_total'];

            // Pool Speed
            $data['user_hash'] =  $this->formatHashRate( $poolData['user_hash'], 2 );


            // Clear data if it's missing
            foreach ( $data as $key => $value ) {
                if ( $value == 0 ) {
                    unset( $data[$key] );
                }
            }

            $this->_fileHandler->write( json_encode( $data ) );
            return $data;
        }

        return json_decode( $this->_fileHandler->read(), true );
    }

}
