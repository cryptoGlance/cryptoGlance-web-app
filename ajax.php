<?php
require_once('includes/inc.php');

$type = ucwords(strtolower($_GET['type']));
$action = ucwords(strtolower($_GET['action']));


if (empty($type) || empty($action)) {
    exit();
}

require_once('includes/autoloader.inc.php');

$className = 'Class_' . $type;
$obj = new $className();
$obj->$action();
?>
