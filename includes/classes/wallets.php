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
        'burstcoin'   => 'BURST',
        'darkcoin'  => 'DRK',
        'dogecoin'  => 'DOGE',
        'dogecoindark'  => 'DOGED',
        'litecoin'  => 'LTC',
        'neoscoin' => 'NEOS',
        'paycoin' => 'XPY',
        'reddcoin'  => 'RDD',
        // 'vertcoin'  => 'VTC', // Disabled until blockchain explorer works
    );

    protected $_fiat = array(
        'CAD'   => 'Canadian Dollar',
        'EUR'   => 'Euro',
        'GBP'   => 'British Pound',
        'NZD'   => 'New Zealand Dollar',
        'USD'   => 'US Dollar',
    );


    /*
     * POST
     */


    /*
     * GET
     */

    public function getCurrencies() {
        return $this->_currencies;
    }
    public function getFiat() {
        return $this->_fiat;
    }

    public function getUpdate() {
        $data = array();
        foreach ($this->_objs as $wallet) {
            // Exchange information
            $btcIndex = new FirstRally();

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
            foreach ($wallet['addresses'] as $addrKey => $address) {
                $addressData = $address->update();
                $walletAddressData[$addressData['address']] = array(
                    'id' => $addrKey+1,
                    'label' => $addressData['label'],
                    'balance' => str_replace('.00000000', '', number_format($addressData['balance'], 8)),
                    'fiat_balance' => number_format($fiatPrice * $addressData['balance'], 2),
                    'coin_balance' => str_replace('.00000000', '', number_format($coinPrice * $addressData['balance'], 8)),
                );
                $currencyBalance += number_format($addressData['balance'], 8, '.', '');
                $fiatBalance += number_format($fiatPrice * $addressData['balance'], 2, '.', '');
                $coinBalance += number_format($coinPrice * $addressData['balance'], 8, '.', '');
            }

            $data[] = array (
                'label' => $wallet['label'],
                'currency' => $wallet['currency'],
                'currency_balance' => str_replace('.00000000', '', number_format($currencyBalance, 8, '.', ',')),
                'currency_code' => $this->_currencies[$wallet['currency']],
                'coin_balance' => str_replace('.00000000', '', number_format($coinBalance, 8, '.', ',')),
                'coin_price' => str_replace('.00000000', '', $coinPrice),
                'coin_code' => 'BTC',
                'coin_value' => number_format($fiatPrice, 4, '.', ','),
                'fiat_balance' => number_format($fiatBalance, 2, '.', ','),
                'fiat_code' => $wallet['fiat'],
                'addresses' => $walletAddressData,
            );
        }

        return $data;
    }

}
