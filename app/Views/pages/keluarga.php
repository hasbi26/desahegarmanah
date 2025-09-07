<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
th h6 {
    display: inline-block;
    margin: 0;
    font-size: 14px;
    /* sesuai tema */
}

.select2-search__field {
    user-select: text !important;
}


/* pastikan input search Select2 bisa diketik */
.select2-container .select2-search__field {
    display: block !important;
    width: 100% !important;
    padding: 6px 8px !important;
    font-size: 14px !important;
    color: #000 !important;
    background-color: #fff !important;
    pointer-events: auto !important;
    opacity: 1 !important;
}

/* Pastikan selalu ada border */
.select2-container--bootstrap-5 .select2-selection {
    border: 1px solid #ced4da !important;
    /* default bootstrap border */
    border-radius: 0.375rem !important;
    /* biar sama dengan form-control */
    min-height: calc(1.5em + .75rem + 2px) !important;
    padding: .375rem .75rem !important;
    display: flex !important;
    align-items: center !important;
    /* biar text selalu di tengah */
    min-height: calc(1.5em + .75rem + 2px) !important;
    /* sama dgn .form-select */
    padding: .375rem .75rem !important;
}

/* Saat fokus tetap ada border biru Bootstrap */
.select2-container--bootstrap-5 .select2-selection:focus {
    border-color: #86b7fe !important;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, .25) !important;
    outline: 0 !important;
}

.select2-container--bootstrap-5 .select2-selection__rendered {
    line-height: 1.5 !important;
    padding-left: 0 !important;
    margin: 0 !important;
}


/* biar dropdown selalu kelihatan di atas modal */
.select2-container.select2-container--open {
    z-index: 9999 !important;
}
</style>

<section class="section">
    <!-- ========== table components start ========== -->
    <section class="table-components">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Form SDGs</h2>
                        </div>
                    </div>
                    <!-- end col -->

                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- ========== title-wrapper end ========== -->

            <!-- ========== tables-wrapper start ========== -->
            <div class="tables-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-style mb-30">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#kuesionerModal">
                                        Tambah Data <i class="lni lni-circle-plus"></i>
                                    </button>
                                </div>

                                <div class="col-md-4 ms-auto">
                                    <input type="text" id="search" class="form-control"
                                        placeholder="Cari nama, alamat atau telepon...">
                                </div>
                            </div>


                            <div class="table-wrapper table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="lead-info">
                                                <h6>Enumerator</h6>
                                            </th>
                                            <th class="lead-email">
                                                <h6>No KK</h6>
                                            </th>
                                            <th class="lead-phone">
                                                <h6>Nik</h6>
                                            </th>
                                            <th class="lead-company">
                                                <h6>Nama</h6>
                                            </th>
                                            <th>
                                                <h6>Action</h6>
                                            </th>
                                        </tr>
                                        <!-- end table row-->
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="min-width">
                                                <div class="lead">
                                                    <div class="lead-text">
                                                        <p>Sujali</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="min-width">
                                                <p>3211934803458093</p>
                                            </td>
                                            <td class="min-width">
                                                <p>3211934803458093</p>
                                            </td>
                                            <td class="min-width">
                                                <p>Ahmad</p>
                                            </td>
                                            <td>
                                                <div class="action">
                                                    <button class="text-info">
                                                        <i class="lni lni-list"></i>
                                                    </button>
                                                    <button class="text-warning">
                                                        <i class="lni lni-pencil-alt"></i>
                                                    </button>
                                                    <button class="text-danger">
                                                        <i class="lni lni-trash-can"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- end table -->
                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- ========== tables-wrapper end ========== -->
        </div>
        <!-- end container -->
    </section>
    <!-- Modal Kuesioner -->
    <div class="modal fade" id="kuesionerModal" tabindex="-1" aria-labelledby="kuesionerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kuesionerModalLabel">Tambah Data Kuesioner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form akan dimuat via AJAX -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <!-- form create -->
                            <form id="sdgsForm">
                                <div class="card-style mb-10">
                                    <h6 class="mb-25">P1. Deskripsi Enumerator</h6>

                                    <label for="enumeratorSelect">Select Enumerator</label>
                                    <div class="select-position">
                                        <select name="enumerator_id" id="enumeratorSelect" style="width: 100%"></select>
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card-style mb-10" style="height: 155px">
                                <!-- P2 DESKRIPSI LOKASI -->
                                <div class="row">
                                    <div class="col-md-3">
                                        <h6 class="mb-25">P2. Deskripsi Lokasi</h6>
                                    </div>
                                    <div class="col-md-4">
                                        <!-- <label for="p205" class="form-label">RT/RW</label> -->
                                        <input type="text" class="form-control" id="rt_rw" name="rt_rw"
                                            placeholder="RT/RW">
                                    </div>
                                    <div class="col-md-4">
                                        <!-- <label for="p206" class="form-label">Nama</label> -->
                                        <input type="text" class="form-control" id="nama_responden"
                                            name="nama_responden" placeholder="Nama">
                                    </div>

                                </div>
                                <div class="row pt-4">
                                    <div class="col-md-5">
                                        <!-- <label for="p207" class="form-label">Alamat</label> -->
                                        <input type="text" class="form-control" id="alamat_responden"
                                            name="alamat_responden" placeholder="Alamat">
                                    </div>
                                    <div class="col-md-3">
                                        <!-- <label for="p208" class="form-label">Nomor HP</label> -->
                                        <input type="text" class="form-control" id="nomor_hp" name="nomor_hp"
                                            placeholder="Nomor HP">
                                    </div>
                                    <div class="col-md-4">
                                        <!-- <label for="p209" class="form-label">No Telp Kabel/Rumah</label> -->
                                        <input type="text" class="form-control" id="no_telepon_rumah"
                                            name="no_telepon_rumah" placeholder="No Telp Kabel/Rumah">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>



                    <!-- P3 DESKRIPSI KELUARGA -->
                    <div class="card-style mb-10">
                        <h5 class="mt-3">P3. Deskripsi Keluarga</h5>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="no_kk" class="form-label">Nomor KK</label>
                                <input type="text" class="form-control" id="no_kk" name="no_kk">
                            </div>
                            <div class="col-md-4">
                                <label for="nik_kepala_keluarga" class="form-label">NIK Kepala Keluarga</label>
                                <input type="text" class="form-control" id="nik_kepala_keluarga"
                                    name="nik_kepala_keluarga">
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Permukiman</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="akses-tab" data-bs-toggle="tab" data-bs-target="#akses"
                                type="button" role="tab" aria-controls="akses" aria-selected="false">Akses</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="individu-tab" data-bs-toggle="tab" data-bs-target="#individu"
                                type="button" role="tab" aria-controls="individu"
                                aria-selected="false">Individu</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pekerjaan-tab" data-bs-toggle="tab" data-bs-target="#pekerjaan"
                                type="button" role="tab" aria-controls="pekerjaan"
                                aria-selected="false">Pekerjaan</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="kesehatan-tab" data-bs-toggle="tab" data-bs-target="#kesehatan"
                                type="button" role="tab" aria-controls="kesehatan"
                                aria-selected="false">Kesehatan</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pendidikan-tab" data-bs-toggle="tab"
                                data-bs-target="#pendidikan" type="button" role="tab" aria-controls="pendidikan"
                                aria-selected="false">Pendidikan</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <!-- pemukiman -->
                            <!-- P4 PERMUKIMAN -->
                            <h5 class="mt-3">P4. Permukiman</h5>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="tempat_tinggal" class="form-label">Tempat tinggal yang ditempati</label>
                                    <select class="form-select" id="tempat_tinggal" name="tempat_tinggal">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Milik sendiri</option>
                                        <option value="2">Kontrak/Sewa</option>
                                        <option value="3">Bebas Sewa</option>
                                        <option value="4">Dipinjami</option>
                                        <option value="5">Dinas</option>
                                        <option value="6">Lainnya</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="status_lahan" class="form-label">Status lahan tempat tinggal</label>
                                    <select class="form-select" id="status_lahan" name="status_lahan">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Milik sendiri</option>
                                        <option value="2">Milik orang lain</option>
                                        <option value="3">Tanah negara</option>
                                        <option value="4">Lainnya</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Luas tempat tinggal</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" id="luas_lantai"
                                                name="luas_lantai" placeholder="Luas lantai (m2)">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" id="luas_lahan" name="luas_lahan"
                                                placeholder="Luas lahan (m2)">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <!-- P404 -->
                                <div class="col-md-3">
                                    <label for="jenis_lantai" class="form-label">Jenis lantai tempat tinggal
                                        terluas</label>
                                    <select class="form-select" id="jenis_lantai" name="jenis_lantai">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Marmer/granit</option>
                                        <option value="2">Keramik</option>
                                        <option value="3">Parket/vinil/permadani</option>
                                        <option value="4">Ubin/tegel/teraso</option>
                                        <option value="5">Kayu/papan kualitas tinggi</option>
                                        <option value="6">Semen/bata merah</option>
                                        <option value="7">Bambu</option>
                                        <option value="8">Kayu/papan kualitas rendah</option>
                                        <option value="9">Bambu</option>
                                        <option value="10">Lainnya</option>
                                    </select>
                                </div>

                                <!-- P405 -->
                                <div class="col-md-3">
                                    <label for="jenis_dinding" class="form-label">Dinding sebagian besar rumah</label>
                                    <select class="form-select" id="jenis_dinding" name="jenis_dinding">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Semen/beton/kayu berkualitas tinggi</option>
                                        <option value="2">Kayu berkualitas rendah/bambu</option>
                                        <option value="3">Lainnya</option>
                                    </select>
                                </div>

                                <!-- P406 -->
                                <div class="col-md-3">
                                    <label for="jendela" class="form-label">Jendela</label>
                                    <select class="form-select" id="jendela" name="jendela">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Ada, berfungsi</option>
                                        <option value="2">Ada, tidak berfungsi</option>
                                        <option value="3">Tidak ada</option>
                                    </select>
                                </div>

                                <!-- P407 -->
                                <div class="col-md-3">
                                    <label for="atap" class="form-label">Atap</label>
                                    <select class="form-select" id="atap" name="atap">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Genteng</option>
                                        <option value="2">Kayu/Jerami</option>
                                        <option value="3">Lainnya</option>
                                    </select>
                                </div>

                            </div>
                            <!-- P408 -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="penerangan" class="form-label">Penerangan rumah</label>
                                    <select class="form-select" id="penerangan" name="penerangan">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Listrik PLN</option>
                                        <option value="2">Listrik non PLN</option>
                                        <option value="3">Lampu minyak/lilin</option>
                                        <option value="4">Sumber penerangan lainnya</option>
                                        <option value="5">Tidak ada</option>
                                    </select>
                                </div>

                                <!-- P409 -->
                                <div class="col-md-3">
                                    <label for="energi_masak" class="form-label">Energi untuk memasak</label>
                                    <select class="form-select" id="energi_masak" name="energi_masak">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Gas kota / LPG / Biogas</option>
                                        <option value="2">Minyak tanah / Batu bara</option>
                                        <option value="3">Kayu bakar</option>
                                        <option value="4">Lainnya</option>
                                    </select>
                                </div>

                                <!-- P410 -->
                                <div class="col-md-4">
                                    <label for="sumber_kayu_bakar" class="form-label">Jika menggunakan kayu bakar,
                                        sumber
                                        kayu</label>
                                    <select class="form-select" id="sumber_kayu_bakar" name="sumber_kayu_bakar">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Pembelian</option>
                                        <option value="2">Diambil dari hutan</option>
                                        <option value="3">Diambil di luar/bukan hutan</option>
                                        <option value="4">Lainnya</option>
                                    </select>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <!-- P411 -->
                                <div class="col-md-3">
                                    <label for="pembuangan_sampah" class="form-label">Tempat pembuangan sampah</label>
                                    <select class="form-select" id="pembuangan_sampah" name="pembuangan_sampah">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Tidak ada</option>
                                        <option value="2">Di kebun/sungai/drainase</option>
                                        <option value="3">Dibakar</option>
                                        <option value="4">Tempat sampah</option>
                                        <option value="5">Tempat sampah diangkut reguler</option>
                                    </select>
                                </div>


                                <!-- P412 -->
                                <div class="col-md-3">
                                    <label for="fasilitas_mck" class="form-label">Fasilitas MCK</label>
                                    <select class="form-select" id="fasilitas_mck" name="fasilitas_mck">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Sendiri</option>
                                        <option value="2">Berkelompok/tetangga</option>
                                        <option value="3">MCK umum</option>
                                        <option value="4">Tidak ada</option>
                                    </select>
                                </div>

                                <!-- P413 -->
                                <div class="col-md-3">
                                    <label for="sumber_air_mandi" class="form-label">Sumber air mandi terbanyak
                                        dari</label>
                                    <select class="form-select" id="sumber_air_mandi" name="sumber_air_mandi">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Ledeng/perpipaan berbayar/air isi ulang/kemasan</option>
                                        <option value="2">Perpipaan</option>
                                        <option value="3">Mata air / Sumur</option>
                                        <option value="4">Sungai, danau, embung</option>
                                        <option value="5">Tadah air hujan</option>
                                        <option value="6">Lainnya</option>
                                    </select>
                                </div>

                                <!-- P414 -->
                                <div class="col-md-3">
                                    <label for="fasilitas_bab" class="form-label">Fasilitas buang air besar</label>
                                    <select class="form-select" id="fasilitas_bab" name="fasilitas_bab">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Jamban sendiri</option>
                                        <option value="2">Jamban bersama/tetangga</option>
                                        <option value="3">Jamban umum</option>
                                        <option value="4">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <!-- P415 -->
                                <div class="col-md-5">
                                    <label for="sumber_air_minum" class="form-label">Sumber air minum terbanyak
                                        dari</label>
                                    <select class="form-select" id="sumber_air_minum" name="sumber_air_minum">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Ledeng/perpipaan berbayar/air isi ulang/kemasan</option>
                                        <option value="2">Mata air / Perpipaan / Sumur</option>
                                        <option value="3">Sungai, danau, embung</option>
                                        <option value="4">Tadah air hujan</option>
                                        <option value="5">Lainnya</option>
                                    </select>
                                </div>

                                <!-- P416 -->
                                <div class="col-md-5">
                                    <label for="pembuangan_limbah_cair" class="form-label">Tempat pembuangan limbah
                                        cair</label>
                                    <select class="form-select" id="pembuangan_limbah_cair"
                                        name="pembuangan_limbah_cair">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Tangki/instalasi pengelolaan limbah</option>
                                        <option value="2">Sawah/kolam/sungai/drainase/laut</option>
                                        <option value="3">Lubang di tanah</option>
                                        <option value="4">Lainnya</option>
                                    </select>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <!-- P417 -->
                                <div class="col-md-5">
                                    <label for="bawah_sutet" class="form-label">Rumah berada di bawah
                                        SUTET/SUTT/SUTTAS</label>
                                    <select class="form-select" id="bawah_sutet" name="bawah_sutet">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Ya</option>
                                        <option value="2">Tidak</option>
                                    </select>
                                </div>

                                <!-- P418 -->
                                <div class="col-md-5">
                                    <label for="bantaran_sungai" class="form-label">Rumah di bantaran sungai</label>
                                    <select class="form-select" id="bantaran_sungai" name="bantaran_sungai">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Ya</option>
                                        <option value="2">Tidak</option>
                                    </select>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <!-- P419 -->
                                <div class="col-md-5">
                                    <label for="lereng_bukit" class="form-label">Rumah di lereng bukit/gunung</label>
                                    <select class="form-select" id="lereng_bukit" name="lereng_bukit">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Ya</option>
                                        <option value="2">Tidak</option>
                                    </select>
                                </div>

                                <!-- P420 -->
                                <div class="col-md-5">
                                    <label for="kondisi_rumah" class="form-label">Secara keseluruhan kondisi
                                        rumah</label>
                                    <select class="form-select" id="kondisi_rumah" name="kondisi_rumah">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Kumuh</option>
                                        <option value="2">Tidak kumuh</option>
                                    </select>
                                </div>

                            </div>
                            <!-- pemukiman -->
                        </div>
                        <div class="tab-pane fade" id="akses" role="tabpanel" aria-labelledby="akses-tab">
                            <!-- akses  -->
                            <!-- P421 -->
                            <div class="container-fluid mt-4">
                                <!-- Row 1: P421 & P422 -->
                                <div class="row mb-3">
                                    <!-- P421 -->
                                    <div class="col-md-6">
                                        <div class="card-style mb-30">
                                            <h6 class="mb-10">P421 - Akses Pendidikan terdekat</h6>
                                            <div class="table-wrapper table-responsive">
                                                <!-- <table class="table striped-table">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <h6>No</h6>
                                                            </th>
                                                            <th>
                                                                <h6>Fasilitas</h6>
                                                            </th>
                                                            <th>
                                                                <h6>Jarak (km) </h6>
                                                            </th>
                                                            <th>
                                                                <h6>Waktu Tempuh (jam) </h6>
                                                            </th>
                                                            <th>
                                                                <h6>Kemudahan </h6>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <p>1
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <p>PAUD
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="pendidikan_paud_jarak">

                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="pendidikan_paud_waktu">

                                                            </td>
                                                            <td>

                                                                <select class="form-control"
                                                                    name="pendidikan_paud_kemudahan">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>2
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <p>TK/RA
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="pendidikan_tk_jarak">

                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="pendidikan_tk_waktu">

                                                            </td>
                                                            <td>

                                                                <select class="form-control"
                                                                    name="pendidikan_tk_kemudahan">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>3
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <p>SD/MI
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="pendidikan_sd_jarak">

                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="pendidikan_sd_waktu">

                                                            </td>
                                                            <td>
                                                                <select class="form-control"
                                                                    name="pendidikan_sd_kemudahan">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>4
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <p>SMP/MTs
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="pendidikan_smp_jarak">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="pendidikan_smp_waktu">
                                                            </td>
                                                            <td>
                                                                <select class="form-control"
                                                                    name="pendidikan_smp_kemudahan">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>5
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <p>SMA/MA
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="pendidikan_sma_jarak">
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="pendidikan_sma_waktu">
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <p>
                                                                    <select class="form-control"
                                                                        name="pendidikan_sma_kemudahan">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Mudah</option>
                                                                        <option value="2">Sulit</option>
                                                                    </select>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>6
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <p>Perguruan tinggi
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="pendidikan_pt_jarak">

                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="pendidikan_pt_waktu">

                                                            </td>
                                                            <td>

                                                                <select class="form-control"
                                                                    name="pendidikan_pt_kemudahan">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>7
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <p>Pesantren
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="pendidikan_pesantren_jarak">

                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="pendidikan_pesantren_waktu">

                                                            </td>
                                                            <td>
                                                                <select class="form-control"
                                                                    name="pendidikan_pesantren_kemudahan">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>8
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <p>Seminari
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="pendidikan_seminari_jarak">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="pendidikan_seminari_waktu">
                                                            </td>
                                                            <td>
                                                                <p>
                                                                    <select class="form-control"
                                                                        name="pendidikan_seminari_kemudahan">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Mudah</option>
                                                                        <option value="2">Sulit</option>
                                                                    </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>9
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <p>Pendidikan keagamaan lain
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="pendidikan_keagamaan_jarak">

                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="pendidikan_keagamaan_waktu">

                                                            </td>
                                                            <td>
                                                                <select class="form-control"
                                                                    name="pendidikan_keagamaan_kemudahan">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table> -->

                                                <table class="table striped-table">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <h6>No</h6>
                                                            </th>
                                                            <th>
                                                                <h6>Fasilitas</h6>
                                                            </th>
                                                            <th>
                                                                <h6>Jarak (km)</h6>
                                                            </th>
                                                            <th>
                                                                <h6>Waktu Tempuh (jam)</h6>
                                                            </th>
                                                            <th>
                                                                <h6>Kemudahan</h6>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- daftar fasilitas pendidikan -->
                                                        <tr>
                                                            <td>
                                                                <p>1</p>
                                                            </td>
                                                            <td>
                                                                <p>PAUD</p>
                                                                <input type="hidden"
                                                                    name="akses_pendidikan[0][fasilitas]" value="PAUD">
                                                                <input type="hidden"
                                                                    name="akses_pendidikan[0][id_fasilitas]" value="1">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="akses_pendidikan[0][jarak_km]" step="0.01">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="akses_pendidikan[0][waktu_tempuh_jam]"
                                                                    step="0.01">
                                                            </td>
                                                            <td>
                                                                <select class="form-control"
                                                                    name="akses_pendidikan[0][kemudahan]">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>2</p>
                                                            </td>
                                                            <td>
                                                                <p>TK/RA</p>
                                                                <input type="hidden"
                                                                    name="akses_pendidikan[1][fasilitas]" value="TK/RA">
                                                                <input type="hidden"
                                                                    name="akses_pendidikan[1][id_fasilitas]" value="2">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="akses_pendidikan[1][jarak_km]" step="0.01">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="akses_pendidikan[1][waktu_tempuh_jam]"
                                                                    step="0.01">
                                                            </td>
                                                            <td>
                                                                <select class="form-control"
                                                                    name="akses_pendidikan[1][kemudahan]">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>3</p>
                                                            </td>
                                                            <td>
                                                                <p>SD/MI</p>
                                                                <input type="hidden"
                                                                    name="akses_pendidikan[2][fasilitas]" value="SD/MI">
                                                                <input type="hidden"
                                                                    name="akses_pendidikan[2][id_fasilitas]" value="3">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="akses_pendidikan[2][jarak_km]" step="0.01">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="akses_pendidikan[2][waktu_tempuh_jam]"
                                                                    step="0.01">
                                                            </td>
                                                            <td>
                                                                <select class="form-control"
                                                                    name="akses_pendidikan[2][kemudahan]">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>4</p>
                                                            </td>
                                                            <td>
                                                                <p>SMP/MTs</p>
                                                                <input type="hidden"
                                                                    name="akses_pendidikan[3][fasilitas]"
                                                                    value="SMP/MTs">
                                                                <input type="hidden"
                                                                    name="akses_pendidikan[3][id_fasilitas]" value="4">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="akses_pendidikan[3][jarak_km]" step="0.01">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="akses_pendidikan[3][waktu_tempuh_jam]"
                                                                    step="0.01">
                                                            </td>
                                                            <td>
                                                                <select class="form-control"
                                                                    name="akses_pendidikan[3][kemudahan]">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>5</p>
                                                            </td>
                                                            <td>
                                                                <p>SMA/MA</p>
                                                                <input type="hidden"
                                                                    name="akses_pendidikan[4][fasilitas]"
                                                                    value="SMA/MA">
                                                                <input type="hidden"
                                                                    name="akses_pendidikan[4][id_fasilitas]" value="5">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="akses_pendidikan[4][jarak_km]" step="0.01">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="akses_pendidikan[4][waktu_tempuh_jam]"
                                                                    step="0.01">
                                                            </td>
                                                            <td>
                                                                <select class="form-control"
                                                                    name="akses_pendidikan[4][kemudahan]">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>6</p>
                                                            </td>
                                                            <td>
                                                                <p>Perguruan tinggi</p>
                                                                <input type="hidden"
                                                                    name="akses_pendidikan[5][fasilitas]"
                                                                    value="Perguruan tinggi">
                                                                <input type="hidden"
                                                                    name="akses_pendidikan[5][id_fasilitas]" value="6">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="akses_pendidikan[5][jarak_km]" step="0.01">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="akses_pendidikan[5][waktu_tempuh_jam]"
                                                                    step="0.01">
                                                            </td>
                                                            <td>
                                                                <select class="form-control"
                                                                    name="akses_pendidikan[5][kemudahan]">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>7</p>
                                                            </td>
                                                            <td>
                                                                <p>Pesantren</p>
                                                                <input type="hidden"
                                                                    name="akses_pendidikan[6][fasilitas]"
                                                                    value="Pesantren">
                                                                <input type="hidden"
                                                                    name="akses_pendidikan[6][id_fasilitas]" value="7">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="akses_pendidikan[6][jarak_km]" step="0.01">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="akses_pendidikan[6][waktu_tempuh_jam]"
                                                                    step="0.01">
                                                            </td>
                                                            <td>
                                                                <select class="form-control"
                                                                    name="akses_pendidikan[6][kemudahan]">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>8</p>
                                                            </td>
                                                            <td>
                                                                <p>Seminari</p>
                                                                <input type="hidden"
                                                                    name="akses_pendidikan[7][fasilitas]"
                                                                    value="Seminari">
                                                                <input type="hidden"
                                                                    name="akses_pendidikan[7][id_fasilitas]" value="8">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="akses_pendidikan[7][jarak_km]" step="0.01">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="akses_pendidikan[7][waktu_tempuh_jam]"
                                                                    step="0.01">
                                                            </td>
                                                            <td>
                                                                <select class="form-control"
                                                                    name="akses_pendidikan[7][kemudahan]">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>9</p>
                                                            </td>
                                                            <td>
                                                                <p>Pendidikan keagamaan lain</p>
                                                                <input type="hidden"
                                                                    name="akses_pendidikan[8][fasilitas]"
                                                                    value="Pendidikan keagamaan lain">
                                                                <input type="hidden"
                                                                    name="akses_pendidikan[8][id_fasilitas]" value="9">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="akses_pendidikan[8][jarak_km]" step="0.01">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control"
                                                                    name="akses_pendidikan[8][waktu_tempuh_jam]"
                                                                    step="0.01">
                                                            </td>
                                                            <td>
                                                                <select class="form-control"
                                                                    name="akses_pendidikan[8][kemudahan]">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>


                                            </div>
                                        </div>
                                    </div>

                                    <!-- P422 -->
                                    <div class="col-md-6">
                                        <div class="card-style mb-30">
                                            <h6 class="mb-10">P422 - Akses Fasilitas Kesehatan terdekat</h6>
                                            <div class="table-wrapper table-responsive">
                                                <table class="table striped-table">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <h6>No</h6>
                                                            </th>
                                                            <th>
                                                                <h6>Fasilitas</h6>
                                                            </th>
                                                            <th>
                                                                <h6>Jarak (km)</h6>
                                                            </th>
                                                            <th>
                                                                <h6>Waktu Tempuh (jam)</h6>
                                                            </th>
                                                            <th>
                                                                <h6>Kemudahan</h6>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- 10 fasilitas -->
                                                        <tr>
                                                            <td>
                                                                <p>1</p>
                                                            </td>
                                                            <td>
                                                                <p>Rumah sakit</p>
                                                            </td>
                                                            <td><input type="number" class="form-control"
                                                                    name="kesehatan_rs_jarak"></td>
                                                            <td><input type="number" class="form-control"
                                                                    name="kesehatan_rs_waktu"></td>
                                                            <td>
                                                                <select class="form-control"
                                                                    name="kesehatan_rs_kemudahan">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>2</p>
                                                            </td>
                                                            <td>
                                                                <p>Rumah sakit bersalin</p>
                                                            </td>
                                                            <td><input type="number" class="form-control"
                                                                    name="kesehatan_rsb_jarak"></td>
                                                            <td><input type="number" class="form-control"
                                                                    name="kesehatan_rsb_waktu"></td>
                                                            <td>
                                                                <select class="form-control"
                                                                    name="kesehatan_rsb_kemudahan">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>3</p>
                                                            </td>
                                                            <td>
                                                                <p>Poliklinik</p>
                                                            </td>
                                                            <td><input type="number" class="form-control"
                                                                    name="kesehatan_poliklinik_jarak"></td>
                                                            <td><input type="number" class="form-control"
                                                                    name="kesehatan_poliklinik_waktu"></td>
                                                            <td>
                                                                <select class="form-control"
                                                                    name="kesehatan_poliklinik_kemudahan">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>4</p>
                                                            </td>
                                                            <td>
                                                                <p>Puskesmas</p>
                                                            </td>
                                                            <td><input type="number" class="form-control"
                                                                    name="kesehatan_puskesmas_jarak"></td>
                                                            <td><input type="number" class="form-control"
                                                                    name="kesehatan_puskesmas_waktu"></td>
                                                            <td>
                                                                <select class="form-control"
                                                                    name="kesehatan_puskesmas_kemudahan">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>5</p>
                                                            </td>
                                                            <td>
                                                                <p>Pustu</p>
                                                            </td>
                                                            <td><input type="number" class="form-control"
                                                                    name="kesehatan_pustu_jarak"></td>
                                                            <td><input type="number" class="form-control"
                                                                    name="kesehatan_pustu_waktu"></td>
                                                            <td>
                                                                <select class="form-control"
                                                                    name="kesehatan_pustu_kemudahan">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>6</p>
                                                            </td>
                                                            <td>
                                                                <p>Polindes</p>
                                                            </td>
                                                            <td><input type="number" class="form-control"
                                                                    name="kesehatan_polindes_jarak"></td>
                                                            <td><input type="number" class="form-control"
                                                                    name="kesehatan_polindes_waktu"></td>
                                                            <td>
                                                                <select class="form-control"
                                                                    name="kesehatan_polindes_kemudahan">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>7</p>
                                                            </td>
                                                            <td>
                                                                <p>Poskesdes</p>
                                                            </td>
                                                            <td><input type="number" class="form-control"
                                                                    name="kesehatan_poskesdes_jarak"></td>
                                                            <td><input type="number" class="form-control"
                                                                    name="kesehatan_poskesdes_waktu"></td>
                                                            <td>
                                                                <select class="form-control"
                                                                    name="kesehatan_poskesdes_kemudahan">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>8</p>
                                                            </td>
                                                            <td>
                                                                <p>Posyandu</p>
                                                            </td>
                                                            <td><input type="number" class="form-control"
                                                                    name="kesehatan_posyandu_jarak"></td>
                                                            <td><input type="number" class="form-control"
                                                                    name="kesehatan_posyandu_waktu"></td>
                                                            <td>
                                                                <select class="form-control"
                                                                    name="kesehatan_posyandu_kemudahan">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>9</p>
                                                            </td>
                                                            <td>
                                                                <p>Apotik</p>
                                                            </td>
                                                            <td><input type="number" class="form-control"
                                                                    name="kesehatan_apotik_jarak"></td>
                                                            <td><input type="number" class="form-control"
                                                                    name="kesehatan_apotik_waktu"></td>
                                                            <td>
                                                                <select class="form-control"
                                                                    name="kesehatan_apotik_kemudahan">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>10</p>
                                                            </td>
                                                            <td>
                                                                <p>Toko obat</p>
                                                            </td>
                                                            <td><input type="number" class="form-control"
                                                                    name="kesehatan_tokoobat_jarak"></td>
                                                            <td><input type="number" class="form-control"
                                                                    name="kesehatan_tokoobat_waktu"></td>
                                                            <td>
                                                                <select class="form-control"
                                                                    name="kesehatan_tokoobat_kemudahan">
                                                                    <option value="">-- pilih --</option>
                                                                    <option value="1">Mudah</option>
                                                                    <option value="2">Sulit</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Row 2: P423 & P424 -->
                                    <div class="row mb-3">
                                        <!-- P424 -->
                                        <div class="col-md-6">
                                            <div class="card-style mb-30">
                                                <h6 class="mb-10">P424 - Akses Prasarana & Sarana Transportasi</h6>
                                                <div class="table-wrapper table-responsive">
                                                    <table class="table striped-table"
                                                        style="table-layout: fixed; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:40px;">
                                                                    <h6>No</h6>
                                                                </th>
                                                                <th style="width:120px;">
                                                                    <h6>Tujuan
                                                                    </h6>
                                                                </th>
                                                                <th style="width:120px;">
                                                                    <h6>Jenis Transportasi
                                                                    </h6>
                                                                </th>
                                                                <th style="width:120px;">
                                                                    <h6>Transportasi Umum
                                                                    </h6>
                                                                </th>
                                                                <th style="width:120px;">
                                                                    <h6>Waktu Tempuh (jam)
                                                                    </h6>
                                                                </th>
                                                                <th style="width:120px;">
                                                                    <h6>Biaya (Rp)
                                                                    </h6>
                                                                </th>
                                                                <th style="width:120px;">
                                                                    <h6>Kemudahan
                                                                    </h6>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <p>1</p>
                                                                </td>
                                                                <td>
                                                                    <p>Lokasi pekerjaan utama</p>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="transportasi_pekerjaan_jenis">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Darat</option>
                                                                        <option value="2">Air</option>
                                                                        <option value="3">Udara</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="transportasi_pekerjaan_umum">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Ya</option>
                                                                        <option value="2">Tidak</option>
                                                                    </select>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="transportasi_pekerjaan_waktu"></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="transportasi_pekerjaan_biaya"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="transportasi_pekerjaan_kemudahan">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Mudah</option>
                                                                        <option value="2">Sulit</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>2</p>
                                                                </td>
                                                                <td>
                                                                    <p>Lahan pertanian</p>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="transportasi_pertanian_jenis">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Darat</option>
                                                                        <option value="2">Air</option>
                                                                        <option value="3">Udara</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="transportasi_pertanian_umum">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Ya</option>
                                                                        <option value="2">Tidak</option>
                                                                    </select>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="transportasi_pertanian_waktu"></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="transportasi_pertanian_biaya"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="transportasi_pertanian_kemudahan">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Mudah</option>
                                                                        <option value="2">Sulit</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>3</p>
                                                                </td>
                                                                <td>
                                                                    <p>Sekolah</p>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="transportasi_sekolah_jenis">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Darat</option>
                                                                        <option value="2">Air</option>
                                                                        <option value="3">Udara</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="transportasi_sekolah_umum">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Ya</option>
                                                                        <option value="2">Tidak</option>
                                                                    </select>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="transportasi_sekolah_waktu"></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="transportasi_sekolah_biaya"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="transportasi_sekolah_kemudahan">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Mudah</option>
                                                                        <option value="2">Sulit</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>4</p>
                                                                </td>
                                                                <td>
                                                                    <p>Berobat</p>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="transportasi_berobat_jenis">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Darat</option>
                                                                        <option value="2">Air</option>
                                                                        <option value="3">Udara</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="transportasi_berobat_umum">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Ya</option>
                                                                        <option value="2">Tidak</option>
                                                                    </select>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="transportasi_berobat_waktu"></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="transportasi_berobat_biaya"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="transportasi_berobat_kemudahan">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Mudah</option>
                                                                        <option value="2">Sulit</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>5</p>
                                                                </td>
                                                                <td>
                                                                    <p>Beribadah</p>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="transportasi_ibadah_jenis">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Darat</option>
                                                                        <option value="2">Air</option>
                                                                        <option value="3">Udara</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="transportasi_ibadah_umum">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Ya</option>
                                                                        <option value="2">Tidak</option>
                                                                    </select>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="transportasi_ibadah_waktu"></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="transportasi_ibadah_biaya"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="transportasi_ibadah_kemudahan">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Mudah</option>
                                                                        <option value="2">Sulit</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>6</p>
                                                                </td>
                                                                <td>
                                                                    <p>Rekreasi</p>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="transportasi_rekreasi_jenis">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Darat</option>
                                                                        <option value="2">Air</option>
                                                                        <option value="3">Udara</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="transportasi_rekreasi_umum">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Ya</option>
                                                                        <option value="2">Tidak</option>
                                                                    </select>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="transportasi_rekreasi_waktu"></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="transportasi_rekreasi_biaya"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="transportasi_rekreasi_kemudahan">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Mudah</option>
                                                                        <option value="2">Sulit</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- P423 -->
                                        <div class="col-md-6">
                                            <div class="card-style mb-30">
                                                <h6 class="mb-10">P423 - Akses Tenaga Kesehatan terdekat</h6>
                                                <div class="table-wrapper table-responsive">
                                                    <table class="table striped-table">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <h6>Fasilitas</h6>
                                                                </th>
                                                                <th>
                                                                    <h6>Jarak (km)</h6>
                                                                </th>
                                                                <th>
                                                                    <h6>Waktu Tempuh (jam)</h6>
                                                                </th>
                                                                <th>
                                                                    <h6>Kemudahan</h6>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <p>Dokter spesialis</p>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="tenaga_spesialis_jarak"></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="tenaga_spesialis_waktu"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="tenaga_spesialis_kemudahan">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Mudah</option>
                                                                        <option value="2">Sulit</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>Dokter umum</p>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="tenaga_umum_jarak"></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="tenaga_umum_waktu"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="tenaga_umum_kemudahan">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Mudah</option>
                                                                        <option value="2">Sulit</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>Bidan</p>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="tenaga_bidan_jarak"></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="tenaga_bidan_waktu"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="tenaga_bidan_kemudahan">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Mudah</option>
                                                                        <option value="2">Sulit</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>Tenaga kesehatan lain</p>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="tenaga_kesehatanlain_jarak"></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="tenaga_kesehatanlain_waktu"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="tenaga_kesehatanlain_kemudahan">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Mudah</option>
                                                                        <option value="2">Sulit</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>Dukun</p>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="tenaga_dukun_jarak"></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="tenaga_dukun_waktu"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="tenaga_dukun_kemudahan">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Mudah</option>
                                                                        <option value="2">Sulit</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- P425 -->
                                    <div class="row mb-3">
                                        <div class="ccard-style mb-30">
                                            <h6 class="mb-10">P425 - Pemanfaat / Penerima Program Pemerintah</h6>
                                            <div class="table-wrapper table-responsive">
                                                <table class="table striped-table">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:70%;">Program</th>
                                                            <th style="width:30%;">Pilihan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1. BLT Dana Desa</td>
                                                            <td>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="p425_blt" value="1">
                                                                    <label class="form-check-label">Ya</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="p425_blt" value="2">
                                                                    <label class="form-check-label">Tidak</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>2. Program Keluarga Harapan (PKH)</td>
                                                            <td>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="p425_pkh" value="1">
                                                                    <label class="form-check-label">Ya</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="p425_pkh" value="2">
                                                                    <label class="form-check-label">Tidak</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>3. Bantuan Sosial Tunai (BST)</td>
                                                            <td>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="p425_bst" value="1">
                                                                    <label class="form-check-label">Ya</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="p425_bst" value="2">
                                                                    <label class="form-check-label">Tidak</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>4. Bantuan Presiden (Banpres)</td>
                                                            <td>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="p425_banpres" value="1">
                                                                    <label class="form-check-label">Ya</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="p425_banpres" value="2">
                                                                    <label class="form-check-label">Tidak</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>5. Bantuan UMKM</td>
                                                            <td>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="p425_umkm" value="1">
                                                                    <label class="form-check-label">Ya</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="p425_umkm" value="2">
                                                                    <label class="form-check-label">Tidak</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>6. Bantuan untuk pekerja</td>
                                                            <td>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="p425_pekerja" value="1">
                                                                    <label class="form-check-label">Ya</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="p425_pekerja" value="2">
                                                                    <label class="form-check-label">Tidak</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>7. Bantuan pendidikan anak</td>
                                                            <td>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="p425_pendidikan" value="1">
                                                                    <label class="form-check-label">Ya</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="p425_pendidikan" value="2">
                                                                    <label class="form-check-label">Tidak</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>8. Lainnya</td>
                                                            <td>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="p425_lainnya" value="1">
                                                                    <label class="form-check-label">Ya</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="p425_lainnya" value="2">
                                                                    <label class="form-check-label">Tidak</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- akses  -->
                                </div>
                            </div>
                            <!-- lanjutkan untuk P404 - P414 dengan select/option sesuai daftar pilihan -->








                            <!-- form create -->





                            <!-- <div id="modalContent">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Memuat form...</p>
                    </div>
                </div> -->
                        </div>

                        <div class="tab-pane fade" id="individu" role="tabpanel" aria-labelledby="individu-tab">
                            <!-- individu -->
                            <div class="col-md-12">
                                <div class="card-style mb-10" style="min-height: 300px">
                                    <!-- P101 - P116 DATA PRIBADI -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="text" class="form-control mb-3" id="p101" name="p101"
                                                placeholder="P101. Nomor Kartu Keluarga">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control mb-3" id="p102" name="p102"
                                                placeholder="P102. NIK">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control mb-3" id="p103" name="p103"
                                                placeholder="P103. Nama">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <select class="form-control mb-3" id="p104" name="p104">
                                                <option value="">P104. Jenis Kelamin</option>
                                                <option value="1">Laki-laki</option>
                                                <option value="2">Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control mb-3" id="p105" name="p105"
                                                placeholder="P105. Tempat Lahir">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="date" class="form-control mb-3" id="p106" name="p106"
                                                placeholder="P106. Tanggal Lahir">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <select class="form-control mb-3" id="p107" name="p107">
                                                <option value="">P107. Status Pernikahan</option>
                                                <option value="1">Kawin</option>
                                                <option value="2">Tidak Kawin</option>
                                                <option value="3">Duda/Janda</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control mb-3" id="p108" name="p108">
                                                <option value="">P108. Agama</option>
                                                <option value="1">Islam</option>
                                                <option value="2">Kristen</option>
                                                <option value="3">Katolik</option>
                                                <option value="4">Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control mb-3" id="p109" name="p109"
                                                placeholder="P109. Suku Bangsa">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <select class="form-control mb-3" id="p110" name="p110">
                                                <option value="">P110. Warganegara</option>
                                                <option value="1">WNI</option>
                                                <option value="2">WNA</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control mb-3" id="p111" name="p111"
                                                placeholder="P111. Nomor HP">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control mb-3" id="p112" name="p112"
                                                placeholder="P112. Nomor Whatsapp">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="email" class="form-control mb-3" id="p113" name="p113"
                                                placeholder="P113. Email Pribadi">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control mb-3" id="p114" name="p114"
                                                placeholder="P114. Facebook Pribadi">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control mb-3" id="p115" name="p115"
                                                placeholder="P115. Twitter Pribadi">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control mb-3" id="p116" name="p116"
                                                placeholder="P116. Instagram Pribadi">
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <!-- individu -->
                        </div>

                        <div class="tab-pane fade" id="pekerjaan" role="tabpanel" aria-labelledby="pekerjaan-tab">
                            <div class="col-md-12">
                                <div class="card-style mb-10" style="min-height: 200px">
                                    <!-- P201 - P203 PEKERJAAN -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control mb-3" id="p201" name="p201">
                                                <option value="">P201. Kondisi Pekerjaan</option>
                                                <option value="1">Bersekolah</option>
                                                <option value="2">Ibu rumah tangga</option>
                                                <option value="3">Tidak bekerja</option>
                                                <option value="4">Sedang mencari pekerjaan</option>
                                                <option value="5">Bekerja</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control mb-3" id="p202" name="p202">
                                                <option value="">P202. Pekerjaan Utama</option>
                                                <option value="1">Petani pemilik lahan</option>
                                                <option value="2">Petani penyewa</option>
                                                <option value="3">Buruh tani</option>
                                                <option value="4">Nelayan pemilik kapal/perahu</option>
                                                <option value="5">Nelayan penyewa kapal/perahu</option>
                                                <option value="6">Buruh nelayan</option>
                                                <option value="7">Guru</option>
                                                <option value="8">Guru agama</option>
                                                <option value="9">Pedagang</option>
                                                <option value="10">Pengolahan/industri</option>
                                                <option value="11">PNS</option>
                                                <option value="12">TNI</option>
                                                <option value="13">Perangkat desa</option>
                                                <option value="14">Pegawai kantor desa</option>
                                                <option value="15">TKI</option>
                                                <option value="16">Lainnya</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control mb-3" id="p203" name="p203">
                                                <option value="">P203. Jaminan Sosial Ketenagakerjaan</option>
                                                <option value="1">Peserta</option>
                                                <option value="2">Bukan Peserta</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control mb-3" id="p204" name="p204"
                                                placeholder="Penghasilan setahun terakhir dari (Rp):">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <!-- P424 -->
                                        <div class="col-md-12">
                                            <div class="card-style mb-30">
                                                <h6 class="mb-10">P424 - Sumber Penghasilan Utama</h6>
                                                <div class="table-wrapper table-responsive">
                                                    <table class="table striped-table">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <h6>No</h6>
                                                                </th>
                                                                <th>
                                                                    <h6>Sumber Penghasilan</h6>
                                                                </th>
                                                                <th>
                                                                    <h6>Volume</h6>
                                                                </th>
                                                                <th>
                                                                    <h6>Penghasilan Setahun (Rp)</h6>
                                                                </th>
                                                                <th>
                                                                    <h6>Diekspor</h6>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th></th>
                                                                <th></th>
                                                                <th>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <h6>Jumlah</h6>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <h6>Satuan</h6>
                                                                        </div>
                                                                    </div>
                                                                </th>
                                                                <th></th>
                                                                <th>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <p>1</p>
                                                                </td>
                                                                <td>
                                                                    <p>Padi</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <input type="number" class="form-control"
                                                                                name="padi_jumlah">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <input type="text" class="form-control"
                                                                                value="ton" readonly>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="padi_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control" name="padi_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>2</p>
                                                                </td>
                                                                <td>
                                                                    <p>Palawija (jagung, kacang, ubi, dll)</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <input type="number" class="form-control"
                                                                                name="palawija_jumlah">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <input type="text" class="form-control"
                                                                                value="ton" readonly>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="palawija_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="palawija_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>

                                                            <!-- >>> lanjutkan baris sesuai daftar 3 sampai 44 <<< -->
                                                            <!-- Lanjutan baris 3 - 44 -->
                                                            <tr>
                                                                <td>
                                                                    <p>3</p>
                                                                </td>
                                                                <td>
                                                                    <p>Hortikultura (buah, sayur, tanaman hias, obat,
                                                                        dll)</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="hortikultura_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="kg"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="hortikultura_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="hortikultura_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>4</p>
                                                                </td>
                                                                <td>
                                                                    <p>Karet</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="karet_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="ton"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="karet_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control" name="karet_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>5</p>
                                                                </td>
                                                                <td>
                                                                    <p>Kelapa sawit</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="sawit_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="ton"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="sawit_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control" name="sawit_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>6</p>
                                                                </td>
                                                                <td>
                                                                    <p>Kopi</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control" name="kopi_jumlah">
                                                                        </div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="kg"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="kopi_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control" name="kopi_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>7</p>
                                                                </td>
                                                                <td>
                                                                    <p>Kakao</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="kakao_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="ton"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="kakao_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control" name="kakao_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>8</p>
                                                                </td>
                                                                <td>
                                                                    <p>Kelapa</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="kelapa_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="ton"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="kelapa_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control" name="kelapa_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>9</p>
                                                                </td>
                                                                <td>
                                                                    <p>Lada</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control" name="lada_jumlah">
                                                                        </div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="kg"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="lada_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control" name="lada_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>10</p>
                                                                </td>
                                                                <td>
                                                                    <p>Cengkeh</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="cengkeh_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="kg"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="cengkeh_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="cengkeh_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>



                                                            <!-- >>> sisanya 11 sampai 44 masih panjang sekali <<< -->

                                                            <tr>
                                                                <td>
                                                                    <p>11</p>
                                                                </td>
                                                                <td>
                                                                    <p>Tembakau</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="tembakau_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="kg"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="tembakau_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="tembakau_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>12</p>
                                                                </td>
                                                                <td>
                                                                    <p>Tebu</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control" name="tebu_jumlah">
                                                                        </div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="ton"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="tebu_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control" name="tebu_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>13</p>
                                                                </td>
                                                                <td>
                                                                    <p>Sapi potong</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="sapipotong_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="ekor"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="sapipotong_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="sapipotong_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>14</p>
                                                                </td>
                                                                <td>
                                                                    <p>Susu sapi</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="sus sapi_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="liter"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="susu_sapi_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="susu_sapi_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>15</p>
                                                                </td>
                                                                <td>
                                                                    <p>Domba</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="domba_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="ekor"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="domba_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control" name="domba_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>16</p>
                                                                </td>
                                                                <td>
                                                                    <p>Ternak besar lainnya (kuda, kerbau, dll)</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="ternakbesar_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="ekor"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="ternakbesar_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="ternakbesar_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>17</p>
                                                                </td>
                                                                <td>
                                                                    <p>Ayam pedaging</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control" name="ayam_jumlah">
                                                                        </div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="ekor"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="ayam_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control" name="ayam_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>18</p>
                                                                </td>
                                                                <td>
                                                                    <p>Telur ayam</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="telur_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="kg"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="telur_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control" name="telur_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>19</p>
                                                                </td>
                                                                <td>
                                                                    <p>Ternak kecil lainnya (bebek, burung, dll)</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="ternakkecil_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="ekor"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="ternakkecil_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="ternakkecil_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>20</p>
                                                                </td>
                                                                <td>
                                                                    <p>Perikanan tangkap (termasuk biota lainnya)</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="ikan_tangkap_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="kg"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="ikan_tangkap_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="ikan_tangkap_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>21</p>
                                                                </td>
                                                                <td>
                                                                    <p>Perikanan budidaya (tambak, kolam, dll)</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="ikan_budidaya_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="kg"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="ikan_budidaya_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="ikan_budidaya_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>22</p>
                                                                </td>
                                                                <td>
                                                                    <p>Udang</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="udang_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="kg"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="udang_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control" name="udang_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>23</p>
                                                                </td>
                                                                <td>
                                                                    <p>Rumput laut</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="rumputlaut_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="kg"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="rumputlaut_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="rumputlaut_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>24</p>
                                                                </td>
                                                                <td>
                                                                    <p>Madu</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control" name="madu_jumlah">
                                                                        </div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="liter"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="madu_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control" name="madu_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>25</p>
                                                                </td>
                                                                <td>
                                                                    <p>Kayu (hasil hutan rakyat/HTI)</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control" name="kayu_jumlah">
                                                                        </div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="m³"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="kayu_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control" name="kayu_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>26</p>
                                                                </td>
                                                                <td>
                                                                    <p>Rotan</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="rotan_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="kg"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="rotan_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control" name="rotan_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>27</p>
                                                                </td>
                                                                <td>
                                                                    <p>Getah/hasil hutan non kayu</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="getah_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="kg"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="getah_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control" name="getah_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>28</p>
                                                                </td>
                                                                <td>
                                                                    <p>Tanaman obat-obatan</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control" name="obat_jumlah">
                                                                        </div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="kg"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="obat_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control" name="obat_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>29</p>
                                                                </td>
                                                                <td>
                                                                    <p>Tanaman hias</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control" name="hias_jumlah">
                                                                        </div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="pot"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="hias_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control" name="hias_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>30</p>
                                                                </td>
                                                                <td>
                                                                    <p>Lainnya (sebutkan)</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="lainnya_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="-" readonly>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="lainnya_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="lainnya_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>31</p>
                                                                </td>
                                                                <td>
                                                                    <p>Perdagangan</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="perdagangan_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="bulan"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="perdagangan_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="perdagangan_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>32</p>
                                                                </td>
                                                                <td>
                                                                    <p>Warung dan rumah makan</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="warung_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="bulan"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="warung_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control" name="warung_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>33</p>
                                                                </td>
                                                                <td>
                                                                    <p>Angkutan</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="angkutan_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="bulan"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="angkutan_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="angkutan_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>34</p>
                                                                </td>
                                                                <td>
                                                                    <p>Pergudangan</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="pergudangan_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="bulan"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="pergudangan_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="pergudangan_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>35</p>
                                                                </td>
                                                                <td>
                                                                    <p>Komunikasi</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="komunikasi_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="bulan"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="komunikasi_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="komunikasi_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>36</p>
                                                                </td>
                                                                <td>
                                                                    <p>Jasa di luar pertanian</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="jasa_luar_pertanian_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="bulan"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="jasa_luar_pertanian_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="jasa_luar_pertanian_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>37</p>
                                                                </td>
                                                                <td>
                                                                    <p>Lainnya</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="lainnya2_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="bulan"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="lainnya2_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="lainnya2_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>38</p>
                                                                </td>
                                                                <td>
                                                                    <p>Karyawan tetap</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="karyawan_tetap_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="bulan"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="karyawan_tetap_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="karyawan_tetap_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>39</p>
                                                                </td>
                                                                <td>
                                                                    <p>Karyawan tidak tetap</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="karyawan_tidak_tetap_jumlah">
                                                                        </div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="bulan"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="karyawan_tidak_tetap_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="karyawan_tidak_tetap_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>40</p>
                                                                </td>
                                                                <td>
                                                                    <p>TNI</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control" name="tni_jumlah">
                                                                        </div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="bulan"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="tni_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control" name="tni_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>41</p>
                                                                </td>
                                                                <td>
                                                                    <p>PNS</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control" name="pns_jumlah">
                                                                        </div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="bulan"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="pns_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control" name="pns_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>42</p>
                                                                </td>
                                                                <td>
                                                                    <p>TKI di luar negeri</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control" name="tki_jumlah">
                                                                        </div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="bulan"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="tki_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control" name="tki_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>43</p>
                                                                </td>
                                                                <td>
                                                                    <p>Sumbangan (dari keluarga, pemerintah, dll)</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="sumbangan_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="bulan"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="sumbangan_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="sumbangan_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <p>44</p>
                                                                </td>
                                                                <td>
                                                                    <p>Lainnya</p>
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-md-6"><input type="number"
                                                                                class="form-control"
                                                                                name="lainnya3_jumlah"></div>
                                                                        <div class="col-md-6"><input type="text"
                                                                                class="form-control" value="bulan"
                                                                                readonly></div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="lainnya3_penghasilan"></td>
                                                                <td>
                                                                    <select class="form-control"
                                                                        name="lainnya3_diekspor">
                                                                        <option value="">-- pilih --</option>
                                                                        <option value="1">Semua</option>
                                                                        <option value="2">Sebagian besar</option>
                                                                        <option value="3">Tidak</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="tab-pane fade" id="kesehatan" role="tabpanel" aria-labelledby="kesehatan-tab">

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="card-style mb-30">
                                        <h6 class="mb-10">P401 - Penyakit yang diderita setahun terakhir</h6>
                                        <div class="table-wrapper table-responsive">
                                            <table class="table striped-table">
                                                <thead>
                                                    <tr>
                                                        <th style="width:70%;">Penyakit</th>
                                                        <th style="width:30%;">Pilihan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1. Muntaber / diare</td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_muntaber" value="1">
                                                                <label class="form-check-label">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_muntaber" value="2">
                                                                <label class="form-check-label">Tidak</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>2. Demam berdarah</td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_dbd" value="1">
                                                                <label class="form-check-label">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_dbd" value="2">
                                                                <label class="form-check-label">Tidak</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>3. Campak</td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_campak" value="1">
                                                                <label class="form-check-label">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_campak" value="2">
                                                                <label class="form-check-label">Tidak</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>4. Malaria</td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_malaria" value="1">
                                                                <label class="form-check-label">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_malaria" value="2">
                                                                <label class="form-check-label">Tidak</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>5. Flu burung / SARS</td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_sars" value="1">
                                                                <label class="form-check-label">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_sars" value="2">
                                                                <label class="form-check-label">Tidak</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>6. Covid-19</td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_covid" value="1">
                                                                <label class="form-check-label">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_covid" value="2">
                                                                <label class="form-check-label">Tidak</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>7. Hepatitis B</td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_hepb" value="1">
                                                                <label class="form-check-label">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_hepb" value="2">
                                                                <label class="form-check-label">Tidak</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>8. Hepatitis E</td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_hepe" value="1">
                                                                <label class="form-check-label">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_hepe" value="2">
                                                                <label class="form-check-label">Tidak</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>9. Difteri</td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_difteri" value="1">
                                                                <label class="form-check-label">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_difteri" value="2">
                                                                <label class="form-check-label">Tidak</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>10. Chikungunya</td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_chikungunya" value="1">
                                                                <label class="form-check-label">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_chikungunya" value="2">
                                                                <label class="form-check-label">Tidak</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>11. Leptospirosis</td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_lepto" value="1">
                                                                <label class="form-check-label">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_lepto" value="2">
                                                                <label class="form-check-label">Tidak</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>12. Kolera</td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_kolera" value="1">
                                                                <label class="form-check-label">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_kolera" value="2">
                                                                <label class="form-check-label">Tidak</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>13. Gizi buruk (marasmus/kwasiorkor)</td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_gizi" value="1">
                                                                <label class="form-check-label">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_gizi" value="2">
                                                                <label class="form-check-label">Tidak</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>14. Jantung</td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_jantung" value="1">
                                                                <label class="form-check-label">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_jantung" value="2">
                                                                <label class="form-check-label">Tidak</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>15. TBC paru-paru</td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_tbc" value="1">
                                                                <label class="form-check-label">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_tbc" value="2">
                                                                <label class="form-check-label">Tidak</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>16. Kanker</td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_kanker" value="1">
                                                                <label class="form-check-label">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_kanker" value="2">
                                                                <label class="form-check-label">Tidak</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>17. Diabetes / kencing manis</td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_diabetes" value="1">
                                                                <label class="form-check-label">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_diabetes" value="2">
                                                                <label class="form-check-label">Tidak</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>18. Lumpuh</td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_lumpuh" value="1">
                                                                <label class="form-check-label">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_lumpuh" value="2">
                                                                <label class="form-check-label">Tidak</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>19. Lainnya</td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_lainnya" value="1">
                                                                <label class="form-check-label">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="p401_lainnya" value="2">
                                                                <label class="form-check-label">Tidak</label>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- lanjutkan sampai 19 penyakit -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card-style mb-30">
                                        <h6 class="mb-10">P402 - Kunjungan Fasilitas Kesehatan (setahun terakhir)</h6>
                                        <div class="table-wrapper table-responsive">
                                            <table class="table striped-table">
                                                <thead>
                                                    <tr>
                                                        <th style="width:70%;">Fasilitas</th>
                                                        <th style="width:30%;">Jumlah Kunjungan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1. Rumah sakit</td>
                                                        <td><input type="number" class="form-control" name="p402_rs">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>2. Rumah sakit bersalin</td>
                                                        <td><input type="number" class="form-control" name="p402_rsb">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>3. Puskesmas dengan rawat inap</td>
                                                        <td><input type="number" class="form-control"
                                                                name="p402_puskesmas_inap"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>4. Puskesmas tanpa rawat inap</td>
                                                        <td><input type="number" class="form-control"
                                                                name="p402_puskesmas_noninap"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>5. Puskesmas pembantu</td>
                                                        <td><input type="number" class="form-control" name="p402_pustu">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>6. Poliklinik / balai pengobatan</td>
                                                        <td><input type="number" class="form-control"
                                                                name="p402_poliklinik"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>7. Tempat praktik dokter</td>
                                                        <td><input type="number" class="form-control"
                                                                name="p402_praktik_dokter"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>8. Rumah bersalin</td>
                                                        <td><input type="number" class="form-control"
                                                                name="p402_rumah_bersalin"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>9. Tempat praktik bidan</td>
                                                        <td><input type="number" class="form-control"
                                                                name="p402_praktik_bidan"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>10. Poskesdes</td>
                                                        <td><input type="number" class="form-control"
                                                                name="p402_poskesdes"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>11. Polindes</td>
                                                        <td><input type="number" class="form-control"
                                                                name="p402_polindes"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>12. Apotik</td>
                                                        <td><input type="number" class="form-control"
                                                                name="p402_apotik"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>13. Toko khusus obat / jamu</td>
                                                        <td><input type="number" class="form-control"
                                                                name="p402_toko_obat"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>14. Posyandu</td>
                                                        <td><input type="number" class="form-control"
                                                                name="p402_posyandu"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>15. Posbindu</td>
                                                        <td><input type="number" class="form-control"
                                                                name="p402_posbindu"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>16. Tempat praktik dukun bayi / bersalin / paraji</td>
                                                        <td><input type="number" class="form-control" name="p402_dukun">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="card-style mb-30">
                                    <h6 class="mb-10">P403 - Jaminan Sosial Kesehatan & Disabilitas</h6>
                                    <div class="table-wrapper table-responsive">
                                        <table class="table striped-table">
                                            <thead>
                                                <tr>
                                                    <th style="width:70%;">Kategori</th>
                                                    <th style="width:30%;">Pilihan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Jaminan Sosial Kesehatan -->
                                                <tr>
                                                    <td>Jaminan sosial kesehatan</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="p403_jamsoskes" value="1">
                                                            <label class="form-check-label">Peserta</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="p403_jamsoskes" value="2">
                                                            <label class="form-check-label">Bukan Peserta</label>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Disabilitas -->
                                                <tr>
                                                    <td>1. Tunanetra (buta)</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="p403_tunanetra" value="1">
                                                            <label class="form-check-label">Ya</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="p403_tunanetra" value="2">
                                                            <label class="form-check-label">Tidak</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2. Tunarungu (tuli)</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="p403_tunarungu" value="1">
                                                            <label class="form-check-label">Ya</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="p403_tunarungu" value="2">
                                                            <label class="form-check-label">Tidak</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3. Tunawicara (bisu)</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="p403_tunawicara" value="1">
                                                            <label class="form-check-label">Ya</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="p403_tunawicara" value="2">
                                                            <label class="form-check-label">Tidak</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4. Tunarungu–wicara (tuli–bisu)</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="p403_tuli_bisu" value="1">
                                                            <label class="form-check-label">Ya</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="p403_tuli_bisu" value="2">
                                                            <label class="form-check-label">Tidak</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>5. Tunadaksa (cacat tubuh)</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="p403_tunadaksa" value="1">
                                                            <label class="form-check-label">Ya</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="p403_tunadaksa" value="2">
                                                            <label class="form-check-label">Tidak</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>6. Tunagrahita (cacat mental, keterbelakangan mental)</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="p403_tunagrahita" value="1">
                                                            <label class="form-check-label">Ya</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="p403_tunagrahita" value="2">
                                                            <label class="form-check-label">Tidak</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>7. Tunalaras (eks–sakit jiwa, gangguan emosi & sosial)</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="p403_tunalaras" value="1">
                                                            <label class="form-check-label">Ya</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="p403_tunalaras" value="2">
                                                            <label class="form-check-label">Tidak</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>8. Cacat eks–sakit kusta (sudah sembuh dokter)</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="p403_kusta" value="1">
                                                            <label class="form-check-label">Ya</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="p403_kusta" value="2">
                                                            <label class="form-check-label">Tidak</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>9. Cacat ganda (fisik & mental)</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="p403_cacat_ganda" value="1">
                                                            <label class="form-check-label">Ya</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="p403_cacat_ganda" value="2">
                                                            <label class="form-check-label">Tidak</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>10. Dipasung</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="p403_dipasung" value="1">
                                                            <label class="form-check-label">Ya</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="p403_dipasung" value="2">
                                                            <label class="form-check-label">Tidak</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>




                        </div>


                        <div class="tab-pane fade" id="pendidikan" role="tabpanel" aria-labelledby="pendidikan-tab">
                            <div class="row mb-3">
                                <div class="card-style mb-30">
                                    <h6 class="mb-10">P501 - Pendidikan Tertinggi yang Ditamatkan</h6>
                                    <div class="table-wrapper table-responsive">
                                        <table class="table striped-table">
                                            <thead>
                                                <tr>
                                                    <th style="width:70%;">Tingkat Pendidikan</th>
                                                    <th style="width:30%;">Pilihan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1. Tidak sekolah</td>
                                                    <td><input type="radio" name="p501_pendidikan" value="1"></td>
                                                </tr>
                                                <tr>
                                                    <td>2. SD dan sederajat</td>
                                                    <td><input type="radio" name="p501_pendidikan" value="2"></td>
                                                </tr>
                                                <tr>
                                                    <td>3. SMP dan sederajat</td>
                                                    <td><input type="radio" name="p501_pendidikan" value="3"></td>
                                                </tr>
                                                <tr>
                                                    <td>4. SMA dan sederajat</td>
                                                    <td><input type="radio" name="p501_pendidikan" value="4"></td>
                                                </tr>
                                                <tr>
                                                    <td>5. Diploma 1-3</td>
                                                    <td><input type="radio" name="p501_pendidikan" value="5"></td>
                                                </tr>
                                                <tr>
                                                    <td>6. S1 dan sederajat</td>
                                                    <td><input type="radio" name="p501_pendidikan" value="6"></td>
                                                </tr>
                                                <tr>
                                                    <td>7. S2 dan sederajat</td>
                                                    <td><input type="radio" name="p501_pendidikan" value="7"></td>
                                                </tr>
                                                <tr>
                                                    <td>8. S3 dan sederajat</td>
                                                    <td><input type="radio" name="p501_pendidikan" value="8"></td>
                                                </tr>
                                                <tr>
                                                    <td>9. Pesantren, seminari, wihara dan sejenisnya</td>
                                                    <td><input type="radio" name="p501_pendidikan" value="9"></td>
                                                </tr>
                                                <tr>
                                                    <td>10. Lainnya</td>
                                                    <td><input type="radio" name="p501_pendidikan" value="10"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="card-style mb-30">
                                    <h6 class="mb-10">P502 - Bahasa digunakan di rumah dan permukiman</h6>
                                    <input type="text" class="form-control" name="p502_bahasa_rumah"
                                        placeholder="Tuliskan bahasa...">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="card-style mb-30">
                                    <h6 class="mb-10">P503 - Bahasa digunakan di lembaga formal (sekolah, tempat kerja)
                                    </h6>
                                    <input type="text" class="form-control" name="p503_bahasa_formal"
                                        placeholder="Tuliskan bahasa...">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="card-style mb-30">
                                    <h6 class="mb-10">P504 - Kerja bakti setahun terakhir</h6>
                                    <input type="number" class="form-control" name="p504_kerjabakti"
                                        placeholder="Jumlah kegiatan">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="card-style mb-30">
                                    <h6 class="mb-10">P505 - Siskamling setahun terakhir</h6>
                                    <input type="number" class="form-control" name="p505_siskamling"
                                        placeholder="Jumlah kegiatan">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="card-style mb-30">
                                    <h6 class="mb-10">P506 - Pesta rakyat/adat setahun terakhir</h6>
                                    <input type="number" class="form-control" name="p506_pesta"
                                        placeholder="Jumlah kegiatan">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="card-style mb-30">
                                    <h6 class="mb-10">P507 - Menolong warga yang mengalami kematian keluarga</h6>
                                    <input type="number" class="form-control" name="p507_kematian"
                                        placeholder="Jumlah kegiatan">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="card-style mb-30">
                                    <h6 class="mb-10">P508 - Menolong warga yang sedang sakit</h6>
                                    <input type="number" class="form-control" name="p508_sakit"
                                        placeholder="Jumlah kegiatan">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="card-style mb-30">
                                    <h6 class="mb-10">P509 - Menolong warga yang kecelakaan</h6>
                                    <input type="number" class="form-control" name="p509_kecelakaan"
                                        placeholder="Jumlah kegiatan">
                                </div>
                            </div>

                        </div>

                        <button type="submit" id="saveSDGS" class="btn btn-primary mt-3">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Edit -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Data Kuesioner</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form edit akan dimuat via AJAX -->
                            <div id="editModalContent">
                                <div class="text-center py-4">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-2">Memuat form
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</section>
<?= $this->endSection(); ?>



<?= $this->section('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$('#enumeratorSelect').on('select2:open', function() {
    // Fokus paksa ke input search ketika dropdown terbuka
    let searchField = document.querySelector('.select2-search__field');
    if (searchField) {
        searchField.focus();
    }
});



$(document).ready(function() {

    $('#enumeratorSelect').select2({
        theme: 'bootstrap-5', // cocok dengan Bootstrap 5 (PlainAdmin)
        placeholder: 'Pilih Enumerator',
        dropdownParent: $('#kuesionerModal'), // penting kalau dipakai dalam modal
        allowClear: true,
        ajax: {
            url: "<?= base_url('enumerator/options') ?>", // endpoint CI4
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term
                }; // kirim keyword pencarian
            },
            processResults: function(data) {
                return {
                    results: data
                };
            }
        }
    });



    // Simpan data (sementara alert, nanti diisi AJAX insert)
    $("#saveSDGS").click(function(e) {
        e.preventDefault(); // Pastikan untuk mencegah reload halaman

        let formData = $("#sdgsForm").serialize();
        console.log("Data yang dikirim:", formData);

        $.ajax({
            url: "/survey/simpan", // route CI4
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    $("#kuesionerModal").modal("hide");
                    $("#sdgsForm")[0].reset(); // Pastikan ini adalah id form yang benar
                    // loadEnumerators(1, ""); // reload data
                    alert(response.message);
                } else {
                    // Menampilkan error validasi atau server
                    let errorMessage = "Gagal: " + response.message;

                    // Jika ada error detail
                    if (response.errors) {
                        errorMessage += "\n\nDetail Error:";
                        for (let key in response.errors) {
                            errorMessage += "\n- " + response.errors[key];
                        }
                    }

                    alert(errorMessage);
                }
            },
            error: function(xhr, status, error) {
                console.error("XHR Response:", xhr.responseText);
                console.error("Status:", status);
                console.error("Error:", error);

                let errorMessage = "Terjadi kesalahan AJAX!\n";

                try {
                    // Coba parsing response JSON jika ada
                    const response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        errorMessage += "Pesan: " + response.message;
                    }
                } catch (e) {
                    // Jika bukan JSON, tampilkan response text biasa
                    errorMessage += "Response: " + xhr.responseText;
                }

                alert(errorMessage);
            }
        });
    });


    // Inisialisasi DataTables
    $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '<?= site_url('kuesioner/getData') ?>',
            type: 'POST'
        },
        columns: [{
                data: 'nomor_kk'
            },
            {
                data: 'enumerator_nama'
            },
            {
                data: null,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-sm btn-primary btn-edit" data-id="${row.id}">Edit</button>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="${row.id}">Hapus</button>
                    `;
                }
            }
        ]
    });

    // Load form tambah ke modal
    $('#kuesionerModal').on('show.bs.modal', function() {
        $('#modalContent').html(`
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
            </div>
            <p class="mt-2">Memuat form...</p>
        </div>
    `);
    });


    // Load form edit ke modal
    $(document).on('click', '.btn-edit', function() {
        const id = $(this).data('id');
        $('#editModal').modal('show');

        $('#editModalContent').html(`
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mt-2">Memuat form...</p>
            </div>
        `);

        $.get('<?= site_url('kuesioner/edit/') ?>' + id, function(data) {
            $('#editModalContent').html(data);
        }).fail(function() {
            $('#editModalContent').html(`
                <div class="alert alert-danger">
                    Gagal memuat form edit. Silakan coba lagi.
                </div>
            `);
        });
    });

    // Handle delete
    $(document).on('click', '.btn-delete', function() {
        const id = $(this).data('id');
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            window.location.href = '<?= site_url('kuesioner/delete/') ?>' + id;
        }
    });

    // Handle submit form dalam modal
    $(document).on('submit', '#kuesionerForm', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const url = $(this).attr('action');
        const isEdit = $('#editModal').hasClass('show');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    // Tutup modal dan refresh table
                    if (isEdit) {
                        $('#editModal').modal('hide');
                    } else {
                        $('#kuesionerModal').modal('hide');
                    }

                    // Tampilkan pesan sukses
                    alert(response.message);

                    // Refresh DataTables
                    $('#dataTable').DataTable().ajax.reload();
                } else {
                    // Tampilkan error
                    alert(response.message || 'Terjadi kesalahan');
                }
            },
            error: function(xhr) {
                alert('Terjadi kesalahan: ' + xhr.responseText);
            }
        });
    });
});
</script>

<?= $this->endSection() ?>