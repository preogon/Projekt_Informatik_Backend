<?php
namespace test;

class Mock {


    /**
     * Sets a mocked request method
     * @param string $method method to mock
     */
    public static function request_method (string $method) {
        $_SERVER["REQUEST_METHOD"] = $method;
    }

    /**
     * Sets a mocked request path
     * @param string $path path to mock
     */
    public static function request_path (string $path) {
        $_SERVER["PHP_SELF"] = "/server/index.php";
        $_SERVER["REQUEST_URI"] = "/server{$path}";
    }


    /**
     * Sets mocked request GET parameters
     * @param array $params parameters to be mocked
     */
    public static function get_parameters (array $params) {
        $_GET = $params;
    }

    /**
     * Sets mocked request POST parameters
     * @param array $params parameters to be mocked
     */
    public static function post_parameters (array $params) {
        $_POST = $params;
    }

    /**
     * Sets mocked request FILES parameters
     * @param array $params parameters to be mocked
     */
    public static function files_parameters(array $params) {
        $_FILES = $params;
    }


}