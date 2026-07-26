<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 snow-animate-in">
    <div>
        <h1 class="fw-bold" style="font-size:1.8rem; letter-spacing:-0.025em;">
            <i class="fas fa-users me-2" style="color:var(--snow-primary);"></i> Kelola User
        </h1>
        <p class="m-0" style="color:var(--snow-text-secondary);">Semua pengguna sistem</p>
    </div>
</div>

<div class="snow-card p-0 snow-animate-in snow-delay-2" style="overflow:auto;">
    <table class="snow-table" style="width:100%;">
        <thead><tr><th>#</th><th>NIM/NIDN</th><th>Nama</th><th>Email</th><th>Role</th><th>Prodi</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            <?php if(empty($users)): ?>
                <tr><td colspan="8" style="text-align:center; color:var(--snow-text-muted); padding:40px;">Belum ada user</td></tr>
            <?php else: ?>
                <?php $no = 1; foreach($users as $user): ?>
                <tr>
                    <td style="font-weight:600; color:var(--snow-text-muted);"><?= $no++ ?></td>
                    <td><code style="background:var(--snow-bg-input); padding:2px 8px; border-radius:var(--snow-radius-sm); font-size:0.8rem;"><?= esc($user['nim']) ?></code></td>
                    <td style="color:var(--snow-text-primary); font-weight:500;"><?= esc($user['nama']) ?></td>
                    <td style="color:var(--snow-text-secondary);"><?= esc($user['email']) ?></td>
                    <td>
                        <?php 
                        $roleBadges = [
                            'admin' => 'snow-badge-role-admin',
                            'dosen' => 'snow-badge-role-dosen',
                            'mahasiswa' => 'snow-badge-role-mahasiswa'
                        ];
                        ?>
                        <span class="snow-badge <?= $roleBadges[$user['role']] ?? 'snow-badge-role-mahasiswa' ?>"><?= ucfirst($user['role']) ?></span>
                    </td>
                    <td style="color:var(--snow-text-secondary);"><?= esc($user['prodi']) ?></td>
                    <td>
                        <?php if($user['is_active']): ?>
                            <span class="snow-badge" style="background:#D1FAE5; color:#065F46; border-color:#6EE7B7;">Aktif</span>
                        <?php else: ?>
                            <span class="snow-badge" style="background:#FEE2E2; color:#991B1B; border-color:#FCA5A5;">Nonaktif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div style="display:flex; gap:4px; flex-wrap:wrap;">
                            <a href="<?= base_url('admin/users/' . $user['id']) ?>" class="snow-btn snow-btn-ghost snow-btn-sm"><i class="fas fa-eye"></i></a>
                            <?php if($user['role'] != 'admin' || $user['id'] == session()->get('user_id')): ?>
                                <a href="<?= base_url('admin/users/edit/' . $user['id']) ?>" class="snow-btn snow-btn-sm" style="background:#FEF3C7; color:#92400E; border-color:#FDE68A;"><i class="fas fa-edit"></i></a>
                            <?php endif; ?>
                            <?php if($user['role'] != 'admin' && $user['id'] != session()->get('user_id')): ?>
                                <a href="<?= base_url('admin/users/delete/' . $user['id']) ?>" class="snow-btn snow-btn-sm snow-btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?')"><i class="fas fa-trash"></i></a>
                            <?php endif; ?>
                            <?php if($user['role'] != 'admin' || $user['id'] == session()->get('user_id')): ?>
                                <a href="<?= base_url('admin/users/toggle/' . $user['id']) ?>" class="snow-btn snow-btn-sm" style="background:<?= $user['is_active'] ? '#FEE2E2' : '#D1FAE5' ?>; color:<?= $user['is_active'] ? '#991B1B' : '#065F46' ?>; border-color:<?= $user['is_active'] ? '#FCA5A5' : '#6EE7B7' ?>;" onclick="return confirm('Yakin ingin <?= $user['is_active'] ? 'menonaktifkan' : 'mengaktifkan' ?> user ini?')">
                                    <i class="fas fa-<?= $user['is_active'] ? 'ban' : 'check-circle' ?>"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>