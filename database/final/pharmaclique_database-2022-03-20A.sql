-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2022 at 02:58 PM
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
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(12) NOT NULL,
  `user_id` int(12) NOT NULL,
  `product_id` int(12) NOT NULL,
  `pharmacy_id` int(12) NOT NULL,
  `count` int(12) NOT NULL DEFAULT 1,
  `price` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `check_out` int(1) NOT NULL DEFAULT 0,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `transaction_id` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `pharmacy_id`, `count`, `price`, `subtotal`, `check_out`, `updated_at`, `transaction_id`) VALUES
(39, 2, 1, 1, 1, '10.00', '10.00', 1, '2022-03-20 20:43:06', 29),
(40, 2, 2, 1, 1, '11.00', '11.00', 1, '2022-03-20 20:43:07', 29),
(41, 2, 3, 1, 1, '12.00', '12.00', 1, '2022-03-20 20:43:08', 29),
(42, 2, 8, 2, 1, '20.00', '20.00', 1, '2022-03-20 20:43:08', 30),
(43, 2, 21, 3, 1, '123.00', '123.00', 1, '2022-03-20 20:43:09', 31),
(44, 2, 22, 3, 1, '9999999999.99', '9999999999.99', 1, '2022-03-20 20:43:10', 31);

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
(1, 1, 'sampla', 'sample', 'sample', '92302047746-spcflogo.png', 99, '10', 'UNILIVER', '0', 1, '2022-01-03 20:51:33'),
(2, 1, 'samplb', 'sample', 'sample', '92302047746-spcflogo.png', 99, '11', 'UNILIVER', '0', 1, '2022-01-03 20:52:19'),
(3, 1, 'samplc', 'sample', 'sample', '92302047746-spcflogo.png', 99, '12', 'UNILIVER', '0', 1, '2022-01-03 20:52:22'),
(8, 2, 'sa', 'sa', 'asdf', '92302047746-spcflogo.png', 123, '20', 'UNILIVER', '0', 1, '2022-02-23 14:04:49'),
(21, 3, 'cert', 'cert', 'cert', '92302047746-spcflogo.png', 123, '123', 'cert', '123', 1, '2022-02-23 17:51:31'),
(22, 3, 'certc', 'certcertcertcert', '3456345', '92302047746-spcflogo.png', 0, '245665454656', 'certcertcertcert', '456456', 1, '2022-02-23 17:51:55');

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
  `longitude` varchar(128) DEFAULT '120.59241763989398',
  `latitude` varchar(128) DEFAULT '15.1585504',
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pharmacy_store`
--

INSERT INTO `pharmacy_store` (`id`, `user_id`, `store_name`, `description`, `address`, `longitude`, `latitude`, `updated_at`) VALUES
(1, 1, 'Sample Store Name Before', 'Store Description Sample', 'Store Address Sample', '120.59241763989398', '15.15875230007508', '2022-01-02 14:36:30'),
(2, 4, 'Sample Store Namen', 'Sample Store Descrptionnn', 'Sample Store Address', '121.33987426757814', '15.435810296691406', '2022-01-02 14:37:27'),
(3, 7, 'Sample Pharmacy', 'Sample Description', 'Sample Address', '120.79241763989398', '15.15875230007508', '2022-02-23 06:18:16'),
(6, 8, '123', '123123', '123', '120.57947874069215', '15.133299457326657', '2022-03-19 02:14:58');

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
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(12) NOT NULL,
  `pharmacy_id` int(12) NOT NULL,
  `user_id` int(12) NOT NULL,
  `transaction_date` datetime NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `amount_paid` decimal(12,2) NOT NULL,
  `user_long` text NOT NULL,
  `user_lat` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `delivery_charge` decimal(12,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `pharmacy_id`, `user_id`, `transaction_date`, `total_amount`, `amount_paid`, `user_long`, `user_lat`, `status`, `delivery_charge`) VALUES
(29, 1, 2, '2022-03-20 20:43:29', '82.90', '82.90', '120.632339', '15.158874', 1, '49.90'),
(30, 2, 2, '2022-03-20 20:43:37', '69.90', '69.90', '120.632339', '15.158874', -1, '49.90'),
(31, 3, 2, '2022-03-20 20:43:45', '9999999999.99', '9999999999.99', '120.632339', '15.158874', 1, '49.90');

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
  `validated` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `phone_number`, `password`, `role`, `validated`) VALUES
(1, 'Karlo', 'Sotto', 'pharmacy_2', '09000000000', '$2y$10$BFzaFb8UHuithQH2yKdTBuChuUenSOWQGy628Myuj/QlsI/WVDWn.', 3, 1),
(2, 'Customer', 'Customer', 'customer', '09000000000', '$2y$10$BFzaFb8UHuithQH2yKdTBuChuUenSOWQGy628Myuj/QlsI/WVDWn.', 1, 1),
(3, 'Teacher', 'Teacher', 'new_teacher@sample.com', '09000000000', '$2y$10$V9gkujYVYitCdTcQaUe1/.BmoxHteagkvg5RUJc2GwphTbwvqTofy', 3, 1),
(4, 'Admin', 'Manager', 'admin', '09000000000', '$2y$10$BFzaFb8UHuithQH2yKdTBuChuUenSOWQGy628Myuj/QlsI/WVDWn.', 4, 1),
(6, 'Chris', 'Tian', 'tian@tian.com', '09000000000', '$2y$10$5xxKAXXvHSjwP3chIEZzY.1QeEpkHfBFCmvs9ZYvznSA6aIQSuohS', 2, 1),
(7, 'Karlo', 'Sotto', 'pharmacy', '3123213', '$2y$10$BFzaFb8UHuithQH2yKdTBuChuUenSOWQGy628Myuj/QlsI/WVDWn.', 3, 1),
(8, 'Marsha', 'Superio', 'marsha@superio.com', 'phone_number', '$2y$10$BFzaFb8UHuithQH2yKdTBuChuUenSOWQGy628Myuj/QlsI/WVDWn.', 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `pharmacy_id` (`pharmacy_id`);

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
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pharmacy_id` (`pharmacy_id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `pharmacy_products`
--
ALTER TABLE `pharmacy_products`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `pharmacy_store`
--
ALTER TABLE `pharmacy_store`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`pharmacy_id`) REFERENCES `pharmacy_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `pharmacy_products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
