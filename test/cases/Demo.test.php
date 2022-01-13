<?php
use test\Assert;
use test\Test;


$test = new Test("Demo Test Case");

$test->test("Expect to values to be the same", function () {
    $a = 123;
    $b = 123;
    Assert::equals($a, $b);
});

$test->test("Expect to values to not be the same", function () {
    $a = 123;
    $b = 321;
    Assert::notEquals($a, $b);
});

$test->test("Expect a value to be true", function () {
    $a = true;
    Assert::true($a);
});

$test->test("Expect a value to be false", function () {
    $a = false;
    Assert::false($a);
});

$test->test("Expect a function to fail", function () {
    Assert::fail(function () {
        throw new Exception("This method failed");
    });
});

$test->run();