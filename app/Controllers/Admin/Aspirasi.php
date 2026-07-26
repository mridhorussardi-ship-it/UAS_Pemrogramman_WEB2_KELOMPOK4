<?php

namespace App\Controllers\Admin;

use App\Controllers\Base\BaseController;
use App\Models\AspirasiModel;
use App\Models\KomentarModel;
use App\Models\TanggapanModel;

class Aspirasi extends BaseController
{
    protected $aspirasiModel;
    protected $komentarModel;
    protected $tanggapanModel;
    
    public function __construct()
    {
        $this->aspirasiModel = new AspirasiModel();
        $this->komentarModel = new KomentarModel();
        $this->tanggapanModel = new TanggapanModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Kelola Aspirasi - Admin',
            'aspirasi' => $this->aspirasiModel->getAllWithUser()
        ];
        
        return view('admin/aspirasi_index', $data);
    }
    
    public function detail($id)
    {
        $aspirasi = $this->aspirasiModel->getDetail($id);
        
        if (!$aspirasi) {
            return redirect()->to('/admin/aspirasi')->with('error', 'Aspirasi tidak ditemukan');
        }
        
        $komentar = $this->komentarModel->getByAspirasi($id);
        $tanggapan = $this->tanggapanModel->getByAspirasi($id);
        
        $data = [
            'title' => 'Detail Aspirasi - Admin',
            'aspirasi' => $aspirasi,
            'komentar' => $komentar,
            'tanggapan' => $tanggapan
        ];
        
        return view('admin/aspirasi_detail', $data);
    }
    
    public function updateStatus($id)
    {
        $aspirasi = $this->aspirasiModel->find($id);
        
        if (!$aspirasi) {
            return redirect()->to('/admin/aspirasi')->with('error', 'Aspirasi tidak ditemukan');
        }
        
        $status = $this->request->getPost('status');
        
        // Validasi status
        $validStatus = ['pending', 'diproses', 'selesai', 'ditolak'];
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
            'pending' => 'Pending',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak'
        ];
        
        return redirect()->to('/admin/aspirasi/' . $id)
                         ->with('success', 'Status berhasil diubah menjadi ' . $statusLabel[$status]);
    }
}