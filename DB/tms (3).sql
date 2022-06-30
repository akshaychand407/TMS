-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2022 at 04:34 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tms`
--

-- --------------------------------------------------------

--
-- Table structure for table `task_tb`
--

CREATE TABLE `task_tb` (
  `Id` int(11) NOT NULL,
  `TaskName` varchar(50) NOT NULL,
  `TeamName` varchar(50) NOT NULL,
  `EstimatedTime` varchar(50) NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `LastModifiedBy` varchar(50) NOT NULL,
  `LastModifiedDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `RecordStatus` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task_tb`
--

INSERT INTO `task_tb` (`Id`, `TaskName`, `TeamName`, `EstimatedTime`, `CreatedBy`, `CreatedDate`, `LastModifiedBy`, `LastModifiedDate`, `RecordStatus`) VALUES
(1, 'IT', '1', '30', '1', '2022-03-01 10:25:23', '1', '2022-03-01 04:55:23', 1),
(2, 'Invoice', '5', '60', '1', '2022-03-01 10:25:41', '1', '2022-03-01 04:55:41', 1),
(3, 'VAT', '3', '120', '1', '2022-03-01 10:26:22', '1', '2022-03-01 04:56:22', 1),
(4, 'Payroll', '4', '30', '1', '2022-03-01 10:26:47', '1', '2022-03-01 04:56:47', 1),
(5, 'Income Tax', '2', '60', '1', '2022-03-01 10:27:19', '1', '2022-03-01 04:57:19', 1),
(6, 'Invoice', '5', '40', '1', '2022-03-07 10:41:25', '1', '2022-03-07 10:41:49', 0),
(7, 'Invoice', '5', '33', '1', '2022-03-07 10:43:07', '1', '2022-03-07 10:45:27', 0),
(8, 'Invoice', '5', '66', '1', '2022-03-07 10:45:02', '1', '2022-03-07 10:45:21', 0),
(9, 'Invoice', '5', '33', '1', '2022-03-07 10:50:35', '1', '2022-03-07 10:59:58', 0),
(10, 'Invoice', '5', '66', '1', '2022-03-07 10:52:46', '1', '2022-03-07 11:00:09', 0);

-- --------------------------------------------------------

--
-- Table structure for table `team_tb`
--

CREATE TABLE `team_tb` (
  `Id` int(11) NOT NULL,
  `TeamName` varchar(50) NOT NULL,
  `TeamLeader` varchar(50) NOT NULL,
  `TeamManager` varchar(50) NOT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastModifiedDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `LastModifiedBy` int(11) NOT NULL,
  `RecordStatus` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team_tb`
--

INSERT INTO `team_tb` (`Id`, `TeamName`, `TeamLeader`, `TeamManager`, `CreatedDate`, `CreatedBy`, `LastModifiedDate`, `LastModifiedBy`, `RecordStatus`) VALUES
(1, 'IT', '5', '6', '2022-03-01 09:49:57', 1, '2022-03-01 04:19:57', 1, 1),
(2, 'Income Tax', '2', '3', '2022-03-01 09:51:07', 1, '2022-03-01 04:41:36', 1, 1),
(3, 'VAT', '7', '9', '2022-03-01 10:09:32', 1, '2022-03-01 04:39:32', 1, 1),
(4, 'Payroll', '8', '10', '2022-03-01 10:10:03', 1, '2022-03-01 04:40:03', 1, 1),
(5, 'Invoice', '11', '13', '2022-03-01 10:10:35', 1, '2022-03-01 04:40:35', 1, 1),
(6, 'Income Tax', '12', '14', '2022-03-07 11:07:19', 1, '2022-03-07 05:37:19', 1, 0),
(7, 'Income Tax', '12', '14', '2022-03-07 11:19:22', 1, '2022-03-07 05:49:22', 1, 0),
(8, 'Income Tax', '12', '14', '2022-03-07 11:20:55', 1, '2022-03-07 05:50:55', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_tb`
--

CREATE TABLE `users_tb` (
  `Id` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Designation` varchar(50) NOT NULL,
  `Managers` varchar(50) NOT NULL,
  `RecordStatus` tinyint(1) NOT NULL DEFAULT 1,
  `FailedAttempts` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_tb`
--

INSERT INTO `users_tb` (`Id`, `FirstName`, `LastName`, `Email`, `Password`, `Designation`, `Managers`, `RecordStatus`, `FailedAttempts`) VALUES
(1, 'Akshay', 'T', 'akshay@gmail.com', '$2y$10$XEL1meyKx.H440RDPGEQQeDOPiSTVpETaKo6ckrs2ndd5NSGvES0G', 'Head of Operation', '', 1, 2),
(2, 'Arun', 'KTK', 'Arun@gmail.com', '$2y$10$XEL1meyKx.H440RDPGEQQeDOPiSTVpETaKo6ckrs2ndd5NSGvES0G', 'Team Leader', '3', 1, 0),
(3, 'Ritwik', 'R', 'ritwik@gmail.com', '$2y$10$XEL1meyKx.H440RDPGEQQeDOPiSTVpETaKo6ckrs2ndd5NSGvES0G', 'Team Manager', '', 1, 0),
(4, 'Ananthu', 'Haridas', 'ananthu@gmail.com', '$2y$10$XEL1meyKx.H440RDPGEQQeDOPiSTVpETaKo6ckrs2ndd5NSGvES0G', 'Employee', '2,3', 1, 0),
(5, 'Muhammed', 'Safriyab', 'safri@gmail.com', '$2y$10$XEL1meyKx.H440RDPGEQQeDOPiSTVpETaKo6ckrs2ndd5NSGvES0G', 'Team Leader', '6', 1, 0),
(6, 'Rejas', 'Rasak', 'rejas@gmail.com', '$2y$10$XEL1meyKx.H440RDPGEQQeDOPiSTVpETaKo6ckrs2ndd5NSGvES0G', 'Team Manager', '', 1, 0),
(7, 'Gayatri', 'N R', 'gayatri@gmail.com', '$2y$10$XEL1meyKx.H440RDPGEQQeDOPiSTVpETaKo6ckrs2ndd5NSGvES0G', 'Team Leader', '9', 1, 0),
(8, 'Pooja', '', 'pooja@gmail.com', '$2y$10$XEL1meyKx.H440RDPGEQQeDOPiSTVpETaKo6ckrs2ndd5NSGvES0G', 'Team Leader', '10', 1, 0),
(9, 'Arya', 'B', 'arya@gamil.com', '$2y$10$XEL1meyKx.H440RDPGEQQeDOPiSTVpETaKo6ckrs2ndd5NSGvES0G', 'Team Manager', '', 1, 0),
(10, 'Varun', 'P K', 'varun@gamil.com', '$2y$10$XEL1meyKx.H440RDPGEQQeDOPiSTVpETaKo6ckrs2ndd5NSGvES0G', 'Team Manager', '', 1, 0),
(11, 'Jyothis', 'P M', 'jyothis@gamil.com', '$2y$10$XEL1meyKx.H440RDPGEQQeDOPiSTVpETaKo6ckrs2ndd5NSGvES0G', 'Team Leader', '13', 1, 0),
(12, 'Amal', 'M P', 'amal@gamil.com', '$2y$10$XEL1meyKx.H440RDPGEQQeDOPiSTVpETaKo6ckrs2ndd5NSGvES0G', 'Team Leader', '14', 1, 0),
(13, 'Arjun', 'T M', 'arjun@gamil.com', '$2y$10$XEL1meyKx.H440RDPGEQQeDOPiSTVpETaKo6ckrs2ndd5NSGvES0G', 'Team Manager', '', 1, 0),
(14, 'Adarsh', 'V K', 'adarsh@gamil.com', '$2y$10$XEL1meyKx.H440RDPGEQQeDOPiSTVpETaKo6ckrs2ndd5NSGvES0G', 'Team Manager', '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `work_tb`
--

CREATE TABLE `work_tb` (
  `Id` int(11) NOT NULL,
  `WorkDate` date NOT NULL,
  `Team` int(50) NOT NULL,
  `Task` int(255) NOT NULL,
  `Count` int(11) NOT NULL,
  `CurrespondingTime` varchar(50) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Note` varchar(900) CHARACTER SET armscii8 NOT NULL,
  `AmsTime` time NOT NULL DEFAULT '08:00:00',
  `RejectNote` varchar(900) NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `LastModifiedBy` varchar(50) NOT NULL,
  `LastModifiedDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `RecordStatus` tinyint(1) NOT NULL DEFAULT 1,
  `AdditionalTime` varchar(300) NOT NULL,
  `InTime` time NOT NULL,
  `OutTime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `work_tb`
--

INSERT INTO `work_tb` (`Id`, `WorkDate`, `Team`, `Task`, `Count`, `CurrespondingTime`, `Status`, `Note`, `AmsTime`, `RejectNote`, `CreatedBy`, `CreatedDate`, `LastModifiedBy`, `LastModifiedDate`, `RecordStatus`, `AdditionalTime`, `InTime`, `OutTime`) VALUES
(1, '2022-03-01', 1, 1, 3, '90', '0', 'Nothing', '08:00:00', '', '1', '2022-03-01 10:30:08', '1', '2022-03-05 15:48:18', 1, '30', '00:00:00', '00:00:00'),
(2, '2022-02-28', 2, 5, 1, '60', '0', 'Nothing', '08:00:00', '', '1', '2022-03-01 10:30:40', '1', '2022-03-05 15:48:49', 1, '', '00:00:00', '00:00:00'),
(3, '2022-01-26', 3, 3, 3, '360', '0', 'Nothing', '08:00:00', '', '1', '2022-03-01 10:36:28', '1', '2022-03-05 15:49:13', 1, '', '00:00:00', '00:00:00'),
(4, '2022-01-24', 4, 4, 5, '150', '0', 'Nothing', '08:00:00', '', '1', '2022-03-01 10:36:54', '1', '2022-03-05 15:49:16', 1, '30', '00:00:00', '00:00:00'),
(5, '2022-01-22', 5, 2, 2, '120', '0', 'Nothing', '08:00:00', '', '1', '2022-03-01 10:37:23', '1', '2022-03-05 15:49:27', 1, '20', '00:00:00', '00:00:00'),
(6, '2022-03-16', 1, 1, 4, '120', '0', 'Nothing', '08:00:00', '', '1', '2022-03-01 10:39:02', '1', '2022-03-05 15:47:47', 1, '20', '00:00:00', '00:00:00'),
(7, '2022-03-01', 4, 4, 2, '60', '0', 'Nothing', '08:00:00', '', '1', '2022-03-01 10:39:39', '1', '2022-03-05 15:48:29', 1, '50', '00:00:00', '00:00:00'),
(8, '2022-01-18', 3, 3, 3, '360', '0', 'Nothing', '08:00:00', '', '1', '2022-03-01 12:54:30', '1', '2022-03-09 10:01:27', 0, '30', '00:00:00', '00:00:00'),
(9, '2022-03-01', 1, 1, 6, '180', '0', 'Nothing', '08:00:00', '', '2', '2022-03-01 13:02:27', '2', '2022-03-01 13:16:08', 1, '30', '00:00:00', '00:00:00'),
(10, '2022-02-28', 2, 5, 3, '180', '0', 'Nothing', '08:00:00', '', '1', '2022-03-01 13:05:33', '1', '2022-03-05 15:48:57', 1, '22', '00:00:00', '00:00:00'),
(11, '2022-02-27', 2, 5, 3, '180', '0', 'Nothing', '08:00:00', '', '1', '2022-03-01 13:05:49', '1', '2022-03-05 15:49:03', 1, '', '00:00:00', '00:00:00'),
(12, '2022-02-26', 2, 5, 3, '180', '0', 'Nothing', '08:00:00', '', '1', '2022-03-01 13:06:02', '1', '2022-03-05 15:49:09', 1, '30', '00:00:00', '00:00:00'),
(13, '2022-03-01', 2, 5, 1, '60', '0', 'Nothing', '08:00:00', '', '1', '2022-03-01 13:13:04', '1', '2022-03-05 15:48:44', 1, '50', '00:00:00', '00:00:00'),
(14, '2022-03-04', 4, 4, 3, '90', '0', 'Nothing', '08:00:00', '', '1', '2022-03-04 15:56:04', '1', '2022-03-05 15:47:54', 1, '30', '00:00:00', '00:00:00'),
(15, '2022-03-04', 5, 2, 2, '120', '0', 'Nothing', '08:00:00', '', '1', '2022-03-04 15:56:41', '1', '2022-03-05 15:47:56', 1, '20', '00:00:00', '00:00:00'),
(16, '2022-03-03', 2, 5, 5, '300', '0', 'Nothing', '08:00:00', '', '1', '2022-03-04 15:57:22', '1', '2022-03-05 15:48:04', 1, '50', '00:00:00', '00:00:00'),
(17, '2022-03-03', 3, 3, 5, '600', '0', 'Nothing', '08:00:00', '', '1', '2022-03-04 15:58:14', '1', '2022-03-05 15:48:08', 1, '30', '00:00:00', '00:00:00'),
(18, '2022-03-02', 2, 5, 2, '120', '0', 'Nothing', '08:00:00', '', '2', '2022-03-04 19:22:55', '2', '2022-03-04 13:52:55', 1, '30', '00:00:00', '00:00:00'),
(19, '2022-03-02', 2, 5, 3, '180', '0', 'Nothing', '08:00:00', '', '11', '2022-03-04 19:25:18', '11', '2022-03-07 11:18:00', 1, '50', '00:00:00', '00:00:00'),
(20, '2022-03-02', 1, 1, 3, '90', '1', 'Nothing', '08:00:00', '', '3', '2022-03-05 15:59:54', '3', '2022-03-05 17:12:47', 1, '30', '00:00:00', '00:00:00'),
(21, '2022-03-02', 3, 3, 5, '600', '0', 'Nothing', '08:00:00', '', '1', '2022-03-07 11:08:11', '1', '2022-03-07 05:38:11', 1, '22', '00:00:00', '00:00:00'),
(22, '2022-03-03', 1, 1, 3, '90', '0', 'Nothing', '08:00:00', '', '1', '2022-03-07 11:10:14', '1', '2022-03-07 05:40:14', 1, '30', '00:00:00', '00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `task_tb`
--
ALTER TABLE `task_tb`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `team_tb`
--
ALTER TABLE `team_tb`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `users_tb`
--
ALTER TABLE `users_tb`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `work_tb`
--
ALTER TABLE `work_tb`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `task_tb`
--
ALTER TABLE `task_tb`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `team_tb`
--
ALTER TABLE `team_tb`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users_tb`
--
ALTER TABLE `users_tb`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `work_tb`
--
ALTER TABLE `work_tb`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
