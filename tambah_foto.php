<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload Foto Galeri Sekolah</title>
</head>
<body>
    <h2>Upload Foto Baru</h2>
    
    <form action="proses-upload.php" method="POST" enctype="multipart/form-data">
    <label>Judul Foto:</label><br>
    <input type="text" name="judul" required><br><br>

    <label>Pilih Galeri:</label><br>
    <select name="galery_id" required>
        <?php
        include 'koneksi.php';
        $galery = mysqli_query($conn, "SELECT * FROM galery");
        while ($row = mysqli_fetch_assoc($galery)) {
            echo "<option value='{$row['id']}'>{$row['id']}</option>";
        }
        ?>
    </select><br><br>

    <label>Pilih Foto:</label><br>
    <input type="file" name="file" accept="image/*" required><br><br>

    <button type="submit" name="upload">Upload</button>
</form>

</body>
</html>