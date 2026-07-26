<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 snow-animate-in">
    <div>
        <h1 class="fw-bold" style="font-size:1.8rem; letter-spacing:-0.025em;">
            <i class="fas fa-tachometer-alt me-2" style="color:var(--snow-primary);"></i> Dashboard
        </h1>
        <p class="m-0" style="color:var(--snow-text-secondary);"><?= date('l, d F Y') ?></p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('admin/aspirasi') ?>" class="snow-btn snow-btn-outline"><i class="fas fa-list me-1"></i> Kelola</a>
        <a href="<?= base_url('admin/laporan') ?>" class="snow-btn snow-btn-primary"><i class="fas fa-file-alt me-1"></i> Laporan</a>
    </div>
</div>

<!-- Stats -->
<div class="row g-4">
    <?php
    $stats = [
        ['number' => $total_aspirasi ?? 0, 'label' => 'Total Aspirasi', 'icon' => 'fa-file-alt', 'color' => 'var(--snow-primary)'],
        ['number' => $total_mahasiswa ?? 0, 'label' => 'Mahasiswa', 'icon' => 'fa-user-graduate', 'color' => 'var(--snow-success)'],
        ['number' => $total_dosen ?? 0, 'label' => 'Dosen', 'icon' => 'fa-chalkboard-teacher', 'color' => 'var(--snow-info)'],
        ['number' => $statistik_status['pending'] ?? 0, 'label' => 'Pending', 'icon' => 'fa-clock', 'color' => 'var(--snow-warning)'],
    ];
    foreach($stats as $i => $stat): ?>
    <div class="col-xl-3 col-md-6 snow-animate-in snow-delay-<?= $i+1 ?>">
        <div class="snow-stat d-flex align-items-center justify-content-between">
            <div>
                <div class="snow-stat-number"><?= $stat['number'] ?></div>
                <div class="snow-stat-label"><?= $stat['label'] ?></div>
            </div>
            <i class="fas <?= $stat['icon'] ?> fa-2x snow-stat-icon" style="color:<?= $stat['color'] ?>;"></i>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Table and Actions -->
<div class="row g-4 mt-2">
    <div class="col-lg-7 snow-animate-in snow-delay-5">
        <div class="snow-card">
            <div class="snow-card-header d-flex justify-content-between align-items-center">
                <span class="fw-bold"><i class="fas fa-chart-pie me-2" style="color:var(--snow-primary);"></i> Status Breakdown</span>
                <span class="badge" style="background:var(--snow-bg-input); color:var(--snow-text-secondary); font-weight:500;"><?= array_sum($statistik_status) ?> total</span>
            </div>
            <div class="snow-card-body">
                <div class="table-responsive">
                    <table class="snow-table">
                        <thead><tr><th>Status</th><th>Jumlah</th><th>Persentase</th></tr></thead>
                        <tbody>
                            <?php
                            $total = array_sum($statistik_status);
                            $items = [
                                ['key' => 'pending', 'label' => 'Pending', 'badge' => 'snow-badge-pending', 'color' => '#F59E0B'],
                                ['key' => 'diproses', 'label' => 'Diproses', 'badge' => 'snow-badge-diproses', 'color' => '#3B82F6'],
                                ['key' => 'selesai', 'label' => 'Selesai', 'badge' => 'snow-badge-selesai', 'color' => '#10B981'],
                                ['key' => 'ditolak', 'label' => 'Ditolak', 'badge' => 'snow-badge-ditolak', 'color' => '#EF4444'],
                            ];
                            foreach($items as $item):
                                $value = $statistik_status[$item['key']] ?? 0;
                                $percent = $total > 0 ? round(($value/$total)*100, 1) : 0;
                            ?>
                            <tr>
                                <td><span class="snow-badge <?= $item['badge'] ?>"><?= $item['label'] ?></span></td>
                                <td class="fw-bold" style="color:var(--snow-text-primary);"><?= $value ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="flex:1; height:4px; background:var(--snow-bg-input); border-radius:var(--snow-radius-full); overflow:hidden;">
                                            <div style="width:<?= $percent ?>%; height:100%; background:<?= $item['color'] ?>; border-radius:var(--snow-radius-full);"></div>
                                        </div>
                                        <span style="font-size:0.8rem; color:var(--snow-text-muted); min-width:40px;"><?= $percent ?>%</span>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5 snow-animate-in snow-delay-6">
        <div class="snow-card">
            <div class="snow-card-header fw-bold"><i class="fas fa-bolt me-2" style="color:var(--snow-warning);"></i> Quick Actions</div>
            <div class="snow-card-body">
                <div class="d-grid gap-3">
                    <a href="<?= base_url('admin/aspirasi') ?>" class="snow-btn snow-btn-primary snow-btn-lg w-100 justify-content-center">
                        <i class="fas fa-list me-2"></i> Kelola Aspirasi
                        <span class="badge bg-light text-dark ms-2 rounded-pill"><?= $total_aspirasi ?? 0 ?></span>
                    </a>
                    <a href="<?= base_url('admin/users') ?>" class="snow-btn snow-btn-outline snow-btn-lg w-100 justify-content-center">
                        <i class="fas fa-users me-2"></i> Kelola User
                        <span class="badge bg-light text-dark ms-2 rounded-pill"><?= ($total_mahasiswa ?? 0) + ($total_dosen ?? 0) ?></span>
                    </a>
                    <a href="<?= base_url('admin/laporan') ?>" class="snow-btn snow-btn-ghost snow-btn-lg w-100 justify-content-center" style="border:1px solid var(--snow-border);">
                        <i class="fas fa-file-alt me-2"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>