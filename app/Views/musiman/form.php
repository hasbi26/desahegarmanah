<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid py-3">
    <div class="card page-header-card mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0"><?= esc($title ?? 'Form Musiman') ?></h5>
                <small>Lengkapi data penduduk musiman</small>
            </div>
            <div>
                <a href="<?= base_url('musiman') ?>" class="btn btn-outline-secondary btn-sm"><i class="lni lni-arrow-left"></i> Kembali</a>
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

    <div class="card detail-card">
        <div class="card-header"><i class="lni lni-form me-1"></i> Input Data</div>
        <div class="card-body">
            <form method="post" action="<?= isset($item) ? base_url('musiman/' . $item['id'] . '/update') : base_url('musiman') ?>">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Periode (contoh: 2025-01)</label>
                        <input name="periode" class="form-control" value="<?= esc($item['periode'] ?? old('periode')) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Penduduk ID (opsional)</label>
                        <input name="penduduk_id" class="form-control" value="<?= esc($item['penduduk_id'] ?? old('penduduk_id')) ?>">
                    </div>
                    <?php if (session('role') == 1): ?>
                        <div class="col-md-4">
                            <label class="form-label">RT ID</label>
                            <input name="rt_id" class="form-control" value="<?= esc($item['rt_id'] ?? old('rt_id')) ?>" required>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="rt_id" value="<?= esc(session('rt_id')) ?>">
                    <?php endif; ?>

                    <div class="col-12">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="2"><?= esc($item['keterangan'] ?? old('keterangan')) ?></textarea>
                    </div>

                    <hr class="mt-4" />
                    <div class="col-12"><strong>Alasan Tinggal / Domisili</strong></div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Perguruan Tinggi</label>
                        <input name="nama_perguruan_tinggi" class="form-control" value="<?= esc($item['nama_perguruan_tinggi'] ?? old('nama_perguruan_tinggi')) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Perusahaan</label>
                        <input name="nama_perusahaan" class="form-control" value="<?= esc($item['nama_perusahaan'] ?? old('nama_perusahaan')) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Alamat Tempat Jualan</label>
                        <textarea name="alamat_tempat_jualan" class="form-control" rows="2"><?= esc($item['alamat_tempat_jualan'] ?? old('alamat_tempat_jualan')) ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Alasan Lainnya</label>
                        <textarea name="alasan_lainnya" class="form-control" rows="2"><?= esc($item['alasan_lainnya'] ?? old('alasan_lainnya')) ?></textarea>
                    </div>

                    <hr class="mt-4" />
                    <div class="col-12"><strong>Data Pondokan</strong></div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Pondokan</label>
                        <input name="nama_pondokan" class="form-control" value="<?= esc($item['nama_pondokan'] ?? old('nama_pondokan')) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No. Telepon</label>
                        <input name="no_telp" class="form-control" value="<?= esc($item['no_telp'] ?? old('no_telp')) ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alamat Pondokan</label>
                        <textarea name="alamat_pondokan" class="form-control" rows="2"><?= esc($item['alamat_pondokan'] ?? old('alamat_pondokan')) ?></textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Alamat Asal</label>
                        <textarea name="alamat_asal" class="form-control" rows="2"><?= esc($item['alamat_asal'] ?? old('alamat_asal')) ?></textarea>
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