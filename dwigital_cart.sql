-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2025 at 04:37 PM
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
-- Database: `dbs_ciptareka`
--

-- --------------------------------------------------------

--
-- Table structure for table `dwigital_cart`
--

CREATE TABLE `dwigital_cart` (
  `id_cart` int(10) UNSIGNED NOT NULL,
  `no_faktur` varchar(50) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_karyawan` int(11) DEFAULT NULL,
  `nama_karyawan` varchar(200) DEFAULT NULL,
  `durasi_langganan` varchar(10) DEFAULT NULL,
  `catatan` varchar(200) NOT NULL,
  `total` int(11) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `kembalian` int(11) DEFAULT NULL,
  `diskon` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `status_bayar` varchar(10) DEFAULT NULL,
  `foto` varchar(100) NOT NULL,
  `waktu_bayar` datetime NOT NULL,
  `nama_pemesan` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `payment_type` varchar(20) NOT NULL,
  `bank` varchar(20) NOT NULL,
  `va_number` varchar(50) NOT NULL,
  `pdf_url` varchar(100) NOT NULL,
  `status_code` int(11) NOT NULL,
  `closed_at` datetime DEFAULT NULL,
  `closed_by` int(11) DEFAULT NULL,
  `gg` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `id_platform` int(11) DEFAULT NULL,
  `id_import` int(11) DEFAULT NULL,
  `import_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dwigital_cart`
--

INSERT INTO `dwigital_cart` (`id_cart`, `no_faktur`, `tgl`, `id_user`, `id_karyawan`, `nama_karyawan`, `durasi_langganan`, `catatan`, `total`, `nominal`, `kembalian`, `diskon`, `status`, `status_bayar`, `foto`, `waktu_bayar`, `nama_pemesan`, `phone`, `created_at`, `created_by`, `updated_at`, `payment_type`, `bank`, `va_number`, `pdf_url`, `status_code`, `closed_at`, `closed_by`, `gg`, `id_produk`, `id_platform`, `id_import`, `import_at`) VALUES
(21, '250925000002', '2025-09-07', 16, NULL, NULL, '6 bulan', '', 150000, 12333666, 1083366, NULL, 'selesai', '2', '', '0000-00-00 00:00:00', NULL, '', '2025-09-07 16:33:05', 1, NULL, 'cash', '', '', '', 0, NULL, NULL, NULL, NULL, 4, NULL, NULL),
(22, 'H370925000001', '2025-09-07', NULL, NULL, NULL, NULL, '', 0, 0, 0, NULL, 'hold', '0', '', '0000-00-00 00:00:00', NULL, NULL, '2025-09-07 16:33:32', NULL, NULL, '', '', '', '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, '110925000003', '2025-09-07', 17, NULL, NULL, '1 bulan', '', 150000, 1333333, 1183333, NULL, 'selesai', '2', '', '0000-00-00 00:00:00', NULL, '', '2025-09-07 17:37:33', 1, NULL, 'cash', '', '', '', 0, NULL, NULL, NULL, 0, 4, NULL, NULL),
(24, '770925000004', '2025-09-07', 5, NULL, NULL, '12 bulan', 'Pak Lailyn', 450000, 1234566, 784566, NULL, 'selesai', '2', '', '0000-00-00 00:00:00', NULL, '082376475617', '2025-09-07 17:39:13', 1, NULL, 'cash', '', '', '', 0, NULL, NULL, NULL, 0, 5, NULL, NULL),
(25, '830925000005', '2025-09-07', 5, NULL, NULL, '3 bulan', 'Pak Lailyn lagi', 90000, 123333, 33333, NULL, 'selesai', '2', '', '0000-00-00 00:00:00', NULL, '082376475617', '2025-09-07 17:44:53', 1, NULL, 'cod', '', '', '', 0, NULL, NULL, NULL, 0, 5, NULL, NULL),
(29, 'H390925000002', '2025-09-07', NULL, NULL, NULL, NULL, '', 0, 0, 0, NULL, 'hold', '0', '', '0000-00-00 00:00:00', NULL, NULL, '2025-09-07 21:08:17', NULL, NULL, '', '', '', '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'H750925000003', '2025-09-07', NULL, NULL, NULL, NULL, '', 0, 0, 0, NULL, 'hold', '0', '', '0000-00-00 00:00:00', NULL, NULL, '2025-09-07 21:26:16', NULL, NULL, '', '', '', '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'H160925000004', '2025-09-07', NULL, NULL, NULL, NULL, '', 0, 0, 0, NULL, 'hold', '0', '', '0000-00-00 00:00:00', NULL, NULL, '2025-09-07 21:34:21', NULL, NULL, '', '', '', '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, '520925000006', '2025-09-07', 16, NULL, NULL, '1 bulan', 'Pak Lailyn Puad', 170000, 180000, 10000, NULL, 'selesai', '2', '', '0000-00-00 00:00:00', NULL, '082376475617', '2025-09-07 21:35:17', 1, NULL, 'cash', '', '', '', 0, NULL, NULL, NULL, 0, 5, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dwigital_cart`
--
ALTER TABLE `dwigital_cart`
  ADD PRIMARY KEY (`id_cart`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dwigital_cart`
--
ALTER TABLE `dwigital_cart`
  MODIFY `id_cart` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
