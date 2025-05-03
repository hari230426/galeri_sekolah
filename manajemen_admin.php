<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['level'])) {
    header("Location: ../login.php");
    exit;
}

// Hanya superadmin yang boleh akses halaman ini
if ($_SESSION['level'] !== 'superadmin') {
    header("Location: dashboard_admin.php"); // atau tampilkan pesan error
    exit;
}

// Ambil semua petugas (admin)
$result = mysqli_query($conn, "SELECT * FROM petugas WHERE level = 'admin'"); // Filter hanya yang level 'admin'

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2>Manajemen Admin</h2>

    <!-- Baris keterangan siapa yang login -->
    <p class="text-muted">
        Anda login sebagai: <strong><?= htmlspecialchars($_SESSION['username']) ?></strong> (<?= htmlspecialchars($_SESSION['level']) ?>)
    </p>

    <a href="tambah_admin.php" class="btn btn-success mb-3">+ Tambah Admin</a>

    <table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th>Username</th>
            <th>Level</th> <!-- Kolom baru -->
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td>
                        <span class="badge bg-<?= $row['level'] === 'superadmin' ? 'primary' : 'secondary' ?>">
                            <?= htmlspecialchars($row['level']) ?>
                        </span>
                    </td>
                    <td>
                        <a href="hapus_admin.php?id=<?= $row['id'] ?>" 
                           onclick="return confirm('Yakin ingin menghapus admin ini?')" 
                           class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="text-center">Belum ada admin.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>


</body>
</html>
