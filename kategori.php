<?php
include 'koneksi.php';

// proses simpan kategori
if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $query = "INSERT INTO kategori (judul) VALUES ('$judul')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<p style='color:green;'>Kategori berhasil ditambahkan!</p>";
    } else {
        echo "<p style='color:red;'>Gagal menambahkan kategori: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kategori</title>
</head>
<body>
    <h2>Tambah Kategori</h2>
    <form action="" method="POST">
        <label>Judul Kategori:</label><br>
        <input type="text" name="judul" required><br><br>
        <button type="submit" name="simpan">Simpan Kategori</button>
    </form>

    <hr>

    <h3>Daftar Kategori</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Judul</th>
        </tr>
        <?php
        $no = 1;
        $kategori = mysqli_query($conn, "SELECT * FROM kategori");
        while ($row = mysqli_fetch_assoc($kategori)) {
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $row['judul']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
