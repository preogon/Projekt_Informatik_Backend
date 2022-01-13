<?php
// Configuration
$root_dir = __DIR__ . "/src/";
$main_file = $root_dir . "index.php";

// AutoLoad Classes
spl_autoload_register(function($className) use($root_dir){
    $fileName = '';
    if($lastNameSpacePosition = strpos($className,'\\')){
        $namespace = substr($className, 0, $lastNameSpacePosition);
        $className = substr($className, $lastNameSpacePosition + 1);
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className);
    if(is_file($root_dir . $fileName . '.php')){
    require_once $root_dir . $fileName . '.php';
    }
});

// load configuration file
include "config.php";

// run main file
include $main_file;