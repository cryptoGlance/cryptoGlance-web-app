<?php

// Initial classes path
$classesPath = 'includes/classes';
if (defined('CRYPTOGLANCE_PATH')) {
    $classesPath = CRYPTOGLANCE_PATH . $classesPath;
}

$dir = new RecursiveDirectoryIterator($classesPath);

foreach(new RecursiveIteratorIterator($dir) as $filepath => $file) {
    if (preg_match('/\.php/i', $filepath)) {
        require_once($filepath);
    }
}