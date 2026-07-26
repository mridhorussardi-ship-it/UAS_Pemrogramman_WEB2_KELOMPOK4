<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');
        
        if (!$authHeader) {
            return service('response')
                ->setJSON([
                    'status' => false,
                    'message' => 'Token tidak ditemukan'
                ])
                ->setStatusCode(401);
        }
        
        try {
            $token = str_replace('Bearer ', '', $authHeader);
            $key = getenv('JWT_SECRET_KEY');
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            
            service('request')->user = $decoded;
            
        } catch (\Exception $e) {
            return service('response')
                ->setJSON([
                    'status' => false,
                    'message' => 'Token tidak valid: ' . $e->getMessage()
                ])
                ->setStatusCode(401);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}