<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Student Aspirations' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
    <style>
        /* Navbar SnowUI */
        .navbar-snow {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--snow-border);
            padding: 12px 0;
        }
        .navbar-snow .brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--snow-text-primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .navbar-snow .brand i { color: var(--snow-primary); }
        .navbar-snow .nav-link-snow {
            color: var(--snow-text-secondary);
            padding: 6px 14px;
            border-radius: var(--snow-radius-md);
            font-size: 0.9rem;
            font-weight: 500;
            transition: var(--snow-transition);
        }
        .navbar-snow .nav-link-snow:hover,
        .navbar-snow .nav-link-snow.active {
            background: var(--snow-primary-bg);
            color: var(--snow-primary);
        }
        .avatar-snow {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--snow-primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .footer-snow {
            border-top: 1px solid var(--snow-border);
            padding: 20px 0;
            margin-top: auto;
            color: var(--snow-text-muted);
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

<nav class="navbar-snow sticky-top">
    <div class="container d-flex align-items-center justify-content-between">
        <a href="<?= base_url('dashboard') ?>" class="brand">
            <i class="fas fa-graduation-cap"></i> Student Aspirations
        </a>

        <div class="d-none d-lg-flex align-items-center gap-1">
            <?php if(session()->get('isLoggedIn')): ?>
                <?php if(session()->get('role') == 'admin'): ?>
                    <a class="nav-link-snow <?= current_url() == base_url('admin/dashboard') ? 'active' : '' ?>" href="<?= base_url('admin/dashboard') ?>"><i class="fas fa-tachometer-alt me-1"></i> Dashboard</a>
                    <a class="nav-link-snow <?= strpos(current_url(), 'admin/aspirasi') !== false ? 'active' : '' ?>" href="<?= base_url('admin/aspirasi') ?>"><i class="fas fa-list me-1"></i> Aspirasi</a>
                    <a class="nav-link-snow <?= strpos(current_url(), 'admin/users') !== false ? 'active' : '' ?>" href="<?= base_url('admin/users') ?>"><i class="fas fa-users me-1"></i> Users</a>
                    <a class="nav-link-snow <?= strpos(current_url(), 'admin/laporan') !== false ? 'active' : '' ?>" href="<?= base_url('admin/laporan') ?>"><i class="fas fa-chart-bar me-1"></i> Laporan</a>
                <?php elseif(session()->get('role') == 'dosen'): ?>
                    <a class="nav-link-snow <?= current_url() == base_url('dosen/dashboard') ? 'active' : '' ?>" href="<?= base_url('dosen/dashboard') ?>"><i class="fas fa-tachometer-alt me-1"></i> Dashboard</a>
                    <a class="nav-link-snow <?= strpos(current_url(), 'dosen/aspirasi') !== false ? 'active' : '' ?>" href="<?= base_url('dosen/aspirasi') ?>"><i class="fas fa-list me-1"></i> Aspirasi</a>
                <?php else: ?>
                    <a class="nav-link-snow <?= current_url() == base_url('dashboard') ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>"><i class="fas fa-tachometer-alt me-1"></i> Dashboard</a>
                    <a class="nav-link-snow <?= strpos(current_url(), 'aspirasi') !== false && strpos(current_url(), 'create') === false ? 'active' : '' ?>" href="<?= base_url('aspirasi') ?>"><i class="fas fa-list me-1"></i> Aspirasi</a>
                    <a class="nav-link-snow <?= strpos(current_url(), 'aspirasi/create') !== false ? 'active' : '' ?>" href="<?= base_url('aspirasi/create') ?>"><i class="fas fa-plus-circle me-1"></i> Buat</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="d-flex align-items-center gap-3">
            <?php if(session()->get('isLoggedIn')): ?>
                <div class="dropdown">
                    <a href="#" data-bs-toggle="dropdown" class="d-flex align-items-center gap-2 text-decoration-none">
                        <span class="avatar-snow"><?= strtoupper(substr(session()->get('nama'), 0, 1)) ?></span>
                        <span class="d-none d-md-inline" style="font-weight:500; color:var(--snow-text-secondary);"><?= session()->get('nama') ?></span>
                        <i class="fas fa-chevron-down" style="font-size:0.7rem; color:var(--snow-text-muted);"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="border-radius:var(--snow-radius-lg); padding:8px; min-width:200px;">
                        <li><a class="dropdown-item" href="<?= base_url('dashboard') ?>"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="<?= base_url('login') ?>" class="snow-btn snow-btn-ghost">Login</a>
                <a href="<?= base_url('register') ?>" class="snow-btn snow-btn-primary">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<main class="container py-4">
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0" style="background:#D1FAE5; color:#065F46; border-radius:var(--snow-radius-md); padding:12px 16px;">
            <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger border-0" style="background:#FEE2E2; color:#991B1B; border-radius:var(--snow-radius-md); padding:12px 16px;">
            <i class="fas fa-exclamation-circle me-2"></i> <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    <?= $this->renderSection('content') ?>
</main>

<footer class="footer-snow">
    <div class="container text-center">
        &copy; <?= date('Y') ?> <span class="fw-bold" style="color:var(--snow-text-primary);">Student Aspirations</span>
        <span class="mx-2">|</span> Built with <i class="fas fa-heart" style="color: var(--snow-danger);"></i> for students
        <?php if(session()->get('isLoggedIn')): ?>
            <span class="mx-2">|</span> <span style="color:var(--snow-text-muted);"><?= session()->get('nama') ?></span>
        <?php endif; ?>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Auto dismiss alerts
    setTimeout(function() { $('.alert').fadeOut('slow'); }, 5000);
</script>
</body>
</html>