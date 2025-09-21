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
            <form id="search-form" class="row g-2 mb-3">
                <div class="col-md-6 position-relative">
                    <i class="lni lni-search search-icon"></i>
                    <input type="text" name="q" value="<?= esc($q) ?>" class="form-control search-input" placeholder="Cari nama/NIK/KK/alamat" />
                </div>
                <div class="col-auto">
                    <button class="btn btn-outline-primary" type="submit" title="Cari"><i class="lni lni-search-alt"></i> Cari</button>
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
                    <tbody id="penduduk-body">
                        <!-- Data akan diisi via AJAX -->
                    </tbody>
                </table>
            </div>

            <nav>
                <ul id="pagination" class="pagination mb-0">
                    <!-- Pagination akan diisi via AJAX -->
                </ul>
            </nav>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let currentPage = 1;
        let currentQ = '';

        function loadData(page = 1, q = '') {
            $.ajax({
                url: '<?= base_url('penduduk/list-data') ?>',
                method: 'GET',
                data: { page: page, q: q },
                dataType: 'json',
                success: function(data) {
                    let tbody = $('#penduduk-body');
                    tbody.empty();
                    if (data.items && data.items.length > 0) {
                        let no = 1 + (data.page - 1) * data.perPage;
                        data.items.forEach(function(i) {
                            let row = `
                                <tr>
                                    <td>${no++}</td>
                                    <td>${i.nik}</td>
                                    <td>${i.nama_lengkap}</td>
                                    <td>${i.jenis_kelamin}</td>
                                    <td>${i.alamat}</td>
                                    <td>${i.rt_id}</td>
                                    <td>
                                        <div class="actions">
                                            <a href="<?= base_url('penduduk/') ?>${i.penduduk_id}" class="btn btn-outline-secondary btn-icon" title="Lihat">
                                                <i class="lni lni-eye"></i>
                                            </a>
                                            <a href="<?= base_url('penduduk/') ?>${i.penduduk_id}/edit" class="btn btn-warning btn-icon" title="Edit">
                                                <i class="lni lni-pencil"></i>
                                            </a>
                                            <form action="<?= base_url('penduduk/') ?>${i.penduduk_id}/delete" method="post" onsubmit="return confirm('Hapus data ini?')" style="display:inline">
                                                <button class="btn btn-danger btn-icon" type="submit" title="Hapus">
                                                    <i class="lni lni-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            `;
                            tbody.append(row);
                        });
                    } else {
                        tbody.append('<tr><td colspan="7" class="text-center py-4">Tidak ada data</td></tr>');
                    }

                    // Render pagination
                    let pagination = $('#pagination');
                    pagination.empty();
                    const q = ($('input[name="q"]').val() || '').trim();
                    const buildHref = (p) => `?q=${encodeURIComponent(q)}&page=${p}`;
                    const maxPage = Math.max(1, parseInt(data.totalPages || 0, 10));
                    const current = Math.max(1, parseInt(data.page || 1, 10));
                    if (maxPage > 10) {
                        for (let p = 1; p <= 10; p++) {
                            let active = p === current ? 'active' : '';
                            pagination.append(`<li class="page-item ${active}"><a class="page-link" href="${buildHref(p)}" data-page="${p}">${p}</a></li>`);
                        }
                        const nextPage = Math.min(current + 1, maxPage);
                        pagination.append(`<li class="page-item"><a class="page-link" href="${buildHref(nextPage)}" data-page="${nextPage}">Next</a></li>`);
                    } else {
                        for (let p = 1; p <= maxPage; p++) {
                            let active = p === current ? 'active' : '';
                            pagination.append(`<li class="page-item ${active}"><a class="page-link" href="${buildHref(p)}" data-page="${p}">${p}</a></li>`);
                        }
                    }
                },
                error: function() {
                    alert('Gagal memuat data');
                }
            });
        }

        // Initial load
        loadData(currentPage, currentQ);

        // Search form submit
        $('#search-form').on('submit', function(e) {
            e.preventDefault();
            currentQ = $('input[name="q"]').val();
            currentPage = 1;
            loadData(currentPage, currentQ);
        });

        // Pagination click
        $('#pagination').on('click', 'a', function(e) {
            e.preventDefault();
            currentPage = $(this).data('page');
            loadData(currentPage, currentQ);
        });
    });
</script>
<?= $this->endSection() ?>