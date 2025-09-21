<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid py-3">
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
</div>

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
</script>

<!-- Modals: Add & Edit Enumerator -->
<?= $this->endSection() ?>