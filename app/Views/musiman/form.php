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

    <?php if ((service('request')->getGet('debug_rt') ?? '') == '1'): ?>
        <div class="alert alert-info">
            <strong>DEBUG session:</strong>
            <div>session('user_id'): <?= esc(session('user_id') ?? '-') ?></div>
            <div>session('role'): <?= esc(session('role') ?? '-') ?></div>
            <div>session('rt_id'): <?= esc(session('rt_id') ?? '-') ?></div>
            <div>old('rt_id'): <?= esc(old('rt_id') ?? '-') ?></div>
            <small class="text-muted">(Hapus ?debug_rt=1 setelah pengecekan)</small>
        </div>
    <?php endif; ?>

    <div class="card detail-card">
        <div class="card-header"><i class="lni lni-form me-1"></i> Input Data</div>
        <div class="card-body">
            <form method="post" action="<?= isset($item) ? base_url('musiman/' . $item['id'] . '/update') : base_url('musiman') ?>">
                <?= csrf_field() ?>
                <?php if (!empty($item['id'])): ?>
                    <!-- Ensure form submits the record id so controller updates musiman -->
                    <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                <?php endif; ?>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Periode (contoh: 2025-01)</label>
                        <input name="periode" class="form-control" value="<?= esc($item['periode'] ?? old('periode')) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Penduduk (opsional)</label>
                        <div class="position-relative">
                            <input id="penduduk_search" type="text" class="form-control" placeholder="Cari nama atau NIK" value="<?= esc($item['penduduk_name'] ?? old('penduduk_name') ?? '') ?>">
                            <input id="penduduk_id" name="penduduk_id" type="hidden" value="<?= esc($item['penduduk_id'] ?? old('penduduk_id')) ?>">
                            <div id="penduduk_results" class="list-group position-absolute" style="z-index:50;width:100%;display:none;"></div>
                        </div>
                    </div>
                    <?php if (session('role') == 1): ?>
                        <div class="col-md-4">
                            <label class="form-label">RT ID</label>
                            <input name="rt_id" class="form-control" value="<?= esc($item['rt_id'] ?? old('rt_id')) ?>">
                        </div>
                    <?php else: ?>
                        <?php if (session('rt_id')): ?>
                            <input type="hidden" name="rt_id" value="<?= esc(session('rt_id')) ?>">
                        <?php endif; ?>
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

                    <hr class="mt-4" />
                    <div class="col-12"><strong>Data Pribadi</strong></div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input name="nama_lengkap" class="form-control" value="<?= esc($item['nama_lengkap'] ?? old('nama_lengkap')) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select">
                            <option value="" disabled selected>Pilih</option>
                            <option value="L" <?= (old('jenis_kelamin') === 'L' || ($item['jenis_kelamin'] ?? '') === 'L') ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="P" <?= (old('jenis_kelamin') === 'P' || ($item['jenis_kelamin'] ?? '') === 'P') ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIK</label>
                        <input name="nik" class="form-control" value="<?= esc($item['nik'] ?? old('nik')) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tempat Lahir</label>
                        <input name="tempat_lahir" class="form-control" value="<?= esc($item['tempat_lahir'] ?? old('tempat_lahir')) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input name="tanggal_lahir" type="date" class="form-control" value="<?= esc($item['tanggal_lahir'] ?? old('tanggal_lahir')) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status Perkawinan</label>
                        <input name="status_perkawinan" class="form-control" value="<?= esc($item['status_perkawinan'] ?? old('status_perkawinan')) ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alasan Tinggal</label>
                        <textarea name="alasan_tinggal" class="form-control" rows="2"><?= esc($item['alasan_tinggal'] ?? old('alasan_tinggal')) ?></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Lainnya</label>
                        <textarea name="lainnya" class="form-control" rows="2"><?= esc($item['lainnya'] ?? old('lainnya')) ?></textarea>
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
<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const search = document.getElementById('penduduk_search');
        const hid = document.getElementById('penduduk_id');
        const results = document.getElementById('penduduk_results');
        let timeout = null;

        function clearResults() {
            results.innerHTML = '';
            results.style.display = 'none';
        }

        function renderRows(rows) {
            results.innerHTML = '';
            if (!rows || rows.length === 0) {
                clearResults();
                return;
            }
            rows.forEach(r => {
                const a = document.createElement('a');
                a.href = '#';
                a.className = 'list-group-item list-group-item-action';
                a.textContent = r.nama_lengkap + ' — ' + (r.nik || '-');
                a.dataset.id = r.id;
                a.addEventListener('click', function(ev) {
                    ev.preventDefault();
                    hid.value = this.dataset.id;
                    search.value = this.textContent;
                    clearResults();
                });
                results.appendChild(a);
            });
            results.style.display = 'block';
        }

        search.addEventListener('input', function() {
                hid.value = '';
                const q = this.value.trim();
                if (timeout) clearTimeout(timeout);
                if (q.length < 2) {
                    clearResults();
                    return;
                }
                timeout = setTimeout(() => {
                        fetch('<?= base_url('api/penduduk-tetap/search') ?>?q=' + encodeURIComponent(q))
                            .then(r => r.json())
                            .then(json => {
                                if (json && json.status === 'ok') renderRows(json.data || []);
                            }).catch(() => {
                        clearResults();
                    });
                }, 300);
        });

    document.addEventListener('click', function(e) {
        if (!results.contains(e.target) && e.target !== search) {
            clearResults();
        }
    });
    });
</script>
<?= $this->endSection() ?>