<?php

namespace base;

class Action {

    public function __construct () {}

    /**
     * Preprocesses parameters from request and returns them
     * @return array
     */
    protected function parameters ():array {
        return array();
    }

    /**
     * Action logic goes here
     * @param array $parameters parameters given from parameters method
     * @return array
     */
    protected function action (array $parameters):array {
        return $parameters;
    }


    /**
     * Postprocessing the result of action
     * @param array $result return of action method
     * @return array
     */
    protected function postprocess (array $result):array {
        return $result;
    }


    /**
     * Executes the action. Gets called from API
     * @return array
     */
    public function execute ():array {
        return $this->postprocess(
            $this->action(
                $this->parameters()
            )
        );
    }
}