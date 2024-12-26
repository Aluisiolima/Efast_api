<?php
namespace App\Http;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWToken
{
    private static $secret;

    
    public static function generateToken(array $data = [], int $expiration = 3600): string|array
    {
        try {
            
            self::$secret = $_ENV['SECRET_KEY'];
            
            
            $data['iat'] = time(); 
            $data['exp'] = time() + $expiration; 
            
            
            return JWT::encode($data, self::$secret, 'HS256');
        } catch (\Exception $e) {
           
            return ['error' => $e->getMessage()];
        }
    }

    
    public static function validateToken(string $token): ?object
    {
        try {
            self::$secret = $_ENV['SECRET_KEY'];
            // Decodifica e valida o token
            return JWT::decode($token, new Key(self::$secret, 'HS256'));
        } catch (\Exception $e) {
            
            return null;
        }
    }
}