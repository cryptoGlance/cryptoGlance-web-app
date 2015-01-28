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
    // validate posted data for rig
    protected function postValidate($dataType, $data) {
        if ($dataType == 'details' && empty($data['label'])) {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted
            return 'Missing a name for the wallet.';
        } else if ($dataType == 'details' && empty($data['currency'])) {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted
            return 'Missing requires a crypto currency.';
        } else if ($dataType == 'details' && empty($data['fiat'])) {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted
            return 'Missing requires a fiat conversion.';
        } else if ($dataType == 'address' && empty($data['label'])) {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted
            return 'An address needs a label';
        } else if ($dataType == 'address' && empty($data['address'])) {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted
            return 'An address is needed for balance tracking.';
        }

        return true;
    }

    protected function add($wallet) {

        if (empty($wallet['currency'])) {
            return false;
        }

        $class = 'Wallets_' . ucwords(strtolower($wallet['currency']));

        if (class_exists($class)) {
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

    public function addAddress() {
        $walletId = intval($_POST['id']);
        if ($walletId == 0){
            return false; // Not sure how anyone would ever get here, but just incase.
        }
        $walletId = $walletId-1;

        $data = $_POST['values'];

        $isValid = $this->postValidate('address', $data);
        if ($isValid !== true) {
            return $isValid;
        }

        if ($this->_data[$walletId]) {
            $walletData = array();
            $addessData = array();

            // No duplicates
            foreach ($this->_data[$walletId]['addresses'] as $address) {
                if ($address['address'] == $data['address']) {
                    header("HTTP/1.0 406 Not Acceptable"); // not accepted
                    return 'This address already exists in this wallet.';
                }
            }

            $this->_data[$walletId]['addresses'][] = array(
                'label' => $data['label'],
                'address' => $data['address'],
            );

            $this->write();
            return;
        } else {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted
            return 'Something went wrong.<br />Please go back to the dashboard and try again.';
        }

    }

    public function removeAddress() {
        $walletId = intval($_POST['id']);
        $addressId = intval($_POST['addressId']);
        if ($walletId == 0 || $addressId == 0){
            return false; // Not sure how anyone would ever get here, but just incase.
        }
        $walletId = $walletId-1;
        $addressId = $addressId-1;

        if ($this->_data[$walletId]) {

            unset($this->_data[$walletId]['addresses'][$addressId]);

            $this->write();
            return;
        } else {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted
            return 'Something went wrong.<br />Please go back to the dashboard and try again.';
        }

    }

    public function editAddress() {
        $walletId = intval($_POST['id']);
        $addressId = intval($_POST['addressId']);
        if ($walletId == 0 || $addressId == 0){
            return false; // Not sure how anyone would ever get here, but just incase.
        }

        $data = $_POST['values'];

        $isValid = $this->postValidate('address', $data);
        if ($isValid !== true) {
            return $isValid;
        }

        $walletId = $walletId-1;
        $addressId = $addressId-1;

        if ($this->_data[$walletId]) {

            $this->_data[$walletId]['addresses'][$addressId] = array(
                'label' => $data['label'],
                'address' => $data['address'],
            );

            $this->write();
            return;
        } else {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted
            return 'Something went wrong.<br />Please go back to the dashboard and try again.';
        }

    }

    public function update() {
        $id = intval($_POST['id']);
        if ($id == 0) {
            return $this->create();
        } else if (strtolower($_POST['action']) == 'remove') {
            return $this->remove();
        } else if ($id > 0 && strtolower($_POST['action']) == 'update') {
            return $this->updateDetails($id-1, 'details', $_POST);
        }
    }

    public function create() {
        $isValid = $this->postValidate($_POST['type'], $_POST);
        if ($isValid !== true) {
            return $isValid;
        }

        $this->_data[] = array(
            'label' => $_POST['label'],
            'currency' => $_POST['currency'],
            'fiat' => $_POST['fiat'],
            'addresses' => array(),
        );

        $this->write();

        return count($this->_data);
    }

    private function updateDetails($id, $dataType, $data) {
        $isValid = $this->postValidate($dataType, $data);
        if ($isValid !== true) {
            return $isValid;
        }

        $this->_data[$id] = array(
            'label' => $_POST['label'],
            'currency' => $_POST['currency'],
            'fiat' => $_POST['fiat'],
            'addresses' => $this->_data[$id]['addresses'],
        );

        $this->write();

        return ($id+1);
    }

}
