<?php
session_start();

// Mencegah cache agar tidak bisa kembali via back/forward button
header("Cache-Control: no-cache, no-store, must-revalidate"); 
header("Pragma: no-cache");
header("Expires: 0");

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: /login.php");
    exit;
}
?>
<script>
// Logout otomatis saat halaman ditinggalkan (misal: tombol back ditekan)
window.addEventListener("beforeunload", function () {
    navigator.sendBeacon('/logout.php');
});
</script>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fa;
            color: #333;
        }
        .header {
            background: #6C5CE7;
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
        .header h2 {
            margin-bottom: 5px;
        }
        .container {
            max-width: 900px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
        }
        .menu {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        .menu a {
            display: block;
            padding: 15px;
            background-color: #eaf0ff;
            text-decoration: none;
            color: #2d3436;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s ease;
            text-align: center;
        }
        .menu a:hover {
            background-color: #d6e0ff;
            transform: translateY(-2px);
        }
        .logout {
            margin-top: 40px;
            text-align: center;
        }
        .logout a {
            color: #d63031;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }
        .logout a:hover {
            color: #c0392b;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>Dashboard Admin</h2>
    <p>Selamat datang, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>!</p>
</div>

<div class="container">
    <h3 style="margin-bottom: 20px;">Menu Fitur</h3>
    <div class="menu">
        <?php if ($_SESSION['level'] === 'superadmin') : ?>
            <a href="manajemen_admin.php">Manajemen Admin</a>
        <?php endif; ?>
        <a href="tambah_kategori.php">Kategori Galeri</a>
        <a href="logo.php">Logo</a>
        <a href="post.php">Post</a>
    </div>

    <div class="logout">
        <p><a href="logout.php">Logout</a></p>
    </div>
</div>

</body>
</html>

<script>
// Buat history menjadi "dummy", jadi setelah logout, forward (→) tidak bisa
history.pushState(null, "", location.href);
window.addEventListener("popstate", function () {
  history.pushState(null, "", location.href);
});

// Kirim logout otomatis jika user keluar dari halaman
window.addEventListener("beforeunload", function () {
    navigator.sendBeacon('logout.php');
});
</script>
