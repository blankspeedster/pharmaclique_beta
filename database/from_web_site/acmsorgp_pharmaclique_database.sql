-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 26, 2022 at 02:20 AM
-- Server version: 10.2.43-MariaDB-cll-lve
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `acmsorgp_pharmaclique_database`
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
(76, 20, 24, 8, 11, '15.00', '165.00', 1, '2022-04-19 22:12:26', 39),
(77, 20, 24, 8, 2, '15.00', '30.00', 1, '2022-04-19 22:24:20', 40),
(78, 20, 24, 8, 4, '15.00', '60.00', 1, '2022-04-19 22:27:49', 41),
(79, 20, 24, 8, 1, '15.00', '15.00', 1, '2022-04-19 22:31:19', 42),
(80, 20, 24, 8, 6, '15.00', '90.00', 1, '2022-04-19 22:46:10', 43),
(81, 20, 24, 8, 3, '15.00', '45.00', 1, '2022-04-19 23:00:23', 44),
(82, 20, 24, 8, 5, '15.00', '75.00', 1, '2022-04-19 23:03:36', 45),
(83, 20, 24, 8, 3, '15.00', '45.00', 1, '2022-04-20 08:55:01', 46),
(84, 20, 24, 8, 10, '15.00', '150.00', 1, '2022-04-20 08:58:54', 47),
(85, 20, 24, 8, 1, '15.00', '15.00', 1, '2022-04-20 09:03:45', 48),
(87, 20, 31, 11, 1, '15.00', '15.00', 0, '2022-04-20 10:28:49', 0),
(88, 20, 30, 11, 1, '14.00', '14.00', 0, '2022-04-20 10:28:50', 0),
(89, 20, 29, 10, 5, '9.00', '45.00', 1, '2022-04-20 10:28:51', 50),
(90, 20, 28, 10, 2, '67.00', '134.00', 1, '2022-04-20 10:28:52', 50),
(91, 20, 27, 8, 1, '12.00', '12.00', 1, '2022-04-20 10:28:53', 49),
(92, 20, 24, 8, 1, '15.00', '15.00', 0, '2022-04-20 17:01:03', 0),
(93, 20, 32, 8, 3, '45.00', '135.00', 1, '2022-04-25 12:20:55', 52);

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
  `receipt_url` tinytext NOT NULL DEFAULT 'receipt.png',
  `prescription` int(1) NOT NULL DEFAULT 0,
  `prescription_url` tinytext NOT NULL DEFAULT 'prescription.png',
  `status` int(1) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `doctor_bookings`
--

INSERT INTO `doctor_bookings` (`id`, `doctor_id`, `patient_id`, `date_time_from`, `date_time_to`, `receipt`, `receipt_url`, `prescription`, `prescription_url`, `status`, `updated_at`) VALUES
(9, 10, 2, '2022-03-30 13:00:00', '2022-03-30 14:00:00', '0', 'receipt.png', 0, 'prescription.png', -1, '2022-03-30 19:54:32'),
(10, 10, 2, '2022-03-30 13:00:00', '2022-03-30 14:00:00', '0', 'receipt.png', 0, 'prescription.png', -1, '2022-03-30 21:06:16'),
(11, 11, 2, '2022-03-30 13:00:00', '2022-03-30 14:00:00', '0', 'receipt.png', 0, 'prescription.png', -1, '2022-03-30 21:33:37'),
(12, 10, 2, '2022-03-30 13:00:00', '2022-03-30 14:00:00', '0', 'receipt.png', 0, 'prescription.png', -1, '2022-03-30 21:39:13'),
(13, 11, 2, '2022-03-30 14:00:00', '2022-03-30 15:00:00', '0', 'receipt.png', 0, 'prescription.png', -1, '2022-03-30 21:43:23'),
(14, 10, 2, '2022-03-30 08:00:00', '2022-03-30 09:00:00', '0', 'receipt.png', 0, 'prescription.png', -1, '2022-03-30 21:45:36'),
(15, 10, 2, '2022-03-30 09:00:00', '2022-03-30 10:00:00', '0', 'receipt.png', 0, 'prescription.png', -1, '2022-03-30 21:45:55'),
(16, 11, 2, '2022-03-30 20:00:00', '2022-03-30 21:00:00', '0', 'receipt.png', 0, 'prescription.png', -1, '2022-03-30 21:46:56'),
(17, 11, 2, '2022-03-30 13:00:00', '2022-03-30 14:00:00', '0', 'receipt.png', 0, 'prescription.png', -1, '2022-03-30 21:47:03'),
(18, 11, 2, '2022-03-30 10:00:00', '2022-03-30 11:00:00', '0', 'receipt.png', 0, 'prescription.png', -1, '2022-03-30 21:47:35'),
(19, 11, 2, '2022-03-30 09:00:00', '2022-03-30 10:00:00', '0', 'receipt.png', 0, 'prescription.png', -1, '2022-03-30 21:47:52'),
(20, 11, 2, '2022-03-30 13:00:00', '2022-03-30 14:00:00', '0', 'receipt.png', 0, 'prescription.png', -1, '2022-03-30 21:50:39'),
(21, 11, 2, '2022-03-30 08:00:00', '2022-03-30 09:00:00', '0', 'receipt.png', 0, 'prescription.png', -1, '2022-03-30 21:51:00'),
(22, 10, 2, '2022-03-30 13:00:00', '2022-03-30 14:00:00', '1', '45318442407-game-pattern.jpg', 0, 'prescription.png', -1, '2022-04-03 23:40:40'),
(23, 10, 2, '2022-03-30 13:00:00', '2022-03-30 14:00:00', '1', '10161435116-game-pattern.jpg', 1, '19655044273-link.jpg', 0, '2022-04-03 23:48:01'),
(24, 10, 12, '2022-05-16 17:00:00', '2022-05-16 18:00:00', '0', 'receipt.png', 0, 'prescription.png', 0, '2022-04-17 21:13:29'),
(25, 15, 12, '2022-03-30 13:00:00', '2022-03-30 14:00:00', '0', 'receipt.png', 1, '82562738055-biogesics.jpg', 0, '2022-04-17 21:32:34'),
(26, 17, 20, '2022-03-30 12:00:00', '2022-03-30 14:00:00', '0', 'receipt.png', 1, '2052453550-biogesics.jpg', -1, '2022-04-19 22:38:42'),
(27, 17, 20, '2022-04-30 13:00:00', '2022-04-30 14:00:00', '1', '66018628169-biogesics.jpg', 1, '97385005334-sample-doctors-recipt-template.webp', 0, '2022-04-19 22:55:00'),
(28, 17, 20, '2022-03-30 13:00:00', '2022-03-30 14:00:00', '0', 'receipt.png', 0, 'prescription.png', 0, '2022-04-19 23:17:45'),
(29, 17, 20, '2022-06-15 13:00:00', '2022-06-15 14:00:00', '1', '56743718102-biogesics.jpg', 1, '27529309583-122.jpg', 0, '2022-04-20 09:04:17'),
(30, 17, 20, '2022-03-30 15:00:00', '2022-03-30 17:00:00', '0', 'receipt.png', 0, 'prescription.png', -1, '2022-04-23 00:16:26'),
(31, 17, 17, '2022-03-30 15:00:00', '2022-03-30 17:00:00', '1', '50228441293-qr.png', 0, 'prescription.png', 0, '2022-04-24 22:15:10');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_booking_threads`
--

CREATE TABLE `doctor_booking_threads` (
  `id` int(11) NOT NULL,
  `doctor_booking_id` int(12) NOT NULL,
  `user` varchar(12) NOT NULL,
  `user_message` text NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `doctor_booking_threads`
--

INSERT INTO `doctor_booking_threads` (`id`, `doctor_booking_id`, `user`, `user_message`, `updated_at`) VALUES
(1, 21, 'user', 'hello po doc', '2022-04-03 23:27:42'),
(2, 21, 'doctor', 'yes hello', '2022-04-03 23:31:30'),
(3, 21, 'doctor', 'kamusta?', '2022-04-03 23:31:38'),
(4, 21, 'user', 'wala po hehe love you po doc', '2022-04-03 23:37:55'),
(5, 22, 'user', 'hello po doc', '2022-04-03 23:41:50'),
(6, 22, 'doctor', 'Ayos lang naman ako iha. Ikaw kamusta?', '2022-04-03 23:45:12'),
(7, 22, 'user', 'okay lang ako. send gcash please', '2022-04-03 23:46:32'),
(8, 22, 'doctor', 'ayaw ko nga hehe', '2022-04-03 23:46:44'),
(9, 23, 'doctor', 'Hello. Please send the payment in gcash', '2022-04-03 23:48:21'),
(10, 23, 'user', 'ah okay grabe naman need po pala agad mag send dito hehe', '2022-04-03 23:53:26'),
(11, 23, 'doctor', 'sample here\n', '2022-04-16 10:58:26'),
(12, 25, 'user', 'Hi doc', '2022-04-17 21:33:12'),
(13, 25, 'doctor', 'this gmeet link lets meet according to your schedule you book', '2022-04-17 21:35:01'),
(14, 26, 'doctor', 'Nath nath dunk it', '2022-04-19 22:38:58'),
(15, 26, 'user', 'Sotto Dunk it\n', '2022-04-19 22:39:25'),
(16, 27, 'doctor', 'Hey doc \n', '2022-04-19 22:55:29'),
(17, 27, 'user', 'Sup patient', '2022-04-19 22:56:06'),
(18, 29, 'doctor', 'https://meet.google.com/qwu-ndka-zcf', '2022-04-20 09:05:22'),
(19, 29, 'doctor', 'lets meet here 2pm', '2022-04-20 09:05:39'),
(20, 29, 'user', 'okay doc', '2022-04-20 09:06:13'),
(21, 29, 'user', 'thanks doc', '2022-04-20 09:08:17');

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
(4, 11, '73119618460-flash-wallpaper.jpg', '900.00', 'External'),
(5, 15, '82878037872-biogesics.jpg', '500.00', 'Internal Medicine'),
(6, 17, '99676961411-doctorimage.jpg', '400.00', 'Internal Medicine');

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
(24, 8, 'BIOGE', 'BIOGESIC', 'Xevera,Calibutbut,Pampanga', '69041060577-biogesics.jpg', 999, '15', 'PARACETAMOL', '55', 1, '2022-04-19 14:11:19'),
(25, 9, 'BIOGE', 'BIOGESIC', 'Mexico,Pampanga', '41751457697-biogesics.jpg', 51, '12', 'PARACETAMOL', '55', 1, '2022-04-20 02:09:33'),
(26, 10, 'BIOGE', 'BIOGESIC', 'San fernando', '38496891077-biogesics.jpg', 85, '14', 'PARACETAMOL', '55', 1, '2022-04-20 02:11:09'),
(27, 8, 'BIOFL', 'BIOFLU', 'Xevera,Mabalacat,Pampanga', '99070741509-biofluu.jpg', 50, '12', 'PARACETAMOL', '200', 1, '2022-04-20 02:14:11'),
(28, 10, 'Lagun', 'Lagundi', 'Calibutbut', '21097950489-lagundisyrup.jpg', 41, '67', 'ASCOF', '55', 1, '2022-04-20 02:15:58'),
(29, 10, 'NEOZE', 'NEOZEP', 'Angeles,City', '20714411464-newsep.jpg', 66, '9', 'PARACETAMOL', '50', 1, '2022-04-20 02:17:10'),
(30, 11, 'katin', 'katinko', 'St jude', '34681528134-katinko.jpg', 88, '14', 'Methyl', '80', 1, '2022-04-20 02:21:25'),
(31, 11, 'BUSCO', 'BUSCOPAN', 'Dolores', '57802309585-buscopan.jpg', 15, '15', 'Hysocine', '55', 1, '2022-04-20 02:23:37'),
(32, 8, 'Robit', 'Robitussin', 'angeles City', '8027280101-4dc3b885f0bfa820ab7b6b259c3fbd17.jfif', 27, '45', 'Guiatuss', '6', 1, '2022-04-25 04:19:51');

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
(2, 4, 'Sample Store Namen', 'Sample Store Descrptionnn', 'Sample Store Address', '121.33987426757814', '15.435810296691406', '2022-01-02 14:37:27'),
(8, 16, 'The Generic', 'Medic', 'Angeles,Pamapanga', '120.59241763989398', '15.1585504', '2022-04-19 14:10:22'),
(9, 21, 'Mercury', 'Meds', 'Mabalacat', '120.59241763989398', '15.1585504', '2022-04-20 02:08:24'),
(10, 22, 'Chevera', 'Docs', 'Xevera', '120.59241763989398', '15.1585504', '2022-04-20 02:10:38'),
(11, 23, 'Drug Mart', 'Legal', 'Calibutbut', '120.59241763989398', '15.1585504', '2022-04-20 02:20:35');

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
(8, 18, '15.0929408', '120.6091776', 41, '2022-04-19 22:41:21'),
(9, 18, '15.0929408', '120.6091776', 42, '2022-04-19 22:41:23'),
(10, 16, '15.0929408', '120.6091776', 43, '2022-04-19 22:47:28'),
(11, 18, '15.0929408', '120.6091776', 44, '2022-04-19 23:01:33'),
(12, 18, '15.0929408', '120.6091776', 47, '2022-04-20 09:00:25'),
(13, 18, '15.0929408', '120.6091776', 48, '2022-04-20 09:34:11'),
(14, 18, '15.0929408', '120.6157312', 49, '2022-04-23 00:28:40');

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
(8, 18, 41, '120.6091776', '15.0929408', '2022-04-19 22:41:21', 1),
(9, 18, 42, '120.6091776', '15.0929408', '2022-04-19 22:41:23', 1),
(10, 16, 43, '120.6091776', '15.0929408', '2022-04-19 22:47:28', 1),
(11, 18, 44, 'User denied the request for Geolocation.', '', '2022-04-19 23:01:33', 1),
(12, 18, 47, '120.6091776', '15.0929408', '2022-04-20 09:00:25', 1),
(13, 18, 48, '120.6091776', '15.0929408', '2022-04-20 09:34:11', 1),
(14, 18, 49, '120.6091776', '15.0929408', '2022-04-23 00:28:40', 0);

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
(35, 3, 2, '2022-03-20 22:27:08', '9999999999.99', '9999999999.99', '120.6321829', '15.1592122', 1, '49.90'),
(37, 3, 2, '2022-04-05 13:28:23', '9999999999.99', '9999999999.99', '120.5744', '15.2216', -1, '49.90'),
(38, 7, 12, '2022-04-17 22:37:08', '79.90', '79.90', '120.6091776', '15.0929408', -1, '49.90'),
(39, 8, 20, '2022-04-19 22:13:25', '94.90', '94.90', '120.6091776', '15.0929408', 1, '49.90'),
(40, 8, 20, '2022-04-19 22:24:30', '79.90', '79.90', '120.6322113', '15.1591982', 1, '49.90'),
(41, 8, 20, '2022-04-19 22:28:10', '109.90', '109.90', '120.6091776', '15.0929408', 1, '49.90'),
(42, 8, 20, '2022-04-19 22:31:50', '64.90', '64.90', '120.6091776', '15.0929408', 1, '49.90'),
(43, 8, 20, '2022-04-19 22:46:31', '139.90', '139.90', '120.6091776', '15.0929408', 1, '49.90'),
(44, 8, 20, '2022-04-19 23:00:48', '94.90', '94.90', 'User denied the request for Geolocation.', '', 1, '49.90'),
(45, 8, 20, '2022-04-19 23:04:26', '124.90', '124.90', 'User denied the request for Geolocation.', '', -3, '49.90'),
(46, 8, 20, '2022-04-20 08:55:53', '94.90', '94.90', '120.6091776', '15.0929408', 1, '49.90'),
(47, 8, 20, '2022-04-20 08:59:22', '199.90', '199.90', '120.6091776', '15.0929408', 1, '49.90'),
(48, 8, 20, '2022-04-20 09:33:38', '64.90', '64.90', '120.6091776', '15.0929408', 1, '49.90'),
(49, 8, 20, '2022-04-20 10:29:39', '61.90', '61.90', '120.6091776', '15.0929408', -1, '49.90'),
(50, 10, 20, '2022-04-24 21:19:05', '228.90', '228.90', '120.6089761', '15.093292', 0, '49.90'),
(51, 0, 0, '2022-04-25 11:31:59', '49.90', '49.90', '120.6089288', '15.0932937', 0, '49.90'),
(52, 8, 20, '2022-04-25 12:21:17', '184.90', '184.90', '120.6089438', '15.0932755', -2, '49.90');

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
(4, 'Admin', 'Manager', 'admin', '09000000000', '$2y$10$BFzaFb8UHuithQH2yKdTBuChuUenSOWQGy628Myuj/QlsI/WVDWn.', 4, 1),
(16, 'Ato', 'Ang', 'pharmacy@gmail.com', 'phone_number', '$2y$10$7H/N.GmNg8EKqRSkgMQZaOGTu90hCgFgdrqjjitwrD7bGRxsiyztu', 3, 1),
(17, 'Jessy', 'Ang', 'doc@gmail.com', 'phone_number', '$2y$10$6TRyQjpAdzv6zCJnoacEz.aPZs1rE4j3LotnyfX1RvSKAH.Ma2K.S', 5, 1),
(18, 'Aj', 'Cruz', 'rider@gmail.com', '09000000000', '$2y$10$RU3cLPF7IGKniDG0Oq4EAeiSICGuQv464O/b0vcwvXf64XyY3qZW.', 2, 1),
(19, 'Karlo', 'Sotto', 'ksadmin@gmail.com', 'phone_number', '$2y$10$NGecYTgZAtmGCwL33reaSuwLEgSLAaF/IxyJpfRkO23.cOgjuqFqq', 4, 1),
(20, 'Dunk', 'Jonathan', 'user@gmail.com', '015125215151', '$2y$10$2pY1GrCk42MAB9YbzDpsSucpTv7MTWqNMO/AB3duXOy6OgrxuamcS', 1, 1),
(21, 'Jc', 'Vargas', 'pharmacy2@gmail.com', 'phone_number', '$2y$10$cwfd1W1cawq4DW43.Wy7XObpPDMeek2DwiD5zf6tB4IE39zzJsvm.', 3, 1),
(22, 'Kc', 'Lu', 'pharmacy3@gmail.com', 'phone_number', '$2y$10$riVu8vjnCrvIAMatKQbwmO.EcQJBAHSR8m7WVV7940uCoHdCBNuKG', 3, 1),
(23, 'AJ', 'Perez', 'pharmacy4@gmail.com', 'phone_number', '$2y$10$QybiG0pSBBwL22T74L6tz.4qVCYqq3uygIoky0.dPwA9qOFLIqbQ2', 3, 1),
(24, 'Bogs', 'Deez', 'pharmacy5@gmail.com', 'phone_number', '$2y$10$aghwQCRATWTt/kmTYEGRFuqvzx1IMPh/hWM/UebJ5LVIP5sZCF1hi', 3, 1),
(25, 'Marie', 'Cruz', 'doc2@gmail.com', 'phone_number', '$2y$10$8EBlXZq5vSLD85Zu3QHAN.UY7RFFfdkkC9pAD1Hn6dESYJbmVKeu6', 5, 1),
(26, 'Jazy', 'Perez', 'doc3@gmail.com', 'phone_number', '$2y$10$bVMdQ6pYR3RFk.gyf3gLleZiQUOhrQdCaLGG6kFAiX2vGWxSfboHC', 5, 1);

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
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `doctor_bookings`
--
ALTER TABLE `doctor_bookings`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `doctor_booking_threads`
--
ALTER TABLE `doctor_booking_threads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `doctor_profile`
--
ALTER TABLE `doctor_profile`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pharmacy_products`
--
ALTER TABLE `pharmacy_products`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `pharmacy_store`
--
ALTER TABLE `pharmacy_store`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rider_logs`
--
ALTER TABLE `rider_logs`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `rider_transaction`
--
ALTER TABLE `rider_transaction`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
