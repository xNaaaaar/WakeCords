-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2022 at 08:00 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wakecords`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(8) NOT NULL,
  `admin_fname` varchar(25) NOT NULL,
  `admin_mi` char(1) NOT NULL,
  `admin_lname` varchar(25) NOT NULL,
  `admin_email` varchar(50) NOT NULL,
  `admin_pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_fname`, `admin_mi`, `admin_lname`, `admin_email`, `admin_pass`) VALUES
(1, 'Admn', 'Z', 'Admn', 'admin@wakecords.com', '0192023a7bbd73250516f069df18b500');

-- --------------------------------------------------------

--
-- Table structure for table `candle`
--

CREATE TABLE `candle` (
  `service_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(8) NOT NULL,
  `service_id` int(8) NOT NULL,
  `seeker_id` int(8) NOT NULL,
  `cart_qty` int(2) DEFAULT NULL,
  `cart_size` varchar(25) DEFAULT NULL,
  `cart_font` varchar(25) DEFAULT NULL,
  `cart_wake_start_date` date DEFAULT NULL,
  `cart_wake_time` varchar(50) DEFAULT NULL,
  `cart_num_days` int(2) DEFAULT NULL,
  `cart_burial_start_date` date DEFAULT NULL,
  `cart_burial_time` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `catering`
--

CREATE TABLE `catering` (
  `service_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `church`
--

CREATE TABLE `church` (
  `service_id` int(8) NOT NULL,
  `church_church` varchar(25) NOT NULL,
  `church_cemetery` varchar(25) NOT NULL,
  `church_priest` varchar(25) NOT NULL,
  `church_address` varchar(300) NOT NULL,
  `church_mass_date` date DEFAULT NULL,
  `church_mass_time` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE `details` (
  `purchase_id` int(8) NOT NULL,
  `deceased_name` varchar(25) DEFAULT NULL,
  `burial_datetime` datetime DEFAULT NULL,
  `burial_add` varchar(100) DEFAULT NULL,
  `delivery_add` varchar(100) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `message` varchar(200) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `death_date` date DEFAULT NULL,
  `delivery_datetime` datetime DEFAULT NULL,
  `num_pax` int(4) DEFAULT NULL,
  `cemetery_add` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(8) NOT NULL,
  `seeker_id` int(8) NOT NULL,
  `service_id` int(8) NOT NULL,
  `feedback_star` int(8) NOT NULL,
  `feedback_comments` varchar(250) DEFAULT NULL,
  `feedback_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `flower`
--

CREATE TABLE `flower` (
  `service_id` int(8) NOT NULL,
  `flower_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `funeral`
--

CREATE TABLE `funeral` (
  `service_id` int(8) NOT NULL,
  `funeral_name` varchar(50) NOT NULL,
  `funeral_type` varchar(20) NOT NULL,
  `funeral_kind` varchar(20) NOT NULL,
  `funeral_size` varchar(200) DEFAULT NULL,
  `funeral_qty` varchar(200) DEFAULT NULL,
  `funeral_price` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `headstone`
--

CREATE TABLE `headstone` (
  `service_id` int(8) NOT NULL,
  `stone_kind` varchar(20) NOT NULL,
  `stone_type` varchar(20) NOT NULL,
  `stone_color` varchar(20) NOT NULL,
  `stone_size` varchar(100) NOT NULL,
  `stone_font` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `purchase_id` int(8) NOT NULL,
  `payment_method` varchar(15) NOT NULL,
  `account_name` varchar(50) NOT NULL,
  `account_number` varchar(25) NOT NULL,
  `payment_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payout`
--

CREATE TABLE `payout` (
  `purchase_id` int(8) NOT NULL,
  `payout_method` varchar(25) NOT NULL,
  `account_name` varchar(50) DEFAULT NULL,
  `account_number` varchar(25) NOT NULL,
  `payout_datetime` datetime DEFAULT NULL,
  `payout_image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `provider`
--

CREATE TABLE `provider` (
  `provider_id` int(8) NOT NULL,
  `provider_logo` varchar(100) NOT NULL,
  `provider_company` varchar(25) NOT NULL,
  `provider_desc` varchar(200) NOT NULL,
  `provider_fname` varchar(25) NOT NULL,
  `provider_mi` char(1) NOT NULL,
  `provider_lname` varchar(25) NOT NULL,
  `provider_type` varchar(15) NOT NULL,
  `provider_phone` varchar(11) NOT NULL,
  `provider_address` varchar(300) NOT NULL,
  `provider_email` varchar(50) NOT NULL,
  `provider_pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `provider`
--

INSERT INTO `provider` (`provider_id`, `provider_logo`, `provider_company`, `provider_desc`, `provider_fname`, `provider_mi`, `provider_lname`, `provider_type`, `provider_phone`, `provider_address`, `provider_email`, `provider_pass`) VALUES
(13, '', '', '', 'Nicyl', '', 'Lapas', 'church', '', '', 'nicyllapas@gmail.com', 'd7e73fb6980b78278c69b4e9f024f16a'),
(14, '', '', '', 'Joe Marc', '', 'Malicay', 'funeral', '', '', 'joemarc123192@gmail.com', 'd7e73fb6980b78278c69b4e9f024f16a');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `purchase_id` int(8) NOT NULL,
  `seeker_id` int(8) NOT NULL,
  `service_id` int(8) NOT NULL,
  `purchase_total` decimal(9,2) DEFAULT NULL,
  `purchase_qty` int(2) DEFAULT NULL,
  `purchase_size` varchar(25) DEFAULT NULL,
  `purchase_font` varchar(25) DEFAULT NULL,
  `purchase_date` date NOT NULL,
  `purchase_wake_date` date DEFAULT NULL,
  `purchase_wake_time` varchar(50) DEFAULT NULL,
  `purchase_num_days` int(2) DEFAULT NULL,
  `purchase_burial_date` date DEFAULT NULL,
  `purchase_burial_time` varchar(50) DEFAULT NULL,
  `purchase_status` varchar(15) NOT NULL,
  `purchase_progress` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `request_id` int(8) NOT NULL,
  `purchase_id` int(8) NOT NULL,
  `seeker_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `requirement`
--

CREATE TABLE `requirement` (
  `req_id` int(8) NOT NULL,
  `provider_id` int(8) DEFAULT NULL,
  `seeker_id` int(8) DEFAULT NULL,
  `req_type` varchar(20) NOT NULL,
  `req_img` varchar(100) NOT NULL,
  `req_status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `requirement`
--

INSERT INTO `requirement` (`req_id`, `provider_id`, `seeker_id`, `req_type`, `req_img`, `req_status`) VALUES
(16, NULL, 20, 'seeker', '', 'verified'),
(17, 13, NULL, 'church', '', 'verified');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `purchase_id` int(8) NOT NULL,
  `schedule_address` varchar(100) NOT NULL,
  `schedule_datetime` datetime NOT NULL,
  `schedule_status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `seeker`
--

CREATE TABLE `seeker` (
  `seeker_id` int(8) NOT NULL,
  `seeker_fname` varchar(25) NOT NULL,
  `seeker_mi` char(1) DEFAULT NULL,
  `seeker_lname` varchar(25) NOT NULL,
  `seeker_address` varchar(100) DEFAULT NULL,
  `seeker_phone` varchar(11) DEFAULT NULL,
  `seeker_status` varchar(10) DEFAULT NULL,
  `seeker_email` varchar(50) NOT NULL,
  `seeker_pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seeker`
--

INSERT INTO `seeker` (`seeker_id`, `seeker_fname`, `seeker_mi`, `seeker_lname`, `seeker_address`, `seeker_phone`, `seeker_status`, `seeker_email`, `seeker_pass`) VALUES
(20, 'Joy', 'G', 'Blanco', 'A9845 Fake Street, Sitio Sample Barangay Test, Cebu City, Cebu', '09457239646', 'inactive', 'joyblanco819@gmail.com', 'd250786e8127c338aa76955b8c1faab2');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(8) NOT NULL,
  `provider_id` int(8) NOT NULL,
  `service_type` varchar(20) NOT NULL,
  `service_desc` varchar(500) NOT NULL,
  `service_cost` decimal(9,2) DEFAULT NULL,
  `service_qty` int(2) DEFAULT NULL,
  `service_img` varchar(100) NOT NULL,
  `service_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `provider_id` int(8) NOT NULL,
  `subs_startdate` date NOT NULL,
  `subs_duedate` date NOT NULL,
  `subs_description` varchar(200) NOT NULL,
  `subs_cost` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `candle`
--
ALTER TABLE `candle`
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `seeker_id` (`seeker_id`);

--
-- Indexes for table `catering`
--
ALTER TABLE `catering`
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `church`
--
ALTER TABLE `church`
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `details`
--
ALTER TABLE `details`
  ADD KEY `purchase_id` (`purchase_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `seeker_id` (`seeker_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `flower`
--
ALTER TABLE `flower`
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `funeral`
--
ALTER TABLE `funeral`
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `headstone`
--
ALTER TABLE `headstone`
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD KEY `purchase_id` (`purchase_id`);

--
-- Indexes for table `payout`
--
ALTER TABLE `payout`
  ADD KEY `purchase_id` (`purchase_id`);

--
-- Indexes for table `provider`
--
ALTER TABLE `provider`
  ADD PRIMARY KEY (`provider_id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `seeker_id` (`seeker_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `purchase_id` (`purchase_id`),
  ADD KEY `seeker_id` (`seeker_id`);

--
-- Indexes for table `requirement`
--
ALTER TABLE `requirement`
  ADD PRIMARY KEY (`req_id`),
  ADD KEY `provider_id` (`provider_id`),
  ADD KEY `seeker_id` (`seeker_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `purchase_id` (`purchase_id`);

--
-- Indexes for table `seeker`
--
ALTER TABLE `seeker`
  ADD PRIMARY KEY (`seeker_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`),
  ADD KEY `provide_id` (`provider_id`);

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD KEY `provider_id` (`provider_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `provider`
--
ALTER TABLE `provider`
  MODIFY `provider_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `purchase_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `request_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requirement`
--
ALTER TABLE `requirement`
  MODIFY `req_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `seeker`
--
ALTER TABLE `seeker`
  MODIFY `seeker_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`seeker_id`) REFERENCES `seeker` (`seeker_id`);

--
-- Constraints for table `church`
--
ALTER TABLE `church`
  ADD CONSTRAINT `church_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`);

--
-- Constraints for table `details`
--
ALTER TABLE `details`
  ADD CONSTRAINT `details_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`purchase_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`seeker_id`) REFERENCES `seeker` (`seeker_id`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`);

--
-- Constraints for table `funeral`
--
ALTER TABLE `funeral`
  ADD CONSTRAINT `funeral_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`);

--
-- Constraints for table `headstone`
--
ALTER TABLE `headstone`
  ADD CONSTRAINT `headstone_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`purchase_id`);

--
-- Constraints for table `payout`
--
ALTER TABLE `payout`
  ADD CONSTRAINT `payout_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`purchase_id`);

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `purchase_ibfk_1` FOREIGN KEY (`seeker_id`) REFERENCES `seeker` (`seeker_id`),
  ADD CONSTRAINT `purchase_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`);

--
-- Constraints for table `requirement`
--
ALTER TABLE `requirement`
  ADD CONSTRAINT `requirement_ibfk_1` FOREIGN KEY (`seeker_id`) REFERENCES `seeker` (`seeker_id`);

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`provider_id`) REFERENCES `provider` (`provider_id`);

--
-- Constraints for table `subscription`
--
ALTER TABLE `subscription`
  ADD CONSTRAINT `subscription_ibfk_1` FOREIGN KEY (`provider_id`) REFERENCES `provider` (`provider_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
