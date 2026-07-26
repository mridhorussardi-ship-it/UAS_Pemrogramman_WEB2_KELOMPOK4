<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nim' => '20230001',
                'nama' => 'Admin Sistem',
                'email' => 'admin@aspirasi.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'prodi' => 'Sistem Informasi',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nim' => '19900001',
                'nama' => 'Dr. Budi Santoso',
                'email' => 'budi@dosen.ac.id',
                'password' => password_hash('dosen123', PASSWORD_DEFAULT),
                'role' => 'dosen',
                'prodi' => 'Teknik Informatika',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nim' => '19900002',
                'nama' => 'Dr. Ani Wijaya',
                'email' => 'ani@dosen.ac.id',
                'password' => password_hash('dosen123', PASSWORD_DEFAULT),
                'role' => 'dosen',
                'prodi' => 'Sistem Informasi',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nim' => '20230003',
                'nama' => 'Andi Pratama',
                'email' => 'andi@student.ac.id',
                'password' => password_hash('mahasiswa123', PASSWORD_DEFAULT),
                'role' => 'mahasiswa',
                'prodi' => 'Sistem Informasi',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nim' => '20230004',
                'nama' => 'Siti Rahayu',
                'email' => 'siti@student.ac.id',
                'password' => password_hash('mahasiswa123', PASSWORD_DEFAULT),
                'role' => 'mahasiswa',
                'prodi' => 'Teknik Informatika',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nim' => '20230005',
                'nama' => 'Budi Santoso',
                'email' => 'budi@student.ac.id',
                'password' => password_hash('mahasiswa123', PASSWORD_DEFAULT),
                'role' => 'mahasiswa',
                'prodi' => 'Manajemen',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
        echo "UserSeeder selesai!\n";
    }
}