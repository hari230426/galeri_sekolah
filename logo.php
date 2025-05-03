<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
$query = mysqli_query($conn, "SELECT * FROM logo");
$logo = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manajemen Logo</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="p-6">
  <h1 class="text-2xl font-bold mb-4">Manajemen Logo Sekolah</h1>

  <?php if ($logo): ?>
    <div class="flex items-center space-x-4 mb-4">
      <img src="images/<?= $logo['nama_logo'] ?>" class="h-20" alt="Logo Sekolah">
      <div>
        <p class="font-semibold text-lg"><?= $logo['nama_sekolah'] ?></p>
        <p class="text-sm text-gray-500"><?= $logo['tagline'] ?></p>
      </div>
    </div>
    <a href="edit_logo.php?id=<?= $logo['id'] ?>" class="bg-yellow-400 px-4 py-2 rounded text-white">Edit Logo</a>
    <a href="hapus_logo.php?id=<?= $logo['id'] ?>" onclick="return confirm('Hapus logo?')" class="bg-red-500 px-4 py-2 rounded text-white">Hapus</a>
  <?php else: ?>
    <p class="mb-4 text-gray-700">Belum ada logo yang ditambahkan.</p>
    <a href="tambah_logo.php" class="bg-green-600 px-4 py-2 rounded text-white">Tambah Logo</a>
  <?php endif; ?>
</body>
</html>
