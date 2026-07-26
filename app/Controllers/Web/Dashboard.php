<?php

namespace App\Controllers\Web;

use App\Controllers\Base\BaseController;
use App\Models\AspirasiModel;

class Dashboard extends BaseController
{
    protected $aspirasiModel;
    
    public function __construct()
    {
        $this->aspirasiModel = new AspirasiModel();
    }
    
    public function index()
    {
        $userId = session()->get('user_id');
        $role = session()->get('role');
        
        $data = [
            'title' => 'Dashboard - Sistem Aspirasi Mahasiswa',
            'total_aspirasi' => $this->aspirasiModel->countAll(),
            'aspirasi_saya' => $this->aspirasiModel->where('user_id', $userId)->countAllResults(),
            'statistik_status' => $this->aspirasiModel->getStatistik(),
            'aspirasi_terbaru' => $this->aspirasiModel->getByUser($userId)
        ];
        
        // Jika admin, tambahkan data tambahan
        if ($role === 'admin') {
            return redirect()->to('/admin/dashboard');
        }
        
        // Jika dosen, redirect ke dashboard dosen
        if ($role === 'dosen') {
            return redirect()->to('/dosen/dashboard');
        }
        
        return view('mahasiswa/dashboard', $data);
    }
}