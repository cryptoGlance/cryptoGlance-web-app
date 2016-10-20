<?php
//error_reporting(E_ALL ^ E_NOTICE);


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

    public function getCurrencies($wallet = null) {
    	return array_intersect_key($this->getExchanger($wallet)->getCurrencies(), self::getSupportedWalets());
    }
    public function getFiat($wallet) {
        return $this->getExchanger($wallet)->getFiat();
    }

    public function __get($name){
        switch ($name){
            case '_currencies' : return $this->getCurrencies();
        }
        return null;
    }

    private static $exchangers = null;
    public function getExchangers(){
    	if (self::$exchangers === null){
    		$cache = new FileHandler('wallets/exchangers.json');
    		$directory = new DirectoryIterator(__DIR__.'/exchanger');
	    	self::$exchangers = array();
	    	$process = false;
    		foreach (array('test', 'process') as $step){
		    	foreach ($directory as $fileInfo) {
		    		if (($fileInfo->getExtension() != 'php') || $fileInfo->isDot()) {
		    			continue;
		    		}
					if ($step == 'test'){
						if ($fileInfo->getMTime() > $cache->getMTime()){
							$process = true;
							break;
						}
						continue;
					}
		    		$classes = get_declared_classes();
		    		include $fileInfo->getRealPath();
		    		$classes = array_diff(get_declared_classes(), $classes);
		    		foreach ($classes as $class){
		    			$cr = new ReflectionClass($class);
		    			if ($cr->isSubclassOf('IExchanger')){
		    				var_dump(self::$exchangers);
		    				self::$exchangers[$class] = $cr->getMethod('getName')->invoke(null);
		    			}
		    		}
		    	}
		    	if (!$process){
		    		return self::$exchangers = (array)json_decode($cache->read());
		    	}
    		}
   			$cache->write(json_encode(self::$exchangers));
    	}
    	return self::$exchangers;
    }
    
    private static $supportedWallets = null;
    public function getSupportedWalets(){
    	if (self::$supportedWallets  === null){
    		self::$supportedWallets = array();
    		
    		$cache = new FileHandler('wallets/currencies.json');
    		$directory = new DirectoryIterator(__DIR__.'/wallets');
    		$process = false;
    		foreach (array('test', 'process') as $step){
	    		foreach ($directory as $fileInfo) {
	    			if (($fileInfo->getExtension() != 'php') || $fileInfo->isDot()) {
	    				continue;
	    			}
	    			if ($step == 'test'){
	    				if ($fileInfo->getMTime() > $cache->getMTime()){
	    					$process = true;
	    					break;
	    				}
	    				continue;
	    			}
	    			$classes = get_declared_classes();
	    			include $fileInfo->getRealPath();
	    			$classes = array_diff(get_declared_classes(), $classes);
	    			foreach ($classes as $class){
	    				$cr = new ReflectionClass($class);
	    				if ($cr->isSubclassOf('IWallet')){
	    					foreach ($cr->getMethod('getSupportedWallets')->invoke(null) as $curr){
	    						self::$supportedWallets[$curr] = $class;
	    					}
	    				}
	    			}
	    		}
    		   	if (!$process){
		    		return self::$supportedWallets = (array)json_decode($cache->read());
		    	}
    		}
    		$cache->write(json_encode(self::$supportedWallets));
    	}
    	return self::$supportedWallets;
    }
    
    private $ex = array();
    /*
     * @return IExchanger
    */
    public function getExchanger($wallet = null){
    	if(empty($wallet)){
    		reset(self::$exchangers);
    		$exchnager = key(self::$exchangers);
    	} else {
    		$exchnager = $wallet; 
    	}
        if (!array_key_exists($exchnager, $this->ex)){
        	if (!class_exists($exchnager)){
        		cgLoader($exchnager);
        	}
            $this->ex[$exchnager] = new $exchnager();
        }
        return $this->ex[$exchnager];
    }

    public function getUpdate() {
        $data = array();

        foreach ($this->_objs as $wallet) {
            // Exchange information
            $btcIndex = $this->getExchanger($wallet['exchanger']);
            $this->getCurrencies($wallet['exchanger']);

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
            	'exchanger' => $wallet['exchanger'],
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
            	'disclaimer' => $btcIndex->getDisclaimer(),
            );
        }
        return $data;
    }

    public function getcurrency(){
    	return array(
	    	'currency' => $this->getCurrencies($_REQUEST['exchanger']),
    		'fiat' => $this->getFiat($_REQUEST['exchanger']),
    	);
    }
}
