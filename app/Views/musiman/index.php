<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid py-3">
    <div class="card list-card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0"><?= esc($title ?? 'Data Penduduk Musiman') ?></h5>
                <small class="text-muted">Kelola data penduduk musiman</small>
            </div>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-secondary btn-sm" href="<?= base_url('musiman/export/excel') ?>" title="Export CSV"><i class="lni lni-download"></i> CSV</a>
                <a class="btn btn-outline-secondary btn-sm" href="<?= base_url('musiman/export/pdf') ?>" target="_blank" title="Export PDF"><i class="lni lni-printer"></i> PDF</a>
                <a class="btn btn-primary btn-sm" href="<?= base_url('musiman/create') ?>" title="Tambah"><i class="lni lni-plus"></i> Tambah</a>
            </div>
        </div>
        <div class="card-body">
            <form class="row g-2 mb-3" method="get">
                <div class="col-md-6 position-relative">
                    <i class="lni lni-search search-icon"></i>
                    <input name="q" value="<?= esc($q) ?>" class="form-control search-input" placeholder="Cari periode/keterangan">
                </div>
                <div class="col-auto">
                    <button class="btn btn-outline-primary" title="Cari"><i class="lni lni-search-alt"></i> Cari</button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Periode</th>
                            <th>Penduduk ID</th>
                            <th>RT</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($items)): $no = 1 + ($page - 1) * $perPage;
                            foreach ($items as $i): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($i['periode']) ?></td>
                                    <td><?= esc($i['penduduk_id']) ?></td>
                                    <td><?= esc($i['rt_id']) ?></td>
                                    <td><?= esc($i['keterangan']) ?></td>
                                    <td>
                                        <div class="actions">
                                            <a href="<?= base_url('musiman/' . $i['id'] . '/edit') ?>" class="btn btn-warning btn-icon" title="Edit">
                                                <i class="lni lni-pencil"></i>
                                            </a>
                                            <form action="<?= base_url('musiman/' . $i['id'] . '/delete') ?>" method="post" style="display:inline" onsubmit="return confirm('Hapus data ini?')">
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