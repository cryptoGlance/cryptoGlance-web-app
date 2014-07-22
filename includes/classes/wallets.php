<?php
/**
 * Description of wallets
 * 
 * This was refactored to add another level of management... I hope it still makes sense...
 * This class holds wallets, wallets have addresses within them.
 *
 * @author Stoyvo
 */
class Wallets extends Config_Wallets {

    protected $_currencies = array(
        'bitcoin' => 'BTC',
        'continuum' => 'CTM',
        'darkcoin' => 'DRK',
        'dogecoin' => 'DOGE',
        'litecoin' => 'LTC',
        'reddcoin' => 'RDD',
        'vertcoin' => 'VTC',
    );

    public function __construct() {
        $fh = new FileHandler('configs/wallets.json');
        $wallets = json_decode($fh->read(), true);

        if (isset($_GET['id'])) {
            $walletId = intval($_GET['id'])-1;
            $this->addWallet($wallets[$walletId]['currency'], $wallets[$walletId]['label'], $wallets[$walletId]['addresses']);
        } else if (!empty($wallets)) {
            foreach ($wallets as $key => $wallet) {
                $this->addWallet($wallet['currency'], $wallet['label'], $wallet['addresses']);
            }
        }
    }
    
    public function getCurrencies() {
        // Making room for possible addition of data here.
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
        
        $this->_objs[] = array (
            'currency' => $currency,
            'label' => $label,
            'addresses' => $addessData,
        );
    }
    
    public function getUpdate() {
        $data = array();
        foreach ($this->_objs as $wallet) {
            $walletAddressData = array();
            $totalBalance = 0;
            
            // Wallet actually contains a bunch of addresses and associated data
            foreach ($wallet['addresses'] as $address) {
                $addressData = $address->update();
                $walletAddressData[$addressData['address']] = $addressData['balance'];
                $totalBalance += $addressData['balance'];
            }
            
            $data[] = array (
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
