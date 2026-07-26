<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 snow-animate-in">
    <div>
        <h1 class="fw-bold" style="font-size:1.8rem; letter-spacing:-0.025em;">
            <i class="fas fa-list me-2" style="color:var(--snow-primary);"></i> Daftar Aspirasi
        </h1>
        <p class="m-0" style="color:var(--snow-text-secondary);">Semua aspirasi yang telah dikirim</p>
    </div>
    <?php if(session()->get('role') == 'mahasiswa'): ?>
    <a href="<?= base_url('aspirasi/create') ?>" class="snow-btn snow-btn-primary"><i class="fas fa-plus me-1"></i> Buat Aspirasi</a>
    <?php endif; ?>
</div>

<?php if(empty($aspirasi)): ?>
    <div class="snow-card p-5 text-center snow-animate-in">
        <i class="fas fa-inbox fa-3x" style="color:var(--snow-text-muted); opacity:0.3;"></i>
        <h5 class="mt-3" style="color:var(--snow-text-secondary);">Belum ada aspirasi</h5>
        <p style="color:var(--snow-text-muted);">Jadilah yang pertama mengirim aspirasi!</p>
        <?php if(session()->get('role') == 'mahasiswa'): ?>
        <a href="<?= base_url('aspirasi/create') ?>" class="snow-btn snow-btn-primary mt-2"><i class="fas fa-plus me-1"></i> Buat Aspirasi</a>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach($aspirasi as $item): ?>
        <div class="col-md-6 col-lg-4">
            <div class="snow-card p-4 snow-animate-in h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="snow-badge" style="background:var(--snow-bg-input); color:var(--snow-text-secondary);"><?= esc($item['nama_kategori'] ?? 'Lainnya') ?></span>
                    <?php 
                    $statusMap = [
                        'pending' => 'snow-badge-pending',
                        'diproses' => 'snow-badge-diproses',
                        'selesai' => 'snow-badge-selesai',
                        'ditolak' => 'snow-badge-ditolak'
                    ];
                    $labelMap = ['pending' => 'Pending', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak'];
                    ?>
                    <span class="snow-badge <?= $statusMap[$item['status']] ?? 'snow-badge-pending' ?>"><?= $labelMap[$item['status']] ?? 'Pending' ?></span>
                </div>
                <h6 class="fw-bold" style="color:var(--snow-text-primary);"><?= esc(substr($item['judul'], 0, 60)) ?></h6>
                <p style="color:var(--snow-text-muted); font-size:0.85rem; flex:1;"><?= substr(esc($item['isi']), 0, 100) ?>...</p>
                <div class="d-flex justify-content-between align-items-center pt-3" style="border-top:1px solid var(--snow-border); margin-top:auto;">
                    <div class="d-flex align-items-center gap-2">
                        <span style="width:28px;height:28px;border-radius:50%;background:var(--snow-primary);color:white;display:flex;align-items:center;justify-content:center;font-weight:600;font-size:0.7rem;"><?= strtoupper(substr($item['is_anonymous'] ? 'A' : ($item['nama'] ?? 'U'), 0, 1)) ?></span>
                        <span style="font-size:0.8rem; color:var(--snow-text-secondary);"><?= $item['is_anonymous'] ? 'Anonim' : esc($item['nama'] ?? 'Unknown') ?></span>
                    </div>
                    <a href="<?= base_url('aspirasi/' . $item['id']) ?>" class="snow-btn snow-btn-primary snow-btn-sm"><i class="fas fa-eye me-1"></i> Detail</a>
                </div>
                <div style="font-size:0.7rem; color:var(--snow-text-muted); margin-top:8px;"><i class="fas fa-calendar-alt me-1"></i> <?= date('d/m/Y', strtotime($item['created_at'])) ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>