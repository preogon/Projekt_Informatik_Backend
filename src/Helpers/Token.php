<?php
namespace Helpers;

class Token {

    private static function base64url_encode ($data) {
        $b64 = base64_encode($data);
        if ($b64 === false) return false;
        $url = strtr($b64, '+/', '-_');
        return rtrim($url, '=');
    }

    private static function base64url_decode ($data, $strict = false) {
        $b64 = strtr($data, '-_', '+/');
        return base64_decode($b64, $strict);
    }

    /**
     * Generates and returns a token.
     * Uses TOKEN_KEY in config.
     * @param string $uid User Id to store in token
     * @param string $role User Role to store in token
     * @return string Encoded token
     */
    public static function generate (string $uid, string $role):string {
        $head = array(
            "typ"=>"JWT",
            "alg"=>"sha256"
        );

        $payload = array(
            "uid"=>$uid,
            "role"=>$role,
            "exp"=>time() + (1 * 60 * 60 * 24)
        );

        $head_encoded = self::base64url_encode(json_encode($head));
        $payload_encoded = self::base64url_encode(json_encode($payload));

        $content = "{$head_encoded}.{$payload_encoded}";
        $signature = self::base64url_encode(hash_hmac("sha256", $content, TOKEN_KEY));

        return "{$content}.{$signature}";
    }


    /**
     * Verifies a given token.
     * @param string $token Encoded token to verify
     * @return bool True if token is valid
     */
    public static function verify (string $token):bool {
        $parts = explode(".", $token);
        if(count($parts) !== 3) return false;

        $head = json_decode(self::base64url_decode($parts[0]), true);        
        $payload = json_decode(self::base64url_decode($parts[1]), true);
        $signature = self::base64url_decode($parts[2]);

        if(!isset($head["alg"])) return false;
        if(!isset($payload["uid"])) return false;
        if(!isset($payload["role"])) return false;
        if(!isset($payload["exp"])) return false;
        if(time() > $payload["exp"]) return false;

        $check = hash_hmac("sha256", "{$parts[0]}.{$parts[1]}", TOKEN_KEY);
        if(!hash_equals($check, $signature)) return false;

        return true;
    }

    /**
     * Decodes and returns the payload of a token
     * @param string $token encoded token
     * @return array Payload of the token
     */
    public static function payload (string $token):array {
        $parts = explode(".", $token);
        $payload = json_decode(self::base64url_decode($parts[1]), true);
        return $payload;
    }
}