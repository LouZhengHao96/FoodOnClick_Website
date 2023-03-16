-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2022 at 06:44 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reservationdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `reservation_ID` int(255) NOT NULL,
  `cust_ID` varchar(999) NOT NULL,
  `user_fullname` varchar(999) NOT NULL,
  `emailAddress` varchar(999) NOT NULL,
  `phoneNumber` varchar(999) NOT NULL,
  `outletLocation` varchar(999) NOT NULL,
  `dateSlot` varchar(999) NOT NULL,
  `timeSlot` varchar(999) NOT NULL,
  `paxAmount` varchar(999) NOT NULL,
  `seatingArea` varchar(999) NOT NULL,
  `promoCode` varchar(999) NOT NULL,
  `item_1` varchar(999) NOT NULL,
  `item_2` varchar(999) NOT NULL,
  `item_3` varchar(999) NOT NULL,
  `item_4` varchar(999) NOT NULL,
  `item_5` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservation_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservation_ID` int(255) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
