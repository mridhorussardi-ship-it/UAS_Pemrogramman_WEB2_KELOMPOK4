<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 snow-animate-in">
    <div>
        <h1 class="fw-bold" style="font-size:1.8rem; letter-spacing:-0.025em;">
            <i class="fas fa-tachometer-alt me-2" style="color:var(--snow-primary);"></i> Dashboard
        </h1>
        <p class="m-0" style="color:var(--snow-text-secondary);">
            <i class="fas fa-chalkboard-teacher me-1"></i> Selamat datang, <strong><?= session()->get('nama') ?></strong>
            <span class="mx-2">|</span> <?= date('l, d F Y') ?>
        </p>
    </div>
    <a href="<?= base_url('dosen/aspirasi') ?>" class="snow-btn snow-btn-primary"><i class="fas fa-list me-1"></i> Lihat Aspirasi</a>
</div>

<div class="row g-4">
    <div class="col-md-6 snow-animate-in snow-delay-1">
        <div class="snow-stat d-flex align-items-center justify-content-between">
            <div>
                <div class="snow-stat-number"><?= $total_aspirasi ?? 0 ?></div>
                <div class="snow-stat-label">Total Aspirasi</div>
            </div>
            <i class="fas fa-file-alt fa-2x snow-stat-icon"></i>
        </div>
    </div>
    <div class="col-md-6 snow-animate-in snow-delay-2">
        <div class="snow-stat d-flex align-items-center justify-content-between" style="border-color:#F59E0B30;">
            <div>
                <div class="snow-stat-number" style="color:#F59E0B;"><?= $statistik_status['pending'] ?? 0 ?></div>
                <div class="snow-stat-label">Pending</div>
            </div>
            <i class="fas fa-clock fa-2x snow-stat-icon" style="color:#F59E0B;"></i>
        </div>
    </div>
</div>

<div class="snow-card p-4 mt-4 snow-animate-in snow-delay-3">
    <h6 class="fw-bold"><i class="fas fa-list me-2" style="color:var(--snow-primary);"></i> Aspirasi Terbaru <span class="snow-badge" style="background:var(--snow-primary-bg); color:var(--snow-primary); margin-left:8px;"><?= count($aspirasi_terbaru ?? []) ?></span></h6>
    <div class="table-responsive">
        <table class="snow-table">
            <thead><tr><th>Judul</th><th>Pengirim</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php if(empty($aspirasi_terbaru)): ?>
                    <tr><td colspan="5" style="text-align:center; color:var(--snow-text-muted); padding:30px;">Belum ada aspirasi</td></tr>
                <?php else: ?>
                    <?php foreach($aspirasi_terbaru as $item): ?>
                    <tr>
                        <td style="color:var(--snow-text-primary); font-weight:500;"><?= esc(substr($item['judul'], 0, 40)) ?></td>
                        <td><?= $item['is_anonymous'] ? 'Anonim' : esc($item['nama'] ?? 'Unknown') ?></td>
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
                        <td><a href="<?= base_url('dosen/aspirasi/' . $item['id']) ?>" class="snow-btn snow-btn-primary snow-btn-sm"><i class="fas fa-eye"></i></a></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>