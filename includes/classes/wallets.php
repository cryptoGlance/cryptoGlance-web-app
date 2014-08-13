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
        'feathercoin' => 'FTC',
        'litecoin' => 'LTC',
        'reddcoin' => 'RDD',
        'vertcoin' => 'VTC',
    );
    
    public function getCurrencies() {
        // Making room for possible addition of data here.
        return $this->_currencies;
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
            
            $btcIndex = new BitcoinIndex();
            $convert = $btcIndex->convert($wallet['fiat'], $this->_currencies[$wallet['currency']]);
            $fiat = 0;
            if (!empty($convert['result']['conversion'])) {
                $fiat = round($convert['result']['conversion'] * $totalBalance, 2);
            }
            
            $data[] = array (
                'currency' => $wallet['currency'],
                'currency_code' => $this->_currencies[$wallet['currency']],
                'label' => $wallet['label'],
                'balance' => $totalBalance,
                'fiat' => $fiat,
                'fiat_code' => $wallet['fiat'],
                'total_addresses' => count($wallet['addresses']), // needed?
                'addresses' => $walletAddressData,
            );
        }
                
        return $data;
    }

}
