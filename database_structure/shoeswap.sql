-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2025 at 08:22 AM
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
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(10) UNSIGNED NOT NULL,
  `user` varchar(50) NOT NULL,
  `shoes_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(6) UNSIGNED NOT NULL,
  `seller` varchar(50) NOT NULL,
  `user` varchar(50) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `shoes_id` int(6) NOT NULL,
  `comment_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `seller`, `user`, `comment`, `shoes_id`, `comment_time`) VALUES
(1, 'subha', 'akash76', '1234', 36, '2023-06-24 09:33:28');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phno` varchar(50) NOT NULL,
  `msg` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `phno`, `msg`) VALUES
(1, 'Arnab Saha', 'arnabsaha52@gmail.com', '8798785423', 'give me the details about the branded shoes.');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(6) UNSIGNED NOT NULL,
  `user` varchar(50) NOT NULL,
  `shoes_id` int(10) UNSIGNED DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `user`, `shoes_id`, `created_date`) VALUES
(1, 'akash76', 6, '2023-06-23 12:57:21'),
(2, 'akash76', 13, '2023-06-23 12:57:21'),
(3, 'akash76', 15, '2023-06-23 12:57:21'),
(4, 'akash76', 16, '2023-06-23 12:57:21'),
(5, 'akash76', 36, '2023-06-24 09:30:23'),
(6, 'akash76', 17, '2023-06-24 09:30:23');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(6) UNSIGNED NOT NULL,
  `card_name` varchar(50) NOT NULL,
  `card_number` int(16) NOT NULL,
  `card_expiry` int(4) NOT NULL,
  `card_cvv` int(3) NOT NULL,
  `order_id` int(6) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `card_name`, `card_number`, `card_expiry`, `card_cvv`, `order_id`, `payment_date`) VALUES
(1, 'subhadeep ray', 2147483647, 1234, 567, 6, '2023-06-24 09:30:23');

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
  `status` varchar(10) NOT NULL DEFAULT 'LISTED',
  `seller_name` varchar(50) NOT NULL,
  `seller_location` varchar(50) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `image_url_f` varchar(255) NOT NULL,
  `image_url_s` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `shoes`
--

INSERT INTO `shoes` (`id`, `brand`, `type`, `category`, `shoe_usage`, `gender`, `size`, `purchase_price`, `selling_price`, `status`, `seller_name`, `seller_location`, `image_url`, `image_url_f`, `image_url_s`, `description`) VALUES
(6, 'Gucci', 'Sneaker', 'Foam', '1-3 months', 'Male', 'US-7', 30000.00, 8000.00, 'sold', 'subho1', 'Deshbandhu nagar kalnagate', 'uploads/gucci-ace-bee-sneakers-foam-3rd.jpg', 'uploads/gucci-ace-bee-sneakers-foam-2nd.jpg', 'uploads/gucci-ace-bee-sneakers-foam-1st.jpg', 'The quality of this shoe is very good'),
(9, 'Puma', 'Sport-Shoes', 'Leather', '<1 months', 'Male', 'US-6', 3000.00, 800.00, 'LISTED', 'subho1', 'Deshbandhu nagar kalnagate', 'uploads/1000012774287-Black-Black-1000012774287_01-2100.jpg', 'uploads/1000012774287-Black-Black-1000012774287_06-2100.jpg', 'uploads/1000012774287-Black-Black-1000012774287_02-2100.jpg', 'The shoe is in good condition'),
(10, 'Puma', 'Sport-Shoes', 'Leather', '1-3 months', 'Male', 'US-8', 3500.00, 900.00, 'LISTED', 'subho1', 'Deshbandhu nagar kalnagate', 'uploads/1000012502911-Blue-BlueNavyDen-1000012502911_01-2100.jpg', 'uploads/1000012502911-Blue-BlueNavyDen-1000012502911_02-2100.jpg', 'uploads/1000012502911-Blue-BlueNavyDen-1000012502911_04-2100.jpg', 'Well-maintained pre-loved shoes, still in excellent condition.'),
(11, 'Skechers', 'Slippers', 'Foam', '<1 months', 'Male', 'US-9', 2000.00, 500.00, 'LISTED', 'subho1', 'Deshbandhu nagar kalnagate', 'uploads/MP000000016892937_437Wx649H_202303172027552.jpeg', 'uploads/MP000000016892937_437Wx649H_202303172027574.jpeg', 'uploads/MP000000016892937_437Wx649H_202303172028031.jpeg', 'Nearly new shoes, only worn a few times, with no visible flaws.'),
(12, 'Puma', 'Slippers', 'Foam', '<1 months', 'Male', 'US-9', 1500.00, 500.00, 'LISTED', 'subho1', 'Deshbandhu nagar kalnagate', 'uploads/41bvKqeAweL._UL1200_.jpg', 'uploads/51zYR07oryL._UL1200_.jpg', 'uploads/41dFiQ14gOL._UL1200_.jpg', 'Lightly used slippers that still look and feel great'),
(13, 'Gucci', 'Brogues', 'Leather', '1-3 months', 'Male', 'US-10', 20000.00, 6000.00, 'sold', 'subho1', 'Deshbandhu nagar kalnagate', 'uploads/unnamed.jpg', 'uploads/gucci-Brown-Bee-GG-Web-Trim-Brogues.jpeg', 'uploads/download.jpg', 'Well-cared shoes, showing only minor wear and tear'),
(14, 'Gucci', 'Sneaker', 'Foam', '3-6 months', 'Male', 'US-5', 45000.00, 10000.00, 'LISTED', 'danish77', 'Ullash Colony, 17 no street', 'uploads/gucci-hightop white-sneakers-foam-1st.jpg', 'uploads/gucci-hightop white-sneakers-foam-2nd.jpg', 'uploads/gucci-hightop white-sneakers-foam-3rd.jpg', 'This shoe is in great condition, suitable for any occasion.'),
(15, 'Gucci', 'Sneaker', 'Foam', '6-9 months', 'Male', 'US-9', 35000.00, 7000.00, 'sold', 'danish77', 'Ullash Colony, 17 no street', 'uploads/gucci-ace Gg supreme-sneakers-foam-2nd.jpg', 'uploads/gucci-ace Gg supreme-sneakers-foam-3rd.jpg', 'uploads/gucci-ace Gg supreme-sneakers-foam-1st.jpg', 'pre-owned shoe that have been meticulously cleaned and cared for. '),
(16, 'Puma', 'Sport-Shoes', 'Foam', '<1 months', 'Female', 'US-5', 2000.00, 700.00, 'sold', 'danish77', 'Ullash Colony, 17 no street', 'uploads/puma-sneakers-foam-1st.jpg', 'uploads/puma-sneakers-foam-2nd.jpg', 'uploads/puma-sneakers-foam-3rdd.jpg', 'Slightly used shoes with plenty of life left in them.'),
(17, 'Puma', 'Sport-Shoes', 'Foam', '<1 months', 'Female', 'US-6', 2889.00, 1000.00, 'sold', 'danish77', 'Ullash Colony, 17 no street', 'uploads/puma-sports-black-foam-2nd.jpg', 'uploads/puma-sports-black-foam-3rd.jpg', 'uploads/puma-sports-black-foam-1st.jpg', 'Shoes in excellent condition, perfect for sports wear.'),
(18, 'Puma', 'Sport-Shoes', 'Foam', '<1 months', 'Kids', 'US-3', 1599.00, 500.00, 'LISTED', 'danish77', 'Ullash Colony, 17 no street', 'uploads/puma-kid-black-sports-foam-1st.jpg', 'uploads/puma-kid-black-sports-foam-3rd.jpg', 'uploads/puma-kid-black-sports-foam.jpg', 'These pre-loved shoe is still in remarkable condition.'),
(19, 'Adidas', 'Sport-Shoes', 'Foam', '<1 months', 'Kids', 'US-4', 3000.00, 1200.00, 'LISTED', 'danish77', 'Ullash Colony, 17 no street', 'uploads/adidas-sport-black-foam-1st.jpg', 'uploads/adidas-sport-black-foam-2nd.jpg', 'uploads/adidas-sport-black-foam-3rd.jpg', 'Quality used shoe that have been taken care of exceptionally well.'),
(20, 'Skechers', 'Sneaker', 'Foam', '1-3 months', 'Female', 'US-6', 3500.00, 800.00, 'LISTED', 'danish77', 'Ullash Colony, 17 no street', 'uploads/skecher-sneaker-foam-white-1st.jpg', 'uploads/skecher-sneaker-foam-white-2nd.jpg', 'uploads/skecher-sneaker-foam-white-3rd.jpg', 'Well-preserved shoe with minimal signs of wear , ready to be sold.'),
(21, 'Nike', 'Sneaker', 'Leather', '1-3 months', 'Male', 'US-10', 5699.00, 1500.00, 'listed', 'yogesh85', 'Park Street', 'uploads/nike-sneakers-white-foam-1st.jpg', 'uploads/nike-sneakers-white-leather-2nd.jpg', 'uploads/nike-sneakers-white-leather-3rdd.jpg', 'Quality used shoes with only slight wear visible.'),
(22, 'New Balance', 'Sport-Shoes', 'Foam', '1-3 months', 'Male', 'US-7', 2867.00, 700.00, 'LISTED', 'yogesh85', 'Park Street', 'uploads/sport shoe-blue-foam-2nd.jpg', 'uploads/sport shoe-blue-foam-3rd.jpg', 'uploads/sport shoe-blue-foam-1st.jpg', 'Gently used shoe that have been cleaned and refreshed'),
(23, 'Nike', 'Slippers', 'Foam', '<1 months', 'Female', 'US-6', 3600.00, 800.00, 'LISTED', 'yogesh85', 'Park Street', 'uploads/slippers-black-foam-2nd.jpg', 'uploads/slippers-black-foam-1st.jpg', 'uploads/slippers-black-foam-3rd.jpg', 'Slightly used slipper that have been maintained with attention to detail.'),
(24, 'Nike', 'Sport-Shoes', 'Foam', '<1 months', 'Kids', 'US-3', 3200.00, 600.00, 'LISTED', 'yogesh85', 'Park Street', 'uploads/sports-black-foam-1st.jpg', 'uploads/sports-black-foam-3rd.jpg', 'uploads/sports-black-foam-2nd.jpg', 'Well maintained shoe suitable for various occasion.'),
(25, 'Air jordan', 'Sneaker', 'Foam', '3-6 months', 'Male', 'US-9', 50000.00, 15000.00, 'LISTED', 'yogesh85', 'Park Street', 'uploads/sneakers-white-red-leather-1st.jpg', 'uploads/sneakers-white-red-leather-2nd.jpg', 'uploads/sneakers-white-red-leather-3rd.jpg', 'Slightly used shoes that heve been maintained with attention to detail.'),
(26, 'Gucci', 'Sneaker', 'Canvas', '1-3 months', 'Male', 'US-7', 45000.00, 12000.00, 'LISTED', 'yogesh85', 'Park Street', 'uploads/gucci-Blue-GG-Canvas-Leather-High-top-Sneaker.jpeg', 'uploads/gucci-hightop-black-canvas-sneaker2.jpg', 'uploads/gucci-hightop-black-canvas-sneaker.jpg', 'Quality used shoes with only slight wear visible.'),
(27, 'Reebok', 'Slippers', 'Foam', '<1 months', 'Female', 'US-5', 1200.00, 400.00, 'LISTED', 'yogesh85', 'Park Street', 'uploads/slipper-green-.jpg', 'uploads/slipper-green-2.jpg', 'uploads/slipper-green-1.jpg', 'Quality used slipper with only slight wear visible.'),
(28, 'Air jordan', 'Sneaker', 'Canvas', '1-3 months', 'Kids', 'US-2', 42500.00, 12000.00, 'LISTED', 'sahil256', 'Ambuja, City Centre', 'uploads/biue-high sneaker-canvas.jpg', 'uploads/biue-high sneaker-canvas2.jpg', 'uploads/biue-high sneaker-canvas1.jpg', 'Well-maintained pre-loved shoes, still in excellent condition.'),
(29, 'New Balance', 'Slippers', 'Foam', '<1 months', 'Female', 'US-8', 3500.00, 600.00, 'LISTED', 'sahil256', 'Ambuja, City Centre', 'uploads/slipper-blue-foam-.jpg', 'uploads/slipper-blue-foam-1.jpg', 'uploads/slipper-blue-foam-2.jpg', 'Well-maintained pre-loved slipper, still in excellent condition.'),
(30, 'Gucci', 'Brogues', 'Leather', '1-3 months', 'Male', 'US-9', 52000.00, 18000.00, 'LISTED', 'sahil256', 'Ambuja, City Centre', 'uploads/brogues-black-leather.jpg', 'uploads/brogues-black-leather2.jpg', 'uploads/brogues-black-leather1.jpg', 'pre-owned shoe that have been meticulously cleaned and cared for.'),
(31, 'Puma', 'Casual', 'Suede', '<1 months', 'Male', 'US-6', 4700.00, 732.00, 'LISTED', 'sahil256', 'Ambuja, City Centre', 'uploads/suede-csual-blue-.jpg', 'uploads/suede-csual-blue-1.jpg', 'uploads/suede-csual-blue-2.jpg', 'Lightly used shoe that have been cleaned and sanitized.'),
(32, 'Nike', 'Sport-Shoes', 'Suede', '<1 months', 'Female', 'US-8', 10000.00, 3000.00, 'LISTED', 'sahil256', 'Ambuja, City Centre', 'uploads/sports-suede-pink.jpg', 'uploads/sports-suede-pink3.jpg', 'uploads/sports-suede-pink1.jpg', 'Barely used shoe that are practically as good as new.'),
(33, 'Nike', 'Sneaker', 'Leather', '1-3 months', 'Male', 'US-8', 25000.00, 8000.00, 'LISTED', 'sahil256', 'Ambuja, City Centre', 'uploads/airforce1-white-sneaker.jpg', 'uploads/airforce1-white-sneaker1jpg.jpg', 'uploads/airforce1-white-sneaker2.jpg', 'Well-preserved shoe, perfect for someone seeking quality at a lower price.'),
(34, 'Puma', 'Slippers', 'Leather', '<1 months', 'Kids', 'US-2', 1200.00, 400.00, 'LISTED', 'sahil256', 'Ambuja, City Centre', 'uploads/slipper-black-.jpg', 'uploads/slipper-black-1.jpg', 'uploads/slipper-black-2.jpg', 'Gently used shoes, ideal for someone looking for a good deal.'),
(35, 'Puma', 'Sneaker', 'Canvas', '1-3 months', 'Male', 'US-11', 5000.00, 1000.00, 'LISTED', 'ashok87', 'citycentre, near junction', 'uploads/canvas-white-sneakers.jpg', 'uploads/canvas-white-sneakers1.jpg', 'uploads/canvas-white-sneakers2.jpg', 'Shoes in excellent condition , perfect for wear'),
(36, 'Adidas', 'Loafer', 'Leather', '3-6 months', 'Female', 'US-8', 3000.00, 1200.00, 'sold', 'subha', 'kalnagate', 'uploads/sports-shoes-1000x1000.jpg', 'uploads/sports-shoes-1000x1000.jpg', 'uploads/varna-bulgaria-june-red-puma-sport-shoes-background-major-german-multinational-company-product-shot-163936479.jpg', 'the shoe is in good condition');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `FNAME` varchar(15) NOT NULL,
  `LNAME` varchar(15) NOT NULL,
  `USERNAME` varchar(10) NOT NULL,
  `EMAIL_ID` varchar(50) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `ADDRESS` varchar(30) NOT NULL,
  `CITY` varchar(30) NOT NULL,
  `PHONE_NUMBER` varchar(10) NOT NULL,
  `SECURITY_QUES` varchar(4) DEFAULT NULL,
  `PIN` varchar(6) NOT NULL
) ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`FNAME`, `LNAME`, `USERNAME`, `EMAIL_ID`, `PASSWORD`, `ADDRESS`, `CITY`, `PHONE_NUMBER`, `SECURITY_QUES`, `PIN`) VALUES
('Riyanka', 'Sarkar', 'riyanka', 'msriyankasarkar@gmail.com', '$2y$10$UUeXXvXh2jCtylqjzwY59.SBmxoVBM3WfQEaNYryg2hp9lqvWTw0G', 'kolkata', 'kolkata', '7477636226', '2025', '765432'),
('Sehenaj', 'Sultana', 'sehenaj', 'sehenaj@gamil.com', '$2y$10$ep18qm1dCxSlkqGjDNcKouypHOwTDFHbi39o4XVCqJCrkl4A4PLOK', 'Murshidabad', 'Kolkata', '9876543210', '2025', '765432');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(10) UNSIGNED NOT NULL,
  `user` varchar(50) NOT NULL,
  `shoes_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wishlist_id`, `user`, `shoes_id`) VALUES
(1, 'danish77', 6),
(2, 'danish77', 9),
(3, 'danish77', 16),
(4, 'danish77', 19),
(5, 'akash76', 7),
(6, 'akash76', 14),
(7, 'akash76', 17),
(8, 'akash76', 28),
(9, 'akash76', 35),
(10, 'akash76', 36);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `shoes`
--
ALTER TABLE `shoes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`USERNAME`),
  ADD UNIQUE KEY `USERNAME` (`USERNAME`),
  ADD UNIQUE KEY `EMAIL_ID` (`EMAIL_ID`),
  ADD UNIQUE KEY `EMAIL_ID_2` (`EMAIL_ID`),
  ADD UNIQUE KEY `PHONE_NUMBER` (`PHONE_NUMBER`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shoes`
--
ALTER TABLE `shoes`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
