<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nim', 'nama', 'email', 'password', 
        'role', 'prodi', 'foto', 'is_active'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    public function getMahasiswa()
    {
        return $this->where('role', 'mahasiswa')->findAll();
    }
    
    public function getDosen()
    {
        return $this->where('role', 'dosen')->findAll();
    }
    
    public function getAdmin()
    {
        return $this->where('role', 'admin')->findAll();
    }
}