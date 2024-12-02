-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2024 at 06:09 PM
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
-- Database: `vitaflow`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminId` int(11) NOT NULL,
  `AdminName` varchar(30) DEFAULT NULL,
  `DonorId` int(11) DEFAULT NULL,
  `ReceiverId` int(11) DEFAULT NULL,
  `BloodGroupId` int(11) DEFAULT NULL,
  `Password` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminId`, `AdminName`, `DonorId`, `ReceiverId`, `BloodGroupId`, `Password`) VALUES
(8, 'Admin', NULL, NULL, 4, '$2y$10$rAHWswojeaxJhVf41FiUAeqiXoyobK4S/XuuUoRUB7HrQ5FWhI/Q2');

-- --------------------------------------------------------

--
-- Table structure for table `bloodgroup`
--

CREATE TABLE `bloodgroup` (
  `BloodGroupId` int(11) NOT NULL,
  `BloodType` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bloodgroup`
--

INSERT INTO `bloodgroup` (`BloodGroupId`, `BloodType`) VALUES
(1, '[B+]'),
(2, '[B-]'),
(3, '[O+]'),
(4, '[O-]'),
(5, '[AB+]'),
(6, 'A+'),
(7, 'A-');

-- --------------------------------------------------------

--
-- Table structure for table `bloodrequest`
--

CREATE TABLE `bloodrequest` (
  `BloodRequestId` int(11) NOT NULL,
  `ReceiverId` int(11) DEFAULT NULL,
  `DonorId` int(11) DEFAULT NULL,
  `ReceiverName` varchar(10) DEFAULT NULL,
  `ReceiverPhone` varchar(15) DEFAULT NULL,
  `DonorName` varchar(20) DEFAULT NULL,
  `BloodGroupId` int(11) DEFAULT NULL,
  `BloodType` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

CREATE TABLE `donor` (
  `DonorId` int(11) NOT NULL,
  `DonorName` varchar(20) DEFAULT NULL,
  `BloodGroupId` int(11) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  `Password` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `receiver`
--

CREATE TABLE `receiver` (
  `ReceiverId` int(11) NOT NULL,
  `ReceiverName` varchar(10) DEFAULT NULL,
  `BloodGroupId` int(11) DEFAULT NULL,
  `DonorId` int(11) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  `Password` varchar(250) DEFAULT NULL,
  `UserName` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminId`),
  ADD KEY `BloodGroupId` (`BloodGroupId`),
  ADD KEY `DonorId` (`DonorId`),
  ADD KEY `ReceiverId` (`ReceiverId`);

--
-- Indexes for table `bloodgroup`
--
ALTER TABLE `bloodgroup`
  ADD PRIMARY KEY (`BloodGroupId`);

--
-- Indexes for table `bloodrequest`
--
ALTER TABLE `bloodrequest`
  ADD PRIMARY KEY (`BloodRequestId`),
  ADD KEY `ReceiverId` (`ReceiverId`),
  ADD KEY `DonorId` (`DonorId`),
  ADD KEY `BloodGroupId` (`BloodGroupId`);

--
-- Indexes for table `donor`
--
ALTER TABLE `donor`
  ADD PRIMARY KEY (`DonorId`),
  ADD KEY `BloodGroupId` (`BloodGroupId`);

--
-- Indexes for table `receiver`
--
ALTER TABLE `receiver`
  ADD PRIMARY KEY (`ReceiverId`),
  ADD KEY `BloodGroupId` (`BloodGroupId`),
  ADD KEY `DonorId` (`DonorId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `bloodgroup`
--
ALTER TABLE `bloodgroup`
  MODIFY `BloodGroupId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bloodrequest`
--
ALTER TABLE `bloodrequest`
  MODIFY `BloodRequestId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `donor`
--
ALTER TABLE `donor`
  MODIFY `DonorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `receiver`
--
ALTER TABLE `receiver`
  MODIFY `ReceiverId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`BloodGroupId`) REFERENCES `bloodgroup` (`BloodGroupId`),
  ADD CONSTRAINT `admin_ibfk_2` FOREIGN KEY (`DonorId`) REFERENCES `donor` (`DonorId`),
  ADD CONSTRAINT `admin_ibfk_3` FOREIGN KEY (`ReceiverId`) REFERENCES `receiver` (`ReceiverId`);

--
-- Constraints for table `bloodrequest`
--
ALTER TABLE `bloodrequest`
  ADD CONSTRAINT `bloodrequest_ibfk_1` FOREIGN KEY (`ReceiverId`) REFERENCES `receiver` (`ReceiverId`),
  ADD CONSTRAINT `bloodrequest_ibfk_2` FOREIGN KEY (`DonorId`) REFERENCES `donor` (`DonorId`),
  ADD CONSTRAINT `bloodrequest_ibfk_3` FOREIGN KEY (`BloodGroupId`) REFERENCES `bloodgroup` (`BloodGroupId`);

--
-- Constraints for table `donor`
--
ALTER TABLE `donor`
  ADD CONSTRAINT `donor_ibfk_1` FOREIGN KEY (`BloodGroupId`) REFERENCES `bloodgroup` (`BloodGroupId`);

--
-- Constraints for table `receiver`
--
ALTER TABLE `receiver`
  ADD CONSTRAINT `receiver_ibfk_1` FOREIGN KEY (`BloodGroupId`) REFERENCES `bloodgroup` (`BloodGroupId`),
  ADD CONSTRAINT `receiver_ibfk_2` FOREIGN KEY (`DonorId`) REFERENCES `donor` (`DonorId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
