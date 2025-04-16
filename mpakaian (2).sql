-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2025 at 03:05 AM
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
-- Database: `mpakaian`
--

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `kegiatan` varchar(255) DEFAULT NULL,
  `hari` varchar(10) DEFAULT NULL,
  `jam` time DEFAULT NULL,
  `pakaian_id` int(11) DEFAULT NULL,
  `skincare_id` int(11) DEFAULT NULL,
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id`, `user_id`, `tanggal`, `kegiatan`, `hari`, `jam`, `pakaian_id`, `skincare_id`, `catatan`) VALUES
(12, 2, '2222-02-22', NULL, 'Jumat', '22:22:00', 1, 1, '1'),
(13, 2, '2025-04-15', NULL, 'Selasa', '10:00:00', 1, 1, '12'),
(15, 2, '2025-04-15', NULL, 'Selasa', '11:30:00', 1, 2, 'ok');

-- --------------------------------------------------------

--
-- Table structure for table `lemari_pakaian`
--

CREATE TABLE `lemari_pakaian` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `warna` varchar(50) DEFAULT NULL,
  `ukuran` varchar(10) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lemari_pakaian`
--

INSERT INTO `lemari_pakaian` (`id`, `user_id`, `nama`, `jenis`, `warna`, `ukuran`, `foto`, `catatan`) VALUES
(1, 2, 'hem', 'baju', 'putih', 'l', 'Black White Bold Modern Studio Logo.png', '12'),
(2, 2, 'kaos ', 'baju', 'putih', 'L', 'data.jpeg.webp', '');

-- --------------------------------------------------------

--
-- Table structure for table `lemari_skincare`
--

CREATE TABLE `lemari_skincare` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `fungsi` varchar(100) DEFAULT NULL,
  `kadaluarsa` date DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lemari_skincare`
--

INSERT INTO `lemari_skincare` (`id`, `user_id`, `nama`, `jenis`, `fungsi`, `kadaluarsa`, `foto`, `catatan`) VALUES
(1, 2, 'mosturaizer', 'serum', 'mencerahkan', '2222-02-22', 'Gemini_Generated_Image_xibsxwxibsxwxibs-removebg-preview.png', '1'),
(2, 2, 'test', 'toner', 'lemebabkan', '2222-02-22', 'lilartsy-333oj7zFsdg-unsplash.jpg', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'admin', 'admin@example.com', '$2y$10$9UMatTsKs6OJNYiV2X8Pg.0dAydaY7OCmTJXClXaiG7/nMM6Hv2T2'),
(2, 'user', 'oqnyat@gmail.com', '$2y$10$E2RHMMtwABKvCceEW6f8/.7S10thDeyNVYPIwuumK26pg/sE4OdS6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pakaian_id` (`pakaian_id`),
  ADD KEY `skincare_id` (`skincare_id`);

--
-- Indexes for table `lemari_pakaian`
--
ALTER TABLE `lemari_pakaian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `lemari_skincare`
--
ALTER TABLE `lemari_skincare`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `lemari_pakaian`
--
ALTER TABLE `lemari_pakaian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lemari_skincare`
--
ALTER TABLE `lemari_skincare`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `jadwal_ibfk_2` FOREIGN KEY (`pakaian_id`) REFERENCES `lemari_pakaian` (`id`),
  ADD CONSTRAINT `jadwal_ibfk_3` FOREIGN KEY (`skincare_id`) REFERENCES `lemari_skincare` (`id`);

--
-- Constraints for table `lemari_pakaian`
--
ALTER TABLE `lemari_pakaian`
  ADD CONSTRAINT `lemari_pakaian_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lemari_skincare`
--
ALTER TABLE `lemari_skincare`
  ADD CONSTRAINT `lemari_skincare_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
