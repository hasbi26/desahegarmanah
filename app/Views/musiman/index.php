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
                <a class="btn btn-primary btn-sm" href="<?= base_url('musiman/create') ?>" title="Tambah"><i class="lni lni-plus"></i> Tambah</a>
            </div>
        </div>
        <div class="card-body">
            <form id="search-form" class="row g-2 mb-3">
                <div class="col-md-6 position-relative">
                    <i class="lni lni-search search-icon"></i>
                    <input name="q" value="<?= esc($q ?? '') ?>" class="form-control search-input" placeholder="Cari periode/keterangan/nama/NIK" />
                </div>
                <div class="col-auto">
                    <button class="btn btn-outline-primary" type="submit" title="Cari"><i class="lni lni-search-alt"></i> Cari</button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Penduduk ID</th>
                            <th>RT</th>
                            <th>Nama Lengkap</th>
                            <th>NIK</th>
                            <th>No. Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="musiman-body">
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
                url: '<?= base_url('musiman/ajaxList') ?>',
                method: 'GET',
                data: { page: page, q: q },
                dataType: 'json',
                success: function(data) {
                    let tbody = $('#musiman-body');
                    tbody.empty();
                    if (data.items && data.items.length > 0) {
                        let no = 1 + (data.page - 1) * data.perPage;
                        data.items.forEach(function(i) {
                            let row = `
                                <tr>
                                    <td>${no++}</td>
                                    <td>${i.penduduk_id || ''}</td>
                                    <td>${i.rt_id}</td>
                                    <td>${i.nama_lengkap || ''}</td>
                                    <td>${i.nik || ''}</td>
                                    <td>${i.no_telp || ''}</td>
                                    <td>
                                        <div class="actions">
                                            <a href="<?= base_url('musiman/') ?>${i.id}/edit" class="btn btn-warning btn-icon" title="Edit">
                                                <i class="lni lni-pencil"></i>
                                            </a>
                                            <form action="<?= base_url('musiman/') ?>${i.id}/delete" method="post" style="display:inline" onsubmit="return confirm('Hapus data ini?')">
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