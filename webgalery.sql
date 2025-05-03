-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2025 at 04:10 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webgalery`
--

-- --------------------------------------------------------

--
-- Table structure for table `foto`
--

CREATE TABLE `foto` (
  `id` int(11) NOT NULL,
  `galery_id` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `judul` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `foto`
--

INSERT INTO `foto` (`id`, `galery_id`, `file`, `judul`) VALUES
(9, 9, 'SnapInsta.to_468310535_1591790024879414_7578696883746112966_n.jpg', 'Juara 1'),
(10, 10, 'IMG_3055.JPG', 'Juara 2'),
(11, 11, 'IMG_20240907_084754_11zon.jpg', 'Ujian Kompentensi Kejuruan'),
(12, 12, 'SLIDER-20231109110605.jpg', 'Banner 1'),
(13, 13, 'SLIDER-20231109091329.jpg', 'Banner 2'),
(14, 14, 'picture-20231105073733.jpg', 'Banner 3'),
(15, 15, 'picture-20231105073701.jpg', 'Banner 4'),
(16, 16, 'logo-triplej-1.jpeg', 'Galeri 1'),
(17, 17, 'IMG_3126.JPG', 'Galeri 2');

-- --------------------------------------------------------

--
-- Table structure for table `galery`
--

CREATE TABLE `galery` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT 0,
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `galery`
--

INSERT INTO `galery` (`id`, `post_id`, `position`, `status`) VALUES
(9, 17, 1, 1),
(10, 18, 1, 1),
(11, 19, 1, 1),
(12, 20, 1, 1),
(13, 21, 1, 1),
(14, 22, 1, 1),
(15, 23, 1, 1),
(16, 24, 1, 1),
(17, 25, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `judul`) VALUES
(1, 'Informasi terkini'),
(2, 'Agenda Sekolah'),
(6, 'Galery sekolah'),
(7, 'Banner');

-- --------------------------------------------------------

--
-- Table structure for table `logo`
--

CREATE TABLE `logo` (
  `id` int(11) NOT NULL,
  `nama_logo` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `nama_sekolah` varchar(255) DEFAULT 'Nama Sekolah',
  `tagline` varchar(255) DEFAULT 'Tagline Sekolah'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logo`
--

INSERT INTO `logo` (`id`, `nama_logo`, `created_at`, `nama_sekolah`, `tagline`) VALUES
(3, 'logo-triplej-1.jpeg', '2025-04-21 07:06:29', 'SMK 1 Triple J', 'Maju seiring perkembangan digital');

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `level` enum('superadmin','admin') NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id`, `username`, `password`, `created_at`, `level`) VALUES
(2, 'admin', '$2y$10$Q0bVvQX.itQZV3tb.rpCbOnCTZbG56laletatBXzQd7yl2mkHuvo.', '2025-04-17 04:17:38', 'superadmin'),
(3, 'hafizh', '$2y$10$pYGuUzO5MAl7w2rzU.pDn.JdNlhr9PWkx7s0JRly9RVV3LKmetLeq', '2025-04-17 04:21:05', 'admin'),
(4, 'rahman', '$2y$10$Iimj8kRylqZL0FEdA0dFz.qqf2NrGQZawrTNhGO3ebcxzj5u5AKdG', '2025-04-18 10:23:51', 'admin'),
(5, 'jesii', '$2y$10$IP/mx6NMuPAX18e5Tc72yexi0bmdvwkVB25NgGbFIMtvy3wa8HIZi', '2025-04-19 02:24:53', 'admin'),
(6, 'kanan', '$2y$10$KZ3.lGiQnwiWmPzNDNGkJO6Tzo4Yp4VEUBvyo.K1pxYpLDLTf9WWi', '2025-04-21 06:29:12', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `isi` text DEFAULT NULL,
  `kategori_id` int(11) DEFAULT NULL,
  `petugas_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `judul`, `isi`, `kategori_id`, `petugas_id`, `status`, `created_at`) VALUES
(17, 'juara 1', 'Selamat kepada Siswa Konsentrasi Keahlian Bisnis Digital@bdp.smk1triplejSMK 1 Triple J yang telah berhasil meraih prestasi Juara 1 Pembuatan Video Promosi yang diselenggarakan oleh Universitas Ibn Khaldun@uika_bogor.', 6, 2, 'publish', '2025-04-20 06:27:48'),
(18, 'juara 2', 'Hari Guru', 2, 2, 'publish', '2025-04-20 06:50:00'),
(19, 'Ujian Kompetensi Kejuruan', '21 April 2025', 1, 2, 'publish', '2025-04-20 06:50:28'),
(20, 'Banner 1', 'Banner 1', 7, 2, 'publish', '2025-04-20 10:01:05'),
(21, 'Banner 2', 'Banner 2', 7, 2, 'publish', '2025-04-20 10:10:35'),
(22, 'Banner 3', 'Banner 3', 7, 2, 'publish', '2025-04-20 10:12:21'),
(23, 'Banner 4', 'Banner 4', 7, 2, 'publish', '2025-04-21 07:07:57'),
(24, 'Galeri 1', 'Logo SMK 1 TRIPLE J', 6, 2, 'publish', '2025-04-21 08:47:02'),
(25, 'Galeri 2', 'Kenangan hari guru', 6, 2, 'publish', '2025-04-21 08:49:30');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `isi` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `galery_id` (`galery_id`);

--
-- Indexes for table `galery`
--
ALTER TABLE `galery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logo`
--
ALTER TABLE `logo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`),
  ADD KEY `petugas_id` (`petugas_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `foto`
--
ALTER TABLE `foto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `galery`
--
ALTER TABLE `galery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `logo`
--
ALTER TABLE `logo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `foto`
--
ALTER TABLE `foto`
  ADD CONSTRAINT `foto_ibfk_1` FOREIGN KEY (`galery_id`) REFERENCES `galery` (`id`);

--
-- Constraints for table `galery`
--
ALTER TABLE `galery`
  ADD CONSTRAINT `galery_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`petugas_id`) REFERENCES `petugas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
