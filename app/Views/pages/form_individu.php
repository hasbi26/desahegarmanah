<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
th h6 {
    display: inline-block;
    margin: 0;
    font-size: 14px;
    /* sesuai tema */
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
                            <h2>Form Individu</h2>
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
                            <!-- <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#kuesionerModal">
                                <i class="fas fa-plus"></i> Tambah Data
                            </button> -->

                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#kuesionerModal">
                                Tambah Data <i class="lni lni-circle-plus"></i>
                            </button>

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
    <!-- ========== table components end ========== -->




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
                            <form action="#" method="post">
                                <!-- P1 DESKRIPSI ENUMERATOR -->
                                <div class="card-style mb-10">
                                    <h6 class="mb-25">P1. Deskripsi Enumerator</h6>

                                    <label>Select Enumerator</label>
                                    <div class="select-position">
                                        <select class="form-select">
                                            <option value="">Select Enumerator</option>
                                            <option value="">Sajali</option>
                                            <option value="">Ahmad</option>
                                            <option value="">Asep</option>
                                        </select>
                                    </div>
                                </div>
                        </div>
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


                    </div>



                    <!-- P3 DESKRIPSI KELUARGA -->
                    <div class="card-style mb-10">
                        <h5 class="mt-3">P3. Deskripsi Keluarga</h5>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="p301" class="form-label">Nomor KK</label>
                                <input type="text" class="form-control" id="p301" name="p301">
                            </div>
                            <div class="col-md-4">
                                <label for="p302" class="form-label">NIK Kepala Keluarga</label>
                                <input type="text" class="form-control" id="p302" name="p302">
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
                                aria-selected="false">individu</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <!-- pemukiman -->
                            <!-- P4 PERMUKIMAN -->
                            <h5 class="mt-3">P4. Permukiman</h5>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="p401" class="form-label">Tempat tinggal yang ditempati</label>
                                    <select class="form-select" id="p401" name="p401">
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
                                    <label for="p402" class="form-label">Status lahan tempat tinggal</label>
                                    <select class="form-select" id="p402" name="p402">
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
                                            <input type="number" class="form-control" id="p403_lantai"
                                                name="p403_lantai" placeholder="Luas lantai (m2)">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" id="p403_lahan" name="p403_lahan"
                                                placeholder="Luas lahan (m2)">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <!-- P404 -->
                                <div class="col-md-3">
                                    <label for="p404" class="form-label">Jenis lantai tempat tinggal terluas</label>
                                    <select class="form-select" id="p404" name="p404">
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
                                    <label for="p405" class="form-label">Dinding sebagian besar rumah</label>
                                    <select class="form-select" id="p405" name="p405">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Semen/beton/kayu berkualitas tinggi</option>
                                        <option value="2">Kayu berkualitas rendah/bambu</option>
                                        <option value="3">Lainnya</option>
                                    </select>
                                </div>

                                <!-- P406 -->
                                <div class="col-md-3">
                                    <label for="p406" class="form-label">Jendela</label>
                                    <select class="form-select" id="p406" name="p406">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Ada, berfungsi</option>
                                        <option value="2">Ada, tidak berfungsi</option>
                                        <option value="3">Tidak ada</option>
                                    </select>
                                </div>

                                <!-- P407 -->
                                <div class="col-md-3">
                                    <label for="p407" class="form-label">Atap</label>
                                    <select class="form-select" id="p407" name="p407">
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
                                    <label for="p408" class="form-label">Penerangan rumah</label>
                                    <select class="form-select" id="p408" name="p408">
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
                                    <label for="p409" class="form-label">Energi untuk memasak</label>
                                    <select class="form-select" id="p409" name="p409">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Gas kota / LPG / Biogas</option>
                                        <option value="2">Minyak tanah / Batu bara</option>
                                        <option value="3">Kayu bakar</option>
                                        <option value="4">Lainnya</option>
                                    </select>
                                </div>

                                <!-- P410 -->
                                <div class="col-md-4">
                                    <label for="p410" class="form-label">Jika menggunakan kayu bakar, sumber
                                        kayu</label>
                                    <select class="form-select" id="p410" name="p410">
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
                                    <label for="p411" class="form-label">Tempat pembuangan sampah</label>
                                    <select class="form-select" id="p411" name="p411">
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
                                    <label for="p412" class="form-label">Fasilitas MCK</label>
                                    <select class="form-select" id="p412" name="p412">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Sendiri</option>
                                        <option value="2">Berkelompok/tetangga</option>
                                        <option value="3">MCK umum</option>
                                        <option value="4">Tidak ada</option>
                                    </select>
                                </div>

                                <!-- P413 -->
                                <div class="col-md-3">
                                    <label for="p413" class="form-label">Sumber air mandi terbanyak dari</label>
                                    <select class="form-select" id="p413" name="p413">
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
                                    <label for="p414" class="form-label">Fasilitas buang air besar</label>
                                    <select class="form-select" id="p414" name="p414">
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
                                    <label for="p415" class="form-label">Sumber air minum terbanyak dari</label>
                                    <select class="form-select" id="p415" name="p415">
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
                                    <label for="p416" class="form-label">Tempat pembuangan limbah cair</label>
                                    <select class="form-select" id="p416" name="p416">
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
                                    <label for="p417" class="form-label">Rumah berada di bawah
                                        SUTET/SUTT/SUTTAS</label>
                                    <select class="form-select" id="p417" name="p417">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Ya</option>
                                        <option value="2">Tidak</option>
                                    </select>
                                </div>

                                <!-- P418 -->
                                <div class="col-md-5">
                                    <label for="p418" class="form-label">Rumah di bantaran sungai</label>
                                    <select class="form-select" id="p418" name="p418">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Ya</option>
                                        <option value="2">Tidak</option>
                                    </select>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <!-- P419 -->
                                <div class="col-md-5">
                                    <label for="p419" class="form-label">Rumah di lereng bukit/gunung</label>
                                    <select class="form-select" id="p419" name="p419">
                                        <option value="">-- Pilih --</option>
                                        <option value="1">Ya</option>
                                        <option value="2">Tidak</option>
                                    </select>
                                </div>

                                <!-- P420 -->
                                <div class="col-md-5">
                                    <label for="p420" class="form-label">Secara keseluruhan kondisi rumah</label>
                                    <select class="form-select" id="p420" name="p420">
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
                                                        <!-- daftar fasilitas pendidikan -->
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

                            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                            </form>






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
$(document).ready(function() {
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

        // $.get('<?= site_url('kuesioner/create') ?>', function(response) {
        //     if (response.fields_enumerators) {
        //         let formHtml = `<form id="formKuesioner">`;

        //         response.fields_enumerators.forEach(field => {
        //             // skip kalau field 'id' atau 'created_at'
        //             if (field === 'id' || field === 'created_at') return;

        //             formHtml += `
        //                 <div class="mb-3">
        //                     <label for="${field}" class="form-label text-capitalize">${field.replace('_',' ')}</label>
        //                     <input type="text" class="form-control" id="${field}" name="${field}" placeholder="Masukkan ${field}">
        //                 </div>
        //             `;
        //         });

        //         formHtml += `
        //             <div class="d-flex justify-content-end">
        //                 <button type="submit" class="btn btn-primary">Simpan</button>
        //             </div>
        //         </form>`;

        //         $('#modalContent').html(formHtml);
        //     } else {
        //         $('#modalContent').html(`
        //             <div class="alert alert-warning">
        //                 Tidak ada field ditemukan.
        //             </div>
        //         `);
        //     }
        // }, 'json').fail(function() {
        //     $('#modalContent').html(`
        //         <div class="alert alert-danger">
        //             Gagal memuat form. Silakan refresh halaman dan coba lagi.
        //         </div>
        //     `);
        // });
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