-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2024 at 08:51 AM
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
  `Charge` varchar(50) NOT NULL DEFAULT 'Daily'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vehicle_info`
--

INSERT INTO `vehicle_info` (`ID`, `Registered_by`, `Updated_by`, `Owner_name`, `Vehicle_name`, `Vehicle_number`, `Entry_date`, `Exit_date`, `Token_number`, `Charge`) VALUES
(1, 'guest', 'guest', 'Hari Shrestha', 'Ford', 'GA 43 CHA 2347', '2024-04-29 20:19:00', '2024-04-30 20:37:00', 1, 'daily'),
(2, 'guest', 'singh', 'Sita Kapoor', 'Toyota', 'BA 2 KHA 2024', '2024-04-30 13:19:00', '2024-04-30 20:39:00', 2, 'daily'),
(3, '', 'guest', 'Singh', 'Hyundai kona ev', 'BA 2 KHA 2024', '2024-04-30 22:35:00', '2024-04-30 23:01:00', 3, 'daily'),
(10, 'guest', 'singh', 'Ram', 'Toyota', 'GA 1 KHA 1111', '2024-05-01 22:17:00', '2024-05-03 22:36:00', 4, 'daily'),
(13, '', '', 'nita', 'toyota', 'ba 2 kha 3847', '2024-05-03 22:56:00', NULL, 5, 'daily'),
(14, '', 'guest', 'Rita', 'Hyundai kona ev', 'BA 88 GA 2342', '2024-05-03 22:57:00', '2024-05-03 23:15:00', 6, 'daily'),
(15, '', 'Guest', 'Kushi', 'Jaguar', 'AB 12 CD 3456', '2024-05-12 20:19:00', '2024-05-13 20:19:00', 7, 'daily'),
(16, 'Guest', 'Guest', 'Kushi', 'Jaguar', 'AB 12 CD 3456', '2024-05-13 20:22:00', '2024-05-13 20:24:00', 8, 'daily'),
(17, 'Guest', '', 'Latika', 'Toyota', 'QQ 20 WW 1234', '2024-05-11 20:27:00', NULL, 9, 'daily'),
(20, 'Guest', 'Guest', 'Niti', 'Honda', 'RQ 23 TT 4203', '2024-05-06 20:38:00', '2024-05-13 20:39:00', 10, 'daily'),
(21, 'Guest', '', 'Vidya', 'Toyota', 'BA 23 KHA 2404', '2024-05-12 20:39:00', NULL, 11, 'daily'),
(24, 'Guest', 'Guest', 'Try', 'Try', 'TRY TRY', '2024-05-25 12:09:00', '2024-05-25 12:16:00', 12, '0'),
(25, 'Guest', 'Guest', 'Try', 'Try', 'TRY TRY', '2024-05-24 12:19:00', '2024-05-25 12:19:00', 12, '0'),
(26, 'Guest', 'Guest', 'Try', 'Try', 'TRY TRY', '2024-05-25 12:19:00', '2024-05-25 12:23:00', 12, 'Daily'),
(27, 'Guest', 'Guest', 'Try', 'Try', 'TRY TRY1', '2024-05-19 12:31:00', '2024-05-25 12:31:00', 12, 'Daily'),
(28, '--', 'Guest', 'Try', 'Try', 'TRY TRY1', '2024-05-19 12:31:00', '2024-05-25 12:31:00', 12, 'Monthly');

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
