<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Daftar Foto Galeri</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    img.thumb { height: 70px; }
  </style>
</head>
<body>
<div class="container mt-4">
  <h3>Daftar Foto Galeri</h3>
  <a href="tambah_post.php" class="btn btn-success mb-3">+ Tambah Post</a>

  <table class="table table-bordered">
    <thead class="table-primary">
      <tr>
        <th>No</th>
        <th>Judul Foto</th>
        <th>Foto</th>
        <th>Post</th>
        <th>Kategori</th>
        <th>Isi</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      $query = mysqli_query($conn, "
        SELECT f.*, p.judul AS post_judul, p.id AS post_id, p.isi, k.judul AS kategori 
        FROM foto f
        JOIN galery g ON f.galery_id = g.id
        JOIN posts p ON g.post_id = p.id
        JOIN kategori k ON p.kategori_id = k.id
        ORDER BY f.id DESC
      ");
      while ($row = mysqli_fetch_assoc($query)):
      ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($row['judul']) ?></td>
        <td><img src="uploads/<?= $row['file'] ?>" class="thumb"></td>
        <td>
          <?= htmlspecialchars($row['post_judul']) ?><br>
        </td>
        <td><?= htmlspecialchars($row['kategori']) ?></td>
        <td><?= htmlspecialchars($row['isi']) ?></td>
        <td>
          <a href="edit_foto.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
          <a href="hapus_foto.php?id=<?= $row['id'] ?>&post_id=<?= $row['post_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus foto ini?')">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
