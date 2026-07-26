<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-edit text-warning"></i> Edit Aspirasi
    </h1>
    <a href="<?= base_url('aspirasi/' . $aspirasi['id']) ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="<?= base_url('aspirasi/update/' . $aspirasi['id']) ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    
                    <?php if(session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger">
                            <?php foreach(session()->getFlashdata('errors') as $error): ?>
                                <div><?= $error ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="judul" name="judul" 
                               value="<?= old('judul', $aspirasi['judul']) ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select" id="kategori_id" name="kategori_id" required>
                            <option value="">Pilih Kategori</option>
                            <?php foreach($kategori as $kat): ?>
                            <option value="<?= $kat['id'] ?>" <?= old('kategori_id', $aspirasi['kategori_id']) == $kat['id'] ? 'selected' : '' ?>>
                                <?= esc($kat['nama_kategori']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="isi" class="form-label">Isi Aspirasi <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="isi" name="isi" rows="6" required><?= old('isi', $aspirasi['isi']) ?></textarea>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_anonymous" name="is_anonymous" value="1" 
                               <?= old('is_anonymous', $aspirasi['is_anonymous']) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="is_anonymous">
                            <i class="fas fa-user-secret"></i> Kirim secara anonim
                        </label>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Status saat ini: 
                        <span class="badge bg-secondary"><?= ucfirst($aspirasi['status']) ?></span>
                        <br><small>Hanya aspirasi dengan status Pending yang dapat diedit.</small>
                    </div>
                    
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Update Aspirasi
                    </button>
                    <a href="<?= base_url('aspirasi/' . $aspirasi['id']) ?>" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>