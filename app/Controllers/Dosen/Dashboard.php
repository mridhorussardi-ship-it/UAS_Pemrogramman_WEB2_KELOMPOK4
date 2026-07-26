<?php

namespace App\Controllers\Dosen;

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
        $data = [
            'title' => 'Dashboard Dosen - Sistem Aspirasi Mahasiswa',
            'total_aspirasi' => $this->aspirasiModel->countAll(),
            'statistik_status' => $this->aspirasiModel->getStatistik(),
            'aspirasi_terbaru' => $this->aspirasiModel->getAllWithUser(10)
        ];
        
        return view('dosen/dashboard', $data);
    }
}