<?php
namespace App\Http;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JWToken
{
    private static $secret;

    
    public static function generateTokenUser(array $data = [], int $expiration = 3600): string|array
    {
        try {
            
            self::$secret = $_ENV["USER_SECRET_KEY"];
            
            
            $data["iat"] = time(); 
            $data["exp"] = time() + $expiration; 
            
            
            return JWT::encode($data, self::$secret, "HS256");
        } catch (Exception $e) {
           
            return ["error" => $e->getMessage()];
        }
    }

    public static function generateTokenDev(array $data = [], int $expiration = 3600): string|array
    {
        try {
            
            self::$secret = $_ENV["DEV_SECRET_KEY"];
            
            return JWT::encode($data, self::$secret, "HS256");
        } catch (Exception $e) {
           
            return ["error" => $e->getMessage()];
        }
    }

    
    public static function validateTokenUser(string $token): ?object
    {
        try {
            self::$secret = $_ENV["USER_SECRET_KEY"];
            // Decodifica e valida o token
            return JWT::decode($token, new Key(self::$secret, "HS256"));
        } catch (Exception $e) {
            
            return null;
        }
    }

    public static function validateTokenDev(string $token): ?object
    {
        try {
            self::$secret = $_ENV["DEV_SECRET_KEY"];
            // Decodifica e valida o token
            return JWT::decode($token, new Key(self::$secret, "HS256"));
        } catch (Exception $e) {
            
            return null;
        }
    }
}