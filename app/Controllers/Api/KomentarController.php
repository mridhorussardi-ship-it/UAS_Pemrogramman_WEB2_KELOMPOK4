<?php

namespace App\Controllers\Api;

use App\Controllers\Base\BaseController;
use App\Models\AspirasiModel;
use App\Models\KomentarModel;

class KomentarController extends BaseController
{
    protected $komentarModel;
    protected $aspirasiModel;
    
    public function __construct()
    {
        $this->komentarModel = new KomentarModel();
        $this->aspirasiModel = new AspirasiModel();
    }
    
    public function create($aspirasiId)
    {
        $aspirasi = $this->aspirasiModel->find($aspirasiId);
        
        if (!$aspirasi) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Aspirasi tidak ditemukan'
            ])->setStatusCode(404);
        }
        
        $rules = [
            'isi_komentar' => 'required|min_length[3]'
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ])->setStatusCode(400);
        }
        
        $data = [
            'aspirasi_id' => $aspirasiId,
            'user_id' => service('request')->user->id,
            'isi_komentar' => $this->request->getPost('isi_komentar')
        ];
        
        $this->komentarModel->save($data);
        
        return $this->response->setJSON([
            'status' => true,
            'message' => 'Komentar berhasil ditambahkan'
        ])->setStatusCode(201);
    }
}