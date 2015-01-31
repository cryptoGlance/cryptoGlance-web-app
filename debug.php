<?php
//
// Author: Stoyvo (CryptoGlance)
//
// Description: This is a quick tool to get basic information from a specified API for mining software.
// The goal is to expand CryptoGlance to as many devices as possible and make this open to all crypto miners.
//

error_reporting(E_ERROR);
ini_set("display_errors", 1);

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
                    <td>IP Address:</td>
                    <td><input type="text" name="address" value="<?php echo $_POST['address']; ?>" /></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Port:</td>
                    <td><input type="text" name="port" value="<?php echo $_POST['port']; ?>" /></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <button type="submit" name="submit" value="one">Test Miner</button>
                        &nbsp;or&nbsp;
                        <button type="submit" name="submit" value="all">Test All miners</button>
                    </td>
                </tr>
            </table>
        </form>
        <div style="font-size: 12px;margin-top:20px;"><a href="javascript:window.history.go(-1);">&#171; Back to CryptoGlance</a>.</div>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo '<br /><hr /><br />';

    if ($_POST['submit'] == 'one') {
        $config = json_decode(runCMD($_POST['address'], $_POST['port'], '{"command":"config"}'), true);
        $debug = json_decode(runCMD($_POST['address'], $_POST['port'], '{"command":"debug"}'), true);
        $summary = json_decode(runCMD($_POST['address'], $_POST['port'], '{"command":"summary"}'), true);
        $dev = json_decode(runCMD($_POST['address'], $_POST['port'], '{"command":"devs"}'), true);
        $devdetails = json_decode(runCMD($_POST['address'], $_POST['port'], '{"command":"devdetails"}'), true);
        $stats = json_decode(runCMD($_POST['address'], $_POST['port'], '{"command":"stats"}'), true);
        $eStats = json_decode(runCMD($_POST['address'], $_POST['port'], '{"command":"estats","parameter":1}'), true);
        $pools = json_decode(runCMD($_POST['address'], $_POST['port'], '{"command":"pools"}'), true);
        $ascset = json_decode(runCMD($_POST['address'], $_POST['port'], '{"command":"ascset","parameter":"0, help"}'), true);

        echo "<pre>config:";
        print_r($config);
        echo "</pre>";
        echo "<pre>debug:";
        print_r($debug);
        echo "</pre>";
        echo "<pre>SUMMARY:";
        print_r($summary);
        echo "</pre>";
        echo "<br />------------<br /><br />";
        echo "<pre>DEVICES:";
        print_r($dev);
        echo "</pre>";
        echo "<pre>devdetails:";
        print_r($devdetails);
        echo "</pre>";
        echo "<pre>stats:";
        print_r($stats);
        echo "</pre>";
        echo "<pre>eStats:";
        print_r($eStats);
        echo "</pre>";
        echo "<br />------------<br /><br />";
        echo "<pre>POOLS:";
        print_r($pools);
        echo "</pre>";
        echo "<pre>ascset:";
        print_r($ascset);
        echo "</pre>";
    } else if ($_POST['submit'] == 'all') {
        // Show errors
        ini_set("display_errors", 1);

        // Get all custom classes
        require_once('includes/inc.php');
        require_once('includes/autoloader.inc.php');

        $rigClass = new Rigs();
        $overview = $rigClass->getOverview();
        $update = $rigClass->getUpdate();

        echo "<pre>RIGS OVERVIEW:";
        print_r($overview);
        echo "</pre>";
        echo "<br />------------<br /><br />";
        echo "<pre>RIGS UPDATE:";
        print_r($update);
        echo "</pre>";
    }
}

?>
        <hr />
        <div style="font-size: 12px;margin-top:20px;">This tool was created for <a href="http://cryptoglance.info">CryptoGlance</a>.</div>
    </body>
</html>
