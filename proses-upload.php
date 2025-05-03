<?php
include 'koneksi.php';

if (isset($_POST['upload'])) {
    $judul = $_POST['judul'];
    $galery_id = $_POST['galery_id'];

    $filename = $_FILES['file']['name'];
    $tmp = $_FILES['file']['tmp_name'];
    $folder = "uploads/" . $filename;

    if (move_uploaded_file($tmp, $folder)) {
        // Simpan ke DB
        $query = "INSERT INTO foto (galery_id, file, judul) VALUES ('$galery_id', '$filename', '$judul')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "Foto berhasil diupload!";
        } else {
            echo "Gagal upload ke database: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal upload file.";
    }
}
?>
