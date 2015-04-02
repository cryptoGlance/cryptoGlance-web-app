<?php

function curlCall($url, $params = null, $contentType = 'application/json', $options = array()) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_FAILONERROR, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSLVERSION, 4);

    if (!is_null($params) && !is_null($options['key']) && !is_null($options['sig'])) {
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: '.$contentType, 'key: '.$options['key'], 'sig: '.$options['sig']));
        //
    } else if (!is_null($params) && !empty($params)) {
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: '.$contentType));
    } else {
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: '.$contentType));
    }

    // Allow for custom requests
    if (isset($options['custom_request']) && !empty($options['custom_request'])) {
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $options['custom_request']);
    }

    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; cryptoGlance ' . CURRENT_VERSION . '; PHP/' . phpversion() . ')');

    $curlExec = curl_exec($curl);
    if ($curlExec === false || curl_errno($curl)) {
        $data = array();
    } else {
        $data = json_decode($curlExec, true);
    }

    if (empty($data)) {
        // return non-jsonfied data
        return $curlExec;
    }

    curl_close($curl);

    return $data;
}

function formatHashrate($hashrate, $precision = 2) { // h expected
    // Math Stuffs
    $units = array('KH', 'MH', 'GH', 'TH', 'PH', 'EH', 'ZH', 'YH');

    $pow = min(floor(($hashrate ? log($hashrate) : 0) / log(1000)), count($units) - 1);
    $hashrate /= pow(1000, $pow);
    $hashrate = round($hashrate, $precision) . ' ' . $units[$pow] . '/s';

    return $hashrate;
}
function formatCapacity($hashrate, $precision = 2) { // h expected
    return str_replace('H/s', 'B', formatHashrate($hashrate, $precision));
}

function formatTimeElapsed($elapsed) { // NOTE: This does not support weeks. Only days/months.
    if (isset($elapsed)) {
        $elapsed = intval($elapsed);

        $from = new DateTime("@0");
        $to = new DateTime("@$elapsed");
        $difference = $from->diff($to);

        if ($difference->y) {
            $format = '%yY %mM %dD';
        } else if ($difference->m) {
            $format = '%mM %dD %hH';
        } else if ($difference->d) {
            $format = '%aD %hH %iM';
        } else if ($difference->h) {
             $format = '%hH %iM %sS';
        } else if ($difference->i) {
             $format = '0H %iM %sS';
        } else if ($difference->s) {
             $format = '0H 0M %sS';
        }

        $uptime = $difference->format($format);

        return $uptime;
    }

    return null;
}
