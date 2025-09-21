<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid py-3">
    <div class="card page-header-card mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0"><?= esc($title ?? (isset($item) ? 'Edit Pengguna' : 'Tambah Pengguna')) ?></h5>
                <small>Pengguna peran Pengelola RT</small>
            </div>
            <div>
                <a href="<?= base_url('users') ?>" class="btn btn-outline-secondary btn-sm"><i class="lni lni-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>

    <?php if (session('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session('errors') as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (session('success')): ?>
        <div class="alert alert-success">
            <?= esc(session('success')) ?>
        </div>
    <?php elseif (session('error')): ?>
        <div class="alert alert-danger">
            <?= esc(session('error')) ?>
        </div>
    <?php endif; ?>

    <div class="card detail-card">
        <div class="card-header"><i class="lni lni-protection me-1"></i> Data Pengguna</div>
        <div class="card-body">
            <form method="post" action="<?= isset($item) ? base_url('users/' . $item['id'] . '/update') : base_url('users') ?>">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Username</label>
                        <input name="username" class="form-control" value="<?= esc($item['username'] ?? old('username')) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= esc($item['email'] ?? old('email')) ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">RT</label>
                        <select name="rt_id" class="form-select" required>
                            <option value="">- pilih -</option>
                            <?php foreach (($rtOptions ?? []) as $rt): ?>
                                <option value="<?= $rt['id'] ?>" <?= (isset($item['rt_id']) && (int)$item['rt_id'] === (int)$rt['id']) ? 'selected' : '' ?>>RT <?= esc($rt['rt']) ?>/RW <?= esc($rt['rw']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="">- pilih -</option>
                            <option value="desa/admin" <?= isset($item['role']) && $item['role'] === 'desa/admin' ? 'selected' : '' ?>>Desa/Admin</option>
                            <option value="rt" <?= isset($item['role']) && $item['role'] === 'rt' ? 'selected' : '' ?>>RT</option>
                            <option value="kecamatan" <?= isset($item['role']) && $item['role'] === 'kecamatan' ? 'selected' : '' ?>>Kecamatan</option>
                            <option value="kabupaten" <?= isset($item['role']) && $item['role'] === 'kabupaten' ? 'selected' : '' ?>>Kabupaten</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Password <?= isset($item) ? '(kosongkan jika tidak diubah)' : '' ?></label>
                        <input type="password" name="password" class="form-control" <?= isset($item) ? '' : 'required' ?>>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-select">
                            <option value="1" <?= (isset($item['is_active']) && (int)$item['is_active'] === 1) ? 'selected' : '' ?>>Aktif</option>
                            <option value="0" <?= (isset($item['is_active']) && (int)$item['is_active'] === 0) ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>