<?php

namespace App\Controllers\Admin;

use App\Controllers\Base\BaseController;
use App\Models\AspirasiModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $aspirasiModel;
    protected $userModel;
    
    public function __construct()
    {
        $this->aspirasiModel = new AspirasiModel();
        $this->userModel = new UserModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Dashboard Admin',
            'total_aspirasi' => $this->aspirasiModel->countAll(),
            'total_mahasiswa' => $this->userModel->where('role', 'mahasiswa')->countAllResults(),
            'total_dosen' => $this->userModel->where('role', 'dosen')->countAllResults(),
            'statistik_status' => $this->aspirasiModel->getStatistik(),
            'aspirasi_terbaru' => $this->aspirasiModel->getAllWithUser(10)
        ];
        
        return view('admin/dashboard', $data);
    }
}