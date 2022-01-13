<?php

use Helpers\Token;
use test\Assert;
use test\Test;

$test = new Test("Token Helper Test");

$test->test("Generate token", function () {
    $token = Token::generate("UserID", "UserRole");
    Assert::notNull($token);
});

$test->test("Verify correct token", function () {
    $token = Token::generate("UserID", "UserRole");
    $verified = Token::verify($token);
    Assert::true($verified);
});

$test->test("Verify false signature", function () {
    $token = Token::generate("UserID", "UserRole");
    $verified = Token::verify($token . "wrongSignature");
    Assert::false($verified);
});

$test->test("Verify wrong size", function () {
    $tokenParts = explode(".",Token::generate("UserID", "UserRole"));
    $verified = Token::verify("{$tokenParts[0]}.{$tokenParts[1]}");
    Assert::false($verified);
});

$test->test("Verify garbage", function () {
    $verified = Token::verify("SomeRandomTestAsGarbage");
    Assert::false($verified);
});

$test->test("Verify expired", function () {
    $head = array(
        "type"=>"CustomToken",
        "method"=>"sha256"
    );

    $payload = array(
        "user"=>"Admin",
        "expires"=>time() - 1
    );

    $head_encoded = urlencode(base64_encode(json_encode($head)));
    $payload_encoded = urlencode(base64_encode(json_encode($payload)));

    $content = "{$head_encoded}.{$payload_encoded}";
    $signature = urlencode(base64_encode(hash_hmac("sha256", $content, TOKEN_KEY)));

    $token = "{$content}.{$signature}";
    $verified = Token::verify($token);
    Assert::false($verified);
});

$test->test("Read Payload", function () {
    $token = Token::generate("UserID", "UserRole");
    $verified = Token::verify($token);
    Assert::true($verified);
    $payload = Token::payload($token);
    Assert::equals($payload["uid"], "UserID");
    Assert::equals($payload["role"], "UserRole");
});



$test->run();