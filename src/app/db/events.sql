-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql-server
-- Generation Time: Mar 29, 2022 at 12:09 PM
-- Server version: 8.0.19
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `events`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_address` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_name`, `customer_address`, `zipcode`, `product`, `quantity`) VALUES
(1, 'Vikas', 'Jankipuram', '92347', 'Mobilenew', 2),
(2, 'Vikas', 'Jankipuram', '226010', 'Mobilenew', 2),
(3, 'Vikas', 'Jankipuram', '226010', 'Mobilenew', 2);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `price` int DEFAULT NULL,
  `stocks` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `description`, `tags`, `price`, `stocks`) VALUES
(70, 'Mobilenew', 'Nokia 7772', 'new', 10000, 100),
(71, 'T-Shirt ', 'New Black T-shirt', '', 1000, 100),
(72, 'Pant', 'Black Pant', 'Latest', 100, 100),
(73, 'Mobile', 'ra', 'new', 100, 100),
(74, 'Mobile', 'ra', 'new', 100, 100),
(75, 'Mobile', 'ra', 'new', 100, 100),
(76, 'Mobile', 'ra', 'new', 100, 100),
(77, 'Mobile', 'ra', 'new', 100, 100),
(78, 'Mobile', 'ra', 'new', 100, 100),
(79, 'Mobile', 'ra', 'new', 100, 100),
(80, 'Mobile', 'ra', 'new', 100, 100),
(81, 'Mobile', 'ra', 'new', 100, 100),
(82, 'Mobile', 'ra', 'new', 100, 100),
(83, 'Mobile', 'ra', 'new', 100, 100),
(84, 'Mobile', 'ra', 'new', 100, 100),
(85, 'Mobile', 'ra', 'new', 100, 100),
(86, 'Mobile', 'ra', 'new', 100, 100),
(87, 'Mobile', 'ra', 'new', 100, 100),
(88, 'Mobile', 'ra', 'new', 100, 100),
(89, 'Mobile', 'ra', 'new', 100, 100),
(90, 'Mobile', 'ra', 'new', 100, 100),
(91, 'Mobile', 'ra', 'new', 100, 100),
(92, 'Mobile', 'ra', 'new', 100, 100),
(93, 'Mobile', 'ra', 'new', 100, 100),
(94, 'Mobile', 'ra', 'new', 100, 100),
(95, 'Mobile', 'ra', 'new', 100, 100);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `title_optimization` varchar(255) NOT NULL,
  `default_price` int NOT NULL,
  `default_stock` int NOT NULL,
  `default_zipcode` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title_optimization`, `default_price`, `default_stock`, `default_zipcode`) VALUES
(1, 'N', 100, 100, 226010);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
