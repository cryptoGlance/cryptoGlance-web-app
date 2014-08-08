<?php
//
// Author: Stoyvo (CryptoGlance)
//
// Description: This is a quick tool to get basic information from a specified API for mining software. The goal is to expact CryptoGlance to as many devices as possible and make this open to all crypto miners.
//

error_reporting(E_ERROR);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $summary = json_decode(runCMD($_POST['address'], $_POST['port'], '{"command":"summary"}'), true);        
    $dev = json_decode(runCMD($_POST['address'], $_POST['port'], '{"command":"devs"}'), true);
    $pools = json_decode(runCMD($_POST['address'], $_POST['port'], '{"command":"pools"}'), true);
            
    echo "<pre>";
    echo $_POST['type'];
    echo "<br />------------";
    echo "<pre>SUMMARY:";
    print_r($summary);
    echo "<br />------------";
    echo "<pre>DEVICES:";
    print_r($dev);
    echo "<br />------------";
    echo "<pre>POOLS:";
    print_r($pools);
    die();
}

function runCMD($host, $port, $cmd) {
    $response = '';
    $socket = stream_socket_client('tcp://'.$host.':'.$port, $errno, $errstr, 5);
    
    if (!$socket) {
        die('Cannot connect to miner API. Please go <a href="" onclick="window.history.go(-1); return false;">back</a> and verify IP address and port.');
        return null;
    } else {
        fwrite($socket, $cmd);
        while (!feof($socket)) {
            $response .= fgets($socket);
        }
        fclose($socket);
    }
    
    return str_replace("\0", '', $response);
}

?>
<html>
    <head>
        <title>Rig/Minger Debug Info</title>
    </head>
    <body>
        <form action="" method="POST">
            <table>
                <tr>
                    <td>Miner Type:</td>
                    <td><input type="text" name="type" /></td>
                    <td style="font-size:12px;">Please enter the type of mining software. EG: Gridseed, CudaMiner, bfgminer, etc</td>
                </tr>
                <tr>
                    <td>IP Address:</td>
                    <td><input type="text" name="address" /></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Port:</td>
                    <td><input type="text" name="port" /></td>
                    <td></td>
                </tr>
                <tr>
                    <td><input type="submit" name="submit" /></td>
                    <td><input type="reset" name="reset" /></td>
                    <td></td>
                </tr>
            </table>
        </form>
        <div style="font-size: 12px;margin-top:20px;">This tool was created for <a href="http://cryptoglance.info">CryptoGlance</a>.</div>
    </body>
</html>