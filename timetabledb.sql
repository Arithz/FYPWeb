-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2021 at 04:54 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `timetabledb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `Admin_ID` int(11) NOT NULL,
  `Admin_Username` varchar(50) NOT NULL,
  `Admin_Password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`Admin_ID`, `Admin_Username`, `Admin_Password`) VALUES
(1, 'harith', 'helo'),
(2, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `assessment`
--

CREATE TABLE `assessment` (
  `Assessment_ID` int(11) NOT NULL,
  `Assessment_Date` date NOT NULL,
  `Assessment_Subject` varchar(50) NOT NULL,
  `Assessment_Description` varchar(200) NOT NULL,
  `Class_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assessment`
--

INSERT INTO `assessment` (`Assessment_ID`, `Assessment_Date`, `Assessment_Subject`, `Assessment_Description`, `Class_ID`) VALUES
(11, '2021-07-15', 'CSC259', 'Madam Taniza Bagi Assignmentsekali rubric', 7),
(19, '2021-07-08', 'ISP250', 'bdawjkbdkawd', 7),
(20, '2021-07-08', 'CTU', 'afiq busuk', 9),
(21, '2021-07-10', 'CTU', 'harini kena hantar report banyak banyak', 7);

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `Class_ID` int(11) NOT NULL,
  `Class_Name` varchar(20) NOT NULL,
  `Class_Notes` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`Class_ID`, `Class_Name`, `Class_Notes`) VALUES
(7, 'KCS1104A', 'youtube'),
(9, 'KCS1104J', 'meow meow'),
(12, 'KCS1104K', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

CREATE TABLE `lecturer` (
  `Lecturer_ID` int(11) NOT NULL,
  `Lecturer_Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lecturer`
--

INSERT INTO `lecturer` (`Lecturer_ID`, `Lecturer_Name`) VALUES
(3, 'Madam Nurul Husna'),
(4, 'Madam Siti Nurbaya'),
(7, 'Madam Hasnita Talib'),
(10, 'Miss Nazifa'),
(11, 'Sir Zhafry');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `Request_ID` int(11) NOT NULL,
  `Request_Description` varchar(300) DEFAULT NULL,
  `Request_Category` varchar(20) DEFAULT NULL,
  `Request_Date` datetime DEFAULT NULL,
  `Status_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`Request_ID`, `Request_Description`, `Request_Category`, `Request_Date`, `Status_ID`) VALUES
(10, 'KCS1104K', 'Class', '2021-07-05 10:47:52', 1),
(16, 'Madam Hasnita Talib', 'Lecturer', '2021-07-06 17:11:25', 2),
(18, 'ENT300 Fundamentals of Entrepreneurship', 'Subject', '2021-07-06 17:20:02', 1),
(21, 'Monday 16:00 18:00 Madam Nurul Husna KCS1104A CSC259 ODL-S', 'Schedule', '2021-07-06 18:23:16', 2),
(22, 'Wednesday 14:00 16:00 Madam Nurul Husna KCS1104J ISP250 MK-7', 'Schedule', '2021-07-06 18:23:55', 2),
(25, 'Miss Nazifa', 'Lecturer', '2021-07-07 18:47:16', 1),
(26, 'Sir Zhafry', 'Lecturer', '2021-07-07 20:32:17', 2),
(28, 'CTU Agama', 'Subject', '2021-07-07 22:25:27', 2),
(29, 'Sunday 22:30 23:30 Sir Zhafry KCS1104E CTU MK8', 'Schedule', '2021-07-07 22:35:40', 3),
(38, 'Thursday 02:55 02:57 Madam Siti Nurbaya KCS1104A CTU ODL-S', 'Schedule', '2021-07-08 02:54:11', 2),
(39, 'KCS1105J', 'Class', '2021-07-08 15:40:00', 3),
(40, 'Thursday 15:23 15:24 Sir Zhafry KCS1104J CTU ODL-S', 'Schedule', '2021-07-08 15:22:10', 2);

-- --------------------------------------------------------

--
-- Table structure for table `requester`
--

CREATE TABLE `requester` (
  `Requester_ID` int(11) NOT NULL,
  `Requester_Password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `requester`
--

INSERT INTO `requester` (`Requester_ID`, `Requester_Password`) VALUES
(1, 'uitmmerbok1'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `Schedule_ID` int(11) NOT NULL,
  `Schedule_Day` varchar(20) NOT NULL,
  `Schedule_TimeStart` time NOT NULL,
  `Schedule_TimeEnd` time NOT NULL,
  `Lecturer_ID` int(11) NOT NULL,
  `Class_ID` int(11) NOT NULL,
  `Subject_Code` varchar(15) NOT NULL,
  `Schedule_Location` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`Schedule_ID`, `Schedule_Day`, `Schedule_TimeStart`, `Schedule_TimeEnd`, `Lecturer_ID`, `Class_ID`, `Subject_Code`, `Schedule_Location`) VALUES
(3, 'Monday', '16:00:00', '18:00:00', 3, 7, 'CSC259', 'ODL-S'),
(4, 'Wednesday', '14:00:00', '16:00:00', 3, 9, 'ISP250', 'MK-7');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `Session_ID` int(11) NOT NULL,
  `Session_Date` datetime NOT NULL,
  `Admin_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`Session_ID`, `Session_Date`, `Admin_ID`) VALUES
(1, '2021-07-06 21:32:44', 1),
(2, '2021-07-06 22:30:02', 1),
(3, '2021-07-06 22:46:23', 1),
(4, '2021-07-06 22:47:51', 1),
(5, '2021-07-06 22:48:02', 1),
(6, '2021-07-06 22:49:36', 1),
(7, '2021-07-06 22:50:39', 1),
(8, '2021-07-06 22:50:53', 1),
(9, '2021-07-06 22:51:55', 1),
(10, '2021-07-06 22:52:08', 1),
(11, '2021-07-06 22:52:23', 1),
(12, '2021-07-06 22:52:36', 1),
(13, '2021-07-06 22:52:51', 1),
(14, '2021-07-06 23:05:38', 1),
(15, '2021-07-06 23:08:42', 1),
(16, '2021-07-06 23:09:51', 1),
(17, '2021-07-06 23:11:32', 1),
(18, '2021-07-06 23:11:57', 2),
(19, '2021-07-07 14:04:44', 2),
(20, '2021-07-07 15:27:22', 1),
(21, '2021-07-07 18:58:51', 1),
(22, '2021-07-07 19:36:56', 1),
(23, '2021-07-07 20:35:58', 1),
(24, '2021-07-07 22:26:42', 1),
(25, '2021-07-07 22:35:57', 1),
(26, '2021-07-07 22:37:35', 1),
(27, '2021-07-07 22:45:07', 1),
(28, '2021-07-08 01:10:06', 2),
(29, '2021-07-08 15:21:47', 1),
(30, '2021-07-08 15:26:55', 1),
(31, '2021-07-08 15:31:47', 1),
(32, '2021-07-08 15:39:28', 2),
(33, '2021-07-08 22:52:46', 2),
(34, '2021-07-09 02:18:41', 2);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `Status_ID` int(11) NOT NULL,
  `Status_Description` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`Status_ID`, `Status_Description`) VALUES
(1, 'Waiting For Approval'),
(2, 'Accepted'),
(3, 'Declined');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `Subject_Code` varchar(15) NOT NULL,
  `Subject_Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`Subject_Code`, `Subject_Name`) VALUES
('CSC259', 'Introduction To Mobile and Web Development'),
('ENT300', 'Fundamentals of Entrepreneurship'),
('ISP250', 'Introduction To System Documentation');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`Admin_ID`);

--
-- Indexes for table `assessment`
--
ALTER TABLE `assessment`
  ADD PRIMARY KEY (`Assessment_ID`),
  ADD KEY `assessment_ibfk_1` (`Class_ID`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`Class_ID`);

--
-- Indexes for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`Lecturer_ID`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`Request_ID`),
  ADD KEY `Status_ID` (`Status_ID`);

--
-- Indexes for table `requester`
--
ALTER TABLE `requester`
  ADD PRIMARY KEY (`Requester_ID`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`Schedule_ID`),
  ADD KEY `schedule_ibfk_1` (`Lecturer_ID`),
  ADD KEY `schedule_ibfk_2` (`Class_ID`),
  ADD KEY `schedule_ibfk_3` (`Subject_Code`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`Session_ID`),
  ADD KEY `FK_AdminSession` (`Admin_ID`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`Status_ID`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`Subject_Code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `Admin_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assessment`
--
ALTER TABLE `assessment`
  MODIFY `Assessment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `Class_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `lecturer`
--
ALTER TABLE `lecturer`
  MODIFY `Lecturer_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `Request_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `requester`
--
ALTER TABLE `requester`
  MODIFY `Requester_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `Schedule_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `Session_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `Status_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assessment`
--
ALTER TABLE `assessment`
  ADD CONSTRAINT `assessment_ibfk_1` FOREIGN KEY (`Class_ID`) REFERENCES `class` (`Class_ID`) ON DELETE CASCADE;

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`Status_ID`) REFERENCES `status` (`Status_ID`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`Lecturer_ID`) REFERENCES `lecturer` (`Lecturer_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`Class_ID`) REFERENCES `class` (`Class_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedule_ibfk_3` FOREIGN KEY (`Subject_Code`) REFERENCES `subject` (`Subject_Code`) ON DELETE CASCADE;

--
-- Constraints for table `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `FK_AdminSession` FOREIGN KEY (`Admin_ID`) REFERENCES `admins` (`Admin_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
