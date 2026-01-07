-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2026 at 03:58 AM
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
-- Database: `wifi_invetory`
--

-- --------------------------------------------------------

--
-- Table structure for table `consumable_logs`
--

CREATE TABLE `consumable_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gid` varchar(1000) NOT NULL,
  `uid` varchar(1000) NOT NULL,
  `cid` varchar(1000) NOT NULL,
  `date` varchar(1000) NOT NULL,
  `time` varchar(1000) NOT NULL,
  `quantity_deduction` varchar(1000) NOT NULL,
  `remarks` varchar(1000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consumable_logs`
--

INSERT INTO `consumable_logs` (`id`, `gid`, `uid`, `cid`, `date`, `time`, `quantity_deduction`, `remarks`, `created_at`, `updated_at`) VALUES
(1, '4', '22', '5', '2026-01-07', '10:55', '10', 'Sample Remarks', '2026-01-07 02:56:48', '2026-01-07 02:56:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `consumable_logs`
--
ALTER TABLE `consumable_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `consumable_logs`
--
ALTER TABLE `consumable_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
