-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2018 at 05:24 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chat_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `attachment_name` text NOT NULL,
  `file_ext` text NOT NULL,
  `mime_type` text NOT NULL,
  `message_date_time` text NOT NULL,
  `ip_address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `sender_id`, `receiver_id`, `message`, `attachment_name`, `file_ext`, `mime_type`, `message_date_time`, `ip_address`) VALUES
(30, 184, 197, 'hi jon please send my project file report', '', '', '', '2018-06-13 17:28:40', '::1'),
(31, 197, 184, 'ok', '', '', '', '2018-06-13 17:28:45', '::1'),
(32, 197, 184, 'wait..', '', '', '', '2018-06-13 17:28:47', '::1'),
(33, 197, 184, 'NULL', 'Proejct_report_presenation.pptx', '.pptx', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', '2018-06-13 17:29:11', '::1'),
(34, 184, 197, 'ok thanks', '', '', '', '2018-06-13 17:30:21', '::1'),
(35, 197, 184, 'open the file', '', '', '', '2018-06-13 17:30:34', '::1'),
(36, 184, 197, 'please send images', '', '', '', '2018-06-13 17:31:22', '::1'),
(37, 197, 184, 'ok', '', '', '', '2018-06-13 17:31:27', '::1'),
(38, 197, 184, 'wait bro..', '', '', '', '2018-06-13 17:31:33', '::1'),
(39, 197, 184, 'NULL', '21_preview.png', '.png', 'image/png', '2018-06-13 17:31:43', '::1'),
(40, 197, 184, 'you got it', '', '', '', '2018-06-13 17:32:05', '::1'),
(41, 184, 197, 'yes', '', '', '', '2018-06-13 17:32:10', '::1'),
(42, 184, 197, 'thanks', '', '', '', '2018-06-13 17:32:16', '::1'),
(43, 184, 197, 'some pdf file send', '', '', '', '2018-06-13 17:32:33', '::1'),
(44, 197, 184, 'NULL', 'Invoice.pdf', '.pdf', 'application/pdf', '2018-06-13 17:33:03', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `role` text NOT NULL,
  `source` int(5) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  `is_email_verify` int(11) NOT NULL,
  `name` text NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `email` text NOT NULL,
  `alternateEmail` text NOT NULL,
  `mobile_no` text NOT NULL,
  `website` text NOT NULL,
  `picture_url` text NOT NULL,
  `profile_url` text NOT NULL,
  `vendor_file` text NOT NULL,
  `dob` text NOT NULL,
  `gender` text NOT NULL,
  `about` text NOT NULL,
  `type` text NOT NULL,
  `address` text NOT NULL,
  `address_2` text NOT NULL,
  `country` text NOT NULL,
  `language` text NOT NULL,
  `state` text NOT NULL,
  `city` text NOT NULL,
  `pincode` text NOT NULL,
  `ip_address` text NOT NULL,
  `created` text NOT NULL,
  `lastlogged` text NOT NULL,
  `modified` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `source`, `status`, `is_email_verify`, `name`, `first_name`, `last_name`, `email`, `alternateEmail`, `mobile_no`, `website`, `picture_url`, `profile_url`, `vendor_file`, `dob`, `gender`, `about`, `type`, `address`, `address_2`, `country`, `language`, `state`, `city`, `pincode`, `ip_address`, `created`, `lastlogged`, `modified`) VALUES
(127, 'admin@ca.com', '$2y$12$RyMmZVcqPEt9X2lJbHg1PeFJqcpURF2QOrH4vqMEQELe9wDMLfZYe', 'Admin', 1, 1, 0, 'Admin', 'Super', 'Admin', 'admin@admin.com', '', '', '', 'eligibility-jump.png', '', '', '', '', 'asdfsdfsdfsdf', '', 'Helosdf', '', '', '', '', '', '302039', '::1', '2018-03-21 15:53:01', '', '2018-03-22 07:31:43'),
(184, 'vendor1@ca.com', '$2y$12$RyMmZVcqPEt9X2lJbHg1PeFJqcpURF2QOrH4vqMEQELe9wDMLfZYe', 'Vendor', 0, 1, 1, 'Vendor 1 xyz', 'Vendor 1', 'xyz', 'vendor1@xyz.com', '', '', '', '4.png', '', '[\"27042018105604_test - Copy (2).png\",\"27042018105604_test - Copy (3) - Copy.png\"]', '', '', '', '', '', '', '', '', '', '', '', '::1', '2018-04-27 10:56:05', '', ''),
(185, 'vendor2@ca.com', '$2y$12$RyMmZVcqPEt9X2lJbHg1PeFJqcpURF2QOrH4vqMEQELe9wDMLfZYe', 'Vendor', 0, 1, 1, 'Vendor 2 xyz', 'Vendor 2', 'xyz', 'vendor2@xyz.com', '', '', '', '', '', '[\"27042018105632_message-bar-chart3.png\",\"27042018105632_test - Copy (2).png\"]', '', '', '', '', '', '', '', '', '', '', '', '::1', '2018-04-27 10:56:33', '', ''),
(196, 'client1@ca.com', '$2y$12$RyMmZVcqPEt9X2lJbHg1PeFJqcpURF2QOrH4vqMEQELe9wDMLfZYe', 'Client_cs', 0, 1, 1, 'Client 1 xyz', 'Client 1', 'xyz', 'client1@xyz.com', '', '', '', '1.png', '', '', '', '', '', '', '', '', '', '', '', '', '', '::1', '2018-04-27 10:56:05', '', ''),
(197, 'client2@ca.com', '$2y$12$RyMmZVcqPEt9X2lJbHg1PeFJqcpURF2QOrH4vqMEQELe9wDMLfZYe', 'Client_cs', 0, 1, 1, 'Client 2 xyz', 'Client 2', 'xyz', 'client2@xyz.com', '', '', '', '2.png', '', '', '', '', '', '', '', '', '', '', '', '', '', '::1', '2018-04-27 10:56:05', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
