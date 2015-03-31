<?php
require_once('includes/inc.php');

if (!$_SESSION['login_string']) {
    header("HTTP/1.0 401 Unauthorized");
    exit();
}

session_write_close();

$CACHED = true;
if (isset($_GET['cached']) && ($_GET['cached'] == 'false' || $_GET['cached'] == 0)) {
    $CACHED = false;
}
$GLOBALS['cached'] = $CACHED;

$type = (!empty($_GET['type']) ? $_GET['type'] : $_POST['type']);
$action = (!empty($_GET['action']) ? $_GET['action'] : $_POST['action']);

$type = str_replace(' ', '', lcfirst(ucwords(str_replace('-', ' ', strtolower($type)))));
$action = str_replace(' ', '', lcfirst(ucwords(str_replace('-', ' ', strtolower($action)))));

// If we're not posting, it's a get function
if (empty($_POST)) {
    $action = 'get' . $action;
}

if (empty($type) || empty($action)) {
    exit();
}

require_once('includes/autoloader.inc.php');

$obj = new $type();
$result = $obj->$action();
header('Content-Type: application/json');
echo json_encode($result);
?>
