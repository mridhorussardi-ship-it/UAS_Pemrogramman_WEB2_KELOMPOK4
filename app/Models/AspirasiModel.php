<?php

namespace App\Models;

use CodeIgniter\Model;

class AspirasiModel extends Model
{
    protected $table = 'aspirasi';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'kategori_id', 'judul', 'isi', 
        'status', 'lampiran', 'is_anonymous'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    const STATUS_PENDING = 'pending';
    const STATUS_DIPROSES = 'diproses';
    const STATUS_SELESAI = 'selesai';
    const STATUS_DITOLAK = 'ditolak';
    
    public function getAllWithUser($limit = null)
    {
        $builder = $this->select('aspirasi.*, users.nama, users.nim, users.prodi, kategori.nama_kategori')
                        ->join('users', 'users.id = aspirasi.user_id')
                        ->join('kategori', 'kategori.id = aspirasi.kategori_id', 'left')
                        ->orderBy('aspirasi.created_at', 'DESC');
        
        if ($limit) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }
    
    public function getByUser($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
    
    public function getDetail($id)
    {
        return $this->select('aspirasi.*, users.nama, users.nim, users.prodi, kategori.nama_kategori')
                    ->join('users', 'users.id = aspirasi.user_id')
                    ->join('kategori', 'kategori.id = aspirasi.kategori_id', 'left')
                    ->where('aspirasi.id', $id)
                    ->first();
    }
    
    public function getStatistik()
    {
        $data = [];
        $statuses = ['pending', 'diproses', 'selesai', 'ditolak'];
        
        foreach ($statuses as $status) {
            $data[$status] = $this->where('status', $status)->countAllResults();
        }
        
        return $data;
    }
    
    // TAMBAHKAN METHOD INI!
    public function getByKategori()
    {
        return $this->select('kategori.nama_kategori, COUNT(aspirasi.id) as total')
                    ->join('kategori', 'kategori.id = aspirasi.kategori_id', 'left')
                    ->groupBy('kategori.id')
                    ->findAll();
    }
}