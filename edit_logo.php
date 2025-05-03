<?php
session_start();
include 'koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM logo WHERE id = $id");
$data = mysqli_fetch_assoc($query);

if (isset($_POST['submit'])) {
  $nama_sekolah = $_POST['nama_sekolah'];
  $tagline = $_POST['tagline'];

  if ($_FILES['logo']['name']) {
    $gambar = $_FILES['logo']['name'];
    $tmp = $_FILES['logo']['tmp_name'];
    move_uploaded_file($tmp, "images/$gambar");

    mysqli_query($conn, "UPDATE logo SET nama_logo='$gambar', nama_sekolah='$nama_sekolah', tagline='$tagline' WHERE id=$id");
  } else {
    mysqli_query($conn, "UPDATE logo SET nama_sekolah='$nama_sekolah', tagline='$tagline' WHERE id=$id");
  }

  header("Location: logo.php");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Logo</title>
</head>
<body>
  <h2>Edit Logo Sekolah</h2>
  <form method="post" enctype="multipart/form-data">
    <label>Nama Sekolah</label><br>
    <input type="text" name="nama_sekolah" value="<?= $data['nama_sekolah'] ?>" required><br><br>

    <label>Tagline</label><br>
    <input type="text" name="tagline" value="<?= $data['tagline'] ?>" required><br><br>

    <label>Ganti Logo (kosongkan jika tidak diganti)</label><br>
    <input type="file" name="logo"><br><br>

    <button type="submit" name="submit">Update</button>
  </form>
</body>
</html>
