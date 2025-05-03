<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit;
}

// Proses Simpan Post + Upload Foto
if (isset($_POST['simpan'])) {
  $judul_post = mysqli_real_escape_string($conn, $_POST['judul_post']);
  $isi = mysqli_real_escape_string($conn, $_POST['isi']);
  $kategori_id = $_POST['kategori_id'];
  $judul_foto = mysqli_real_escape_string($conn, $_POST['judul_foto']);
  $petugas_id = $_SESSION['id'];
  $status = 'publish';

  $file = $_FILES['file']['name'];
  $tmp = $_FILES['file']['tmp_name'];
  $folder = "uploads/";

  if ($file != '') {
    // Simpan Post
    mysqli_query($conn, "INSERT INTO posts (judul, isi, kategori_id, petugas_id, status, created_at) 
                         VALUES ('$judul_post', '$isi', $kategori_id, $petugas_id, '$status', NOW())");
    $post_id = mysqli_insert_id($conn);

    // Simpan Galery
    move_uploaded_file($tmp, $folder . $file);
    mysqli_query($conn, "INSERT INTO galery (post_id, position, status) VALUES ($post_id, 1, 1)");
    $galery_id = mysqli_insert_id($conn);

    // Simpan Foto
    mysqli_query($conn, "INSERT INTO foto (galery_id, file, judul) VALUES ($galery_id, '$file', '$judul_foto')");

    header("Location: post.php");
    exit;
  } else {
    echo "<script>alert('Upload foto wajib.');</script>";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Tambah Post & Foto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
  <h3>Tambah Post Sekaligus Upload Foto</h3>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">Judul Post</label>
      <input type="text" name="judul_post" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Isi Postingan</label>
      <textarea name="isi" class="form-control" rows="4" required></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Kategori</label>
      <select name="kategori_id" class="form-select" required>
        <option value="">Pilih Kategori</option>
        <?php
        $kat = mysqli_query($conn, "SELECT * FROM kategori");
        while ($k = mysqli_fetch_assoc($kat)) {
          echo "<option value='$k[id]'>$k[judul]</option>";
        }
        ?>
      </select>
    </div>
    <hr>
    <div class="mb-3">
      <label class="form-label">Judul Foto</label>
      <input type="text" name="judul_foto" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Upload Foto</label>
      <input type="file" name="file" class="form-control" required>
    </div>
    <button type="submit" name="simpan" class="btn btn-primary">Simpan & Upload</button>
    <a href="post.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>
</body>
</html>
