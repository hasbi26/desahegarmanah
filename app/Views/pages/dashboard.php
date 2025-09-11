<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- ========== section start ========== -->
<section class="section">
    <div class="container-fluid">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>Dashboard Penduduk</h2>
                        <p class="text-muted mb-0">Statistik ringkas dan manajemen data</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat Cards (Modern) -->
        <style>
            .stat-card {
                border: none;
                border-radius: 14px;
                color: #fff;
                overflow: hidden;
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
                position: relative;
            }

            .stat-card .card-body {
                padding: 18px 18px 10px 18px;
            }

            .stat-card .label {
                font-size: 14px;
                opacity: 0.95;
                margin-bottom: 6px;
            }

            .stat-card .value {
                font-size: 34px;
                font-weight: 700;
                line-height: 1;
            }

            .stat-card .trend {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                font-weight: 600;
                margin-top: 8px;
                font-size: 13px;
            }

            .stat-card .trend.up i {
                transform: rotate(0deg);
            }

            .stat-card .trend.down i {
                transform: rotate(180deg);
            }

            .stat-card .icon-bg {
                position: absolute;
                right: -10px;
                bottom: -10px;
                font-size: 90px;
                opacity: 0.15;
            }

            .bg-tetap {
                background: linear-gradient(135deg, #211DB4 0%, #4b47ff 100%);
            }

            .bg-musiman {
                background: linear-gradient(135deg, #1DA5B4 0%, #2fc9d9 100%);
            }

            .bg-baru {
                background: linear-gradient(135deg, #727272 0%, #9e9e9e 100%);
            }

            .bg-total {
                background: linear-gradient(135deg, #727272 0%, #9e9e9e 100%);
            }
        </style>

        <div class="row mt-3">
            <!-- Total Penduduk Tetap -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card stat-card bg-tetap">
                    <div class="card-body">
                        <div class="label">Total Penduduk Tetap</div>
                        <div class="value"><?= number_format((int)($stats['cards']['tetap']['total'] ?? 0)) ?></div>
                        <?php $pct = (float)($stats['cards']['tetap']['changePct'] ?? 0);
                        $up = $pct >= 0; ?>
                        <div class="trend <?= $up ? 'up' : 'down' ?>">
                            <i class="lni lni-arrow-up"></i>
                            <span><?= $up ? 'Naik' : 'Turun' ?> <?= number_format(abs($pct), 1, ',', '.') ?>% / 30 hari</span>
                        </div>
                        <div class="icon-bg"><i class="lni lni-users"></i></div>
                    </div>
                </div>
            </div>

            <!-- Total Penduduk Musiman -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card stat-card bg-musiman">
                    <div class="card-body">
                        <div class="label">Total Penduduk Musiman</div>
                        <div class="value"><?= number_format((int)($stats['cards']['musiman']['total'] ?? 0)) ?></div>
                        <?php $pct = (float)($stats['cards']['musiman']['changePct'] ?? 0);
                        $up = $pct >= 0; ?>
                        <div class="trend <?= $up ? 'up' : 'down' ?>">
                            <i class="lni lni-arrow-up"></i>
                            <span><?= $up ? 'Naik' : 'Turun' ?> <?= number_format(abs($pct), 1, ',', '.') ?>% / 30 hari</span>
                        </div>
                        <div class="icon-bg"><i class="lni lni-calendar"></i></div>
                    </div>
                </div>
            </div>

            <!-- Data Penduduk Baru (30 hari) -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card stat-card bg-baru">
                    <div class="card-body">
                        <div class="label">Data Penduduk Baru (30 hari)</div>
                        <div class="value"><?= number_format((int)($stats['cards']['baru']['total'] ?? 0)) ?></div>
                        <?php $pct = (float)($stats['cards']['baru']['changePct'] ?? 0);
                        $up = $pct >= 0; ?>
                        <div class="trend <?= $up ? 'up' : 'down' ?>">
                            <i class="lni lni-arrow-up"></i>
                            <span><?= $up ? 'Naik' : 'Turun' ?> <?= number_format(abs($pct), 1, ',', '.') ?>% / 30 hari</span>
                        </div>
                        <div class="icon-bg"><i class="lni lni-rocket"></i></div>
                    </div>
                </div>
            </div>

            <!-- Total Keseluruhan -->
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card stat-card bg-total">
                    <div class="card-body">
                        <div class="label">Total Keseluruhan</div>
                        <div class="value"><?= number_format((int)($stats['cards']['total_all']['total'] ?? 0)) ?></div>
                        <?php $pct = (float)($stats['cards']['total_all']['changePct'] ?? 0);
                        $up = $pct >= 0; ?>
                        <div class="trend <?= $up ? 'up' : 'down' ?>">
                            <i class="lni lni-arrow-up"></i>
                            <span><?= $up ? 'Naik' : 'Turun' ?> <?= number_format(abs($pct), 1, ',', '.') ?>% / 30 hari</span>
                        </div>
                        <div class="icon-bg"><i class="lni lni-stats-up"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row (Modern) -->
        <style>
            .chart-card {
                border: none;
                border-radius: 14px;
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
                overflow: hidden;
            }

            .chart-card .card-header {
                background: #fff;
                border-bottom: 0;
                font-weight: 600;
            }

            .chart-card .card-body {
                padding: 16px;
            }

            .chart-canvas {
                min-height: 280px;
            }
        </style>
        <div class="row">
            <div class="col-xl-6 mb-4">
                <div class="card chart-card">
                    <div class="card-header"><i class="lni lni-stats-up me-1"></i> Distribusi Per RT (Top 10)</div>
                    <div class="card-body"><canvas id="rtBarChart" class="chart-canvas"></canvas></div>
                </div>
            </div>
            <div class="col-xl-6 mb-4">
                <div class="card chart-card">
                    <div class="card-header"><i class="lni lni-pie-chart me-1"></i> Komposisi Jenis Kelamin</div>
                    <div class="card-body"><canvas id="jkPieChart" class="chart-canvas"></canvas></div>
                </div>
            </div>
        </div>

        <!-- Quick Actions / Links -->
        <div class="card mb-4">
            <div class="card-header"><i class="lni lni-cog"></i> Aksi Cepat</div>
            <div class="card-body d-flex gap-2 flex-wrap">
                <a class="btn btn-outline-primary" href="<?= base_url('penduduk') ?>">Kelola Data Penduduk</a>
                <a class="btn btn-primary" href="<?= base_url('penduduk/create') ?>">Tambah Data Penduduk</a>
                <a class="btn btn-outline-success" href="<?= base_url('musiman') ?>">Data Musiman</a>
                <a class="btn btn-outline-secondary" href="<?= base_url('settings') ?>">Pengaturan</a>
            </div>
        </div>

    </div>
</section>
<!-- ========== section end ========== -->

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    // Data for charts
    const perRT = <?= json_encode(array_map(fn($r) => ['rt' => (string)($r['rt_id'] ?? 'RT?'), 'jumlah' => (int)$r['jumlah']], $stats['perRT'] ?? []), JSON_UNESCAPED_SLASHES) ?>;
    const jkData = {
        laki: <?= (int)($stats['laki'] ?? 0) ?>,
        perempuan: <?= (int)($stats['perempuan'] ?? 0) ?>
    };

    window.addEventListener('DOMContentLoaded', () => {
        try {
            // Helper gradient
            const makeGradient = (ctx, color) => {
                const gradient = ctx.createLinearGradient(0, 0, 0, 240);
                gradient.addColorStop(0, color.replace('1)', '0.35)'));
                gradient.addColorStop(1, color.replace('1)', '0.05)'));
                return gradient;
            };

            // Bar chart per RT (modern)
            const ctxBar = document.getElementById('rtBarChart');
            if (ctxBar && window.Chart) {
                const c = ctxBar.getContext('2d');
                const baseColor = 'rgba(13,110,253,1)'; // bootstrap primary
                new Chart(c, {
                    type: 'bar',
                    data: {
                        labels: perRT.map(x => x.rt),
                        datasets: [{
                            label: 'Jumlah Penduduk',
                            data: perRT.map(x => x.jumlah),
                            backgroundColor: makeGradient(c, baseColor),
                            borderColor: 'rgba(13,110,253,0.9)',
                            borderWidth: 1,
                            borderRadius: 8,
                            maxBarThickness: 34,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#111827',
                                titleColor: '#fff',
                                bodyColor: '#e5e7eb',
                                padding: 10,
                                displayColors: false,
                                callbacks: {
                                    label: (ctx) => ` ${ctx.parsed.y?.toLocaleString('id-ID') ?? 0}`
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#6b7280'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(107,114,128,0.15)'
                                },
                                ticks: {
                                    color: '#6b7280'
                                }
                            }
                        }
                    }
                });
            }

            // Pie/Donut chart jenis kelamin (modern)
            const ctxPie = document.getElementById('jkPieChart');
            if (ctxPie && window.Chart) {
                const c2 = ctxPie.getContext('2d');
                new Chart(c2, {
                    type: 'doughnut',
                    data: {
                        labels: ['Laki-laki', 'Perempuan'],
                        datasets: [{
                            data: [jkData.laki, jkData.perempuan],
                            backgroundColor: ['#0d6efd', '#ffc107'],
                            hoverBackgroundColor: ['#0b5ed7', '#e0a800'],
                            borderWidth: 0,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '58%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                backgroundColor: '#111827',
                                titleColor: '#fff',
                                bodyColor: '#e5e7eb',
                                padding: 10,
                            }
                        }
                    }
                });
            }
        } catch (e) {
            console.error(e);
        }
    });

    // Enumerator CRUD via AJAX (existing)
    $(document).ready(function() {
        let currentPage = 1;
        let searchQuery = "";
        loadEnumerators(currentPage, searchQuery);

        $("#search").on("keyup", function() {
            searchQuery = $(this).val();
            loadEnumerators(1, searchQuery);
        });

        $(document).on("click", ".page-link", function(e) {
            e.preventDefault();
            let page = $(this).data("page");
            if (page) {
                currentPage = page;
                loadEnumerators(currentPage, searchQuery);
            }
        });

        $("#saveEnumerator").click(function() {
            let formData = $("#enumeratorForm").serialize();
            $.ajax({
                url: "<?= base_url('enumerator/store') ?>",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        $("#addEnumeratorModal").modal("hide");
                        $("#enumeratorForm")[0].reset();
                        loadEnumerators(1, "");
                        alert(response.message);
                    } else {
                        alert("Gagal: " + response.message);
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert("Terjadi kesalahan AJAX!");
                }
            });
        });
    });

    function loadEnumerators(page, search) {
        $.ajax({
            url: "<?= base_url('enumerator/read') ?>",
            type: "GET",
            data: {
                page,
                search
            },
            success: function(response) {
                let html = "";
                let data = response.data || [];
                let pagination = response.pagination || {
                    currentPage: 1,
                    totalPages: 1,
                    perPage: 5
                };
                if (data.length > 0) {
                    $.each(data, function(index, row) {
                        let no = (pagination.currentPage - 1) * pagination.perPage + (index + 1);
                        html += `
            <tr>
              <td>${no}</td>
              <td>${row.nama}</td>
              <td>${row.alamat ?? '-'}</td>
              <td>${row.hp_telepon ?? '-'}</td>
              <td>
                <div class="action">
                  <button class="text-warning btn-edit" data-id="${row.id}"><i class="lni lni-pencil-alt"></i></button>
                  <button class="text-danger btn-delete" data-id="${row.id}"><i class="lni lni-trash-can"></i></button>
                </div>
              </td>
            </tr>`;
                    });
                } else {
                    html = `<tr><td colspan="6" class="text-center">Data tidak ditemukan</td></tr>`;
                }
                $("#enumeratorData").html(html);

                // Pagination
                let pagHtml = "";
                let current = pagination.currentPage;
                let totalPages = pagination.totalPages;
                if (current > 1) {
                    pagHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${current-1}">Previous</a></li>`;
                }
                for (let i = 1; i <= totalPages; i++) {
                    pagHtml += `<li class="page-item ${i == current ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
                }
                if (current < totalPages) {
                    pagHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${current+1}">Next</a></li>`;
                }
                $("#pagination").html(pagHtml);
            }
        });
    }

    $(document).on("click", ".btn-edit", function() {
        let id = $(this).data("id");
        $.ajax({
            url: "<?= base_url('enumerator') ?>" + "/" + id,
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    let data = response.data;
                    $("#editEnumeratorModal #nama").val(data.nama);
                    $("#editEnumeratorModal #alamat").val(data.alamat);
                    $("#editEnumeratorModal #hp_telepon").val(data.hp_telepon);
                    $("#editEnumeratorModal").data("id", data.id);
                    $("#editEnumeratorModal").modal("show");
                } else {
                    alert(response.message);
                }
            }
        });
    });

    $(document).on("click", "#saveEnumeratorUpdate", function() {
        let id = $("#editEnumeratorModal").data("id");
        let formData = $("#editEnumeratorModal #enumeratorForm").serialize();
        $.ajax({
            url: "<?= base_url('enumerator/update') ?>" + "/" + id,
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    $("#editEnumeratorModal").modal("hide");
                    loadEnumerators(1, "");
                    alert(response.message);
                } else {
                    alert("Gagal: " + response.message);
                }
            }
        });
    });

    $(document).on("click", ".btn-delete", function() {
        if (!confirm("Yakin ingin menghapus data ini?")) return;
        let id = $(this).data("id");
        $.ajax({
            url: "<?= base_url('enumerator') ?>" + "/" + id,
            type: "DELETE",
            success: function(response) {
                loadEnumerators(1, "");
                alert(response.message || "Berhasil dihapus");
            },
            error: function() {
                alert("Gagal menghapus data");
            }
        });
    });
</script>

<!-- Modals: Add & Edit Enumerator -->
<?= $this->endSection() ?>