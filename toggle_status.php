<?php
include 'koneksi.php';

$id = $_GET['id'] ?? 0;

$result = mysqli_query($conn, "SELECT status FROM galery WHERE id = '$id'");
$data = mysqli_fetch_assoc($result);

$newStatus = $data['status'] == 1 ? 0 : 1;

mysqli_query($conn, "UPDATE galery SET status = '$newStatus' WHERE id = '$id'");
header("Location: post.php"); // sesuaikan dengan nama file aslinya
exit;
