-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 10, 2022 at 12:47 PM
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
(1, 'admin', 'fyp_group', 'fyp2022test@gmail.com', 'fyp_22_s3_22', '99999999', 'active', 'test email'),
(4, 'customer', 'lu', 'lu@gmail.com', 'lu', '99889988', 'Active', 'Created by customer'),
(5, 'admin', '', 'nicadmin@gmail.com', 'password', '', 'active', 'this is an admin account'),
(6, 'staff', '', 'leonng1191@gmail.com', 'leon', '', 'active', ''),
(7, 'staff', '', 'nicstaff@gmail.com', 'password', '', 'active', 'this is a staff account'),
(8, 'owner', '', 'leonng1191@gmail.com', 'leon', '', 'active', 'owner no.1'),
(9, 'staff', '', 'melvin@gmail.com', 'hello', '', 'active', 'hello'),
(11, 'customer', 'Nicholas Tan Yu Shu', 'niccustomer@gmail.com', 'password', '83881460', 'active', 'this is a customer profile'),
(12, 'owner', '', 'nicowner@gmail.com', 'password', '', 'active', 'this is an owner account'),
(15, 'customer', 'Ebenezer Phua', 'ebecustomer@gmail.com', 'password', '12345678', 'active', 'Created by customer'),
(17, 'customer', 'Sakura', 'sakuramiyazaki@gmail.com', 'sakura12345', '86532156', 'active', 'Created by customer'),
(18, 'admin', '', 'leonng1191@gmail.com', 'leon', '', 'active', 'admin no.2'),
(19, 'customer', 'leon', 'leonng1191@gmail.com', 'leon', '90901234', 'active', 'customer no.'),
(21, 'customer', 'Shao Wen', 'shaowen@gmail.com', 'moshiq', '90927462', 'active', 'Created by customer'),
(22, 'customer', 'Karen', 'kkarenn@gmail.com', 'moshiq', '99847284', 'active', 'Created by customer'),
(23, 'customer', 'Wei Jie', 'weijie92@gmail.com', 'moshiq', '82847161', 'active', 'Created by customer'),
(24, 'customer', 'Zane', 'zane@hotmail.com', 'moshiq', '90948275', 'active', 'Created by customer'),
(25, 'customer', 'Yshtola', 'yshtola@gmail.com', 'moshiq', '98472958', 'active', 'Created by customer'),
(26, 'customer', 'Thancred', 'thancred@gmail.com', 'moshiq', '82746174', 'active', 'Created by customer'),
(27, 'customer', 'Ryan', 'ryanson96@gmail.com', 'moshiq', '89102948', 'active', 'Created by customer'),
(28, 'customer', 'Jakob', 'purplejakob@gmail.com', 'moshiq', '82756472', 'active', 'Created by customer'),
(29, 'customer', 'Dale', 'errxn@icloud.com', 'moshiq', '90581783', 'active', 'Created by customer'),
(30, 'customer', 'Beau', 'ilikered@live.com', 'moshiq', '84917284', 'active', 'Created by customer'),
(31, 'customer', 'Cliff', 'uncle@yahoo.com', 'moshiq', '92818591', 'active', 'Created by customer'),
(32, 'customer', 'Timothy', 'fmtbebuck@msn.com', 'moshiq', '92580182', 'active', 'Created by customer'),
(33, 'customer', 'Raphael', 'kdawson@gmail.com', 'moshiq', '89583721', 'active', 'Created by customer'),
(34, 'customer', 'Brain', 'dcoppit@gmail.com', 'moshiq', '89048172', 'active', 'Created by customer'),
(35, 'customer', 'Mauro', 'bsikdar@live.com', 'moshiq', '90987647', 'active', 'Created by customer'),
(36, 'customer', 'Luke', 'jimxugle@live.com', 'moshiq', '90827584', 'active', 'Created by customer'),
(37, 'customer', 'Myron', 'fhirsch@optonline.com', 'moshiq', '90484715', 'active', 'Created by customer'),
(38, 'customer', 'Omar', 'kwilliams@yahoo.com', 'moshiq', '92857361', 'active', 'Created by customer'),
(39, 'customer', 'Reynaldo', 'emmanuel@yahoo.com', 'moshiq', '92049581', 'active', 'Created by customer'),
(40, 'customer', 'Major', 'crimsane@yahoo.com', 'moshiq', '89581722', 'active', 'Created by customer'),
(41, 'customer', 'Clinton', 'maratb@comcast.com', 'moshiq', '84918274', 'active', 'Created by customer'),
(42, 'customer', 'Nolan', 'dexter@verizon.com', 'moshiq', '95837183', 'active', 'Created by customer'),
(43, 'customer', 'Raymond', 'jelmer@yahoo.com', 'moshiq', '89587251', 'active', 'Created by customer'),
(44, 'customer', 'Lucien', 'zilla@hotmail.com', 'moshiq', '88275817', 'active', 'Created by customer'),
(45, 'customer', 'Carey', 'storerm@hotmail.com', 'moshiq', '84758675', 'active', 'Created by customer'),
(46, 'customer', 'Winfred', 'parsimony@yahoo.com', 'moshiq', '98274857', 'active', 'Created by customer'),
(47, 'customer', 'Dan', 'miltchev@hotmail.com', 'moshiq', '88275617', 'active', 'Created by customer'),
(48, 'customer', 'Abel', 'seanq@verizon.com', 'moshiq', '82948571', 'active', 'Created by customer'),
(49, 'customer', 'Elliott', 'jschauma@msn.com', 'moshiq', '82759172', 'active', 'Created by customer'),
(50, 'customer', 'Brent', 'tromey@icloud.com', 'moshiq', '89948172', 'active', 'Created by customer'),
(51, 'customer', 'Chuck', 'webteam@msn.com', 'moshiq', '90948172', 'active', 'Created by customer'),
(52, 'customer', 'Dirk', 'doormat@msn.com', 'moshiq', '90394857', 'active', 'Created by customer'),
(53, 'customer', 'Tod', 'dwendlan@verizon.com', 'moshiq', '92847182', 'active', 'Created by customer'),
(54, 'customer', 'Emerson', 'temmink@aol.com', 'moshiq', '94827481', 'active', 'Created by customer'),
(55, 'customer', 'Dewey', 'hauma@sbcglobal.com', 'moshiq', '98475831', 'active', 'Created by customer'),
(56, 'customer', 'Scot', 'openldap@icloud.com', 'moshiq', '90395837', 'active', 'Created by customer'),
(57, 'customer', 'Enrique', 'mrobshaw@verizon.com', 'moshiq', '88984751', 'active', 'Created by customer'),
(58, 'customer', 'Al', 'kjetilk@outlook.com', 'moshiq', '81928473', 'active', 'Created by customer'),
(59, 'customer', 'Beatrice', 'naupa@icloud.com', 'moshiq', '80938573', 'active', 'Created by customer'),
(60, 'customer', 'Brandy', 'alias@icloud.com', 'moshiq', '87857461', 'active', 'Created by customer'),
(61, 'customer', 'Kathy', 'iamcal@yahoo.com', 'moshiq', '98984758', 'active', 'Created by customer'),
(62, 'customer', 'Jane', 'brbarret@att.com', 'moshiq', '99827461', 'active', 'Created by customer'),
(63, 'customer', 'Marcy', 'mhouston@mac.com', 'moshiq', '98927481', 'active', 'Created by customer'),
(64, 'customer', 'Shelly', 'claesjac@att.com', 'moshiq', '98645234', 'active', 'Created by customer'),
(65, 'customer', 'Lucy', 'feamster@verizon.com', 'moshiq', '99876753', 'active', 'Created by customer'),
(66, 'customer', 'Cathy', 'privcan@outlook.com', 'moshiq', '87267162', 'active', 'Created by customer'),
(67, 'customer', 'Joanna', 'joehall@comcast.com', 'moshiq', '92172631', 'active', 'Created by customer'),
(68, 'customer', 'Doris', 'bester@yahoo.com', 'moshiq', '90234714', 'active', 'Created by customer'),
(69, 'customer', 'Lindsay', 'pkplex@comcast.com', 'moshiq', '84917285', 'active', 'Created by customer'),
(70, 'customer', 'Staci', 'ralamosm@optonline.com', 'moshiq', '92847581', 'active', 'Created by customer'),
(71, 'customer', 'Shelia', 'eimear@mac.com', 'moshiq', '82038947', 'active', 'Created by customer'),
(72, 'customer', 'Rosanne', 'thrymm@live.com', 'moshiq', '91928475', 'active', 'Created by customer'),
(73, 'customer', 'Rebecca', 'nighthawk@outlook.com', 'moshiq', '88274621', 'active', 'Created by customer'),
(74, 'customer', 'Luz', 'kidehen@outlook.com', 'moshiq', '83918273', 'active', 'Created by customer'),
(75, 'customer', 'Flora', 'webinc@mac.com', 'moshiq', '90987182', 'active', 'Created by customer'),
(76, 'customer', 'Alexandra', 'jaffe@mac.com', 'moshiq', '84428576', 'active', 'Created by customer'),
(77, 'customer', 'Marina', 'alastair@optonline.com', 'moshiq', '85547361', 'active', 'Created by customer'),
(78, 'customer', 'Lorraine', 'eabrown@live.com', 'moshiq', '90192471', 'active', 'Created by customer'),
(79, 'customer', 'Sybil', 'bastian@gmail.com', 'moshiq', '98278491', 'active', 'Created by customer'),
(80, 'customer', 'Adeline', 'cgarcia@icloud.com', 'moshiq', '83918275', 'active', 'Created by customer'),
(81, 'customer', 'Taylor', 'enintend@verizon.com', 'moshiq', '90491827', 'active', 'Created by customer'),
(82, 'customer', 'Anita', 'martyloo@yahoo.com', 'moshiq', '87472182', 'active', 'Created by customer'),
(83, 'customer', 'Aurora', 'niknejad@aol.com', 'moshiq', '98746718', 'active', 'Created by customer'),
(84, 'customer', 'Neva', 'jgmyers@me.com', 'moshiq', '90859381', 'active', 'Created by customer'),
(85, 'customer', 'Alisha', 'jusdisgi@verizon.com', 'moshiq', '87898724', 'active', 'Created by customer'),
(86, 'customer', 'Maria', 'mwitte@yahoo.com', 'moshiq', '88987461', 'active', 'Created by customer'),
(87, 'customer', 'Erna', 'bdbrown@optonline.com', 'moshiq', '99829384', 'active', 'Created by customer'),
(88, 'customer', 'Gwendolyn', 'tromey@comcast.com', 'moshiq', '89987265', 'active', 'Created by customer'),
(89, 'customer', 'Brenda', 'jaxweb@att.com', 'moshiq', '81882746', 'active', 'Created by customer'),
(90, 'customer', 'Bethany', 'dsowsy@mac.com', 'moshiq', '90987261', 'active', 'Created by customer'),
(91, 'customer', 'Sybil', 'slaff@yahoo.com', 'moshiq', '87689481', 'active', 'Created by customer'),
(92, 'customer', 'Earline', 'petersen@mac.com', 'moshiq', '99829102', 'active', 'Created by customer'),
(93, 'customer', 'June', 'meinkej@mac.com', 'moshiq', '90594812', 'active', 'Created by customer'),
(94, 'customer', 'Brandy', 'loscar@me.com', 'moshiq', '90491824', 'active', 'Created by customer'),
(95, 'customer', 'Sue', 'lishoy@aol.com', 'moshiq', '84718273', 'active', 'Created by customer'),
(96, 'customer', 'Thomas Shelby ', 'tshelby@gmail.com', 'moshiq', '82347521', 'active', 'Created by customer'),
(97, 'owner', '', 'jeremy@gmail.com', 'hello', '', 'active', 'hello'),
(98, 'customer', 'Pavithra', 'pxvithrx@gmail.com', 'hello', '98213243', 'active', 'Created by customer'),
(99, 'owner', '', '', '', '', 'active', ''),
(100, 'customer', 'louzhenghao123', 'steamaddress06@gmail.com', 'lzh', '90909090', 'active', 'Created by customer'),
(101, 'staff', '', 'thomas.moshiqqstaff@gmail.com', 'moshiq', '', 'suspended', 'Will be in charged of handling reservations'),
(102, 'admin', '', 'pxvithrx@gmail.com', 'hello', '', 'active', 'hello'),
(103, 'owner', '', 'pxvithrx@gmail.com', 'hello', '', 'active', 'hello');

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
(1, 'Delivery', 'D1: Delivery for leon~~ at 2022/11/23~~ 11:00', '2022-11-23'),
(2, 'Delivery', 'D2: Delivery for leon~~ at 2022/11/09~~ 20:00', '2022-11-09'),
(3, 'Delivery', 'D2: Delivery for Pavithra~~ at 2022/11/30~~ 16:00', '2022-11-30'),
(4, 'Delivery', 'D4: Delivery for ~~ at 2022/11/10~~ 20:00', '2022-11-10'),
(5, 'Delivery', 'D5: Delivery for ~~ at 2022/11/15~~ 11:00', '2022-11-15');

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
(1, '19', '2022-11-23', '11:00', '$21.50', 'Delivered', 'None', 'Test address Test address, s(Testcode)', 'CC', '1x HAWAIIAN SALMON'),
(3, '98', '2022-11-30', '16:00', '$21.50', 'In-progress', 'None', 'Blk 218 Sentosa Drive 12-121, s(642311)', 'CC', '1x HAWAIIAN SALMON'),
(4, '8', '2022-11-10', '20:00', '$52.50', 'In-progress', 'None', 'Test address Test address, s(Testcode)', 'CC', '3x HAWAIIAN SALMON'),
(5, '8', '2022-11-15', '11:00', '$37.00', 'In-progress', 'None', 'Test address Test address, s(Testcode)', 'CC', '1x HAWAIIAN SALMON~~1x COLOURFUL GODDESS');

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
(1, 'signature', 'HAWAIIAN SALMON', 'The go-to option for those who love a hawaiian kick with the flavourish salmon!', '../MoshiQ2 IMG Assets/Menu/Hawaiian Salmon.png', '15.50', '2'),
(2, 'signature', 'COLOURFUL GODDESS', 'Our classic goddess bowl that will most definitely make your mouth water! Comes with 7 toppings and 2 garnishes.', '../MoshiQ2 IMG Assets/Menu/Colourful Goddess.png', '15.50', '4'),
(5, 'signature', 'SPICY MIXED SALMON', 'A touch of spice on your fresh bowl of salmon will bring forth a wave of flavour!', '../MoshiQ2 IMG Assets/Menu/Spicy Mixed Salmon.png', '15.50', '20'),
(7, 'diy', 'SHOYU TUNA SPECIAL', 'Sweet and salty makes the umami go crazy on your tastebuds.', '../MoshiQ2 IMG Assets/Menu/Shoyu Tuna Specials.png', '12.80', '3'),
(8, 'diy', 'FULL VEGGIELICIOUS', 'For the vege lovers out there this dish is made just for you!', '../MoshiQ2 IMG Assets/Menu/Full Vegelicious.png', '12.80', '0'),
(9, 'diy', 'AVOCADO SUPREME', 'Avocado Loveacado is there anything you can hate about it?', '../MoshiQ2 IMG Assets/Menu/Avocado Supreme.png', '12.80', '22'),
(10, 'acai', 'SUMMER FLING', 'This dish embodies the hot passionate summer time we had back in the day!', '../MoshiQ2 IMG Assets/Menu/Summer Fling.png', '8.90', '10'),
(11, 'acai', 'CHOC SWEET', 'Chocolate is always the number one dessert!', '../MoshiQ2 IMG Assets/Menu/Choc Sweet.png', '8.90', '11'),
(12, 'acai', 'CARAMEL NUTTIN', 'Nuts make the world go nuts. ', '../MoshiQ2 IMG Assets/Menu/Caramel Nuttin.png', '9.80', '0'),
(13, 'beverages', 'INCREDIBLE HULK', 'This drink has a secret that is only known when you try it!', '../MoshiQ2 IMG Assets/Menu/Incredible Hulk.png', '6.90', '23'),
(14, 'beverages', 'ORANGE MADNESS', 'Orange you glad that you got this?', '../MoshiQ2 IMG Assets/Menu/Orange Madness.png', '5.60', '5'),
(15, 'beverages', 'SPIDEY SENSES', 'All it takes is a leap of faith to bring your senses to a new world!', '../MoshiQ2 IMG Assets/Menu/Spidey Senses.png', '5.60', '6'),
(18, 'diy', 'SALAD', 'Mix of nutrients', '../MoshiQ2 IMG Assets/Menu/salad.jpg', '5.50', '20'),
(21, 'acai', 'SALAD TEST 2', 'Mix of nutrients', '../MoshiQ2 IMG Assets/Menu/salad.jpg', '5.50', '20');

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
(3, '', '30', '../MoshiQ2 IMG Assets/Promo code 2.png', '2022-11-02', '2023-11-26', 'OFF on Fresh MoshiQ2 Beverages - Dine-in Exclusive'),
(6, '11 november exclusive', '20', '../MoshiQ2 IMG Assets/11 nov.jpg', '2022-11-11', '2022-11-11', 'specially for 11 november only');

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
(1, '2', 'leon', 'leonng1190@gmail.com', '90901010', 'TAMPINES', '2022-11-11', 'timeSlot1', '1', 'B', 'none', 'Hawaiian Salmon', 'Colourful Goddess', 'Shoyu Tuna Specials', 'Summer Fling', 'Spidey Senses'),
(2, '11', 'Nicholas Tan Yu Shu', 'niccustomer@gmail.com', '83881460', 'TAMPINES', '2022-11-12', 'timeSlot1', '1', 'B', 'none', 'Hawaiian Salmon', 'none', 'none', 'none', 'none'),
(4, '17', 'Sakura', 'sakuramiyazaki@gmail.com', '83455667', 'TAMPINES', '2022-11-15', 'timeSlot1', '1', 'B', 'none', 'none', 'none', 'none', 'none', 'Spidey Senses'),
(10, '98', 'Pavithra', 'pxvithrx@gmail.com', '54', 'CHANGI', '2022-11-13', 'timeSlot1', '3', 'D', 'none', 'none', 'none', 'none', 'none', 'Spidey Senses'),
(11, '100', 'zhenghao me', 'steamaddress06@gmail.com', '90909090', 'CHANGI', '2022-11-14', 'timeSlot1', '2', 'B', 'none', 'Hawaiian Salmon', 'none', 'none', 'none', 'none'),
(12, '8', 'leon', 'leonng1191@gmail.com', '90901010', 'CHANGI', '2022-11-15', 'timeSlot1', '4', 'D', 'none', 'none', 'none', 'none', 'none', 'none'),
(13, '98', 'Pavithra', 'pxvithrx@gmail.com', '82312334', 'KALLANG', '2022-11-30', 'timeSlot8', '3', 'D', 'none', 'none', 'Colourful Goddess', 'none', 'none', 'none');

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
(1, 'Reservation', 'R1: Reservation for leon~~ at 2022/11/11~~ 11:00~~ for 1(B)', '2022/11/07'),
(2, 'Reservation', 'R2: Reservation for Nicholas Tan Yu Shu~~ at 2022/11/12~~ 11:00~~ for 1(B)', '2022/11/07'),
(3, 'Reservation', 'R3: Reservation for Pavithra~~ at 2022/11/28~~ 18:00~~ for 2(B)', '2022/11/08'),
(4, 'Reservation', 'R3: Reservation for Sakura~~ at 2022/11/15~~ 11:00~~ for 1(B)', '2022/11/08'),
(5, 'Reservation', 'R5: Reservation for Pavithra~~ at 2022/11/13~~ 11:00~~ for 3(D)', '2022/11/08'),
(6, 'Reservation', 'R6: Reservation for Pavithra~~ at 2022/11/26~~ 19:00~~ for 5+(D~~ G)', '2022/11/08'),
(7, 'Reservation', 'R7: Reservation for leon~~ at 2022/11/19~~ 13:00~~ for 4(A)', '2022/11/09'),
(8, 'Reservation', 'R8: Reservation for Pavithra~~ at 2022/11/22~~ 18:00~~ for 3(D)', '2022/11/09'),
(9, 'Reservation', 'R8: Reservation for Pavithra~~ at 2022/11/13~~ 11:00~~ for 1(B)', '2022/11/09'),
(10, 'Reservation', 'R8: Reservation for Pavithra~~ at 2022/11/13~~ 11:00~~ for 3(D)', '2022/11/09'),
(11, 'Reservation', 'R11: Reservation for zhenghao me~~ at 2022/11/14~~ 11:00~~ for 2(B)', '2022/11/09'),
(12, 'Reservation', 'R12: Reservation for leon~~ at 2022/11/15~~ 11:00~~ for 1(B)', '2022/11/10'),
(13, 'Reservation', 'R13: Reservation for Pavithra~~ at 2022/11/30~~ 18:00~~ for 3(D)', '2022/11/10');

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
  MODIFY `accountID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `delivery_inbox`
--
ALTER TABLE `delivery_inbox`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `delivery_orders`
--
ALTER TABLE `delivery_orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `menu_item`
--
ALTER TABLE `menu_item`
  MODIFY `menu_item_ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `promocodes`
--
ALTER TABLE `promocodes`
  MODIFY `promoID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservation_ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `reservation_inbox`
--
ALTER TABLE `reservation_inbox`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
