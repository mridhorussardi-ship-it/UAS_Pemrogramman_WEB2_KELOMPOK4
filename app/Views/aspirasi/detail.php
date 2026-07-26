<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-file-alt text-primary"></i> Detail Aspirasi
    </h1>
    <a href="<?= base_url('aspirasi') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><?= esc($aspirasi['judul']) ?></h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Status:</strong>
                    <span class="badge bg-<?= $aspirasi['status'] == 'selesai' ? 'success' : ($aspirasi['status'] == 'diproses' ? 'warning' : ($aspirasi['status'] == 'ditolak' ? 'danger' : 'secondary')) ?>">
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
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-comments"></i> Aksi</h5>
            </div>
            <div class="card-body">
                <?php if(session()->get('user_id') == $aspirasi['user_id'] && $aspirasi['status'] == 'pending'): ?>
                    <a href="<?= base_url('aspirasi/edit/' . $aspirasi['id']) ?>" class="btn btn-warning w-100 mb-2">
                        <i class="fas fa-edit"></i> Edit Aspirasi
                    </a>
                    <a href="<?= base_url('aspirasi/delete/' . $aspirasi['id']) ?>" class="btn btn-danger w-100" onclick="return confirm('Yakin ingin menghapus?')">
                        <i class="fas fa-trash"></i> Hapus Aspirasi
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>