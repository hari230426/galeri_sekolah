<?php
include 'koneksi.php'; // Include database connection
session_start();
if (!isset($_SESSION['login'])) header("Location: login.php");

// Update Kategori
if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $judul = mysqli_real_escape_string($conn, $_POST['judul']);
  mysqli_query($conn, "UPDATE kategori SET judul='$judul' WHERE id=$id");
  header("Location: tambah_kategori.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Manajemen Kategori Galeri</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-4">
    <h3 class="mb-4">Edit Kategori Galeri</h3>

    <!-- Form Edit -->
    <?php if (isset($_GET['edit'])):
      $id = $_GET['edit'];
      $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM kategori WHERE id=$id"));
    ?>
      <form method="POST" class="row g-3">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">
        <div class="col-md-6">
          <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($data['judul']) ?>" required>
        </div>
        <div class="col-md-6">
          <button type="submit" name="update" class="btn btn-warning">Update</button>
          <a href="kategori.php" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    <?php endif; ?>

    <!-- Tabel Kategori -->
    <table class="table table-bordered table-striped mt-4">
      <thead class="table-primary">
        <tr>
          <th>No</th>
          <th>Judul</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $query = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id DESC");
        while ($row = mysqli_fetch_assoc($query)):
        ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= htmlspecialchars($row['judul']) ?></td>
          <td>
            <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
