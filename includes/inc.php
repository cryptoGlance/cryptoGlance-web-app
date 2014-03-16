<?php
error_reporting(E_ERROR);
//error_reporting(E_ALL);

$session_name = 'cryptoGlance'; // feel free to rename this!
session_name($session_name);
session_start();


require_once('config.php');

define('DATA_PATH', getcwd() . '/' . DATA_FOLDER . '/');


//
//// DEV ONLY:
define('CURRENT_VERSION', 'v0.1-alpha');
//// END DEV ONLY
//

// PRODUCTION:
//define('CURRENT_VERSION', 'v0.0.');
?>