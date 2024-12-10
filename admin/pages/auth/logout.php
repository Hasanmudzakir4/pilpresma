<?php
session_start();

// Cek jika user sudah mengklik tombol logout
if (isset($_GET['logout']) && $_GET['logout'] == 'confirm') {
    // Proses logout jika konfirmasi
    session_unset();
    session_destroy();
    header("Location: ../../../index.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="shortcut icon" type="image/png" href="../../../src/img/ppu.png" />
    <!-- Tambahkan SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <script>
        Swal.fire({
            title: 'Apakah Anda yakin ingin logout?',
            text: "Anda akan keluar dari akun ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, logout!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Success!",
                    text: "Anda berhasil logout.",
                    icon: "success"
                }).then(function() {
                    window.location.href = 'logout.php?logout=confirm';
                });
            } else {
                window.location.href = '../dashboard/dashboard.php';
            }
        });
    </script>
</body>

</html>