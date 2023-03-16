-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2022 at 08:15 AM
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
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `accountID` int(255) NOT NULL,
  `profileID` varchar(999) NOT NULL,
  `fullName` varchar(999) NOT NULL,
  `email` varchar(999) NOT NULL,
  `accountPassword` varchar(999) NOT NULL,
  `phoneNumber` varchar(999) NOT NULL,
  `accountStatus` varchar(999) NOT NULL,
  `accountDescription` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`accountID`, `profileID`, `fullName`, `email`, `accountPassword`, `phoneNumber`, `accountStatus`, `accountDescription`) VALUES
(1, 'customer', 'Alan Bobby Cedric Daniel', 'fyp2022test@gmail.com', 'fyp_22_s3_22', '91238123', 'active', 'customer'),
(3, 'admin', '', 'lucasleeht@gmail.com', 'lucas', '', 'active', 'admin'),
(35, 'staff', '', 'lucasleeht@gmail.com', 'gg', '', 'active', 'gg'),
(36, 'owner', '', 'lucasleeht@gmail.com', 'gg', '', 'active', 'gg'),
(39, 'customer', 'gg', 'lucasLEeht@gmail.com', 'gg', '12314123', 'active', 'Created by customer'),
(40, 'staff', '', '', '', '', 'active', '');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_inbox`
--

CREATE TABLE `delivery_inbox` (
  `id` int(255) NOT NULL,
  `inboxStatus` varchar(999) NOT NULL,
  `inboxDescription` varchar(999) NOT NULL,
  `inboxDate` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `delivery_inbox`
--

INSERT INTO `delivery_inbox` (`id`, `inboxStatus`, `inboxDescription`, `inboxDate`) VALUES
(1, 'Delivery', 'D1: Delivery for gg~~ at 2022/11/08~~ 11:00', '2022-11-08'),
(2, 'Delivery', 'D2: Delivery for gg~~ at 2022/11/09~~ 00:22', '2022-11-09'),
(3, 'Delivery', 'D3: Delivery for gg~~ at 2022/11/09~~ 00:22', '2022-11-09'),
(4, 'Delivery', 'D4: Delivery for gg~~ at 2022/11/11~~ 02:12', '2022-11-11');

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
(1, '39', '2022-11-01', '11:00', '$68.80', 'Delivered', 'None', 'a b, s(s)', 'CC', '1x HAWAIIAN SALMON~~1x AVOCADO SUPREME~~1x CHOC SWEET~~2x SHOYU TUNA SPECIAL'),
(2, '39', '2022-11-05', '00:22', '$40.75', 'In-progress', 'moshiqq50', '123 Pasir Ris St 12 #03-03, s(123123)', 'CC', '1x HAWAIIAN SALMON~~1x FULL VEGGIELICIOUS~~4x SUMMER FLING~~1x SPIDEY SENSES'),
(3, '39', '2022-11-22', '00:22', '$42.40', 'In-progress', 'moshiqq50', '123 Pasir Ris St 12 #03-03, s(123123)', 'CC', '3x GG~~1x SHOYU TUNA SPECIAL~~2x CHOC SWEET~~1x SPIDEY SENSES'),
(4, '39', '2022-11-11', '02:12', '$21.50', 'In-progress', 'moshiqq50', 'aba a8458 asf #123-123, s(123123)', 'Cash', '1x HAWAIIAN SALMON~~1x SPICY MIXED SALMON');

-- --------------------------------------------------------

--
-- Table structure for table `menu_item`
--

CREATE TABLE `menu_item` (
  `menu_item_ID` int(255) NOT NULL,
  `item_category` varchar(999) NOT NULL,
  `item_name` varchar(999) NOT NULL,
  `item_description` varchar(999) NOT NULL,
  `item_picture` varchar(999) NOT NULL,
  `item_price` varchar(999) NOT NULL,
  `item_stock` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu_item`
--

INSERT INTO `menu_item` (`menu_item_ID`, `item_category`, `item_name`, `item_description`, `item_picture`, `item_price`, `item_stock`) VALUES
(1, 'signature', 'HAWAIIAN SALMON', 'The go-to option for those who love a hawaiian kick with the flavourish salmon!', '../MoshiQ2 IMG Assets/Menu/Hawaiian Salmon.png', '15.50', '16'),
(2, 'signature', 'COLOURFUL GODDESS', 'Our classic goddess bowl that will most definitely make your mouth water! Comes with 7 toppings and 2 garnishes.', '../MoshiQ2 IMG Assets/Menu/Colourful Goddess.png', '15.50', '0'),
(5, 'signature', 'SPICY MIXED SALMON', 'A touch of spice on your fresh bowl of salmon will bring forth a wave of flavour!', '../MoshiQ2 IMG Assets/Menu/Spicy Mixed Salmon.png', '15.50', '20'),
(7, 'diy', 'SHOYU TUNA SPECIAL', 'Sweet and salty makes the umami go crazy on your tastebuds.', '../MoshiQ2 IMG Assets/Menu/Shoyu Tuna Specials.png', '12.80', '10'),
(8, 'diy', 'FULL VEGGIELICIOUS', 'For the vege lovers out there this dish is made just for you!', '../MoshiQ2 IMG Assets/Menu/Full Vegelicious.png', '12.80', '12'),
(9, 'diy', 'AVOCADO SUPREME', 'Avocado Loveacado is there anything you can hate about it?', '../MoshiQ2 IMG Assets/Menu/Avocado Supreme.png', '12.80', '11'),
(10, 'acai', 'SUMMER FLING', 'This dish embodies the hot passionate summer time we had back in the day!', '../MoshiQ2 IMG Assets/Menu/Summer Fling.png', '8.90', '30'),
(11, 'acai', 'CHOC SWEET', 'Chocolate is always the number one dessert!', '../MoshiQ2 IMG Assets/Menu/Choc Sweet.png', '8.90', '40'),
(12, 'acai', 'CARAMEL NUTTIN', 'Nuts make the world go nuts. ', '../MoshiQ2 IMG Assets/Menu/Caramel Nuttin.png', '9.80', '20'),
(13, 'beverages', 'INCREDIBLE HULK', 'This drink has a secret that is only known when you try it!', '../MoshiQ2 IMG Assets/Menu/Incredible Hulk.png', '6.90', '0'),
(14, 'beverages', 'ORANGE MADNESS', 'Orange you glad that you got this?', '../MoshiQ2 IMG Assets/Menu/Orange Madness.png', '5.60', '25'),
(15, 'beverages', 'SPIDEY SENSES', 'All it takes is a leap of faith to bring your senses to a new world!', '../MoshiQ2 IMG Assets/Menu/Spidey Senses.png', '5.60', '33');

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
(1, 'moshiqq50', '50', '../MoshiQ2 IMG Assets/Promo code 1.png', '2022-11-07', '2022-11-25', 'on all orders - Grand Opening Exclusive'),
(3, '', '30', '../MoshiQ2 IMG Assets/Promo code 2.png', '2022-11-09', '2022-11-30', 'on Fresh MoshiQ2 Beverages - Dine-in Exclusive');

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
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservation_ID`, `cust_ID`, `user_fullname`, `emailAddress`, `phoneNumber`, `outletLocation`, `dateSlot`, `timeSlot`, `paxAmount`, `seatingArea`, `promoCode`, `item_1`, `item_2`, `item_3`, `item_4`, `item_5`) VALUES
(8, '39', 'lucasleeht@gmail.com', 'lucasleeht@gmail.com', '12341234', 'CHANGI', '2022-11-25', 'timeSlot1', '1', 'B', 'moshiqq50', 'none', 'none', 'none', 'none', 'none');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_inbox`
--

CREATE TABLE `reservation_inbox` (
  `id` int(255) NOT NULL,
  `inboxStatus` varchar(999) NOT NULL,
  `inboxDescription` varchar(999) NOT NULL,
  `inboxDate` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservation_inbox`
--

INSERT INTO `reservation_inbox` (`id`, `inboxStatus`, `inboxDescription`, `inboxDate`) VALUES
(1, 'Reservation', 'R1: Reservation for lucas~~ at 2022/11/07~~ 13:00~~ for 2(C)', '2022/11/03'),
(2, 'Reservation', 'R2: Reservation for a~~ at 2022/11/08~~ 11:00~~ for 4(D)', '2022/11/04'),
(3, 'Reservation', 'R2: Reservation for b~~ at 2022/11/16~~ 15:00~~ for 4(D)', '2022/11/08'),
(4, 'Reservation', 'R2: Reservation for gg~~ at 2022/11/13~~ 11:00~~ for 5+(B~~ F~~ I)', '2022/11/08'),
(5, 'Reservation', 'R1: Reservation for b~~ at 2022/11/13~~ 11:00~~ for 5+(C~~ F)', '2022/11/08'),
(6, 'Reservation', 'R6: Reservation for gg~~ at 2022/11/13~~ 11:00~~ for 5+(D~~ E~~ J)', '2022/11/08'),
(7, 'Reservation', 'R1: Reservation for aa~~ at 2022/11/13~~ 11:00~~ for 5+(D~~ E~~ G~~ J)', '2022/11/08'),
(8, 'Reservation', 'R8: Reservation for lucasleeht@gmail.com~~ at 2022/11/13~~ 11:00~~ for 1(B)', '2022/11/09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`accountID`);

--
-- Indexes for table `delivery_inbox`
--
ALTER TABLE `delivery_inbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_orders`
--
ALTER TABLE `delivery_orders`
  ADD PRIMARY KEY (`orderID`);

--
-- Indexes for table `menu_item`
--
ALTER TABLE `menu_item`
  ADD PRIMARY KEY (`menu_item_ID`);

--
-- Indexes for table `promocodes`
--
ALTER TABLE `promocodes`
  ADD PRIMARY KEY (`promoID`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservation_ID`);

--
-- Indexes for table `reservation_inbox`
--
ALTER TABLE `reservation_inbox`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `accountID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `delivery_inbox`
--
ALTER TABLE `delivery_inbox`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `delivery_orders`
--
ALTER TABLE `delivery_orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `menu_item`
--
ALTER TABLE `menu_item`
  MODIFY `menu_item_ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `promocodes`
--
ALTER TABLE `promocodes`
  MODIFY `promoID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservation_ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `reservation_inbox`
--
ALTER TABLE `reservation_inbox`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
