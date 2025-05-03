<?php
include 'koneksi.php';
session_start();

// Cek apakah sudah login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// Cek apakah ada parameter ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Hindari menghapus akun sendiri (opsional)
    // if ($_SESSION['id'] == $id) {
    //     header("Location: admin.php?error=tidak_boleh_hapus_diri");
    //     exit;
    // }

    // Hapus admin
    $query = mysqli_query($conn, "DELETE FROM petugas WHERE id = $id");

    // Redirect kembali
    header("Location: admin.php");
    exit;
} else {
    // Jika tidak ada ID, kembali ke admin
    header("Location: admin.php");
    exit;
}
?>
