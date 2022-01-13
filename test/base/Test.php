<?php

namespace test;
use Exception;

class Test {
    private $_before_all = array();
    private $_after_all = array();
    private $_tests = array();

    private static $_result_total = 0;
    private static $_result_passed = 0;
    private static $_result_failed = 0;

    private $_description = "Some Test";

    public function __construct(string $description) {
        $this->_description = $description;
    }

    public function beforeAll(callable $function) {
        array_push($this->_before_all, $function);
    }

    public function afterAll(callable $function) {
        array_push($this->_after_all, $function);
    }

    public function test(string $description, callable $function) {
        array_push($this->_tests, array("description"=>$description, "function"=>$function));
    }

    public function run() {
        self::$_result_total += 1;

        $failed = 0;
        $passed = 0;
        $total = 0;
        echo "---\n";

        foreach($this->_tests as $test) {
            $total += 1;
            echo " | \e[1;37;40m {$test["description"]} \e[0m";

            try {
                foreach($this->_before_all as $before) { $before(); }
                
                $test["function"]();

                foreach($this->_after_all as $after) { $after(); }

                echo "\e[0;30;42m PASS \e[0m\n";
                $passed += 1;
            } catch (Exception $e) {
                echo "\e[1;37;41m FAIL \e[0m {$e->getMessage()}\n";
                $failed += 1;
            }
        }
        echo "---\n";
        if($passed == $total) {
            echo " | \e[0;30;42m {$this->_description} \e[0m\n";
            self::$_result_passed += 1;
        }
        if($passed != $total) {
            echo " | \e[1;37;41m {$this->_description} \e[0m\n";
            self::$_result_failed += 1;
        }
        echo " | Total Tests: {$total}\n";
        echo " | Passed: \e[0;32m{$passed}\e[0m\n";
        echo " | Failed: \e[0;31m{$failed}\e[0m\n";
        echo "---\n\n\n";
    }

    public static function printResults() {
        $passed = self::$_result_passed;
        $failed = self::$_result_failed;
        $total = self::$_result_total;
        echo "\n";
        if(!$failed) {
            echo "\e[0;30;42m ALL TESTS PASSED \e[0m\n";
            echo "Total Tests: {$total}\n";
        }
        else {
            echo "\e[0;37;41m SOME TESTS FAILED \e[0m\n";
            echo "Passed: \e[0;32m{$passed}\e[0m\n";
            echo "Failed: \e[0;31m{$failed}\e[0m\n";
        }

    }

}