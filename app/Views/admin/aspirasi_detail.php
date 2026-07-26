<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-file-alt text-primary"></i> Detail Aspirasi
    </h1>
    <a href="<?= base_url('admin/aspirasi') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Detail Aspirasi -->
        <div class="card">
            <div class="card-header">
                <h4><?= esc($aspirasi['judul']) ?></h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Status:</strong>
                    <span class="badge bg-<?= $aspirasi['status'] == 'selesai' ? 'success' : ($aspirasi['status'] == 'diproses' ? 'info' : ($aspirasi['status'] == 'ditolak' ? 'danger' : 'warning')) ?>">
                        <?= ucfirst($aspirasi['status']) ?>
                    </span>
                </div>
                
                <div class="mb-3">
                    <strong>Kategori:</strong>
                    <span class="badge bg-secondary"><?= esc($aspirasi['nama_kategori'] ?? 'Lainnya') ?></span>
                </div>
                
                <div class="mb-3">
                    <strong>Pengirim:</strong>
                    <?= $aspirasi['is_anonymous'] ? 'Anonim' : esc($aspirasi['nama'] ?? 'Unknown') ?>
                    <?php if(!$aspirasi['is_anonymous']): ?>
                        <small class="text-muted">(<?= esc($aspirasi['nim'] ?? '') ?>)</small>
                    <?php endif; ?>
                </div>
                
                <div class="mb-3">
                    <strong>Tanggal:</strong>
                    <?= date('d/m/Y H:i', strtotime($aspirasi['created_at'])) ?>
                </div>
                
                <hr>
                
                <div class="mb-3">
                    <strong>Isi Aspirasi:</strong>
                    <p class="mt-2"><?= nl2br(esc($aspirasi['isi'])) ?></p>
                </div>
                
                <?php if($aspirasi['lampiran']): ?>
                <div class="mb-3">
                    <strong>Lampiran:</strong>
                    <a href="<?= base_url('assets/uploads/aspirasi/' . $aspirasi['lampiran']) ?>" target="_blank" class="btn btn-sm btn-info">
                        <i class="fas fa-paperclip"></i> Lihat Lampiran
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Komentar -->
        <div class="card mt-3">
            <div class="card-header">
                <h5><i class="fas fa-comments"></i> Komentar</h5>
            </div>
            <div class="card-body">
                <?php if(empty($komentar)): ?>
                    <p class="text-muted">Belum ada komentar</p>
                <?php else: ?>
                    <?php foreach($komentar as $komen): ?>
                    <div class="border-bottom pb-2 mb-2">
                        <strong><?= esc($komen['nama']) ?></strong>
                        <small class="text-muted"><?= date('d/m/Y H:i', strtotime($komen['created_at'])) ?></small>
                        <p class="mb-0"><?= esc($komen['isi_komentar']) ?></p>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Update Status -->
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-edit"></i> Update Status</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('admin/aspirasi/status/' . $aspirasi['id']) ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status Saat Ini:</label>
                        <div class="mb-2">
                            <span class="badge bg-<?= $aspirasi['status'] == 'selesai' ? 'success' : ($aspirasi['status'] == 'diproses' ? 'info' : ($aspirasi['status'] == 'ditolak' ? 'danger' : 'warning')) ?>">
                                <?= ucfirst($aspirasi['status']) ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Ubah Status:</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="pending" <?= $aspirasi['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="diproses" <?= $aspirasi['status'] == 'diproses' ? 'selected' : '' ?>>Diproses</option>
                            <option value="selesai" <?= $aspirasi['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                            <option value="ditolak" <?= $aspirasi['status'] == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tanggapan" class="form-label">Tanggapan (Opsional):</label>
                        <textarea class="form-control" id="tanggapan" name="tanggapan" rows="3" 
                                  placeholder="Berikan tanggapan untuk mahasiswa..."></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Update Status
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Info -->
        <div class="card mt-3">
            <div class="card-header">
                <h5><i class="fas fa-info-circle"></i> Keterangan Status</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li><span class="badge bg-warning">Pending</span> - Menunggu diproses</li>
                    <li><span class="badge bg-info">Diproses</span> - Sedang diproses</li>
                    <li><span class="badge bg-success">Selesai</span> - Telah selesai</li>
                    <li><span class="badge bg-danger">Ditolak</span> - Ditolak</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>