<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="bg-light p-5 rounded">
            <h1 class="display-4">
                <i class="fas fa-graduation-cap text-primary"></i>
                Selamat Datang di Sistem Aspirasi Mahasiswa
            </h1>
            <p class="lead">
                Sistem untuk menampung aspirasi dan saran mahasiswa.
            </p>
            <hr class="my-4">
            <p>
                Silakan login atau daftar untuk menggunakan sistem ini.
            </p>
            <div class="mt-3">
                <?php if(session()->get('isLoggedIn')): ?>
                    <a href="<?= base_url('dashboard') ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('login') ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                    <a href="<?= base_url('register') ?>" class="btn btn-success btn-lg">
                        <i class="fas fa-user-plus"></i> Daftar
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Info Cards -->
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-pen fa-3x text-primary"></i>
                <h5 class="card-title mt-3">Kirim Aspirasi</h5>
                <p class="card-text">Sampaikan aspirasi dan saran Anda</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-eye fa-3x text-success"></i>
                <h5 class="card-title mt-3">Pantau Status</h5>
                <p class="card-text">Lihat status aspirasi Anda</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-comments fa-3x text-warning"></i>
                <h5 class="card-title mt-3">Diskusi</h5>
                <p class="card-text">Berikan komentar dan tanggapan</p>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Aspirasi Terbaru -->
<?php if(isset($aspirasi) && !empty($aspirasi)): ?>
<div class="row mt-5">
    <div class="col-12">
        <h3>Aspirasi Terbaru</h3>
        <hr>
        <?php foreach($aspirasi as $item): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5><?= esc($item['judul']) ?></h5>
                <p><?= substr(esc($item['isi']), 0, 200) ?>...</p>
                <small class="text-muted">
                    Oleh: <?= esc($item['nama']) ?> | 
                    Kategori: <?= esc($item['nama_kategori'] ?? 'Tanpa Kategori') ?> |
                    Status: 
                    <span class="badge bg-<?= $item['status'] == 'selesai' ? 'success' : ($item['status'] == 'diproses' ? 'warning' : ($item['status'] == 'ditolak' ? 'danger' : 'secondary')) ?>">
                        <?= ucfirst($item['status']) ?>
                    </span>
                </small>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>
<?= $this->endSection() ?>