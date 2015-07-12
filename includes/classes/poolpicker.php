<?php
/**
 * Description of PoolPicker | http://poolpicker.eu/
 *
 * This service collects statistics from pools and displays them for you.
 * Show support to this amazing project by donating: BTC 1DoNATE48KBdTYJQDbEckUcFdEgzyTC9De
 *
 * ---------------------------------------------------------------------------------------------------------------
 *
 * This class uses the http://poolpicker.eu/ API | http://poolpicker.eu/api
 *
 * @author Stoyvo
 */
class PoolPicker extends Config_PoolPicker {

    public function getUpdate() {
        $fileHandler = new FileHandler('services/poolpicker.json');

        if ($GLOBALS['cached'] == false || $fileHandler->lastTimeModified() >= 3600) { // updates every 1 minute
            $data = array();

            $data = curlCall($this->_url);

            $data = $this->_filterData($data);

            $fileHandler->write(json_encode($data));
            return $data;
        }

        return json_decode($fileHandler->read(), true);
    }

    private function _filterData($data) {
        // Get the metrics we'll be using
        $algoMetric = array();
        foreach ($data['algos'] as $algo => $metric) {
            $algo = strtolower(str_replace('-', '', $algo));
            $algoMetric[$algo] = $metric[0];
        }
        unset($algo);

        // Sort the pools based on payout
        $topPayouts = array();
        foreach ($data['pools'] as $pKey => $pool) {
            foreach ($pool['profitability'] as $algo => $profitability) {
                // Some handling for content
                $algo = strtolower(str_replace('-', '', $algo));
                if (!in_array($algo, $this->_data)) {
                    continue;
                }
                $btc = number_format($profitability[0]['btc'], 8);
                $poolData = array(
                    'name' => $pool['name'],
                    'btc' => $btc,
                    'metric' => $algoMetric[$algo],
                );

                // If the algorithm layer hasnt been set, create array stack
                if (!isset($topPayouts[$algo])) {
                    $topPayouts[$algo] = array();
                }

                // We only care about yesterday
                if (!isset($topPayouts[$algo][0])) {
                    $topPayouts[$algo][0] = $poolData;
                } else if ($btc > $topPayouts[$algo][0]['btc']) {
                    array_unshift($topPayouts[$algo], $poolData);
                    if (count($topPayouts[$algo]) > 3) {
                        unset($topPayouts[$algo][3]);
                    }
                } else if (!isset($topPayouts[$algo][1])) {
                    $topPayouts[$algo][1] = $poolData;
                } else if ($btc > $topPayouts[$algo][1]['btc']) {
                    $topPayouts[$algo][2] = $topPayouts[$algo][1];
                    $topPayouts[$algo][1] = $poolData;
                } else if (!isset($topPayouts[$algo][2])) {
                    $topPayouts[$algo][2] = $poolData;
                } else if ($btc > $topPayouts[$algo][2]['btc']) {
                    $topPayouts[$algo][2] = $poolData;
                }
            }
        }

        return $topPayouts;
    }

    public function remove() {
        if (parent::remove()) {
            header("HTTP/1.0 202 Accepted");
            return true;
        } else {
            return false;
        }
    }


}
