<?php
require_once('includes/inc.php');

if (!$_SESSION['login_string']) {
    header("HTTP/1.0 401 Unauthorized");
    exit();
}

session_write_close();

global $CACHED;
if (isset($_GET['cached']) && $_GET['cached'] == 0) {
    $CACHED = false;
} else {
    $CACHED = true;
}

$type = ucwords(strtolower($_GET['type']));

$action = str_replace('-', '', preg_replace_callback('/(\w+)/', function($match){ return ucfirst($match[1]); }, strtolower($_GET['action'])));

// If we're not posting, it's a get function
if (empty($_POST)) {
    $action = 'get' . $action;
}

if (empty($type) || empty($action)) {
    exit();
}

require_once('includes/autoloader.inc.php');

//$className = 'Class_' . $type;
//$obj = new $className();
$obj = new $type();
$result = $obj->$action();

echo json_encode($result);
?>
