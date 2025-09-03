-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2025 at 05:28 AM
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
-- Table structure for table `dwigital_withdraw`
--

CREATE TABLE `dwigital_withdraw` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_platform` int(10) UNSIGNED NOT NULL,
  `nominal` int(10) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `dwigital_withdraw`
--

INSERT INTO `dwigital_withdraw` (`id`, `id_platform`, `nominal`, `tanggal`, `created_at`, `updated_at`) VALUES
(1, 1, 2344444, '2025-09-02', '2025-09-02 15:09:06', '2025-09-02 15:09:06'),
(2, 2, 203000, '2025-09-17', '2025-09-03 01:20:20', '2025-09-03 01:20:20'),
(3, 1, 24444, '2025-09-17', '2025-09-03 03:11:26', '2025-09-03 03:11:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dwigital_withdraw`
--
ALTER TABLE `dwigital_withdraw`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_withdraw_platform` (`id_platform`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dwigital_withdraw`
--
ALTER TABLE `dwigital_withdraw`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dwigital_withdraw`
--
ALTER TABLE `dwigital_withdraw`
  ADD CONSTRAINT `withdraw_platform_fk` FOREIGN KEY (`id_platform`) REFERENCES `dwigital_platform` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
