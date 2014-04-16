<?php

// Initial classes path
//$classesPath = 'includes/classes';
//if (defined('CRYPTOGLANCE_PATH')) {
//    $classesPath = CRYPTOGLANCE_PATH . $classesPath;
//}
//
//$dir = new RecursiveDirectoryIterator($classesPath);
//
//foreach(new RecursiveIteratorIterator($dir) as $filepath => $file) {
//    if (preg_match('/\.php/i', $filepath)) {
//        require_once($filepath);
//    }
//}

//ini_set('display_errors',1);
//error_reporting(E_ALL);
function cgLoader($className) {
    $className = 'classes/' . $className;
//    if (defined('CRYPTOGLANCE_PATH')) {
//        $classesPath = CRYPTOGLANCE_PATH;
//    }
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    require $fileName;
}

spl_autoload_register('cgLoader');