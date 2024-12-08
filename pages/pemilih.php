<?php
session_start();

// Periksa apakah user sudah login
if (!isset($_SESSION['username'])) {
  echo "<script>alert('Anda harus login untuk memilih!'); window.location.href = '../index.php';</script>";
  exit;
}

require '../config/config.php';
require '../config/functions.php';

// Ambil semester dari data user
$username = $_SESSION['username'];
$querySemester = "SELECT semester FROM mahasiswa WHERE username = '$username'";
$resultSemester = mysqli_query($conn, $querySemester);
$semester = '';

if ($resultSemester && mysqli_num_rows($resultSemester) > 0) {
  $row = mysqli_fetch_assoc($resultSemester);
  $semester = $row['semester'];
}

if (isset($_POST['vote'])) {
  $id_paslon = $_POST['id_paslon'];

  // Simpan data ke tabel pemilihan
  $queryInsert = "INSERT INTO pemilihan VALUES ('', '$username', '$id_paslon', '$semester', NOW())";
  if (mysqli_query($conn, $queryInsert)) {
    session_unset();
    session_destroy();
    $message = 'Terima kasih telah memilih!';
    $location = '../index.php';
    echo "<body onload='success(\"$message\", \"$location\")'></body>";
  } else {
    $message = 'Terjadi kesalahan saat menyimpan data!';
    echo "<body onload='error()'><input type='hidden' id='msg' value='" . $message . "''></input></body>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pemilihan Ketua Senat STTIS</title>
  <link rel="shortcut icon" type="image/png" href="../src/img/ppu.png" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <link rel="stylesheet" href="../src/css/pemilih.css">

</head>

<body>
  <div class="text-center my-2">
    <img src="../src/img/ppu.png" alt="Logo OSIS" class="logo" />
    <h1 class="text-center mb-2">Pemilihan Ketua Senat</h1>
    <h2 class="text-center mb-5">STTI Sony Sugema</h2>
  </div>

  <div class="container-fluid">
    <div class="row g-4 justify-content-center">
      <?php
      // Mendapatkan list kandidat
      $kandidatList = getKandidat();

      // Menampilkan setiap kandidat
      foreach ($kandidatList as $kandidat): ?>
        <div class="col-12 col-md-6 col-lg-3">
          <div class="card">
            <img src="../admin/src/img/<?= $kandidat['foto']; ?>" alt="<?= $kandidat['nama_paslon']; ?>" class="card-img-top" />
            <div class="card-body">
              <h3 class="card-title text-center"><?= $kandidat['nama_paslon']; ?></h3>
              <p class="card-text">
                <strong>Visi :</strong><q><?= $kandidat['visi']; ?></q><br />
              </p>
              <p>
                <strong>Misi :</strong>
                <?php
                $misiList = explode(" - ", $kandidat['misi']);
                echo "<ul>";
                foreach ($misiList as $misi) {
                  echo "<li>" . $misi . "</li>";
                }
                echo "</ul>";
                ?>
              </p>
            </div>
            <form method="POST" action="" onsubmit="return confirmVote()">
              <input type="hidden" name="id_paslon" value="<?= $kandidat['id_paslon']; ?>" />
              <input type="hidden" name="semester" value="<?= $semester; ?>" />
              <button class="btn vote-btn" type="submit" name="vote" onclick="">Vote</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Footer dengan copyright dan logo -->
  <footer>
    <img src="../src/img/ppu.png" alt="Logo STTI Sony Sugema" class="footer-logo" />
    <p>&copy; <?= date("Y"); ?> Panitia Pemilihan Umum Mahasiswa. All rights reserved.</p>
  </footer>

  <script>
    // Fungsi untuk konfirmasi voting
    function confirmVote() {
      return window.confirm("Apakah Anda yakin untuk memilih paslon ini?");
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
        window.location.href = "../index.php"
      });
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>