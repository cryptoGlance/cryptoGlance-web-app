<?php
/**
 * Description of wallets
 * 
 * This was refactored to add another level of management... I hope it still makes sense...
 * This class holds wallets, wallets have addresses within them.
 *
 * @author Timothy.Stoyanovski
 */

class Wallets {

    protected $_wallets = array();
    protected $_currencies = array(
        'bitcoin' => 'BTC',
        'continuum' => 'CTM',
        'litecoin' => 'LTC',
        'feathercoin' => 'FTC',
        'dogecoin' => 'DOGE',
        'vertcoin' => 'VTC',
    );

    public function __construct() {
        $fh = new FileHandler('configs/wallets.json');
        $wallets = json_decode($fh->read(), true);

        if (!empty($wallets)) {
            foreach ($wallets as $key => $wallet) {
                $this->addWallet($wallet['currency'], $wallet['label'], $wallet['addresses']);
            }
        }
    }
    
    public function getCurrencies() {
        // Making room for possible addition of data here.s
        return $this->_currencies;
    }

    private function addWallet($currency, $label, $addresses) {
        if (empty($currency)) {
            return false;
        }
        
        $class = 'Wallets_' . ucwords(strtolower($currency));
        
        $walletData = array();
        $addessData = array();
        
        foreach ($addresses as $address) {
            $addessData[] = new $class($address['label'], $address['address']);
        }
        
        $this->_wallets[] = array (
            'currency' => $currency,
            'label' => $label,
            'addresses' => $addessData,
        );
    }
    
    public function update($walletId = null) {
        $data = $wallets = array();
        $wallets = $this->_wallets;
        
        if (!empty($walletId) && $walletId != 0) {
            $walletId -= 1;
            $wallets = array($this->_wallets[$walletId]);
        }
        
        foreach ($wallets as $key => $wallet) {
            $walletAddressData = array();
            $totalBalance = 0;
            
            // Wallet actually contains a bunch of addresses and associated data
            foreach ($wallet['addresses'] as $address) {
                $addressData = $address->update();
                $walletAddressData[$addressData['address']] = $addressData['balance'];
                $totalBalance += $addressData['balance'];
            }
            
            $data[$key] = array (
                'currency' => $wallet['currency'],
                'currency_code' => $this->_currencies[$wallet['currency']],
                'label' => $wallet['label'],
                'balance' => $totalBalance,
                'total_addresses' => count($wallet['addresses']), // needed?
                'addresses' => $walletAddressData,
            );
        }
        
        return $data;
    }

}
