<?php
require_once('includes/inc.php');

if (empty($_SESSION['login_string'])) {
    exit();
}

$type = ucwords(strtolower($_GET['type']));

$action = str_replace('-', '', preg_replace_callback('/(\w+)/', function($match){ return ucfirst($match[1]); }, strtolower($_GET['action'])));


if (empty($type) || empty($action)) {
    exit();
}

require_once('includes/autoloader.inc.php');

$className = 'Class_' . $type;
$obj = new $className();
$obj->$action();
?>
