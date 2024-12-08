<?php
session_start();

require "./config/config.php";
require "./config/functions.php";


if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Panggil fungsi login
    $loginStatus = login($username, $password);

    if ($loginStatus === 'incorrect_password') {
        $message = 'Password salah!';
        echo "<body onload='error()'><input type='hidden' id='msg' value='" . $message . "''></input></body>";
    } elseif ($loginStatus === 'user_not_found') {
        $message = 'Username salah!';
        echo "<body onload='error()'><input type='hidden' id='msg' value='" . $message . "''></input></body>";
    } elseif ($loginStatus === true) {
        // Jika login berhasil, akan diarahkan sesuai role
        if ($_SESSION['role'] == 'admin') {
            $message = 'Anda berhasil login';
            $location = './admin/src/pages/dashboard.php';
            echo "<body onload='success(\"$message\", \"$location\")'></body>";
        } else {
            $message = 'Anda berhasil login!';
            $location = "./pages/pemilih.php";
            echo "<body onload='success(\"$message\", \"$location\")'></body>";
        }
    } else {
        $message = 'Gagal!';
        echo "<body onload='error()'><input type='hidden' id='msg' value='" . $message . "''></input></body>";
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Mahasiswa</title>
    <link rel="shortcut icon" type="image/png" href="./src/img/ppu.png" />
    <!-- Link ke Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link ke Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Link ke Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="./src/css/style.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-8 col-10">
                <div class="card my-5">
                    <form action="" method="POST" class="card-body cardbody-color p-lg-5">
                        <div class="text-center">
                            <img src="./src/img/ppu.png" class="img-fluid profile-image-pic" width="100px" alt="profile">
                            <h3 class="mt-3 mb-3 fw-bold">Login</h3>
                        </div>

                        <div class="mb-3">
                            <input type="text" class="form-control" name="username" id="Username" placeholder="Username">
                        </div>
                        <div class="mb-3 position-relative">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                            <span toggle="#password" class="fa fa-eye toggle-password position-absolute top-50 end-0 translate-middle-y me-3"></span>
                        </div>
                        <div class="text-center">
                            <button type="submit" name="login" class="btn btn-color px-5 w-100">Login</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Script Bootstrap 5 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('.toggle-password').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;
            this.classList.toggle('fa-eye-slash');
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

        function error() {
            Swal.fire({
                position: 'top-center',
                icon: 'error',
                title: "Error!",
                text: document.getElementById("msg").value,
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = './index.php';
            })
        }
    </script>
</body>

</html>