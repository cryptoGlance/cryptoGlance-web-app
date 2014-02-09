<?php

// Initial classes path
$classesPath = 'includes/classes';

$dir = new RecursiveDirectoryIterator($classesPath);

foreach(new RecursiveIteratorIterator($dir) as $filepath => $file) {

    if (preg_match('/\.php/i', $filepath)) {
        require_once($filepath);
    }
}