-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2023 at 03:01 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u8378009_geofence`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `company` varchar(250) NOT NULL,
  `profile_picture` varchar(250) NOT NULL,
  `id_level` int(11) NOT NULL,
  `address` varchar(250) NOT NULL,
  `login_type` enum('default','google','fb') NOT NULL,
  `status` varchar(250) NOT NULL,
  `token` text NOT NULL,
  `active` int(11) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_login` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id_user`, `username`, `first_name`, `last_name`, `email`, `password`, `company`, `profile_picture`, `id_level`, `address`, `login_type`, `status`, `token`, `active`, `create_at`, `last_login`) VALUES
(1, 'Fadil', 'Achmad', 'Fadilah', 'fadilahdeveloper@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '', 'assets/images/users/blank.png', 2, '', 'default', '0', 'Already verified', 1, '2023-11-21 01:25:40', '2023-11-21 08:25:40'),
(2, 'Demo', 'Demo', 'Account', 'fadil@mail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '', '', 2, '', 'default', '0', 'Already verified', 1, '2023-12-28 01:09:57', '2023-12-28 08:09:57'),
(3, 'scrapingteam', 'Scraping', 'Team', 'scrapingteam@mail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '', '', 3, '', 'default', '0', 'Already verified', 1, '2023-11-09 09:34:23', '2023-11-09 16:34:23'),
(4, 'Satria', 'Satria', 'Rizali', 'dedenjr123@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '', '', 2, '', 'default', '0', 'Already verified', 1, '2023-11-24 09:51:16', '2023-11-24 16:51:16'),
(5, 'kimura', 'Kimura', 'Kenji', 'kimura@csar.co.jp', '46a7daf5ce4b16c0095275decea0c38dcadb6a0b', '', 'assets/images/users/blank.png', 2, '', 'default', '0', 'hPrONuEyRItoGn3sLc1e79pD6UCw', 0, '2023-10-18 04:44:14', '2023-10-18 11:44:14'),
(6, 'aji', 'Adjie', 'Suryabuana', 'aji@mail.com', '46a7daf5ce4b16c0095275decea0c38dcadb6a0b', '', 'assets/images/users/blank.png', 2, '', 'default', '0', 'CTmIa9YljqcJUNSVr3LbiZpz8vnk', 0, '2023-09-21 04:41:43', '2023-09-21 11:41:43'),
(7, 'rizaldi', 'M Rizaldi', 'Yani', 'rizaldi@mail.com', '46a7daf5ce4b16c0095275decea0c38dcadb6a0b', '', 'assets/images/users/blank.png', 2, '', 'default', '0', 'tqKGu9PjH1o5BQaLf4UWJp0ehTFA', 0, '2023-09-29 01:59:26', '2023-09-29 08:59:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
