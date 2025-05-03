<?php
include 'koneksi.php';
$newPassword = password_hash('admin123', PASSWORD_DEFAULT);
mysqli_query($conn, "UPDATE petugas SET password = '$newPassword' WHERE username = 'admin'");
echo "Password admin berhasil dihash ulang.";
