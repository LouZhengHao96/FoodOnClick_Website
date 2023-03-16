-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2022 at 08:15 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id19649955_fyp2022`
--

-- --------------------------------------------------------

--
-- Table structure for table `delivery_orders`
--

CREATE TABLE `delivery_orders` (
  `orderID` int(11) NOT NULL,
  `accountID` varchar(999) NOT NULL,
  `order_date` varchar(999) NOT NULL,
  `order_time` varchar(999) NOT NULL,
  `order_price` varchar(999) NOT NULL,
  `order_status` varchar(999) NOT NULL,
  `order_promocode` varchar(999) NOT NULL,
  `order_address` varchar(999) NOT NULL,
  `order_payment` varchar(999) NOT NULL,
  `order_description` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `delivery_orders`
--

INSERT INTO `delivery_orders` (`orderID`, `accountID`, `order_date`, `order_time`, `order_price`, `order_status`, `order_promocode`, `order_address`, `order_payment`, `order_description`) VALUES
(1, '39', '2022-11-08', '11:00', '$68.80', 'Delivered', 'None', 'a b, s(s)', 'CC', '1x HAWAIIAN SALMON~~1x AVOCADO SUPREME~~1x CHOC SWEET~~2x SHOYU TUNA SPECIAL'),
(2, '39', '2022-11-09', '00:22', '$40.75', 'In-progress', 'moshiqq50', '123 Pasir Ris St 12 #03-03, s(123123)', 'CC', '1x HAWAIIAN SALMON~~1x FULL VEGGIELICIOUS~~4x SUMMER FLING~~1x SPIDEY SENSES'),
(3, '39', '2022-11-09', '00:22', '$42.40', 'In-progress', 'moshiqq50', '123 Pasir Ris St 12 #03-03, s(123123)', 'CC', '3x GG~~1x SHOYU TUNA SPECIAL~~2x CHOC SWEET~~1x SPIDEY SENSES');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `delivery_orders`
--
ALTER TABLE `delivery_orders`
  ADD PRIMARY KEY (`orderID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `delivery_orders`
--
ALTER TABLE `delivery_orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
