<?php
 // New Autoloader
function cgLoader($className) {
    $className = 'classes/' . strtolower($className);
//    if (defined('CRYPTOGLANCE_PATH')) { $classesPath = CRYPTOGLANCE_PATH; }
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