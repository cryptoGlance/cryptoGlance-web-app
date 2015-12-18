<?php
/**
 * Description of Wallet API | http://walletapi.cryptoglance.info
 *
 * Wallet API is a service hosted free of charge by CryptoGlance devs.
 * Development support was provided by Tim Coulter (http://twitter.com/timothyjcoulter)
 *
 * ---------------------------------------------------------------------------------------------------------------
 *
 * This class uses the CryptoGlance Wallet API
 *
 * @author Stoyvo
 */
class Walletapi {

    // Settings
    protected $_url = 'http://walletapi.cryptoglance.info';

    public function convert($to, $from) {
        $fileHandler = new FileHandler('fiat/walletapi/' . strtolower($to) . '_' . strtolower($from) . '.json');

        if ($GLOBALS['cached'] == false || $fileHandler->lastTimeModified() >= 3600) { // updates every 1 minute
            $data = array();

            $data = curlCall($this->_url . '/?from=' . strtolower($from) . '&to=' . strtolower($to));

            $fileHandler->write(json_encode($data));
            return $data;
        }

        return json_decode($fileHandler->read(), true);
    }


}
