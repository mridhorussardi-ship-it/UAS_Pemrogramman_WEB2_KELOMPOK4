<?php

namespace App\Models;

use CodeIgniter\Model;

class KomentarModel extends Model
{
    protected $table = 'komentar';
    protected $primaryKey = 'id';
    protected $allowedFields = ['aspirasi_id', 'user_id', 'isi_komentar'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = false;
    
    public function getByAspirasi($aspirasiId)
    {
        return $this->select('komentar.*, users.nama')
                    ->join('users', 'users.id = komentar.user_id')
                    ->where('aspirasi_id', $aspirasiId)
                    ->orderBy('komentar.created_at', 'ASC')
                    ->findAll();
    }
    
    public function countByAspirasi($aspirasiId)
    {
        return $this->where('aspirasi_id', $aspirasiId)->countAllResults();
    }
}