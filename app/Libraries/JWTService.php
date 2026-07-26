<?php

namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTService
{
    protected $key;
    protected $expiration;
    
    public function __construct()
    {
        $this->key = getenv('JWT_SECRET_KEY') ?: 'rahasia1234567890';
        $this->expiration = getenv('JWT_EXPIRATION') ?: 86400;
    }
    
    public function generateToken($user)
    {
        $payload = [
            'id' => $user['id'],
            'email' => $user['email'],
            'nama' => $user['nama'],
            'role' => $user['role'],
            'nim' => $user['nim'] ?? '',
            'prodi' => $user['prodi'] ?? '',
            'iat' => time(),
            'exp' => time() + (int)$this->expiration
        ];
        
        return JWT::encode($payload, $this->key, 'HS256');
    }
    
    public function validateToken($token)
    {
        try {
            $decoded = JWT::decode($token, new Key($this->key, 'HS256'));
            return (array) $decoded;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    public function getPayload($token)
    {
        try {
            $decoded = JWT::decode($token, new Key($this->key, 'HS256'));
            return (array) $decoded;
        } catch (\Exception $e) {
            return null;
        }
    }
}