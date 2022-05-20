-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2022 at 02:23 AM
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

--
-- Dumping data for table `church`
--

INSERT INTO `church` (`service_id`, `church_church`, `church_cemetery`, `church_priest`, `church_address`, `church_mass_date`, `church_mass_time`) VALUES
(71, 'Sto. Rosario', 'Caretta', 'George Wais', '2392 E. Sabellano Street, Sitio Granada Quiot Pardo, Cebu City, Cebu', NULL, NULL),
(72, 'Lourdes Church', 'Pardo', 'Benedict Servi', '2392 E. Sabellano Street, Sitio Granada Quiot Pardo, Cebu City, Cebu', NULL, NULL);

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

--
-- Dumping data for table `details`
--

INSERT INTO `details` (`purchase_id`, `deceased_name`, `burial_datetime`, `burial_add`, `delivery_add`, `delivery_date`, `message`, `birth_date`, `death_date`, `delivery_datetime`, `num_pax`, `cemetery_add`) VALUES
(51, 'Deceased Name', '2022-05-21 18:05:00', 'Sample Burial Address', 'My Updated Delivery Address', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(61, 'John Doeeer', NULL, NULL, NULL, NULL, NULL, NULL, '2022-05-14', NULL, NULL, NULL);

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

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `seeker_id`, `service_id`, `feedback_star`, `feedback_comments`, `feedback_date`) VALUES
(6, 17, 46, 4, '', '2022-05-12'),
(7, 19, 71, 5, '', '2022-05-18');

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

--
-- Dumping data for table `funeral`
--

INSERT INTO `funeral` (`service_id`, `funeral_name`, `funeral_type`, `funeral_kind`, `funeral_size`, `funeral_qty`, `funeral_price`) VALUES
(45, 'St. Jude', 'traditional', '', 'size #1,size #2,size #4,', NULL, NULL),
(46, 'St. Catherine', 'cremation', '', 'size #2,size #5,', NULL, NULL),
(47, 'St. Bernadette', 'traditional', '', 'size #3,size #4,size #5,', NULL, NULL),
(48, 'St. Paul', 'traditional', '', 'size #4,sample size#1', NULL, NULL),
(74, 'St. Bernadette', 'traditional', 'wooden', '6x3x4,7x3x4,5x3x4,4x3x4', '50,20,10,15', '35000,20000,25000,29000');

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

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`purchase_id`, `payment_method`, `account_name`, `account_number`, `payment_datetime`) VALUES
(51, 'gcash', 'My Name', '09345588383', '2022-05-12 18:06:54'),
(61, 'gcash', 'My Account Name', '09345588383', '2022-05-18 18:03:09');

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

--
-- Dumping data for table `payout`
--

INSERT INTO `payout` (`purchase_id`, `payout_method`, `account_name`, `account_number`, `payout_datetime`, `payout_image`) VALUES
(51, 'gcash', 'Nelmar Citan', '04958283757', '2022-05-12 18:21:48', '627ce005351128.55894108.png'),
(61, 'gcash', 'Nelmar Citan', '04958283757', '2022-05-18 23:42:09', '62851425aedc89.20980104.png');

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
(7, '627beb937df714.58366619.png', 'Church Corporation', '', 'Nicyl', 'H', 'Lapas', 'church', '09457239646', '2392 Fake Street, Sitio Granada Quiot Pardo, Cebu City, Cebu', 'nicyllapas@gmail.com', 'd7e73fb6980b78278c69b4e9f024f16a'),
(8, '627c6bfc278075.93773823.jpg', 'Cosmopolitan', '', 'Jane', 'V', 'Doe', 'funeral', '09457239646', 'Fake Address St.', 'funeral@wakecords.com', 'd7e73fb6980b78278c69b4e9f024f16a'),
(9, '627cc232f1dc11.01858196.png', 'Marbles', '', 'Jooon', 'K', 'Dee', 'headstone', '09457239646', 'My Sample Address', 'headstone@wakecords.com', 'd7e73fb6980b78278c69b4e9f024f16a'),
(10, '627cd7b895bb55.68335576.jpg', 'St. Peter', '', 'Jane', 'J', 'Dee', 'funeral', '09457239646', 'Sample Fake Address', 'saintpeter@wakecords.com', 'd7e73fb6980b78278c69b4e9f024f16a'),
(11, '6280abb997b055.59562307.jpg', 'Church Incorporation', '', 'Meelnar', 'B', 'Aancit', 'church', '09457239646', '2392 E. Sabellano Street, Sitio Granada Quiot Pardo, Cebu City, Cebu', 'narancit@gmail.com', 'd7e73fb6980b78278c69b4e9f024f16a'),
(12, '628609c82aac43.94774141.png', 'St. Anghel', '', 'Prove', 'T', 'Vader', 'funeral', '09457239646', '5492A Fake Street, Sitio Sample Barangay Test, Mandaue City, Cebu', 'narancit2021@gmail.com', 'd7e73fb6980b78278c69b4e9f024f16a');

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

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`purchase_id`, `seeker_id`, `service_id`, `purchase_total`, `purchase_qty`, `purchase_size`, `purchase_font`, `purchase_date`, `purchase_wake_date`, `purchase_wake_time`, `purchase_num_days`, `purchase_burial_date`, `purchase_burial_time`, `purchase_status`, `purchase_progress`) VALUES
(51, 17, 46, '30000.00', 1, 'size #2', NULL, '2022-05-12', NULL, NULL, NULL, NULL, NULL, 'rated', 5),
(52, 17, 48, '30000.00', 1, 'size #4', NULL, '2022-05-12', NULL, NULL, NULL, NULL, NULL, 'to pay', 0),
(61, 19, 71, '1300.00', NULL, NULL, NULL, '2022-05-18', '2022-05-21', '07:00pm - 08:00pm', 6, '2022-05-27', '10:00am - 11:00am', 'rated', 8),
(62, 19, 71, '800.00', NULL, NULL, NULL, '2022-05-19', '2022-06-01', '04:00pm - 05:00pm', 3, '2022-06-04', '10:00am - 11:00am', 'for approval', 0);

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
(8, NULL, 17, 'death certificate', '627be29e2b2ed6.83989884.jpg', 'verified'),
(9, 7, NULL, 'business permit', '627beba7ddb7a5.00566049.jpg', 'verified'),
(10, 8, NULL, 'business permit', '627c6c2deac569.28939915.jpg', 'verified'),
(11, 9, NULL, 'business permit', '627face55bf158.12435535.jpg', 'not verified'),
(12, 10, NULL, 'business permit', '627cd7c6519e11.94355213.jpg', 'verified'),
(13, 11, NULL, 'church', '', 'verified'),
(14, NULL, 19, 'seeker', '', 'verified'),
(15, 12, NULL, 'business permit', '628609dddd5640.90228614.png', 'verified');

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
(17, 'Merry Joy', 'G', 'Blanco', '119A Fake Street, Sitio Kamputhaw Quiot Pardo, Cebu City, Cebu', '09457239646', 'inactive', 'joyblanco819@gmail.com', 'd250786e8127c338aa76955b8c1faab2'),
(19, 'Newtwo', 'G', 'Sakeer', '5583 Fake Street, Fake Sitio In Brgy, Cebu City, Cebu', '09457239646', 'inactive', 'seeker@gmail.com', 'd250786e8127c338aa76955b8c1faab2');

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

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `provider_id`, `service_type`, `service_desc`, `service_cost`, `service_qty`, `service_img`, `service_status`) VALUES
(45, 8, 'funeral', 'This is my sample description for St. Jude traditional services.', '50000.00', 5, '627cd8baab3078.81509166.png', 'active'),
(46, 8, 'funeral', 'This is my sample description for St. Catherine cremation services.', '30000.00', 0, '627cd90552d5b3.83874925.jpg', 'inactive'),
(47, 8, 'funeral', 'This is my sample description for St. Bernadette traditional funeral services.', '40000.00', 4, '627cda89dbb2c7.95809111.png', 'active'),
(48, 10, 'funeral', 'This is my description for St. Paul traditional funeral services.', '30000.00', 3, '627ce5026bbe33.40763445.png', 'active'),
(71, 11, 'church', 'This package includes: wake pamisa (x no. of days) and burial pamisa after wake pamisa.', '800.00', NULL, '6280ca1aaebc65.26001768.jpg', 'active'),
(72, 11, 'church', 'This package includes: wake mass (x no. of days) and burial mass after wake mass.', '750.00', NULL, '62821ff2eac687.79673148.jpg', 'active'),
(74, 12, 'funeral', 'This is my sample description for funeral tradition services. This is my sample packages: sample package #1, sample package #2, sample package #3 and sample package #4.', NULL, NULL, '62865b6e0a2fc1.77696580.png', 'active');

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
-- Dumping data for table `subscription`
--

INSERT INTO `subscription` (`provider_id`, `subs_startdate`, `subs_duedate`, `subs_description`, `subs_cost`) VALUES
(8, '2022-05-12', '2023-05-12', 'Provider can post and boost their service in an affordable amount.', '2000.00'),
(10, '2022-05-12', '2022-06-12', 'Provider can post and boost their service in an affordable amount.', '200.00'),
(11, '2022-05-15', '2022-06-15', 'Provider can post and boost their service in an affordable amount.', '200.00'),
(12, '2022-05-19', '2023-05-19', 'Provider can post and boost their service in an affordable amount.', '2000.00');

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
  MODIFY `provider_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  MODIFY `req_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `seeker`
--
ALTER TABLE `seeker`
  MODIFY `seeker_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
