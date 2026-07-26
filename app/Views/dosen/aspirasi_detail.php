<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 snow-animate-in">
    <div>
        <h1 class="fw-bold" style="font-size:1.8rem; letter-spacing:-0.025em;">
            <i class="fas fa-file-alt me-2" style="color:var(--snow-primary);"></i> Detail Aspirasi
        </h1>
        <p class="m-0" style="color:var(--snow-text-secondary);">Lihat dan tanggapi aspirasi</p>
    </div>
    <a href="<?= base_url('dosen/aspirasi') ?>" class="snow-btn snow-btn-outline"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
</div>

<div class="row g-4">
    <div class="col-lg-8 snow-animate-in snow-delay-1">
        <div class="snow-card p-4">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                <h4 class="fw-bold"><?= esc($aspirasi['judul']) ?></h4>
                <?php 
                $statusMap = [
                    'pending' => 'snow-badge-pending',
                    'diproses' => 'snow-badge-diproses',
                    'selesai' => 'snow-badge-selesai',
                    'ditolak' => 'snow-badge-ditolak'
                ];
                $labelMap = ['pending' => 'Pending', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak'];
                ?>
                <span class="snow-badge <?= $statusMap[$aspirasi['status']] ?? 'snow-badge-pending' ?>" style="font-size:0.9rem; padding:6px 18px;"><?= $labelMap[$aspirasi['status']] ?? 'Pending' ?></span>
            </div>
            <div class="row g-3 mb-3" style="background:var(--snow-bg-page); border-radius:var(--snow-radius-md); padding:16px;">
                <div class="col-6"><span style="color:var(--snow-text-muted); font-size:0.8rem;">Kategori</span><br><strong><?= esc($aspirasi['nama_kategori'] ?? 'Lainnya') ?></strong></div>
                <div class="col-6"><span style="color:var(--snow-text-muted); font-size:0.8rem;">Pengirim</span><br><strong><?= $aspirasi['is_anonymous'] ? 'Anonim' : esc($aspirasi['nama'] ?? 'Unknown') ?></strong></div>
                <div class="col-6"><span style="color:var(--snow-text-muted); font-size:0.8rem;">NIM</span><br><strong><?= $aspirasi['is_anonymous'] ? '-' : esc($aspirasi['nim'] ?? '-') ?></strong></div>
                <div class="col-6"><span style="color:var(--snow-text-muted); font-size:0.8rem;">Tanggal</span><br><strong><?= date('d/m/Y H:i', strtotime($aspirasi['created_at'])) ?></strong></div>
            </div>
            <div><span style="color:var(--snow-text-muted); font-size:0.8rem;">Isi Aspirasi</span><p class="mt-2" style="line-height:1.8;"><?= nl2br(esc($aspirasi['isi'])) ?></p></div>
            <?php if($aspirasi['lampiran']): ?>
                <div class="mt-3"><span style="color:var(--snow-text-muted); font-size:0.8rem;">Lampiran</span><br><a href="<?= base_url('assets/uploads/aspirasi/' . $aspirasi['lampiran']) ?>" target="_blank" class="snow-btn snow-btn-outline snow-btn-sm mt-1"><i class="fas fa-paperclip me-1"></i> Lihat Lampiran</a></div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="col-lg-4 snow-animate-in snow-delay-2">
        <div class="snow-card p-4">
            <h6 class="fw-bold"><i class="fas fa-edit me-2" style="color:var(--snow-primary);"></i> Update Status</h6>
            <form action="<?= base_url('dosen/aspirasi/status/' . $aspirasi['id']) ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size:0.8rem; color:var(--snow-text-secondary);">Status Saat Ini</label>
                    <div><span class="snow-badge <?= $statusMap[$aspirasi['status']] ?? 'snow-badge-pending' ?>"><?= $labelMap[$aspirasi['status']] ?? 'Pending' ?></span></div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size:0.8rem; color:var(--snow-text-secondary);">Ubah Status</label>
                    <select class="snow-input" name="status" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="diproses" <?= $aspirasi['status'] == 'diproses' ? 'selected' : '' ?>>Diproses</option>
                        <option value="selesai" <?= $aspirasi['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                    </select>
                    <small style="color:var(--snow-text-muted); font-size:0.7rem;">Dosen hanya bisa ubah ke Diproses atau Selesai</small>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size:0.8rem; color:var(--snow-text-secondary);">Tanggapan (Opsional)</label>
                    <textarea class="snow-input" name="tanggapan" rows="3" placeholder="Berikan tanggapan..."></textarea>
                </div>
                <button type="submit" class="snow-btn snow-btn-primary w-100 justify-content-center"><i class="fas fa-save me-1"></i> Update Status</button>
            </form>
        </div>
        <div class="snow-card p-4 mt-4">
            <h6 class="fw-bold"><i class="fas fa-info-circle me-2" style="color:var(--snow-primary);"></i> Keterangan Status</h6>
            <div style="display:grid; gap:6px; font-size:0.85rem;">
                <div><span class="snow-badge snow-badge-pending">Pending</span> Menunggu diproses</div>
                <div><span class="snow-badge snow-badge-diproses">Diproses</span> Sedang diproses</div>
                <div><span class="snow-badge snow-badge-selesai">Selesai</span> Telah selesai</div>
                <div><span class="snow-badge snow-badge-ditolak">Ditolak</span> Ditolak (Hanya Admin)</div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>