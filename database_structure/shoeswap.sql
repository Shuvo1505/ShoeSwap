-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2025 at 09:53 AM
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
-- Database: `shoeswap`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `addressId` int(11) NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `fullName` varchar(31) NOT NULL,
  `phoneNumber` varchar(10) NOT NULL,
  `pincode` char(6) NOT NULL,
  `state` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `house` varchar(100) NOT NULL,
  `area` varchar(100) NOT NULL,
  `landmark` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_default` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(10) UNSIGNED NOT NULL,
  `user` varchar(50) NOT NULL,
  `shoes_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `sellerId` int(10) UNSIGNED NOT NULL,
  `shoes_id` int(10) UNSIGNED NOT NULL,
  `comment` varchar(500) DEFAULT NULL,
  `rating` tinyint(3) UNSIGNED DEFAULT NULL CHECK (`rating` between 0 and 5),
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(6) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED DEFAULT NULL,
  `user` varchar(50) NOT NULL,
  `shoes_id` int(10) UNSIGNED DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `addressId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(6) UNSIGNED NOT NULL,
  `card_name` varchar(50) NOT NULL,
  `card_number` varchar(16) NOT NULL,
  `card_expiry` varchar(4) NOT NULL,
  `card_cvv` varchar(3) NOT NULL,
  `order_id` int(10) UNSIGNED DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `sellerId` int(10) UNSIGNED NOT NULL,
  `FNAME` varchar(15) NOT NULL,
  `LNAME` varchar(15) NOT NULL,
  `USERNAME` varchar(12) NOT NULL,
  `EMAIL_ID` varchar(50) DEFAULT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `ADDRESS` varchar(30) NOT NULL,
  `CITY` varchar(30) NOT NULL,
  `PIN` varchar(6) NOT NULL,
  `PHONE_NUMBER` varchar(10) NOT NULL,
  `SECURITY_QUES` varchar(4) DEFAULT NULL,
  `GOVT_ID_TYPE` varchar(50) NOT NULL,
  `ID_NUMBER` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shoes`
--

CREATE TABLE `shoes` (
  `id` int(6) UNSIGNED NOT NULL,
  `brand` varchar(30) NOT NULL,
  `type` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `shoe_usage` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `size` varchar(10) NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Listed',
  `seller_name` varchar(50) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `image_url_f` varchar(255) NOT NULL,
  `image_url_s` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sellerId` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userId` int(10) UNSIGNED NOT NULL,
  `FNAME` varchar(15) NOT NULL,
  `LNAME` varchar(15) NOT NULL,
  `USERNAME` varchar(12) NOT NULL,
  `EMAIL_ID` varchar(50) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `STATE` varchar(100) NOT NULL,
  `CITY` varchar(100) NOT NULL,
  `PHONE_NUMBER` varchar(10) NOT NULL,
  `SECURITY_QUES` varchar(4) DEFAULT NULL,
  `PIN` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(10) UNSIGNED NOT NULL,
  `user` varchar(50) NOT NULL,
  `shoes_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`addressId`),
  ADD KEY `show_fk_userid` (`userId`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `show_fk_shoeid` (`shoes_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `sellerId` (`sellerId`),
  ADD KEY `shoes_id` (`shoes_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_userId` (`userId`),
  ADD KEY `show_fk_shoeid2` (`shoes_id`),
  ADD KEY `fk_address_id` (`addressId`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `show_fk_orderid` (`order_id`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`sellerId`),
  ADD UNIQUE KEY `unique_username` (`USERNAME`),
  ADD UNIQUE KEY `USERNAME` (`USERNAME`),
  ADD UNIQUE KEY `EMAIL_ID` (`EMAIL_ID`);

--
-- Indexes for table `shoes`
--
ALTER TABLE `shoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `show_fk1` (`sellerId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `USERNAME` (`USERNAME`),
  ADD UNIQUE KEY `EMAIL_ID` (`EMAIL_ID`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD KEY `show_fk_shoeid3` (`shoes_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `addressId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `sellerId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shoes`
--
ALTER TABLE `shoes`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `show_fk_userid` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `show_fk_shoeid` FOREIGN KEY (`shoes_id`) REFERENCES `shoes` (`id`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`sellerId`) REFERENCES `seller` (`sellerId`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_ibfk_3` FOREIGN KEY (`shoes_id`) REFERENCES `shoes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_address_id` FOREIGN KEY (`addressId`) REFERENCES `addresses` (`addressId`),
  ADD CONSTRAINT `fk_userId` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`),
  ADD CONSTRAINT `show_fk_shoeid2` FOREIGN KEY (`shoes_id`) REFERENCES `shoes` (`id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `show_fk_orderid` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`);

--
-- Constraints for table `shoes`
--
ALTER TABLE `shoes`
  ADD CONSTRAINT `show_fk1` FOREIGN KEY (`sellerId`) REFERENCES `seller` (`sellerId`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `show_fk_shoeid3` FOREIGN KEY (`shoes_id`) REFERENCES `shoes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
