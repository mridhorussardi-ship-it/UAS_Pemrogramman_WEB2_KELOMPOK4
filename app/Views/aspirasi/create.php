<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 snow-animate-in">
    <div>
        <h1 class="fw-bold" style="font-size:1.8rem; letter-spacing:-0.025em;">
            <i class="fas fa-pen me-2" style="color:var(--snow-primary);"></i> Buat Aspirasi
        </h1>
        <p class="m-0" style="color:var(--snow-text-secondary);">Sampaikan aspirasi dan saran Anda</p>
    </div>
    <a href="<?= base_url('aspirasi') ?>" class="snow-btn snow-btn-outline"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
</div>

<div class="snow-card p-4 snow-animate-in snow-delay-2">
    <form action="<?= base_url('aspirasi/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <?php if(session()->getFlashdata('errors')): ?>
            <div class="alert" style="background:#FEE2E2; color:#991B1B; border-radius:var(--snow-radius-md); padding:12px 16px; margin-bottom:20px;">
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <div><i class="fas fa-exclamation-circle me-1"></i> <?= $error ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <div class="row g-4">
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size:0.85rem; color:var(--snow-text-secondary);">Judul <span class="text-danger">*</span></label>
                    <input type="text" class="snow-input" name="judul" placeholder="Masukkan judul aspirasi" value="<?= old('judul') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size:0.85rem; color:var(--snow-text-secondary);">Kategori <span class="text-danger">*</span></label>
                    <select class="snow-input" name="kategori_id" required>
                        <option value="">Pilih Kategori</option>
                        <?php foreach($kategori as $kat): ?>
                            <option value="<?= $kat['id'] ?>" <?= old('kategori_id') == $kat['id'] ? 'selected' : '' ?>><?= esc($kat['nama_kategori']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size:0.85rem; color:var(--snow-text-secondary);">Isi Aspirasi <span class="text-danger">*</span></label>
                    <textarea class="snow-input" name="isi" rows="6" placeholder="Jelaskan aspirasi Anda secara detail" required><?= old('isi') ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size:0.85rem; color:var(--snow-text-secondary);">Lampiran</label>
                    <input type="file" class="snow-input" name="lampiran" style="padding:10px;">
                    <small style="color:var(--snow-text-muted); font-size:0.75rem;">Format: JPG, PNG, PDF, DOC (Max 5MB)</small>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_anonymous" name="is_anonymous" value="1">
                    <label class="form-check-label" for="is_anonymous" style="color:var(--snow-text-secondary); font-weight:500;">
                        <i class="fas fa-user-secret me-1" style="color:var(--snow-primary);"></i> Kirim secara anonim
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="snow-card p-4" style="background:var(--snow-bg-page); border-color:var(--snow-border);">
                    <h6 class="fw-bold"><i class="fas fa-info-circle me-2" style="color:var(--snow-primary);"></i> Panduan</h6>
                    <div style="display:grid; gap:12px; margin-top:12px;">
                        <div><div class="d-flex align-items-center gap-2"><span class="badge bg-primary rounded-circle" style="width:24px;height:24px;display:flex;align-items:center;justify-content:center;">1</span> <span class="fw-semibold">Judul Jelas</span></div><p style="color:var(--snow-text-muted); font-size:0.85rem; margin-left:36px;">Buat judul yang singkat dan jelas</p></div>
                        <div><div class="d-flex align-items-center gap-2"><span class="badge bg-primary rounded-circle" style="width:24px;height:24px;display:flex;align-items:center;justify-content:center;">2</span> <span class="fw-semibold">Deskripsi Detail</span></div><p style="color:var(--snow-text-muted); font-size:0.85rem; margin-left:36px;">Jelaskan aspirasi Anda dengan detail</p></div>
                        <div><div class="d-flex align-items-center gap-2"><span class="badge bg-primary rounded-circle" style="width:24px;height:24px;display:flex;align-items:center;justify-content:center;">3</span> <span class="fw-semibold">Pilih Kategori</span></div><p style="color:var(--snow-text-muted); font-size:0.85rem; margin-left:36px;">Pilih kategori yang sesuai</p></div>
                        <div><div class="d-flex align-items-center gap-2"><span class="badge bg-primary rounded-circle" style="width:24px;height:24px;display:flex;align-items:center;justify-content:center;">4</span> <span class="fw-semibold">Anonim (Opsional)</span></div><p style="color:var(--snow-text-muted); font-size:0.85rem; margin-left:36px;">Aktifkan jika ingin menyembunyikan identitas</p></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-4" style="border-top:1px solid var(--snow-border); padding-top:20px;">
            <button type="submit" class="snow-btn snow-btn-primary" style="padding:12px 36px;"><i class="fas fa-paper-plane me-2"></i> Kirim Aspirasi</button>
            <a href="<?= base_url('aspirasi') ?>" class="snow-btn snow-btn-ghost" style="margin-left:12px;">Batal</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>