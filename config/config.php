<?php
$host = "34.128.64.118";
$user = "root";
$password = "";
$database = "db_pilpresma";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Koneksi gagal :" . mysqli_connect_error());
}
