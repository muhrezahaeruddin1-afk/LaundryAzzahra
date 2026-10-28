-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2025 at 06:50 AM
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
-- Database: `laundry_azzahra`
--

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tipe_satuan` enum('KG','PCS') NOT NULL DEFAULT 'KG',
  `harga_per_satuan` int(11) NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `layanan`
--

INSERT INTO `layanan` (`id`, `nama`, `tipe_satuan`, `harga_per_satuan`, `aktif`, `created_at`) VALUES
(2, 'Cuci Lipat', 'KG', 4000, 1, '2025-10-29 10:39:28'),
(3, 'Cuci Kering', 'KG', 4000, 1, '2025-10-29 10:39:28'),
(5, 'Cuci Saja', 'KG', 3000, 1, '2025-10-29 10:39:28'),
(6, 'Pengeringan Saja', 'KG', 3000, 1, '2025-10-29 10:39:28'),
(7, 'Gorden', 'KG', 10000, 1, '2025-10-29 10:39:28'),
(8, 'Seprai / Komplit', 'PCS', 10000, 1, '2025-10-29 10:39:28'),
(9, 'Selimut Tipis', 'PCS', 10000, 1, '2025-10-29 10:39:28'),
(10, 'Selimut Sedang', 'PCS', 15000, 1, '2025-10-29 10:39:28'),
(11, 'Selimut Tebal', 'PCS', 20000, 1, '2025-10-29 10:39:28'),
(12, 'Bad Cover No 1', 'PCS', 30000, 1, '2025-10-29 10:39:28'),
(13, 'Bad Cover No 2', 'PCS', 20000, 1, '2025-10-29 10:39:28'),
(14, 'Jas', 'PCS', 20000, 1, '2025-10-29 10:39:28'),
(15, 'Jas 1 Pasang', 'PCS', 15000, 1, '2025-10-29 10:39:28'),
(20, 'cuci sepatu', 'PCS', 200000, 0, '2025-12-01 08:06:17'),
(21, 'cuci sepatu', 'PCS', 20000, 1, '2025-12-01 08:39:11');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `telp` varchar(25) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `telp`, `alamat`, `created_at`) VALUES
(7, 'Muh Reza Haeruddin', '082296785430', 'jln Traktor IV', '2025-10-30 09:24:13'),
(8, 'Alya', '082296785431', 'Parang Tambung', '2025-10-30 09:33:02'),
(10, 'Muslimah', '082296785431', 'Daeng Tata 1', '2025-11-02 04:34:26'),
(11, 'Rifki', '082299785431', 'Daeng Tata 2', '2025-11-02 12:31:21'),
(12, 'Salmi', '082345455423', 'Parang Tambung', '2025-11-06 00:37:07'),
(13, 'Reza', '0876666666', 'Traltor', '2025-11-20 00:39:57'),
(14, 'Nurul', '082298887775', 'Daeng tata', '2025-11-27 01:06:07'),
(15, 'Fauzan', '0823334447665', 'Andi djema', '2025-11-27 01:10:07'),
(16, 'Fadilah', '084443555255', 'Parangtambung', '2025-12-01 05:54:44'),
(17, 'yayat', '083332445443', 'ParangTambung', '2025-12-01 08:10:25'),
(18, 'Utami', '097777666666', 'Landak', '2025-12-01 08:41:09'),
(19, 'Muh', '083332445443', 'Sulawesi Barat', '2025-12-02 03:41:31');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `pelanggan_id` int(11) DEFAULT NULL,
  `tanggal_masuk` datetime NOT NULL DEFAULT current_timestamp(),
  `tanggal_selesai_est` datetime DEFAULT NULL,
  `status` enum('MASUK','PROSES','SELESAI','BATAL') NOT NULL DEFAULT 'MASUK',
  `berat_kg` decimal(7,2) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `estimasi_selesai_jam` int(11) NOT NULL DEFAULT 24,
  `metode_terima` enum('ambil_sendiri','antar') NOT NULL DEFAULT 'ambil_sendiri',
  `jarak_km` decimal(5,2) NOT NULL DEFAULT 0.00,
  `biaya_antar` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `kode`, `pelanggan_id`, `tanggal_masuk`, `tanggal_selesai_est`, `status`, `berat_kg`, `catatan`, `estimasi_selesai_jam`, `metode_terima`, `jarak_km`, `biaya_antar`) VALUES
(11, 'AZ-20251030-702', 7, '2025-10-30 17:24:13', NULL, 'SELESAI', 0.00, '', 24, 'ambil_sendiri', 0.00, 0),
(12, 'AZ-20251030-825', 8, '2025-10-30 17:33:02', NULL, 'SELESAI', 0.00, '', 2, 'antar', 1.00, 5000),
(15, 'AZ-20251102-779', 10, '2025-11-02 12:34:26', NULL, 'SELESAI', 0.00, '', 24, 'antar', 3.00, 15000),
(16, 'AZ-20251102-155', 11, '2025-11-02 20:31:21', NULL, 'SELESAI', 0.00, '', 24, 'antar', 2.00, 10000),
(19, 'AZ-20251127-386', 14, '2025-11-27 09:06:07', NULL, 'MASUK', 0.00, 'Cepat ya', 48, 'antar', 1.00, 5000),
(20, 'AZ-20251127-841', 15, '2025-11-27 09:10:07', NULL, 'PROSES', 0.00, '', 48, 'ambil_sendiri', 0.00, 0),
(21, 'AZ-20251201-656', 16, '2025-12-01 13:54:44', NULL, 'PROSES', NULL, 'Cepat ya', 19, 'antar', 1.00, 5000),
(22, 'AZ-20251201-465', 17, '2025-12-01 16:10:25', NULL, 'SELESAI', NULL, '', 24, 'antar', 2.00, 10000),
(23, 'AZ-20251201-759', 18, '2025-12-01 16:41:09', NULL, 'MASUK', NULL, 'Cepat Yaa', 48, 'antar', 2.00, 10000),
(24, 'AZ-20251202-708', 19, '2025-12-02 11:41:31', NULL, 'MASUK', NULL, '', 24, 'ambil_sendiri', 0.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_detail`
--

CREATE TABLE `pesanan_detail` (
  `id` int(11) NOT NULL,
  `pesanan_id` int(11) NOT NULL,
  `layanan_id` int(11) NOT NULL,
  `qty` decimal(7,2) NOT NULL DEFAULT 1.00,
  `harga_satuan` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan_detail`
--

INSERT INTO `pesanan_detail` (`id`, `pesanan_id`, `layanan_id`, `qty`, `harga_satuan`, `subtotal`) VALUES
(14, 11, 2, 1.00, 4000, 4000),
(15, 12, 15, 2.00, 15000, 30000),
(19, 16, 10, 2.00, 15000, 30000),
(24, 20, 15, 2.00, 15000, 30000),
(25, 21, 3, 1.50, 4000, 6000),
(26, 22, 3, 2.00, 4000, 8000),
(27, 22, 14, 1.00, 20000, 20000),
(28, 23, 7, 1.00, 10000, 10000),
(29, 23, 21, 2.00, 20000, 40000),
(30, 24, 15, 1.00, 15000, 15000),
(31, 24, 2, 1.00, 4000, 4000),
(32, 24, 21, 1.00, 20000, 20000);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `pesanan_id` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `diskon` int(11) NOT NULL DEFAULT 0,
  `biaya_tambahan` int(11) NOT NULL DEFAULT 0,
  `grand_total` int(11) NOT NULL,
  `metode` enum('CASH','QRIS') NOT NULL,
  `status_bayar` enum('UNPAID','PAID') NOT NULL DEFAULT 'UNPAID',
  `qris_ref` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `paid_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `pesanan_id`, `total`, `diskon`, `biaya_tambahan`, `grand_total`, `metode`, `status_bayar`, `qris_ref`, `created_at`, `paid_at`) VALUES
(11, 11, 4000, 0, 0, 4000, 'QRIS', 'UNPAID', NULL, '2025-10-30 17:24:13', NULL),
(12, 12, 35000, 0, 0, 35000, 'CASH', 'PAID', 'CASH', '2025-10-30 17:33:02', '2025-10-30 10:33:02'),
(15, 15, 22000, 0, 0, 22000, 'QRIS', 'PAID', 'QRIS', '2025-11-02 05:34:26', '2025-11-02 05:34:33'),
(16, 16, 45000, 0, 5000, 50000, 'CASH', 'PAID', 'CASH', '2025-11-02 13:31:21', '2025-11-02 13:31:21'),
(19, 19, 12000, 0, 0, 12000, 'QRIS', 'UNPAID', NULL, '2025-11-27 02:06:07', NULL),
(20, 20, 30000, 0, 0, 30000, 'CASH', 'PAID', 'CASH', '2025-11-27 02:10:07', '2025-11-27 02:10:07'),
(21, 21, 16000, 0, 5000, 21000, 'QRIS', 'PAID', NULL, '2025-12-01 06:54:44', '2025-12-01 06:55:31'),
(22, 22, 43000, 0, 5000, 48000, 'QRIS', 'PAID', NULL, '2025-12-01 09:10:25', '2025-12-01 09:10:53'),
(23, 23, 65000, 0, 5000, 70000, 'QRIS', 'PAID', NULL, '2025-12-01 09:41:09', '2025-12-01 09:41:27'),
(24, 24, 44000, 0, 5000, 49000, 'CASH', 'PAID', 'CASH', '2025-12-02 04:41:31', '2025-12-02 04:41:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `nama`, `level`) VALUES
(2, 'admin1', 'admin1@gmail.com', '$2y$10$p7a0lLlo0IVgE49fRifH2s.mxBrN.Ae6CMZdVu...', 'atalya', 'admin'),
(3, 'ztilyaa', 'fauzanmstng27@gmail.com', '$2y$10$snealVr0plVHL9D6hJyRNsevYqmSIRGzcdbht...', 'Admin123', 'admin'),
(6, 'Ima', 'muslimah@gmail.com', '$2y$10$Oy9Ijq6PsRavFNN3ir/jROCFP7uw5lEjKi8ZsSfFbYgy0QZHJGvWm', 'Muslimah', 'admin'),
(7, 'Admin2', 'muslimah1@gmail.com', '$2y$10$fFEZnlgqIVdE8zTEuYf6..mLMKvb/UZ4JU1GYcRm2B3bjHLOiZsAe', 'Muh Reza', 'admin'),
(8, 'alya', 'Alya1@gmail.com', '$2y$10$sD9x3JGIlT67cZDQhwJj0O3cyYcIn1jsJudh1u70AcQc14bpEAl9S', 'Tri Atalya', 'admin'),
(9, 'ima anak baik', 'Muslimah12@gmial.com', '$2y$10$K5gYOVOYJBkacJBJ6zdnhOE4c3RAYSwr1ohHEj8ZZNuChaA/0tIVC', 'Muslimah Nur Salam', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggan_id` (`pelanggan_id`);

--
-- Indexes for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanan_id` (`pesanan_id`),
  ADD KEY `layanan_id` (`layanan_id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanan_id` (`pesanan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  ADD CONSTRAINT `pesanan_detail_ibfk_1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pesanan_detail_ibfk_2` FOREIGN KEY (`layanan_id`) REFERENCES `layanan` (`id`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
