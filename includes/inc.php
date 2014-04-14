<?php
error_reporting(E_ERROR);
//error_reporting(E_ALL);

$session_name = 'cryptoGlance'; // feel free to rename this!
session_name($session_name);
// Forces use of cookies
if (ini_set('session.use_only_cookies', 1) === FALSE) {
    die('Error: We require that sessions only use cookies. Consult your PHP config to resolve this issue.');
}
// Gets cookies params
$cookieParams = session_get_cookie_params();
//session_set_cookie_params($cookieParams['lifetime'], $cookieParams['path'], $cookieParams['domain'], false, true);
session_start();

require_once('config.php');

define('DATA_PATH', getcwd() . '/' . DATA_FOLDER . '/');


//// Current Build:
define('CURRENT_VERSION', 'v1.0.1');
?>