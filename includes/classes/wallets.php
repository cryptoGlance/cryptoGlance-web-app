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
        'bitcoin'   => 'BTC',
        'continuum' => 'CTM',
        'darkcoin'  => 'DRK',
        'dogecoin'  => 'DOGE',
        'litecoin'  => 'LTC',
        'reddcoin'  => 'RDD',
        'vertcoin'  => 'VTC',
    );

    
    /*
     * POST
     */


    /*
     * GET
     */

    public function getCurrencies() {
        // Making room for possible addition of data here.
        return $this->_currencies;
    }

    public function getUpdate() {
        $data = array();
        foreach ($this->_objs as $wallet) {
            // Exchange information
            $btcIndex = new BitcoinIndex();

            // Get FIAT rate
            $fiatPrice = $btcIndex->convert($wallet['fiat'], $this->_currencies[$wallet['currency']]);
            $fiatPrice = number_format($fiatPrice['result']['conversion'], 8, '.', '');

            // Get COIN rate
            $coinPrice = $btcIndex->convert('btc', $this->_currencies[$wallet['currency']]); // 'btc' to be dynamic
            $coinPrice = number_format($coinPrice['result']['conversion'], 8, '.', '');

            // Wallet information
            $walletAddressData = array();
            $currencyBalance = 0.00000000;
            $fiatBalance = 0.00;
            $coinBalance = 0.00000000;

            // Wallet actually contains a bunch of addresses and associated data
            foreach ($wallet['addresses'] as $address) {
                $addressData = $address->update();
                $walletAddressData[$addressData['address']] = array(
                    'label' => $addressData['label'],
                    'balance' => number_format($addressData['balance'], 8),
                    'fiat_balance' => number_format($fiatPrice * $addressData['balance'], 2),
                    'coin_balance' => number_format($coinPrice * $addressData['balance'], 8),
                );
                $currencyBalance += number_format($addressData['balance'], 8, '.', '');
                $fiatBalance += number_format($fiatPrice * $addressData['balance'], 2, '.', '');
                $coinBalance += number_format($coinPrice * $addressData['balance'], 8, '.', '');
            }

            $data[] = array (
                'label' => $wallet['label'],
                'currency' => $wallet['currency'],
                'currency_balance' => number_format($currencyBalance, 8, '.', ','),
                'currency_code' => $this->_currencies[$wallet['currency']],
                'coin_balance' => number_format($coinBalance, 8, '.', ','),
                'coin_price' => $coinPrice,
                'coin_code' => 'BTC',
                'fiat_balance' => number_format($fiatBalance, 2, '.', ','),
                'fiat_code' => $wallet['fiat'],
                'total_addresses' => count($wallet['addresses']),
                'addresses' => $walletAddressData,
            );
        }

        return $data;
    }

}
