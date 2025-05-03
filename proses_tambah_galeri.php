<?php
include 'koneksi.php';

if (isset($_POST['submit'])) {
    $post_id = $_POST['post_id'];
    $position = $_POST['position'];
    $status = $_POST['status'];

    $query = "INSERT INTO galery (post_id, position, status) 
              VALUES ('$post_id', '$position', '$status')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Galeri berhasil ditambahkan!";
    } else {
        echo "Gagal menambahkan galeri: " . mysqli_error($conn);
    }
}
?>
