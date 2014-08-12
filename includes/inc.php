<?php
// looking for required extensions
if (!extension_loaded('sockets')) {
    die('The sockets extension is not loaded.');
} else if (!extension_loaded('curl')) {
    die('The curl extension is not loaded.');
} else if (ini_set('session.use_only_cookies', 1) === FALSE) {
    die('Error: We require that sessions only use cookies. Consult your PHP config to resolve this issue.');
}

require_once('config.php');

// App Setup
set_time_limit(20);
ini_set("display_errors", 1);
error_reporting(E_ERROR);
// error_reporting(E_ALL);

date_default_timezone_set("GMT");

session_name('cryptoGlance'); // feel free to rename this!
// Gets cookies params
$cookieParams = session_get_cookie_params();
session_set_cookie_params($cookieParams['lifetime'], $cookieParams['path'], $cookieParams['domain'], false, true);
session_start();

define('DATA_PATH', getcwd() . DIRECTORY_SEPARATOR . DATA_FOLDER . DIRECTORY_SEPARATOR);

require_once('cryptoglance.php');
$cryptoGlance = new CryptoGlance();
$settings = $cryptoGlance->getSettings();

//// Current Build:
define('CURRENT_VERSION', 'v1.2.0');


// Misc function used throughout cryptoglance
require_once('functions.php');
