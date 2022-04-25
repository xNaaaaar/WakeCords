-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2022 at 01:08 PM
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
(1, 'Admn', 'Z', 'Admn', 'admin@wakecords.com', '0192023a7bbd73250516f069df18b500'),
(2, 'New Admin', 'N', 'New Admin', 'admin1@wakecords.com', '0192023a7bbd73250516f069df18b500'),
(3, 'Admiin', 'A', 'Admiin', 'admin2@wakecords.com', '0192023a7bbd73250516f069df18b500');

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
  `cart_qty` int(2) NOT NULL,
  `cart_size` varchar(15) DEFAULT NULL
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
  `church_address` varchar(100) NOT NULL,
  `church_mass_date` date NOT NULL,
  `church_mass_time` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `church`
--

INSERT INTO `church` (`service_id`, `church_church`, `church_cemetery`, `church_priest`, `church_address`, `church_mass_date`, `church_mass_time`) VALUES
(34, 'Sto. Rosario', 'Carreta', 'Benedict Servi', 'Sitio Granada Quiot Pardo, Cebu City Philippines', '2022-04-26', '10:00 am - 11:00 am, 11:00 am - 12:00 nn, 12:00 nn - 01:00 pm, 01:00 pm - 02:00 pm, 02:00 pm - 03:00'),
(37, 'San Roque 2', 'Pardoow', 'George Waise', 'Quiot Pardo, Cebu City Philippines', '2022-05-01', '10:00 am - 11:00 am, 11:00 am - 12:00 nn, 12:00 nn - 01:00 pm, 01:00 pm - 02:00 pm, 02:00 pm - 03:00');

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
(10, 'Jan-Jan Dowll', '2022-04-12 13:00:00', 'This Is My New Updated Address', 'This Is My New Updated Address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'Asdys Sdfwe', '2022-04-23 18:46:00', 'Address 2', 'My Address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'Asdys Sdfwe', '2022-04-30 21:12:00', 'Sample Burial Address', 'My Address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'Asdys Sdfwe', '2022-04-28 19:23:00', 'Sample Burial Address', 'My Address', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
(1, 10, 1, 4, '', '2022-04-10'),
(2, 10, 1, 3, NULL, '2022-04-12'),
(3, 10, 9, 5, 'Very good!', '2022-04-12'),
(4, 10, 29, 3, 'This is my comment!', '2022-04-25');

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
  `funeral_size` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `funeral`
--

INSERT INTO `funeral` (`service_id`, `funeral_name`, `funeral_type`, `funeral_size`) VALUES
(1, 'St. Jude', 'traditional', NULL),
(2, 'St. Thomas', 'cremation', NULL),
(9, 'St. Benedicto', 'cremation', NULL),
(26, 'New Coffin 2', 'cremation', 'size #1,size #2,size #3,size #6,sample1, sample2'),
(29, 'New Coffin', 'traditional', 'size #2,size #5,sample1, sample2');

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

--
-- Dumping data for table `headstone`
--

INSERT INTO `headstone` (`service_id`, `stone_kind`, `stone_type`, `stone_color`, `stone_size`, `stone_font`) VALUES
(19, 'flat', 'bronze', 'black', 'size #2,size #4,', 'font #2,font #5,'),
(31, 'flat', 'bronze', 'black', 'size #1,size #4,size #5,sample#5, sample#1', 'font #1,font #4,sample#1'),
(32, 'flat', 'granite', 'white', 'size #3,size #6,sample3, sample6', 'font #3,font #6,sample#1');

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
-- Table structure for table `payout`
--

CREATE TABLE `payout` (
  `purchase_id` int(8) NOT NULL,
  `payout_method` varchar(25) NOT NULL,
  `payout_account` varchar(25) NOT NULL,
  `payout_image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payout`
--

INSERT INTO `payout` (`purchase_id`, `payout_method`, `payout_account`, `payout_image`) VALUES
(10, 'card', '2312323', '6251afbe887f97.73718527.png'),
(21, 'gcash', '2312323', '62665a3e458531.94001106.jpg'),
(22, 'card', '4472523544', NULL);

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
  `provider_address` varchar(100) NOT NULL,
  `provider_email` varchar(50) NOT NULL,
  `provider_pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `provider`
--

INSERT INTO `provider` (`provider_id`, `provider_logo`, `provider_company`, `provider_desc`, `provider_fname`, `provider_mi`, `provider_lname`, `provider_type`, `provider_phone`, `provider_address`, `provider_email`, `provider_pass`) VALUES
(1, '625573639b7841.77026679.png', 'Cosmopolitan', '', 'Nicyl', 'D', 'Lapas', 'funeral', '09090909090', 'Mabolo', 'nicyl@gmail.com', 'd7e73fb6980b78278c69b4e9f024f16a'),
(2, '', '', '', 'Flower', '', 'Provider', 'flower', '', '', 'flower@provider.com', 'd7e73fb6980b78278c69b4e9f024f16a'),
(3, '62556ec5694796.07430911.png', 'Sent Church', '', 'Melnaaar', 'B', 'Ancit', 'church', '09560376576', 'Sitio Granada Quiot Pardo, Cebu City Philippines', 'narancit@gmail.com', 'd7e73fb6980b78278c69b4e9f024f16a'),
(4, '62569c4e6bd8d9.82250856.jpg', 'Marbles', '', 'Head', 'T', 'Stone', 'headstone', '09457239646', 'This Is My Address', 'headstone@wakecords.com', 'd7e73fb6980b78278c69b4e9f024f16a'),
(5, '', '', '', 'Candol', '', 'Meker', 'candle', '', '', 'candle@wakecords.com', 'd7e73fb6980b78278c69b4e9f024f16a'),
(6, '', '', '', 'Kather', '', 'Reng', 'catering', '', '', 'catering@wakecords.com', 'd7e73fb6980b78278c69b4e9f024f16a');

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
  `purchase_size` varchar(15) DEFAULT NULL,
  `purchase_date` date NOT NULL,
  `purchase_status` varchar(15) NOT NULL,
  `purchase_progress` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`purchase_id`, `seeker_id`, `service_id`, `purchase_total`, `purchase_qty`, `purchase_size`, `purchase_date`, `purchase_status`, `purchase_progress`) VALUES
(10, 10, 1, '220000.00', 2, NULL, '2022-03-21', 'rated', 5),
(19, 16, 9, '100000.00', 1, NULL, '2022-04-13', 'paid', 0),
(21, 10, 29, '20000.00', 1, 'sample1', '2022-04-25', 'rated', 5),
(22, 10, 1, '110000.00', 1, '', '2022-04-25', 'done', 5);

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
(2, NULL, 13, 'death certificate', '6247da321a0a64.72029108.jpg', 'verified'),
(3, NULL, 14, 'death certificate', '6240038f3f6390.99031927.png', 'not verified'),
(4, 1, NULL, 'business permit', '6248240f08d326.27804580.jpg', 'verified'),
(5, 3, NULL, 'business permit', '62497c52bc1541.38904101.jpg', 'verified'),
(6, 4, NULL, 'business permit', '62569d068ca7e9.87658203.png', 'verified'),
(7, 5, NULL, 'business permit', '626657149e2ca9.95810840.jpg', 'verified');

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
(16, 'JJ', NULL, 'GG', NULL, NULL, 'inactive', 'jpulllefoiapnhcpak@kvhrr.com', '60719b813c16a8bd57388c1cdb047c22');

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
(1, 1, 'funeral', 'This is the new and final part of the funeral liturgy occurs at the cemetery.  ', '110000.00', 4, 'coffin.png', 'active'),
(2, 1, 'funeral', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ad corrupti beatae magni rerum doloribus, vitae inventore. Tempore quod fugit commodi!', '80000.00', 1, 'coffin.png', 'active'),
(9, 1, 'funeral', 'An important part of grieving and of honouring the life of a person is the releasing of their remains to the earth.  A committal is the gathering of a small community, often just close family & friends, and the presider, at the graveside or mausoleum.', '100000.00', 4, '6249572712ddd5.72232742.png', 'active'),
(19, 4, 'headstone', 'This is my sample description of headstone service.', '66666.00', 6, '62641fcd338220.97815685.jpg', 'active'),
(26, 1, 'funeral', 'This is my new funeral description for adult.', '55556.00', 12, '62652a865a28b5.76843127.png', 'active'),
(29, 1, 'funeral', 'This is my new description for child.', '20000.00', 4, '62653bac37a939.71344588.png', 'active'),
(31, 4, 'headstone', 'This is my another updated sample of headstone\'s description.', '55555.00', 15, '62660842a0d699.20167841.jpg', 'active'),
(32, 4, 'headstone', 'This is my new headstone service.', '123123.00', 12, '626608f8902278.65745779.jpg', 'active'),
(34, 3, 'church', 'This is my sample description of this specific Church service.', NULL, NULL, '6266305610a584.54404705.jpg', 'active'),
(37, 3, 'church', 'This is my updated description.', NULL, NULL, '626646477ece95.78724691.jpg', 'active');

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
(1, '2022-03-03', '2022-04-03', 'Provider can post and boost their service in an affordable amount.', '200.00'),
(3, '2022-04-03', '2023-04-03', 'Provider can post and boost their service in an affordable amount.', '2000.00'),
(1, '2022-04-06', '2022-05-06', 'Provider can post and boost their service in an affordable amount.', '200.00'),
(4, '2022-04-13', '2022-05-13', 'Provider can post and boost their service in an affordable amount.', '200.00'),
(5, '2022-04-25', '2023-04-25', 'Provider can post and boost their service in an affordable amount.', '2000.00');

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
  MODIFY `cart_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `provider`
--
ALTER TABLE `provider`
  MODIFY `provider_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `purchase_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `request_id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requirement`
--
ALTER TABLE `requirement`
  MODIFY `req_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `seeker`
--
ALTER TABLE `seeker`
  MODIFY `seeker_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

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
