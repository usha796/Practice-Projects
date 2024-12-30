-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2024 at 10:08 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parking_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_info`
--

CREATE TABLE `admin_info` (
  `username` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_info`
--

INSERT INTO `admin_info` (`username`, `password`) VALUES
('admin', 'admin'),
('guest', '3e03d1b4bebdb37dc5d45d9d1e92f029521fd859'),
('singh', '8242e7e6364605d5aa899556378694fd66e492e1');

-- --------------------------------------------------------

--
-- Table structure for table `update_info`
--

CREATE TABLE `update_info` (
  `Registered_by` varchar(50) NOT NULL,
  `Updated_by` varchar(50) NOT NULL,
  `Owner_name` varchar(50) NOT NULL,
  `Vehicle_name` varchar(40) NOT NULL,
  `Vehicle_number` varchar(40) NOT NULL,
  `Entry_date` datetime NOT NULL,
  `Exit_date` datetime NOT NULL,
  `Token_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `update_info`
--

INSERT INTO `update_info` (`Registered_by`, `Updated_by`, `Owner_name`, `Vehicle_name`, `Vehicle_number`, `Entry_date`, `Exit_date`, `Token_number`) VALUES
('guest', '', 'Sita Kapoor', 'Jaguar', 'BA 3 GA 2342', '2024-02-02 13:22:00', '2024-04-23 23:00:00', 12),
('', 'guest', 'Sita Kapoor', 'Jaguar', 'BA 3 GA 2342', '2024-02-02 13:22:00', '2024-04-23 23:05:00', 12),
('', 'singh', 'Singh', 'Toyota', 'BA 2 KHA 2024', '2024-02-01 10:37:00', '2024-04-23 23:15:00', 50),
('', 'singh', 'Gaurav Shrestha', 'Ford', 'GA 1 KHA 1111', '2024-02-18 10:39:00', '2024-04-23 23:19:00', 2),
('guest', 'singh', 'Karan Wahi', 'Hyundai kona ev', 'GA 1 GHA 6345', '2024-04-23 22:57:00', '2024-04-23 23:21:00', 13),
('', 'singh', 'Gaurav Shrestha', 'Ford', 'GA 1 KHA 1111', '2024-02-18 10:39:00', '2024-05-01 19:19:00', 2),
('', 'guest', 'Singh', 'Toyota', 'BA 2 KHA 2024', '2024-02-01 10:37:00', '2024-05-02 19:21:00', 50),
('guest', 'guest', 'Sita Kapoor', 'Toyota', 'BA 2 KHA 2024', '2024-04-30 13:19:00', '2024-04-30 20:22:00', 2),
('guest', 'guest', 'Sita Kapoor', 'Toyota', 'BA 2 KHA 2024', '2024-04-30 13:19:00', '2024-04-30 20:25:00', 2),
('', '', 'Singh', 'Hyundai kona ev', 'BA 2 KHA 2024', '2024-04-30 22:35:00', '2024-04-30 22:42:00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_info`
--

CREATE TABLE `vehicle_info` (
  `ID` int(11) NOT NULL,
  `Registered_by` varchar(50) NOT NULL,
  `Updated_by` varchar(50) NOT NULL,
  `Owner_name` varchar(50) NOT NULL,
  `Vehicle_name` varchar(40) NOT NULL,
  `Vehicle_number` varchar(40) DEFAULT NULL,
  `Entry_date` datetime NOT NULL,
  `Exit_date` datetime DEFAULT NULL,
  `Token_number` int(11) NOT NULL,
  `Charge` varchar(50) NOT NULL DEFAULT 'Daily',
  `Fare` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vehicle_info`
--

INSERT INTO `vehicle_info` (`ID`, `Registered_by`, `Updated_by`, `Owner_name`, `Vehicle_name`, `Vehicle_number`, `Entry_date`, `Exit_date`, `Token_number`, `Charge`, `Fare`) VALUES
(1, 'guest', 'guest', 'Hari Shrestha', 'Ford', 'GA 43 CHA 2347', '2024-04-29 20:19:00', '2024-04-30 20:37:00', 1, 'daily', 243),
(2, 'guest', 'singh', 'Sita Kapoor', 'Toyota', 'BA 2 KHA 2024', '2024-04-30 13:19:00', '2024-04-30 20:39:00', 2, 'daily', 73),
(3, '', 'guest', 'Singh', 'Hyundai kona ev', 'BA 2 KHA 2024', '2024-04-30 22:35:00', '2024-04-30 23:01:00', 3, 'daily', 4),
(10, 'guest', 'singh', 'Ram', 'Toyota', 'GA 1 KHA 1111', '2024-05-01 22:17:00', '2024-05-03 22:36:00', 4, 'daily', 483),
(13, '', '', 'nita', 'toyota', 'ba 2 kha 3847', '2024-05-03 22:56:00', NULL, 5, 'daily', 0),
(14, '', 'guest', 'Rita', 'Hyundai kona ev', 'BA 88 GA 2342', '2024-05-03 22:57:00', '2024-05-03 23:15:00', 6, 'daily', 3),
(15, '', 'Guest', 'Kushi', 'Jaguar', 'AB 12 CD 3456', '2024-05-12 20:19:00', '2024-05-13 20:19:00', 7, 'daily', 240),
(16, 'Guest', 'Guest', 'Kushi', 'Jaguar', 'AB 12 CD 3456', '2024-05-13 20:22:00', '2024-05-13 20:24:00', 8, 'daily', 0),
(17, 'Guest', '', 'Latika', 'Toyota', 'QQ 20 WW 1234', '2024-05-11 20:27:00', NULL, 9, 'daily', 0),
(20, 'Guest', 'Guest', 'Niti', 'Honda', 'RQ 23 TT 4203', '2024-05-06 20:38:00', '2024-05-13 20:39:00', 10, 'daily', 1680),
(21, 'Guest', '', 'Vidya', 'Toyota', 'BA 23 KHA 2404', '2024-05-12 20:39:00', NULL, 11, 'daily', 0),
(24, 'Guest', 'Guest', 'Try', 'Try', 'TRY TRY', '2024-05-25 12:09:00', '2024-05-25 12:16:00', 12, '0', 1),
(25, 'Guest', 'Guest', 'Try', 'Try', 'TRY TRY', '2024-05-24 12:19:00', '2024-05-25 12:19:00', 12, '0', 240),
(26, 'Guest', 'Guest', 'Try', 'Try', 'TRY TRY', '2024-05-25 12:19:00', '2024-05-25 12:23:00', 12, 'Daily', 1),
(27, 'Guest', 'Guest', 'Try', 'Try', 'TRY TRY1', '2024-05-19 12:31:00', '2024-05-25 12:31:00', 12, 'Daily', 2160),
(28, '--', 'Guest', 'Try', 'Try', 'TRY TRY1', '2024-05-19 12:31:00', '2024-05-25 12:31:00', 12, 'Monthly', 1440),
(29, 'Guest', '', 'Token Try', 'Token', 'TRY T', '2024-05-25 13:30:00', NULL, 1, 'Daily', 0),
(30, 'Guest', '', 'Token Try2', 'Token', 'TRY T2', '2024-05-25 13:30:00', NULL, 2, 'Daily', 0),
(31, 'Guest', '', 'Token Try2', 'Token', 'TRY T3', '2024-05-25 13:30:00', NULL, 3, 'Select charge', 0),
(32, 'Guest', 'Guest', 'Token Try2', 'Token', 'TRY T4', '2024-05-25 13:32:00', '2024-05-25 13:35:00', 4, 'Monthly', 1),
(33, 'Guest', '', 'Token Try2', 'Token', 'TRY T5', '2024-05-25 13:32:00', NULL, 6, 'Monthly', 0),
(34, 'Guest', '', 'Token Try6', 'Token', 'TRY T6', '2024-05-25 13:32:00', NULL, 7, 'Monthly', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vehicle_info`
--
ALTER TABLE `vehicle_info`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vehicle_info`
--
ALTER TABLE `vehicle_info`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
