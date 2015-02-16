<?php
require_once('abstract.php');
/**
 * Configuring pools
 *
 * @author Stoyvo
 */

class Config_Pools extends Config_Abstract {

    protected $_config = 'configs/pools.json';


    /*
     * Specific to class
     */

    protected function add($pool) {

        if (empty($pool['type'])) {
            return false;
        }

        $class = 'Pools_' . ucwords(strtolower($pool['type']));
        $obj = new $class($pool);
        $this->_objs[] = $obj;
    }

    public function create() {
        $id = intval($_POST['id']);
        $label = $_POST['label'];
        $type = $_POST['poolType'];
        $url = rtrim($_POST['url'], '/');
        $address = $_POST['address'];
        $api = $_POST['api'];
        $coin = $_POST['coin'];
        $userid = $_POST['userid'];

        $pool = array();
        if ($type == 'btcguild' && !empty($api)) {
            $pool = array(
                'type' => $type,
                'name' => ($label ? $label : 'BTC Guild'),
                'apikey' => $api,
            );
        } else if ($type == 'eclipse' && !empty($api)) {
            $pool = array(
                'type' => $type,
                'name' => ($label ? $label : 'Eclipse'),
                'apikey' => $api,
            );
        } else if ($type == 'mpos' && !empty($url) && !empty($api) && !empty($userid)) {
            $pool = array(
                'type' => $type,
                'name' => ($label ? $label : preg_replace('#^https?://#', '', $url)),
                'apiurl' => rtrim($url, '/'),
                'apikey' => $api,
                'userid' => $userid,
            );
        } else if ($type == 'bitcoinaffiliatenetwork' && !empty($api) && !empty($userid)) {
            $pool = array(
                'type' => $type,
                'name' => ($label ? $label : preg_replace('#^https?://#', '', $url)),
                'apikey' => $api,
                'userid' => $userid,
            );
        } else if ($type == 'simplecoin' && !empty($api) && !empty($url)) {
            $pool = array(
                'type' => $type,
                'name' => ($label ? $label : preg_replace('#^https?://#', '', $url)),
                'apiurl' => rtrim($url, '/'),
                'apikey' => $api,
            );
        } else if ($type == 'wafflepool' && !empty($address)) {
            $pool = array(
                'type' => $type,
                'name' => ($label ? $label : 'WafflePool'),
                'address' => $address,
            );
        } else if ($type == 'ckpool' && !empty($api) && !empty($userid) && !empty($url)) {
            $pool = array(
                'type' => $type,
                'name' => ($label ? $label : preg_replace('#^https?://#', '', $url)),
                'apiurl' => rtrim($url, '/'),
                'apikey' => $api,
                'userid' => $userid,
            );
        } else if ($type == 'eligius' && !empty($address)) {
            $pool = array(
                'type' => $type,
                'name' => ($label ? $label : 'Eligius'),
                'address' => $address,
            );
        } else if ($type == 'magicpool' && !empty($address)) {
            $pool = array(
                'type' => $type,
                'name' => ($label ? $label : 'MagicPool'),
                'address' => $address,
            );
        } else if ($type == 'trademybit' && !empty($api)) {
            $pool = array(
                'type' => $type,
                'name' => ($label ? $label : 'TradeMyBit'),
                'apikey' => $api,
            );
        } else if ($type == 'multipoolus' && !empty($api)) {
            $pool = array(
                'type' => $type,
                'name' => ($label ? $label : 'MultiPool.us'),
                'apikey' => $api,
            );
        } else if ($type == 'nomp' && !empty($address) && !empty($url) && !empty($coin)) {
            $pool = array(
                'type' => $type,
                'name' => ($label ? $label : preg_replace('#^https?://#', '', $url)),
                'apiurl' => rtrim($url, '/'),
                'address' => $address,
                'coin' => $coin,
            );
        } else if ($type == 'p2pool' && !empty($address) && !empty($url)) {
               $pool = array(
                   'type' => $type,
                   'name' => ($label ? $label : 'MagicPool'),
                   'apiurl' => rtrim($url, '/'),
                   'address' => $address,
               );
           } else {
            header("HTTP/1.0 406 Not Acceptable"); // not accepted
            return 'All fields are required on this form.';
        }

        if ($id != 0) {
            $this->_data[$id-1] = $pool;
        } else {
            $this->_data[] = $pool;
        }

        return $this->write();
    }

    public function getConfig() {
        $id = intval($_GET['id']);
        if ($id != 0) {
            return $this->_data[$id-1];
        }
    }

}
