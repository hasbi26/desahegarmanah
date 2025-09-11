<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid py-3">
    <div class="card list-card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Pengguna</h5>
                <small class="text-muted">Kelola akun pengelola RT</small>
            </div>
            <div class="d-flex gap-2">
                <a class="btn btn-primary btn-sm" href="<?= base_url('users/create') ?>"><i class="lni lni-plus"></i> Tambah</a>
            </div>
        </div>
        <div class="card-body">
            <form class="row g-2 mb-3" method="get">
                <div class="col-md-6 position-relative">
                    <i class="lni lni-search search-icon"></i>
                    <input type="text" name="q" value="<?= esc($q ?? '') ?>" class="form-control search-input" placeholder="Cari username/email" />
                </div>
                <div class="col-auto">
                    <button class="btn btn-outline-primary"><i class="lni lni-search-alt"></i> Cari</button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>RT/RW</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($items)): $no = 1 + ($page - 1) * $perPage;
                            foreach ($items as $i): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($i['username']) ?></td>
                                    <td><?= esc($i['email']) ?></td>
                                    <td><?= esc(($i['rt'] ?? '-') . '/' . ($i['rw'] ?? '-')) ?></td>
                                    <td>
                                        <?php if ((int)($i['is_active'] ?? 1) === 1): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <a href="<?= base_url('users/' . $i['id'] . '/edit') ?>" class="btn btn-warning btn-icon" title="Edit">
                                                <i class="lni lni-pencil"></i>
                                            </a>
                                            <form action="<?= base_url('users/' . $i['id'] . '/delete') ?>" method="post" style="display:inline" onsubmit="return confirm('Hapus user ini?')">
                                                <button class="btn btn-danger btn-icon" type="submit" title="Hapus">
                                                    <i class="lni lni-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;
                        else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">Tidak ada data</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if (($totalPages ?? 1) > 1): ?>
                <nav>
                    <ul class="pagination mb-0">
                        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                            <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?q=<?= urlencode($q ?? '') ?>&page=<?= $p ?>"><?= $p ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>