-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2022 at 09:12 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spg`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `a_id` int(11) NOT NULL,
  `a_type` varchar(100) NOT NULL,
  `a_user` int(11) NOT NULL,
  `a_date` date NOT NULL,
  `a_time` int(15) NOT NULL,
  `a_status` int(11) NOT NULL,
  `a_for` int(11) NOT NULL,
  `a_key` varchar(255) NOT NULL,
  `a_shop` int(11) NOT NULL,
  `a_name` varchar(255) NOT NULL,
  `a_email` varchar(255) NOT NULL,
  `a_ic` varchar(15) NOT NULL,
  `a_alamat` varchar(255) NOT NULL,
  `a_phone` varchar(255) NOT NULL,
  `a_gambar` varchar(255) NOT NULL,
  `a_ssm` text NOT NULL,
  `a_mp` text NOT NULL,
  `a_files` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`a_id`, `a_type`, `a_user`, `a_date`, `a_time`, `a_status`, `a_for`, `a_key`, `a_shop`, `a_name`, `a_email`, `a_ic`, `a_alamat`, `a_phone`, `a_gambar`, `a_ssm`, `a_mp`, `a_files`) VALUES
(15, '', 0, '2022-07-14', 1657785389, 0, 0, '6241d63f3790a', 5, 'qwewgew', 'deathreaper754@gmail.com', 'qweasd', 'Jalan Ayu 27', '444453', '', '', '', ''),
(17, '', 0, '2022-07-14', 1657785444, 0, 0, '6242da9c73013', 5, 'ok nice dah tukar', 'test@test', '11111111', 'rererere', '121212121', '', '', '', ''),
(19, '', 0, '2022-07-14', 1657785402, 0, 0, '62b34802e31c1', 7, 'testorangawam', 'oa@gmail.com', '9393939393939', 'australia', '343434343434', '', '', 'test3', 'apexlegemnnewpass.txt, arablesson.txt'),
(20, '', 0, '2022-07-14', 1657785644, 0, 0, '62cf5c977cb33', 7, 'Razali Amin', 'amin@gmail.com', '9393939393939', 'Jalan Ayu 27', '55555555', '', '', 'testetst', '');

-- --------------------------------------------------------

--
-- Table structure for table `application_status`
--

CREATE TABLE `application_status` (
  `as_id` int(11) NOT NULL,
  `as_application` int(11) NOT NULL,
  `as_status` int(11) NOT NULL,
  `as_user` int(11) NOT NULL,
  `as_date` date NOT NULL,
  `as_time` int(15) NOT NULL,
  `as_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `application_status`
--

INSERT INTO `application_status` (`as_id`, `as_application`, `as_status`, `as_user`, `as_date`, `as_time`, `as_description`) VALUES
(1, 15, 0, 1, '2022-07-14', 1657785387, 'masih disemak'),
(2, 0, 0, 1, '2022-07-18', 1658135735, ''),
(3, 19, 1, 1, '2022-07-14', 1657785401, 'lulus mat'),
(4, 20, 3, 1, '2022-07-14', 1657785641, 'sila semak dokuman');

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `c_id` int(11) NOT NULL,
  `c_shop` int(11) NOT NULL,
  `c_tenant` int(11) NOT NULL COMMENT 'pemohon',
  `c_pic` int(11) NOT NULL COMMENT 'pelulus',
  `c_council` int(11) NOT NULL COMMENT 'ahli majlis',
  `c_period` int(11) NOT NULL COMMENT 'tempoh kontrak(bulan)',
  `c_price` double NOT NULL COMMENT 'nilai sewa',
  `c_deposit` double NOT NULL COMMENT 'cagaran',
  `c_shopType` int(11) NOT NULL COMMENT 'jenis gerai',
  `c_key` varchar(100) NOT NULL,
  `c_refer` varchar(255) NOT NULL,
  `c_fail` varchar(255) NOT NULL,
  `c_main` int(11) NOT NULL COMMENT 'id asal',
  `c_after` int(11) NOT NULL COMMENT 'id baru',
  `c_updateBy` int(11) NOT NULL COMMENT 'id user',
  `c_dateStart` date NOT NULL,
  `c_dateEnd` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`c_id`, `c_shop`, `c_tenant`, `c_pic`, `c_council`, `c_period`, `c_price`, `c_deposit`, `c_shopType`, `c_key`, `c_refer`, `c_fail`, `c_main`, `c_after`, `c_updateBy`, `c_dateStart`, `c_dateEnd`) VALUES
(1, 5, 1, 6, 6, 4, 30000, 5000, 1, 'CONTRACT_61e462d13b63f', 'C12345', 'Fail 1', 1, 0, 0, '2022-06-26', '2023-06-26'),
(2, 5, 1, 6, 6, 4, 30000, 5000, 1, 'CONTRACT_62d5d32ebab11', 'C12345', 'Fail 1', 1, 2, 1, '2022-06-26', '2023-06-26'),
(3, 5, 1, 6, 6, 4, 30000, 5000, 1, 'CONTRACT_62d5d35168370', 'C12345', 'Fail 1', 2, 3, 1, '2022-06-26', '2023-06-26');

-- --------------------------------------------------------

--
-- Table structure for table `contracts_status`
--

CREATE TABLE `contracts_status` (
  `cs_id` int(11) NOT NULL,
  `cs_contracts` int(11) NOT NULL,
  `cs_status` int(11) NOT NULL,
  `cs_user` int(11) NOT NULL,
  `cs_date` date NOT NULL,
  `cs_time` int(11) NOT NULL,
  `cs_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contracts_status`
--

INSERT INTO `contracts_status` (`cs_id`, `cs_contracts`, `cs_status`, `cs_user`, `cs_date`, `cs_time`, `cs_description`) VALUES
(1, 1, 0, 1, '2022-07-18', 1658209198, '-'),
(2, 2, 0, 1, '2022-07-18', 1658209233, '-');

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

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`d_id`, `d_name`, `d_code`, `d_status`) VALUES
(1, 'Perlesenan', 'LESEN', 1),
(2, 'Ahli Majlis', 'MAJLIS', 1),
(3, 'Orang Awam', 'AWAM', 1),
(7, 'Test', 'TEST', 1);

-- --------------------------------------------------------

--
-- Table structure for table `help`
--

CREATE TABLE `help` (
  `h_id` int(11) NOT NULL,
  `h_name` varchar(255) NOT NULL,
  `h_email` varchar(255) NOT NULL,
  `h_subjek` text NOT NULL,
  `h_mesej` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `help`
--

INSERT INTO `help` (`h_id`, `h_name`, `h_email`, `h_subjek`, `h_mesej`) VALUES
(1, 'Naqiuddin Sani', 'deathreaper754@gmail.com', 'test', 'testmesej');

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
(1, 0, 1, 'Dashboards', 'dashboards', 'dashboards', 1, 'Paparan data mengikut peta kawasan', '', 'typcn typcn-chart-bar', '0,1,2'),
(2, 1, 1, 'Geografik', 'dashboard-geo', 'dashboard-geo', 1, '', 'GEO', '', '0,1,2'),
(3, 1, 2, 'Statistik', 'dashboard-statistik', 'dashboard-statistik', 1, '', 'STK', '', '0,1,2'),
(4, 1, 3, 'Laporan', 'dashboard-laporan', 'dashboard-laporan', 1, '', 'LPN', '', '0,1,2'),
(5, 0, 2, 'Data Gerai', 'gerai', 'gerai', 1, 'Pengurusan Data Gerai', 'GER', 'typcn typcn-business-card', '0,1,2'),
(6, 0, 4, 'Sewaan', 'sewaan', 'sewaan', 1, 'Maklumat Sewaan Gerai Bulanan', '', 'typcn typcn-th-small-outline', '0,1,2'),
(7, 13, 3, 'Gerai', 'gerai', 'gerai', 1, 'Senarai Maklumat Pemohon & Permohonan', 'GER', 'typcn typcn-th-large', '0,1,2'),
(8, 0, 5, 'Pengguna', 'pengguna', 'pengguna', 1, 'Senarai Pengguna Dalaman & Luaran', '', 'typcn typcn-user-outline', '0,1,2'),
(9, 0, 100, 'Settings', 'settings', 'settings', 1, 'All System Settings', '', 'typcn typcn-cog-outline', '0,1,2'),
(10, 9, 1, 'Menus', 'menus', 'menus', 1, 'Manage System Menus', 'MNU', '', '0,1,2'),
(11, 5, 2, 'Gerai', 'gerai', 'gerai', 1, 'Pengurusan Data Gerai', 'GRI', '', '0,1,2'),
(12, 5, 2, 'Kawasan', 'kawasan-perniagaan', 'kawasan-perniagaan', 1, 'Pengurusan Data Gerai', 'GRI', '', '0,1,2'),
(13, 0, 3, 'Permohonan', 'permohonan', 'permohonan', 1, 'Bahagian Permohonan', 'PER', 'typcn typcn-th-large', '0,1,2'),
(14, 13, 3, 'Pembaharuan', 'pembaharuan', 'pembaharuan', 1, 'Pembaharuan Kontrak Sewa Gerai', 'BAH', 'typcn typcn-th-large', '0,1,2'),
(15, 13, 3, 'Wang Cagaran', 'cagaran', 'cagaran', 1, 'Permohonan Wang Cagaran', 'WCG', 'typcn typcn-th-large', '0,1,2'),
(16, 13, 3, 'Pindah Milik', 'pindah-milik', 'pindah-milik', 1, 'Permohonan Pindah Milik', 'MLK', 'typcn typcn-th-large', '0,1,2'),
(21, 9, 1, 'Rol Pengguna', 'rols', 'rols', 1, 'Senarai Rol Pengguna', 'ROL', 'typcn typcn-th-large', '0,1,2'),
(23, 9, 1, 'Jabatan', 'jabatan', 'jabatan', 1, 'Data-data Jabatan', 'JAB', '', '0,1,2');

-- --------------------------------------------------------

--
-- Table structure for table `rentals`
--

CREATE TABLE `rentals` (
  `r_id` int(11) NOT NULL,
  `r_shop` int(11) NOT NULL,
  `r_tenant` int(11) NOT NULL,
  `r_month` varchar(50) NOT NULL,
  `r_year` int(11) NOT NULL,
  `r_amount` double NOT NULL,
  `r_time` int(11) NOT NULL,
  `r_user` int(11) NOT NULL,
  `r_status` int(11) NOT NULL,
  `r_name` varchar(255) NOT NULL,
  `r_address` text NOT NULL,
  `r_phone` varchar(100) NOT NULL,
  `r_email` varchar(255) NOT NULL,
  `r_ic` int(11) NOT NULL,
  `r_no` varchar(100) NOT NULL,
  `r_key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rentals`
--

INSERT INTO `rentals` (`r_id`, `r_shop`, `r_tenant`, `r_month`, `r_year`, `r_amount`, `r_time`, `r_user`, `r_status`, `r_name`, `r_address`, `r_phone`, `r_email`, `r_ic`, `r_no`, `r_key`) VALUES
(11, 5, 0, 'July', 2022, 3333, 1657812751, 0, 0, 'hery', '0402 Jalan Pendidikan 3, Taman Universiti', '222222', 'admin@admin', 2147483647, 'test', 'R_62cfc68f29156'),
(12, 7, 0, 'July', 2022, 4555, 1657812866, 0, 0, 'test', 'rererere', '121212121', 'staff@ret', 11111111, 'test', 'R_62cfc702838a3'),
(14, 9, 0, 'July', 2022, 56565656, 1657814602, 0, 0, 'testorangawam', 'australia', '343434343434', 'oa@gmail.com', 2147483647, 'test', 'R_62cfcdca711b9');

-- --------------------------------------------------------

--
-- Table structure for table `request_deposits`
--

CREATE TABLE `request_deposits` (
  `rd_id` int(11) NOT NULL,
  `rd_contract` int(11) NOT NULL,
  `rd_tenant` int(11) NOT NULL,
  `rd_date` date NOT NULL,
  `rd_time` int(15) NOT NULL,
  `rd_status` int(11) NOT NULL,
  `rd_updateBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `request_deposit_logs`
--

CREATE TABLE `request_deposit_logs` (
  `rdl_id` int(11) NOT NULL,
  `rdl_request` int(11) NOT NULL,
  `rdl_user` int(11) NOT NULL,
  `rdl_status` int(11) NOT NULL,
  `rdl_message` text NOT NULL,
  `rdl_time` int(15) NOT NULL,
  `rdl_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 'Ketua Jabatan', '', 1),
(2, 'Staff', '', 1),
(3, 'Ahli Majlis', '', 1),
(4, 'Orang Awam', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `s_id` int(11) NOT NULL,
  `s_refno` varchar(255) NOT NULL,
  `s_lotno` varchar(255) NOT NULL,
  `s_hsd` varchar(255) NOT NULL,
  `s_fileno` varchar(255) NOT NULL,
  `s_ref1` varchar(255) NOT NULL,
  `s_ref2` varchar(255) NOT NULL,
  `s_level` varchar(100) NOT NULL,
  `s_lot` varchar(100) NOT NULL,
  `s_road` varchar(100) NOT NULL,
  `s_residential` varchar(255) NOT NULL,
  `s_area` varchar(255) NOT NULL,
  `s_state` varchar(255) NOT NULL,
  `s_postcode` int(11) NOT NULL,
  `s_country` varchar(100) NOT NULL,
  `s_date` date NOT NULL,
  `s_time` int(15) NOT NULL,
  `s_status` int(11) NOT NULL,
  `s_longitude` varchar(100) NOT NULL,
  `s_latitude` varchar(100) NOT NULL,
  `s_key` varchar(255) NOT NULL,
  `s_owner` int(11) NOT NULL,
  `s_price` double NOT NULL,
  `s_block` varchar(100) NOT NULL,
  `s_group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`s_id`, `s_refno`, `s_lotno`, `s_hsd`, `s_fileno`, `s_ref1`, `s_ref2`, `s_level`, `s_lot`, `s_road`, `s_residential`, `s_area`, `s_state`, `s_postcode`, `s_country`, `s_date`, `s_time`, `s_status`, `s_longitude`, `s_latitude`, `s_key`, `s_owner`, `s_price`, `s_block`, `s_group`) VALUES
(5, 'C12345', '123', '', 'Fail 1', '', '', '02', '04', 'Jalan Pendidikan 3', 'Taman Universiti', 'Skudai', 'Johor', 81300, '', '0000-00-00', 0, 1, '100.410465570366', '5.366643538146448', 'SHOP_61e462d13b63f', 0, 500, '1', 32),
(7, '', '321', '', 'Fail 2', '', '', '03', '03', 'Jalan Mustafa 3', 'Taman C++', 'Ulu Tiram', 'Johor', 81800, 'Malaysia', '0000-00-00', 0, 1, '3.3231999999989057', '90', '', 0, 0, '33', 45),
(9, 'c334', '56', '', 'fail 3', '', '', '04', '04', 'Jalan Tun Hussein', 'Taman Misbun Sidek', 'Pasir Gudang', 'Johor', 81233, 'Malaysia', '2022-07-14', 33, 1, '100.410465570366', '5.366643538146448', 'SHOP_61e462d15656f', 0, 900, '12', 48);

-- --------------------------------------------------------

--
-- Table structure for table `shop_group`
--

CREATE TABLE `shop_group` (
  `sg_id` int(11) NOT NULL,
  `sg_name` varchar(255) NOT NULL,
  `sg_description` text NOT NULL,
  `sg_main` int(11) NOT NULL,
  `sg_lat` varchar(50) NOT NULL,
  `sg_lng` varchar(50) NOT NULL,
  `sg_status` int(11) NOT NULL,
  `sg_note` text NOT NULL,
  `sg_key` varchar(100) NOT NULL,
  `sg_address` text NOT NULL,
  `sg_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shop_group`
--

INSERT INTO `shop_group` (`sg_id`, `sg_name`, `sg_description`, `sg_main`, `sg_lat`, `sg_lng`, `sg_status`, `sg_note`, `sg_key`, `sg_address`, `sg_picture`) VALUES
(32, 'asdasd', '', 0, '5.372112598856274', '100.58350023833478', 1, '', 'SG_61e2f4455d3a8', 'asdasdasd', 'abcd.jpg'),
(33, 'aasdasd', '', 1, '5.366643538146448', '100.410465570366', 1, '', 'SG_61e2f4617315f', 'asdasdasd', ''),
(34, 'asdasdasd', '', 1, '5.366643538146448', '100.410465570366', 1, '', 'SG_61e2f4f759c73', 'asdasdasd', ''),
(35, 'asdasdada', '', 1, '5.366643538146448', '100.410465570366', 1, '', 'SG_61e2f50d2eb85', 'dasdasdasd', ''),
(36, 'asdasd', '', 0, '5.381683336944906', '100.2442973574754', 1, '', 'SG_61e2f51b2bb9d', 'asdadasd', ''),
(37, 'asdasd', '', 1, '5.366643538146448', '100.410465570366', 1, '', 'SG_61e2f533b5f68', 'adadasdads', ''),
(38, 'asdasd', '', 1, '5.366643538146448', '100.410465570366', 1, '', 'SG_61e2f55120a0d', 'aasdasdad', ''),
(39, 'adasda', '', 1, '5.366643538146448', '100.410465570366', 1, '', 'SG_61e2f56c4d2ff', 'asdasdsad', ''),
(40, 'asdasda', '', 1, '5.366643538146448', '100.410465570366', 1, '', 'SG_61e2f618b0453', 'dasda', ''),
(41, 'asdada', '', 1, '5.366643538146448', '100.410465570366', 1, '', 'SG_61e2f7b00bed5', 'dasdasdasd', ''),
(42, 'asdasdasd', '', 1, '5.366643538146448', '100.410465570366', 1, '', 'SG_61e2f80d231b9', 'asdasdasd', ''),
(43, 'asdasd', '', 1, '5.366643538146448', '100.410465570366', 1, '', 'SG_61e2f821e1a11', 'asdadasdasd', ''),
(44, 'asdasd', '', 1, '5.366643538146448', '100.410465570366', 1, '', 'SG_61e2f8392ecbc', 'asdadsasadsasd', ''),
(45, 'asdasd', '', 1, '5.366643538146448', '100.410465570366', 1, '', 'SG_61e2f8435c2ef', 'asdadsasadsasd', ''),
(46, 'asdasd', '', 1, '5.366643538146448', '100.410465570366', 1, '', 'SG_61e2f8451ebdd', 'asdadsasadsasd', ''),
(47, 'asdasd', '', 1, '5.366643538146448', '100.410465570366', 1, '', 'SG_61e2f8464a42c', 'asdadsasadsasd', ''),
(48, 'asdasd', '', 1, '5.366643538146448', '100.410465570366', 1, '', 'SG_61e2f8472e43e', 'asdadsasadsasd', '');

-- --------------------------------------------------------

--
-- Table structure for table `shop_user`
--

CREATE TABLE `shop_user` (
  `su_id` int(11) NOT NULL,
  `su_shop` int(11) NOT NULL,
  `su_user` int(11) NOT NULL,
  `su_date` date NOT NULL,
  `su_time` int(15) NOT NULL,
  `su_status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shop_user`
--

INSERT INTO `shop_user` (`su_id`, `su_shop`, `su_user`, `su_date`, `su_time`, `su_status`) VALUES
(2, 7, 11, '2022-06-25', 1655945346, '1'),
(3, 5, 5, '2022-06-25', 1655945346, '1');

-- --------------------------------------------------------

--
-- Table structure for table `transfer_requests`
--

CREATE TABLE `transfer_requests` (
  `tr_id` int(11) NOT NULL,
  `tr_contract` int(11) NOT NULL,
  `tr_cagaran` int(11) NOT NULL DEFAULT 0,
  `tr_sender` int(11) NOT NULL,
  `tr_rcpt` int(11) NOT NULL,
  `tr_date` varchar(100) NOT NULL,
  `tr_time` int(15) NOT NULL,
  `tr_status` int(11) NOT NULL,
  `tr_staff` int(11) NOT NULL,
  `tr_notes` text NOT NULL,
  `tr_approved_by` int(11) DEFAULT NULL,
  `tr_approved_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transfer_requests`
--

INSERT INTO `transfer_requests` (`tr_id`, `tr_contract`, `tr_cagaran`, `tr_sender`, `tr_rcpt`, `tr_date`, `tr_time`, `tr_status`, `tr_staff`, `tr_notes`, `tr_approved_by`, `tr_approved_date`) VALUES
(1, 1, 0, 1, 3, '2022-07-16 03:07:21', 1658015601, 0, 1, '', NULL, NULL),
(2, 1, 1, 1, 11, '2022-07-16 03:07:29', 1658015609, 0, 1, '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transfer_request_logs`
--

CREATE TABLE `transfer_request_logs` (
  `trl_id` int(11) NOT NULL,
  `trl_request` int(11) DEFAULT NULL,
  `trl_user` int(11) DEFAULT NULL,
  `trl_status` int(11) DEFAULT NULL,
  `trl_message` text DEFAULT NULL,
  `trl_date` varchar(100) DEFAULT NULL,
  `trl_time` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transfer_request_logs`
--

INSERT INTO `transfer_request_logs` (`trl_id`, `trl_request`, `trl_user`, `trl_status`, `trl_message`, `trl_date`, `trl_time`) VALUES
(1, 1, 1, 0, 'Initial Request', '2022-07-16 03:07:34', 1658015194),
(2, 1, 1, 0, 'Initial Request', '2022-07-16 03:07:43', 1658015203),
(3, 1, 1, 0, 'Initial Request', '2022-07-16 03:07:58', 1658015218),
(4, 1, 1, 0, 'Initial Request', '2022-07-16 03:07:06', 1658015406),
(5, 1, 1, 0, 'Initial Request', '2022-07-16 03:07:17', 1658015417),
(6, 1, 1, 0, 'Initial Request', '2022-07-16 03:07:35', 1658015495),
(7, 1, 1, 0, 'Initial Request', '2022-07-16 03:07:21', 1658015601),
(8, 1, 1, 0, 'Initial Request', '2022-07-16 03:07:29', 1658015609);

-- --------------------------------------------------------

--
-- Table structure for table `tutorial_video`
--

CREATE TABLE `tutorial_video` (
  `tv_id` int(15) NOT NULL,
  `tv_title` varchar(255) NOT NULL,
  `tv_desc` varchar(255) NOT NULL,
  `tv_thumbnail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tutorial_video`
--

INSERT INTO `tutorial_video` (`tv_id`, `tv_title`, `tv_desc`, `tv_thumbnail`) VALUES
(14, 'TESTT111', '62d4de1377731vidx001.mp4', '62d4de137756eggww.png'),
(15, 'nAQI vID', '62d4de879c41eMADNOR.mp4', '62d4de879c26dpassstest.jpg');

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
(1, 'hery', 'admin@admin', 'cda8206eb90ff0ff143e5ee404d980102b37b7de52774b414bca3cc69d2ef6e3', '', 'Ahmad Khairi Aiman', '121212121212', '0402 Jalan Pendidikan 3, Taman Universiti', '', '018-782 4900', 1, 0, 1, '', '', '', '0'),
(3, 'test', 'staff', 'cda8206eb90ff0ff143e5ee404d980102b37b7de52774b414bca3cc69d2ef6e3', '', 'testtest', '11111111', 'rererere', '', '121212121', 0, 2, 1, '', '', '', '0'),
(4, 'ketuajabatan', 'ketua@ketua', 'cda8206eb90ff0ff143e5ee404d980102b37b7de52774b414bca3cc69d2ef6e3', '', '', '', '', '', '', 0, 1, 1, '', '', '', '0'),
(5, 'orangawam', 'awam@awam', 'cda8206eb90ff0ff143e5ee404d980102b37b7de52774b414bca3cc69d2ef6e3', '', '', '', '', '', '', 0, 4, 3, '', '', '', '0'),
(6, 'ahlimajlis', 'ahlimajlis@am', 'cda8206eb90ff0ff143e5ee404d980102b37b7de52774b414bca3cc69d2ef6e3', '', 'Ahli Majlis', '', 'Johor', '', '0123456789', 0, 3, 2, '', '', '', '0'),
(11, 'testorangawam', 'oa@gmail.com', '1234', '', 'orangawamtest', '9393939393939', 'australia', 'nepal', '343434343434', 0, 4, 3, '34343', 'Bangladesh', 'sri lanka', 'ayam');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `application_status`
--
ALTER TABLE `application_status`
  ADD PRIMARY KEY (`as_id`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `contracts_status`
--
ALTER TABLE `contracts_status`
  ADD PRIMARY KEY (`cs_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `help`
--
ALTER TABLE `help`
  ADD PRIMARY KEY (`h_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `request_deposits`
--
ALTER TABLE `request_deposits`
  ADD PRIMARY KEY (`rd_id`);

--
-- Indexes for table `request_deposit_logs`
--
ALTER TABLE `request_deposit_logs`
  ADD PRIMARY KEY (`rdl_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `shop_group`
--
ALTER TABLE `shop_group`
  ADD PRIMARY KEY (`sg_id`);

--
-- Indexes for table `shop_user`
--
ALTER TABLE `shop_user`
  ADD PRIMARY KEY (`su_id`);

--
-- Indexes for table `transfer_requests`
--
ALTER TABLE `transfer_requests`
  ADD PRIMARY KEY (`tr_id`);

--
-- Indexes for table `transfer_request_logs`
--
ALTER TABLE `transfer_request_logs`
  ADD PRIMARY KEY (`trl_id`);

--
-- Indexes for table `tutorial_video`
--
ALTER TABLE `tutorial_video`
  ADD PRIMARY KEY (`tv_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `application_status`
--
ALTER TABLE `application_status`
  MODIFY `as_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contracts_status`
--
ALTER TABLE `contracts_status`
  MODIFY `cs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `help`
--
ALTER TABLE `help`
  MODIFY `h_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `rentals`
--
ALTER TABLE `rentals`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `request_deposits`
--
ALTER TABLE `request_deposits`
  MODIFY `rd_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_deposit_logs`
--
ALTER TABLE `request_deposit_logs`
  MODIFY `rdl_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `shop_group`
--
ALTER TABLE `shop_group`
  MODIFY `sg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `shop_user`
--
ALTER TABLE `shop_user`
  MODIFY `su_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transfer_requests`
--
ALTER TABLE `transfer_requests`
  MODIFY `tr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transfer_request_logs`
--
ALTER TABLE `transfer_request_logs`
  MODIFY `trl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tutorial_video`
--
ALTER TABLE `tutorial_video`
  MODIFY `tv_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
