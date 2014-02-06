<?php

/**
 * TO-DO:
 * - Ability to pull single miner by RIG ID
 * - Ability to pull all miners
 */
/**
 * Description of miners
 *
 * @author Timothy.Stoyanovski
 */

class Class_Miners {

    protected $_miners = array();

    public function __construct() {
        $fh = new Class_FileHandler('configs/miners.json');
        $miners = json_decode($fh->read(), true);

        if (!empty($miners)) {
            foreach ($miners as $minerType => $miner) {
                $minerArray = $miner;
                $this->addMiner($minerArray['type'], $minerArray['host'], $minerArray['port']);
            }
        }
    }

    private function addMiner($type, $host, $port) {
        if (empty($type) || empty($host) || empty($port)) {
            return false;
        }

        $class = 'Class_Miners_' . ucwords(strtolower($type));
        $obj = new $class($host, $port);
        $this->_miners[] = $obj;
    }

    public function getData() {
        // Requires param for type of data:
        foreach ($this->_miners as $miner) {
            $miner->$_GET['funct']();
        }
    }

    public function update($minerId = null) {
        $data = array();
        if (!empty($minerId) && $minerId != 0) {
            $minerId -= 1; // Arrays start at 0... 1 less than the ID on frontend
            if (!empty($this->_miners[$minerId])) {
                $data[] = $this->_miners[$minerId]->update();
            }
        } else {
            foreach ($this->_miners as $miner) {
                $data[] = $miner->update();
            }
        }
        
        return $data;
    }

}
