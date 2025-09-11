<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="section">
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0">Detail Penduduk</h4>
                    <small class="text-muted">Informasi lengkap penduduk</small>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('penduduk') ?>" class="btn btn-outline-secondary"><i class="lni lni-arrow-left"></i> Kembali</a>
                    <a href="<?= base_url('penduduk/' . (int)($item['id'] ?? 0) . '/edit') ?>" class="btn btn-primary"><i class="lni lni-pencil"></i> Edit</a>
                </div>
            </div>
        </div>

        <style>
            .detail-card {
                border: none;
                border-radius: 14px;
                box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
            }

            .detail-card .card-header {
                background: #fff;
                border-bottom: 0;
                font-weight: 600;
            }

            .detail-card .list-group-item {
                border: 0;
                padding: .6rem 0;
            }

            .detail-label {
                color: #6b7280;
                min-width: 180px;
                display: inline-block;
            }
        </style>

        <div class="card detail-card">
            <div class="card-header"><i class="lni lni-user me-1"></i> Biodata</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled mb-0">
                            <li class="list-group-item"><span class="detail-label">Nama Lengkap</span>: <strong><?= esc($item['nama_lengkap'] ?? '-') ?></strong></li>
                            <li class="list-group-item"><span class="detail-label">NIK</span>: <?= esc($item['nik'] ?? '-') ?></li>
                            <li class="list-group-item"><span class="detail-label">No. KK</span>: <?= esc($item['no_kk'] ?? '-') ?></li>
                            <li class="list-group-item"><span class="detail-label">Jenis Kelamin</span>: <?= esc($item['jenis_kelamin'] ?? '-') ?></li>
                            <li class="list-group-item"><span class="detail-label">Tempat, Tgl Lahir</span>: <?= esc(($item['tempat_lahir'] ?? '-') . ', ' . ($item['tanggal_lahir'] ?? '-')) ?></li>
                            <li class="list-group-item"><span class="detail-label">Pendidikan</span>: <?= esc($item['pendidikan'] ?? '-') ?></li>
                            <li class="list-group-item"><span class="detail-label">Status Perkawinan</span>: <?= esc($item['status_perkawinan'] ?? '-') ?></li>
                            <li class="list-group-item"><span class="detail-label">Agama</span>: <?= esc($item['agama'] ?? '-') ?></li>
                            <li class="list-group-item"><span class="detail-label">Pekerjaan</span>: <?= esc($item['pekerjaan'] ?? '-') ?></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled mb-0">
                            <li class="list-group-item"><span class="detail-label">Alamat</span>: <?= esc($item['alamat'] ?? '-') ?></li>
                            <li class="list-group-item"><span class="detail-label">RT</span>: <?= esc($item['rt_id'] ?? '-') ?></li>
                            <li class="list-group-item"><span class="detail-label">Status Rumah</span>: <?= esc($item['status_rumah'] ?? '-') ?></li>
                            <li class="list-group-item"><span class="detail-label">Luas Tanah</span>: <?= esc($item['luas_tanah'] ?? '-') ?></li>
                            <li class="list-group-item"><span class="detail-label">Luas Bangunan</span>: <?= esc($item['luas_bangunan'] ?? '-') ?></li>
                            <li class="list-group-item"><span class="detail-label">Air</span>: <?= esc($item['air'] ?? '-') ?></li>
                            <li class="list-group-item"><span class="detail-label">Listrik</span>: <?= esc($item['listrik'] ?? '-') ?></li>
                            <li class="list-group-item"><span class="detail-label">Sampah</span>: <?= esc($item['sampah'] ?? '-') ?></li>
                            <li class="list-group-item"><span class="detail-label">Limbah</span>: <?= esc($item['limbah'] ?? '-') ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>