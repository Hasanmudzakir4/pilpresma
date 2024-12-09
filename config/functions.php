<?php
require_once 'config.php';

// Mengambil nama Admin
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

// Register untuk Admin
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

// Register untuk Mahasiswa
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

// Login
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

// Upload Foto Kandidat
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

// Menambahkan Data Kandidat dan Foto
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

// Ambil data kandidat
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

// Ambil data Mahasiswa
function getMahasiswa($semester = null)
{
    global $conn;

    $query = "SELECT * FROM mahasiswa ";

    if ($semester !== null) {
        $query .= " WHERE semester = '$semester'";
    }

    $query .= " ORDER BY 
                    CASE 
                WHEN kelas = 'Pusat/ Teknologi' THEN 1
                WHEN kelas = 'Laborti' THEN 2
                WHEN kelas = 'Tasik' THEN 3
                ELSE 4
                    END,
                nama_lengkap ASC";

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

// Ambil data yang sudah memilih dan belum memilih
function getStatusPemilihan($semester = null)
{
    global $conn;

    // Query untuk mendapatkan data mahasiswa beserta status pemilihannya
    $query = "SELECT m.nim, m.nama_lengkap, m.kelas, m.semester, 
                     IF(p.username IS NULL, 'Belum Memilih', 'Sudah Memilih') AS status
              FROM mahasiswa m
              LEFT JOIN pemilihan p ON m.username = p.username";

    // Tambahkan kondisi semester jika ada
    if ($semester !== null) {
        $query .= " WHERE m.semester = '$semester'";
    }

    // Tambahkan pengurutan berdasarkan semester dan nama
    $query .= " ORDER BY 
                    CASE 
                WHEN m.kelas = 'Pusat/ Teknologi' THEN 1
                WHEN m.kelas = 'Laborti' THEN 2
                WHEN m.kelas = 'Tasik' THEN 3
                    ELSE 4
                END,
                    FIELD(m.semester, 1, 3, 5, 7), m.nama_lengkap ASC";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Error: " . mysqli_error($conn));
    }

    $sudahMemilih = [];
    $belumMemilih = [];

    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['status'] === 'Sudah Memilih') {
            $sudahMemilih[] = $row;
        } else {
            $belumMemilih[] = $row;
        }
    }

    // Mengembalikan array yang berisi data sudah memilih dan belum memilih
    return [
        'sudahMemilih' => $sudahMemilih,
        'belumMemilih' => $belumMemilih
    ];
}

// Ambil data suara berdasarkan paslon
function getSuaraPaslon()
{
    global $conn;

    $sql = "SELECT p.id_paslon, pas.nama_paslon, COUNT(*) AS jumlah_suara
            FROM pemilihan p
            JOIN paslon pas ON p.id_paslon = pas.id_paslon
            GROUP BY p.id_paslon, pas.nama_paslon";

    $result = $conn->query($sql);

    if (!$result) {
        die("Query Error: " . $conn->error);
    }

    $labels = [];
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $labels[] = $row['nama_paslon'];
        $data[] = $row['jumlah_suara'];
    }

    return ['labels' => $labels, 'data' => $data];
}

// Ambil total suara
function getTotalSuara()
{
    $suaraPaslon = getSuaraPaslon();
    return array_sum($suaraPaslon['data']);
}

// Ambil jumlah paslon
function getTotalPaslon()
{
    global $conn;

    $sql = "SELECT COUNT(*) AS total_paslon FROM paslon";
    $result = $conn->query($sql);

    if (!$result) {
        die("Query Error: " . $conn->error);
    }

    $row = $result->fetch_assoc();
    return $row['total_paslon'];
}

// Ambil total admin
function getTotalAdmin()
{
    global $conn;

    $sql = "SELECT COUNT(*) AS total_admin FROM users WHERE role = 'admin'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Query Error: " . $conn->error);
    }

    $row = $result->fetch_assoc();
    return $row['total_admin'];
}

// Fungsi untuk mendapatkan semester mahasiswa berdasarkan username
function getSemesterMahasiswa($username)
{
    global $conn;
    $query = "SELECT semester FROM mahasiswa WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['semester'];
    }

    return null;
}

// Fungsi untuk menyimpan data pemilihan ke database
function saveVote($username, $id_paslon, $semester)
{
    global $conn;
    $queryInsert = "INSERT INTO pemilihan VALUES ('', '$username', '$id_paslon', '$semester', NOW())";
    return mysqli_query($conn, $queryInsert);
}
