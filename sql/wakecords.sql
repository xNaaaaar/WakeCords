-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2022 at 03:21 PM
-- Server version: 10.4.18-MariaDB
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
(1, 'Admiiin', 'I', 'Admiiin', 'admin@wakecords.com', '0192023a7bbd73250516f069df18b500'),
(2, 'New Admin', 'N', 'New Admin', 'admin1@wakecords.com', '0192023a7bbd73250516f069df18b500');

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
  `cart_qty` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `church`
--

CREATE TABLE `church` (
  `service_id` int(8) NOT NULL,
  `church_type` varchar(20) NOT NULL,
  `church_church` varchar(50) NOT NULL,
  `church_priest` varchar(20) NOT NULL,
  `church_address` varchar(100) NOT NULL,
  `church_mass_sched` datetime NOT NULL
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
  `msg_ribbon` varchar(200) DEFAULT NULL,
  `msg_headstone` varchar(200) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `death_date` date DEFAULT NULL,
  `delivery_datetime` datetime DEFAULT NULL,
  `num_pax` int(4) DEFAULT NULL,
  `cemetery_add` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `details`
--

INSERT INTO `details` (`purchase_id`, `deceased_name`, `burial_datetime`, `burial_add`, `delivery_add`, `delivery_date`, `msg_ribbon`, `msg_headstone`, `birth_date`, `death_date`, `delivery_datetime`, `num_pax`, `cemetery_add`) VALUES
(10, 'John Doe', '2022-04-09 19:06:00', 'This Is My Address', 'This Is My Address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'John Doe', '2022-04-16 15:14:00', 'This Is My Address', 'This Is My Address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'John Doe', '2022-04-16 15:14:00', 'This Is My Address', 'This Is My Address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(8) NOT NULL,
  `seeker_id` int(8) NOT NULL,
  `service_id` int(8) NOT NULL,
  `feedback_star` int(8) NOT NULL,
  `feedback_comments` varchar(250) NOT NULL
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
-- Table structure for table `food_cater`
--

CREATE TABLE `food_cater` (
  `service_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `funeral`
--

CREATE TABLE `funeral` (
  `service_id` int(8) NOT NULL,
  `funeral_name` varchar(50) NOT NULL,
  `funeral_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `funeral`
--

INSERT INTO `funeral` (`service_id`, `funeral_name`, `funeral_type`) VALUES
(1, 'St. Jude', 'traditional'),
(2, 'St. Thomas', 'cremation'),
(3, 'St. Catherine', 'cremation');

-- --------------------------------------------------------

--
-- Table structure for table `headstone`
--

CREATE TABLE `headstone` (
  `service_id` int(8) NOT NULL,
  `stone_type` varchar(20) NOT NULL,
  `stone_size` varchar(10) NOT NULL,
  `stone_font` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `purchase_id` int(8) NOT NULL,
  `payment_method` varchar(15) NOT NULL,
  `payment_datetime` datetime NOT NULL,
  `payment_status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `provider`
--

CREATE TABLE `provider` (
  `provider_id` int(8) NOT NULL,
  `provider_company` varchar(25) NOT NULL,
  `provider_desc` varchar(200) NOT NULL,
  `provider_fname` varchar(25) NOT NULL,
  `provider_mi` char(1) NOT NULL,
  `provider_lname` varchar(25) NOT NULL,
  `provider_type` varchar(15) NOT NULL,
  `provider_phone` varchar(11) NOT NULL,
  `provider_address` varchar(100) NOT NULL,
  `provider_email` varchar(50) NOT NULL,
  `provider_pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `provider`
--

INSERT INTO `provider` (`provider_id`, `provider_company`, `provider_desc`, `provider_fname`, `provider_mi`, `provider_lname`, `provider_type`, `provider_phone`, `provider_address`, `provider_email`, `provider_pass`) VALUES
(1, '', '', 'Nicyl', '', 'Lapas', 'funeral', '', '', 'nicyl@gmail.com', '917b4e1bc1a0f75efeed0afcf703b8ea');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `purchase_id` int(8) NOT NULL,
  `seeker_id` int(8) NOT NULL,
  `service_id` int(8) NOT NULL,
  `purchase_total` decimal(9,2) NOT NULL,
  `purchase_qty` int(2) NOT NULL,
  `purchase_date` date NOT NULL,
  `purchase_status` varchar(15) NOT NULL,
  `purchase_progress` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`purchase_id`, `seeker_id`, `service_id`, `purchase_total`, `purchase_qty`, `purchase_date`, `purchase_status`, `purchase_progress`) VALUES
(10, 10, 1, '220000.00', 2, '2022-03-21', 'paid', 0),
(11, 10, 2, '80000.00', 1, '2022-03-23', 'paid', 0),
(13, 14, 1, '110000.00', 1, '2022-03-27', 'to pay', 0),
(14, 10, 2, '80000.00', 1, '2022-03-27', 'paid', 0);

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
(1, NULL, 10, 'death certificate', '6220cb08d606a4.91479037.jpg', 'verified'),
(2, NULL, 13, 'death certificate', '622c4d0cc5f490.06257154.jpg', 'pending'),
(3, NULL, 14, 'death certificate', '6240038f3f6390.99031927.png', 'not verified');

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
(10, 'Merry Joy', 'G', 'Blancooo', 'Capitol Site Street', '09560376575', 'active', 'joyblanco@gmail.com', 'd250786e8127c338aa76955b8c1faab2'),
(11, 'Lindor', NULL, 'Siton', NULL, NULL, 'inactive', 'lindor@gmail.com', 'd250786e8127c338aa76955b8c1faab2'),
(12, 'John', NULL, 'Doe', NULL, NULL, 'inactive', 'johndoe@gmail.com', 'd250786e8127c338aa76955b8c1faab2'),
(13, 'Jane', NULL, 'Doe', NULL, NULL, 'inactive', 'janedoe@gmail.com', 'd250786e8127c338aa76955b8c1faab2'),
(14, 'Bernadette', 'G', 'Lapas', 'Mabolo', '09090909090', 'inactive', 'Blapas@gmail.com', '711037ae9ed6036d7de8e252dddd57b8'),
(15, 'Melnar', NULL, 'Ancit', NULL, NULL, 'inactive', 'narancit@gmail.com', 'e93ff6979683e7b179bcee52d1d809c8');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(8) NOT NULL,
  `provider_id` int(8) NOT NULL,
  `service_type` varchar(20) NOT NULL,
  `service_name` varchar(50) NOT NULL,
  `service_desc` varchar(500) NOT NULL,
  `service_cost` decimal(9,2) NOT NULL,
  `service_qty` int(2) NOT NULL,
  `service_img` varchar(100) NOT NULL,
  `service_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `provider_id`, `service_type`, `service_name`, `service_desc`, `service_cost`, `service_qty`, `service_img`, `service_status`) VALUES
(1, 1, 'funeral', 'St. Peter', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ad corrupti beatae magni rerum doloribus, vitae inventore. Tempore quod fugit commodi!', '110000.00', 8, 'coffin.png', 'active'),
(2, 1, 'funeral', 'Cosmopolitan', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ad corrupti beatae magni rerum doloribus, vitae inventore. Tempore quod fugit commodi!', '80000.00', 1, 'coffin.png', 'active'),
(3, 1, 'funeral', 'St. Peter', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ad corrupti beatae magni rerum doloribus, vitae inventore. Tempore quod fugit commodi!', '70000.00', 2, 'coffin.png', 'active');

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
-- Indexes for table `food_cater`
--
ALTER TABLE `food_cater`
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
  MODIFY `admin_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `provider`
--
ALTER TABLE `provider`
  MODIFY `provider_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `purchase_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `request_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requirement`
--
ALTER TABLE `requirement`
  MODIFY `req_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `seeker`
--
ALTER TABLE `seeker`
  MODIFY `seeker_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- Constraints for table `details`
--
ALTER TABLE `details`
  ADD CONSTRAINT `details_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`purchase_id`);

--
-- Constraints for table `funeral`
--
ALTER TABLE `funeral`
  ADD CONSTRAINT `funeral_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
