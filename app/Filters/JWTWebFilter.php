<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Libraries\JWTService;

class JWTWebFilter implements FilterInterface
{
    protected $jwtService;
    
    public function __construct()
    {
        $this->jwtService = new JWTService();
    }
    
    public function before(RequestInterface $request, $arguments = null)
    {
        $token = session()->get('jwt_token');
        
        if (!$token) {
            return redirect()->to('/login')->with('error', 'Silakan login dengan JWT terlebih dahulu');
        }
        
        $payload = $this->jwtService->validateToken($token);
        
        if (!$payload) {
            session()->remove('jwt_token');
            return redirect()->to('/login')->with('error', 'JWT Token tidak valid atau expired. Silakan login ulang.');
        }
        
        service('request')->jwt_payload = $payload;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}