<?php

require './functions.php';



$jumlahDataPerHalaman = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $jumlahDataPerHalaman;
$search = isset($_GET['search']) ? $_GET['search'] : null;

// Ambil data mahasiswa
$mahasiswaStatus = getPemilihan(null, $jumlahDataPerHalaman, $offset, $search);
$belumMemilih = $mahasiswaStatus['sudahMemilih'];
var_dump($belumMemilih);
