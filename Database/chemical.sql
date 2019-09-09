-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2019 at 11:32 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chemical`
--

-- --------------------------------------------------------

--
-- Table structure for table `chemical_profile`
--

CREATE TABLE `chemical_profile` (
  `no_id` varchar(30) NOT NULL,
  `2nd_id` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `nomat` varchar(10) DEFAULT NULL,
  `brand` varchar(10) DEFAULT NULL,
  `brand2` varchar(50) DEFAULT NULL,
  `min_stock` int(11) DEFAULT NULL,
  `unit` varchar(10) DEFAULT NULL,
  `loc` varchar(10) DEFAULT NULL,
  `user` varchar(50) DEFAULT NULL,
  `last_date` timestamp NULL DEFAULT NULL,
  `act` varchar(10) DEFAULT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chemical_profile`
--

INSERT INTO `chemical_profile` (`no_id`, `2nd_id`, `name`, `nomat`, `brand`, `brand2`, `min_stock`, `unit`, `loc`, `user`, `last_date`, `act`, `qty`) VALUES
('001', NULL, 'test', '222', 'FILMA', NULL, 3, 'btl', 'i9', 'admin', '2019-09-09 09:23:29', 'add', 1),
('002', NULL, 'test2', '1234', 'test', NULL, 2, 'btl', 'i9', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `exp`
--

CREATE TABLE `exp` (
  `no_id` varchar(15) DEFAULT NULL,
  `2nd_id` varchar(50) DEFAULT NULL,
  `no` int(11) NOT NULL,
  `exp_date` date DEFAULT NULL,
  `stock` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exp`
--

INSERT INTO `exp` (`no_id`, `2nd_id`, `no`, `exp_date`, `stock`) VALUES
('001', '', 35, '2020-01-01', '1'),
('002', NULL, 36, '2019-08-08', '1');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `no_id` varchar(15) DEFAULT NULL,
  `2nd_id` varchar(50) DEFAULT NULL,
  `first_stock` int(11) DEFAULT NULL,
  `adding` int(11) DEFAULT NULL,
  `take` int(11) DEFAULT NULL,
  `last_stock` int(11) DEFAULT NULL,
  `percentage` int(11) DEFAULT NULL,
  `stat_stock` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`no_id`, `2nd_id`, `first_stock`, `adding`, `take`, `last_stock`, `percentage`, `stat_stock`) VALUES
('001', NULL, 2, 1, 2, 1, 33, 'Under Safe'),
('002', NULL, 1, NULL, NULL, 1, 50, 'Expired');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chemical_profile`
--
ALTER TABLE `chemical_profile`
  ADD PRIMARY KEY (`no_id`),
  ADD KEY `2nd_id_2` (`2nd_id`);

--
-- Indexes for table `exp`
--
ALTER TABLE `exp`
  ADD PRIMARY KEY (`no`),
  ADD KEY `no_id` (`no_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD KEY `no_id` (`no_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exp`
--
ALTER TABLE `exp`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exp`
--
ALTER TABLE `exp`
  ADD CONSTRAINT `exp_ibfk_1` FOREIGN KEY (`no_id`) REFERENCES `chemical_profile` (`no_id`) ON DELETE CASCADE;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`no_id`) REFERENCES `chemical_profile` (`no_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
