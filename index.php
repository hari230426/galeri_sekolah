<?php
include 'koneksi.php';

function getAllGaleri($conn)
{
  $kategori = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM kategori WHERE judul = 'Galery Sekolah'"));
  if (!$kategori) return [];

  $posts = mysqli_query($conn, "
      SELECT * FROM posts
      WHERE kategori_id = {$kategori['id']} AND status = 'publish'
      ORDER BY created_at DESC
  ");

  $galeriData = [];

  while ($post = mysqli_fetch_assoc($posts)) {
    $galeries = mysqli_query($conn, "SELECT * FROM galery WHERE post_id = {$post['id']}");
    while ($galery = mysqli_fetch_assoc($galeries)) {
      $fotos = mysqli_query($conn, "SELECT * FROM foto WHERE galery_id = {$galery['id']}");
      while ($foto = mysqli_fetch_assoc($fotos)) {
        $galeriData[] = [
          'judul_post' => $post['judul'],
          'isi_post' => $post['isi'],
          'foto' => $foto['file'],
          'judul_foto' => $foto['judul']
        ];
      }
    }
  }

  return $galeriData;
}

function getKontenKategori($conn, $kategori_nama)
{
  $kategori = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM kategori WHERE judul = '$kategori_nama'"));
  if (!$kategori) return null;

  if ($kategori_nama === 'Agenda Sekolah') {
    $result = mysqli_query($conn, "
            SELECT isi FROM posts
            WHERE kategori_id = {$kategori['id']} AND status = 'publish'
            ORDER BY created_at DESC
            LIMIT 7
        ");
    $agendaList = [];
    while ($row = mysqli_fetch_assoc($result)) {
      $agendaList[] = $row['isi'];
    }
    return $agendaList;
  }

  $post = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT * FROM posts
        WHERE kategori_id = {$kategori['id']} AND status = 'publish'
        ORDER BY created_at DESC
        LIMIT 1
    "));
  if (!$post) return null;

  $galeri = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM galery WHERE post_id = {$post['id']} LIMIT 1"));
  $foto = $galeri ? mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM foto WHERE galery_id = {$galeri['id']} LIMIT 1")) : null;

  return [
    'judul' => $post['judul'],
    'isi' => $post['isi'],
    'foto' => $foto['file'] ?? null,
    'foto_judul' => $foto['judul'] ?? ''
  ];
}

function getBannerImages($conn)
{
  $kategori = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM kategori WHERE judul = 'Banner'"));
  if (!$kategori) return [];

  $posts = mysqli_query($conn, "
      SELECT p.id 
      FROM posts p
      WHERE kategori_id = {$kategori['id']} AND status = 'publish'
      ORDER BY created_at DESC
  ");

  $banners = [];

  while ($post = mysqli_fetch_assoc($posts)) {
    $galeries = mysqli_query($conn, "SELECT id FROM galery WHERE post_id = {$post['id']}");
    while ($galery = mysqli_fetch_assoc($galeries)) {
      $fotos = mysqli_query($conn, "SELECT * FROM foto WHERE galery_id = {$galery['id']}");
      while ($foto = mysqli_fetch_assoc($fotos)) {
        $banners[] = $foto['file'];
      }
    }
  }

  return $banners;
}

$bannerImages = getBannerImages($conn);
$agenda = getKontenKategori($conn, 'Agenda Sekolah');
$info = getKontenKategori($conn, 'Informasi Terkini');
$galeriItems = getAllGaleri($conn);
?>



<!DOCTYPE html>
<html lang="id">

<head>
  <title>Homepage</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-100 text-gray-800">

  <!-- Header -->
  <!-- Navbar -->
  <?php
  include 'koneksi.php';
  $logo = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM logo LIMIT 1"));
  ?>

  <header class="bg-white shadow px-4 py-2 flex items-center space-x-4">
    <!-- Logo -->
    <img src="images/<?= $logo['nama_logo'] ?>" alt="Logo Sekolah" class="h-12 w-12 object-contain">

    <!-- Teks di samping logo -->
    <div>
      <h1 class="text-xl font-bold text-gray-800"><?= $logo['nama_sekolah'] ?></h1>
      <p class="text-sm text-gray-500"><?= $logo['tagline'] ?></p>
    </div>
  </header>




  <!-- Carousel Banner -->
  <div x-data="{ current: 0 }"
    x-init="setInterval(() => { current = (current + 1) % <?= count($bannerImages) ?> }, 3000)"
    class="relative w-full h-96 overflow-hidden bg-gray-300">
    <?php foreach ($bannerImages as $i => $img): ?>
      <div class="absolute inset-0 w-full h-full transition-opacity duration-700"
        :class="current === <?= $i ?> ? 'opacity-100 z-10' : 'opacity-0 z-0'" style="pointer-events: none;">
        <img src="uploads/<?= $img ?>" alt="Banner <?= $i + 1 ?>" class="w-full h-full object-cover">
      </div>
    <?php endforeach; ?>

    <!-- Dots -->
    <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2 flex space-x-2">
      <?php foreach ($bannerImages as $i => $_): ?>
        <div class="w-3 h-3 rounded-full bg-white border border-gray-400 cursor-pointer"
          :class="{ 'bg-blue-500': current === <?= $i ?> }" @click="current = <?= $i ?>"></div>
      <?php endforeach; ?>
    </div>
  </div>



  <!-- Galeri Kegiatan -->
<section class="bg-green-100 p-6">
  <h2 class="text-2xl font-bold text-center mb-6">GALERI SEKOLAH</h2>
  <?php if (!empty($galeriItems)): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <?php foreach ($galeriItems as $item): ?>
        <div class="bg-white rounded shadow overflow-hidden">
          <img src="uploads/<?= $item['foto'] ?>" alt="<?= $item['judul_foto'] ?>"
            class="w-full h-64 object-cover">
          <div class="p-4">
            <h3 class="font-semibold text-md mb-1"><?= $item['judul_post'] ?></h3>
            <p class="text-sm text-gray-600"><?= $item['isi_post'] ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p class="text-center text-gray-500">Belum ada data galeri.</p>
  <?php endif; ?>
</section>


  <!-- Agenda & Informasi Terkini -->
  <section class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 text-center">
    <div class="bg-red-200 p-4 rounded">
      <h2 class="text-lg font-semibold mb-2 text-center">AGENDA SEKOLAH</h2>
      <?php if (!empty($agenda)): ?>
        <ul class="list-disc list-inside space-y-1">
          <?php foreach ($agenda as $item): ?>
            <li><?= htmlspecialchars($item) ?></li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p>Belum ada agenda.</p>
      <?php endif; ?>
    </div>

    <div class="bg-white p-4 rounded shadow flex flex-col items-center justify-center text-center">
      <h2 class="text-lg font-semibold mb-2">INFORMASI TERKINI</h2>
      <?php if ($info): ?>
        <h3 class="text-md font-bold mb-2"><?= $info['judul'] ?></h3>
        <img src="uploads/<?= $info['foto'] ?>" class="object-cover w-96 h-64 mb-2 rounded shadow"
          alt="<?= $info['foto_judul'] ?>">
        <p><?= $info['isi'] ?></p>
      <?php else: ?>
        <p>Belum ada informasi.</p>
      <?php endif; ?>
    </div>

  </section>

  <!-- Peta Sekolah -->
  <section class="p-4 bg-white">
    <h2 class="text-lg font-semibold mb-2">PETA SEKOLAH</h2>
    <div class="flex gap-4 items-start">
      <p class="w-1/2 text-lg">
        SMK 1 Triple J adalah sebuah sekolah SMK swasta yang beralamat di Jl. Landbow No.01 Karang Asem Barat Citeureup,
        Kab. Bogor. <br>

        SMK swasta ini mengawali perjalanannya pada tahun 1998. Pada saat ini SMK 1 Triple J memakai panduan kurikulum
        belajar pemerintah yaitu SMK 2013 REV.  Bisnis Daring dan Pemasaran. SMK 1 Triple J berada di bawah naungan
        kepala sekolah dengan nama Sriyanto ditangani oleh seorang operator yang bernama Indra Sutisna.

        SMK 1 Triple J terakreditasi grade A dengan nilai 92 (akreditasi tahun 2018) dari BAN-S/M (Badan Akreditasi
        Nasional) Sekolah/Madrasah.
      </p>
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.2879222081947!2d106.86433137499259!3d-6.485175293506797!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c15f22b23331%3A0x152d0f1eb6ef7c6c!2sSMKS%201%20Triple%20J!5e0!3m2!1sid!2sid!4v1745125474909!5m2!1sid!2sid"
        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </section>

</body>

</html>