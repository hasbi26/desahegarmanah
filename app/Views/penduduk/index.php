<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid py-3">
    <style>
        .list-card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
            overflow: hidden;
        }

        .list-card .card-header {
            background: #fff;
            border-bottom: 0;
        }

        .list-card .card-body {
            padding: 16px;
        }

        .btn-icon {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }

        .btn-icon i {
            font-size: 16px;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        .search-input {
            padding-left: 34px;
        }

        .table thead th {
            white-space: nowrap;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .actions {
            display: flex;
            gap: 6px;
            align-items: center;
        }
    </style>

    <div class="card list-card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0"><?= esc($title ?? 'Data Penduduk') ?></h5>
                <small class="text-muted">Kelola data penduduk</small>
            </div>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-secondary btn-sm" href="<?= base_url('penduduk/export/excel') ?>" title="Export CSV"><i class="lni lni-download"></i> CSV</a>
                <a class="btn btn-outline-secondary btn-sm" href="<?= base_url('penduduk/export/pdf') ?>" target="_blank" title="Export PDF"><i class="lni lni-printer"></i> PDF</a>
                <a class="btn btn-primary btn-sm" href="<?= base_url('penduduk/create') ?>" title="Tambah Data"><i class="lni lni-plus"></i> Tambah</a>
            </div>
        </div>
        <div class="card-body">
            <?php if (session('success')): ?>
                <div class="alert alert-success"><?= esc(session('success')) ?></div>
            <?php endif; ?>
            <?php if (session('error')): ?>
                <div class="alert alert-danger"><?= esc(session('error')) ?></div>
            <?php endif; ?>
            <?php if (session('errors')): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach (session('errors') as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form class="row g-2 mb-3" method="get">
                <div class="col-md-6 position-relative">
                    <i class="lni lni-search search-icon"></i>
                    <input type="text" name="q" value="<?= esc($q) ?>" class="form-control search-input" placeholder="Cari nama/NIK/KK/alamat" />
                </div>
                <div class="col-auto">
                    <button class="btn btn-outline-primary" title="Cari"><i class="lni lni-search-alt"></i> Cari</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-2">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>JK</th>
                            <th>Alamat</th>
                            <th>RT</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($items)): $no = 1 + ($page - 1) * $perPage;
                            foreach ($items as $i): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($i['nik']) ?></td>
                                    <td><?= esc($i['nama_lengkap']) ?></td>
                                    <td><?= esc($i['jenis_kelamin']) ?></td>
                                    <td><?= esc($i['alamat']) ?></td>
                                    <td><?= esc($i['rt_id']) ?></td>
                                    <td>
                                        <div class="actions">
                                            <a href="<?= base_url('penduduk/' . ($i['penduduk_id'] ?? $i['id'])) ?>" class="btn btn-outline-secondary btn-icon" title="Lihat">
                                                <i class="lni lni-eye"></i>
                                            </a>
                                            <a href="<?= base_url('penduduk/' . ($i['penduduk_id'] ?? $i['id']) . '/edit') ?>" class="btn btn-warning btn-icon" title="Edit">
                                                <i class="lni lni-pencil"></i>
                                            </a>
                                            <form action="<?= base_url('penduduk/' . ($i['penduduk_id'] ?? $i['id']) . '/delete') ?>" method="post" onsubmit="return confirm('Hapus data ini?')" style="display:inline">
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
                                <td colspan="7" class="text-center py-4">Tidak ada data</td>
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
                                <a class="page-link" href="?q=<?= urlencode($q) ?>&page=<?= $p ?>"><?= $p ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>