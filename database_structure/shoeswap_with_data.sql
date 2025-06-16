-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2025 at 09:52 AM
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

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`addressId`, `userId`, `fullName`, `phoneNumber`, `pincode`, `state`, `city`, `house`, `area`, `landmark`, `created_at`, `is_default`) VALUES
(9, 17, 'Purnendu Guha', '6291747596', '700051', 'West Bengal', 'Kolkata', '421/4', 'Birati', 'Near Spencer', '2025-06-12 07:01:15', 'no');

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

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `userId`, `sellerId`, `shoes_id`, `comment`, `rating`, `created_at`) VALUES
(8, 17, 17, 38, 'Very good product, I am satisfied.', 4, '2025-06-12 13:11:48');

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

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `userId`, `user`, `shoes_id`, `created_date`, `addressId`) VALUES
(33, 17, 'purnendu1505', 38, '2025-06-07 07:02:00', 9),
(34, 17, 'purnendu1505', 39, '2025-06-12 07:02:00', 9);

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

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `card_name`, `card_number`, `card_expiry`, `card_cvv`, `order_id`, `payment_date`) VALUES
(17, 'Purnendu Guha', '9807654348765432', '0928', '876', 34, '2025-06-12 07:02:00');

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

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`sellerId`, `FNAME`, `LNAME`, `USERNAME`, `EMAIL_ID`, `PASSWORD`, `ADDRESS`, `CITY`, `PIN`, `PHONE_NUMBER`, `SECURITY_QUES`, `GOVT_ID_TYPE`, `ID_NUMBER`) VALUES
(17, 'Susmita', 'Poddar', 'susmita2002', 'developbyheart33@gmail.com', '$2y$10$QGe29nxyagHiigVASkiKdeskOj9ZyuXOJ/Q/5KyU9dEXq1KJQnZVW', 'Kaikhali', 'Kolkata', '700056', '8547114777', '2001', 'Aadhaar Card', '745888996666');

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

--
-- Dumping data for table `shoes`
--

INSERT INTO `shoes` (`id`, `brand`, `type`, `category`, `shoe_usage`, `gender`, `size`, `purchase_price`, `selling_price`, `status`, `seller_name`, `image_url`, `image_url_f`, `image_url_s`, `description`, `sellerId`) VALUES
(38, 'Nike', 'Sneaker', 'Leather', 'Less than 1 month', 'Male', 'US-7', 47500.76, 24300.32, 'Sold', 'susmita2002', 'uploads/8ce5544dd4cb811fb0f4f52ceac117f5.png', 'uploads/3550f6b08d7e80ba1d1fcdcd2ffd72c6.png', 'uploads/46572e9efabf18b8f7c4d444ff52f235.png', 'Experience classic style and comfort with the Nike sneaker leather edition. Designed with premium leather for durability and a sleek look, it offers all-day support, grip, and a timeless design perfect for everyday wear.', NULL),
(39, 'Adidas', 'Loafer', 'Foam', '1-3 months', 'Male', 'US-8', 85400.00, 24300.00, 'Sold', 'susmita2002', 'uploads/f6362ba6de5c98dbf8735f06a531c9a3.png', 'uploads/e206990e8bb0a355f57f8b18916c8da8.jpg', 'uploads/ca337e29678264b49f21d369678f09b2.jpg', 'Step into comfort with the Adidas loafer foam edition. Crafted for everyday ease, it features soft foam cushioning, a lightweight build, and a sleek design that blends sporty style with casual elegance.', NULL),
(41, 'Gucci', 'Sport Shoes', 'Suede', '6-9 months', 'Male', 'US-8', 47500.76, 24300.32, 'Listed', 'susmita2002', 'uploads/cee2c7349503b850f302e7c68c2e34d0.jpg', 'uploads/483ed52561f65d32bfcd5f96ff8f8aad.jpg', 'uploads/9133e6eb4bbe4f857524e830899989dc.jpg', 'Elevate your style with Gucci sport shoes in suede. Crafted with premium suede and a modern sporty design, they offer luxury comfort, durable grip, and a bold fashion statement for any casual or active look.', NULL),
(42, 'Air Jordan', 'Brogues', 'Cons', 'Less than 1 month', 'Male', 'US-6', 85400.00, 75600.00, 'Listed', 'susmita2002', 'uploads/c39cdc7ce96ae61ba0d4c073c5921f2b.jpg', 'uploads/65b1e3386b56924482708404ac095a65.jpg', 'uploads/77e88eb1c68815906d9b819cc1d3f261.jpg', 'Blend classic and modern with Air Jordan brogues con. Featuring iconic Air Jordan flair with brogue-inspired detailing, they offer a unique mix of sporty comfort and timeless style, perfect for making a bold statement in any setting.', NULL),
(43, 'New Balance', 'Slippers', 'Leather', '6-9 months', 'Male', 'US-6', 18600.65, 9200.33, 'Listed', 'susmita2002', 'uploads/91de8f4533e93a7e59532ee28e248261.jpg', 'uploads/5d0d78252f996a9f09aef6b1f125f1b4.jpg', 'uploads/32f92f12e44d17503308a1935f3c092d.jpg', 'Enjoy everyday comfort with New Balance slipper leather edition. Made from premium leather with a soft inner lining, it offers a relaxed fit, durable sole, and a stylish look ideal for casual indoor or outdoor wear.', NULL),
(44, 'Puma', 'Sneaker', 'Foam', '3-6 months', 'Male', 'US-5', 47500.00, 24300.00, 'Listed', 'susmita2002', 'uploads/0d6e3043efc293c0ce520016d68f86ab.jpg', 'uploads/5869411a7f5ac11c94eee4ed44ef2d92.jpg', 'uploads/bf02a72dd12056c81fbf3adc918c6ebd.jpg', 'Step up your game with Puma sneaker foam edition. Built with soft foam cushioning and a sleek design, it delivers lightweight comfort, strong support, and a sporty style perfect for active and casual wear.', NULL),
(45, 'Reebok', 'Loafer', 'Suede', '1-3 months', 'Female', 'US-5', 47500.87, 24300.24, 'Listed', 'susmita2002', 'uploads/94f0a3437591c2b04f815044a4cf7513.jpg', 'uploads/4c94ab66105faf7968b448c45e0c6247.jpg', 'uploads/446a9e1995603c96274a77669f961939.jpg', 'Upgrade your look with Reebok loafer suede edition. Crafted from soft suede with a sleek, casual design, it offers comfort, durability, and effortless style for everyday wear.', NULL),
(46, 'Air Jordan', 'Brogues', 'Cons', 'Less than 1 month', 'Female', 'US-4', 85400.00, 75600.00, 'Listed', 'susmita2002', 'uploads/32ef92116337e8faf456f4f87276d4f1.png', 'uploads/5eef18e9ebfb5e06d3d415c7df14fd7a.png', 'uploads/6bffd3cee3815a5ac8551651c9b2f6a6.png', 'Air Jordan brogues cons combine heritage style with modern edge. Featuring brogue-inspired details and sporty comfort, they offer a bold fusion of elegance and street-ready performance for standout everyday wear.', NULL),
(48, 'Puma', 'Sport Shoes', 'Suede', '6-9 months', 'Kids', 'US-5', 29600.00, 16700.00, 'Listed', 'susmita2002', 'uploads/d4bf9f82e8503d12a3a8f6d9e5a14c26.jpg', 'uploads/4cfe2a45a8230d154da4977ef9ee7048.jpg', 'uploads/fa6b58dbd5ea26dda982586cafef725b.jpg', 'Kids Puma sport shoes in suede offer soft comfort and durable support. With a flexible sole and stylish design, they keep kids ready for play and active fun all day long.', NULL);

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

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `FNAME`, `LNAME`, `USERNAME`, `EMAIL_ID`, `PASSWORD`, `STATE`, `CITY`, `PHONE_NUMBER`, `SECURITY_QUES`, `PIN`) VALUES
(17, 'Purnendu', 'Guha', 'purnendu1505', 'purnenduguha71@gmail.com', '$2y$10$jByOLwr/v/yFce5tiky0z.CK6TBXXVf8xD5EDwF/mK4i2O2LsDVzG', 'West Bengal', 'Kolkata', '6291747596', '2001', '700051');

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
  MODIFY `addressId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `sellerId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `shoes`
--
ALTER TABLE `shoes`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
