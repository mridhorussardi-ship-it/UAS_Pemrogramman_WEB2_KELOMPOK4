<?php

namespace App\Controllers\Web;

use App\Controllers\Base\BaseController;
use App\Models\AspirasiModel;
use App\Models\KategoriModel;
use App\Models\KomentarModel;

class Aspirasi extends BaseController
{
    protected $aspirasiModel;
    protected $kategoriModel;
    protected $komentarModel;
    
    public function __construct()
    {
        $this->aspirasiModel = new AspirasiModel();
        $this->kategoriModel = new KategoriModel();
        $this->komentarModel = new KomentarModel();
    }
    
    public function index()
    {
        // Ambil data aspirasi dengan user
        $aspirasi = $this->aspirasiModel->getAllWithUser();
        
        $data = [
            'title' => 'Daftar Aspirasi - Sistem Aspirasi Mahasiswa',
            'aspirasi' => $aspirasi
        ];
        
        return view('aspirasi/index', $data);
    }
    
    public function create()
    {
        $data = [
            'title' => 'Buat Aspirasi - Sistem Aspirasi Mahasiswa',
            'kategori' => $this->kategoriModel->findAll()
        ];
        
        return view('aspirasi/create', $data);
    }
    
    public function store()
    {
        // Validasi input
        $rules = [
            'judul' => 'required|min_length[5]|max_length[200]',
            'isi' => 'required|min_length[10]',
            'kategori_id' => 'required|numeric'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Siapkan data
        $data = [
            'user_id' => session()->get('user_id'),
            'judul' => $this->request->getPost('judul'),
            'isi' => $this->request->getPost('isi'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'status' => 'pending',
            'is_anonymous' => $this->request->getPost('is_anonymous') ? 1 : 0
        ];
        
        // Upload file
        $file = $this->request->getFile('lampiran');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('public/assets/uploads/aspirasi', $newName);
            $data['lampiran'] = $newName;
        }
        
        // Simpan
        $this->aspirasiModel->save($data);
        
        return redirect()->to('/aspirasi')->with('success', 'Aspirasi berhasil dikirim!');
    }
    
    public function detail($id)
    {
        $aspirasi = $this->aspirasiModel->getDetail($id);
        
        if (!$aspirasi) {
            return redirect()->to('/aspirasi')->with('error', 'Aspirasi tidak ditemukan');
        }
        
        // Ambil komentar
        $komentar = $this->komentarModel->getByAspirasi($id);
        
        $data = [
            'title' => 'Detail Aspirasi - Sistem Aspirasi Mahasiswa',
            'aspirasi' => $aspirasi,
            'komentar' => $komentar
        ];
        
        return view('aspirasi/detail', $data);
    }
    
    public function edit($id)
    {
        $aspirasi = $this->aspirasiModel->find($id);
        
        if (!$aspirasi) {
            return redirect()->to('/aspirasi')->with('error', 'Aspirasi tidak ditemukan');
        }
        
        // Cek kepemilikan
        if ($aspirasi['user_id'] != session()->get('user_id')) {
            return redirect()->to('/aspirasi')->with('error', 'Anda tidak memiliki akses');
        }
        
        // Cek status, hanya boleh edit jika pending
        if ($aspirasi['status'] != 'pending') {
            return redirect()->to('/aspirasi/' . $id)->with('error', 'Aspirasi sudah diproses, tidak dapat diedit');
        }
        
        $data = [
            'title' => 'Edit Aspirasi - Sistem Aspirasi Mahasiswa',
            'aspirasi' => $aspirasi,
            'kategori' => $this->kategoriModel->findAll()
        ];
        
        return view('aspirasi/edit', $data);
    }
    
    public function update($id)
    {
        $aspirasi = $this->aspirasiModel->find($id);
        
        if (!$aspirasi) {
            return redirect()->to('/aspirasi')->with('error', 'Aspirasi tidak ditemukan');
        }
        
        // Cek kepemilikan
        if ($aspirasi['user_id'] != session()->get('user_id')) {
            return redirect()->to('/aspirasi')->with('error', 'Anda tidak memiliki akses');
        }
        
        // Cek status
        if ($aspirasi['status'] != 'pending') {
            return redirect()->to('/aspirasi/' . $id)->with('error', 'Aspirasi sudah diproses, tidak dapat diedit');
        }
        
        $rules = [
            'judul' => 'required|min_length[5]|max_length[200]',
            'isi' => 'required|min_length[10]',
            'kategori_id' => 'required|numeric'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'judul' => $this->request->getPost('judul'),
            'isi' => $this->request->getPost('isi'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'is_anonymous' => $this->request->getPost('is_anonymous') ? 1 : 0
        ];
        
        $this->aspirasiModel->update($id, $data);
        
        return redirect()->to('/aspirasi/' . $id)->with('success', 'Aspirasi berhasil diupdate!');
    }
    
    public function delete($id)
    {
        $aspirasi = $this->aspirasiModel->find($id);
        
        if (!$aspirasi) {
            return redirect()->to('/aspirasi')->with('error', 'Aspirasi tidak ditemukan');
        }
        
        // Cek kepemilikan
        if ($aspirasi['user_id'] != session()->get('user_id')) {
            return redirect()->to('/aspirasi')->with('error', 'Anda tidak memiliki akses');
        }
        
        // Cek status
        if ($aspirasi['status'] != 'pending') {
            return redirect()->to('/aspirasi/' . $id)->with('error', 'Aspirasi sudah diproses, tidak dapat dihapus');
        }
        
        $this->aspirasiModel->delete($id);
        
        return redirect()->to('/aspirasi')->with('success', 'Aspirasi berhasil dihapus!');
    }
    
    public function addKomentar($id)
    {
        // Cek aspirasi ada
        $aspirasi = $this->aspirasiModel->find($id);
        if (!$aspirasi) {
            return redirect()->to('/aspirasi')->with('error', 'Aspirasi tidak ditemukan');
        }
        
        $rules = [
            'isi_komentar' => 'required|min_length[3]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'aspirasi_id' => $id,
            'user_id' => session()->get('user_id'),
            'isi_komentar' => $this->request->getPost('isi_komentar')
        ];
        
        $this->komentarModel->save($data);
        
        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }
}