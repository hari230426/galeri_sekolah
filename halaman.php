<?php
include 'koneksi.php';
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['id'])) {
    echo "<p style='color:red;'>Anda harus login sebagai admin terlebih dahulu.</p>";
    exit;
}

// Ambil ID petugas dari session
$petugas_id = $_SESSION['id'];

// Proses simpan post
if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $kategori_id = $_POST['kategori_id'];
    $isi = $_POST['isi'];
    $status = $_POST['status'];

    // Validasi sederhana
    if (!empty($judul) && !empty($kategori_id) && !empty($isi) && !empty($status)) {
        $query = "INSERT INTO posts (judul, kategori_id, isi, petugas_id, status, created_at)
                  VALUES ('$judul', '$kategori_id', '$isi', '$petugas_id', '$status', NOW())";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $notif = "<p style='color:green;'>Post berhasil ditambahkan!</p>";
        } else {
            $notif = "<p style='color:red;'>Gagal menambahkan post: " . mysqli_error($conn) . "</p>";
        }
    } else {
        $notif = "<p style='color:red;'>Semua field harus diisi!</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Post</title>
</head>
<body>
    <h2>Tambah Post</h2>

    <?php if (!empty($notif)) echo $notif; ?>

    <form action="" method="POST">
        <label>Judul:</label><br>
        <input type="text" name="judul" required><br><br>

        <label>Kategori:</label><br>
        <select name="kategori_id" required>
            <option value="">-- Pilih Kategori --</option>
            <?php
            $kategori = mysqli_query($conn, "SELECT * FROM kategori");
            while ($row = mysqli_fetch_assoc($kategori)) {
                echo "<option value='{$row['id']}'>{$row['judul']}</option>";
            }
            ?>
        </select><br><br>

        <label>Isi Konten:</label><br>
        <textarea name="isi" rows="5" cols="50" required></textarea><br><br>

        <label>Status:</label><br>
        <select name="status">
            <option value="aktif">Aktif</option>
            <option value="draft">Draft</option>
        </select><br><br>

        <button type="submit" name="simpan">Simpan Post</button>
    </form>

    <hr>

    <h3>Daftar Post</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Judul</th>
        <th>Kategori</th>
        <th>Status</th>
        <th>Tanggal</th>
    </tr>
    <?php
    $no = 1;
    $post = mysqli_query($conn, "
        SELECT posts.*, kategori.judul AS kategori_nama
        FROM posts
        LEFT JOIN kategori ON posts.kategori_id = kategori.id
        ORDER BY created_at DESC
    ");
    while ($row = mysqli_fetch_assoc($post)) {
    ?>
    <tr>
        <td><?php echo $no++; ?></td>
        <td><?php echo $row['judul']; ?></td>
        <td><?php echo $row['kategori_nama']; ?></td>
        <td><?php echo $row['status']; ?></td>
        <td><?php echo $row['created_at']; ?></td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
