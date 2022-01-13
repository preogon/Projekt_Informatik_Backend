<?php
/**
 * Setup script to create Database and htaccess
 */
include "config.php";

/**
 * Creates htaccess file with redirect on main.php except for files
 */
function htaccess () {
    $dir = FILES_DIR;
    $htacess = "Options -Indexes\n"
    . "<IfModule mod_rewrite.c>\n"
    . "\tRewriteEngine On\n"
    . "\tRewriteRule !^{$dir}/.*\..* main.php [L]\n"
    . "</IfModule>";

    file_put_contents(".htaccess", $htacess);
}



htaccess();