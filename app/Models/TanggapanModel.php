<?php

namespace App\Models;

use CodeIgniter\Model;

class TanggapanModel extends Model
{
    protected $table = 'tanggapan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['aspirasi_id', 'admin_id', 'isi_tanggapan'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = false;
    
    public function getByAspirasi($aspirasiId)
    {
        return $this->select('tanggapan.*, users.nama')
                    ->join('users', 'users.id = tanggapan.admin_id')
                    ->where('aspirasi_id', $aspirasiId)
                    ->orderBy('tanggapan.created_at', 'DESC')
                    ->findAll();
    }
}