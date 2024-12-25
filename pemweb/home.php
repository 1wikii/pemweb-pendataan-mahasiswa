<?php
$title = 'Home Page';
require_once('middleware/auth.php');
require_once('views/layoutCSS.php');
require_once('objects/mahasiswa.php');

$mahasiswa = new Mahasiswa();
$dataMahasiswa = $mahasiswa->getMahasiswa();


// handle tambah mahasiswa
if (isset($_POST['add'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];

    $isSave = true;

    if ($nim == '') {
        $isSave = false;
        echo "<script>alert('NIM harus diisi !');</script>";
    } else if ($nama == '') {
        $isSave = false;
        echo "<script>alert('Nama harus diisi !');</script>";
    } elseif (!isset($_POST['jenis_kelamin'])) {
        $isSave = false;
        echo "<script>alert('Jenis Kelamin harus diisi !');</script>";
    }

    // cek apakah akun denga NIM sudah ada
    if ($mahasiswa->isAccountAlreadyExist($nim)) {
        $isSave = false;
        echo "<script>alert('NIM sudah ada, mohon ganti !');</script>";
    }

    if ($isSave) {
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $status = 0;

        if (isset($_POST['status'])) {
            $status = 1;
        }
        // panggil method addMahasiswa dari class Mahasiswa
        $mahasiswa->addMahasiswa($nim, $nama, $jenis_kelamin, $status);

        // hapus untuk menandai tambah selesai
        unset($_POST['add']);
        header('Location: ' . $_SERVER['PHP_SELF']);

    }

}

// handle edit mahasiswa
if (isset($_POST['update'])) {
    $id = $_POST['idEdit'];
    $nim = $_POST['nimEdit'];
    $nama = $_POST['namaEdit'];

    $isSave = true;

    if ($nim == '') {
        $isSave = false;
        echo "<script>alert('NIM harus diisi !');</script>";
    } else if ($nama == '') {
        $isSave = false;
        echo "<script>alert('Nama harus diisi !');</script>";
    } elseif (!isset($_POST['jenis_kelaminEdit'])) {
        $isSave = false;
        echo "<script>alert('Jenis Kelamin harus diisi !');</script>";
    }

    if ($isSave) {
        $jenis_kelamin = $_POST['jenis_kelaminEdit'];
        $status = 0;

        if (isset($_POST['statusEdit'])) {
            $status = 1;
        }


        // panggil method updateMahasiswa dari class Mahasiswa
        $mahasiswa->updateMahasiswa($id, $nim, $nama, $jenis_kelamin, $status);

        // hapus untuk menandai edit selesai
        unset($_POST['update']);
        header('Location: ' . $_SERVER['PHP_SELF']);

    }

}


// handle hapus mahasiswa
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    // panggil method deleteMahasiswa dari class Mahasiswa
    $mahasiswa->deleteMahasiswa($id);

    // hapus untuk menandai hapus selesai
    unset($_POST['delete']);
    header('Location: ' . $_SERVER['PHP_SELF']);
}

?>

<head>
    <link rel="stylesheet" href="css/table.css">
    <!-- Sweet Alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body style="background: linear-gradient(0deg,rgb(244, 245, 245),rgb(163, 215, 237),rgb(100, 194, 238));">
    <?php
    require_once('views/navbar.php');
    ?>

    <div class="container-fluid d-flex justify-content-center align-items-center container-login100">
        <div class="bg-body-tertiary shadow-lg p-3 mb-5 bg-body-tertiary rounded">
            <section class="ftco-section">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-6 text-center mb-2">
                            <h2 class="heading-section font-custom">Data Mahasiswa</h2>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mb-2 font-custom" style="width: 100%;">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal"> Tambah
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-wrap" style="border-radius: 10px;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>NIM</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Status</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php if (isset($dataMahasiswa) && count($dataMahasiswa) == 0): ?>
                                            <tr class="alert" role="alert">
                                                <td class="text-center" colspan="5">Belum ada data mahasiswa</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($dataMahasiswa as $data): ?>

                                                <tr class="alert" role="alert">
                                                    <td class="d-flex align-items-center">
                                                        <div class="pl-3 email">
                                                            <span><?= $data['nim'] ?></span>
                                                            <span>Added: <?= $data['date_added'] ?></span>
                                                        </div>
                                                    </td>

                                                    <td><?= $data['nama'] ?></td>
                                                    <td><?= $data['jenis_kelamin'] ?></td>

                                                    <?php if ($data['status']): ?>
                                                        <td class="status"><span class="active">Aktif</span></td>
                                                    <?php else: ?>
                                                        <td class="status border-bottom-0"><span class="waiting">Nonaktif</span>
                                                        </td>
                                                    <?php endif; ?>

                                                    <td>
                                                        <button class="edit btn btn-warning pt-1 pb-0 px-1"
                                                            data-id="<?= $data['id'] ?>" data-nim="<?= $data['nim'] ?>"
                                                            data-nama="<?= $data['nama'] ?>"
                                                            data-jenis-kelamin="<?= $data['jenis_kelamin'] ?>"
                                                            data-status="<?= $data['status'] ?>" type="button"
                                                            data-bs-toggle="modal" data-bs-target="#editModal">
                                                            <box-icon name="edit" color="white"></box-icon>
                                                        </button>
                                                        <button class="hapus btn btn-danger pt-1 pb-0 px-1"
                                                            data-id="<?= $data['id'] ?>" data-nim="<?= $data['nim'] ?>"
                                                            type="button">
                                                            <box-icon name="trash" color="white"></box-icon>
                                                        </button>

                                                        <form class="d-none" action="<?php $_SERVER['PHP_SELF'] ?>"
                                                            method="POST">
                                                            <input type="hidden" name="id" value="<?= $data['id'] ?>">
                                                            <button class="d-none" type="submit" name="delete"
                                                                id="hapus-<?= $data['id'] ?>"></button>
                                                        </form>

                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>

    </div>



    <!-- modal tambah data mahasiswa -->
    <div class="modal fade" id="tambahModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="tambahModalLabel">Tambah Data Mahasiswa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">

                        <div class="mb-3">
                            <label for="nim" class="form-label">NIM </label>
                            <input name="nim" type="text" class="form-control" id="nim">
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input name="nama" type="text" class="form-control" id="nama">
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" name="jenis_kelamin" id="jenis_kelamin">
                                <option selected disabled></option>
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="form-check form-switch ms-4">
                            <input class="form-check-input" type="checkbox" role="switch" name="status" id="status">
                            <label class="form-check-label ms-1" for="status">Status Mahasiswa</label>
                        </div>

                        <button id="btnFormTambah" class="d-none" type="submit" name="add"></button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button id="triggerTambah" type="button" class="btn btn-primary"
                        data-bs-dismiss="modal">Kirim</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal edit data mahasiswa -->
    <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Data Mahasiswa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                        <input type="hidden" name="idEdit" id="idEdit">
                        <div class="mb-3">
                            <label for="nimEdit" class="form-label">NIM </label>
                            <input name="nimEdit" type="text" class="form-control" id="nimEdit">
                        </div>
                        <div class="mb-3">
                            <label for="namaEdit" class="form-label">Nama</label>
                            <input name="namaEdit" type="text" class="form-control" id="namaEdit">
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelaminEdit" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" name="jenis_kelaminEdit" id="jenis_kelaminEdit">
                                <option selected disabled></option>
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="form-check form-switch ms-4">
                            <input class="form-check-input" type="checkbox" role="switch" name="statusEdit"
                                id="statusEdit">
                            <label class="form-check-label ms-1" for="statusEdit">Status Mahasiswa</label>
                        </div>

                        <button id="btnFormEdit" class="d-none" type="submit" name="update"></button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button id="triggerEdit" type="button" class="btn btn-primary" data-bs-dismiss="modal">Edit</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    require_once('views/layoutJS.php');
    ?>


    <script>
        $(document).ready(function () {

            // handle ketika tombol tambah di klik
            $("#triggerTambah").on('click', function () {
                $("#btnFormTambah").click();
            });

            // handle ketika tombol edit di klik
            // memindah data ke modal edit
            $(".edit").on('click', function () {
                const id = $(this).attr('data-id');
                const nim = $(this).attr('data-nim');
                const nama = $(this).attr('data-nama');
                const jenis_kelamin = $(this).attr('data-jenis-kelamin');
                const status = $(this).attr('data-status');

                $("#idEdit").val(id);
                $("#nimEdit").val(nim);
                $("#namaEdit").val(nama);
                $("#jenis_kelaminEdit").val(jenis_kelamin);

                if (status == 1) {
                    $("#statusEdit").prop('checked', true);
                } else {
                    $("#statusEdit").prop('checked', false);
                }
            });

            // handle ketika tombol edit di klik
            $("#triggerEdit").on('click', function () {
                $("#btnFormEdit").click();
            });

            // handle ketika tombol hapus di klik
            $(".hapus").on('click', function () {
                const id = $(this).attr('data-id');
                const nim = $(this).attr('data-nim');

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-danger",
                        cancelButton: "btn btn-warning"
                    },
                });
                swalWithBootstrapButtons.fire({
                    title: "Yakin menghapus data mahasiswa ?",
                    text: "NIM : " + nim,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Hapus",
                    cancelButtonText: "Batal",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        swalWithBootstrapButtons.fire({
                            title: "Terhapus !",
                            text: "Data berhasil dihapus.",
                            icon: "success"
                        }).then((e) => {
                            if (e.isConfirmed) {
                                $(`#hapus-${id}`).click();
                            }
                        });


                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire({
                            title: "Dibatalkan",
                            text: "Data batal dihapus",
                            icon: "error"
                        });
                    }
                });
            });



            // =========VALIDASI=========
            // Validasi NIM
            $("#nim").on("input blur", function () {
                $(".error-message").remove();
                const nim = $(this).val().trim();
                if (nim === "") {
                    $(this).after('<span class="error-message text-danger">NIM harus diisi</span>');
                }
            });

            // Validasi Nama
            $("#nama").on("input blur", function () {
                $(".error-message").remove();
                const nama = $(this).val().trim();
                if (nama === "") {
                    $(this).after('<span class="error-message text-danger">Nama harus diisi</span>');
                }
            });

            // Validasi Jenis Kelamin
            $("#jenis_kelamin").on("input blur", function () {
                $(".error-message").remove();
                const jenis_kelamin = $(this).val().trim();
                if (jenis_kelamin === "") {
                    $(this).after('<span class="error-message text-danger">Jenis Kelamin harus diisi</span>');
                }
            });


            $("#nimEdit").on("input blur", function () {
                $(".error-message").remove();
                const nimEdit = $(this).val().trim();
                if (nimEdit === "") {
                    $(this).after('<span class="error-message text-danger">NIM harus diisi</span>');
                }
            });

            $("#namaEdit").on("input blur", function () {
                $(".error-message").remove();
                const namaEdit = $(this).val().trim();
                if (namaEdit === "") {
                    $(this).after('<span class="error-message text-danger">Nama harus diisi</span>');
                }
            });

            $("#jenis_kelaminEdit").on("input blur", function () {
                $(".error-message").remove();
                const jenis_kelaminEdit = $(this).val().trim();
                if (jenis_kelaminEdit === "") {
                    $(this).after('<span class="error-message text-danger">Jenis Kelamin harus diisi</span>');
                }
            });

        });
    </script>



</body>