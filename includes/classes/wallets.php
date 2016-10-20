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

    /*
     * POST
     */


    /*
     * GET
     */

    public function getCurrencies() {
        return array_intersect_key($this->getExchanger()->getCurrencies(), self::$currencyClasses);
    }
    public function getFiat() {
        return $this->getExchanger()->getFiat();
    }

    public function __get($name){
        switch ($name){
            case '_currencies' : return $this->getCurrencies();
        }
        return null;
    }

    public static $currencyClasses = array(
      'BTC' => 'Wallets_Bitcoin',
      'BURST' => 'Wallets_Burstcoin',
      'DARK' => 'Wallets_Darkcoin',
      'DOGE' => 'Wallets_Dogecoin',
      'DOGED' => 'Wallets_Dogecoindark',
      'LTC' => 'Wallets_Litecoin',
      'NEOS' => 'Wallets_Neoscoin',
      'XPY' => 'Wallets_Paycoin',
      'PPC' => 'Wallets_Peercoin',
      'RDD' => 'Wallets_Reddcoin',
      'VTC' => 'Wallets_Vertcoin',
    );

    private $ex = null;
    /*
     * @return IExchanger
    */
    public function getExchanger(){
        if ($this->ex === null){
//            $this->ex = new CoinDesk();
//			$this->ex = new Walletapi();
            $this->ex = new Cryptonator();
        }
        return $this->ex;
    }

    public function getUpdate() {
        $data = array();

        foreach ($this->_objs as $wallet) {
            // Exchange information
            $btcIndex = $this->getExchanger();
            $this->getCurrencies();

            // Get FIAT rate
            $fiatPrice = $btcIndex->convert($wallet['fiat'], $wallet['currency']);
            $fiatPrice = number_format($fiatPrice['result']['conversion'], 8, '.', '');

            // Get COIN rate
            $coinPrice = $btcIndex->convert('BTC', $wallet['currency']); // 'btc' to be dynamic
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
                    'balance' => str_replace('.00000000', '', number_format($addressData['balance'], 8, '.', '')),
                    'fiat_balance' => number_format($fiatPrice * $addressData['balance'], 2, '.', ''),
                    'coin_balance' => str_replace('.00000000', '', number_format($coinPrice * $addressData['balance'], 8, '.', '')),
                );
                $currencyBalance += number_format($addressData['balance'], 8, '.', '');
                $fiatBalance += number_format($fiatPrice * $addressData['balance'], 2, '.', '');
                $coinBalance += number_format($coinPrice * $addressData['balance'], 8, '.', '');
            }

            $data[] = array (
                'label' => $wallet['label'],
                'currency' => $wallet['currency'],
                'currency_balance' => str_replace('.00000000', '', number_format($currencyBalance, 8, '.', ',')),
                'currency_code' => $wallet['currency'],
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
