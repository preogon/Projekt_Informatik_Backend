<?php

use Helpers\SQLite;
use test\Assert;
use test\Test;

$test = new Test("SQLite Helper Test");

$filename = "sqlite.helper.test.sqlite";

$test->beforeAll(function () use($filename) {
    file_put_contents($filename, "");
});

$test->afterAll(function () use($filename) {
    unlink($filename);
});

$test->test("Create SQLite instance", function () use($filename) {
    $SQLite = new SQLite($filename);
    Assert::notNull($SQLite);
});

$test->test("Fetch data from empty table", function () use($filename) {
    $SQLite = new SQLite($filename);
    $data = $SQLite->execute("SELECT * FROM MYTABLE;");
    Assert::equals($data, array());
});

$test->test("Create table", function () use($filename) {
    $SQLite = new SQLite($filename);
    $SQLite->execute("CREATE TABLE MYTABLE(ID TEXT PRIMARY KEY);");
});

$test->test("Insert to table", function () use($filename) {
    $SQLite = new SQLite($filename);
    $SQLite->execute("CREATE TABLE MYTABLE(ID TEXT PRIMARY KEY);");
    $SQLite->execute("INSERT INTO MYTABLE(ID) VALUES('1');");
});

$test->test("Fetch from table", function () use($filename) {
    $SQLite = new SQLite($filename);
    $SQLite->execute("CREATE TABLE MYTABLE(ID TEXT PRIMARY KEY);");
    $SQLite->execute("INSERT INTO MYTABLE(ID) VALUES('1');");
    $data = $SQLite->execute("SELECT * FROM MYTABLE;");
    Assert::equals($data, array(array("ID"=>"1")));
});

$test->test("Use statement params", function () use($filename) {
    $SQLite = new SQLite($filename);
    $SQLite->execute("CREATE TABLE MYTABLE(ID TEXT PRIMARY KEY);");
    $SQLite->execute("INSERT INTO MYTABLE(ID) VALUES('1');");
    $data = $SQLite->execute(
        "SELECT * FROM MYTABLE WHERE ID = :id",
        array(":id"=>"1")
    );
    Assert::equals($data, array(array("ID"=>"1")));
});

$test->run();