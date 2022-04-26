-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2022 at 11:06 AM
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
(56, 2, 22, 3, 1, '9999999999.99', '9999999999.99', 1, '2022-03-20 22:26:53', 35),
(57, 2, 21, 3, 1, '123.00', '123.00', 1, '2022-03-20 22:26:53', 35),
(58, 2, 21, 3, 2, '123.00', '246.00', 1, '2022-03-23 10:55:22', 36);

-- --------------------------------------------------------

--
-- Table structure for table `doctor_bookings`
--

CREATE TABLE `doctor_bookings` (
  `id` int(12) NOT NULL,
  `doctor_id` int(12) NOT NULL,
  `patient_id` int(12) NOT NULL,
  `date_time_from` datetime NOT NULL,
  `date_time_to` datetime NOT NULL,
  `receipt` text NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `doctor_bookings`
--

INSERT INTO `doctor_bookings` (`id`, `doctor_id`, `patient_id`, `date_time_from`, `date_time_to`, `receipt`, `status`, `updated_at`) VALUES
(9, 10, 2, '2022-03-30 13:00:00', '2022-03-30 14:00:00', '0', -1, '2022-03-30 19:54:32'),
(10, 10, 2, '2022-03-30 13:00:00', '2022-03-30 14:00:00', '0', -1, '2022-03-30 21:06:16'),
(11, 11, 2, '2022-03-30 13:00:00', '2022-03-30 14:00:00', '0', -1, '2022-03-30 21:33:37'),
(12, 10, 2, '2022-03-30 13:00:00', '2022-03-30 14:00:00', '0', -1, '2022-03-30 21:39:13'),
(13, 11, 2, '2022-03-30 14:00:00', '2022-03-30 15:00:00', '0', -1, '2022-03-30 21:43:23'),
(14, 10, 2, '2022-03-30 08:00:00', '2022-03-30 09:00:00', '0', -1, '2022-03-30 21:45:36'),
(15, 10, 2, '2022-03-30 09:00:00', '2022-03-30 10:00:00', '0', -1, '2022-03-30 21:45:55'),
(16, 11, 2, '2022-03-30 20:00:00', '2022-03-30 21:00:00', '0', -1, '2022-03-30 21:46:56'),
(17, 11, 2, '2022-03-30 13:00:00', '2022-03-30 14:00:00', '0', -1, '2022-03-30 21:47:03'),
(18, 11, 2, '2022-03-30 10:00:00', '2022-03-30 11:00:00', '0', -1, '2022-03-30 21:47:35'),
(19, 11, 2, '2022-03-30 09:00:00', '2022-03-30 10:00:00', '0', -1, '2022-03-30 21:47:52'),
(20, 11, 2, '2022-03-30 13:00:00', '2022-03-30 14:00:00', '0', -1, '2022-03-30 21:50:39'),
(21, 11, 2, '2022-03-30 08:00:00', '2022-03-30 09:00:00', '0', 0, '2022-03-30 21:51:00');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_booking_threads`
--

CREATE TABLE `doctor_booking_threads` (
  `id` int(11) NOT NULL,
  `doctor_booking_id` int(12) NOT NULL,
  `user` int(1) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_profile`
--

CREATE TABLE `doctor_profile` (
  `id` int(12) NOT NULL,
  `doctor_id` int(12) NOT NULL,
  `profile_image` text NOT NULL DEFAULT 'undraw_profile.svg',
  `hourly_rate` decimal(12,2) NOT NULL,
  `specialization` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `doctor_profile`
--

INSERT INTO `doctor_profile` (`id`, `doctor_id`, `profile_image`, `hourly_rate`, `specialization`) VALUES
(3, 10, '66418495387-spcflogo.png', '1000.00', 'Sample Sample'),
(4, 11, '73119618460-flash-wallpaper.jpg', '900.00', 'External');

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
(21, 3, 'cert', 'cert', 'cert', '92302047746-spcflogo.png', 99, '123', 'cert', '123', 1, '2022-02-23 17:51:31'),
(22, 3, 'certc', 'certcertcertcert', '3456345', '92302047746-spcflogo.png', 99, '245665454656', 'certcertcertcert', '456456', 1, '2022-02-23 17:51:55');

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
-- Table structure for table `rider_logs`
--

CREATE TABLE `rider_logs` (
  `id` int(1) NOT NULL,
  `rider_id` int(12) NOT NULL,
  `rider_lat` text NOT NULL,
  `rider_long` text NOT NULL,
  `transaction_id` int(12) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rider_logs`
--

INSERT INTO `rider_logs` (`id`, `rider_id`, `rider_lat`, `rider_long`, `transaction_id`, `updated_at`) VALUES
(4, 6, '15.1585385', '121', 35, '2022-03-23 13:11:09'),
(5, 6, '15.1584616', '121', 35, '2022-03-23 16:25:15'),
(6, 6, '15.158454', '121', 35, '2022-03-23 16:39:37');

-- --------------------------------------------------------

--
-- Table structure for table `rider_transaction`
--

CREATE TABLE `rider_transaction` (
  `id` int(12) NOT NULL,
  `rider_id` int(12) NOT NULL,
  `transaction_id` int(12) NOT NULL,
  `customer_lat` text NOT NULL,
  `customer_long` text NOT NULL,
  `updated_at` datetime NOT NULL,
  `delivered` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rider_transaction`
--

INSERT INTO `rider_transaction` (`id`, `rider_id`, `transaction_id`, `customer_lat`, `customer_long`, `updated_at`, `delivered`) VALUES
(6, 6, 35, '120.6321829', '15.1592122', '2022-03-23 16:39:37', 0);

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
(4, 'admin', 'admin for the whole app that over see everything'),
(5, 'doctor', 'Doctor role');

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
(35, 3, 2, '2022-03-20 22:27:08', '9999999999.99', '9999999999.99', '120.6321829', '15.1592122', -1, '49.90');

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
(6, 'Chris', 'Tian', 'rider', '09000000000', '$2y$10$BFzaFb8UHuithQH2yKdTBuChuUenSOWQGy628Myuj/QlsI/WVDWn.', 2, 1),
(7, 'Karlo', 'Sotto', 'pharmacy', '3123213', '$2y$10$BFzaFb8UHuithQH2yKdTBuChuUenSOWQGy628Myuj/QlsI/WVDWn.', 3, 1),
(8, 'Marsha', 'Superio', 'marsha@superio.com', 'phone_number', '$2y$10$BFzaFb8UHuithQH2yKdTBuChuUenSOWQGy628Myuj/QlsI/WVDWn.', 3, 1),
(10, 'Doctor', 'Doctor', 'doctor', '09103252006', '$2y$10$8pygSNJq9c.D9.MNjZIhOeB6aZNA9BXuDFxpC2phillpmS7hEXHSy', 5, 1),
(11, 'Another', 'Doctor', 'doctor@doctor.com', 'phone_number', '$2y$10$2EyrkLcNPGTKGc10n9OnO.VfPhKZ6IqdQNhiZWIaed9Njov1lk3KG', 5, 1);

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
-- Indexes for table `doctor_bookings`
--
ALTER TABLE `doctor_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `doctor_booking_threads`
--
ALTER TABLE `doctor_booking_threads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_booking_id` (`doctor_booking_id`);

--
-- Indexes for table `doctor_profile`
--
ALTER TABLE `doctor_profile`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `rider_logs`
--
ALTER TABLE `rider_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rider_transaction`
--
ALTER TABLE `rider_transaction`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `doctor_bookings`
--
ALTER TABLE `doctor_bookings`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `doctor_booking_threads`
--
ALTER TABLE `doctor_booking_threads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_profile`
--
ALTER TABLE `doctor_profile`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- AUTO_INCREMENT for table `rider_logs`
--
ALTER TABLE `rider_logs`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rider_transaction`
--
ALTER TABLE `rider_transaction`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
