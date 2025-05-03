<?php
include 'koneksi.php';

$id = $_GET['id']; // foto ID

// Ambil data lengkap dari foto dan post
$data = mysqli_fetch_assoc(mysqli_query($conn, "
  SELECT f.id as foto_id, f.judul as judul_foto, f.file, 
         p.id as post_id, p.judul as judul_post, p.isi, p.kategori_id,
         g.id as galery_id
  FROM foto f
  JOIN galery g ON f.galery_id = g.id
  JOIN posts p ON g.post_id = p.id
  WHERE f.id = $id
"));

if (isset($_POST['update'])) {
  // Data dari form
  $foto_id     = $_POST['foto_id'];
  $judul_foto  = mysqli_real_escape_string($conn, $_POST['judul_foto']);
  $judul_post  = mysqli_real_escape_string($conn, $_POST['judul_post']);
  $isi         = mysqli_real_escape_string($conn, $_POST['isi']);
  $kategori_id = $_POST['kategori_id'];
  $post_id     = $_POST['post_id'];

  // Upload file jika ada
  $file = $_FILES['file']['name'];
  $tmp  = $_FILES['file']['tmp_name'];
  $folder = "uploads/";

  if ($file != '') {
    move_uploaded_file($tmp, $folder . $file);
    mysqli_query($conn, "UPDATE foto SET judul='$judul_foto', file='$file' WHERE id = $foto_id");
  } else {
    mysqli_query($conn, "UPDATE foto SET judul='$judul_foto' WHERE id = $foto_id");
  }

  // Update data post juga
  mysqli_query($conn, "
    UPDATE posts 
    SET judul = '$judul_post', isi = '$isi', kategori_id = $kategori_id
    WHERE id = $post_id
  ");

  // Redirect kembali ke halaman post terkait
  header("Location: post.php?id=$post_id");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Foto & Post</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    img.thumb { height: 80px; }
  </style>
</head>
<body>
<div class="container mt-4">
  <h3>Edit Foto & Postingan</h3>
  <form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="foto_id" value="<?= $data['foto_id'] ?>">
    <input type="hidden" name="post_id" value="<?= $data['post_id'] ?>">

    <!-- FOTO -->
    <div class="mb-3">
      <label>Judul Foto</label>
      <input type="text" name="judul_foto" class="form-control" value="<?= htmlspecialchars($data['judul_foto']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Ganti File Foto (opsional)</label>
      <input type="file" name="file" class="form-control">
      <small>File saat ini: <strong><?= $data['file'] ?></strong></small><br>
      <img src="uploads/<?= $data['file'] ?>" class="thumb mt-2">
    </div>

    <hr>

    <!-- POST -->
    <div class="mb-3">
      <label>Judul Post</label>
      <input type="text" name="judul_post" class="form-control" value="<?= htmlspecialchars($data['judul_post']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Isi Postingan</label>
      <textarea name="isi" class="form-control" rows="4" required><?= htmlspecialchars($data['isi']) ?></textarea>
    </div>
    <div class="mb-3">
      <label>Kategori</label>
      <select name="kategori_id" class="form-select" required>
        <?php
        $kat = mysqli_query($conn, "SELECT * FROM kategori");
        while ($k = mysqli_fetch_assoc($kat)) {
          $selected = ($data['kategori_id'] == $k['id']) ? 'selected' : '';
          echo "<option value='$k[id]' $selected>$k[judul]</option>";
        }
        ?>
      </select>
    </div>

    <button type="submit" name="update" class="btn btn-success">Simpan Semua Perubahan</button>
    <a href="post.php?id=<?= $data['post_id'] ?>" class="btn btn-secondary">Kembali</a>
  </form>
</div>
</body>
</html>
