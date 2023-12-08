-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2023 at 12:00 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

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
  `a_status` int(11) NOT NULL,
  `a_reason` varchar(500) NOT NULL,
  `a_user` int(11) NOT NULL,
  `a_createdDate` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`a_id`, `a_ukey`, `a_customer`, `a_clinic`, `a_date`, `a_time`, `a_status`, `a_reason`, `a_user`, `a_createdDate`) VALUES
(1, 'asd', 1, 1, '08-Dec-2023', 1686840540, 1, 'Covid Test asd', 0, ''),
(2, 'asdasdasd asd as', 1, 1, '08-Dec-2023', 1686926940, 0, 'Astma', 0, ''),
(3, '9133b951587bbfe9a16a667e07874b1af4725856f5e7e2eaa1c7c5ae1016400c', 2, 1, '08-Dec-2023', 1686843660, 1, 'adasd', 0, ''),
(4, '3b8a98eb98cabad62395b9b925bfc732bde4470799f2b25c653a180c9ee375e3', 2, 1, '08-Dec-2023', 1687621320, 0, 'fever', 0, ''),
(5, 'abd52a45f32b896ae36d80e191a01d97cca9b546dcca5fbd92b9b493d75783e0', 3, 1, '08-Dec-2023', 1687448580, 0, 'sdfsdfsdf', 0, ''),
(6, '2c9688e4bf270ab7b2b950ec0fec26b4e54776dccaad5f1bb892c55fa0e75a40', 1, 1, '08-Dec-2023', 1692376980, 1, 'demam', 1, '17-Aug-2023');

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

--
-- Dumping data for table `appointment_status`
--

INSERT INTO `appointment_status` (`as_id`, `as_appointment`, `as_status`, `as_message`, `as_date`, `as_time`, `as_user`) VALUES
(1, 2, 0, 'teting', '16-Jun-2023', 1686902672, 1),
(2, 6, 1, '', '17-Aug-2023', 1692290628, 1);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(255) NOT NULL,
  `c_regno` varchar(255) NOT NULL,
  `c_address` varchar(255) NOT NULL,
  `c_phone` varchar(100) NOT NULL,
  `c_email` varchar(100) NOT NULL,
  `c_is_personal` int(11) NOT NULL,
  `c_clinic` int(11) NOT NULL,
  `c_date` varchar(100) NOT NULL,
  `c_time` int(15) NOT NULL,
  `c_user` int(11) NOT NULL,
  `c_key` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`c_id`, `c_name`, `c_regno`, `c_address`, `c_phone`, `c_email`, `c_is_personal`, `c_clinic`, `c_date`, `c_time`, `c_user`, `c_key`) VALUES
(1, 'Intellingent Mental Arithmetic Sdn Bhd', 'IMA-1234', 'No 23A Jalan Kebudayaan 16, Taman Universiti, 81300 Johor Bahru, Johor', '+607-521 1178', '', 0, 1, '08-Dec-2023', 0, 1, 'client_001'),
(2, 'Intelligent Hosting Sdn Bhd', 'IH-1234', 'No 23A Jalan Kebudayaan 16, Taman Universiti, 81300 Johor Bahru, Johor', '+607-521 1178', '', 0, 1, '08-Dec-2023', 0, 1, 'client_002'),
(3, 'Hery Intelligent Technology', 'HIT-1234', 'No 0402 Jalan Pendidikan 3, Taman Universiti, 81300 Johor Bahru, Johor', '+6018-782 4900', '', 0, 1, '07-Dec-2023', 0, 1, 'client_003');

-- --------------------------------------------------------

--
-- Table structure for table `clinics`
--

CREATE TABLE `clinics` (
  `c_id` int(11) NOT NULL,
  `c_ukey` varchar(255) NOT NULL,
  `c_name` varchar(255) NOT NULL,
  `c_address` text NOT NULL,
  `c_phone` varchar(50) NOT NULL,
  `c_email` varchar(255) NOT NULL,
  `c_regno` varchar(100) NOT NULL,
  `c_logo` varchar(255) NOT NULL,
  `c_user` int(11) NOT NULL,
  `c_owner` int(11) NOT NULL,
  `c_disabled` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clinics`
--

INSERT INTO `clinics` (`c_id`, `c_ukey`, `c_name`, `c_address`, `c_phone`, `c_email`, `c_regno`, `c_logo`, `c_user`, `c_owner`, `c_disabled`) VALUES
(1, '2de99521fb8204da4b9e1497aff933fc062e7b8ead5933ec85a7ec973c26994f', 'Clinic Pergigian Intelhost', 'asdadad adsad sads', '0187824900', 'intelhost2u@gmail.com', 'JMxxxa', '', 1, 12, 0),
(2, '5554cf84b3b9d2e7326f1e5c9219a75d0bc84f8eb6b3f7fb1a0f874222ce45ff', 'Poliklinik Ahmed Taman Universiti', '', '', 'asdads@ads', '', '', 14, 14, 0),
(3, '060356720881168c5275c41f202c312cb793e3dfefa72d2400c88f8aa28abb3b', 'Poliklinik Ahmed Taman Tun Aminah', '', '234243243', 'zads@asdads', 'asdsd', '', 1, 14, 0);

-- --------------------------------------------------------

--
-- Table structure for table `clinic_customer`
--

CREATE TABLE `clinic_customer` (
  `cc_id` int(11) NOT NULL,
  `cc_clinic` int(11) NOT NULL,
  `cc_customer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clinic_customer`
--

INSERT INTO `clinic_customer` (`cc_id`, `cc_clinic`, `cc_customer`) VALUES
(1, 2, 5),
(2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `clinic_user`
--

CREATE TABLE `clinic_user` (
  `cu_id` int(11) NOT NULL,
  `cu_clinic` int(11) NOT NULL,
  `cu_user` int(11) NOT NULL,
  `cu_role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clinic_user`
--

INSERT INTO `clinic_user` (`cu_id`, `cu_clinic`, `cu_user`, `cu_role`) VALUES
(1, 1, 12, 'owner'),
(2, 1, 1, 'admin'),
(3, 1, 13, 'staff'),
(4, 2, 14, 'owner'),
(5, 2, 1, 'admin'),
(6, 3, 14, 'owner'),
(7, 3, 1, 'admin');

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
  `c_password` varchar(255) NOT NULL,
  `c_ukey` varchar(255) NOT NULL,
  `c_address` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`c_id`, `c_name`, `c_ic`, `c_phone`, `c_email`, `c_password`, `c_ukey`, `c_address`) VALUES
(1, 'Mr Hery', '1234567890', '1234567890', 'hery@herytechnology.com', '', 'abc123', ''),
(2, 'asdasd', '123123', '', '', '', '3426e93cb58b3fc5790f7e261109fc6b3098643a6f36d6ab2e52ba471923df51', ''),
(3, 'asdasdad', '12341234', '', '', '', '934297ece8454deba61f1211bda0c277a0d52bc168134cce15642e8991af4a9c', 'asdfasd'),
(5, 'dfsdfsfasd', '234234243234', '', '', '', 'e06cd9636663fdf8b0c8e86add805ff8360663065d6231f9b4652adec9c0423e', ' ');

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
  `cr_description` text NOT NULL,
  `cr_illness` text NOT NULL,
  `cr_examination` text NOT NULL,
  `cr_investigation` text NOT NULL,
  `cr_diagnosis` text NOT NULL,
  `cr_plan` text NOT NULL,
  `cr_key` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_record`
--

INSERT INTO `customer_record` (`cr_id`, `cr_customer`, `cr_clinic`, `cr_user`, `cr_date`, `cr_time`, `cr_title`, `cr_description`, `cr_illness`, `cr_examination`, `cr_investigation`, `cr_diagnosis`, `cr_plan`, `cr_key`) VALUES
(3, 5, 2, 14, '16-Jun-2023', 1686922942, 'hahahah', 'hthththth', '', '', '', '', '', 'addd'),
(10, 1, 1, 1, '16-Jul-2023', 1689503815, '', '', 'nut allergic', 'demam', 'lepas makan kambing', 'tekanan darah tinggi', 'kurang makan', 'doc-202307161-5EJ190'),
(11, 1, 1, 1, '19-Aug-2023', 1692435365, '', '', 'testing', 'asd', 'asd', 'asd', 'asd', 'doc-202308191-qKM112'),
(12, 1, 1, 1, '23-Aug-2023', 1692800937, '', '', '', '', '', '', '', 'doc-202308231-gwO407'),
(13, 1, 1, 1, '24-Aug-2023', 1692870962, '', '', '', '', '', '', '', 'doc-202308241-B4l438'),
(14, 1, 1, 1, '24-Aug-2023', 1692871199, '', '', '', '', '', '', '', 'doc-202308241-Q1f738'),
(15, 1, 1, 1, '24-Aug-2023', 1692871228, '', '', '', '', '', '', '', 'doc-202308241-jN4212'),
(16, 1, 1, 1, '24-Aug-2023', 1692871698, '', '', '', '', '', '', '', 'doc-202308241-9GI095'),
(17, 1, 1, 1, '24-Aug-2023', 1692872086, '', '', '', '', '', '', '', 'doc-202308241-5qY534'),
(18, 1, 1, 1, '24-Aug-2023', 1692872101, '', '', '', '', '', '', '', 'doc-202308241-nKx703'),
(19, 1, 1, 1, '24-Aug-2023', 1692872238, '', '', '', '', '', '', '', 'doc-202308241-Lya183'),
(20, 1, 1, 1, '16-Nov-2023', 1700140756, '', '', 'dfsdf', 'sdfsdf', 'sdfsdf', 'sdfsdf', 'sdfs', 'doc-202311161-exS168'),
(21, 1, 1, 1, '16-Nov-2023', 1700141811, '', '', 'test pdf hery', 'huhuhu', '', '', '', 'doc-202311161-6VN116'),
(22, 1, 1, 1, '16-Nov-2023', 1700141914, '', '', '', '', '', '', '', 'doc-202311161-EhG905'),
(23, 1, 1, 1, '16-Nov-2023', 1700141958, '', '', '', '', '', '', '', 'doc-202311161-5xF978'),
(24, 1, 1, 1, '16-Nov-2023', 1700142029, '', '', '', '', '', '', '', 'doc-202311161-6ok493'),
(25, 1, 1, 1, '16-Nov-2023', 1700143278, '', '', '', '', '', '', '', 'doc-202311161-OVZ700'),
(26, 1, 1, 1, '16-Nov-2023', 1700143368, '', '', '', '', '', '', '', 'doc-202311161-940646'),
(27, 1, 1, 1, '16-Nov-2023', 1700143389, '', '', '', '', '', '', '', 'doc-202311161-3kJ018');

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
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `i_id` int(11) NOT NULL,
  `i_name` varchar(255) NOT NULL,
  `i_description` text NOT NULL,
  `i_code` varchar(100) NOT NULL,
  `i_clinic` int(11) NOT NULL,
  `i_quantity` int(11) NOT NULL,
  `i_type` varchar(10) NOT NULL,
  `i_price` double NOT NULL,
  `i_key` varchar(255) NOT NULL,
  `i_user` int(11) NOT NULL,
  `i_sku` varchar(255) NOT NULL,
  `i_tag` varchar(255) NOT NULL,
  `i_cost` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`i_id`, `i_name`, `i_description`, `i_code`, `i_clinic`, `i_quantity`, `i_type`, `i_price`, `i_key`, `i_user`, `i_sku`, `i_tag`, `i_cost`) VALUES
(5, 'Panadol A', '', '', 1, 200, 'product', 0, 'item_6572eded67c1f', 1, '', '', 0.5);

-- --------------------------------------------------------

--
-- Table structure for table `item_inventory`
--

CREATE TABLE `item_inventory` (
  `ii_id` int(11) NOT NULL,
  `ii_item` int(11) NOT NULL,
  `ii_date` varchar(100) NOT NULL,
  `ii_time` int(15) NOT NULL,
  `ii_quantity` int(11) NOT NULL,
  `ii_description` varchar(255) NOT NULL,
  `ii_cost` double NOT NULL,
  `ii_user` int(11) NOT NULL,
  `ii_clinic` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item_inventory`
--

INSERT INTO `item_inventory` (`ii_id`, `ii_item`, `ii_date`, `ii_time`, `ii_quantity`, `ii_description`, `ii_cost`, `ii_user`, `ii_clinic`) VALUES
(6, 5, '08-Dec-2023', 1702052429, 200, 'Try beli', 0.5, 1, 1);

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
(8, 30, 5, 'Staffs', 'pengguna', 'pengguna', 1, 'Manage staff informations', 'STA', 'typcn typcn-user-outline', '1,2,4'),
(9, 0, 100, 'Settings', 'settings', 'settings', 1, 'All System Settings', '', 'typcn typcn-cog-outline', '1'),
(10, 9, 1, 'Menus', 'menus', 'menus', 1, 'Manage System Menus', 'MNU', '', '1'),
(21, 9, 1, 'USer Roles', 'rols', 'rols', 1, 'Senarai Rol Pengguna', 'ROL', 'typcn typcn-th-large', '1'),
(24, 0, 1, 'Dashboard', 'dashboard', 'dashboard', 1, 'Review your business performance interactively', '', 'fa fa-dashboard', '1,2,3,4'),
(25, 30, 4, 'Patients', 'customers', 'customers', 1, 'Manage all your customer\'s information', 'PAT', 'fa fa-users', '1,2,3,4'),
(26, 0, 2, 'Appointments', 'appointments', 'appointments', 1, 'Manage all appointments in your clinic', '', 'fa fa-calendar', '1,2,4'),
(27, 0, 3, 'Medical Records', 'medical-record', 'medical-record', 1, 'All available medical record base on customer information', '', 'fa fa-plus', '1,2,3,4'),
(28, 0, 6, 'Clinic', 'Clinic', 'Clinic', 1, 'Manage you clinic information', '', 'fa fa-building', '1,2,4'),
(29, 0, 8, 'Inventories', 'inventories', 'inventories', 1, 'Manage your clinic inventories', '', 'fa fa-cubes', '1,2,4'),
(30, 0, 3, 'Users', 'Users', 'Users', 1, '', '', 'fa fa-users', '1,3,4'),
(31, 0, 7, 'Billing', 'billing', 'billing', 1, '', '', 'fa fa-dollar', '1,2,4'),
(32, 31, 1, 'Point of Sale', 'pos-system', 'pos-system', 1, 'Point-of-Sale system for daily sales', 'POS', 'fa fa-money', '1,2,4'),
(33, 31, 2, 'Sales', 'sales', 'sales', 1, '', 'SAL', 'fa fa-area-chart', '1,2,4'),
(34, 31, 3, 'Purchasing', 'purchasing', 'purchasing', 1, 'Manage purchases of your clinic', 'PUR', 'fa fa-legal', '1,2,4'),
(35, 31, 1, 'Cash Flow', 'cash-flow', 'cash-flow', 1, 'Outlet cashflow', 'CFL', '', '1,2,4'),
(36, 31, 5, 'Clients', 'clients', 'clients', 1, 'Outlet clients records', 'CLN', '', '1,2,4');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `p_id` int(11) NOT NULL,
  `p_client` int(11) NOT NULL,
  `p_doc` varchar(100) NOT NULL,
  `p_date` varchar(100) NOT NULL,
  `p_time` int(15) NOT NULL,
  `p_key` varchar(100) NOT NULL,
  `p_clinic` int(11) NOT NULL,
  `p_user` int(11) NOT NULL,
  `p_paid` double NOT NULL,
  `p_total` double NOT NULL,
  `p_status` varchar(50) NOT NULL,
  `p_remark` varchar(255) DEFAULT NULL,
  `p_summary` varchar(500) DEFAULT NULL,
  `p_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`p_id`, `p_client`, `p_doc`, `p_date`, `p_time`, `p_key`, `p_clinic`, `p_user`, `p_paid`, `p_total`, `p_status`, `p_remark`, `p_summary`, `p_type`) VALUES
(5, 1, 'abc1234', '08-Dec-2023', 1702052429, 'purchase_6572eded5ca1f', 1, 1, 50, 100, 'partial', 'test pur', 'Panadol A x200<br />', 'invoice');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_item`
--

CREATE TABLE `purchase_item` (
  `pi_id` int(11) NOT NULL,
  `pi_purchase` int(11) NOT NULL,
  `pi_clinic` int(11) NOT NULL,
  `pi_item` int(11) NOT NULL,
  `pi_quantity` int(11) NOT NULL,
  `pi_cost` int(11) NOT NULL,
  `pi_total_cost` double NOT NULL,
  `pi_remark` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase_item`
--

INSERT INTO `purchase_item` (`pi_id`, `pi_purchase`, `pi_clinic`, `pi_item`, `pi_quantity`, `pi_cost`, `pi_total_cost`, `pi_remark`) VALUES
(5, 5, 1, 5, 200, 1, 100, 'Try beli');

-- --------------------------------------------------------

--
-- Table structure for table `record_file`
--

CREATE TABLE `record_file` (
  `rf_id` int(11) NOT NULL,
  `rf_record` int(11) NOT NULL,
  `rf_file` varchar(255) NOT NULL,
  `rf_fileid` varchar(100) NOT NULL,
  `rf_original_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `record_file`
--

INSERT INTO `record_file` (`rf_id`, `rf_record`, `rf_file`, `rf_fileid`, `rf_original_name`) VALUES
(1, 15, 'record_64e6d5dca53fa', '', ''),
(2, 16, 'record_64e6d7b240556', '', ''),
(3, 17, 'record_64e6d936a8aec', '', ''),
(4, 18, 'record_64e6d945f3964', '', ''),
(5, 19, 'record_64e6d9ce2f985', '', ''),
(6, 20, 'record_6555c2529a962', '', ''),
(7, 20, 'record_6555c25d660b3', '', ''),
(8, 20, 'record_6555c25d6d433', '', ''),
(9, 20, 'record_6555c25d73934', '', ''),
(10, 20, 'record_6555c25d77d61', '', ''),
(11, 21, 'record_6555c6842ec65', 'file_77705921', ''),
(12, 21, 'record_6555c6843412a', '', ''),
(13, 21, 'record_6555c684377f3', '', ''),
(14, 21, 'record_6555c6843d0cf', '', ''),
(15, 21, 'record_6555c6883f0d7', '', ''),
(16, 22, 'record_6555c6fa3c4ed', 'file_82831000', ''),
(17, 23, 'record_6555c726bb0b2', 'file_72639054', ''),
(18, 23, 'record_6555c726bef87', '', ''),
(19, 23, 'record_6555c732b7cef', '', ''),
(20, 24, 'record_6555c76d82d9d', 'file_92048124', ''),
(21, 24, 'record_6555c76d8bf5d', 'file_37170130', ''),
(22, 24, 'record_6555c76d8ed1c', 'file_89621030', ''),
(23, 24, 'record_6555c770b46c3', 'file_20808550', 'invoice.pdf'),
(24, 25, 'record_6555cc4e2a631', 'file_85082664', 'asdadasdadsa.JPG'),
(25, 25, 'record_6555cc50c06c9', 'file_39323803', 'CT0128999-V_BIS_INFO.pdf'),
(26, 26, 'record_6555cca82eaed', 'file_69907648', 'asdadasdadsa.JPG'),
(27, 26, 'record_6555ccaa08f5e', 'file_97886745', '3610293669.pdf'),
(28, 27, 'record_6555ccbd9418f', 'file_76154111', 'asdadasdadsa.JPG'),
(29, 27, 'record_6555ccbf6ccd4', 'file_98843057', '3610293669.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `record_prescription`
--

CREATE TABLE `record_prescription` (
  `rp_id` int(11) NOT NULL,
  `rp_item` int(11) NOT NULL,
  `rp_quantity` varchar(100) NOT NULL,
  `rp_remarks` varchar(255) NOT NULL,
  `rp_record` int(11) NOT NULL,
  `rp_frequency` varchar(255) NOT NULL,
  `rp_time` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `record_prescription`
--

INSERT INTO `record_prescription` (`rp_id`, `rp_item`, `rp_quantity`, `rp_remarks`, `rp_record`, `rp_frequency`, `rp_time`) VALUES
(28, 1, '1', 'bb', 10, 'aa', 1689503815),
(29, 2, '1', 'uu', 10, 'yy', 1689503816),
(30, 1, '10', 'a', 20, '1', 1700140756);

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
(1, 'Admin', '', 1),
(2, 'User', '', 1),
(3, 'Customer', '', 1),
(4, 'Staff', '', 1);

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
  `u_picture` varchar(255) NOT NULL,
  `u_ukey` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `u_name`, `u_email`, `u_password`, `u_key`, `u_full_name`, `u_ic`, `u_alamat`, `u_area`, `u_phone`, `u_admin`, `u_role`, `u_department`, `u_postcode`, `u_country`, `u_state`, `u_picture`, `u_ukey`) VALUES
(1, 'Mr Hery', 'admin@admin', 'cda8206eb90ff0ff143e5ee404d980102b37b7de52774b414bca3cc69d2ef6e3', '', 'Ahmad Khairi Aiman', '123123456', '124 Jalan Cekal 14', '', '0187824900', 1, 1, 1, '', '', '', '0', 'abc123'),
(12, 'Dr Hery', 'intelhost2u@gmail.com', 'cda8206eb90ff0ff143e5ee404d980102b37b7de52774b414bca3cc69d2ef6e3', '', '', '324234', 'adsads', '', '123123', 0, 2, 0, '', '', '', '648be4c442285-broomx00wide.JPG', '69925a39ebeb43fc7ef5402b1a762d2760d7256eca910bd50f2b54f281476469'),
(13, 'staff1', 'staff1@gmail.com', 'cda8206eb90ff0ff143e5ee404d980102b37b7de52774b414bca3cc69d2ef6e3', '', '', '', '', '', '', 0, 4, 0, '', '', '', '', 'def9c215a731e79c1210a16d989ecad181b241a70cae881bad3859fd4d766f1e'),
(14, 'Dr Ahmed', 'ahmed@gmail.com', 'cda8206eb90ff0ff143e5ee404d980102b37b7de52774b414bca3cc69d2ef6e3', '', '', '', '', '', '', 0, 2, 0, '', '', '', '648c1614affd3-logo-heryit.png', '165e82a12eee08ad7356decb9f4a5203dbc191e658638bd354227ca16455d1ef');

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
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `clinics`
--
ALTER TABLE `clinics`
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
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`i_id`);

--
-- Indexes for table `item_inventory`
--
ALTER TABLE `item_inventory`
  ADD PRIMARY KEY (`ii_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `purchase_item`
--
ALTER TABLE `purchase_item`
  ADD PRIMARY KEY (`pi_id`);

--
-- Indexes for table `record_file`
--
ALTER TABLE `record_file`
  ADD PRIMARY KEY (`rf_id`);

--
-- Indexes for table `record_prescription`
--
ALTER TABLE `record_prescription`
  ADD PRIMARY KEY (`rp_id`);

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
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `appointment_status`
--
ALTER TABLE `appointment_status`
  MODIFY `as_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `clinics`
--
ALTER TABLE `clinics`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `clinic_customer`
--
ALTER TABLE `clinic_customer`
  MODIFY `cc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `clinic_user`
--
ALTER TABLE `clinic_user`
  MODIFY `cu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customer_record`
--
ALTER TABLE `customer_record`
  MODIFY `cr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `i_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `item_inventory`
--
ALTER TABLE `item_inventory`
  MODIFY `ii_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `purchase_item`
--
ALTER TABLE `purchase_item`
  MODIFY `pi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `record_file`
--
ALTER TABLE `record_file`
  MODIFY `rf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `record_prescription`
--
ALTER TABLE `record_prescription`
  MODIFY `rp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
