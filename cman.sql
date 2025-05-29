-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2025 at 06:54 AM
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
-- Database: `cman`
--

-- --------------------------------------------------------




--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `Bank_Name` varchar(200) DEFAULT NULL,
  `Account_Number` varchar(200) DEFAULT NULL,
  `Branch` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `Bank_Name`, `Account_Number`, `Branch`) VALUES
(1, 'LIPA NA MPESA', '11111110', 'Safaricom'),
(2, 'COPARATIVE BANK', '0213289993', 'Meru'),
(3, 'NATIONAL BANK', '099887765666', 'Meru'),
(4, 'COMMERCIAL BANK', '3476374654623', 'Meru'),
(5, 'STARDAND CHARTER', '345646332', 'Meru'),
(6, 'EQUIT BANK', '21242423432', 'Meru');

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `activity_log_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `action` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`activity_log_id`, `username`, `date`, `action`) VALUES
(1, '', '2017-01-10 16:41:42', 'Added member 0723437369'),
(2, 'admin', '2017-01-11 10:19:34', 'Edited Member Kithinji'),
(3, 'admin', '2017-01-11 10:23:28', 'Edited Member Kithinji'),
(4, 'admin', '2017-01-11 10:26:45', 'Edited Member Kithinji'),
(5, 'admin', '2017-01-11 10:28:02', 'Edited Member Kithinji'),
(6, 'admin', '2017-01-11 10:29:31', 'Edited Member Kithinji'),
(7, 'admin', '2017-01-11 10:32:58', 'Edited Member Kithinji'),
(8, 'admin', '2017-01-11 10:33:24', 'Edited Member Kithinji'),
(9, 'admin', '2017-01-11 10:34:24', 'Added member 0725873436'),
(10, 'admin', '2017-01-11 11:13:12', 'Edited Visitor Kithinji'),
(11, 'admin', '2017-01-11 11:16:00', 'Edited Visitor Kithinji'),
(12, 'admin', '2017-01-11 19:19:32', 'Added member 0725873436'),
(13, 'admin', '2017-01-11 19:20:31', 'Added member 725873436'),
(14, '', '2017-01-12 06:05:26', 'Added member 00000000000'),
(15, '', '2017-02-15 05:54:40', 'Added member 0733997722'),
(16, 'admin', '2017-02-20 12:30:16', 'Edited member Kithinji'),
(17, 'master', '2024-12-21 11:19:41', 'Edited member Rivera'),
(18, 'master', '2024-12-21 11:22:30', 'Edited member Rhyzen'),
(19, 'master', '2024-12-21 11:33:27', 'Edited member Emeliy'),
(20, 'master', '2024-12-21 11:34:31', 'Edited member Abalos'),
(21, 'master', '2024-12-21 11:36:40', 'Edited member Emeliy'),
(22, 'master', '2024-12-21 11:38:02', 'Added member 09651123456'),
(23, 'master', '2024-12-21 11:39:10', 'Added member 09554136648'),
(24, 'master', '2024-12-21 11:40:21', 'Added member 09457789463'),
(25, 'master', '2024-12-27 11:36:55', 'Added member 09224866331'),
(26, 'master', '2024-12-27 11:38:30', 'Added member 09235964471'),
(27, 'master', '2024-12-27 16:11:05', 'Added member 09654194515'),
(28, 'Admin', '2025-01-06 12:30:41', 'Added member 09458617422'),
(29, 'Admin', '2025-01-06 12:31:49', 'Added member 09552544389'),
(30, 'Admin', '2025-01-06 12:33:18', 'Added member 09226457825'),
(31, 'Admin', '2025-01-06 12:35:39', 'Added member 09458566325');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(128) NOT NULL,
  `firstname` varchar(128) NOT NULL,
  `lastname` varchar(128) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `adminthumbnails` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `firstname`, `lastname`, `username`, `password`, `adminthumbnails`) VALUES
(1, 'Julius ', 'Visbal', 'Admin', 'Admin', 'uploads/me.jpg'),
(2, 'Admin', 'Admin', 'master', '1234', 'images/NO-IMAGE-AVAILABLE.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `announcement_id` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `content` text NOT NULL,
  `times` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`announcement_id`, `title`, `content`, `times`) VALUES
(1, 'notice', 'ALL FEES SHOULD BE PAID THROUGH THE ACCOUNTS GIVEN. NO CASH WILL BE ACCEPTED', '2016-10-24');

-- --------------------------------------------------------

--
-- Table structure for table `apply`
--

CREATE TABLE `apply` (
  `id` int(100) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `mname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `apfor` varchar(100) NOT NULL,
  `sched` datetime NOT NULL,
  `residence` varchar(100) NOT NULL,
  `pob` varchar(255) NOT NULL,
  `purpose` varchar(1000) NOT NULL,
  `mobile` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `apply`
--

INSERT INTO `apply` (`id`, `fname`, `mname`, `lname`, `gender`, `apfor`, `sched`, `residence`, `pob`, `purpose`, `mobile`) VALUES
(1, 'Maverick', 'Caballero', 'Cuevas', 'Male', 'Ministry of Altar Servers', '2024-12-26 00:00:00', 'Caloocan City', 'Caloocan City', 'None', '09654194515');

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

CREATE TABLE `donation` (
  `titheid` int(10) NOT NULL,
  `Amount` varchar(100) DEFAULT NULL,
  `Trcode` varchar(100) DEFAULT NULL,
  `paytime` timestamp NULL DEFAULT current_timestamp(),
  `na` varchar(10) DEFAULT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`titheid`, `Amount`, `Trcode`, `paytime`, `na`, `type`) VALUES
(1, '1000', 'KMSMBNJDW', '2016-10-23 15:38:57', '0725873436', 'GCASH'),
(2, '2000', 'KAJHDJHJD', '2016-10-23 19:52:58', '0725873436', 'MAYA'),
(3, '8000', 'WEADADADD', '2017-01-11 09:57:26', '0725873436', 'BDO'),
(7, '20', 'dawdawdaw', '2024-12-26 03:54:16', '0725873436', 'GCASH'),
(26, '3000', 'WADAWDAW', '2024-12-26 05:04:53', '0000000000', 'GCASH'),
(27, '1000', 'WADAWDAW', '2024-12-26 10:30:56', '0000000000', 'GCASH');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(100) NOT NULL,
  `Title` text NOT NULL,
  `Date` date NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `Title`, `Date`, `content`) VALUES
(1, 'Kasalang Pamparokya', '2024-12-28', 'Community Wedding'),
(2, 'New Years Evening', '2024-12-31', 'New Year'),
(3, 'Nobena Mass', '2025-01-09', 'Preparation for Fiesta');

-- --------------------------------------------------------

--
-- Table structure for table `giving`
--

CREATE TABLE `giving` (
  `givingid` int(10) NOT NULL,
  `Amount` varchar(100) DEFAULT NULL,
  `Trcode` varchar(100) DEFAULT NULL,
  `paytime` timestamp NULL DEFAULT current_timestamp(),
  `na` varchar(10) DEFAULT NULL,
  `ya` varchar(100) DEFAULT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `giving`
--

INSERT INTO `giving` (`givingid`, `Amount`, `Trcode`, `paytime`, `na`, `ya`, `type`) VALUES
(1, '1000', 'KKKSJKJS', '2016-10-23 19:13:02', '0725873436', 'Church Mission', ''),
(2, '2000', 'KAJHDJHJD', '2016-10-23 19:42:17', '0725873436', 'Mjengo', ''),
(4, '2000', 'KAJHDJHJD', '2016-10-23 19:47:43', '0725873436', 'Mjengo', ''),
(5, '5500', 'WEADADADD', '2017-01-11 10:35:31', '0725873436', 'Godfrey Kithinji', ''),
(6, '3000', 'ttytegfdg', '2017-01-11 10:38:41', '0725873436', 'Rent', '');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `keyu` int(10) NOT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `sname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `Gender` varchar(100) DEFAULT NULL,
  `Birthday` varchar(100) DEFAULT NULL,
  `Residence` varchar(100) DEFAULT NULL,
  `pob` varchar(100) DEFAULT NULL,
  `ministry` varchar(100) DEFAULT NULL,
  `mobile` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `thumbnail` varchar(500) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `id` varchar(10) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`keyu`, `fname`, `sname`, `lname`, `Gender`, `Birthday`, `Residence`, `pob`, `ministry`, `mobile`, `email`, `thumbnail`, `password`, `id`, `date`) VALUES
(1, 'Janine', 'Rivera', 'Mutia', 'Female', '1992-02-26', 'Caloocan City', 'Caloocan City', 'Lectors and Commentators Ministry', '09984567712', 'godkith@gmail.com', 'uploads/none.jpg', '1234', '0725873436', '2017-01-11 11:34:34'),
(3, 'Khyrra', 'Rhyzen', 'Samson', 'Male', '2006-07-20', 'Caloocan City', 'Caloocan City', 'Ministry of Altar Servers', '09654478964', 'khykhy07@gmail.com', 'uploads/none.png', '1234', '0720571204', '2017-01-11 11:34:34'),
(4, 'King', 'Emeliy', 'Maketong', 'Male', '2000-01-01', 'Caloocan City', 'Caloocan City', 'Family and Life Ministry', '09224856912', 'godkde9@gmail.com', 'uploads/none.png', '1234', '0723437369', '2017-01-11 11:34:34'),
(5, 'Emmanuel', 'Abalos', 'Ili', 'Male', '2003-11-02', 'Bulacan', 'Caloocan City', 'Ministry of Altar Servers', '09445697715', 'emanputok@gmail.com', 'uploads/none.png', '1234', '0000000000', '2017-01-12 06:05:26'),
(6, 'Sean Andrei', 'Emeliy', 'Fran', 'Male', '2003-02-13', 'Caloocan City', 'Caloocan City', 'Ministry of Altar Servers', '09443123443', 'barakaabraham@gmail.com', 'uploads/none.png', '1234', '0733997722', '2017-02-15 05:54:40'),
(7, 'E John Vianney', 'Kalentong', 'Basilio', 'Male', '2004-11-17', 'Caloocan City', 'Caloocan City', 'Ministry of Altar Servers', '09651123456', 'johnkulangot@gmail.com', 'uploads/none.png', '1234', '0965112345', '2024-12-21 03:38:02'),
(8, 'Arldrick John', 'Kupal', 'Dapa', 'Male', '2006-06-22', 'Laguna', 'Caloocan City', 'Ministry of Altar Servers', '09554136648', 'ajdapa@gmail.com', 'uploads/none.png', '1234', '0955413664', '2024-12-21 03:39:10'),
(9, 'Mark Joseph', 'Kanto', 'Demotica', 'Male', '2004-10-26', 'Caloocan City', 'Caloocan City', 'Ministry of Altar Servers', '09457789463', 'kalampag@gmail.com', 'uploads/none.png', '1234', '0945778946', '2024-12-21 03:40:21'),
(11, 'Delia', 'Loba', 'Visbal', 'Female', '1973-10-17', 'Caloocan City', 'Manila City', 'Lectors and Commentators Ministry', '09224866331', 'delialoba17@gmail.com', 'uploads/none.png', '1234', '0922486633', '2024-12-27 03:36:55'),
(12, 'Antero', 'Olidan ', 'Visbal', 'Male', '1964-01-20', 'Caloocan City', 'Manila City', 'Extra-Ordinary Ministry of Holy Communion', '09235964471', 'antero20@gmail.com', 'uploads/none.png', '1234', '0923596447', '2024-12-27 03:38:30'),
(13, 'John ', 'Lorio', 'Laggera', 'Male', '2000-06-20', 'Caloocan City', 'Caloocan City', 'Parish Youth Ministry', '09458617422', 'johnlagerra@gmail.com', 'uploads/none.png', '1234', '0945861742', '2025-01-06 04:30:41'),
(14, 'Marevick ', 'suyou ', 'kwepeng', 'Female', '1998-01-01', 'Caloocan City', 'Caloocan City', 'Social Action Ministry', '09552544389', 'marevickkwep@gmail.com', 'uploads/none.png', '1234', '0955254438', '2025-01-06 04:31:49'),
(15, 'Anastacia', 'Bodua', 'Melencio', 'Female', '1987-10-22', 'Caloocan City', 'Caloocan City', 'Ministry of Altar Servers', '09226457825', 'AnastaciaMelencio@gmail.com', 'uploads/none.png', '1234', '0922645782', '2025-01-06 04:33:18'),
(16, 'Mariss', 'Hendea', 'Cruz', 'Female', '2001-07-19', 'Caloocan City', 'Caloocan City', 'Parish Youth Ministry', '09458566325', 'MarissCruz@gmail.com', 'uploads/none.png', '1234', '0945856632', '2025-01-06 04:35:39');

-- --------------------------------------------------------

--
-- Table structure for table `offering`
--

CREATE TABLE `offering` (
  `offeringid` int(10) NOT NULL,
  `Amount` varchar(100) DEFAULT NULL,
  `Trcode` varchar(100) DEFAULT NULL,
  `paytime` timestamp NULL DEFAULT current_timestamp(),
  `na` varchar(10) DEFAULT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `offering`
--

INSERT INTO `offering` (`offeringid`, `Amount`, `Trcode`, `paytime`, `na`, `type`) VALUES
(1, '2000', 'KAJHDJHJD', '2016-10-23 19:55:47', '0725873436', ''),
(2, '8000', 'WEADADADD', '2017-01-11 10:05:39', '0725873436', ''),
(3, '8000', 'WWEDDDDDS', '2017-01-11 12:24:29', '0725873436', ''),
(4, '1000', 'dawdawdaw', '2024-12-26 06:09:47', '0000000000', 'GCASH');

-- --------------------------------------------------------

--
-- Table structure for table `sundays`
--

CREATE TABLE `sundays` (
  `keyu` int(10) NOT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `mname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `Gender` varchar(100) DEFAULT NULL,
  `sched` varchar(100) DEFAULT NULL,
  `Residence` varchar(100) DEFAULT NULL,
  `purpose` varchar(100) DEFAULT NULL,
  `pay` varchar(100) DEFAULT NULL,
  `mobile` varchar(100) DEFAULT NULL,
  `thumbnail` varchar(500) DEFAULT NULL,
  `id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sundays`
--

INSERT INTO `sundays` (`keyu`, `fname`, `mname`, `lname`, `Gender`, `sched`, `Residence`, `purpose`, `pay`, `mobile`, `thumbnail`, `id`) VALUES
(1, 'Julius Ceasar', 'Loba', 'Visbal', 'Male', '2024-12-01', 'Phase 1', 'Appointment', '1000', '09654194515', 'uploads/none.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teens`
--

CREATE TABLE `teens` (
  `keyu` int(10) NOT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `sname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `Gender` varchar(100) DEFAULT NULL,
  `Birthday` varchar(100) DEFAULT NULL,
  `Residence` varchar(100) DEFAULT NULL,
  `pob` varchar(100) DEFAULT NULL,
  `ministry` varchar(100) DEFAULT NULL,
  `mobile` varchar(100) DEFAULT NULL,
  `thumbnail` varchar(500) DEFAULT NULL,
  `id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `teens`
--

INSERT INTO `teens` (`keyu`, `fname`, `sname`, `lname`, `Gender`, `Birthday`, `Residence`, `pob`, `ministry`, `mobile`, `thumbnail`, `id`) VALUES
(1, 'Aron', 'Mwingirwa', 'Mutia', '', '2007-03-12', 'Meru', 'meru', 'kithinji Godfrey', '0725873436', 'uploads/none.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tithe`
--

CREATE TABLE `tithe` (
  `titheid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `trcode` varchar(255) NOT NULL,
  `na` varchar(50) NOT NULL,
  `ttype` varchar(50) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `paytime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tithe`
--

INSERT INTO `tithe` (`titheid`, `name`, `gender`, `amount`, `trcode`, `na`, `ttype`, `purpose`, `paytime`) VALUES
(6, 'Julius Ceasar Visbal', 'Male', 1000.00, 'WADAWDAW', '09919467527', 'Gcash', 'None', '2024-12-26 11:47:20'),
(7, 'Julius Ceasar Visbal', 'Male', 1000.00, 'WADAWDAW', '09919467527', 'Gcash', 'None', '2024-12-27 04:46:03');

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `user_log_id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `login_date` varchar(30) NOT NULL,
  `logout_date` varchar(128) NOT NULL,
  `admin_id` int(128) NOT NULL,
  `student_id` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitor`
--

CREATE TABLE `visitor` (
  `id` int(10) NOT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `sname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `Gender` varchar(100) DEFAULT NULL,
  `Birthday` varchar(100) DEFAULT NULL,
  `Residence` varchar(100) DEFAULT NULL,
  `pob` varchar(100) DEFAULT NULL,
  `ministry` varchar(100) DEFAULT NULL,
  `mobile` varchar(100) DEFAULT NULL,
  `thumbnail` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `visitor`
--

INSERT INTO `visitor` (`id`, `fname`, `sname`, `lname`, `Gender`, `Birthday`, `Residence`, `pob`, `ministry`, `mobile`, `thumbnail`) VALUES
(1, 'Godfrey', 'Kithinji', 'Mutia', 'Male', '1989-01-31', 'Nairobi', 'Nairobi', 'Sunday Service', '0725873436', 'uploads/none.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`activity_log_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `apply`
--
ALTER TABLE `apply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donation`
--
ALTER TABLE `donation`
  ADD PRIMARY KEY (`titheid`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `giving`
--
ALTER TABLE `giving`
  ADD PRIMARY KEY (`givingid`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`keyu`);

--
-- Indexes for table `offering`
--
ALTER TABLE `offering`
  ADD PRIMARY KEY (`offeringid`);

--
-- Indexes for table `sundays`
--
ALTER TABLE `sundays`
  ADD PRIMARY KEY (`keyu`);

--
-- Indexes for table `teens`
--
ALTER TABLE `teens`
  ADD PRIMARY KEY (`keyu`);

--
-- Indexes for table `tithe`
--
ALTER TABLE `tithe`
  ADD PRIMARY KEY (`titheid`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`user_log_id`);

--
-- Indexes for table `visitor`
--
ALTER TABLE `visitor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `activity_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `apply`
--
ALTER TABLE `apply`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `donation`
--
ALTER TABLE `donation`
  MODIFY `titheid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `giving`
--
ALTER TABLE `giving`
  MODIFY `givingid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `keyu` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `offering`
--
ALTER TABLE `offering`
  MODIFY `offeringid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sundays`
--
ALTER TABLE `sundays`
  MODIFY `keyu` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teens`
--
ALTER TABLE `teens`
  MODIFY `keyu` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tithe`
--
ALTER TABLE `tithe`
  MODIFY `titheid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `user_log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visitor`
--
ALTER TABLE `visitor`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



-- Add baptismal_certificates table to track certificate generation and validation
CREATE TABLE IF NOT EXISTS `baptismal_certificates` (
  `certificate_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` varchar(10) NOT NULL,
  `certificate_number` varchar(50) NOT NULL,
  `baptism_date` date NOT NULL,
  `baptized_by` varchar(100) NOT NULL,
  `witnesses` text,
  `church_location` varchar(200) DEFAULT 'Parish Church',
  `generated_date` timestamp DEFAULT CURRENT_TIMESTAMP,
  `generated_by` varchar(100) NOT NULL,
  `validated_by_priest` tinyint(1) DEFAULT 0,
  `validated_by_staff` tinyint(1) DEFAULT 0,
  `priest_signature` varchar(100) DEFAULT NULL,
  `staff_signature` varchar(100) DEFAULT NULL,
  `validation_date` timestamp NULL DEFAULT NULL,
  `status` enum('draft','validated','printed') DEFAULT 'draft',
  `notes` text,
  PRIMARY KEY (`certificate_id`),
  UNIQUE KEY `certificate_number` (`certificate_number`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Insert sample data for testing
INSERT INTO `baptismal_certificates` (`member_id`, `certificate_number`, `baptism_date`, `baptized_by`, `witnesses`, `generated_by`, `validated_by_priest`, `validated_by_staff`, `status`) VALUES
('0725873436', 'BC-2024-001', '2024-01-15', 'Fr. John Smith', 'Maria Santos, Jose Rodriguez', 'Admin', 1, 1, 'validated'),
('0720571204', 'BC-2024-002', '2024-02-20', 'Fr. John Smith', 'Ana Cruz, Pedro Garcia', 'Admin', 0, 1, 'draft'),
('0723437369', 'BC-2024-003', '2024-03-10', 'Fr. John Smith', 'Carmen Lopez, Miguel Torres', 'Admin', 1, 0, 'draft');



-- Marriage Certificate Table
CREATE TABLE `marriage_certificates` (
  `marriage_id` int(11) NOT NULL AUTO_INCREMENT,
  `groom_name` varchar(255) NOT NULL,
  `groom_mobile` varchar(20) DEFAULT NULL,
  `groom_address` varchar(500) DEFAULT NULL,
  `bride_name` varchar(255) NOT NULL,
  `bride_mobile` varchar(20) DEFAULT NULL,
  `bride_address` varchar(500) DEFAULT NULL,
  `marriage_date` date NOT NULL,
  `marriage_venue` varchar(255) DEFAULT NULL,
  `officiant_name` varchar(255) DEFAULT NULL,
  `certificate_number` varchar(100) DEFAULT NULL,
  `proof_document` varchar(500) DEFAULT NULL, -- Path to uploaded marriage certificate proof
  `status` enum('pending','approved','issued','rejected') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(100) DEFAULT NULL, -- Admin username who created the record
  PRIMARY KEY (`marriage_id`),
  UNIQUE KEY `certificate_number` (`certificate_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Optional: Marriage Applications Table (for pending requests)
CREATE TABLE `marriage_applications` (
  `application_id` int(11) NOT NULL AUTO_INCREMENT,
  `groom_name` varchar(255) NOT NULL,
  `groom_mobile` varchar(20) NOT NULL,
  `groom_email` varchar(255) DEFAULT NULL,
  `groom_address` varchar(500) NOT NULL,
  `bride_name` varchar(255) NOT NULL,
  `bride_mobile` varchar(20) NOT NULL,
  `bride_email` varchar(255) DEFAULT NULL,
  `bride_address` varchar(500) NOT NULL,
  `preferred_date` date NOT NULL,
  `preferred_venue` varchar(255) DEFAULT NULL,
  `proof_document` varchar(500) DEFAULT NULL, -- Path to uploaded documents
  `status` enum('pending','approved','scheduled','completed','rejected') DEFAULT 'pending',
  `application_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `notes` text DEFAULT NULL,
  PRIMARY KEY (`application_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Insert sample data
INSERT INTO `marriage_certificates` (
  `groom_name`, `groom_mobile`, `groom_address`,
  `bride_name`, `bride_mobile`, `bride_address`,
  `marriage_date`, `marriage_venue`, `officiant_name`,
  `certificate_number`, `status`, `created_by`
) VALUES 
(
  'John Doe', '09123456789', 'Caloocan City',
  'Jane Smith', '09987654321', 'Quezon City',
  '2024-12-25', 'Parish Church', 'Father Rodriguez',
  'MC-2024-001', 'issued', 'Admin'
);

-- Add indexes for better performance
CREATE INDEX idx_marriage_date ON marriage_certificates(marriage_date);
CREATE INDEX idx_groom_mobile ON marriage_certificates(groom_mobile);
CREATE INDEX idx_bride_mobile ON marriage_certificates(bride_mobile);
CREATE INDEX idx_status ON marriage_certificates(status);


-- Dedication Certificate Database Schema
-- Simple schema to add dedication certificate functionality to existing Parish Management System

-- Main dedication table
CREATE TABLE `dedication` (
  `dedication_id` int(11) NOT NULL AUTO_INCREMENT,
  `child_fname` varchar(100) NOT NULL,
  `child_mname` varchar(100) DEFAULT NULL,
  `child_lname` varchar(100) NOT NULL,
  `child_gender` varchar(10) NOT NULL,
  `child_birthdate` date NOT NULL,
  `child_birthplace` varchar(100) NOT NULL,
  `father_name` varchar(200) NOT NULL,
  `mother_name` varchar(200) NOT NULL,
  `parents_address` varchar(255) NOT NULL,
  `parents_mobile` varchar(20) NOT NULL,
  `dedication_date` date NOT NULL,
  `officiant` varchar(100) NOT NULL,
  `certificate_number` varchar(50) NOT NULL UNIQUE,
  `remarks` text DEFAULT NULL,
  `member_id` varchar(10) DEFAULT NULL, -- Links to existing members table
  `created_by` int(11) NOT NULL, -- Links to admin table
  `created_date` timestamp DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) DEFAULT 'Active',
  PRIMARY KEY (`dedication_id`),
  INDEX `idx_member_id` (`member_id`),
  INDEX `idx_created_by` (`created_by`),
  INDEX `idx_dedication_date` (`dedication_date`),
  INDEX `idx_certificate_number` (`certificate_number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Sample data for testing
INSERT INTO `dedication` (
  `child_fname`, `child_mname`, `child_lname`, `child_gender`, 
  `child_birthdate`, `child_birthplace`, `father_name`, `mother_name`,
  `parents_address`, `parents_mobile`, `dedication_date`, `officiant`,
  `certificate_number`, `member_id`, `created_by`
) VALUES 
(
  'Maria', 'Santos', 'Cruz', 'Female',
  '2024-01-15', 'Caloocan City', 'Juan Santos Cruz', 'Ana Maria Cruz',
  'Phase 1, Caloocan City', '09123456789', '2024-12-15', 'Fr. Joseph Martinez',
  'DED-2024-001', '0912345678', 1
),
(
  'Gabriel', 'Reyes', 'Flores', 'Male',
  '2024-03-20', 'Manila City', 'Carlos Reyes Flores', 'Elena Santos Flores',
  'Quezon City', '09234567890', '2024-12-22', 'Fr. Joseph Martinez',
  'DED-2024-002', '0923456789', 1
);

-- Add foreign key constraints (optional, depending on your existing setup)
-- ALTER TABLE `dedication` 
-- ADD CONSTRAINT `fk_dedication_member` 
-- FOREIGN KEY (`member_id`) REFERENCES `members`(`id`) ON DELETE SET NULL;

-- ALTER TABLE `dedication` 
-- ADD CONSTRAINT `fk_dedication_admin` 
-- FOREIGN KEY (`created_by`) REFERENCES `admin`(`admin_id`) ON DELETE RESTRICT;

