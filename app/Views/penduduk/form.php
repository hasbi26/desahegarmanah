<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid py-3">
    <div class="card page-header-card mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0"><?= esc($title ?? (isset($item) ? 'Edit Penduduk' : 'Tambah Penduduk')) ?></h5>
                <small>Lengkapi data penduduk tetap</small>
            </div>
            <div>
                <a href="<?= base_url('penduduk') ?>" class="btn btn-outline-secondary btn-sm"><i class="lni lni-arrow-left"></i> Kembali</a>
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
            <form method="post" action="<?= isset($item) ? base_url('penduduk/' . $item['id'] . '/update') : base_url('penduduk') ?>">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Nama Lengkap</label>
                        <input name="nama_lengkap" class="form-control" value="<?= esc($item['nama_lengkap'] ?? old('nama_lengkap')) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">NIK</label>
                        <input name="nik" class="form-control" value="<?= esc($item['nik'] ?? old('nik')) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">No KK</label>
                        <input name="no_kk" class="form-control" value="<?= esc($item['no_kk'] ?? old('no_kk')) ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Tempat Lahir</label>
                        <input name="tempat_lahir" class="form-control" value="<?= esc($item['tempat_lahir'] ?? old('tempat_lahir')) ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="<?= esc($item['tanggal_lahir'] ?? old('tanggal_lahir')) ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="">- pilih -</option>
                            <option value="L" <?= (isset($item['jenis_kelamin']) && $item['jenis_kelamin'] == 'L') ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="P" <?= (isset($item['jenis_kelamin']) && $item['jenis_kelamin'] == 'P') ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">RT</label>
                        <?php if ((int)($role ?? 0) === 2): ?>
                            <input type="hidden" name="rt_id" value="<?= esc(session('rt_id')) ?>">
                            <input class="form-control" value="<?= esc(session('rt_id')) ?>" readonly>
                        <?php else: ?>
                            <?php if (!empty($rtOptions)): ?>
                                <select name="rt_id" class="form-select" required>
                                    <option value="">- pilih -</option>
                                    <?php foreach ($rtOptions as $rt): ?>
                                        <option value="<?= $rt['id'] ?>" <?= (isset($item['rt_id']) && $item['rt_id'] == $rt['id']) ? 'selected' : '' ?>>RT <?= esc($rt['rt']) ?>/RW <?= esc($rt['rw']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else: ?>
                                <div class="alert alert-warning mb-0">Data RT belum tersedia. Tambahkan data RT terlebih dahulu.</div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Pendidikan</label>
                        <input name="pendidikan" class="form-control" value="<?= esc($item['pendidikan'] ?? old('pendidikan')) ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status Perkawinan</label>
                        <input name="status_perkawinan" class="form-control" value="<?= esc($item['status_perkawinan'] ?? old('status_perkawinan')) ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Agama</label>
                        <input name="agama" class="form-control" value="<?= esc($item['agama'] ?? old('agama')) ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Pekerjaan</label>
                        <input name="pekerjaan" class="form-control" value="<?= esc($item['pekerjaan'] ?? old('pekerjaan')) ?>">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2"><?= esc($item['alamat'] ?? old('alamat')) ?></textarea>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label d-block">Status Dinamis</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="kelahiran" <?= !empty($item['kelahiran']) ? 'checked' : '' ?>>
                            <label class="form-check-label">Kelahiran</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="pendatang" <?= !empty($item['pendatang']) ? 'checked' : '' ?>>
                            <label class="form-check-label">Pendatang</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="kematian" <?= !empty($item['kematian']) ? 'checked' : '' ?>>
                            <label class="form-check-label">Kematian</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="pindah" <?= !empty($item['pindah']) ? 'checked' : '' ?>>
                            <label class="form-check-label">Pindah</label>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Status Rumah</label>
                        <input name="status_rumah" class="form-control" value="<?= esc($item['status_rumah'] ?? old('status_rumah')) ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Luas Tanah (m2)</label>
                        <input name="luas_tanah" class="form-control" type="number" step="0.01" value="<?= esc($item['luas_tanah'] ?? old('luas_tanah')) ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Luas Bangunan (m2)</label>
                        <input name="luas_bangunan" class="form-control" type="number" step="0.01" value="<?= esc($item['luas_bangunan'] ?? old('luas_bangunan')) ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Air</label>
                        <input name="air" class="form-control" value="<?= esc($item['air'] ?? old('air')) ?>">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Listrik</label>
                        <input name="listrik" class="form-control" value="<?= esc($item['listrik'] ?? old('listrik')) ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Sampah</label>
                        <input name="sampah" class="form-control" value="<?= esc($item['sampah'] ?? old('sampah')) ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Limbah</label>
                        <input name="limbah" class="form-control" value="<?= esc($item['limbah'] ?? old('limbah')) ?>">
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