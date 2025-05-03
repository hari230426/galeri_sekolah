<?php
session_start();
include 'koneksi.php';

if (isset($_POST['submit'])) {
  $nama_sekolah = $_POST['nama_sekolah'];
  $tagline = $_POST['tagline'];

  $gambar = $_FILES['logo']['name'];
  $tmp = $_FILES['logo']['tmp_name'];
  $path = 'images/' . $gambar;

  if (move_uploaded_file($tmp, $path)) {
    mysqli_query($conn, "INSERT INTO logo (nama_logo, nama_sekolah, tagline) VALUES ('$gambar', '$nama_sekolah', '$tagline')");
    header("Location: logo.php");
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Tambah Logo</title>
</head>
<body>
  <h2>Tambah Logo Sekolah</h2>
  <form method="post" enctype="multipart/form-data">
    <label>Nama Sekolah</label><br>
    <input type="text" name="nama_sekolah" required><br><br>

    <label>Tagline</label><br>
    <input type="text" name="tagline" required><br><br>

    <label>Upload Logo</label><br>
    <input type="file" name="logo" required><br><br>

    <button type="submit" name="submit">Simpan</button>
  </form>
</body>
</html>
