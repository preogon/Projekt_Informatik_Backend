<?php
namespace base;

class API {
    private array $actions = array();

    public function __construct () {
        $this->set_header();
    }

    /**
     * Sets the headers for requests response
     * @return void
     */
    private function set_header ():void {
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Credentials: true');
        header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Authorization, Content-Type,Accept, Origin");
        header("Content-Type: application/json; charset=utf-8");
    }

    /**
     * Gets path from requested url (relative to executing php file)
     * @return string
     */
    private function get_path ():string {
        $prefix = dirname($_SERVER["PHP_SELF"]);
        $path = parse_url($_SERVER["REQUEST_URI"])["path"];
        $path = substr($path, strlen($prefix));
        return $path;
    }

    /**
     * Gets the method of current request
     * @return string
     */
    private function get_method ():string {
        return $_SERVER["REQUEST_METHOD"];
    }

    /**
     * Matches request properties with registered action
     * @param array $action registered action
     */
    private function match (array $action):bool {
        $PATH = $this->get_path() === $action["path"];
        $METHOD = $this->get_method() === $action["method"];
        return $PATH && $METHOD;
    }

    /**
     * Parses Array to JSON
     * @param array $data array to parse
     * @return string
     */
    private function parse_json (array $data):string {
        $mask = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES; // | JSON_PRETTY_PRINT
        return json_encode($data, $mask);
    }

    /**
     * Registers an action to the API
     * @param string $path request path to trigger action
     * @param string $method request method to trigger action
     * @param mixed ...$handlers namespaced classnames of actions to execute
     */
    public function register (string $path, string $method, ...$handlers):void {
        foreach ($handlers as $action) {
            array_push($this->actions, array(
                "path"=>$path,
                "method"=>$method,
                "action"=>$action
            ));
        }
    }

    /**
     * Executes matching commands and echos resulting data
    */
    public function execute ():void {
        $result = array();
        
        foreach ($this->actions as $action) {
            if(!$this->match($action)) continue;
            $handler = new $action["action"]();
            $result = array_merge($result, $handler->execute());
        }

        echo $this->parse_json($result);
    }

}