<?php include 'koneksi.php'; ?>

<h2>Tambah Galeri</h2>

<form action="proses_tambah_galeri.php" method="POST">
    <label>Judul Post:</label><br>
    <select name="post_id" required>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM posts");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='{$row['id']}'>{$row['judul']}</option>";
        }
        ?>
    </select><br><br>

    <label>Posisi Galeri:</label><br>
    <input type="number" name="position" min="0" value="0" required><br><br>

    <label>Status:</label><br>
    <select name="status">
        <option value="1">Aktif</option>
        <option value="0">Nonaktif</option>
    </select><br><br>

    <button type="submit" name="submit">Simpan Galeri</button>
</form>
