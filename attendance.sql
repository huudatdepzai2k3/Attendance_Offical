-- phpMyAdmin SQL Dump
-- version 8.2.4
-- https://www.phpmyadmin.net/
-- Host: 127.0.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `admin_name` varchar(30) NOT NULL,
  `admin_email` varchar(80) NOT NULL,
  `admin_pwd` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_name`, `admin_email`, `admin_pwd`) VALUES
(1, 'Dat dep zai', 'ndat2329@gmail.com', '$2y$10$89uX3LBy4mlU/DcBveQ1l.32nSianDP/E1MfUh.Z.6B4Z0ql3y7PK');

-- --------------------------------------------------------
-- Table structure for table `check_url`
CREATE TABLE `check_url` (
  `id` int(11) NOT NULL,
  `selector_check` varchar(80) NOT NULL,
  `validator_check` LONGTEXT NOT NUll,
  `time_create` int(14) NOT NULL
);

-- Table structure for table `check_otp`
CREATE TABLE `check_otp` (
  `id` int(11) NOT NULL,
  `otp_check` TEXT NOT NULL,
  `email_change` TEXT NOT NULL,
  `time_create` int(14) NOT NULL
);
--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` int(11) NOT NULL,
  `device_name` varchar(50) NOT NULL,
  `device_dep` varchar(20) NOT NULL,
  `device_uid` text NOT NULL,
  `device_date` date NOT NULL,
  `device_mode` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
-- Đang đổ dữ liệu cho bảng `devices`
--

INSERT INTO `devices` (`id`, `device_name`, `device_dep`, `device_uid`, `device_date`, `device_mode`) VALUES
(1, 'ESP8266', 'HUMG_DTDB2_K66', '007642b40dc47ec6', '2024-05-15', 1);
--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL DEFAULT 'None',
  `serialnumber` double NOT NULL DEFAULT '0',
  `gender` varchar(10) NOT NULL DEFAULT 'None',
  `email` varchar(50) NOT NULL DEFAULT 'None',
  `card_uid` varchar(30) NOT NULL,
  `fingerprint_id` int(11) NOT NULL,
  `card_select` tinyint(1) NOT NULL DEFAULT '0',
  `user_date` date NOT NULL,
  `device_uid` varchar(20) NOT NULL DEFAULT '0',
  `device_dep` varchar(20) NOT NULL DEFAULT '0',
  `add_card` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `serialnumber`, `gender`, `email`, `card_uid`, `fingerprint_id`, `card_select`, `user_date`, `device_uid`, `device_dep`, `add_card`) VALUES
(1, 'Nguyen Van A', 1111, 'Male', 'example1@gmail.com', '239d4afc', 1, 0, '2024-05-15', '007642b40dc47ec6', 'HUMG_DTDB2_K66', 1),
(2, 'Nguyen Van B', 1112, 'Female', 'example2@gmail.com', '444ry2f', 2, 0, '2024-05-15', '007642b40dc47ec6', 'HUMG_DTDB2_K66', 1),
(3, 'Nguyen Van C', 1113, 'Male', 'example3@gmail.com', '127wq413', 3, 0, '2024-05-15', '007642b40dc47ec6', 'HUMG_DTDB2_K66', 1),
(4, 'Nguyen Van D', 1114, 'Male', 'example4@gmail.com', '8198ww25', 4, 0, '2024-05-15', '007642b40dc47ec6', 'HUMG_DTDB2_K66', 1),
(5, 'Nguyen Van E', 1115, 'Female', 'example5@gmail.com', '1271qw501', 5, 1, '2024-05-15', '007642b40dc47ec6', 'HUMG_DTDB2_K66', 1),
(6, 'Tran Van C', 1117, 'Male', 'example6@gmail.com', '224we2f4', 6, 0, '2024-05-15', '007642b40dc47ec6', 'HUMG_DTDB2_K66', 1),
(7, 'Tran Van A', 1116, 'Female', 'example7@gmail.com', '15sd9e51', 7, 0, '2024-05-15', '007642b40dc47ec6', 'HUMG_DTDB2_K66', 1),
(8, 'Tran Van B', 1118, 'Female', 'example8@gmail.com', '12we4h93', 8, 0, '2024-05-15', '007642b40dc47ec6', 'HUMG_DTDB2_K66', 1),
(9, 'Tran Van D', 119, 'Female', 'example9@gmail.com', '2r4w2fc', 9, 0, '2024-05-15', '007642b40dc47ec6', 'HUMG_DTDB2_K66', 1),
(10, 'Tran Van E', 1120, 'Male', 'example10@gmail.com', '15tw7wqt8', 10, 0, '2024-05-15', '007642b40dc47ec6', 'HUMG_DTDB2_K66', 1);
--
-- Table structure for table `users_logs`
--

CREATE TABLE `users_logs` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `serialnumber` double NOT NULL,
  `card_uid` varchar(30) NOT NULL,
  `fingerprint_id` int(11) NOT NULL,
  `device_uid` varchar(20) NOT NULL,
  `device_dep` varchar(20) NOT NULL,
  `checkindate` date NOT NULL,
  `timein` time NOT NULL,
  `checkoutdate` date NOT NULL,
  `timeout` time NOT NULL,
  `card_out` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users_logs` (`id`, `username`, `serialnumber`, `card_uid`,`fingerprint_id`,`device_uid`, `device_dep`, `checkindate`, `timein`,`checkoutdate`, `timeout`, `card_out`) VALUES 
  (1, 'Nguyen Van B', 1112, '444ry2f', 2, '007642b40dc47ec6', 'HUMG_DTDB2_K66', '2024-05-15', '12:40:21', '2024-05-15', '17:33:27', 1);

  


-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_logs`
--
ALTER TABLE `users_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_logs`
--
ALTER TABLE `users_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
