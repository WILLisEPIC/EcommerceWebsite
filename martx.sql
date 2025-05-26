-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2024 at 07:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `martx`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Name` varchar(5) NOT NULL,
  `Password` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Name`, `Password`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cartID`, `UserID`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `cartitems`
--

CREATE TABLE `cartitems` (
  `CID` int(11) NOT NULL,
  `cartID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemID` int(11) NOT NULL,
  `itemName` varchar(255) NOT NULL,
  `itemCategory` varchar(100) NOT NULL,
  `itemBrand` varchar(100) NOT NULL,
  `itemPrice` int(11) NOT NULL,
  `itemQuantity` int(11) NOT NULL,
  `itemPhoto` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemID`, `itemName`, `itemCategory`, `itemBrand`, `itemPrice`, `itemQuantity`, `itemPhoto`) VALUES
(1, 'Television', 'HomeAppliances', 'Sony', 430, 4, 0x736f6e7954562e6a7067),
(2, 'Smart French Door Refrigerator', 'HomeAppliances', 'Samsung', 900, 2, 0x536d617274204672656e636820446f6f7220526566726967657261746f722e6a7067),
(3, 'Washing Machine', 'HomeAppliances', 'LG', 640, 4, 0x4c472057617368696e67204d616368696e652e706e67),
(4, 'Illusion 01 Sunglasses', 'Accessories', 'Gentle Monster', 230, 7, 0x696c6c7573696f6e2030312073756e676c61737365732e6a7067),
(5, 'Men Wallet', 'Accessories', 'Stussy', 410, 7, 0x6d656e2077616c6c6574207374757373792e6a7067),
(6, 'Mini Bag', 'Accessories', 'Versace', 1499, 2, 0x76657273616365206d696e69206261672e6a7067),
(7, 'Transparent Grey Sunglasses', 'Accessories', 'Versace', 899, 3, 0x76657273616365207472616e73706172656e7420677265792073756e676c61737365732e6a7067),
(8, 'Denim Size Sticker Baggy Pants', 'Clothing', 'H&M', 88, 5, 0x44656e696d2053697a6520537469636b6572204261676770792050616e74732e6a7067),
(9, 'Nike Big Swoosh Reversible Boa Jacket', 'Clothing', 'Nike', 310, 5, 0x6e696b65206269672073776f6f73682072657665727369626c6520626f61206a61636b65742e6a7067),
(10, '8 Ball Sherpa Reversible Jacket', 'Clothing', 'Stussy', 599, 3, 0x5374757373795f385f42616c6c5f5368657270615f52657665727369626c655f4a61636b65742e6a706567),
(11, 'Terry Polo Shirt', 'Clothing', 'H&M', 119, 3, 0x746572727920706f6c6f2073686972742068266d2e6a7067),
(12, 'Skirt', 'Clothing', 'Zara', 149, 3, 0x7a61726120736b6972742e6a7067),
(13, 'Bagless Canister Vacuum Cleaner', 'HomeAppliances', 'Eureka', 499, 3, 0x457572656b61204261676c6573732043616e69737465722056616375756d20436c65616e65722e6a7067),
(14, 'Air Pods Pro2', 'Electronics', 'Apple', 399, 7, 0x616972706f647370726f322e6a7067),
(15, 'Electric Guitar', 'Electronics', 'Stewart', 499, 2, 0x456c656374726963204775697461722e6a7067),
(16, 'Nitendo', 'Electronics', 'Nitendo', 410, 5, 0x6e6974656e646f2e6a7067),
(17, 'TUF A15', 'Electronics', 'Asus', 1199, 3, 0x617375737475664131352e6a7067),
(18, 'Mouse', 'Electronics', 'Razer', 139, 3, 0x72617a65726d6f7573652e706e67),
(19, 'PS5', 'Electronics', 'Play Station', 799, 2, 0x7073352e6a7067),
(20, 'Iphone 15', 'Electronics', 'Apple', 899, 7, 0x6970686f6e6531352e6a7067),
(21, '3xl', 'Footwear', 'Balanciaga', 799, 5, 0x33786c2e6a7067),
(22, 'Nike Dunk Panda Low', 'Footwear', 'Nike', 249, 4, 0x70616e6461206c6f772e6a7067),
(23, 'Bouncer Sneaker', 'Footwear', 'Balanciaga', 655, 4, 0x426f756e63657220536e65616b65722e6a7067),
(24, 'Comfort Office Chair', 'Furnitures', 'Oliver', 120, 13, 0x436f6d666f7274204f66666963652043686169722e6a7067),
(25, '3 Seater Fabric Sofa', 'Furnitures', 'Oliver', 899, 3, 0x4f6c697665722033205365617465722046616272696320536f66612e6a7067),
(26, 'Worker Straight Desk', 'Furnitures', 'Rapid', 499, 3, 0x52617069642d576f726b65722d53747261696768742d4465736b2e6a7067),
(27, 'Wood Table', 'Furnitures', 'Seito', 180, 7, 0x736569746f20776f6f64207461626c652e6a7067),
(28, 'Lazy Sofa', 'Furnitures', 'Simone', 429, 4, 0x53696d6f6e65204c617a7920536f66612e6a7067),
(29, 'Mid-Century Modern Table Lamp', 'Furnitures', 'Weston Black', 210, 9, 0x576573746f6e20426c61636b204d69642d43656e74757279204d6f6465726e205461626c65204c616d702e6a7067),
(30, 'Microwave Oven', 'Kitchen', 'Cuisinart', 669, 4, 0x43756973696e617274204d6963726f77617665204f76656e2e6a7067),
(31, 'Badminton Racket', 'Sports', 'LYZOO', 130, 11, 0x4c595a4f4f204261646d696e746f6e205261636b65742e6a7067),
(32, 'Premier League Football', 'Sports', 'Nike', 110, 8, 0x5072656d696572204c656167756520466f6f7462616c6c2e6a7067),
(33, 'Basketball Goal', 'Sports', 'Rocksolid', 1199, 2, 0x526f636b736f6c6964204261736b6562616c6c20476f616c2e6a7067),
(34, 'NBA Basketball', 'Sports', 'Wilsin', 179, 4, 0x57696c73696e204e4241204261736b657462616c6c2e6a7067);

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `detailsID` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`detailsID`, `orderID`, `itemID`, `quantity`) VALUES
(1, 1, 14, 1),
(2, 1, 5, 1),
(3, 1, 10, 1),
(4, 1, 4, 1),
(5, 2, 5, 1),
(6, 3, 29, 1),
(7, 3, 31, 1),
(8, 3, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `orderStatus` varchar(30) NOT NULL DEFAULT 'processing',
  `orderDate` date NOT NULL,
  `deliverAddress` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderID`, `UserID`, `orderStatus`, `orderDate`, `deliverAddress`) VALUES
(1, 1, 'delivered', '2024-05-11', 'Build(31/32) Room(201) Tamwe'),
(2, 3, 'delivering', '2024-05-11', 'Hlaing'),
(3, 4, 'delivering', '2024-05-11', 'New Daung Tea Shop, Tamwe');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `DOB` date NOT NULL,
  `Password` varchar(255) NOT NULL,
  `blockStatus` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Username`, `Phone`, `Email`, `Address`, `DOB`, `Password`, `blockStatus`) VALUES
(1, 'Wai Yan Kyaw', '095414911', 'waiyankyaw.wy6@gmail.com', 'Tamwe', '2004-02-04', 'wyk', 0),
(2, 'Zaw Thet Naing', '09796566874', 'zaw@gmail.com', 'South Dagon', '2005-06-10', 'ztn', 1),
(3, 'Thaw Myo Han', '095413739', 'thaw@gmail.com', 'Hlaing', '2003-10-12', 'tmh', 0),
(4, 'Soe Tay Za', '09798848857', 'soe@gmail.com', 'Tamwe', '2005-08-10', 'stz', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Name`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `cartitems`
--
ALTER TABLE `cartitems`
  ADD PRIMARY KEY (`CID`),
  ADD KEY `cartID` (`cartID`),
  ADD KEY `itemID` (`itemID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemID`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`detailsID`),
  ADD KEY `orderID` (`orderID`),
  ADD KEY `itemID` (`itemID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `UserID` (`UserID`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cartitems`
--
ALTER TABLE `cartitems`
  MODIFY `CID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `detailsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `cartitems`
--
ALTER TABLE `cartitems`
  ADD CONSTRAINT `cartitems_ibfk_1` FOREIGN KEY (`cartID`) REFERENCES `cart` (`cartID`),
  ADD CONSTRAINT `cartitems_ibfk_2` FOREIGN KEY (`itemID`) REFERENCES `items` (`itemID`);

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`),
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`itemID`) REFERENCES `items` (`itemID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `UseID` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
