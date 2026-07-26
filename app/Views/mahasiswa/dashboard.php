<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 snow-animate-in">
    <div>
        <h1 class="fw-bold" style="font-size:1.8rem; letter-spacing:-0.025em;">
            <i class="fas fa-tachometer-alt me-2" style="color:var(--snow-primary);"></i> Dashboard
        </h1>
        <p class="m-0" style="color:var(--snow-text-secondary);">
            <i class="fas fa-user-graduate me-1"></i> Selamat datang, <strong><?= session()->get('nama') ?></strong>
            <span class="mx-2">|</span> <?= date('l, d F Y') ?>
        </p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('aspirasi') ?>" class="snow-btn snow-btn-outline"><i class="fas fa-list me-1"></i> Lihat</a>
        <a href="<?= base_url('aspirasi/create') ?>" class="snow-btn snow-btn-primary"><i class="fas fa-plus me-1"></i> Buat</a>
    </div>
</div>

<!-- Stats -->
<div class="row g-4">
    <?php
    $stats = [
        ['number' => $total_aspirasi ?? 0, 'label' => 'Total Aspirasi', 'icon' => 'fa-file-alt'],
        ['number' => $aspirasi_saya ?? 0, 'label' => 'Aspirasi Saya', 'icon' => 'fa-user'],
        ['number' => $statistik_status['pending'] ?? 0, 'label' => 'Pending', 'icon' => 'fa-clock'],
    ];
    foreach($stats as $i => $stat): ?>
    <div class="col-md-4 snow-animate-in snow-delay-<?= $i+1 ?>">
        <div class="snow-stat d-flex align-items-center justify-content-between">
            <div>
                <div class="snow-stat-number"><?= $stat['number'] ?></div>
                <div class="snow-stat-label"><?= $stat['label'] ?></div>
            </div>
            <i class="fas <?= $stat['icon'] ?> fa-2x snow-stat-icon"></i>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Aspirasi Saya -->
<div class="snow-card p-4 mt-4 snow-animate-in snow-delay-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold m-0"><i class="fas fa-list me-2" style="color:var(--snow-primary);"></i> Aspirasi Saya <span class="snow-badge" style="background:var(--snow-primary-bg); color:var(--snow-primary); margin-left:8px;"><?= $aspirasi_saya ?? 0 ?></span></h6>
        <a href="<?= base_url('aspirasi') ?>" style="color:var(--snow-primary); font-size:0.85rem; text-decoration:none; font-weight:600;">Lihat Semua <i class="fas fa-arrow-right ms-1"></i></a>
    </div>
    <?php if(empty($aspirasi_terbaru)): ?>
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-3x" style="color:var(--snow-text-muted); opacity:0.3;"></i>
            <p style="color:var(--snow-text-muted); margin-top:12px;">Belum ada aspirasi yang Anda buat</p>
            <a href="<?= base_url('aspirasi/create') ?>" class="snow-btn snow-btn-primary"><i class="fas fa-plus me-1"></i> Buat Aspirasi</a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="snow-table">
                <thead><tr><th>Judul</th><th>Kategori</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php foreach($aspirasi_terbaru as $item): ?>
                    <tr>
                        <td style="color:var(--snow-text-primary); font-weight:500;"><?= esc(substr($item['judul'], 0, 40)) ?></td>
                        <td><span class="snow-badge" style="background:var(--snow-bg-input); color:var(--snow-text-secondary);"><?= esc($item['kategori'] ?? 'Lainnya') ?></span></td>
                        <td>
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
                        </td>
                        <td style="color:var(--snow-text-muted); font-size:0.85rem;"><?= date('d/m/Y H:i', strtotime($item['created_at'])) ?></td>
                        <td><a href="<?= base_url('aspirasi/' . $item['id']) ?>" class="snow-btn snow-btn-ghost snow-btn-sm"><i class="fas fa-eye"></i></a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>