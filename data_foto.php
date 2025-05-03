<?php
include 'koneksi.php';
session_start();

// Cek login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// Ambil data foto dari database
$result = mysqli_query($conn, "SELECT * FROM fotos");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Foto</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        img { max-width: 100px; }
        a.tambah { display: inline-block; margin-bottom: 15px; background: green; color: white; padding: 8px 12px; text-decoration: none; border-radius: 5px; }
        a.hapus { color: red; text-decoration: none; }
    </style>
</head>
<body>

    <h2>Data Foto</h2>
    <a href="tambah_foto.php" class="tambah">+ Tambah Foto</a>

    <table>
        <tr>
            <th>Judul</th>
            <th>File</th>
            <th>Aksi</th>
        </tr>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['judul']) ?></td>
                    <td>
                        <img src="uploads/<?= htmlspecialchars($row['file']) ?>" alt="<?= htmlspecialchars($row['judul']) ?>">
                    </td>
                    <td>
                        <a class="hapus" href="hapus_foto.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">Belum ada data foto.</td>
            </tr>
        <?php endif; ?>
    </table>

</body>
</html>
