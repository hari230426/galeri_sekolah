<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "webgalery"; // Ganti sesuai nama database kamu

$conn = mysqli_connect($host, $user, $password, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
