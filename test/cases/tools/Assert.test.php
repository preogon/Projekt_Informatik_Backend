<?php
use test\Assert;
use test\Test;

$test = new Test("Assert Test");

$test->test("Assert::equals", function () {
    $a = array("1"=>"1", "2"=>"2");
    $b = array("2"=>"2", "1"=>"1");
    $c = array("3"=>"3", "4"=>"4");

    Assert::equals($a, $b);
    Assert::equals($b, $a);
    Assert::fail(function() use($a, $c) {
        Assert::equals($a, $c);
    });
});

$test->test("Assert::strict_equals", function () {
    $a = array("1"=>"1", "2"=>"2");
    $b = array("2"=>"2", "1"=>"1");
    $c = array("3"=>"3", "4"=>"4");

    Assert::strict_equals($a, $a);
    Assert::fail(function() use($a, $b) {
        Assert::strict_equals($a, $b);
    });
    Assert::fail(function() use($a, $c) {
        Assert::strict_equals($a, $c);
    });
});

$test->test("Assert::notEquals", function () {
    $a = array("1"=>"1", "2"=>"2");
    $b = array("3"=>"3", "4"=>"4");
    $c = array("2"=>"2", "1"=>"1");

    Assert::notEquals($a, $b);
    Assert::notEquals($b, $a);
    Assert::fail(function() use($a, $c) {
        Assert::notEquals($a, $c);
    });
});

$test->test("Assert::strict_notEquals", function () {
    $a = array("1"=>"1", "2"=>"2");
    $b = array("1"=>"1", "2"=>"2");
    $c = array("2"=>"2", "1"=>"1");

    Assert::strict_notEquals($a, $c);
    Assert::fail(function () use($a, $b) {
        Assert::strict_notEquals($a, $b);
    });
});


$test->test("Assert::true", function () {
    Assert::true(true);
    Assert::fail(function () {
        Assert::true(false);
    });
});

$test->test("Assert::false", function () {
    Assert::false(false);
    Assert::fail(function () {
        Assert::false(true);
    });
});

$test->test("Assert::null", function () {
    Assert::null(null);
    Assert::fail(function () {
        Assert::null(false);
    });
});

$test->test("Assert::notNull", function () {
    Assert::notNull(false);
    Assert::fail(function () {
        Assert::notNull(null);
    });
});

$test->test("Assert::fail", function () {
    Assert::fail(function () {
        throw new Exception("FAIL");
    });

    Assert::fail(function () {
        Assert::fail(function () {
            return;
        });
    });
});

$test->run();