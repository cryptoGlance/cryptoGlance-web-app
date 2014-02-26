<?php
/**
 * Description of wallets
 * 
 * This was refactored to add another level of management... I hope it still makes sense...
 * This class holds wallets, wallets have addresses within them.
 *
 * @author Timothy.Stoyanovski
 */

class Class_Wallets {

    protected $_wallets = array();
    protected $_currencies = array(
        'bitcoin' => 'BTC',
        'litecoin' => 'LTC',
        'dogecoin' => 'DOGE',
    );

    public function __construct() {
        $fh = new Class_FileHandler('configs/wallets.json');
        $wallets = json_decode($fh->read(), true);

        if (!empty($wallets)) {
            foreach ($wallets as $key => $wallet) {
                $this->addWallet($wallet['currency'], $wallet['label'], $wallet['addresses']);
            }
        }
    }

    private function addWallet($currency, $label, $addresses) {
        if (empty($currency) || empty($addresses)) {
            return false;
        }
        
        $class = 'Class_Wallets_' . ucwords(strtolower($currency));
        
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

    public function getAddresses() {
        $walletId = intval($_GET['wallet']);
        if ($walletId == 0) {
            return null;
        }
        
        $walletAddressesData = array();
        foreach($this->_wallets[$walletId-1]['addresses'] as $address) {
            $walletAddressesData[] = $address->getAddress();
        }
        
        echo json_encode($walletAddressesData);
    }
    
    public function update($cached = false) {
        $data = array();
        
        foreach ($this->_wallets as $key => $wallet) {
            $walletAddressData = array();
            $totalBalance = 0;
            
            // Wallet actually contains a bunch of addresses and associated data
            foreach ($wallet['addresses'] as $address) {
                $addressData = $address->update($cached);
                $totalBalance += $addressData['balance'];
            }
            
            $data[$key] = array (
                'currency' => $wallet['currency'],
                'currency_code' => $this->_currencies[$wallet['currency']],
                'label' => $wallet['label'],
                'balance' => $totalBalance,
                'total_addresses' => count($wallet['addresses']),
            );
            
        }
        
        return $data;
    }

}
