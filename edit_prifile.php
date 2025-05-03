<form action="simpan_profile.php" method="POST" enctype="multipart/form-data">
    <label>Judul:</label>
    <input type="text" name="judul" value="<?= $data['judul'] ?>"><br>

    <label>Isi:</label>
    <textarea name="isi"><?= $data['isi'] ?></textarea><br>

    <label>Logo:</label>
    <input type="file" name="logo"><br>
    <?php if (!empty($data['logo'])): ?>
        <img src="../images/<?= $data['logo'] ?>" alt="Logo Lama" class="h-20">
    <?php endif; ?>

    <input type="hidden" name="id" value="<?= $data['id'] ?>">
    <button type="submit">Simpan</button>
</form>
