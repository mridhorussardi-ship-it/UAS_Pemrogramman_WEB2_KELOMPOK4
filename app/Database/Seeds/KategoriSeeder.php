<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_kategori' => 'Akademik', 'deskripsi' => 'Aspirasi terkait pembelajaran, kurikulum, dosen'],
            ['nama_kategori' => 'Fasilitas', 'deskripsi' => 'Aspirasi terkait sarana dan prasarana kampus'],
            ['nama_kategori' => 'Kesejahteraan', 'deskripsi' => 'Aspirasi terkait beasiswa, UKT, kesejahteraan'],
            ['nama_kategori' => 'Lainnya', 'deskripsi' => 'Aspirasi di luar kategori yang ada'],
        ];

        $this->db->table('kategori')->insertBatch($data);
        echo "KategoriSeeder selesai!\n";
    }
}