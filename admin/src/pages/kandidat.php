<?php
session_start();

// Periksa apakah user sudah login dan role-nya adalah admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../../index.php");
    exit;
}

require "../../../config/functions.php";


if (isset($_POST["addKandidat"])) {
    if (tambahKandidat($_POST) > 0) {
        $message = 'Berhasil menambahkan kandidat!';
        $location = '../pages/dashboard.php';
        echo "<body onload='success(\"$message\", \"$location\")'></body>";
    } else {
        $message = 'Gagal menambahkan kandidat!';
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" />
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css" />
    <!-- iCheck -->
    <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
    <!-- JQVMap -->
    <link rel="stylesheet" href="../../plugins/jqvmap/jqvmap.min.css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css" />
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css" />
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css" />
    <!-- summernote -->
    <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.min.css" />
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="../../../src/img/ppu.png" alt="AdminLTELogo" height="150" width="150" />
        </div>
        <?php
        require "./header.php";
        require "./aside.php";

        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Kandidat</h1>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="./dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active">Kandidat</li>
                                </ol>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <div class="container-fluid">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Tambah kandidat</h3>
                        </div>
                        <!-- form start -->
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="namaKandidat">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="namaKandidat" name="namaKandidat" placeholder="Nama Lengkap" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label for="visi">Visi</label>
                                    <!-- <input type="text" class="form-control" id="visi" name="visi" placeholder="Visi" autocomplete="off"> -->
                                    <textarea class="form-control" rows="2" placeholder="Enter visi..." id="visi" name="visi" autocomplete="off" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="misi">Misi</label>
                                    <!-- <input type="text" class="form-control" id="misi" name="misi" placeholder="Misi" autocomplete="off"> -->
                                    <textarea class="form-control" rows="3" placeholder="Enter misi..." id="misi" name="misi" autocomplete="off" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="foto">Foto</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="foto" id="foto" onchange="previewImage()" required>
                                            <label class="custom-file-label" for="foto">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                    </div>
                                    <!-- Preview Image -->
                                    <div class="mt-3">
                                        <img id="preview" src="#" alt="Preview Gambar" class="img-fluid" style="display: none; max-width: 200px;" />
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" name="addKandidat">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
        <?php
        require "./footer.php";
        ?>

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

    <!-- JavaScript for Image Preview -->
    <script>
        function previewImage() {
            const file = document.querySelector('#foto').files[0];
            const preview = document.querySelector('#preview');
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }

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
                window.location.href = "./kandidat.php"
            });
        }
    </script>
</body>

</html>