<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<div class="text-center mb-4">
    <div class="brand-icon mx-auto"><i class="fas fa-user-plus"></i></div>
    <h4 class="fw-bold" style="letter-spacing:-0.025em;">Create Account</h4>
    <p style="color:var(--snow-text-muted); font-size:0.9rem;">Join as student or lecturer</p>
</div>

<form action="<?= base_url('register') ?>" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label class="form-label fw-semibold" style="font-size:0.85rem; color:var(--snow-text-secondary);">Register as</label>
        <select class="snow-input" name="role" required>
            <option value="mahasiswa" <?= old('role') == 'mahasiswa' ? 'selected' : '' ?>>Mahasiswa</option>
            <option value="dosen" <?= old('role') == 'dosen' ? 'selected' : '' ?>>Dosen</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold" style="font-size:0.85rem; color:var(--snow-text-secondary);">NIM / NIDN</label>
        <input type="text" class="snow-input" name="nim" placeholder="e.g., 20230001" value="<?= old('nim') ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold" style="font-size:0.85rem; color:var(--snow-text-secondary);">Full Name</label>
        <input type="text" class="snow-input" name="nama" placeholder="Your full name" value="<?= old('nama') ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold" style="font-size:0.85rem; color:var(--snow-text-secondary);">Email</label>
        <input type="email" class="snow-input" name="email" placeholder="you@email.com" value="<?= old('email') ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold" style="font-size:0.85rem; color:var(--snow-text-secondary);">Program Studi</label>
        <select class="snow-input" name="prodi" required>
            <option value="">Select Program</option>
            <option value="Sistem Informasi" <?= old('prodi') == 'Sistem Informasi' ? 'selected' : '' ?>>Sistem Informasi</option>
            <option value="Teknik Informatika" <?= old('prodi') == 'Teknik Informatika' ? 'selected' : '' ?>>Teknik Informatika</option>
            <option value="Manajemen" <?= old('prodi') == 'Manajemen' ? 'selected' : '' ?>>Manajemen</option>
            <option value="Akuntansi" <?= old('prodi') == 'Akuntansi' ? 'selected' : '' ?>>Akuntansi</option>
            <option value="Hukum" <?= old('prodi') == 'Hukum' ? 'selected' : '' ?>>Hukum</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold" style="font-size:0.85rem; color:var(--snow-text-secondary);">Password</label>
        <input type="password" class="snow-input" name="password" placeholder="Min 6 characters" required>
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold" style="font-size:0.85rem; color:var(--snow-text-secondary);">Confirm Password</label>
        <input type="password" class="snow-input" name="konfirmasi_password" placeholder="Repeat password" required>
    </div>
    <button type="submit" class="snow-btn snow-btn-primary w-100 py-2" style="font-size:1rem; justify-content:center;">
        <i class="fas fa-user-plus me-2"></i> Sign Up
    </button>
</form>

<div class="text-center mt-3" style="font-size:0.9rem; color:var(--snow-text-secondary);">
    Already have an account? <a href="<?= base_url('login') ?>" class="fw-semibold" style="color:var(--snow-primary);">Sign In</a>
</div>
<?= $this->endSection() ?>