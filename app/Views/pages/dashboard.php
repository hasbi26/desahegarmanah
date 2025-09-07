<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- ========== section start ========== -->
<section class="section">
    <!-- ========== table components start ========== -->
    <section class="table-components">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Form Enumerators</h2>
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
                                        data-bs-target="#addEnumeratorModal">
                                        Tambah Data <i class="lni lni-circle-plus"></i>
                                    </button>
                                </div>

                                <div class="col-md-4 ms-auto">
                                    <input type="text" id="search" class="form-control"
                                        placeholder="Cari nama, alamat atau telepon...">
                                </div>
                            </div>


                            <div class="table-wrapper table-responsive">
                                <table class="table striped-table">
                                    <thead>
                                        <tr>
                                            <th class="lead-info">
                                                <h6>No</h6>
                                            </th>
                                            <th class="lead-info">
                                                <h6>Nama</h6>
                                            </th>
                                            <th class="lead-email">
                                                <h6>Alamat</h6>
                                            </th>
                                            <th class="lead-company">
                                                <h6>hp telepon</h6>
                                            </th>
                                            <th>
                                                <h6>Action</h6>
                                            </th>

                                        </tr>

                                    </thead>
                                    <tbody id="enumeratorData">
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

        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center" id="pagination">
                <!-- Link pagination AJAX -->
            </ul>
        </nav>
    </section>
    <!-- ========== section end ========== -->



    <!-- Modal Input Enumerator -->
    <div class="modal fade" id="addEnumeratorModal" tabindex="-1" aria-labelledby="addEnumeratorLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-3 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEnumeratorLabel">Tambah Enumerator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form id="enumeratorForm">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="hp_telepon" class="form-label">No. HP / Telepon</label>
                            <input type="text" class="form-control" id="hp_telepon" name="hp_telepon">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveEnumerator">Simpan</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Edit Enumerator -->
    <div class="modal fade" id="editEnumeratorModal" tabindex="-1" aria-labelledby="editEnumeratorLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-3 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEnumeratorLabel">Update Enumerator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form id="enumeratorForm">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="hp_telepon" class="form-label">No. HP / Telepon</label>
                            <input type="text" class="form-control" id="hp_telepon" name="hp_telepon">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveEnumeratorUpdate">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <?= $this->endSection() ?>
    <?= $this->section('scripts') ?>
    <script>
    $(document).ready(function() {

        let currentPage = 1;
        let searchQuery = "";

        // Load data pertama kali
        loadEnumerators(currentPage, searchQuery);

        // Search realtime
        $("#search").on("keyup", function() {
            searchQuery = $(this).val();
            loadEnumerators(1, searchQuery);
        });

        // Pagination klik
        $(document).on("click", ".page-link", function(e) {
            e.preventDefault();
            let page = $(this).data("page");
            if (page) {
                currentPage = page;
                loadEnumerators(currentPage, searchQuery);
            }
        });

        // Simpan data (sementara alert, nanti diisi AJAX insert)
        $("#saveEnumerator").click(function() {
            let formData = $("#enumeratorForm").serialize();
            // TODO: AJAX POST ke server
            $.ajax({
                url: "<?= base_url('enumerator/store') ?>", // route CI4
                type: "POST",
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        $("#addEnumeratorModal").modal("hide");
                        $("#enumeratorForm")[0].reset();
                        loadEnumerators(1, ""); // reload data
                        alert(response.message);
                    } else {
                        alert("Gagal: " + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("Terjadi kesalahan AJAX!");
                }
            });


        });
        loadEnumerators(1, "")

    });

    // Fungsi load data
    function loadEnumerators(page, search) {
        $.ajax({
            url: "enumerator/read", // endpoint controller (nanti diganti sesuai route CI4)
            type: "GET",
            data: {
                page: page,
                search: search
            },
            success: function(response) {
                let html = "";
                let data = response.data;
                let pagination = response.pagination;

                if (data.length > 0) {
                    $.each(data, function(index, row) {
                        let no = (pagination.currentPage - 1) * pagination.perPage + (
                            index + 1);
                        html += `
                <tr>
                    <td>${no}</td>
                    <td>${row.nama}</td>
                    <td>${row.alamat ?? '-'}</td>
                    <td>${row.hp_telepon ?? '-'}</td>
                    <td>
                        <div class="action">
                            <button class="text-warning btn-edit" data-id="${row.id}">
                                <i class="lni lni-pencil-alt"></i>
                            </button>
                            <button class="text-danger btn-delete" data-id="${row.id}">
                                <i class="lni lni-trash-can"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
                    });
                } else {
                    html =
                        `<tr><td colspan="6" class="text-center">Data tidak ditemukan</td></tr>`;
                }

                $("#enumeratorData").html(html);

                // Render pagination
                let pagHtml = "";
                let current = pagination.currentPage;
                let totalPages = pagination.totalPages;

                if (current > 1) {
                    pagHtml += `<li class="page-item">
                        <a class="page-link" href="#" data-page="${current-1}">Previous</a>
                    </li>`;
                }

                for (let i = 1; i <= totalPages; i++) {
                    pagHtml += `<li class="page-item ${i == current ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>`;
                }

                if (current < totalPages) {
                    pagHtml += `<li class="page-item">
                        <a class="page-link" href="#" data-page="${current+1}">Next</a>
                    </li>`;
                }

                $("#pagination").html(pagHtml);
            }

        });
    }


    // Klik tombol edit
    $(document).on("click", ".btn-edit", function() {
        let id = $(this).data("id");

        $.ajax({
            url: "enumerator/" + id,
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    let data = response.data;

                    // isi form edit
                    $("#editEnumeratorModal #nama").val(data.nama);
                    $("#editEnumeratorModal #alamat").val(data.alamat);
                    $("#editEnumeratorModal #hp_telepon").val(data.hp_telepon);

                    // simpan id di form (hidden field)
                    $("#editEnumeratorModal").data("id", data.id);

                    // tampilkan modal
                    $("#editEnumeratorModal").modal("show");
                } else {
                    alert(response.message);
                }
            }
        });
    });

    // Simpan hasil edit
    $(document).on("click", "#saveEnumeratorUpdate", function() {
        let id = $("#editEnumeratorModal").data("id");
        let formData = $("#editEnumeratorModal #enumeratorForm").serialize();

        $.ajax({
            url: "enumerator/update/" + id,
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    $("#editEnumeratorModal").modal("hide");
                    loadEnumerators(1, ""); // reload data
                    alert(response.message);
                } else {
                    alert("Gagal: " + response.message);
                }
            }
        });
    });


    // Hapus enumerator
    $(document).on("click", ".btn-delete", function() {
        let id = $(this).data("id");

        if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
            $.ajax({
                url: "enumerator/" + id,
                type: "DELETE",
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        alert(response.message);
                        loadEnumerators(1, ""); // reload data
                    } else {
                        alert("Gagal: " + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("Terjadi kesalahan saat menghapus data!");
                }
            });
        }
    });
    </script>
    <?= $this->endSection() ?>



    <!-- jQuery + AJAX -->
    <script defer>

    </script>