<?php

namespace App\Controllers\Admin;

use App\Controllers\Base\BaseController;
use App\Models\AspirasiModel;
use App\Models\UserModel;
use App\Models\KategoriModel;

class Laporan extends BaseController
{
    protected $aspirasiModel;
    protected $userModel;
    protected $kategoriModel;
    
    public function __construct()
    {
        $this->aspirasiModel = new AspirasiModel();
        $this->userModel = new UserModel();
        $this->kategoriModel = new KategoriModel();
    }
    
    public function index()
    {
        $aspirasi = $this->aspirasiModel
            ->select('aspirasi.*, users.nama, users.nim, users.prodi, kategori.nama_kategori')
            ->join('users', 'users.id = aspirasi.user_id')
            ->join('kategori', 'kategori.id = aspirasi.kategori_id', 'left')
            ->orderBy('aspirasi.created_at', 'DESC')
            ->findAll();
        
        $data = [
            'title' => 'Laporan - Admin',
            'aspirasi_terbaru' => $aspirasi,
            'total_aspirasi' => count($aspirasi),
            'statistik_status' => $this->aspirasiModel->getStatistik(),
            'kategori_list' => $this->kategoriModel->findAll(),
            'filter_status' => '',
            'filter_kategori' => '',
            'filter_tanggal_awal' => '',
            'filter_tanggal_akhir' => '',
        ];
        
        return view('admin/laporan_index', $data);
    }
    
    public function filter()
    {
        $status = $this->request->getPost('status');
        $kategori = $this->request->getPost('kategori');
        $tanggal_awal = $this->request->getPost('tanggal_awal');
        $tanggal_akhir = $this->request->getPost('tanggal_akhir');
        
        $builder = $this->aspirasiModel
            ->select('aspirasi.*, users.nama, users.nim, users.prodi, kategori.nama_kategori')
            ->join('users', 'users.id = aspirasi.user_id')
            ->join('kategori', 'kategori.id = aspirasi.kategori_id', 'left');
        
        if (!empty($status)) {
            $builder->where('aspirasi.status', $status);
        }
        
        if (!empty($kategori)) {
            $builder->where('aspirasi.kategori_id', $kategori);
        }
        
        if (!empty($tanggal_awal)) {
            $builder->where('DATE(aspirasi.created_at) >=', $tanggal_awal);
        }
        
        if (!empty($tanggal_akhir)) {
            $builder->where('DATE(aspirasi.created_at) <=', $tanggal_akhir);
        }
        
        $aspirasi = $builder->orderBy('aspirasi.created_at', 'DESC')->findAll();
        
        $statistik_status = [];
        $statuses = ['pending', 'diproses', 'selesai', 'ditolak'];
        foreach ($statuses as $s) {
            $countBuilder = $this->aspirasiModel->where('status', $s);
            
            if (!empty($kategori)) {
                $countBuilder->where('kategori_id', $kategori);
            }
            if (!empty($tanggal_awal)) {
                $countBuilder->where('DATE(created_at) >=', $tanggal_awal);
            }
            if (!empty($tanggal_akhir)) {
                $countBuilder->where('DATE(created_at) <=', $tanggal_akhir);
            }
            
            $statistik_status[$s] = $countBuilder->countAllResults();
        }
        
        $data = [
            'title' => 'Laporan - Admin',
            'aspirasi_terbaru' => $aspirasi,
            'total_aspirasi' => count($aspirasi),
            'statistik_status' => $statistik_status,
            'kategori_list' => $this->kategoriModel->findAll(),
            'filter_status' => $status,
            'filter_kategori' => $kategori,
            'filter_tanggal_awal' => $tanggal_awal,
            'filter_tanggal_akhir' => $tanggal_akhir,
        ];
        
        return view('admin/laporan_index', $data);
    }
}