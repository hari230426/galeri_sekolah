<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

$id = $_GET['id'];

// Ambil nama file logo sebelum dihapus
$get = mysqli_query($koneksi, "SELECT nama_logo FROM logo WHERE id = $id");
$data = mysqli_fetch_assoc($get);
$gambar = $data['nama_logo'];

// Hapus file gambar dari folder
if (file_exists("../images/$gambar")) {
    unlink("../images/$gambar");
}

// Hapus data dari database
mysqli_query($koneksi, "DELETE FROM logo WHERE id = $id");

header("Location: logo.php");
exit;
