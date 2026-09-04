-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2024 at 11:36 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_roriri`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_details`
--

CREATE TABLE `additional_details` (
  `add_id` int(11) NOT NULL COMMENT 'Additional detail Id',
  `basic_id` int(11) NOT NULL COMMENT 'Basic Table id reference',
  `entity_id` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `qr` varchar(100) NOT NULL,
  `joining_date` varchar(50) NOT NULL,
  `reg_no` int(11) NOT NULL,
  `add_status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Additional details of resources';

--
-- Dumping data for table `additional_details`
--

INSERT INTO `additional_details` (`add_id`, `basic_id`, `entity_id`, `role`, `image`, `qr`, `joining_date`, `reg_no`, `add_status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 6, 'anushiya.jpg', 'anushiyaqr.png', '2024-04-29', 180001, 'Active', '2024-07-27 16:55:07', '2024-07-27 11:33:49'),
(2, 3, 3, 10, 'demo001.jpg', 'demo001qr.png', '', 170001, 'Active', '2024-07-27 17:16:43', '2024-07-29 07:04:57'),
(3, 5, 3, 10, '', 'demo1qr.png', '', 170002, 'Active', '2024-07-27 17:23:23', '2024-07-27 11:53:23'),
(4, 7, 1, 5, '', 'testqr.png', '2024-07-11', 180002, 'Active', '2024-07-27 17:32:31', '2024-07-27 12:02:31'),
(5, 8, 11, 2, '', 'dezz sqr.png', '', 160001, 'Active', '2024-07-27 17:35:25', '2024-07-27 12:05:25'),
(6, 9, 2, 11, '9.png', 'sherlinjrqr.png', '', 170003, 'Active', '2024-07-29 12:18:45', '2024-08-03 04:29:00'),
(7, 10, 1, 7, '', 'qr.png', '2024-07-11', 180003, 'Active', '2024-07-29 12:35:32', '2024-07-29 07:05:32'),
(8, 11, 1, 9, '', 'qr.png', '2024-07-02', 180004, 'Active', '2024-07-29 12:58:40', '2024-07-29 07:28:40'),
(9, 12, 1, 7, '', 'qr.png', '2024-07-17', 180005, 'Active', '2024-07-29 13:08:56', '2024-07-29 07:38:56'),
(10, 13, 1, 8, '', 'testqr.png', '2024-07-24', 180006, 'Active', '2024-07-29 17:01:52', '2024-07-29 11:31:52'),
(11, 14, 3, 10, '', 'sherlinjr001qr.png', '', 170003, 'Active', '2024-07-29 17:02:09', '2024-07-29 11:32:09'),
(12, 15, 2, 11, '', 'abcd demoqr.png', '', 170004, 'Active', '2024-07-29 17:02:53', '2024-07-29 11:32:53'),
(13, 16, 1, 0, '', 'qr.png', '', 180007, 'Active', '2024-07-29 17:03:49', '2024-07-29 11:33:49'),
(14, 17, 1, 0, '', 'qr.png', '', 180008, 'Active', '2024-07-29 17:07:09', '2024-07-29 11:37:09'),
(15, 18, 1, 0, '', 'qr.png', '', 180009, 'Active', '2024-07-29 17:10:18', '2024-07-29 11:40:18'),
(16, 19, 2, 11, '', 'dem demooqr.png', '', 170005, 'Active', '2024-07-29 17:12:04', '2024-07-29 11:42:04'),
(17, 20, 1, 5, '', 'ewrewqr.png', '2024-07-24', 180010, 'Active', '2024-07-30 09:32:00', '2024-07-30 04:02:00'),
(18, 21, 1, 9, '', 'demoqr.png', '2024-07-30', 180011, 'Active', '2024-07-30 10:00:48', '2024-07-30 04:30:48'),
(19, 22, 1, 6, '', 'fdcvfcxqr.png', '2024-07-30', 180012, 'Active', '2024-07-30 10:17:09', '2024-07-30 04:47:09'),
(20, 23, 1, 6, '', 'fdcvfcxqr.png', '2024-07-30', 180013, 'Active', '2024-07-30 10:17:17', '2024-07-30 04:47:17'),
(21, 24, 1, 8, '', 'fdcvfcxqr.png', '2024-07-25', 180014, 'Active', '2024-07-30 10:26:35', '2024-07-30 04:56:35'),
(22, 25, 1, 8, '', 'fdcvfcxqr.png', '2024-07-25', 180015, 'Active', '2024-07-30 10:26:40', '2024-07-30 04:56:40'),
(23, 26, 1, 8, '', 'fdcvfcxqr.png', '2024-07-25', 180016, 'Active', '2024-07-30 10:28:01', '2024-07-30 04:58:01'),
(24, 27, 2, 11, '', 'student clgqr.png', '', 170006, 'Active', '2024-07-30 10:38:26', '2024-07-30 05:08:26'),
(25, 28, 3, 10, '', 'sherlinjr002qr.png', '', 170004, 'Active', '2024-07-30 10:43:42', '2024-07-30 05:13:42'),
(26, 29, 3, 10, '', 'sherlinjr003qr.png', '', 170005, 'Active', '2024-07-30 10:50:08', '2024-07-30 05:20:08'),
(27, 30, 1, 8, '', 'exampleqr.png', '2024-07-30', 180017, 'Active', '2024-07-30 10:56:06', '2024-07-30 05:26:06'),
(28, 31, 1, 9, '', 'demoqr.png', '2024-07-30', 180018, 'Active', '2024-07-30 10:57:05', '2024-07-30 05:27:05'),
(29, 32, 1, 7, '', 'empqr.png', '2024-07-01', 180019, 'Active', '2024-07-30 11:06:28', '2024-07-30 05:36:28'),
(30, 33, 1, 8, '', 'cdsqr.png', '2024-07-17', 180020, 'Active', '2024-07-30 11:07:55', '2024-07-30 05:37:55'),
(31, 34, 1, 6, '', 'hariqr.png', '2024-07-04', 180021, 'Active', '2024-07-30 11:11:33', '2024-07-30 05:41:33'),
(32, 35, 2, 11, '05.png', 'stud clgqr.png', '', 170007, 'Active', '2024-07-30 11:16:16', '2024-07-30 05:46:16'),
(33, 36, 2, 11, '36.png', 'clg bcaqr.png', '', 170008, 'Active', '2024-07-30 11:42:28', '2024-08-03 04:50:48'),
(34, 37, 3, 10, '', 'sherlinjr004qr.png', '', 170006, 'Active', '2024-07-30 12:38:41', '2024-07-30 07:08:41'),
(35, 38, 2, 11, '', 'newstud aaqr.png', '', 170009, 'Active', '2024-07-30 12:40:30', '2024-07-30 07:10:30'),
(36, 39, 3, 10, '', 'sherlinjr005qr.png', '', 170007, 'Active', '2024-07-30 12:50:23', '2024-07-30 07:20:23'),
(37, 40, 2, 11, '36.png', 'newclg bcaqr.png', '', 170010, 'Active', '2024-07-30 12:54:23', '2024-07-30 07:24:23'),
(38, 41, 2, 11, '', 'sherlin wwqr.png', '', 170011, 'Active', '2024-07-30 14:33:26', '2024-07-30 09:03:26'),
(39, 42, 2, 11, '42.png', 'dem fkqr.png', '', 170012, 'Active', '2024-07-30 14:42:41', '2024-08-03 04:48:07'),
(40, 43, 2, 11, '', 'ff bgqr.png', '', 170013, 'Active', '2024-07-30 14:44:53', '2024-07-30 09:14:53'),
(41, 44, 3, 10, '', 'ashaqr.png', '', 170008, 'Active', '2024-07-30 14:54:59', '2024-07-30 09:24:59'),
(42, 45, 3, 10, '', 'asha001qr.png', '', 170009, 'Active', '2024-07-30 14:56:22', '2024-07-30 09:26:22'),
(43, 46, 1, 6, '', 'asha tqr.png', '2024-06-15', 180022, 'Active', '2024-07-30 15:25:19', '2024-07-30 09:55:19'),
(44, 47, 2, 11, '04.png', 'rieez hateqr.png', '', 170014, 'Active', '2024-07-30 15:35:53', '2024-07-30 10:05:53'),
(45, 48, 2, 11, '', 'fgh yuqr.png', '', 170015, 'Active', '2024-07-30 15:54:19', '2024-07-30 10:24:19'),
(46, 49, 2, 11, '', 'king sqr.png', '', 170016, 'Active', '2024-07-30 16:08:37', '2024-07-30 10:38:37'),
(47, 50, 2, 11, '', 'erwuy 7ut7qr.png', '', 170017, 'Active', '2024-07-30 16:13:43', '2024-07-30 10:43:43'),
(48, 51, 1, 6, '', 'fdgdqr.png', '2024-07-30', 180023, 'Active', '2024-07-31 10:53:21', '2024-07-31 05:23:21'),
(49, 52, 2, 11, '', 'lkj gfqr.png', '', 170018, 'Active', '2024-07-31 13:12:06', '2024-07-31 07:42:06'),
(50, 53, 2, 11, '', 'hioo bgcvqr.png', '', 170019, 'Active', '2024-07-31 13:19:24', '2024-07-31 07:49:24'),
(51, 54, 2, 11, '', 'ghjh souza silvaqr.png', '', 170020, 'Active', '2024-07-31 13:29:02', '2024-07-31 07:59:02'),
(52, 55, 2, 11, '', 'test demowqr.png', '', 170021, 'Active', '2024-07-31 14:00:22', '2024-07-31 08:30:22'),
(53, 58, 2, 11, '', 'txr hyikqr.png', '', 170022, 'Active', '2024-07-31 14:25:59', '2024-07-31 08:55:59'),
(54, 59, 1, 7, '', 'dcvqr.png', '2024-08-01', 180024, 'Active', '2024-08-02 10:29:55', '2024-08-02 04:59:55'),
(55, 60, 2, 11, '', 'herin jkqr.png', '', 170023, 'Active', '2024-08-03 10:22:27', '2024-08-03 04:52:27'),
(56, 61, 2, 11, '06.png', 'kutty maqr.png', '', 170024, 'Active', '2024-08-03 10:29:11', '2024-08-03 04:59:11'),
(57, 64, 1, 6, '', 'sherlinqr.png', '2024-08-01', 180025, 'Active', '2024-08-07 14:41:23', '2024-08-07 09:11:23'),
(58, 65, 1, 6, '', 'sherlinhhqr.png', '2024-08-01', 180026, 'Active', '2024-08-07 14:44:27', '2024-08-07 09:14:27'),
(59, 66, 1, 6, '', 'gggqr.png', '2024-08-01', 180027, 'Active', '2024-08-07 14:51:21', '2024-08-07 09:21:21'),
(60, 67, 1, 1, '', 'fldg;qr.png', '1998-02-23', 180028, 'Active', '2024-08-07 14:57:51', '2024-08-07 09:27:51'),
(61, 68, 1, 3, '', 'dkqr.png', '1987-08-09', 180029, 'Active', '2024-08-07 15:00:38', '2024-08-07 09:30:38'),
(62, 69, 1, 1, '', 'offoqqqr.png', '2000-02-23', 180030, 'Active', '2024-08-07 15:05:00', '2024-08-07 09:35:00'),
(63, 70, 1, 1, '', 'kfkkfqr.png', '2000-09-09', 180031, 'Active', '2024-08-07 15:06:09', '2024-08-07 09:36:09');

-- --------------------------------------------------------

--
-- Table structure for table `admin_tbl`
--

CREATE TABLE `admin_tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_tbl`
--

INSERT INTO `admin_tbl` (`id`, `name`, `username`, `password`, `role`) VALUES
(1, 'Ragupathi', 'ragu', 'pass', 'Super Admin'),
(2, 'Priya', 'priya', 'pass', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `basic_details`
--

CREATE TABLE `basic_details` (
  `id` int(11) NOT NULL COMMENT 'Basic Details Id',
  `name` varchar(100) NOT NULL,
  `dob` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `blood_group` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `gender` enum('Male','Female','Others') NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `is_admin` enum('True','False') NOT NULL DEFAULT 'False' COMMENT 'for admin true',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='All basic information of resources';

--
-- Dumping data for table `basic_details`
--

INSERT INTO `basic_details` (`id`, `name`, `dob`, `email`, `phone`, `blood_group`, `username`, `password`, `address`, `gender`, `status`, `is_admin`, `created_at`, `updated_at`) VALUES
(1, 'Anushiya', '24-12-2001', 'anushiyapaulraj24@gmail.com', '8056775934', 'O+ ve', 'anushiya', '24-12-2001', 'kalakad', 'Female', 'Active', 'False', '2024-07-27 16:55:07', '2024-08-08 09:28:58'),
(2, 'demo', '2024-07-12', 'demo@gmail.com', '1234567890', 'A1', 'demo', '2024-07-12', '123456789098', 'Female', 'Active', 'False', '2024-07-27 17:11:58', '2024-08-06 04:57:09'),
(3, 'demo', '2024-07-10', 'demo@gmail.com', '1234567890', 'A1', 'demo001', '2024-07-10', 'kalakad', 'Female', 'Active', 'False', '2024-07-27 17:16:43', '2024-08-06 05:01:16'),
(4, 'dez v', '2024-06-30', 'sd@gmail.com', '3456789764', 'o+', 'dez v', '2024-06-30', 'kerala', 'Male', 'Active', 'False', '2024-07-27 17:21:37', '2024-08-06 05:01:22'),
(5, 'demo1', '2024-07-04', 'demo1@gmail.com', '1234567890', 'A1', 'demo1', '2024-07-04', '123456789098', 'Female', 'Active', 'False', '2024-07-27 17:23:23', '2024-08-06 05:01:10'),
(6, 'deez v', '2024-06-30', 'd@gmail.com', '9876543219', 'o+', 'deez v', '2024-06-30', 'kerala', 'Male', 'Active', 'False', '2024-07-27 17:30:24', '2024-08-06 05:01:03'),
(7, 'test', '43242423', 'fdgfd', 'teertweffd', '', 'test', '43242423', 'atest', 'Female', '', 'False', '2024-07-27 17:32:31', '2024-08-06 05:00:57'),
(8, 'dezz s', '2024-07-07', 's@gmail.com', '9876543289', '0+', 'dezz s', '2024-07-07', 'kerala', 'Male', 'Active', 'False', '2024-07-27 17:35:25', '2024-08-06 05:00:51'),
(9, 'happy', '2024-07-02', 'jmsvava3@gmail.com', '6282657440', 'o+', 'sherlinjr', '2024-07-02', 'Anandha veedu , ayathil, elavumthitta, Pathanamthitta', 'Female', 'Active', 'False', '2024-07-29 12:18:45', '2024-08-06 05:00:46'),
(10, '', 'ghfg', 'hggfh', 'gfbgh', '', '', 'ghfg', 'fdf', 'Male', '', 'False', '2024-07-29 12:35:32', '2024-08-06 05:00:40'),
(11, '', 'df', 'test@gmail.com', '8056775935', '', '1970', 'df', 'rtgf', 'Female', '', 'False', '2024-07-29 12:58:40', '2024-08-06 05:00:34'),
(12, '', '21-02-2000', 'ejemplo@ejemplo.mx', '5553428400', '', '2000', '21-02-2000', 'C. Montes Urales 445\r\nPiso 2, Apartamento 1\r\nEntre calle Volcán y calle Montes Celestes, cerca de la', 'Male', '', 'False', '2024-07-29 13:08:56', '2024-08-06 05:00:29'),
(13, 'test', '23-12-2003', 'test@example.us', '6019521325', '', 'test2003', '23-12-2003', '1600 Amphitheatre Parkway\r\nApartment 1', 'Male', '', 'False', '2024-07-29 17:01:52', '2024-08-06 05:00:21'),
(14, 'Sherlinjr', '2024-07-17', 'jmsvava3@gmail.com', '6282657440', 'a', 'sherlinjr001', '2024-07-17', 'Anandha veedu , ayathil, elavumthitta, Pathanamthitta', '', 'Active', 'False', '2024-07-29 17:02:09', '2024-08-06 05:00:15'),
(15, 'jrr', '2024-06-30', 'A@gmail.com', '9632587412', 'A+ve', 'abcd demo', '2024-06-30', 'kerala', 'Male', 'Inactive', 'False', '2024-07-29 17:02:53', '2024-08-06 05:00:09'),
(16, '', '', '', '', '', '197001', '', '', '', '', 'False', '2024-07-29 17:03:49', '2024-08-06 05:00:02'),
(17, '', '', '', '', '', '272', '', '', '', '', 'False', '2024-07-29 17:07:09', '2024-08-06 04:59:55'),
(18, '', '', '', '', '', '650', '', '', '', '', 'False', '2024-07-29 17:10:17', '2024-08-06 04:59:46'),
(19, 'dem demoo', '2024-06-30', 'dsdd@gmail.com', '1234567895', '', 'dem demoo', '2024-06-30', 'kalakad', 'Male', 'Active', 'False', '2024-07-29 17:12:04', '2024-08-06 04:59:40'),
(20, 'ewrew', '2024-07-24', 'test@gmail.com', '8056775934', '', 'ewrew', '2024-07-24', 'dfdd', 'Male', '', 'False', '2024-07-30 09:32:00', '2024-08-06 04:59:34'),
(21, 'demo', '2000-12-04', 'demo@gmail.com', '8056775935', '', 'demo2000', '2000-12-04', 'Av. dos Andradas, 3000\r\nAndar 2, Apartamento 1', 'Male', 'Active', 'False', '2024-07-30 10:00:48', '2024-08-06 04:59:28'),
(22, 'fdcvfcx', '2000-03-23', 'test@gmail.com', '8056775935', '', 'fdcvfcx', '2000-03-23', 'gfdgf', 'Male', '', 'False', '2024-07-30 10:17:09', '2024-08-06 04:59:21'),
(23, 'fdcvfcx', '2000-03-23', 'test@gmail.com', '8056775935', '', 'fdcvfcx2000', '2000-03-23', 'gfdgf', 'Male', '', 'False', '2024-07-30 10:17:17', '2024-08-06 04:59:16'),
(24, 'fdcvfcx', '2000-03-04', 'anushiyapaulraj24@gmail.com', '8056775935', '', 'fdcvfcx200004', '2000-03-04', 'fgfdgf', 'Male', '', 'False', '2024-07-30 10:26:35', '2024-08-06 04:59:10'),
(25, 'fdcvfcx', '2000-03-04', 'anushiyapaulraj24@gmail.com', '8056775935', '', 'fdcvfcx745', '2000-03-04', 'fgfdgf', 'Male', 'Active', 'False', '2024-07-30 10:26:40', '2024-08-06 04:59:05'),
(26, 'fdcvfcx', '2000-03-04', 'anushiyapaulraj24@gmail.com', '8056775935', '', 'fdcvfcx314', '2000-03-04', 'fgfdgf', 'Male', '', 'True', '2024-07-30 10:28:01', '2024-07-30 10:03:00'),
(27, 'student clg', '2024-06-30', 'stud@gmail.com', '7894561236', 'A+ve', 'student clg', '2024-06-30', 'kalakad', 'Male', 'Active', 'True', '2024-07-30 10:38:26', '2024-07-30 05:08:26'),
(28, 'Sherlinjr', '2024-07-19', 'jmsvava3@gmail.com', '6282657440', 'a', 'sherlinjr002', '2024-07-19', 'Anandha veedu , ayathil, elavumthitta, Pathanamthitta', 'Male', 'Active', 'True', '2024-07-30 10:43:42', '2024-07-30 05:13:42'),
(29, 'Sherlinjr', '2024-07-18', 'jmsvava3@gmail.com', '6282657440', 'a', 'sherlinjr003', '2024-07-18', 'Anandha veedu , ayathil, elavumthitta, Pathanamthitta', 'Female', 'Active', 'True', '2024-07-30 10:50:08', '2024-07-30 05:20:08'),
(30, 'example', '2000-02-02', 'exm@gmail.com', '805677500', '', 'example', '2000-02-02', 'fgfd', 'Male', 'Active', 'True', '2024-07-30 10:56:06', '2024-07-30 05:26:06'),
(31, 'demo', '2000-02-22', 'deo@gmail.com', '8056775930', '', 'demo200022', '2000-02-22', 'fdsfd', 'Female', 'Active', 'True', '2024-07-30 10:57:05', '2024-07-30 05:27:05'),
(32, 'emp', '2000-06-30', 'demo11@gmail.com', '0987654321', '', 'emp', '2000-06-30', 'sdd', 'Female', 'Active', 'True', '2024-07-30 11:06:28', '2024-07-30 05:36:28'),
(33, 'cds', '2000-02-22', 'swd@gmail.com', '8765435432', '', 'cds', '2000-02-22', 'gfhghf', 'Male', 'Active', 'True', '2024-07-30 11:07:55', '2024-07-30 05:37:55'),
(34, 'hari', '2002-11-25', 'hari@gmail.com', '7550300367', 'AB-', 'hari', '2002-11-25', '32uhjikikj', 'Male', 'Active', 'True', '2024-07-30 11:11:33', '2024-07-30 05:41:33'),
(35, 'stud clg', '2024-06-30', 'd@gmail.com', '7894561236', 'A+ve', 'stud clg', '2024-06-30', 'kalala', 'Male', 'Active', 'True', '2024-07-30 11:16:16', '2024-07-30 05:46:16'),
(36, 'college', '2024-06-30', 'a@gmail.com', '2314567896', '', 'clg bca', '2024-06-30', 'roriri', 'Male', 'Active', 'True', '2024-07-30 11:42:28', '2024-08-03 04:50:48'),
(37, 'Sherlinjr', '2024-07-18', 'va3@gmail.com', '7673879432', 'a', 'sherlinjr004', '2024-07-18', 'Anandha veedu , ayathil, elavumthitta, Pathanamthitta', 'Female', 'Active', 'True', '2024-07-30 12:38:41', '2024-07-30 07:08:41'),
(38, 'newstud AA', '2024-07-01', 's@22gmail.com', '5689741234', '', 'newstud aa', '2024-07-01', 'roriri', 'Male', 'Active', 'True', '2024-07-30 12:40:30', '2024-07-30 07:10:30'),
(39, 'Sherlinjr', '2002-06-12', '1234@gmail.com', '9982657440', 'a', 'sherlinjr005', '2002-06-12', 'Anandha veedu , ayathil, elavumthitta, Pathanamthitta', 'Female', 'Active', 'True', '2024-07-30 12:50:23', '2024-07-30 07:20:23'),
(40, 'newclg bca', '2024-07-09', 'fff@gmail.com', '1236547899', '', 'newclg bca', '2024-07-09', 'roriri', 'Male', 'Active', 'True', '2024-07-30 12:54:23', '2024-07-30 07:24:23'),
(41, 'Sherlin ww', '2024-07-09', 'jmsvava3@gmail.com', '0628265744', '', 'sherlin ww', '2024-07-09', 'Anandha veedu , ayathil, elavumthitta, Pathanamthitta\r\nAnand blocks company', 'Male', 'Active', 'True', '2024-07-30 14:33:26', '2024-07-30 09:03:26'),
(42, 'dem', '2024-07-01', 'k@gmail.com', '1234567890', '', 'dem fk', '2024-07-01', 'kala', 'Male', 'Active', 'True', '2024-07-30 14:42:41', '2024-08-03 04:48:07'),
(43, 'ff bg', '2024-06-30', 'kk@gmail.com', '8895626540', '', 'ff bg', '2024-06-30', 'jjjj', 'Male', '', 'True', '2024-07-30 14:44:53', '2024-08-03 05:13:14'),
(44, 'Asha', '2003-03-20', 'ashat4944@gmail.com', '9943862039', '', 'asha', '2003-03-20', 'kalakad', 'Female', 'Active', 'True', '2024-07-30 14:54:59', '2024-07-30 09:24:59'),
(45, 'Asha', '2003-03-20', 'ashat4944878@gmail.com', '9948962039', '', 'asha001', '2003-03-20', 'kalakad', 'Female', 'Active', 'True', '2024-07-30 14:56:22', '2024-07-30 09:26:22'),
(46, 'Asha T', '2003-03-20', 'ashat494468768@gmail.com', '9943862030', 'A1+', 'asha t', '2003-03-20', 'Kalakad', 'Female', 'Active', 'True', '2024-07-30 15:25:19', '2024-07-30 09:55:19'),
(47, 'rieez hate', '2024-07-01', 'l@gmail.com', '1234567898', '', 'rieez hate', '2024-07-01', 'kall', 'Male', 'Active', 'True', '2024-07-30 15:35:53', '2024-07-30 10:05:53'),
(48, 'fgh yu', '2024-07-02', 'g@gmail.com', '7894561236', '', 'fgh yu', '2024-07-02', 'hghj', 'Male', 'Active', 'True', '2024-07-30 15:54:19', '2024-07-30 10:24:19'),
(49, 'king s', '2024-06-30', 'w@gmail.com', '1234567896', '', 'king s', '2024-06-30', 'hgjg', 'Male', 'Active', 'True', '2024-07-30 16:08:37', '2024-07-30 10:38:37'),
(50, 'erwuy 7ut7', '2024-07-02', 'rtr@gmail', '4356778889', '', 'erwuy 7ut7', '2024-07-02', 'gtte', 'Male', 'Active', 'True', '2024-07-30 16:13:43', '2024-07-30 10:43:43'),
(51, 'fdgd', '2000-07-31', 'de@gmail.com', '8056775930', '', 'fdgd', '2000-07-31', 'tyty', 'Male', 'Active', 'False', '2024-07-31 10:53:21', '2024-08-06 04:58:41'),
(52, 'lkj gf', '1998-07-09', 'll@gmail.com', '', '', 'lkj gf', '1998-07-09', '', 'Female', 'Active', 'False', '2024-07-31 13:12:06', '2024-08-06 04:58:35'),
(53, 'hioo bgcv', '1999-07-02', 'hj@gmail.com', '8956231478', '', 'hioo bgcv', '1999-07-02', 'jkgkj', 'Male', 'Inactive', 'False', '2024-07-31 13:19:24', '2024-08-06 04:58:29'),
(54, 'ghjh Souza Silva', '1999-07-02', 'teste@exemplo.us', '3121286800', '', 'ghjh souza silva', '1999-07-02', 'Av. dos Andradas, 3000\r\nAndar 2, Apartamento 1', 'Female', 'Active', 'False', '2024-07-31 13:29:02', '2024-08-06 04:58:22'),
(55, 'test demow', '1998-07-01', 'test23@gmail.com', '2589637412', '', 'test demow', '1998-07-01', 'wefwewerg', 'Female', 'Active', 'False', '2024-07-31 14:00:22', '2024-08-06 04:58:15'),
(56, 'demoo txt', '2000-07-08', 'gt@gmail.com', '7894562356', '', 'demoo txt', '2000-07-08', 'kjlllll', 'Male', 'Active', 'False', '2024-07-31 14:19:36', '2024-08-06 04:58:09'),
(57, 'txt dem', '2000-07-03', 'dsa@gmail.com', '4561237896', '', 'txt dem', '2000-07-03', 'lklixdfg', 'Female', 'Active', 'False', '2024-07-31 14:23:53', '2024-08-06 04:58:03'),
(58, 'txr hyik', '2000-07-08', 'mjj@gmail.com', '4561237896', '', 'txr hyik', '2000-07-08', 'gjouil', 'Female', 'Active', 'False', '2024-07-31 14:25:59', '2024-08-06 04:57:57'),
(59, 'dcv', '2000-08-01', 'dmo@gmail.com', '8056775900', '', 'dcv', '2000-08-01', 'dfgfg', 'Male', 'Active', 'False', '2024-08-02 10:29:55', '2024-08-06 04:57:50'),
(60, 'herin jk', '2000-07-29', 'df@gmail.com', '2345678956', 'A+ve', 'herin jk', '2000-07-29', 'tamil nadu', 'Female', 'Active', 'False', '2024-08-03 10:22:27', '2024-08-06 04:57:43'),
(61, 'kutty ma', '2000-08-18', 'nh@gmail.com', '2453156236', 'A+ve', 'kutty ma', '2000-08-18', 'hjdasjkd', 'Female', 'Active', 'False', '2024-08-03 10:29:11', '2024-08-06 04:57:38'),
(62, 'Ragupathi', '', '', '', '', 'ragu', 'pass', '', 'Male', 'Active', 'True', '2024-08-06 10:37:27', '2024-08-06 05:07:27'),
(63, 'Priya', '', '', '', '', 'priya', 'pass', '', 'Female', 'Active', 'True', '2024-08-06 10:42:00', '2024-08-06 05:12:00'),
(64, 'sherlin', '2000-08-26', 'sherlin@gmail.com', '2134567896', '', 'sherlin', '2000-08-26', 'kerala', 'Female', 'Active', 'False', '2024-08-07 14:41:23', '2024-08-07 09:11:23'),
(65, 'sherlinhh', '2000-08-13', 'df33@gmail.com', '1234578963', '', 'sherlinhh', '2000-08-13', 'kerala', 'Female', 'Active', 'False', '2024-08-07 14:44:26', '2024-08-07 09:14:26'),
(66, 'ggg', '2000-07-02', 'hgh@gmail.com', '1234569875', '', 'ggg', '2000-07-02', 'kerala', 'Female', 'Active', 'False', '2024-08-07 14:51:21', '2024-08-07 09:21:21'),
(67, 'fldg;', '1998-10-20', '44qjmsvava3@gmail.com', '6282657444', 'rr', 'fldg;', '1998-10-20', 'Anandha veedu , ayathil, elavumthitta, Pathanamthitta\r\nAnand blocks company', 'Female', 'Active', 'False', '2024-08-07 14:57:51', '2024-08-07 09:27:51'),
(68, 'dk', '1998-09-09', '9jmsvava3@gmail.com', '6282657422', 'kk', 'dk', '1998-09-09', 'Anandha veedu , ayathil, elavumthitta, Pathanamthitta\r\nAnand blocks company', 'Male', 'Active', 'False', '2024-08-07 15:00:38', '2024-08-07 09:30:38'),
(69, 'offoqq', '2000-08-09', '223jmsvava3@gmail.com', '6282657454', 'dd', 'offoqq', '2000-08-09', 'Anandha veedu , ayathil, elavumthitta, Pathanamthitta\r\nAnand blocks company', 'Male', 'Active', 'False', '2024-08-07 15:05:00', '2024-08-07 09:35:00'),
(70, 'kfkkf', '2000-03-29', 'q@gmail.com', '384873833', 'LFLF', 'kfkkf', '2000-03-29', 'KDKD', 'Male', 'Active', 'False', '2024-08-07 15:06:09', '2024-08-07 09:36:09');

-- --------------------------------------------------------

--
-- Table structure for table `client_tbl`
--

CREATE TABLE `client_tbl` (
  `client_id` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `client_name` varchar(50) NOT NULL,
  `client_company` varchar(100) NOT NULL,
  `client_location` varchar(100) NOT NULL,
  `client_email` varchar(50) NOT NULL,
  `client_phone` varchar(11) NOT NULL,
  `client_gst` varchar(30) NOT NULL,
  `client_status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `client_created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `client_updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_tbl`
--

INSERT INTO `client_tbl` (`client_id`, `entity_id`, `client_name`, `client_company`, `client_location`, `client_email`, `client_phone`, `client_gst`, `client_status`, `client_created_date`, `client_updated_date`) VALUES
(1, 1, 'Jeno', 'Jeno', 'Tirunelveli', 'jeno@gmail.com', '8906745432', '', 'Active', '2024-07-30 15:35:41', '2024-07-30 10:05:41'),
(2, 1, 'demo', 'test', 'rgfdf', 'test@gmail.com', '45985960', '45', 'Inactive', '2024-07-30 15:35:54', '2024-07-30 10:05:57');

-- --------------------------------------------------------

--
-- Table structure for table `emp_additional_details`
--

CREATE TABLE `emp_additional_details` (
  `pay_id` int(11) NOT NULL COMMENT 'Payroll table id',
  `basic_id` int(11) NOT NULL COMMENT 'Basic Detail Id Reference',
  `payroll` int(11) NOT NULL,
  `experience` varchar(50) NOT NULL,
  `account_no` varchar(100) NOT NULL,
  `ifsc` varchar(100) NOT NULL,
  `branch` varchar(100) NOT NULL,
  `marrital_status` enum('Married','Unmarried') NOT NULL,
  `company_email` varchar(100) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emp_additional_details`
--

INSERT INTO `emp_additional_details` (`pay_id`, `basic_id`, `payroll`, `experience`, `account_no`, `ifsc`, `branch`, `marrital_status`, `company_email`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 15000, '0.3', '279100080200796', 'TMBL0000279', 'KALAKAD', 'Unmarried', 'anushiya@roririsoft.com', 'Active', '2024-07-27 16:55:07', '2024-07-27 11:25:07'),
(2, 7, 0, '', '', '', '', '', 'fsdf@fdg.g', 'Active', '2024-07-27 17:32:31', '2024-07-27 12:02:31'),
(3, 10, 0, '', '', '', '', 'Married', 'gfhgf', 'Active', '2024-07-29 12:35:32', '2024-07-29 07:05:32'),
(4, 11, 0, '', '', '', '', 'Married', 'anushiyaroririsoft.com', 'Active', '2024-07-29 12:58:40', '2024-07-29 07:28:40'),
(5, 12, 0, '', '', '', '', 'Unmarried', 'ejemplo@ejemplo.mx', 'Active', '2024-07-29 13:08:56', '2024-07-29 07:38:56'),
(6, 13, 1000, '', '', '', '', '', 'test@example.us', 'Active', '2024-07-29 17:01:52', '2024-07-29 11:31:52'),
(7, 16, 0, '', '', '', '', '', '', 'Active', '2024-07-29 17:03:49', '2024-07-29 11:33:49'),
(8, 17, 0, '', '', '', '', '', '', 'Active', '2024-07-29 17:07:09', '2024-07-29 11:37:09'),
(9, 18, 0, '', '', '', '', '', '', 'Active', '2024-07-29 17:10:18', '2024-07-29 11:40:18'),
(10, 20, 0, '', '', '', '', 'Married', 'test@example.us', 'Active', '2024-07-30 09:32:00', '2024-07-30 04:02:00'),
(11, 21, 10000, '', '', '', '', 'Married', 'teste@exemplo.us', 'Active', '2024-07-30 10:00:48', '2024-07-30 04:30:48'),
(12, 22, 0, '', '', '', '', 'Married', 'test@example.us', 'Active', '2024-07-30 10:17:09', '2024-07-30 04:47:09'),
(13, 23, 0, '', '', '', '', 'Married', 'test@example.us', 'Active', '2024-07-30 10:17:17', '2024-07-30 04:47:17'),
(14, 24, 0, '', '', '', '', 'Married', '', 'Active', '2024-07-30 10:26:35', '2024-07-30 04:56:35'),
(15, 25, 0, '', '', '', '', 'Married', '', 'Active', '2024-07-30 10:26:40', '2024-07-30 04:56:40'),
(16, 26, 0, '', '', '', '', 'Married', '', 'Active', '2024-07-30 10:28:01', '2024-07-30 04:58:01'),
(17, 30, 0, '', '', '', '', 'Married', '', 'Active', '2024-07-30 10:56:06', '2024-07-30 05:26:06'),
(18, 31, 0, '', '', '', '', 'Married', '', 'Active', '2024-07-30 10:57:05', '2024-07-30 05:27:05'),
(19, 32, 0, '', '', '', '', 'Unmarried', '', 'Active', '2024-07-30 11:06:28', '2024-07-30 05:36:28'),
(20, 33, 0, '', '', '', '', 'Married', '', 'Active', '2024-07-30 11:07:55', '2024-07-30 05:37:55'),
(21, 34, 0, '', '', '', '', 'Unmarried', '', 'Active', '2024-07-30 11:11:33', '2024-07-30 05:41:33'),
(22, 46, 0, '', '', '', '', 'Unmarried', 'ashat@roririsoft.com', 'Active', '2024-07-30 15:25:19', '2024-07-30 09:55:19'),
(23, 51, 0, '', '', '', '', 'Married', '', 'Active', '2024-07-31 10:53:21', '2024-07-31 05:23:21'),
(24, 59, 1500, '', '', '', '', 'Unmarried', 'test@gmail.com', 'Active', '2024-08-02 10:29:55', '2024-08-02 04:59:55'),
(25, 64, 0, '', '', '', '', 'Unmarried', 'sherlin@roririsoft.com', 'Active', '2024-08-07 14:41:23', '2024-08-07 09:11:23'),
(26, 65, 0, '', '', '', '', 'Unmarried', 'dd@roririsoft.com', 'Active', '2024-08-07 14:44:27', '2024-08-07 09:14:27'),
(27, 66, 0, '', '', '', '', 'Unmarried', 'dfs@gmail.com', 'Active', '2024-08-07 14:51:21', '2024-08-07 09:21:21'),
(28, 67, 0, '', '', '', '', 'Married', 'jmsvava3@gmail.com', 'Active', '2024-08-07 14:57:51', '2024-08-07 09:27:51'),
(29, 68, 0, '', '', '', '', 'Married', 'jmsvava3@gmail.com', 'Active', '2024-08-07 15:00:39', '2024-08-07 09:30:39'),
(30, 69, 0, '', '', '', '', 'Married', 'jmsvava3@gmail.com', 'Active', '2024-08-07 15:05:00', '2024-08-07 09:35:00'),
(31, 70, 0, '', '', '', '', 'Married', 'kdkd@gmil.com', 'Active', '2024-08-07 15:06:09', '2024-08-07 09:36:09');

-- --------------------------------------------------------

--
-- Table structure for table `entity_tbl`
--

CREATE TABLE `entity_tbl` (
  `entity_id` int(11) NOT NULL,
  `entity_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `entity_tbl`
--

INSERT INTO `entity_tbl` (`entity_id`, `entity_name`) VALUES
(1, 'RORIRI SOFTWARE SOLUTIONS '),
(2, 'NEXGEN IT COLLEGE'),
(3, 'NEXGEN IT ACADEMY'),
(4, 'RORIRI FOUNDATION'),
(5, 'RORIRI GROUPS'),
(6, 'RIYA IAS ACADEMY'),
(7, 'ROSHAN TILES'),
(8, 'RITHISH FARMS'),
(9, 'RIYA INFO SYSTEM'),
(10, 'NEXEMY');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `pay_id` int(11) NOT NULL COMMENT 'Payment table id',
  `basic_id` int(11) NOT NULL COMMENT 'Basic details table id foreign key reference',
  `entity_id` int(11) NOT NULL COMMENT 'Entity table entity id foreign key reference',
  `received_amnt` int(11) NOT NULL,
  `received_date` varchar(100) NOT NULL,
  `received_by` varchar(100) NOT NULL,
  `pay_method` enum('Cash','Net Banking','Online Payment','Cheque') NOT NULL,
  `tranx_id` varchar(100) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_amount`
--

CREATE TABLE `project_amount` (
  `pro_amt_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `amnt_received` int(11) NOT NULL,
  `pay_date` date NOT NULL,
  `pay_mode` enum('Cash','Net Banking','Online Payment','Cheque') NOT NULL,
  `received_by` varchar(50) NOT NULL,
  `tranx_id` varchar(11) NOT NULL,
  `pay_status` enum('Paid','Unpaid','Partially') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_amount`
--

INSERT INTO `project_amount` (`pro_amt_id`, `project_id`, `amnt_received`, `pay_date`, `pay_mode`, `received_by`, `tranx_id`, `pay_status`, `created_at`, `updated_at`) VALUES
(1, 1, 500, '2024-08-01', 'Cash', 'Anushiya', '01', '', '2024-08-01 11:17:40', '2024-08-01 05:47:40'),
(2, 1, 500, '2024-08-01', 'Cash', 'Anushiya', '02', '', '2024-08-01 12:48:22', '2024-08-01 07:18:22'),
(3, 1, 500, '2024-08-01', 'Cash', 'Anushiya', '03', '', '2024-08-01 12:56:37', '2024-08-01 07:26:37'),
(4, 1, 500, '2024-08-01', 'Cash', 'Anushiya', '04', 'Paid', '2024-08-01 14:25:34', '2024-08-01 08:55:34'),
(5, 1, 500, '2024-08-01', 'Cash', 'Anushiya', '05', 'Paid', '2024-08-01 14:26:07', '2024-08-01 08:56:07'),
(6, 1, 5000, '2024-08-01', 'Cash', 'Anushiya', '06', '', '2024-08-01 14:27:00', '2024-08-01 08:57:00');

-- --------------------------------------------------------

--
-- Table structure for table `project_tbl`
--

CREATE TABLE `project_tbl` (
  `project_id` int(11) NOT NULL,
  `project_name` varchar(50) NOT NULL,
  `services` varchar(200) NOT NULL,
  `technology` varchar(200) NOT NULL,
  `developers` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `client` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `duration` int(11) NOT NULL,
  `total_pay` int(11) NOT NULL,
  `description` varchar(200) NOT NULL,
  `pay_status` enum('Pending','Completed') NOT NULL DEFAULT 'Pending',
  `project_status` enum('Completed','New','In Progress') NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_tbl`
--

INSERT INTO `project_tbl` (`project_id`, `project_name`, `services`, `technology`, `developers`, `client`, `start_date`, `duration`, `total_pay`, `description`, `pay_status`, `project_status`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Jeno', '[\"1\",\"4\"]', '[\"1\",\"2\"]', '[\"1\",\"25\"]', 1, '2024-07-16', 30, 10000, ' University', 'Pending', 'New', 'Active', '2024-07-31 14:23:55', '2024-07-31 08:53:55'),
(2, 'demo', '[\"1\",\"4\"]', '[\"1\",\"3\"]', '[\"31\"]', 1, '2024-07-16', 30, 10000, ' demo', 'Pending', 'New', 'Active', '2024-07-31 14:34:22', '2024-07-31 09:04:22'),
(3, '', 'null', 'null', 'null', 0, '0000-00-00', 0, 0, ' ', 'Pending', '', 'Inactive', '2024-07-31 17:35:38', '2024-07-31 12:05:38'),
(4, '', 'null', 'null', 'null', 0, '0000-00-00', 0, 0, ' ', 'Pending', '', 'Inactive', '2024-07-31 17:35:42', '2024-07-31 12:05:42'),
(5, '', 'null', 'null', 'null', 0, '0000-00-00', 0, 0, ' ', 'Pending', '', 'Inactive', '2024-08-01 09:39:19', '2024-08-01 04:09:19'),
(6, '', 'null', 'null', 'null', 0, '0000-00-00', 0, 0, ' ', 'Pending', '', 'Inactive', '2024-08-01 09:39:45', '2024-08-01 04:09:45'),
(7, '', 'null', 'null', 'null', 0, '0000-00-00', 0, 0, ' ', 'Pending', '', 'Inactive', '2024-08-01 09:45:11', '2024-08-01 04:15:11'),
(8, '', 'null', 'null', 'null', 0, '0000-00-00', 0, 0, ' ', 'Pending', '', 'Inactive', '2024-08-01 09:48:46', '2024-08-01 04:18:46'),
(9, 'test', '[\"\"]', '[\"2\",\"4\"]', '[\"1\",\"30\"]', 1, '2024-08-01', 3, 10000, ' ', 'Pending', 'New', 'Active', '2024-08-01 10:33:18', '2024-08-01 05:03:18');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `date`, `status`) VALUES
(1, 'CEO', '2024-07-25 16:28:01', 'Active'),
(2, 'CTO', '2024-07-25 16:28:13', 'Active'),
(3, 'Business Analyst', '2024-07-25 16:28:36', 'Active'),
(4, 'HR', '2024-07-25 16:28:44', 'Active'),
(5, 'Project Manager', '2024-07-25 16:28:58', 'Active'),
(6, 'Developer', '2024-07-25 16:29:07', 'Active'),
(7, 'Designer', '2024-07-25 16:29:21', 'Active'),
(8, 'Digital Marketing', '2024-07-25 16:29:33', 'Active'),
(9, 'Trainer', '2024-07-25 16:30:08', 'Active'),
(10, 'Trainee', '2024-07-25 16:30:15', 'Active'),
(11, 'Student', '2024-07-25 16:30:23', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(100) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ERP', 'Active', '2024-07-31 11:22:58', '2024-07-31 05:52:58'),
(2, 'Website(Static)', 'Active', '2024-07-31 11:23:35', '2024-07-31 05:53:35'),
(3, 'Website(Dynamic)', 'Active', '2024-07-31 11:23:46', '2024-07-31 05:53:46'),
(4, 'Logo Design', 'Active', '2024-07-31 11:23:57', '2024-07-31 05:53:57'),
(5, 'Mobile Application', 'Active', '2024-07-31 11:24:22', '2024-07-31 05:54:22'),
(6, 'Multimedia ', 'Active', '2024-07-31 11:24:50', '2024-07-31 05:54:50'),
(7, 'Marketing', 'Active', '2024-07-31 11:24:58', '2024-07-31 05:54:58');

-- --------------------------------------------------------

--
-- Table structure for table `student_additional_details`
--

CREATE TABLE `student_additional_details` (
  `id` int(11) NOT NULL,
  `basic_id` int(11) NOT NULL COMMENT 'basic_table id\r\n',
  `college_course` varchar(600) NOT NULL,
  `course_fee` int(11) NOT NULL,
  `father_name` varchar(600) NOT NULL,
  `father_occupation` varchar(700) NOT NULL,
  `father_phone_number` int(11) NOT NULL,
  `mother_name` varchar(700) NOT NULL,
  `mother_occupation` varchar(700) NOT NULL,
  `mother_phone_number` int(11) NOT NULL,
  `12th_mark` int(11) NOT NULL,
  `10th_mark` int(11) NOT NULL,
  `12th_marksheet` text NOT NULL,
  `10th_marksheet` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `technology`
--

CREATE TABLE `technology` (
  `tech_id` int(11) NOT NULL,
  `tech_name` varchar(100) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `technology`
--

INSERT INTO `technology` (`tech_id`, `tech_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'PHP', 'Active', '2024-07-31 11:26:43', '2024-07-31 05:56:43'),
(2, 'React JS', 'Active', '2024-07-31 11:28:34', '2024-07-31 05:58:34'),
(3, 'React Native', 'Active', '2024-07-31 11:28:45', '2024-07-31 05:58:45'),
(4, 'Flutter', 'Active', '2024-07-31 11:29:05', '2024-07-31 05:59:05'),
(5, 'Python ', 'Active', '2024-07-31 11:29:17', '2024-07-31 05:59:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_details`
--
ALTER TABLE `additional_details`
  ADD PRIMARY KEY (`add_id`);

--
-- Indexes for table `admin_tbl`
--
ALTER TABLE `admin_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `basic_details`
--
ALTER TABLE `basic_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_tbl`
--
ALTER TABLE `client_tbl`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `emp_additional_details`
--
ALTER TABLE `emp_additional_details`
  ADD PRIMARY KEY (`pay_id`);

--
-- Indexes for table `entity_tbl`
--
ALTER TABLE `entity_tbl`
  ADD PRIMARY KEY (`entity_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`pay_id`);

--
-- Indexes for table `project_amount`
--
ALTER TABLE `project_amount`
  ADD PRIMARY KEY (`pro_amt_id`);

--
-- Indexes for table `project_tbl`
--
ALTER TABLE `project_tbl`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `student_additional_details`
--
ALTER TABLE `student_additional_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `technology`
--
ALTER TABLE `technology`
  ADD PRIMARY KEY (`tech_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_details`
--
ALTER TABLE `additional_details`
  MODIFY `add_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Additional detail Id', AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `admin_tbl`
--
ALTER TABLE `admin_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `basic_details`
--
ALTER TABLE `basic_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Basic Details Id', AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `client_tbl`
--
ALTER TABLE `client_tbl`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `emp_additional_details`
--
ALTER TABLE `emp_additional_details`
  MODIFY `pay_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Payroll table id', AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `entity_tbl`
--
ALTER TABLE `entity_tbl`
  MODIFY `entity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `pay_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Payment table id';

--
-- AUTO_INCREMENT for table `project_amount`
--
ALTER TABLE `project_amount`
  MODIFY `pro_amt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `project_tbl`
--
ALTER TABLE `project_tbl`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student_additional_details`
--
ALTER TABLE `student_additional_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `technology`
--
ALTER TABLE `technology`
  MODIFY `tech_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
