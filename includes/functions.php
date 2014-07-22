<?php

function curlCall($url) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_FAILONERROR, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; cryptoGlance ' . CURRENT_VERSION . '; PHP/' . phpversion() . ')');
    
    $data = json_decode(curl_exec($curl), true);
    
    curl_close($curl);
    
    return $data;
}

function formatHashrate($hashrate, $precision = 2) { // h expected
    // Math Stuffs
    $units = array('KH', 'MH', 'GH', 'TH', 'PH');

    $pow = min(floor(($hashrate ? log($hashrate) : 0) / log(1000)), count($units) - 1);
    $hashrate /= pow(1000, $pow);
    $hashrate = round($hashrate, $precision) . ' ' . $units[$pow] . '/s';

    return $hashrate;
}

function formatTimeElapsed($elapsed) { // NOTE: This does not support weeks. Only days/months.
    if (isset($elapsed)) {
    
        $seconds = $elapsed;

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