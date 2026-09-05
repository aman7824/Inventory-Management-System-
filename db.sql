-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 21, 2026 at 10:42 AM
-- Server version: 5.7.36
-- PHP Version: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Customer_Id` varchar(50) NOT NULL,
  `Customer_Name` varchar(255) NOT NULL,
  `Customer_Mobile` varchar(20) DEFAULT NULL,
  `Customer_Email` varchar(100) DEFAULT NULL,
  `Customer_Address` text,
  `Record_Date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Customer_Id` (`Customer_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `Customer_Id`, `Customer_Name`, `Customer_Mobile`, `Customer_Email`, `Customer_Address`, `Record_Date`) VALUES
(1, 'C2025025150', 'RAJESH JOSHI', '9899647249', 'rajesh@gmail.com', 'gurgaon', '2026-04-21 04:47:45');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Product_Id` varchar(50) NOT NULL,
  `Hsn_Code` varchar(50) DEFAULT NULL,
  `Product_Code` varchar(100) DEFAULT NULL,
  `Product_Name` varchar(255) NOT NULL,
  `Product_Cost` decimal(15,2) DEFAULT '0.00',
  `Selling_Price` decimal(15,2) DEFAULT '0.00',
  `Quantity` int(11) DEFAULT '0',
  `Low_Stock_Threshold` int(11) DEFAULT '5',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Product_Id` (`Product_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `Product_Id`, `Hsn_Code`, `Product_Code`, `Product_Name`, `Product_Cost`, `Selling_Price`, `Quantity`, `Low_Stock_Threshold`) VALUES
(1, 'HP1001', '87032291', '9899647249', 'HP KEYBOARD', '1500.00', '1800.00', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

DROP TABLE IF EXISTS `purchase`;
CREATE TABLE IF NOT EXISTS `purchase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Hsn_Code` varchar(50) DEFAULT NULL,
  `Product_Name` varchar(255) DEFAULT NULL,
  `Product_Code` varchar(100) DEFAULT NULL,
  `Vendor_Id` varchar(50) DEFAULT NULL,
  `Vendor_Name` varchar(255) DEFAULT NULL,
  `Purchase_Date` date DEFAULT NULL,
  `Purchase_Units` int(11) DEFAULT NULL,
  `Purchase_Cost` decimal(15,2) DEFAULT NULL,
  `IGST` decimal(15,2) DEFAULT '0.00',
  `CGST` decimal(15,2) DEFAULT '0.00',
  `SGST` decimal(15,2) DEFAULT '0.00',
  `Total_Amount` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`id`, `Hsn_Code`, `Product_Name`, `Product_Code`, `Vendor_Id`, `Vendor_Name`, `Purchase_Date`, `Purchase_Units`, `Purchase_Cost`, `IGST`, `CGST`, `SGST`, `Total_Amount`) VALUES
(1, '87032291', 'HP KEYBOARD', '9899647249', 'VEN1001', 'HITACHI SYSTEMS LIMITED', '2026-04-21', 5, '1500.00', '0.00', '9.00', '9.00', '8850.00');

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

DROP TABLE IF EXISTS `sale`;
CREATE TABLE IF NOT EXISTS `sale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Product_Id` varchar(50) DEFAULT NULL,
  `Customer_Id` varchar(50) DEFAULT NULL,
  `Customer_Name` varchar(255) DEFAULT NULL,
  `Vendor_Id` varchar(50) DEFAULT NULL,
  `Hsn_Code` varchar(50) DEFAULT NULL,
  `Product_Name` varchar(255) DEFAULT NULL,
  `Sale_Date` date DEFAULT NULL,
  `Product_Units` int(11) DEFAULT NULL,
  `Product_Price` decimal(15,2) DEFAULT NULL,
  `IGST` decimal(15,2) DEFAULT '0.00',
  `CGST` decimal(15,2) DEFAULT '0.00',
  `SGST` decimal(15,2) DEFAULT '0.00',
  `Total_Amount` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`id`, `Product_Id`, `Customer_Id`, `Customer_Name`, `Vendor_Id`, `Hsn_Code`, `Product_Name`, `Sale_Date`, `Product_Units`, `Product_Price`, `IGST`, `CGST`, `SGST`, `Total_Amount`) VALUES
(1, 'HP1001', 'C2025025150', 'RAJESH JOSHI', 'VEN1001', '87032291', 'HP KEYBOARD', '2026-04-21', 1, '1800.00', '0.00', '9.00', '9.00', '2124.00'),
(2, 'HP1001', 'C2025025150', 'RAJESH JOSHI', 'VEN1001', '87032291', 'HP KEYBOARD', '2026-04-21', 2, '1800.00', '0.00', '9.00', '9.00', '4248.00'),
(3, 'HP1001', 'C2025025150', 'RAJESH JOSHI', 'VEN1001', '87032291', 'HP KEYBOARD', '2026-04-21', 1, '1800.00', '0.00', '9.00', '9.00', '2124.00'),
(4, 'HP1001', 'C2025025150', 'RAJESH JOSHI', 'VEN1001', '87032291', 'HP KEYBOARD', '2026-04-21', 1, '1800.00', '0.00', '9.00', '9.00', '2124.00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `role` enum('admin','staff') DEFAULT 'staff',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$sxQwNm9WQF8lFS3.UGxj.OaXwzjwgw2AmnGV6NVGNSnbUWTraWOJS', 'GANESH DUTT', 'admin', '2026-04-21 09:46:13'),
(2, 'staff', '$2y$10$wvFZ/Mm0r1bsbYEYpjay1u/RMYtg4ygR8PlPBPf/7Fu.zBQ3eFyKG', 'STAFF ONE', 'staff', '2026-04-21 09:52:50'),
(3, 'MUKESH123', '$2y$10$oer9.CLVdV474Z2laCLEh.D2v8mRFwa.yJrIAv7RUBck0Gdrw7c/i', 'MUKESH KUMAR', 'staff', '2026-04-21 10:13:24');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

DROP TABLE IF EXISTS `vendors`;
CREATE TABLE IF NOT EXISTS `vendors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Vendor_Id` varchar(50) NOT NULL,
  `Vendor_Name` varchar(255) NOT NULL,
  `Vendor_Mobile` varchar(20) DEFAULT NULL,
  `Vendor_Email` varchar(100) DEFAULT NULL,
  `Vendor_Address` text,
  `Vendor_Pan` varchar(20) DEFAULT NULL,
  `Vendor_GST` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Vendor_Id` (`Vendor_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `Vendor_Id`, `Vendor_Name`, `Vendor_Mobile`, `Vendor_Email`, `Vendor_Address`, `Vendor_Pan`, `Vendor_GST`) VALUES
(1, 'VEN1001', 'HITACHI SYSTEMS LIMITED', '9899647145', 'hitachisystems@gmail.com', 'TEST', 'AAJCS1043D', '06AAJCS1043D1ZS');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
