<?php
require_once('classes/filehandler.php');
class CryptoGlance {

    private $_configTypes = array(
        'cryptoglance',
        'miners',
        'pools',
        'wallets',
    );

    private $_algorithms = array(
        'FRESH'     =>  'Fresh',
        'FUGUE'     =>  'Fugue256',
        'KECCAK'    =>  'Keccak',
        'NIST'      =>  'NIST',
        'NSCRYPT'   =>  'NScrypt',
        'QUARK'     =>  'Quarkcoin',
        'SHA256'    =>  'SHA-256',
        'SCRYPT'    =>  'Scrypt',
        'TWE'       =>  'Twecoin',
        'UNK'       =>  'Unknown',
        'X11'       =>  'X11',
        'X13'       =>  'X13',
        'X14'       =>  'X14',
        'X15'       =>  'X15',
    );

    private $_config;

    public function __construct() {
        foreach ($this->_configTypes as $configType) {
            $fh = $fileHandler = new FileHandler('configs/' . $configType . '.json');
            $this->_config[$configType] = json_decode($fh->read(), true);
        }
    }

    public function supportedAlgorithms($reversed = false) {
        if ($reversed) {
            return array_flip($this->_algorithms);
        }
        return $this->_algorithms;
    }

    //////////
    // Rigs //
    //////////
    public function getMiners() {
        return $this->_config['miners'];
    }

    ///////////
    // Pools //
    ///////////
    public function getPools() {
        return $this->_config['pools'];
    }

    //////////////
    // Wallets //
    /////////////
    public function getWallets() {
        return $this->_config['wallets'];
    }
    public function addWallet() {
        $walletId = intval($_POST['walletId']);
        $label = $_POST['label'];
        $currency = $_POST['currency'];

        if ($walletId != 0) {
            $walletId -= 1;
            if (empty($label)) {
                header("HTTP/1.0 406 Not Acceptable"); // not accepted
                return null;
            }
            $this->_config['wallets'][$walletId]['label'] = $label;
        } else {
            if (empty($label) || empty($currency)) { // new wallets need label and option from currency dropdown
                header("HTTP/1.0 406 Not Acceptable"); // not accepted
                return null;
            }
            $this->_config['wallets'][] = array(
                'currency' => $currency,
                'label' => $label,
                'addresses' => array()
            );
        }

        $fh = $fileHandler = new FileHandler('configs/wallets.json');
        $fh->write(json_encode($this->_config['wallets']));
        header("HTTP/1.0 202 Accepted"); // accepted
        echo count($this->_config['wallets']);
    }
    public function removeWallet() {
        $walletId = intval($_POST['walletId']);

        if ($walletId == 0 || empty($this->_config['wallets'][$walletId-1])) {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted
            return null;
        }
        $walletId -= 1;

        unset($this->_config['wallets'][$walletId]);
        $this->_config['wallets'] = array_values($this->_config['wallets']);
        $fh = $fileHandler = new FileHandler('configs/wallets.json');
        $fh->write(json_encode($this->_config['wallets']));
        header("HTTP/1.0 202 Accepted"); // accepted
    }
    public function addAddress() {
        $walletId = intval($_POST['walletId']);
        $newLabel = $_POST['label'];
        $newAddress = $_POST['address'];

        if ($walletId == 0 || empty($this->_config['wallets'][$walletId-1]) || empty($newLabel) || empty($newAddress)) {
            hheader("HTTP/1.0 406 Not Acceptable"); // not accepted
            return null;
        }

        $walletId -= 1;

        foreach ($this->_config['wallets'][$walletId]['addresses'] as $address) {
            if ($newAddress == $address['address']) {
                header("HTTP/1.0 409 Conflict"); // not accepted
                return null;
            }
        }

        $this->_config['wallets'][$walletId]['addresses'][] = array(
            'label' => $newLabel,
            'address' => $newAddress,
        );

        $fh = $fileHandler = new FileHandler('configs/wallets.json');
        $fh->write(json_encode($this->_config['wallets']));
        header("HTTP/1.0 202 Accepted"); // accepted
    }
    public function editAddress() {
        $walletId = intval($_POST['walletId']);
        $addrId = intval($_POST['addrId']);
        $newLabel = $_POST['label'];

        if ($walletId == 0 || $addrId == 0 || empty($this->_config['wallets'][$walletId-1]['addresses'][$addrId-1]) || empty($newLabel)) {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted
            return null;
        }

        $walletId -= 1;
        $addrId -= 1;

        $this->_config['wallets'][$walletId]['addresses'][$addrId]['label'] = $newLabel;

        $fh = $fileHandler = new FileHandler('configs/wallets.json');
        $fh->write(json_encode($this->_config['wallets']));
        header("HTTP/1.0 202 Accepted"); // accepted
    }
    public function removeAddress() {
        $walletId = intval($_POST['walletId']);
        $addrId = intval($_POST['addrId']);

        if ($walletId == 0 || empty($this->_config['wallets'][$walletId-1]) || $addrId == 0 || empty($this->_config['wallets'][$walletId-1]['addresses'][$addrId-1])) {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted
            return null;
        }
        $walletId -= 1;
        $addrId -= 1;

        unset($this->_config['wallets'][$walletId]['addresses'][$addrId]);
        $this->_config['wallets'][$walletId]['addresses'] = array_values($this->_config['wallets'][$walletId]['addresses']);
        $fh = $fileHandler = new FileHandler('configs/wallets.json');
        $fh->write(json_encode($this->_config['wallets']));
        header("HTTP/1.0 202 Accepted"); // accepted
    }


    ///////////////
    // Settings //
    //////////////
    public function getSettings() {
        $settings = $this->_config['cryptoglance'];

        if (empty($settings['general']['updates']['enabled']) && $settings['general']['updates']['enabled'] != 0) {
            $settings['general']['updates']['enabled'] = 1;
        }
        if (empty($settings['general']['updates']['type'])) {
            $settings['general']['updates']['type'] = 'release';
        }
        if (empty($settings['general']['updateTimes']['rig'])) {
            $settings['general']['updateTimes']['rig'] = 3000;
        }
        if (empty($settings['general']['updateTimes']['pool'])) {
            $settings['general']['updateTimes']['pool'] = 120000;
        }
        if (empty($settings['general']['updateTimes']['wallet'])) {
            $settings['general']['updateTimes']['wallet'] = 600000;
        }

        return $settings;
    }

    public function saveSettings($data) {
        $fh = $fileHandler = new FileHandler('configs/cryptoglance.json');
        $settings = json_decode($fh->read(), true);

        if ($data['general']) {
            $settings['general'] = array(
                'updates' => array(
                    'enabled' => $data['general']['update'],
                    'type' => $data['general']['updateType'],
                ),
                'updateTimes' => array(
                    'rig' => $data['general']['rigUpdateTime']*1000,
                    'pool' => $data['general']['poolUpdateTime']*1000,
                    'wallet' => $data['general']['walletUpdateTime']*1000,
                )
            );
        }

        $this->_config['cryptoglance'] = $settings;

        if ($fh->write(json_encode($settings)) !== false) {
            return true;
        } else {
            return false;
        }
    }

}
?>
