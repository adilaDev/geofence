-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 25, 2023 at 09:01 AM
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
-- Table structure for table `tb_geo_draw`
--

CREATE TABLE `tb_geo_draw` (
  `id_drawing` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_polygon` text NOT NULL,
  `polygon_name` varchar(250) NOT NULL,
  `filename` varchar(250) NOT NULL,
  `link` text NOT NULL,
  `data_table` longtext NOT NULL,
  `center_point` longtext NOT NULL,
  `feature_collection` longtext NOT NULL,
  `last_update` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_geo_draw`
--
ALTER TABLE `tb_geo_draw`
  ADD PRIMARY KEY (`id_drawing`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_geo_draw`
--
ALTER TABLE `tb_geo_draw`
  MODIFY `id_drawing` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
