<?php

namespace App\Controllers\Api;

use App\Controllers\Base\BaseController;
use App\Models\UserModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    public function register()
    {
        $rules = [
            'role' => 'required|in_list[mahasiswa,dosen]',
            'nim' => 'required|is_unique[users.nim]|min_length[5]|max_length[20]',
            'nama' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'prodi' => 'required'
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ])->setStatusCode(400);
        }
        
        $data = [
            'nim' => $this->request->getPost('nim'),
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'prodi' => $this->request->getPost('prodi'),
            'role' => $this->request->getPost('role'),
            'is_active' => 1,
        ];
        
        $this->userModel->save($data);
        
        return $this->response->setJSON([
            'status' => true,
            'message' => 'Registrasi berhasil! Silakan login.'
        ])->setStatusCode(201);
    }
    
    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        $user = $this->userModel->where('email', $email)->first();
        
        if (!$user) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Email tidak ditemukan'
            ])->setStatusCode(401);
        }
        
        if (!password_verify($password, $user['password'])) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Password salah'
            ])->setStatusCode(401);
        }
        
        if (!$user['is_active']) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Akun Anda tidak aktif'
            ])->setStatusCode(401);
        }
        
        $key = getenv('JWT_SECRET_KEY');
        $payload = [
            'id' => $user['id'],
            'email' => $user['email'],
            'role' => $user['role'],
            'nama' => $user['nama'],
            'iat' => time(),
            'exp' => time() + (int)getenv('JWT_EXPIRATION')
        ];
        
        $token = JWT::encode($payload, $key, 'HS256');
        
        return $this->response->setJSON([
            'status' => true,
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => [
                'id' => $user['id'],
                'nama' => $user['nama'],
                'email' => $user['email'],
                'role' => $user['role'],
                'nim' => $user['nim'],
                'prodi' => $user['prodi']
            ]
        ]);
    }
    
    public function logout()
    {
        return $this->response->setJSON([
            'status' => true,
            'message' => 'Logout berhasil'
        ]);
    }
    
    public function me()
    {
        $user = service('request')->user;
        
        return $this->response->setJSON([
            'status' => true,
            'user' => $user
        ]);
    }
}