<?php
require_once('abstract.php');
/**
 * Configuring wallets
 *
 * @author Stoyvo
 */
class Config_Wallets extends Config_Abstract {

    protected $_config = 'configs/wallets.json';
    
    
    /*
     * Specific to class
     */
     
    protected function add($wallet) {

        if (empty($wallet['currency'])) {
            return false;
        }

        $class = 'Wallets_' . ucwords(strtolower($wallet['currency']));
        
        $walletData = array();
        $addessData = array();
        
        foreach ($wallet['addresses'] as $address) {
            $addessData[] = new $class($address['label'], $address['address']);
        }
        
        $this->_objs[] = array (
            'currency' => $wallet['currency'],
            'fiat' => (!empty($wallet['fiat']) ? $wallet['fiat'] : 'USD'),
            'label' => $wallet['label'],
            'addresses' => $addessData,
        );
    }

}