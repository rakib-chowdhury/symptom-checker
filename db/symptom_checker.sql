-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2020 at 06:30 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `symptom_checker`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `dob` bigint(20) DEFAULT NULL,
  `gender` tinyint(4) NOT NULL COMMENT '0=Female; 1=Male',
  `email` text NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `address` text DEFAULT NULL,
  `is_super_user` tinyint(4) NOT NULL DEFAULT 0,
  `created_on` bigint(20) DEFAULT NULL,
  `created_by` varchar(255) NOT NULL,
  `last_updated_on` bigint(20) DEFAULT NULL,
  `last_updated_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `user_name`, `name`, `last_name`, `dob`, `gender`, `email`, `phone_number`, `address`, `is_super_user`, `created_on`, `created_by`, `last_updated_on`, `last_updated_by`) VALUES
(1, 'rakibhamid', 'Rakib Ibna Hamid', 'Chowdhury', NULL, 1, 'rakib101025@gmail.com', '01833400025', NULL, 1, 1570026566812, 'rakibhamid', 1570026566812, 'rakibhamid'),
(2, 'riyad', 'Riyad', 'Chowdhury', NULL, 1, 'john_doe@gmail.com', '01746558799', NULL, 0, 1570047260000, 'rakibhamid', 1570113859000, 'riyad'),
(9, 'john_doe', 'John Doe', 'Doe', 771530400000, 1, 'john_doe@gmail.com', '01746558799', '', 0, 1570628028000, 'rakibhamid', 1570628028000, 'rakibhamid');

-- --------------------------------------------------------

--
-- Table structure for table `group_permissions`
--

CREATE TABLE `group_permissions` (
  `id` int(11) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1=Active; 0=Inactive; 2=Deleted',
  `created_on` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `group_permissions`
--

INSERT INTO `group_permissions` (`id`, `user_type_id`, `permission_id`, `status`, `created_on`) VALUES
(1, 2, 1, 1, 1570627836000),
(2, 2, 2, 1, 1570627836000),
(3, 3, 5, 1, 1570629996000);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_on` bigint(20) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `last_updated_on` bigint(20) NOT NULL,
  `last_updated_by` varchar(255) NOT NULL,
  `last_login` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `user_name`, `password`, `status`, `created_on`, `created_by`, `last_updated_on`, `last_updated_by`, `last_login`) VALUES
(1, 'rakibhamid', '0553d0b1c92a732c1775b12765378539', 1, 1570026633015, 'rakibhamid', 1570026633015, 'rakibhamid', 1570629363000),
(2, 'riyad', '40be4e59b9a2a2b5dffb918c0e86b3d7', 1, 1570047260000, 'rakibhamid', 1570441089000, 'rakibhamid', NULL),
(11, 'john_doe', 'e10adc3949ba59abbe56e057f20f883e', 1, 1570628028000, 'rakibhamid', 1570628028000, 'rakibhamid', 1570630006000);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_on` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `status`, `created_on`) VALUES
(1, 'add_users', 1, 1570525149000),
(2, 'view_user_list', 1, 1570525169000),
(3, 'edit_user', 1, 1570525199000),
(4, 'change_user_status', 1, 1570525209000),
(5, 'reset_user_password', 1, 1570525232000),
(6, 'delete_user', 1, 1570525240000);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_on` bigint(20) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `last_updated_on` bigint(20) NOT NULL,
  `last_updated_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `user_name`, `user_type_id`, `status`, `created_on`, `created_by`, `last_updated_on`, `last_updated_by`) VALUES
(1, 'john_doe', 2, 1, 1570628028000, 'rakibhamid', 1570628028000, 'rakibhamid'),
(2, 'john_doe', 3, 1, 1570628028000, 'rakibhamid', 1570628028000, 'rakibhamid');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_on` bigint(20) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `last_updated_on` bigint(20) NOT NULL,
  `last_updated_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `name`, `status`, `created_on`, `created_by`, `last_updated_on`, `last_updated_by`) VALUES
(1, 'Admin', 1, 1570627748000, 'rakibhamid', 1570627748000, 'rakibhamid'),
(2, 'Manager', 1, 1570627765000, 'rakibhamid', 1570629604000, 'rakibhamid'),
(3, 'Client', 1, 1570627772000, 'rakibhamid', 1570629615000, 'rakibhamid'),
(4, 'Customer', 1, 1570627778000, 'rakibhamid', 1570627778000, 'rakibhamid');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_permissions`
--
ALTER TABLE `group_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `group_permissions`
--
ALTER TABLE `group_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
