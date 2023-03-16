-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2022 at 10:45 AM
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
(1, 'signature', 'HAWAIIAN SALMON', 'The go-to option for those who love a hawaiian kick with the flavourish salmon!', '/fyp_codes/MoshiQ2 Assets/Menu/Hawaiian Salmon.png', '15.50', 'Available'),
(2, 'signature', 'COLOURFUL GODDESS', 'Our classic goddess bowl that will most definitely make your mouth water! Comes with 7 toppings and 2 garnishes.', '/fyp_codes/MoshiQ2 Assets/Menu/Colourful Goddess.png', '15.50', 'Unavailable'),
(5, 'signature', 'SPICY MIXED SALMON', 'A touch of spice on your fresh bowl of salmon will bring forth a wave of flavour!', '/fyp_codes/MoshiQ2 Assets/Menu/Spicy Mixed Salmon.png', '15.50', 'Available'),
(7, 'diy', 'SHOYU TUNA SPECIAL', 'Sweet and salty makes the umami go crazy on your tastebuds.', '/fyp_codes/MoshiQ2 Assets/Menu/Shoyu Tuna Specials.png', '12.80', 'Unavailable'),
(8, 'diy', 'FULL VEGGIELICIOUS', 'For the vege lovers out there this dish is made just for you!', '/fyp_codes/MoshiQ2 Assets/Menu/Full Vegelicious.png', '12.80', 'Available'),
(9, 'diy', 'AVOCADO SUPREME', 'Avocado Loveacado is there anything you can hate about it?', '/fyp_codes/MoshiQ2 Assets/Menu/Avocado Supreme.png', '12.80', 'Available'),
(10, 'acai', 'SUMMER FLING', 'This dish embodies the hot passionate summer time we had back in the day!', '/fyp_codes/MoshiQ2 Assets/Menu/Summer Fling.png', '8.90', 'Available'),
(11, 'acai', 'CHOC SWEET', 'Chocolate is always the number one dessert!', '/fyp_codes/MoshiQ2 Assets/Menu/Choc Sweet.png', '8.90', 'Available'),
(12, 'acai', 'CARAMEL NUTTIN', 'Nuts make the world go nuts. ', '/fyp_codes/MoshiQ2 Assets/Menu/Caramel Nuttin.png', '9.80', 'Available'),
(13, 'beverages', 'INCREDIBLE HULK', 'This drink has a secret that is only known when you try it!', '/fyp_codes/MoshiQ2 Assets/Menu/Incredible Hulk.png', '6.90', 'Available'),
(14, 'beverages', 'ORANGE MADNESS', 'Orange you glad that you got this?', '/fyp_codes/MoshiQ2 Assets/Menu/Orange Madness.png', '5.60', 'Available'),
(15, 'beverages', 'SPIDEY SENSES', 'All it takes is a leap of faith to bring your senses to a new world!', '/fyp_codes/MoshiQ2 Assets/Menu/Spidey Senses.png', '5.60', 'Available');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu_item`
--
ALTER TABLE `menu_item`
  ADD PRIMARY KEY (`menu_item_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu_item`
--
ALTER TABLE `menu_item`
  MODIFY `menu_item_ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
