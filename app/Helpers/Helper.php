<?php
namespace App\Helpers;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Helper
{
    public static function genKey()
    {
        $key = env('JWT_SECRET');
        $payload = array(
            "iat" => time(),
            "exp" => time() + env('JWT_EXPIRATION_TIME'),
            "nbf" => time() + env('JWT_START_TIME')
        );
        $jwt = JWT::encode($payload, $key, 'HS256');
        return $jwt;
    }
}