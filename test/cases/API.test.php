<?php
use test\Assert;
use test\Mock;
use test\Test;

use base\API;

$test = new Test("API instance Test");

$test->test("Create instance", function () {
    $API = new API();
    Assert::notNull($API);
});

$test->test("Execute", function () {
    $API = new API();
    $API->execute();
});

$test->test("Register Demo Handler", function () {
    $API = new API();
    $API->register("/test", "GET", "Actions\Demo");
});

$test->test("Execute Demo Handler", function () {
    Mock::request_method("GET");
    Mock::request_path("/test");

    $API = new API();
    $API->register("/test", "GET", "Actions\Demo");
    $API->execute();
});

$test->test("Using multiple Handlers", function () {
    Mock::request_method("GET");
    Mock::request_path("/test");

    $API = new API();
    $API->register("/test", "GET", "Actions\Demo", "Actions\Demo");
    $API->execute();
});

$test->run();