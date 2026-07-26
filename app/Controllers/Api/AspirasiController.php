<?php

namespace App\Controllers\Api;

use App\Controllers\Base\BaseController;
use App\Models\AspirasiModel;
use App\Models\KategoriModel;
use App\Models\KomentarModel;

class AspirasiController extends BaseController
{
    protected $aspirasiModel;
    protected $kategoriModel;
    protected $komentarModel;
    
    public function __construct()
    {
        $this->aspirasiModel = new AspirasiModel();
        $this->kategoriModel = new KategoriModel();
        $this->komentarModel = new KomentarModel();
    }
    
    public function index()
    {
        $userId = service('request')->user->id ?? null;
        $role = service('request')->user->role ?? null;
        
        if ($role == 'admin' || $role == 'dosen') {
            $aspirasi = $this->aspirasiModel->getAllWithUser();
        } else {
            $aspirasi = $this->aspirasiModel->getByUser($userId);
        }
        
        return $this->response->setJSON([
            'status' => true,
            'total' => count($aspirasi),
            'data' => $aspirasi
        ]);
    }
    
    public function show($id)
    {
        $aspirasi = $this->aspirasiModel->getDetail($id);
        
        if (!$aspirasi) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Aspirasi tidak ditemukan'
            ])->setStatusCode(404);
        }
        
        $komentar = $this->komentarModel->getByAspirasi($id);
        $aspirasi['komentar'] = $komentar;
        
        return $this->response->setJSON([
            'status' => true,
            'data' => $aspirasi
        ]);
    }
    
    public function create()
    {
        $rules = [
            'judul' => 'required|min_length[5]|max_length[200]',
            'isi' => 'required|min_length[10]',
            'kategori_id' => 'required|numeric'
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ])->setStatusCode(400);
        }
        
        $data = [
            'user_id' => service('request')->user->id,
            'judul' => $this->request->getPost('judul'),
            'isi' => $this->request->getPost('isi'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'status' => 'pending',
            'is_anonymous' => $this->request->getPost('is_anonymous') ? 1 : 0
        ];
        
        $file = $this->request->getFile('lampiran');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('public/assets/uploads/aspirasi', $newName);
            $data['lampiran'] = $newName;
        }
        
        $this->aspirasiModel->save($data);
        $id = $this->aspirasiModel->getInsertID();
        
        return $this->response->setJSON([
            'status' => true,
            'message' => 'Aspirasi berhasil dikirim',
            'id' => $id
        ])->setStatusCode(201);
    }
    
    public function update($id)
    {
        $aspirasi = $this->aspirasiModel->find($id);
        
        if (!$aspirasi) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Aspirasi tidak ditemukan'
            ])->setStatusCode(404);
        }
        
        $userId = service('request')->user->id;
        $role = service('request')->user->role;
        
        if ($aspirasi['user_id'] != $userId && $role != 'admin') {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Anda tidak memiliki akses'
            ])->setStatusCode(403);
        }
        
        $data = $this->request->getJSON(true);
        
        if ($role == 'admin' && isset($data['status'])) {
            $this->aspirasiModel->update($id, ['status' => $data['status']]);
        }
        
        if ($aspirasi['user_id'] == $userId) {
            unset($data['status']);
            $this->aspirasiModel->update($id, $data);
        }
        
        return $this->response->setJSON([
            'status' => true,
            'message' => 'Aspirasi berhasil diupdate'
        ]);
    }
    
    public function delete($id)
    {
        $aspirasi = $this->aspirasiModel->find($id);
        
        if (!$aspirasi) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Aspirasi tidak ditemukan'
            ])->setStatusCode(404);
        }
        
        $userId = service('request')->user->id;
        $role = service('request')->user->role;
        
        if ($aspirasi['user_id'] != $userId && $role != 'admin') {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Anda tidak memiliki akses'
            ])->setStatusCode(403);
        }
        
        $this->aspirasiModel->delete($id);
        
        return $this->response->setJSON([
            'status' => true,
            'message' => 'Aspirasi berhasil dihapus'
        ]);
    }
}