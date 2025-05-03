<?php
include 'koneksi.php';

$id = $_GET['id'];
$post_id = isset($_GET['post_id']) ? $_GET['post_id'] : 0;

// Ambil data file & galery_id
$data = mysqli_fetch_assoc(mysqli_query($conn, "
  SELECT file, galery_id 
  FROM foto 
  WHERE id = $id
"));

$file_path = 'uploads/' . $data['file'];

// Hapus file dari server
if (file_exists($file_path)) {
  unlink($file_path);
}

// Simpan galery_id sebelum foto dihapus
$galery_id = $data['galery_id'];

// Hapus foto dari database
mysqli_query($conn, "DELETE FROM foto WHERE id = $id");

// Cek apakah galery masih punya foto
$cek_foto = mysqli_query($conn, "SELECT * FROM foto WHERE galery_id = $galery_id");
if (mysqli_num_rows($cek_foto) == 0) {
  // Hapus galery
  mysqli_query($conn, "DELETE FROM galery WHERE id = $galery_id");

  // Hapus juga post jika tidak dipakai galery lain
  mysqli_query($conn, "DELETE FROM posts WHERE id = $post_id");
}

header("Location: post.php?id=$post_id");
?>
