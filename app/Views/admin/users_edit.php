<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div>
        <h1 class="h2">
            <i class="fas fa-edit text-warning"></i> Edit User
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/users') ?>">User</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-user-edit"></i> Edit User: <?= esc($user['nama']) ?></h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('admin/users/update/' . $user['id']) ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <?php if(session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger">
                            <?php foreach(session()->getFlashdata('errors') as $error): ?>
                                <div><?= $error ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM/NIDN</label>
                        <input type="text" class="form-control" id="nim" name="nim" 
                               value="<?= old('nim', $user['nim']) ?>" readonly disabled>
                        <small class="text-muted">NIM/NIDN tidak dapat diubah</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama" 
                               value="<?= old('nama', $user['nama']) ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= old('email', $user['email']) ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="prodi" class="form-label">Program Studi <span class="text-danger">*</span></label>
                        <select class="form-select" id="prodi" name="prodi" required>
                            <option value="">Pilih Program Studi</option>
                            <option value="Sistem Informasi" <?= old('prodi', $user['prodi']) == 'Sistem Informasi' ? 'selected' : '' ?>>Sistem Informasi</option>
                            <option value="Teknik Informatika" <?= old('prodi', $user['prodi']) == 'Teknik Informatika' ? 'selected' : '' ?>>Teknik Informatika</option>
                            <option value="Manajemen" <?= old('prodi', $user['prodi']) == 'Manajemen' ? 'selected' : '' ?>>Manajemen</option>
                            <option value="Akuntansi" <?= old('prodi', $user['prodi']) == 'Akuntansi' ? 'selected' : '' ?>>Akuntansi</option>
                            <option value="Hukum" <?= old('prodi', $user['prodi']) == 'Hukum' ? 'selected' : '' ?>>Hukum</option>
                            <option value="Psikologi" <?= old('prodi', $user['prodi']) == 'Psikologi' ? 'selected' : '' ?>>Psikologi</option>
                            <option value="Ekonomi" <?= old('prodi', $user['prodi']) == 'Ekonomi' ? 'selected' : '' ?>>Ekonomi</option>
                            <option value="Lainnya" <?= old('prodi', $user['prodi']) == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="mahasiswa" <?= old('role', $user['role']) == 'mahasiswa' ? 'selected' : '' ?>>Mahasiswa</option>
                            <option value="dosen" <?= old('role', $user['role']) == 'dosen' ? 'selected' : '' ?>>Dosen</option>
                            <?php if($user['id'] == session()->get('user_id')): ?>
                                <option value="admin" <?= old('role', $user['role']) == 'admin' ? 'selected' : '' ?>>Admin</option>
                            <?php endif; ?>
                        </select>
                        <?php if($user['id'] != session()->get('user_id') && $user['role'] == 'admin'): ?>
                            <small class="text-warning">Role admin tidak dapat diubah untuk user lain</small>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="is_active" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="is_active" name="is_active" required>
                            <option value="1" <?= old('is_active', $user['is_active']) == 1 ? 'selected' : '' ?>>Aktif</option>
                            <option value="0" <?= old('is_active', $user['is_active']) == 0 ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru (Opsional)</label>
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="Kosongkan jika tidak ingin mengubah password">
                        <small class="text-muted">Minimal 6 karakter</small>
                    </div>
                    
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Update User
                    </button>
                    <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-info-circle"></i> Informasi</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li><i class="fas fa-id-card text-primary"></i> ID: <?= $user['id'] ?></li>
                    <li><i class="fas fa-calendar text-primary"></i> Bergabung: <?= date('d/m/Y', strtotime($user['created_at'])) ?></li>
                    <li><i class="fas fa-clock text-primary"></i> Terakhir Update: <?= $user['updated_at'] ? date('d/m/Y', strtotime($user['updated_at'])) : '-' ?></li>
                </ul>
                <hr>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> NIM/NIDN tidak dapat diubah untuk keamanan data.
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>