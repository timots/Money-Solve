-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2020 at 10:28 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nabung`
--

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `income_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `income_from` text NOT NULL,
  `income_date` date NOT NULL,
  `income_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`income_id`, `user_id`, `income_from`, `income_date`, `income_value`) VALUES
(155, 9, 'Uang jajan', '2016-12-11', 40000);

-- --------------------------------------------------------

--
-- Table structure for table `outcome`
--

CREATE TABLE `outcome` (
  `outcome_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `outcome_for` text NOT NULL,
  `outcome_date` date NOT NULL,
  `outcome_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(12) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` text NOT NULL,
  `pict` text NOT NULL,
  `goal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `fullname`, `pict`, `goal`) VALUES
(12, 'admeen', '$2y$10$m9rf//wlWFmdtxPzw0orvOIKPKFultENrtkDDAt8ZB3xy8P0rMfe2', 'Muhammad Faishal', 'upload/admeen/default.jpg', 200000),
(13, 'fe-cre', '$2y$10$Yqt.2qS.P3ewR7KySv6H2utDDh1iysZ2h.WW6skTDI.3cqN1q55QG', 'Fikri Muzaki', '', 200000);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id_barang` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_barang` text NOT NULL,
  `nominal_barang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id_barang`, `user_id`, `nama_barang`, `nominal_barang`) VALUES
(4, 12, 'RAM 2GB', 250000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`income_id`);

--
-- Indexes for table `outcome`
--
ALTER TABLE `outcome`
  ADD PRIMARY KEY (`outcome_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id_barang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `income_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;
--
-- AUTO_INCREMENT for table `outcome`
--
ALTER TABLE `outcome`
  MODIFY `outcome_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
