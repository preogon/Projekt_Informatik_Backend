<?php

namespace Actions;

use base\Action;

class Demo extends Action {

    protected function parameters():array {
        $var = isset($_GET["var"]) ? $_GET["var"] : "";
        return array(
            "var"=>$var
        );
    }

    protected function action (array $parameters):array {
        return array(
            "message"=>"It Works!",
            "var"=>$parameters["var"]
        );
    } 

}