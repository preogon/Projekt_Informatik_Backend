<?php
use test\Assert;
use test\Mock;
use test\Test;

$test = new Test("Mock Test");

$test->test("Mock Request Method", function () {
    Mock::request_method("GET");
    Assert::strict_equals($_SERVER["REQUEST_METHOD"], "GET");
});

$test->test("Mock Request Path", function () {
    Mock::request_path("/test");
    Assert::equals($_SERVER["REQUEST_URI"], "/server/test");
});

$test->test("Mock GET Parameters", function () {
    Mock::get_parameters(array("id"=>"test"));
    Assert::equals($_GET, array("id"=>"test"));
});

$test->test("Mock POST Parameters", function () {
    Mock::post_parameters(array("id"=>"test"));
    Assert::equals($_POST, array("id"=>"test"));
});

$test->test("Mock FILES Parameters", function () {
    Mock::files_parameters(array(
        "mockFile" => array(
            "name" => "MockFile.txt",
            "type" => "text/plain",
            "tmp_name" => "/tmp/txt/tempname",
            "error" => 0,
            "size" => 123
        )
    ));
    Assert::equals($_FILES["mockFile"]["name"], "MockFile.txt");
    Assert::equals($_FILES["mockFile"]["type"], "text/plain");
    Assert::equals($_FILES["mockFile"]["tmp_name"], "/tmp/txt/tempname");
    Assert::equals($_FILES["mockFile"]["error"], 0);
    Assert::equals($_FILES["mockFile"]["size"], 123);
});

$test->run();