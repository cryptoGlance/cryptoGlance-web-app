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

class Miners {

    protected $_miners = array();

    public function __construct() {
        $fh = new FileHandler('configs/miners.json');
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

        $class = 'Miners_' . ucwords(strtolower($type));
        $obj = new $class($host, $port);
        $this->_miners[] = $obj;
    }
    
    // Sending Data to view
    public function getPools() {
        $minerId = intval($_GET['miner']);
        
        if ($minerId == 0) {
            return null;
        }
        
        echo json_encode($this->_miners[$minerId-1]->getPools());
    }
    
    // Setters
    // Enable/Disable Dev
    public function devState() {
        $minerId = intval($_GET['miner']);
        $devType = strval($_GET['devType']);
        $devId = intval($_GET['dev']);
        
        if ($_GET['state'] === 'true') {
            $state = 1;
        } else if ($_GET['state'] === 'false') {
            $state = 0;
        } else {
            return null;
        }
        
        if ($minerId == 0 || $devId == 0 || empty($devType)) {
            return null;
        }
    
        $this->_miners[$minerId-1]->setDevState($devType, $devId-1, $state); 
    }
    
    public function prioritizePools() {
        $minerId = intval($_GET['miner']);
        $poolId = intval($_GET['pool']);
        $priority = intval($_GET['priority']);
        
        if ($minerId == 0 || $poolId == 0) {
            return null;
        }
        
        $this->_miners[$minerId-1]->prioritizePools($poolId-1, $priority); 
    }
    
    public function switchPool() {
        $minerId = intval($_GET['miner']);
        $poolId = intval($_GET['pool']);
        
        if ($minerId == 0 || $poolId == 0) {
            return null;
        }
    
        $this->_miners[$minerId-1]->switchPool($poolId-1);
    }
    public function restart() {
        $minerId = intval($_GET['miner']);
        
        if ($minerId == 0) {
            return null;
        }
    
        $this->_miners[$minerId-1]->restart();
    }
    
    public function getMiner($minerId = null) {
        if (!is_null($minerId) && $minerId != 0) {
            $minerId -= 1; // Arrays start at 0... 1 less than the ID on frontend
            if (!empty($this->_miners[$minerId])) {
                return $this->_miners[$minerId];
            }
        }
    }

    // Automatic Update function
    public function update($minerId = null) {
        $data = array();
        if (!is_null($minerId) && $minerId != 0) {
            $minerId -= 1; // Arrays start at 0... 1 less than the ID on frontend
            if (!empty($this->_miners[$minerId])) {
                $data[$minerId] = $this->_miners[$minerId]->update();
            }
        } else {
            foreach ($this->_miners as $minerId => $miner) {
                $data[$minerId] = $miner->update();
            }
        }
        
        return $data;
    }

}

