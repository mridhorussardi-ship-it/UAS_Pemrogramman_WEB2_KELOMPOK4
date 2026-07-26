<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div>
        <h1 class="h2">
            <i class="fas fa-user text-primary"></i> Detail User
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('admin/users') ?>">User</a></li>
                <li class="breadcrumb-item active">Detail</li>
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
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-user"></i> Informasi User</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">ID</th>
                        <td><?= $user['id'] ?></td>
                    </tr>
                    <tr>
                        <th>NIM/NIDN</th>
                        <td><code><?= esc($user['nim']) ?></code></td>
                    </tr>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td><strong><?= esc($user['nama']) ?></strong></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= esc($user['email']) ?></td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>
                            <span class="badge bg-<?= $user['role'] == 'admin' ? 'danger' : ($user['role'] == 'dosen' ? 'info' : 'success') ?>">
                                <?= ucfirst($user['role']) ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Program Studi</th>
                        <td><?= esc($user['prodi']) ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <?php if($user['is_active']): ?>
                                <span class="badge bg-success">Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Daftar</th>
                        <td><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></td>
                    </tr>
                    <tr>
                        <th>Terakhir Update</th>
                        <td><?= $user['updated_at'] ? date('d/m/Y H:i', strtotime($user['updated_at'])) : '-' ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-cog"></i> Aksi</h5>
            </div>
            <div class="card-body">
                <?php if($user['role'] != 'admin' || $user['id'] == session()->get('user_id')): ?>
                    <a href="<?= base_url('admin/users/edit/' . $user['id']) ?>" class="btn btn-warning w-100 mb-2">
                        <i class="fas fa-edit"></i> Edit User
                    </a>
                <?php endif; ?>
                
                <?php if($user['role'] != 'admin' && $user['id'] != session()->get('user_id')): ?>
                    <a href="<?= base_url('admin/users/delete/' . $user['id']) ?>" 
                       class="btn btn-danger w-100 mb-2"
                       onclick="return confirm('Yakin ingin menghapus user ini?')">
                        <i class="fas fa-trash"></i> Hapus User
                    </a>
                <?php endif; ?>
                
                <?php if($user['role'] != 'admin' || $user['id'] == session()->get('user_id')): ?>
                    <a href="<?= base_url('admin/users/toggle/' . $user['id']) ?>" 
                       class="btn btn-<?= $user['is_active'] ? 'secondary' : 'success' ?> w-100"
                       onclick="return confirm('Yakin ingin <?= $user['is_active'] ? 'menonaktifkan' : 'mengaktifkan' ?> user ini?')">
                        <i class="fas fa-<?= $user['is_active'] ? 'ban' : 'check-circle' ?>"></i>
                        <?= $user['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?> User
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>