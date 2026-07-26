<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 snow-animate-in">
    <div>
        <h1 class="fw-bold" style="font-size:1.8rem; letter-spacing:-0.025em;">
            <i class="fas fa-chart-bar me-2" style="color:var(--snow-primary);"></i> Laporan
        </h1>
        <p class="m-0" style="color:var(--snow-text-secondary);">Filter dan lihat data aspirasi</p>
    </div>
</div>

<!-- Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-3 snow-animate-in snow-delay-1">
        <div class="snow-stat d-flex align-items-center justify-content-between">
            <div><div class="snow-stat-number"><?= $total_aspirasi ?? 0 ?></div><div class="snow-stat-label">Total</div></div>
            <i class="fas fa-file-alt fa-2x snow-stat-icon"></i>
        </div>
    </div>
    <div class="col-md-3 snow-animate-in snow-delay-2">
        <div class="snow-stat d-flex align-items-center justify-content-between" style="border-color:#F59E0B30;">
            <div><div class="snow-stat-number" style="color:#F59E0B;"><?= $statistik_status['pending'] ?? 0 ?></div><div class="snow-stat-label">Pending</div></div>
            <i class="fas fa-clock fa-2x snow-stat-icon" style="color:#F59E0B;"></i>
        </div>
    </div>
    <div class="col-md-3 snow-animate-in snow-delay-3">
        <div class="snow-stat d-flex align-items-center justify-content-between" style="border-color:#3B82F630;">
            <div><div class="snow-stat-number" style="color:#3B82F6;"><?= $statistik_status['diproses'] ?? 0 ?></div><div class="snow-stat-label">Diproses</div></div>
            <i class="fas fa-spinner fa-2x snow-stat-icon" style="color:#3B82F6;"></i>
        </div>
    </div>
    <div class="col-md-3 snow-animate-in snow-delay-4">
        <div class="snow-stat d-flex align-items-center justify-content-between" style="border-color:#10B98130;">
            <div><div class="snow-stat-number" style="color:#10B981;"><?= $statistik_status['selesai'] ?? 0 ?></div><div class="snow-stat-label">Selesai</div></div>
            <i class="fas fa-check-circle fa-2x snow-stat-icon" style="color:#10B981;"></i>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="snow-card p-4 mb-4 snow-animate-in snow-delay-5">
    <form action="<?= base_url('admin/laporan/filter') ?>" method="post">
        <?= csrf_field() ?>
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label fw-semibold" style="font-size:0.8rem; color:var(--snow-text-secondary);">Status</label>
                <select class="snow-input" name="status">
                    <option value="">Semua Status</option>
                    <option value="pending" <?= ($filter_status ?? '') == 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="diproses" <?= ($filter_status ?? '') == 'diproses' ? 'selected' : '' ?>>Diproses</option>
                    <option value="selesai" <?= ($filter_status ?? '') == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                    <option value="ditolak" <?= ($filter_status ?? '') == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold" style="font-size:0.8rem; color:var(--snow-text-secondary);">Kategori</label>
                <select class="snow-input" name="kategori">
                    <option value="">Semua Kategori</option>
                    <?php foreach($kategori_list ?? [] as $kat): ?>
                        <option value="<?= $kat['id'] ?>" <?= ($filter_kategori ?? '') == $kat['id'] ? 'selected' : '' ?>><?= esc($kat['nama_kategori']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold" style="font-size:0.8rem; color:var(--snow-text-secondary);">Tanggal Awal</label>
                <input type="date" class="snow-input" name="tanggal_awal" value="<?= $filter_tanggal_awal ?? '' ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold" style="font-size:0.8rem; color:var(--snow-text-secondary);">Tanggal Akhir</label>
                <input type="date" class="snow-input" name="tanggal_akhir" value="<?= $filter_tanggal_akhir ?? '' ?>">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="snow-btn snow-btn-primary w-100"><i class="fas fa-search me-1"></i> Filter</button>
            </div>
        </div>
    </form>
    <?php if(!empty($filter_status) || !empty($filter_kategori) || !empty($filter_tanggal_awal) || !empty($filter_tanggal_akhir)): ?>
        <div class="mt-3">
            <a href="<?= base_url('admin/laporan') ?>" class="snow-btn snow-btn-ghost snow-btn-sm" style="border:1px solid var(--snow-border);"><i class="fas fa-times me-1"></i> Reset Filter</a>
            <span class="ms-2" style="color:var(--snow-text-muted); font-size:0.85rem;"><i class="fas fa-info-circle me-1"></i> Menampilkan hasil filter</span>
        </div>
    <?php endif; ?>
</div>

<!-- Table -->
<div class="snow-card p-0 snow-animate-in snow-delay-6" style="overflow:auto;">
    <table class="snow-table" style="width:100%;">
        <thead><tr><th>#</th><th>Judul</th><th>Pengirim</th><th>Kategori</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr></thead>
        <tbody>
            <?php if(empty($aspirasi_terbaru ?? [])): ?>
                <tr><td colspan="7" style="text-align:center; color:var(--snow-text-muted); padding:40px;">
                    <i class="fas fa-inbox fa-2x d-block mb-2" style="opacity:0.2;"></i> Tidak ada data
                </td></tr>
            <?php else: ?>
                <?php $no = 1; foreach($aspirasi_terbaru as $item): ?>
                <tr>
                    <td style="font-weight:600; color:var(--snow-text-muted);"><?= $no++ ?></td>
                    <td style="color:var(--snow-text-primary); font-weight:500;"><?= esc(substr($item['judul'], 0, 40)) ?>...</td>
                    <td><?= $item['is_anonymous'] ? '<span style="color:var(--snow-text-muted);"><i class="fas fa-user-secret"></i> Anonim</span>' : esc($item['nama'] ?? 'Unknown') ?></td>
                    <td><span class="snow-badge" style="background:var(--snow-bg-input); color:var(--snow-text-secondary);"><?= esc($item['nama_kategori'] ?? 'Lainnya') ?></span></td>
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
                    <td>
                        <a href="<?= base_url('admin/aspirasi/' . $item['id']) ?>" class="snow-btn snow-btn-primary snow-btn-sm"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>