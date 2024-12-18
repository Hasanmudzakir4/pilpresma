<?php
session_start();

// Periksa apakah user sudah login dan role-nya adalah admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../../index.php");
    exit;
}

require "../../../config/functions.php";

$jumlahDataPerHalaman = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $jumlahDataPerHalaman;

$mahasiswaList = getMahasiswa(1, $offset, $jumlahDataPerHalaman);
$jumlahData = $mahasiswaList['total'];
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

if (isset($_POST['search'])) {
    $keyword = $_POST['input'];
    $mahasiswaList['data'] = search($keyword, 1);
    $jumlahData = count($mahasiswaList['data']);
    $jumlahHalaman = 1;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin PPU</title>

    <link rel="shortcut icon" type="image/png" href="../../../src/img/ppu.png" />
    <!-- Google Font: Source Sans Pro -->
    <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
    <!-- Ionicons -->
    <link
        rel="stylesheet"
        href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <!-- Tempusdominus Bootstrap 4 -->
    <link
        rel="stylesheet"
        href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css" />
    <!-- iCheck -->
    <link
        rel="stylesheet"
        href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
    <!-- JQVMap -->
    <link rel="stylesheet" href="../../plugins/jqvmap/jqvmap.min.css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css" />
    <!-- overlayScrollbars -->
    <link
        rel="stylesheet"
        href="../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css" />
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css" />
    <!-- summernote -->
    <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.min.css" />
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div
            class="preloader flex-column justify-content-center align-items-center">
            <img
                class="animation__shake"
                src="../../../src/img/ppu.png"
                alt="AdminLTELogo"
                height="150"
                width="150" />
        </div>
        <?php
        require "../components/header.php";
        require "../components/aside.php";

        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Data Mahasiswa</h1>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="../dashboard/dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active">Semester 1</li>
                                </ol>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Semester 1</h3>
                                    <div class="card-tools">
                                        <form action="" method="POST">
                                            <div class="input-group input-group-sm" style="width: 150px;">
                                                <input type="text" name="input" class="form-control float-right" placeholder="Search" autocomplete="off">

                                                <div class="input-group-append">
                                                    <button type="submit" name="search" class="btn btn-default">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead class="bg-secondary">
                                            <tr>
                                                <th>No</th>
                                                <th>NIM</th>
                                                <th>Username</th>
                                                <th>Nama Lengkap</th>
                                                <th>Semester</th>
                                                <th>Kelas</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $no = $offset + 1;
                                        foreach ($mahasiswaList['data'] as $mahasiswa):

                                        ?>
                                            <tbody>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $mahasiswa['nim']; ?></td>
                                                    <td><?= $mahasiswa['username']; ?></td>
                                                    <td><?= $mahasiswa['nama_lengkap']; ?></td>
                                                    <td><?= $mahasiswa['semester']; ?></td>
                                                    <td><?= $mahasiswa['kelas']; ?></td>
                                                    <td>
                                                        <a href="#" class="btn btn-outline-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i> Update</a>
                                                        <a href="#" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash-can"></i> Delete</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        <?php
                                            $no++;
                                        endforeach;
                                        ?>
                                    </table>
                                </div>
                                <!-- /.card -->
                                <div class="card-footer clearfix">
                                    <ul class="pagination pagination-sm m-0 float-right">
                                        <!-- Tombol Previous -->
                                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                            <a class="page-link" href="?page=<?= ($page > 1) ? $page - 1 : 1 ?>" aria-label="Previous">
                                                &laquo;
                                            </a>
                                        </li>

                                        <?php
                                        // Menentukan batas halaman yang akan ditampilkan
                                        $start_page = max(1, $page - 2);
                                        $end_page = min($jumlahHalaman, $page + 2);

                                        // Membatasi tampilan pagination pada 5 halaman
                                        for ($i = $start_page; $i <= $end_page; $i++) {
                                            echo '<li class="page-item ' . ($i === $page ? 'active' : '') . '">
                                                <a class="page-link" href="?page=' . $i . '">' . $i . '</a>
                                            </li>';
                                        }
                                        ?>
                                        <!-- Tombol Next -->
                                        <li class="page-item <?= ($page >= $jumlahHalaman) ? 'disabled' : '' ?>">
                                            <a class="page-link" href="?page=<?= ($page < $jumlahHalaman) ? $page + 1 : $jumlahHalaman ?>" aria-label="Next">
                                                &raquo;
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
        </div>
        </section>
    </div>
    <?php
    require "../components/footer.php";
    ?>

    </div>
    <!-- /.modal -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../../plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge("uibutton", $.ui.button);
    </script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="../../plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="../../plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="../../plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="../../plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="../../plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="../../plugins/moment/moment.min.js"></script>
    <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="../../plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.js"></script>
</body>

</html>