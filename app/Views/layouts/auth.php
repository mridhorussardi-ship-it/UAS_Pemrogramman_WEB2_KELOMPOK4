<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Student Aspirations' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
    <style>
        body {
            background: linear-gradient(135deg, #F8FAFC 0%, #E2E8F0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            padding: 20px;
        }
        .snow-auth-card {
            background: white;
            border-radius: var(--snow-radius-xl);
            border: 1px solid var(--snow-border);
            box-shadow: var(--snow-shadow-xl);
            padding: 40px 36px;
            max-width: 440px;
            width: 100%;
            animation: fadeInUp 0.4s ease;
        }
        .snow-auth-card .brand-icon {
            width: 56px;
            height: 56px;
            background: var(--snow-primary);
            border-radius: var(--snow-radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin: 0 auto 16px;
        }
    </style>
</head>
<body>
    <div class="snow-auth-card">
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert border-0" style="background:#FEE2E2; color:#991B1B; border-radius:var(--snow-radius-md); padding:12px 16px; font-size:0.9rem;">
                <i class="fas fa-exclamation-circle me-2"></i> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert border-0" style="background:#D1FAE5; color:#065F46; border-radius:var(--snow-radius-md); padding:12px 16px; font-size:0.9rem;">
                <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('errors')): ?>
            <div class="alert border-0" style="background:#FEE2E2; color:#991B1B; border-radius:var(--snow-radius-md); padding:12px 16px; font-size:0.9rem;">
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <div><i class="fas fa-exclamation-circle me-1"></i> <?= $error ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?= $this->renderSection('content') ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>