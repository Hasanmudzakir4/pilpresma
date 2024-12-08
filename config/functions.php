<?php

function getAdminUsername()
{
    global $conn;

    // Pastikan sesi dimulai
    if (!isset($_SESSION)) {
        session_start();
    }

    // Ambil username dari sesi
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

    // Jika sesi username tidak ditemukan, return default
    if (!$username) {
        return "Admin";
    }

    // Query untuk mendapatkan username dari tabel users
    $query = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return ucfirst($row['username']);
    }

    // Return default jika user tidak ditemukan
    return "Admin";
}

function registerAdmin($data)
{
    global $conn;

    $username = mysqli_real_escape_string($conn, $data["usernameAdmin"]);
    $password = mysqli_real_escape_string($conn, $data["passwordAdmin"]);
    $confirmPassword = mysqli_real_escape_string($conn, $data["confirmPasswordAdmin"]);
    $role = mysqli_real_escape_string($conn, $data["role"]);

    // Cek apakah email sudah terdaftar
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        $message = 'Username sudah terdaftar';
        echo "<body onload='error(\"$message\")'></body>";
        return false;
    }

    // Cek konfirmasi password
    if ($password !== $confirmPassword) {
        $message = 'Password tidak sama';
        echo "<body onload='error(\"$message\")'></body>";
        return false;
    }

    // Encrypt password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data ke tabel users
    $query = "INSERT INTO users 
                VALUES ('','$username', '$password', '$role', NOW())";

    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);
    } else {
        echo mysqli_error($conn);
        return false;
    }
}

function registerMahasiswa($data)
{
    global $conn;

    $namaLengkap = mysqli_real_escape_string($conn, $data["namaLengkapUser"]);
    $username = mysqli_real_escape_string($conn, $data["usernameUser"]);
    $nim = mysqli_real_escape_string($conn, $data["nim"]);
    $semester = mysqli_real_escape_string($conn, $data["semester"]);
    $kelas = mysqli_real_escape_string($conn, $data["kelas"]);
    $password = mysqli_real_escape_string($conn, $data["passwordUser"]);
    $confirmPassword = mysqli_real_escape_string($conn, $data["confirmPasswordUser"]);
    $role = mysqli_real_escape_string($conn, $data["role"]);

    // Cek apakah username sudah terdaftar di tabel users
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        $message = 'Username sudah terdaftar';
        echo "<body onload='error(\"$message\")'></body>";
        return false;
    }

    // Cek apakah NIM sudah terdaftar di tabel mahasiswa
    $result = mysqli_query($conn, "SELECT nim FROM mahasiswa WHERE nim = '$nim'");
    if (mysqli_fetch_assoc($result)) {
        $message = 'NIM sudah terdaftar';
        echo "<body onload='error(\"$message\")'></body>";
        return false;
    }

    // Cek konfirmasi password
    if ($password !== $confirmPassword) {
        $message = 'Password tidak sama';
        echo "<script>error(\"$message\")</script>";
        return false;
    }

    // Encrypt password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Insert data ke tabel users
    $queryUser = "INSERT INTO users VALUES ('', '$username', '$passwordHash', '$role', NOW())";
    if (!mysqli_query($conn, $queryUser)) {
        $message = 'Gagal menambahkan users ke table users';
        echo "<body onload='error(\"$message\")'></body>";
        return false;
    }

    // Insert data ke tabel mahasiswa
    $queryMahasiswa = "INSERT INTO mahasiswa
                       VALUES ('', '$username', '$namaLengkap', '$nim', '$semester', '$kelas', NOW())";
    if (mysqli_query($conn, $queryMahasiswa)) {
        return mysqli_affected_rows($conn);
    } else {
        $message = 'Gagal menambahkan users ke table mahasiswa';
        echo "<body onload='error(\"$message\")'></body>";
        return false;
    }
}


function login($username, $password)
{
    global $conn;

    // Cek apakah username ada di database
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        // Periksa apakah pengguna sudah memilih
        $checkVoteQuery = "SELECT * FROM pemilihan WHERE username = '$username'";
        $checkVoteResult = mysqli_query($conn, $checkVoteQuery);

        if (mysqli_num_rows($checkVoteResult) > 0) {
            // Jika sudah memilih, arahkan ke halaman login lagi
            $message = 'Anda sudah memilih!';
            echo "<body onload='error()'><input type='hidden' id='msg' value='" . $message . "''></input></body>";
            return false;
        }

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Set session untuk login
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            return true;
        } else {
            $message = 'Password salah!';
            echo "<body onload='error()'><input type='hidden' id='msg' value='" . $message . "''></input></body>";
        }
    }

    $message = 'User tidak ditemukan!';
    echo "<body onload='error()'><input type='hidden' id='msg' value='" . $message . "''></input></body>";
}



function uploadFoto()
{
    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $tmpName = $_FILES['foto']['tmp_name'];

    // Cek apakah tidak ada file yang diupload
    if ($namaFile == "") {
        echo "<script>
                 alert('File foto belum diupload!');
            </script>";
        return false;
    }

    // Ekstensi file yang diperbolehkan
    $ekstensiValid = ['jpg', 'jpeg', 'png'];
    $ekstensiFile = explode('.', $namaFile);
    $ekstensiFile = strtolower(end($ekstensiFile));

    if (!in_array($ekstensiFile, $ekstensiValid)) {
        echo "<script>
                alert('Ekstensi file tidak valid (hanya jpg, jpeg, png)!');
            </script>";
        return false;
    }

    // Cek ukuran file (contoh: maksimum 2MB)
    if ($ukuranFile > 5000000) {
        echo "<script>
                alert('Ukuran file terlalu besar (maks. 5MB)!!');
            </script>";
        return false;
    }


    // Tentukan folder tujuan
    $folderTujuan = __DIR__ . '/../admin/src/img/';

    // Generate nama file baru
    $namaFileBaru = $namaFile; // Awalnya gunakan nama asli file
    $counter = 1;

    while (file_exists($folderTujuan . $namaFileBaru)) {
        // Jika file sudah ada, tambahkan angka di akhir nama file sebelum ekstensi
        $namaFileBaru = pathinfo($namaFile, PATHINFO_FILENAME) . "_$counter." . $ekstensiFile;
        $counter++;
    }



    // Pindahkan file ke folder tujuan
    move_uploaded_file($tmpName, $folderTujuan . $namaFileBaru);

    return $namaFileBaru;
}


function tambahKandidat($data)
{
    global $conn;

    // Ambil data dari form
    $namaKandidat = mysqli_real_escape_string($conn, $data["namaKandidat"]);
    $visi = mysqli_real_escape_string($conn, $data["visi"]);
    $misi = mysqli_real_escape_string($conn, $data["misi"]);

    // Upload file foto
    $foto = uploadFoto();
    if (!$foto) {
        return false;
    }

    // Query untuk memasukkan data kandidat ke tabel
    $query = "INSERT INTO paslon 
                VALUES 
              ('', '$namaKandidat', '$visi', '$misi', '$foto', NOW())";

    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);
    } else {
        echo "Error: " . mysqli_error($conn);
        return false;
    }
}

function getKandidat()
{
    global $conn;

    $query = "SELECT * FROM paslon";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error: " . mysqli_error($conn));
    }

    $kandidat = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $kandidat[] = $row;
    }

    return $kandidat;
}

function getMahasiswa($semester = null)
{
    global $conn;

    $query = "SELECT * FROM mahasiswa";
    if ($semester !== null) {
        $query .= " WHERE semester = '$semester'";
    }

    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error: " . mysqli_error($conn));
    }

    $mahasiswa = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $mahasiswa[] = $row;
    }

    // Menghitung total mahasiswa
    $totalMahasiswa = count($mahasiswa);

    return ['data' => $mahasiswa, 'total' => $totalMahasiswa];
}
