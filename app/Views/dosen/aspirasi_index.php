<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 snow-animate-in">
    <div>
        <h1 class="fw-bold" style="font-size:1.8rem; letter-spacing:-0.025em;">
            <i class="fas fa-list me-2" style="color:var(--snow-primary);"></i> Daftar Aspirasi
        </h1>
        <p class="m-0" style="color:var(--snow-text-secondary);">Semua aspirasi mahasiswa</p>
    </div>
</div>

<?php if(empty($aspirasi)): ?>
    <div class="snow-card p-5 text-center snow-animate-in">
        <i class="fas fa-inbox fa-3x" style="color:var(--snow-text-muted); opacity:0.3;"></i>
        <h5 class="mt-3" style="color:var(--snow-text-secondary);">Belum ada aspirasi</h5>
    </div>
<?php else: ?>
    <div class="snow-card p-0 snow-animate-in snow-delay-2" style="overflow:auto;">
        <table class="snow-table" style="width:100%;">
            <thead><tr><th>#</th><th>Judul</th><th>Pengirim</th><th>Kategori</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php $no = 1; foreach($aspirasi as $item): ?>
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
                        <a href="<?= base_url('dosen/aspirasi/' . $item['id']) ?>" class="snow-btn snow-btn-primary snow-btn-sm"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>