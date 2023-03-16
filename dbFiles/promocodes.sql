-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 07, 2022 at 05:46 AM
-- Server version: 10.5.16-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u683387266_fyp_2022`
--

-- --------------------------------------------------------

--
-- Table structure for table `promocodes`
--

CREATE TABLE `promocodes` (
  `promoID` int(255) NOT NULL,
  `codeName` varchar(999) NOT NULL,
  `discountRate` varchar(999) NOT NULL,
  `imgFile` varchar(999) NOT NULL,
  `fromDate` varchar(999) NOT NULL,
  `toDate` varchar(999) NOT NULL,
  `promoDescription` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `promocodes`
--

INSERT INTO `promocodes` (`promoID`, `codeName`, `discountRate`, `imgFile`, `fromDate`, `toDate`, `promoDescription`) VALUES
(1, 'moshiqq50', '50', '../MoshiQ2 IMG Assets/Promo code 1.png', '2022-11-01', '2023-11-25', 'OFF on all orders - Grand Opening Exclusive'),
(3, '', '30', '../MoshiQ2 IMG Assets/Promo code 2.png', '2022-11-02', '2023-11-26', 'OFF on Fresh MoshiQ2 Beverages - Dine-in Exclusive');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `promocodes`
--
ALTER TABLE `promocodes`
  ADD PRIMARY KEY (`promoID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `promocodes`
--
ALTER TABLE `promocodes`
  MODIFY `promoID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
