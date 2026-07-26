<?php

namespace App\Controllers\Dosen;

use App\Controllers\Base\BaseController;
use App\Models\AspirasiModel;
use App\Models\TanggapanModel;
use App\Models\KomentarModel;

class Aspirasi extends BaseController
{
    protected $aspirasiModel;
    protected $tanggapanModel;
    protected $komentarModel;
    
    public function __construct()
    {
        $this->aspirasiModel = new AspirasiModel();
        $this->tanggapanModel = new TanggapanModel();
        $this->komentarModel = new KomentarModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Daftar Aspirasi - Dosen',
            'aspirasi' => $this->aspirasiModel->getAllWithUser()
        ];
        
        return view('dosen/aspirasi_index', $data);
    }
    
    public function detail($id)
    {
        $aspirasi = $this->aspirasiModel->getDetail($id);
        
        if (!$aspirasi) {
            return redirect()->to('/dosen/aspirasi')->with('error', 'Aspirasi tidak ditemukan');
        }
        
        $komentar = $this->komentarModel->getByAspirasi($id);
        $tanggapan = $this->tanggapanModel->getByAspirasi($id);
        
        $data = [
            'title' => 'Detail Aspirasi - Dosen',
            'aspirasi' => $aspirasi,
            'komentar' => $komentar,
            'tanggapan' => $tanggapan
        ];
        
        return view('dosen/aspirasi_detail', $data);
    }
    
    public function addTanggapan($id)
    {
        $rules = [
            'isi_tanggapan' => 'required|min_length[3]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'aspirasi_id' => $id,
            'admin_id' => session()->get('user_id'),
            'isi_tanggapan' => $this->request->getPost('isi_tanggapan')
        ];
        
        $this->tanggapanModel->save($data);
        
        // Update status aspirasi menjadi 'diproses'
        $this->aspirasiModel->update($id, ['status' => 'diproses']);
        
        return redirect()->back()->with('success', 'Tanggapan berhasil ditambahkan!');
    }
    
    public function updateStatus($id)
    {
        $aspirasi = $this->aspirasiModel->find($id);
        
        if (!$aspirasi) {
            return redirect()->to('/dosen/aspirasi')->with('error', 'Aspirasi tidak ditemukan');
        }
        
        $status = $this->request->getPost('status');
        
        // Validasi status (dosen hanya bisa ubah ke diproses atau selesai)
        $validStatus = ['diproses', 'selesai'];
        if (!in_array($status, $validStatus)) {
            return redirect()->back()->with('error', 'Status tidak valid!');
        }
        
        // Update status
        $this->aspirasiModel->update($id, ['status' => $status]);
        
        // Tambahkan tanggapan otomatis jika ada
        $tanggapan = $this->request->getPost('tanggapan');
        if ($tanggapan) {
            $dataTanggapan = [
                'aspirasi_id' => $id,
                'admin_id' => session()->get('user_id'),
                'isi_tanggapan' => $tanggapan
            ];
            $this->tanggapanModel->save($dataTanggapan);
        }
        
        $statusLabel = [
            'diproses' => 'Diproses',
            'selesai' => 'Selesai'
        ];
        
        return redirect()->to('/dosen/aspirasi/' . $id)
                         ->with('success', 'Status berhasil diubah menjadi ' . $statusLabel[$status]);
    }
}