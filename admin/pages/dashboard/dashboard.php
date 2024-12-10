<?php
session_start();

// Periksa apakah user sudah login dan role-nya adalah admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../../index.php");
    exit;
}

require "../../../config/functions.php";

// Data suara berdasarkan paslon
$suaraPaslon = getSuaraPaslon();
$labels = $suaraPaslon['labels'];
$data = $suaraPaslon['data'];

// Menghitung total suara
$totalSuara = getTotalSuara();

// Jumlah paslon
$totalPaslon = getTotalPaslon();

// Jumlah admin
$totalAdmin = getTotalAdmin();

// Data mahasiswa
$mahasiswaData = getMahasiswa();
$totalMahasiswa = $mahasiswaData['total'];

// Menghitung total mahasiswa yang sudah dan belum memilih
$mahasiswaStatus = getStatusPemilihan(null);
$totalSudahMemilih = count($mahasiswaStatus['sudahMemilih']);
$totalBelumMemilih = count($mahasiswaStatus['belumMemilih']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin PPUM | Dashboard</title>

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
        require "../components/header.php";
        require "../components/aside.php";
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="./dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-gray">
                                <div class="inner">
                                    <h3><?= $totalMahasiswa; ?></h3>
                                    <p>Mahasiswa</p>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-users"></i>
                                </div>
                                <a href="./semester1.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?= $totalAdmin; ?></h3>
                                    <p>Admin</p>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-user-tie"></i>
                                </div>
                                <a href="./admin.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?= $totalPaslon; ?></h3>
                                    <p>Kandidat</p>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-user-graduate"></i>
                                </div>
                                <a href="../kandidat/profileKandidat.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3><?= $totalSudahMemilih; ?></h3>
                                    <p>Sudah Memilih</p>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-user-check"></i>
                                </div>
                                <a href="../bilikSuara/sudahMemilih.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?= $totalBelumMemilih; ?></h3>
                                    <p>Belum Memilih</p>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-user-xmark"></i>
                                </div>
                                <a href="../bilikSuara/belumMemilih.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- /.row -->
                    </div>

                    <!-- PIE CHART -->
                    <div class="row">
                        <!-- PIE CHART -->
                        <div class="col-lg-6"> <!-- Tambahkan ini untuk setengah layar -->
                            <div class="card card-indigo">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="far fa-chart-bar"></i>
                                        Hasil Pemungutan Suara
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                    <div class="mt-3 text-center">
                                        <?php
                                        $output = "";
                                        foreach ($labels as $index => $label) {
                                            $output .= "<span class='mx-3'><strong>$label</strong> : " . $data[$index] . " suara</span>";
                                        }
                                        echo $output;
                                        ?>
                                        <p class="mt-3"><strong>Total Suara:</strong> <?= $totalSuara; ?></p>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>

                    <!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </section>
        </div>
        <?php
        require "../components/footer.php";
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
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="../../plugins/chart.js/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.js"></script>

    <script>
        $(function() {
            var pieData = {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: ['#ff0000', '#0000ff', '#ffff00', '#00ff00'],
                }]
            };

            var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
            var pieOptions = {
                maintainAspectRatio: false,
                responsive: true,
            };

            new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            });
        });
    </script>
</body>

</html>