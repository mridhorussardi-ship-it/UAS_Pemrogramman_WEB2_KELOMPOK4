<?php

namespace App\Controllers\Base;

use CodeIgniter\Controller;

class BaseController extends Controller
{
    protected $helpers = ['url', 'form', 'text', 'date', 'html'];
    
    protected $session;
    protected $db;
    
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
        
        date_default_timezone_set('Asia/Jakarta');
        
        // Set data user ke semua view
        if ($this->session->get('isLoggedIn')) {
            $userData = [
                'id' => $this->session->get('user_id'),
                'nama' => $this->session->get('nama'),
                'email' => $this->session->get('email'),
                'role' => $this->session->get('role'),
                'nim' => $this->session->get('nim'),
                'prodi' => $this->session->get('prodi'),
            ];
            
            // Set view data dengan cara yang benar
            \Config\Services::renderer()->setData(['user' => $userData]);
        }
    }
    
    protected function responseSuccess($data = null, $message = 'Success', $code = 200)
    {
        return $this->response->setJSON([
            'status' => true,
            'message' => $message,
            'data' => $data,
            'timestamp' => date('Y-m-d H:i:s')
        ])->setStatusCode($code);
    }
    
    protected function responseError($message = 'Error', $errors = null, $code = 400)
    {
        return $this->response->setJSON([
            'status' => false,
            'message' => $message,
            'errors' => $errors,
            'timestamp' => date('Y-m-d H:i:s')
        ])->setStatusCode($code);
    }
}