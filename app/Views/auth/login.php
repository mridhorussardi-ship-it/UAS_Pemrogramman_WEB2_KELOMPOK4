<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<div class="text-center mb-4">
    <div class="brand-icon mx-auto"><i class="fas fa-graduation-cap"></i></div>
    <h4 class="fw-bold" style="letter-spacing:-0.025em;">Welcome Back</h4>
    <p style="color:var(--snow-text-muted); font-size:0.9rem;">Login to your student account</p>
</div>

<form action="<?= base_url('login') ?>" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label class="form-label fw-semibold" style="font-size:0.85rem; color:var(--snow-text-secondary);">Email Address</label>
        <input type="email" class="snow-input" name="email" placeholder="your@email.com" required>
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold" style="font-size:0.85rem; color:var(--snow-text-secondary);">Password</label>
        <input type="password" class="snow-input" name="password" placeholder="••••••••" required>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="use_jwt" name="use_jwt" value="1">
        <label class="form-check-label" for="use_jwt" style="font-size:0.85rem; color:var(--snow-text-secondary);">
            <i class="fas fa-key me-1" style="color:var(--snow-warning);"></i> Login with JWT
        </label>
    </div>
    <button type="submit" class="snow-btn snow-btn-primary w-100 py-2" style="font-size:1rem; justify-content:center;">
        <i class="fas fa-arrow-right me-2"></i> Sign In
    </button>
</form>

<div class="text-center mt-3" style="font-size:0.9rem; color:var(--snow-text-secondary);">
    Don't have an account? <a href="<?= base_url('register') ?>" class="fw-semibold" style="color:var(--snow-primary);">Sign Up</a>
</div>

<hr class="my-4" style="border-color:var(--snow-border);">

<div style="background:var(--snow-bg-page); border-radius:var(--snow-radius-md); padding:16px;">
    <p class="text-center mb-2 fw-semibold" style="font-size:0.85rem; color:var(--snow-text-secondary);">
        <i class="fas fa-users me-1"></i> Demo Accounts
    </p>
    <div class="row g-2 text-center" style="font-size:0.8rem;">
        <div class="col-6"><div style="background:white; padding:8px; border-radius:var(--snow-radius-md); border:1px solid var(--snow-border);"><span class="fw-bold">Admin</span><br><span style="color:var(--snow-text-muted);">admin@aspirasi.com</span></div></div>
        <div class="col-6"><div style="background:white; padding:8px; border-radius:var(--snow-radius-md); border:1px solid var(--snow-border);"><span class="fw-bold">Student</span><br><span style="color:var(--snow-text-muted);">demo@student.ac.id</span></div></div>
    </div>
    <p class="text-center mt-2" style="color:var(--snow-text-muted); font-size:0.7rem;">Password: <strong class="text-dark">admin123</strong> / <strong class="text-dark">demo123</strong></p>
</div>

<?php if(session()->get('jwt_token')): ?>
<div class="mt-3 p-2" style="background:#EEF2FF; border-radius:var(--snow-radius-md); border:1px solid #C7D2FE;">
    <small class="d-block text-truncate"><i class="fas fa-check-circle text-success me-1"></i> <strong>JWT Active</strong></small>
    <code class="d-block text-truncate" style="font-size:0.7rem;"><?= session()->get('jwt_token') ?></code>
    <a href="<?= base_url('auth/get-token') ?>" class="snow-btn snow-btn-sm snow-btn-primary mt-1" target="_blank"><i class="fas fa-download me-1"></i> Get Token</a>
    <a href="<?= base_url('auth/verify-token?token=' . session()->get('jwt_token')) ?>" class="snow-btn snow-btn-sm snow-btn-outline mt-1" target="_blank"><i class="fas fa-check me-1"></i> Verify</a>
</div>
<?php endif; ?>
<?= $this->endSection() ?>