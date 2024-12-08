<?php
session_start();

// Periksa apakah user sudah login dan role-nya adalah admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../../index.php");
    exit;
}

require "../../../config/config.php";
require "../../../config/functions.php";


if (isset($_POST["registerAdmin"])) {
    $registerStatus = registerAdmin($_POST);

    if ($registerStatus > 0) {
        $message = 'Anda berhasil Menambahkan Admin';
        $location = '../pages/dashboard.php';
        echo "<body onload='success(\"$message\", \"$location\")'></body>";
    } else {
        $message = 'Password tidak sama';
        echo "<body onload='error(\"$message\")'></body>";
    }
}

if (isset($_POST["registerUser"])) {
    $registerStatus = registerMahasiswa($_POST);

    if ($registerStatus > 0) {
        $message = 'Anda berhasil Menambahkan User';
        $location = '../pages/dashboard.php';
        echo "<body onload='success(\"$message\", \"$location\")'></body>";
    } else {
        $message = 'Terjadi kesalahan saat menambahkan mahasiswa';
        echo "<body onload='error(\"$message\")'></body>";
    }
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
    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <!-- <div
            class="preloader flex-column justify-content-center align-items-center">
            <img
                class="animation__shake"
                src="../img/ppu.png"
                alt="AdminLTELogo"
                height="150"
                width="150" />
        </div> -->
        <?php
        require "./header.php";
        require "./aside.php";

        ?>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Users</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Users</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>

            <!-- Toggle Button -->
            <section class="content">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pilih Formulir</h3>
                        <div class="card-tools">
                            <button
                                class="btn btn-tool"
                                id="toggleFormBtn"
                                data-target="mahasiswa">
                                <i class="fas fa-exchange-alt"></i> Ganti Form
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Admin Form -->
                <div class="card card-info" id="formAdmin">
                    <div class="card-header">
                        <h3 class="card-title">Form Register Admin</h3>
                    </div>
                    <form action="" method="POST" class="form-horizontal">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="usernameAdmin" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="usernameAdmin" id="usernameAdmin" placeholder="Username">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="passwordAdmin" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="passwordAdmin" id="passwordAdmin" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="confirmPasswordAdmin" class="col-sm-2 col-form-label">Confirm Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="confirmPasswordAdmin" id="confirmPasswordAdmin" placeholder="Confirm Password">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="role" value="admin">
                        <div class="card-footer">
                            <button type="submit" name="registerAdmin" class="btn btn-info">Register</button>
                        </div>
                    </form>
                </div>

                <!-- Admin Form -->
                <div class="card card-warning d-none" id="formMahasiswa">
                    <div class="card-header">
                        <h3 class="card-title">Form Register Mahasiswa</h3>
                    </div>
                    <!-- /.card-header -->
                    <form action="" method="POST" class="form-horizontal">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="namaLengkapUser">Nama Lengkap</label>
                                <input type="text" class="form-control" id="namaLengkapUser" name="namaLengkapUser" placeholder="Nama Lengkap" autocomplete="off">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="usernameUser">Username</label>
                                        <input type="text" name="usernameUser" id="usernameUser" class="form-control" placeholder="Username" autocomplete="off">
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label>Semester</label>
                                        <select class="form-control select2" style="width: 100%;" name="semester">
                                            <option value="1">1</option>
                                            <option value="3">3</option>
                                            <option value="5">5</option>
                                            <option value="7">7</option>
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>

                                <!-- /.col -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nim">NIM</label>
                                        <input type="text" name="nim" id="nim" class="form-control" placeholder="NIM" autocomplete="off">
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label>Kelas</label>
                                        <select class="form-control select2" style="width: 100%;" name="kelas">
                                            <option value="Pusat/ Teknologi">Pusat/ Teknologi</option>
                                            <option value="Laborti">Laborti</option>
                                            <option value="Tasik">Tasik</option>
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="passwordUser">Password</label>
                                        <input type="password" name="passwordUser" id="passwordUser" class="form-control" placeholder="Password" autocomplete="off">
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="confirmPasswordUser">Confirm Password</label>
                                        <input type="password" name="confirmPasswordUser" id="confirmPasswordUser" class="form-control" placeholder="Confirm Password" autocomplete="off">
                                    </div>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <input type="hidden" name="role" value="user">
                        <div class="card-footer">
                            <button type="submit" name="registerUser" class="btn btn-warning">Register</button>
                        </div>
                        <!-- /.row -->
                    </form>
                </div>
        </div>
        </section>
        <?php
        require "./footer.php";
        ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <script>
        // Togle Switch
        document.getElementById('toggleFormBtn').addEventListener('click', function() {
            const targetForm = this.getAttribute('data-target');
            if (targetForm === 'mahasiswa') {
                document.getElementById('formMahasiswa').classList.add('d-none');
                document.getElementById('formAdmin').classList.remove('d-none');
                this.setAttribute('data-target', 'admin');
            } else {
                document.getElementById('formAdmin').classList.add('d-none');
                document.getElementById('formMahasiswa').classList.remove('d-none');
                this.setAttribute('data-target', 'mahasiswa');
            }
        });

        function success(message, location) {
            Swal.fire({
                position: 'top-center',
                icon: 'success',
                title: "Success!",
                text: message,
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = location;
            })
        }

        function error(message) {
            Swal.fire({
                position: 'top-center',
                icon: 'error',
                title: "Error!",
                text: message,
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = "./register.php"
            });
        }
    </script>
    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../../plugins/jquery-ui/jquery-ui.min.js"></script>
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
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge("uibutton", $.ui.button);
    </script>
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