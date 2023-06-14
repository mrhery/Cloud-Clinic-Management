-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2023 at 05:12 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cclinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `a_id` int(11) NOT NULL,
  `a_ukey` varchar(255) NOT NULL,
  `a_customer` int(11) NOT NULL,
  `a_clinic` int(11) NOT NULL,
  `a_date` varchar(100) NOT NULL,
  `a_time` int(15) NOT NULL,
  `a_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `appointment_status`
--

CREATE TABLE `appointment_status` (
  `as_id` int(11) NOT NULL,
  `as_appointment` int(11) NOT NULL,
  `as_status` int(11) NOT NULL,
  `as_message` varchar(1000) NOT NULL,
  `as_date` varchar(100) NOT NULL,
  `as_time` int(15) NOT NULL,
  `as_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `clinic`
--

CREATE TABLE `clinic` (
  `c_id` int(11) NOT NULL,
  `c_ukey` varchar(255) NOT NULL,
  `c_name` varchar(255) NOT NULL,
  `c_address` text NOT NULL,
  `c_phone` varchar(50) NOT NULL,
  `c_email` varchar(255) NOT NULL,
  `c_regno` varchar(100) NOT NULL,
  `c_logo` varchar(255) NOT NULL,
  `c_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `clinic_customer`
--

CREATE TABLE `clinic_customer` (
  `cc_id` int(11) NOT NULL,
  `cc_clinic` int(11) NOT NULL,
  `cc_customer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `clinic_user`
--

CREATE TABLE `clinic_user` (
  `cu_id` int(11) NOT NULL,
  `cu_clinic` int(11) NOT NULL,
  `cu_user` int(11) NOT NULL,
  `cu_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(255) NOT NULL,
  `c_ic` varchar(25) NOT NULL,
  `c_phone` varchar(50) NOT NULL,
  `c_email` varchar(100) NOT NULL,
  `c_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `customer_record`
--

CREATE TABLE `customer_record` (
  `cr_id` int(11) NOT NULL,
  `cr_customer` int(11) NOT NULL,
  `cr_clinic` int(11) NOT NULL,
  `cr_user` int(11) NOT NULL,
  `cr_date` varchar(50) NOT NULL,
  `cr_time` int(15) NOT NULL,
  `cr_title` varchar(500) NOT NULL,
  `cr_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `d_id` int(11) NOT NULL,
  `d_name` varchar(100) NOT NULL,
  `d_code` varchar(100) NOT NULL,
  `d_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `m_id` int(11) NOT NULL,
  `m_main` int(11) NOT NULL,
  `m_sort` int(11) NOT NULL,
  `m_name` varchar(100) NOT NULL,
  `m_url` varchar(255) NOT NULL,
  `m_route` varchar(255) NOT NULL,
  `m_status` int(11) NOT NULL,
  `m_description` varchar(255) NOT NULL,
  `m_short` varchar(3) NOT NULL,
  `m_icon` varchar(255) NOT NULL,
  `m_role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`m_id`, `m_main`, `m_sort`, `m_name`, `m_url`, `m_route`, `m_status`, `m_description`, `m_short`, `m_icon`, `m_role`) VALUES
(8, 0, 5, 'Staffs', 'pengguna', 'pengguna', 1, 'Manage staff informations', '', 'typcn typcn-user-outline', '0,6'),
(9, 0, 100, 'Settings', 'settings', 'settings', 1, 'All System Settings', '', 'typcn typcn-cog-outline', '0,1,2'),
(10, 9, 1, 'Menus', 'menus', 'menus', 1, 'Manage System Menus', 'MNU', '', '0,1,2'),
(21, 9, 1, 'Rol Pengguna', 'rols', 'rols', 1, 'Senarai Rol Pengguna', 'ROL', 'typcn typcn-th-large', '0,1,2'),
(23, 9, 1, 'Jabatan', 'jabatan', 'jabatan', 1, 'Data-data Jabatan', 'JAB', '', '0,1,2'),
(24, 0, 1, 'Dashboard', 'dashboard', 'dashboard', 1, 'Review your business performance interactively', '', 'fa fa-dashboard', '0,6'),
(25, 0, 4, 'Customers', 'customers', 'customers', 1, 'Manage all your customer\'s information', '', 'fa fa-users', '0,6'),
(26, 0, 2, 'Appointments', 'appointments', 'appointments', 1, 'Manage all appointments in your clinic', '', 'fa fa-calendar', '0,6'),
(27, 0, 3, 'Medical Records', 'medical-record', 'medical-record', 1, 'All available medical record base on customer information', '', 'fa fa-plus', '0,6'),
(28, 0, 6, 'Clinic', 'Clinic', 'Clinic', 1, 'Manage you clinic information', '', 'fa fa-building', '0,6,8');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `r_id` int(11) NOT NULL,
  `r_name` varchar(100) NOT NULL,
  `r_menu` varchar(100) NOT NULL,
  `r_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`r_id`, `r_name`, `r_menu`, `r_status`) VALUES
(0, 'Admin', '', 1),
(6, 'Users', '', 1),
(7, 'Customers', '', 1),
(8, 'Doctor', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `u_name` varchar(255) NOT NULL,
  `u_email` varchar(255) NOT NULL,
  `u_password` varchar(255) NOT NULL,
  `u_key` varchar(255) NOT NULL,
  `u_full_name` varchar(255) NOT NULL,
  `u_ic` varchar(255) NOT NULL,
  `u_alamat` varchar(255) NOT NULL,
  `u_area` varchar(255) NOT NULL,
  `u_phone` varchar(255) NOT NULL,
  `u_admin` int(11) NOT NULL DEFAULT 0,
  `u_role` int(11) NOT NULL,
  `u_department` int(11) NOT NULL,
  `u_postcode` varchar(255) NOT NULL,
  `u_country` varchar(255) NOT NULL,
  `u_state` varchar(255) NOT NULL,
  `u_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `u_name`, `u_email`, `u_password`, `u_key`, `u_full_name`, `u_ic`, `u_alamat`, `u_area`, `u_phone`, `u_admin`, `u_role`, `u_department`, `u_postcode`, `u_country`, `u_state`, `u_picture`) VALUES
(1, 'hery', 'admin@admin', 'cda8206eb90ff0ff143e5ee404d980102b37b7de52774b414bca3cc69d2ef6e3', '', 'Ahmad Khairi Aiman', '121212121212', '0402 Jalan Pendidikan 3, Taman Universiti', '', '018-782 4900', 1, 0, 1, '', '', '', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `appointment_status`
--
ALTER TABLE `appointment_status`
  ADD PRIMARY KEY (`as_id`);

--
-- Indexes for table `clinic`
--
ALTER TABLE `clinic`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `clinic_customer`
--
ALTER TABLE `clinic_customer`
  ADD PRIMARY KEY (`cc_id`);

--
-- Indexes for table `clinic_user`
--
ALTER TABLE `clinic_user`
  ADD PRIMARY KEY (`cu_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `customer_record`
--
ALTER TABLE `customer_record`
  ADD PRIMARY KEY (`cr_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointment_status`
--
ALTER TABLE `appointment_status`
  MODIFY `as_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clinic`
--
ALTER TABLE `clinic`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clinic_customer`
--
ALTER TABLE `clinic_customer`
  MODIFY `cc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clinic_user`
--
ALTER TABLE `clinic_user`
  MODIFY `cu_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_record`
--
ALTER TABLE `customer_record`
  MODIFY `cr_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
