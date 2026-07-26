<?php

namespace App\Controllers\Web;

use App\Controllers\Base\BaseController;
use App\Models\UserModel;
use App\Libraries\JWTService;

class Auth extends BaseController
{
    protected $userModel;
    protected $jwtService;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->jwtService = new JWTService();
    }
    
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        
        $data = ['title' => 'Login - Sistem Aspirasi'];
        return view('auth/login', $data);
    }
    
    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        
        $data = ['title' => 'Register - Sistem Aspirasi'];
        return view('auth/register', $data);
    }
    
    public function processLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $useJWT = $this->request->getPost('use_jwt') ? true : false;
        
        $user = $this->userModel->where('email', $email)->first();
        
        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan!');
        }
        
        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah!');
        }
        
        // Set Session
        session()->set([
            'isLoggedIn' => true,
            'user_id' => $user['id'],
            'nama' => $user['nama'],
            'email' => $user['email'],
            'role' => $user['role'],
            'nim' => $user['nim'],
            'prodi' => $user['prodi'],
        ]);
        
        // Jika pakai JWT
        if ($useJWT) {
            $token = $this->jwtService->generateToken($user);
            session()->set('jwt_token', $token);
        }
        
        // Redirect berdasarkan role
        if ($user['role'] === 'admin') {
            return redirect()->to('/admin/dashboard')->with('success', 'Selamat datang Admin!');
        } elseif ($user['role'] === 'dosen') {
            return redirect()->to('/dosen/dashboard')->with('success', 'Selamat datang Dosen!');
        } else {
            return redirect()->to('/dashboard')->with('success', 'Selamat datang, ' . $user['nama']);
        }
    }
    
    public function processRegister()
    {
        $rules = [
            'role' => 'required|in_list[mahasiswa,dosen]',
            'nim' => 'required|is_unique[users.nim]|min_length[5]|max_length[20]',
            'nama' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'konfirmasi_password' => 'required|matches[password]',
            'prodi' => 'required'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
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
        
        $roleName = $this->request->getPost('role') === 'dosen' ? 'Dosen' : 'Mahasiswa';
        return redirect()->to('/login')->with('success', 'Registrasi ' . $roleName . ' berhasil!');
    }
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah logout.');
    }
    
    public function getToken()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Silakan login terlebih dahulu'
            ])->setStatusCode(401);
        }
        
        $user = [
            'id' => session()->get('user_id'),
            'nama' => session()->get('nama'),
            'email' => session()->get('email'),
            'role' => session()->get('role'),
            'nim' => session()->get('nim'),
            'prodi' => session()->get('prodi'),
        ];
        
        $token = $this->jwtService->generateToken($user);
        
        return $this->response->setJSON([
            'status' => true,
            'token' => $token,
            'message' => 'JWT Token berhasil digenerate'
        ]);
    }
    
    public function verifyToken()
    {
        $token = $this->request->getGet('token');
        
        if (!$token) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Token tidak ditemukan'
            ]);
        }
        
        $payload = $this->jwtService->validateToken($token);
        
        if (!$payload) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Token tidak valid atau expired'
            ]);
        }
        
        return $this->response->setJSON([
            'status' => true,
            'message' => 'Token valid',
            'payload' => $payload
        ]);
    }
}