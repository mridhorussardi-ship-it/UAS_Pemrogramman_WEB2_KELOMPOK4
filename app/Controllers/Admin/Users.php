<?php

namespace App\Controllers\Admin;

use App\Controllers\Base\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Kelola User - Admin',
            'users' => $this->userModel->findAll()
        ];
        
        return view('admin/users_index', $data);
    }
    
    public function detail($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan');
        }
        
        $data = [
            'title' => 'Detail User - Admin',
            'user' => $user
        ];
        
        return view('admin/users_detail', $data);
    }
    
    public function edit($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan');
        }
        
        // Cegah edit admin lain (kecuali diri sendiri)
        if ($user['role'] == 'admin' && $user['id'] != session()->get('user_id')) {
            return redirect()->to('/admin/users')->with('error', 'Tidak bisa mengedit admin lain!');
        }
        
        $data = [
            'title' => 'Edit User - Admin',
            'user' => $user
        ];
        
        return view('admin/users_edit', $data);
    }
    
    public function update($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan');
        }
        
        // Cegah edit admin lain
        if ($user['role'] == 'admin' && $user['id'] != session()->get('user_id')) {
            return redirect()->to('/admin/users')->with('error', 'Tidak bisa mengedit admin lain!');
        }
        
        $rules = [
            'nama' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email',
            'prodi' => 'required',
            'role' => 'required|in_list[mahasiswa,dosen,admin]',
            'is_active' => 'required|in_list[0,1]'
        ];
        
        // Validasi email unik (kecuali email sendiri)
        if ($this->request->getPost('email') != $user['email']) {
            $rules['email'] .= '|is_unique[users.email]';
        }
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'prodi' => $this->request->getPost('prodi'),
            'role' => $this->request->getPost('role'),
            'is_active' => $this->request->getPost('is_active'),
        ];
        
        // Update password jika diisi
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        
        $this->userModel->update($id, $data);
        
        return redirect()->to('/admin/users')->with('success', 'User berhasil diupdate!');
    }
    
    public function delete($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan');
        }
        
        // Cegah hapus admin lain
        if ($user['role'] == 'admin') {
            return redirect()->to('/admin/users')->with('error', 'Tidak bisa menghapus admin!');
        }
        
        // Cegah hapus diri sendiri
        if ($user['id'] == session()->get('user_id')) {
            return redirect()->to('/admin/users')->with('error', 'Tidak bisa menghapus akun sendiri!');
        }
        
        $this->userModel->delete($id);
        
        return redirect()->to('/admin/users')->with('success', 'User berhasil dihapus!');
    }
    
    public function toggleStatus($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan');
        }
        
        // Cegah nonaktifkan admin lain
        if ($user['role'] == 'admin' && $user['id'] != session()->get('user_id')) {
            return redirect()->to('/admin/users')->with('error', 'Tidak bisa menonaktifkan admin lain!');
        }
        
        $newStatus = $user['is_active'] ? 0 : 1;
        $this->userModel->update($id, ['is_active' => $newStatus]);
        
        $statusText = $newStatus ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->to('/admin/users')->with('success', 'User berhasil ' . $statusText . '!');
    }
}