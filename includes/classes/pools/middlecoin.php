<?php

/*
 *
 * @author Stoyvo
 */
class Class_Pools_Middlecoin {

    // Pool Information
    protected $_apiURL;

    public function __construct($params) {
        $this->_apiURL = $params['apiURL'];
    }

    /*
     * TODO: REFACTOR! getData to be extended, pass pool type 'mpos'
     */

    public function getData($fileName) {
        $fileHandler = new Class_FileHandler(
                'pools/middlecoin/' . sha1($this->_apiURL . '.' . $this->_apiKey) . '/' . $fileName . '.json'
        );

        return $fileHandler->read();
    }

    public function getUserStatus() {
        echo $this->getData('getuserstatus');
    }

    public function getUserWorkers() {
        echo $this->getData('getuserworkers');
    }

    public function getPoolStatus() {
        echo $this->getData('getpoolstatus');
    }

    public function update() {
        foreach ($this->_actions as $action) {
            $fileHandler = new Class_FileHandler(
                    'pools/mpos/' . sha1($this->_apiURL . '.' . $this->_apiKey) . '/' . $action . '.json'
            );

            if ($fileHandler->lastTimeModified() >= 30) {
                $url = $this->_apiURL
                        . '/index.php?page=api'
                        . '&api_key=' . $this->_apiKey
                        . '&action=' . $action;
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_FAILONERROR, true);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                $fileHandler->write(curl_exec($curl));
            }
        }
    }

}
