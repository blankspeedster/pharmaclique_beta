-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2022 at 10:37 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharmaclique_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_products`
--

CREATE TABLE `pharmacy_products` (
  `id` int(12) NOT NULL,
  `store_id` int(12) NOT NULL,
  `product_code` varchar(12) DEFAULT NULL,
  `product_name` varchar(128) DEFAULT NULL,
  `product_description` text DEFAULT NULL,
  `product_url` varchar(128) DEFAULT 'dummy.jpeg',
  `product_stock` int(12) DEFAULT 99,
  `product_price` varchar(12) NOT NULL DEFAULT '0',
  `product_brand` varchar(128) DEFAULT NULL,
  `product_weight` varchar(128) NOT NULL DEFAULT '0',
  `product_category_id` int(12) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pharmacy_products`
--

INSERT INTO `pharmacy_products` (`id`, `store_id`, `product_code`, `product_name`, `product_description`, `product_url`, `product_stock`, `product_price`, `product_brand`, `product_weight`, `product_category_id`, `updated_at`) VALUES
(1, 1, 'sampla', 'sample', 'sample', '86690477991-Giratina.png', 99, '0', 'UNILIVER', '0', 1, '2022-01-03 20:51:33'),
(2, 1, 'samplb', 'sample', 'sample', '4175306875-Giratina.png', 99, '0', 'UNILIVER', '0', 1, '2022-01-03 20:52:19'),
(3, 1, 'samplc', 'sample', 'sample', '75029222479-Giratina.png', 99, '0', 'UNILIVER', '0', 1, '2022-01-03 20:52:22'),
(8, 2, 'sa', 'sa', 'asdf', '92302047746-spcflogo.png', 123, '0', 'UNILIVER', '0', 1, '2022-02-23 14:04:49'),
(9, 3, 'sampl', 'sample spcf logo', 'sample description', '84845861932-spcflogo.png', 123, '0', 'UNILABVVV', '00', 1, '2022-02-23 14:18:34'),
(15, 3, 'KingD', 'KingDomHearts', '1232134 ', '99849761860-kh-b.png', 234234, '0', 'UNILABBCBCVB', '0234', 1, '2022-02-23 16:02:58'),
(16, 3, 'asdf', 'asdf', 'asf', '83273836354-kh-a.png', 123123, '012312', 'asdfasdf', '12312', 1, '2022-02-23 16:05:19'),
(17, 3, 'KingD', 'KingDomHearts', '1232134 ', '44621412482-kh-b.png', 234234, '0', 'UNILABBCBCVB', '0234', 1, '2022-02-23 16:05:59');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy_store`
--

CREATE TABLE `pharmacy_store` (
  `id` int(12) NOT NULL,
  `user_id` int(12) NOT NULL,
  `store_name` varchar(64) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `address` varchar(128) DEFAULT NULL,
  `longitude` varchar(128) DEFAULT NULL,
  `latitude` varchar(128) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pharmacy_store`
--

INSERT INTO `pharmacy_store` (`id`, `user_id`, `store_name`, `description`, `address`, `longitude`, `latitude`, `updated_at`) VALUES
(1, 1, 'Sample Store Name Before', 'Store Description Sample', 'Store Address Sample', NULL, NULL, '2022-01-02 14:36:30'),
(2, 4, 'Sample Store Namen', 'Sample Store Descrptionnn', 'Sample Store Address', NULL, NULL, '2022-01-02 14:37:27'),
(3, 7, 'Sample Pharmacy', 'Sample Description', 'Sample Address', NULL, NULL, '2022-02-23 06:18:16');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(12) NOT NULL,
  `code` varchar(64) NOT NULL,
  `description` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `code`, `description`) VALUES
(1, 'customer', 'Default user for the web app'),
(2, 'rider', 'Rider role'),
(3, 'pharmacy', 'Pharmacy role for the web application'),
(4, 'admin', 'admin for the whole app that over see everything');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(12) NOT NULL,
  `firstname` varchar(256) DEFAULT NULL,
  `lastname` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `phone_number` varchar(12) DEFAULT '09000000000',
  `password` varchar(128) DEFAULT NULL,
  `role` int(12) DEFAULT NULL,
  `validated` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `phone_number`, `password`, `role`, `validated`) VALUES
(1, 'Karlo', 'Sotto', 'pharmacy_2', '09000000000', '$2y$10$BFzaFb8UHuithQH2yKdTBuChuUenSOWQGy628Myuj/QlsI/WVDWn.', 3, 1),
(2, 'Customer', 'Customer', 'customer@customer.com', '09000000000', '$2y$10$BdUqRZaToAd9wzkoRyNJXeAY0N0loJLk4GKFnBMaXaXa7/mXCjMKW', 2, 1),
(3, 'Teacher', 'Teacher', 'new_teacher@sample.com', '09000000000', '$2y$10$V9gkujYVYitCdTcQaUe1/.BmoxHteagkvg5RUJc2GwphTbwvqTofy', 3, 0),
(4, 'Admin', 'Manager', 'admin', '09000000000', '$2y$10$BFzaFb8UHuithQH2yKdTBuChuUenSOWQGy628Myuj/QlsI/WVDWn.', 4, 1),
(6, 'Chris', 'Tian', 'tian@tian.com', '09000000000', '$2y$10$5xxKAXXvHSjwP3chIEZzY.1QeEpkHfBFCmvs9ZYvznSA6aIQSuohS', 2, 1),
(7, 'Karlo', 'Sotto', 'pharmacy', '3123213', '$2y$10$BFzaFb8UHuithQH2yKdTBuChuUenSOWQGy628Myuj/QlsI/WVDWn.', 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pharmacy_products`
--
ALTER TABLE `pharmacy_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`store_id`);

--
-- Indexes for table `pharmacy_store`
--
ALTER TABLE `pharmacy_store`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pharmacy_products`
--
ALTER TABLE `pharmacy_products`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pharmacy_store`
--
ALTER TABLE `pharmacy_store`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pharmacy_products`
--
ALTER TABLE `pharmacy_products`
  ADD CONSTRAINT `pharmacy_products_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `pharmacy_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pharmacy_store`
--
ALTER TABLE `pharmacy_store`
  ADD CONSTRAINT `pharmacy_store_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
