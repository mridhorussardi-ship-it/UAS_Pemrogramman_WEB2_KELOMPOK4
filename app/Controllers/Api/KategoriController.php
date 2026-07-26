<?php

namespace App\Controllers\Api;

use App\Controllers\Base\BaseController;
use App\Models\KategoriModel;

class KategoriController extends BaseController
{
    protected $kategoriModel;
    
    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }
    
    public function index()
    {
        $kategori = $this->kategoriModel->findAll();
        
        return $this->response->setJSON([
            'status' => true,
            'data' => $kategori
        ]);
    }
}