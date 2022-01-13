<?php
namespace Helpers;

class Files {
    /**
     * Uploads a file from $_FILES and returns the path to the file.
     * Uses FILES_DIR from config
     * @param array file File from $_FILES
     * @param int $limit Size limit in bytes to prevent uploading of large files
     * @return string Path of the uploaded file or "" if something went wrong
     */
    public static function upload (array $file, int $limit = 10000000):string {
        if(!$file) return "";

        if(!isset($file["size"])) return "";
        $size = $file["size"];

        if(!isset($file["tmp_name"])) return "";
        $tmp_name = $file["tmp_name"];

        if(!isset($file["name"])) return "";
        $file_name = $file["name"];

        $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if($size > $limit) return "";

        
        $base_dir = FILES_DIR . DIRECTORY_SEPARATOR . $extension;
        if(!file_exists($base_dir)) mkdir($base_dir, 0777, true);
        
        $randomPrefix = substr(hash_file("md5", $tmp_name),0,10);
        $dir = $base_dir . DIRECTORY_SEPARATOR . $randomPrefix;
        while(file_exists($dir)) {
            $randomPrefix = str_shuffle(substr(hash_file("md5", $tmp_name),0,10));
            $dir = $base_dir . DIRECTORY_SEPARATOR . $randomPrefix;
        }
        mkdir($dir, 0777, true);

        $path = $dir . DIRECTORY_SEPARATOR . $file_name;
        if(!move_uploaded_file($tmp_name, $path)) return "";
        return $path;
    }
}