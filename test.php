<?php
// Configuration
$root_dir = __DIR__ . "/src/";
$test_dir = __DIR__ . "/test/";
$test_extension = ".test.php";
error_reporting(0);
$target = isset($argv[1]) ? $argv[1] : "";


// AutoLoad Content Classes
spl_autoload_register(function ($className) use ($root_dir) {
    $fileName = '';
    if ($lastNameSpacePosition = strpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNameSpacePosition);
        $className = substr($className, $lastNameSpacePosition + 1);
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className);
    if (is_file($root_dir . $fileName . '.php')) {
        require_once $root_dir . $fileName . '.php';
    }
});

// load configuration file
include "config.test.php";


//AutoLoad all test Files
function auto_load_tests(string $test_extension, string $test_dir, string $target)
{
    $directory_iterator = new RecursiveDirectoryIterator($test_dir . 'base');
    foreach (new RecursiveIteratorIterator($directory_iterator) as $filename => $__) {
        if (is_file($filename) && !is_dir($filename) && substr($filename, -strlen(".php")) === ".php") {
            require_once($filename);
        }
    }


    $directory_iterator = new RecursiveDirectoryIterator($test_dir . 'cases');
    foreach (new RecursiveIteratorIterator($directory_iterator) as $filename => $__) {
        if (is_file($filename) && !is_dir($filename) && substr($filename, -strlen($test_extension)) === $test_extension) {
            if (!$target) {
                require_once($filename);
                continue;
            }
            $name = substr($filename, - (strlen($target) + strlen($test_extension) + 1));
            if (substr($name, 0, 1) !== DIRECTORY_SEPARATOR) continue;
            $name = substr($name, 1, strlen($target));
            if ($name !== $target) continue;
            require_once($filename);
        }
    }
}
auto_load_tests($test_extension, $test_dir, $target);

\test\Test::printResults();
