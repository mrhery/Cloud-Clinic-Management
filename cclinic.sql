-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2025 at 10:01 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `a_id` int(11) NOT NULL,
  `a_business` int(11) NOT NULL,
  `a_name` varchar(100) NOT NULL,
  `a_code` varchar(100) NOT NULL,
  `a_description` varchar(255) NOT NULL,
  `a_class` varchar(100) NOT NULL,
  `a_category` int(11) NOT NULL,
  `a_liquidated` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`a_id`, `a_business`, `a_name`, `a_code`, `a_description`, `a_class`, `a_category`, `a_liquidated`) VALUES
(1, 1, 'Drawing', 'drawing', 'Owner Drawing', 'equity', 6, 0),
(2, 1, 'TNB Electricity Utility', 'electricity_unitlity', '', 'expenses', 1, 0),
(3, 1, 'SAJ Water Utility', 'water_utility', '', 'expenses', 1, 0),
(4, 1, 'Computer Equipment', 'computer_equipment', '', 'fixed_assets', 5, 0),
(5, 1, 'Office Equipment', 'office_equipment', '', 'fixed_assets', 5, 0),
(6, 1, 'Furnitures', 'furnitures', '', 'fixed_assets', 5, 0),
(7, 1, 'Office Phone and Internet Bills', 'office_phone_internet', '', 'expenses', 2, 0),
(8, 1, 'Mobile Phone and Internet Bills', 'mobile_phone_internet', '', 'expenses', 2, 0),
(9, 1, 'Entertainment', 'entertainment', '', 'expenses', 6, 0),
(10, 1, 'Advertising', 'advertising', '', 'expenses', 6, 0),
(11, 1, 'Stationary', 'stationary', '', 'expenses', 5, 0),
(12, 1, 'Pantry', 'pantry', '', 'expenses', 5, 0),
(13, 1, 'Transportation', 'transportation', '', 'expenses', 4, 0),
(14, 1, 'Gas Transportation', 'gas_transportation', '', 'expenses', 1, 0),
(15, 1, 'Office Clothes', 'office_clothes', '', 'fixed_assets', 5, 0),
(16, 1, 'Office Maintenance', 'office_maintenance', '', 'expenses', 5, 0),
(17, 1, 'Salary', 'salary', '', 'expenses', 3, 0),
(18, 1, 'Wages', 'wages', '', 'expenses', 3, 0),
(19, 1, 'Server Rental', 'server_rental', '', 'expenses', 5, 0),
(20, 1, 'Sales', 'sales', '', 'income', 6, 0),
(21, 1, 'Purchases', 'purchases', '', 'current_assets', 6, 0),
(22, 1, 'Capital', 'capital', '', 'equity', 6, 0),
(23, 1, 'Google Workspace', 'google_workspace', '', 'expenses', 5, 0),
(24, 1, 'Cloud Canva', 'cloud_canva', '', 'expenses', 5, 0),
(25, 1, 'Vehicle Service', 'vehicle_service', '', 'expenses', 4, 0),
(26, 1, 'Short Term Loan (Personal)', 'short_term_loan', '', 'current_liabilities', 6, 0),
(27, 1, 'Cash', 'cash', '', 'current_assets', 7, 1),
(28, 1, 'CIMB Bank (8603170167)', 'cimb_bank_86031701676', '', 'current_assets', 7, 1),
(29, 1, 'AgroBank (1005971000062930)', 'agrobank_1005971000062930', '', 'current_assets', 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `account_categories`
--

CREATE TABLE `account_categories` (
  `ac_id` int(11) NOT NULL,
  `ac_name` varchar(100) NOT NULL,
  `ac_business` int(11) NOT NULL,
  `ac_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_categories`
--

INSERT INTO `account_categories` (`ac_id`, `ac_name`, `ac_business`, `ac_description`) VALUES
(1, 'Utilities', 1, ''),
(2, 'Telecommunication', 1, ''),
(3, 'Payroll', 1, ''),
(4, 'Vehicle & Transportation', 1, ''),
(5, 'Office Supplies', 1, ''),
(6, 'Others', 1, ''),
(7, 'Liquidity', 1, '');

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
  `a_createdDate` varchar(50) NOT NULL,
  `a_plate` varchar(50) NOT NULL,
  `a_bookedDate` date DEFAULT NULL,
  `a_bookedTime` time DEFAULT NULL,
  `a_attendee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`a_id`, `a_ukey`, `a_customer`, `a_clinic`, `a_date`, `a_time`, `a_status`, `a_reason`, `a_user`, `a_createdDate`, `a_plate`, `a_bookedDate`, `a_bookedTime`, `a_attendee`) VALUES
(1, 'asd', 1, 1, '08-Dec-2023', 1702046940, 1, 'Covid Test asd', 0, '', '', NULL, NULL, 0),
(2, 'asdasdasd asd as', 1, 1, '08-Dec-2023', 1702050540, 1, 'Astma', 0, '', '', NULL, NULL, 0),
(3, '9133b951587bbfe9a16a667e07874b1af4725856f5e7e2eaa1c7c5ae1016400c', 2, 1, '08-Dec-2023', 1686843660, 1, 'adasd', 0, '', '', NULL, NULL, 0),
(4, '3b8a98eb98cabad62395b9b925bfc732bde4470799f2b25c653a180c9ee375e3', 2, 1, '08-Dec-2023', 1687621320, 0, 'fever', 0, '', '', NULL, NULL, 0),
(5, 'abd52a45f32b896ae36d80e191a01d97cca9b546dcca5fbd92b9b493d75783e0', 3, 1, '08-Dec-2023', 1687448580, 0, 'sdfsdfsdf', 0, '', '', '2024-11-30', '10:45:00', 0),
(6, '2c9688e4bf270ab7b2b950ec0fec26b4e54776dccaad5f1bb892c55fa0e75a40', 1, 1, '08-Dec-2023', 1692376980, 1, 'demam', 1, '17-Aug-2023', '', '2024-11-30', '11:12:00', 0),
(7, '13304b0976fd3072000c48fc594360167c1784d4ec9819082a52fe4f9841153c', 1, 1, '25-Mar-2024', 1711380600, 1, 'Batuk kahakl berdarah', 1, '25-Mar-2024', '', '2024-11-25', '13:54:00', 0),
(8, '41bf8de966d8801218a5a3517237c5d4ae219e1a949dbdc4029a3d474afcae82', 1, 1, '05-Dec-2024', 1733369280, 1, 'test 12', 1, '30-Nov-2024', '', '2024-11-30', '04:28:00', 12),
(9, 'b7214d41d9e1d42382414a4821a67ed6337071a41ff1a094211dd3416b50d2da', 1, 1, '01-Dec-2024', 1733024100, 0, 'twetwtw', 1, '30-Nov-2024', '', '2024-12-01', '11:35:00', 13),
(10, 'a4dfe56c19c9a6587cac1ab8676236705cf8c45e1d2c99a86ae8fa5ac3decab8', 8, 1, '03-Mar-2025', 1740990000, 1, 'H1N1 viral flu infection', 1, '28-Feb-2025', '', '2025-03-03', '16:20:00', 12),
(11, '06fef1491e6e31d197780b9ec88906ad681045560c11665f2040c32a5f2d74f5', 1, 1, '28-Feb-2025', 1740744900, 1, 'asdcasd', 1, '28-Feb-2025', '', '2025-02-28', '20:15:00', 12);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_status`
--

INSERT INTO `appointment_status` (`as_id`, `as_appointment`, `as_status`, `as_message`, `as_date`, `as_time`, `as_user`) VALUES
(1, 2, 0, 'teting', '16-Jun-2023', 1686902672, 1),
(2, 6, 1, '', '17-Aug-2023', 1692290628, 1),
(3, 7, 0, '', '25-Mar-2024', 1711373466, 1),
(4, 7, 1, '', '25-Mar-2024', 1711373510, 1),
(5, 2, 1, '', '29-Nov-2024', 1732903236, 1),
(6, 8, 1, '', '29-Nov-2024', 1732937351, 1),
(7, 9, 0, '', '30-Nov-2024', 1732937753, 1),
(8, 8, 1, '', '30-Nov-2024', 1732938289, 1),
(9, 8, 1, '', '30-Nov-2024', 1732938296, 1),
(10, 1, 1, '', '27-Feb-2025', 1740671776, 1),
(11, 10, 1, '', '28-Feb-2025', 1740727391, 1),
(12, 10, 1, '', '28-Feb-2025', 1740727587, 1),
(13, 11, 1, '', '28-Feb-2025', 1740744953, 1),
(14, 11, 1, '', '28-Feb-2025', 1740744974, 1),
(15, 10, 2, '', '06-Mar-2025', 1741267710, 1),
(16, 10, 1, '', '06-Mar-2025', 1741269720, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cashaccounts`
--

CREATE TABLE `cashaccounts` (
  `c_id` int(11) NOT NULL,
  `c_business` int(11) NOT NULL,
  `c_name` varchar(200) NOT NULL,
  `c_type` varchar(20) NOT NULL,
  `c_category` varchar(20) NOT NULL,
  `c_key` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cashaccounts`
--

INSERT INTO `cashaccounts` (`c_id`, `c_business`, `c_name`, `c_type`, `c_category`, `c_key`) VALUES
(1, 1, 'Cash', 'personal', 'cash', 'cash_0026676553647889'),
(2, 1, 'CIMB Bank (Business) (8603170167)', 'business', 'bank', 'bank_0093877264789837'),
(3, 1, 'Maybank (Personal) (151061597627)', 'personal', 'bank', 'bank_8374678298716253'),
(4, 1, 'AgroBank (Business) (1005971000062930)', 'business', 'bank', 'bank_1005971000062930');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`c_id`, `c_name`, `c_regno`, `c_address`, `c_phone`, `c_email`, `c_is_personal`, `c_clinic`, `c_date`, `c_time`, `c_user`, `c_key`) VALUES
(1, 'Intellingent Mental Arithmetic Sdn Bhd', 'IMA-1234', 'No 23A Jalan Kebudayaan 16, Taman Universiti, 81300 Johor Bahru, Johor', '+607-521 1178', '', 0, 1, '08-Dec-2023', 0, 1, 'client_001'),
(2, 'Intelligent Hosting Sdn Bhd', 'IH-1234', 'No 23A Jalan Kebudayaan 16, Taman Universiti, 81300 Johor Bahru, Johor', '+607-521 1178', '', 0, 2, '08-Dec-2023', 0, 1, 'client_002'),
(3, 'Hery Intelligent Technology', 'HIT-1234', 'No 0402 Jalan Pendidikan 3, Taman Universiti, 81300 Johor Bahru, Johor', '+6018-782 4900', '', 0, 1, '07-Dec-2023', 0, 1, 'client_003'),
(8, 'Calvin Chong', 'BHAJ24234', 'No, 14, Jalan Indah Pelangi', '325324', 'samtaii@gmail.com', 0, 1, '', 0, 0, '559b17d55c7fbd1e4ebfcad383a477982d0d8cb615c7cf2b84ac98a0e7dd5f91');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clinics`
--

INSERT INTO `clinics` (`c_id`, `c_ukey`, `c_name`, `c_address`, `c_phone`, `c_email`, `c_regno`, `c_logo`, `c_user`, `c_owner`, `c_disabled`) VALUES
(1, '2de99521fb8204da4b9e1497aff933fc062e7b8ead5933ec85a7ec973c26994f', 'Hery Intelligent Technology', '0402 Jalan Pendidikan 3, Taman Universiti, 81300 Johor Bahru, Johor', '0187824900', 'hery@technology.com', 'IP0549884-A', '', 1, 12, 0),
(2, '5554cf84b3b9d2e7326f1e5c9219a75d0bc84f8eb6b3f7fb1a0f874222ce45ff', 'Bengkel Ahmed Taman Universiti', '', '', 'asdads@ads', '', '', 14, 14, 0),
(3, '060356720881168c5275c41f202c312cb793e3dfefa72d2400c88f8aa28abb3b', 'Workshop ABC', '', '234243243', 'zads@asdads', 'asdsd', '', 1, 14, 0),
(4, '3a7e78de230e2d49c13583e58831288ad29d2760cca7ff137b3932c8e968ac88', 'ABC Sdn Bhd', 'No. 12A, Jalan Setia Idaman, Taman Setia Indah', '62387645', 'abc@gmail.com', 'JBHJ2323', '', 1, 12, 0),
(5, 'a29caf47b305dc837c6f1c4b4fca463775b18f854a5cf668ab56333aaf56d67a', 'Deepseek Tech', 'No, 16, Jalan Ayer Hitam', '073456782', 'deepseektech@gmail.com', 'DEG123123', '', 1, 14, 0);

-- --------------------------------------------------------

--
-- Table structure for table `clinic_customer`
--

CREATE TABLE `clinic_customer` (
  `cc_id` int(11) NOT NULL,
  `cc_clinic` int(11) NOT NULL,
  `cc_customer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(7, 3, 1, 'admin'),
(8, 4, 12, 'owner'),
(9, 4, 1, 'admin'),
(10, 5, 14, 'owner'),
(11, 5, 1, 'admin');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`c_id`, `c_name`, `c_ic`, `c_phone`, `c_email`, `c_password`, `c_ukey`, `c_address`) VALUES
(1, 'Mr Hery', '1234567890', '1234567890', 'hery@herytechnology.com', 'cda8206eb90ff0ff143e5ee404d980102b37b7de52774b414bca3cc69d2ef6e3', 'abc123', ''),
(2, 'asdasd', '123123', '', '', '', '3426e93cb58b3fc5790f7e261109fc6b3098643a6f36d6ab2e52ba471923df51', ''),
(3, 'asdasdad', '12341234', '', '', '', '934297ece8454deba61f1211bda0c277a0d52bc168134cce15642e8991af4a9c', 'asdfasd'),
(5, 'dfsdfsfasd', '234234243234', '', '', '', 'e06cd9636663fdf8b0c8e86add805ff8360663065d6231f9b4652adec9c0423e', ' '),
(8, 'gdfnfdn', '634653', '+60`65432727', 'abc@gmail.com', '', '064ca05addb66f919977fcc21c0056f4535e749205243e061765e00690e448eb', '');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_record`
--

INSERT INTO `customer_record` (`cr_id`, `cr_customer`, `cr_clinic`, `cr_user`, `cr_date`, `cr_time`, `cr_title`, `cr_description`, `cr_illness`, `cr_examination`, `cr_investigation`, `cr_diagnosis`, `cr_plan`, `cr_key`) VALUES
(33, 1, 1, 1, '24-Jan-2024', 1706121296, '', '', 'aa', '', '', '', '', 'doc-202401241-5R1682'),
(34, 1, 1, 1, '24-Jan-2024', 1706121563, '', '', '', '', '', '', '', 'doc-202401241-Rg4991'),
(35, 1, 1, 1, '24-Jan-2024', 1706121588, '', '', '', '', '', '', '', 'doc-202401241-S6F704'),
(36, 1, 1, 1, '25-Mar-2024', 1711373561, '', '', '', '', '', '', '', 'doc-202403251-ld9102'),
(37, 1, 1, 1, '28-Mar-2024', 1711651794, '', '', '', '', '', '', '', 'doc-202403281-cX7010'),
(38, 1, 1, 1, '29-Nov-2024', 1732896983, '', '', '', '', '', '', '', 'doc-202411291-M0Z977'),
(39, 1, 1, 1, '30-Nov-2024', 1732941685, '', '', '', '', '', '', '', 'doc-202411301-abx450'),
(40, 1, 1, 1, '30-Nov-2024', 1732943529, '', '', 'aasdadwefew sfsfs sdfsfs df sfd sdadadasda asd asd asd dasd a asdasdas sdada adasd adas qwerq ', '', '', '', '', 'doc-202411301-yKF607'),
(41, 1, 1, 1, '30-Nov-2024', 1732951284, '', '', 'aaaaaaaaaaaaa asda asda sdasd s', '', '', '', '', 'doc-202411301-Ppi847'),
(42, 1, 1, 1, '01-Dec-2024', 1732994650, '', '', 'Demam, selesema, viral fever', '', '', '', '', 'doc-202411301-ljx574'),
(43, 1, 1, 1, '01-Dec-2024', 1732994866, '', '', 'a', '', '', '', '', 'doc-202411301-25x367'),
(44, 1, 1, 1, '01-Dec-2024', 1732994892, '', '', '', '', '', '', '', 'doc-202411301-4Du893'),
(45, 1, 1, 1, '01-Dec-2024', 1732995932, '', '', 'aaa', 'x', 'b', 'c', 'd', 'doc-202411301-L3Z745'),
(46, 1, 1, 1, '28-Feb-2025', 1740730072, '', '', 'High Fever with running nose and severe sorethroat', 'Lastly detected on 27 August 2024', 'Checked forehead, nose and throat', '-', 'Need to take panadol', 'doc-202502281-185087');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `d_id` int(11) NOT NULL,
  `d_name` varchar(100) NOT NULL,
  `d_code` varchar(100) NOT NULL,
  `d_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`i_id`, `i_name`, `i_description`, `i_code`, `i_clinic`, `i_quantity`, `i_type`, `i_price`, `i_key`, `i_user`, `i_sku`, `i_tag`, `i_cost`) VALUES
(5, 'Ubat 1', 'Ubat 1', 'HKK3243', 1, 203, 'product', 150, 'item_6572eded67c1f', 1, 'HFGH243', '', 100),
(6, 'Ubat 2', 'Ubat 2', '', 1, 200, 'product', 30, 'item_6572eded67c1g', 1, '', '', 25),
(7, 'Ubat 3', 'Ubat 3', '', 1, 200, 'product', 50, 'item_6572eded67c1h', 1, '', '', 0),
(8, 'aaaa', 'gggaaa', 'bbbrrreee', 1, 0, 'package', 160, 'package_6604515c233d7', 1, 'rrr', '', 0),
(9, 'Ubat 6', 'Highly efficient in curing diseases', 'GJGF3245325', 1, 30, 'product', 570, 'item_67c13bbc8c6a3', 1, 'GFHJ4534', '', 790),
(10, 'Package 7', '-', 'JN003', 1, 0, 'package', 0, 'package_67c140c2df8ef', 1, 'TYH456456', '', 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_inventory`
--

INSERT INTO `item_inventory` (`ii_id`, `ii_item`, `ii_date`, `ii_time`, `ii_quantity`, `ii_description`, `ii_cost`, `ii_user`, `ii_clinic`) VALUES
(6, 5, '08-Dec-2023', 1702052429, 200, 'Try beli', 0.5, 1, 1),
(7, 5, '25-Mar-2024', 1711373623, 1, '', 100, 1, 1),
(8, 5, '25-Mar-2024', 1711373702, 2, '', 123123, 1, 1),
(9, 6, '28-Feb-2025', 1740735618, 0, '', 0, 1, 1),
(10, 7, '28-May-2025', 1740737288, 0, '', 0, 1, 1),
(11, 7, '28-May-2025', 1740737290, 0, '', 0, 1, 1),
(12, 7, '28-May-2025', 1740737290, 0, '', 0, 1, 1),
(13, 7, '28-May-2025', 1740737290, 0, '', 0, 1, 1),
(14, 7, '28-May-2025', 1740737291, 0, '', 0, 1, 1),
(15, 7, '28-May-2025', 1740737291, 0, '', 0, 1, 1),
(16, 7, '28-May-2025', 1740737291, 0, '', 0, 1, 1),
(17, 7, '28-May-2025', 1740737291, 0, '', 0, 1, 1),
(18, 7, '28-May-2025', 1740737291, 0, '', 0, 1, 1),
(19, 7, '28-May-2025', 1740737291, 0, '', 0, 1, 1),
(20, 7, '28-May-2025', 1740737291, 0, '', 0, 1, 1),
(21, 7, '28-May-2025', 1740737291, 0, '', 0, 1, 1),
(22, 7, '28-May-2025', 1740737291, 0, '', 0, 1, 1),
(23, 7, '28-May-2025', 1740737291, 0, '', 0, 1, 1),
(24, 9, '28-Feb-2025', 1740672000, 30, '-', 650, 1, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`m_id`, `m_main`, `m_sort`, `m_name`, `m_url`, `m_route`, `m_status`, `m_description`, `m_short`, `m_icon`, `m_role`) VALUES
(8, 30, 5, 'Staffs', 'pengguna', 'pengguna', 1, 'Manage staff informations', 'STA', 'typcn typcn-user-outline', '1,2,4'),
(9, 0, 100, 'Settings', 'settings', 'settings', 1, 'All System Settings', '', 'typcn typcn-cog-outline', '1'),
(10, 9, 1, 'Menus', 'menus', 'menus', 1, 'Manage System Menus', 'MNU', '', '1'),
(21, 9, 1, 'User Roles', 'rols', 'rols', 1, 'Senarai Rol Pengguna', 'ROL', 'typcn typcn-th-large', '1'),
(24, 0, 1, 'Dashboard', 'dashboard', 'dashboard', 1, 'Review your business performance interactively', '', 'fa fa-dashboard', '1,2,3,4'),
(25, 30, 4, 'Patients', 'customers', 'customers', 1, 'Manage all your customer&#039;s information', 'PAT', 'fa fa-users', '1,2,3,4'),
(26, 0, 2, 'Appointments', 'appointments', 'appointments', 1, 'Manage all appointments in your clinic', '', 'fa fa-calendar', '1,2,4'),
(27, 0, 3, 'Medical Records', 'medical-record', 'medical-record', 1, 'All available servicec record base on customer information', '', 'fa fa-plus', '1,2,3,4'),
(28, 0, 6, 'Clinics', 'businesses', 'Clinic', 1, 'Manage you business information', '', 'fa fa-building', '1,2,4'),
(29, 0, 8, 'Inventories', 'inventories', 'inventories', 1, 'Manage your business inventories', '', 'fa fa-cubes', '1,2,4'),
(30, 0, 3, 'Users', 'Users', 'Users', 1, '', '', 'fa fa-users', '1,2,3,4'),
(31, 0, 7, 'Billing', 'billing', 'billing', 1, '', '', 'fa fa-dollar', '1,2,4'),
(32, 31, 1, 'Point of Sale', 'pos-system', 'pos-system', 1, 'Point-of-Sale system for daily sales', 'POS', 'fa fa-money', ''),
(33, 31, 2, 'Sales', 'sales', 'sales', 1, '', 'SAL', 'fa fa-area-chart', '1,2,4'),
(34, 31, 3, 'Purchasing', 'purchasing', 'purchasing', 1, 'Manage purchases of your clinic', 'PUR', 'fa fa-legal', '1,2,4'),
(35, 31, 1, 'Cash Flow', 'cashflow', 'cashflow', 1, 'Outlet cashflow', 'CFL', '', ''),
(36, 31, 5, 'Supplier', 'supplier', 'supplier', 1, 'Outlet supplier records', 'SUP', '', '1,2,4'),
(37, 31, 1, 'Journal', 'journal', 'journal', 1, 'Journal Records', 'JRN', '', ''),
(38, 0, 2, 'Vehicles', 'vehicles', 'vehicles', 1, 'Customer vehicles record', 'VEH', 'fa fa-car', '');

-- --------------------------------------------------------

--
-- Table structure for table `package_item`
--

CREATE TABLE `package_item` (
  `pi_id` int(11) NOT NULL,
  `pi_name` varchar(200) NOT NULL,
  `pi_price` double NOT NULL,
  `pi_item` int(11) NOT NULL,
  `pi_package` int(11) NOT NULL,
  `pi_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_item`
--

INSERT INTO `package_item` (`pi_id`, `pi_name`, `pi_price`, `pi_item`, `pi_package`, `pi_quantity`) VALUES
(11, 'Drive Shaftaaa', 150, 5, 8, 1),
(12, 'Break Padaaa', 30, 6, 8, 1),
(13, 'Ubat 6', 570, 9, 10, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`p_id`, `p_client`, `p_doc`, `p_date`, `p_time`, `p_key`, `p_clinic`, `p_user`, `p_paid`, `p_total`, `p_status`, `p_remark`, `p_summary`, `p_type`) VALUES
(5, 1, 'abc1234', '08-Dec-2023', 1702052429, 'purchase_6572eded5ca1f', 1, 1, 50, 100, 'partial', 'test pur', 'Panadol A x200<br />', 'invoice'),
(6, 1, 'HIT-20240001', '25-Mar-2024', 1711373623, 'purchase_660128d72cc6b', 1, 1, 0, 0, 'paid', '', 'Drive Shaft x1<br />', 'invoice'),
(7, 2, 'HIT-20240001', '25-Mar-2024', 1711373701, 'purchase_66012925eb187', 1, 1, 0, 0, 'paid', '', 'Drive Shaft x2<br />', 'invoice'),
(8, 1, 'BJM2323', '28-May-2025', 1740737288, 'purchase_67c136a8c53ea', 1, 1, 350, 450, 'partial', 'dfgdfg', '', 'invoice'),
(9, 1, 'BJM2323', '28-May-2025', 1740737290, 'purchase_67c136aa6de0f', 1, 1, 350, 450, 'partial', 'dfgdfg', '', 'invoice'),
(10, 1, 'BJM2323', '28-May-2025', 1740737290, 'purchase_67c136aac4fb9', 1, 1, 350, 450, 'partial', 'dfgdfg', '', 'invoice'),
(11, 1, 'BJM2323', '28-May-2025', 1740737290, 'purchase_67c136aaca77b', 1, 1, 350, 450, 'partial', 'dfgdfg', '', 'invoice'),
(12, 1, 'BJM2323', '28-May-2025', 1740737291, 'purchase_67c136ab1f332', 1, 1, 350, 450, 'partial', 'dfgdfg', '', 'invoice'),
(13, 1, 'BJM2323', '28-May-2025', 1740737291, 'purchase_67c136ab234ae', 1, 1, 350, 450, 'partial', 'dfgdfg', '', 'invoice'),
(14, 1, 'BJM2323', '28-May-2025', 1740737291, 'purchase_67c136ab56a34', 1, 1, 350, 450, 'partial', 'dfgdfg', '', 'invoice'),
(15, 1, 'BJM2323', '28-May-2025', 1740737291, 'purchase_67c136ab5b117', 1, 1, 350, 450, 'partial', 'dfgdfg', '', 'invoice'),
(16, 1, 'BJM2323', '28-May-2025', 1740737291, 'purchase_67c136ab883d3', 1, 1, 350, 450, 'partial', 'dfgdfg', '', 'invoice'),
(17, 1, 'BJM2323', '28-May-2025', 1740737291, 'purchase_67c136ab8cbc4', 1, 1, 350, 450, 'partial', 'dfgdfg', '', 'invoice'),
(18, 1, 'BJM2323', '28-May-2025', 1740737291, 'purchase_67c136abb56ea', 1, 1, 350, 450, 'partial', 'dfgdfg', '', 'invoice'),
(19, 1, 'BJM2323', '28-May-2025', 1740737291, 'purchase_67c136abb9c63', 1, 1, 350, 450, 'partial', 'dfgdfg', '', 'invoice'),
(20, 1, 'BJM2323', '28-May-2025', 1740737291, 'purchase_67c136abe50a2', 1, 1, 350, 450, 'partial', 'dfgdfg', '', 'invoice'),
(21, 1, 'BJM2323', '28-May-2025', 1740737291, 'purchase_67c136abe97b6', 1, 1, 350, 450, 'partial', 'dfgdfg', '', 'invoice');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_item`
--

INSERT INTO `purchase_item` (`pi_id`, `pi_purchase`, `pi_clinic`, `pi_item`, `pi_quantity`, `pi_cost`, `pi_total_cost`, `pi_remark`) VALUES
(5, 5, 1, 5, 200, 1, 100, 'Try beli'),
(6, 6, 1, 5, 1, 100, 100, ''),
(7, 7, 1, 5, 2, 123123, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE `records` (
  `r_id` int(11) NOT NULL,
  `r_dr_account` int(11) NOT NULL,
  `r_cr_account` int(11) NOT NULL,
  `r_amount` double NOT NULL,
  `r_date` varchar(25) NOT NULL,
  `r_description` varchar(255) NOT NULL,
  `r_business` int(11) NOT NULL,
  `r_doc` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(29, 27, 'record_6555ccbf6ccd4', 'file_98843057', '3610293669.pdf'),
(30, 38, 'record_674994775f0f5', 'file_93463030', '1.jpg'),
(31, 40, 'record_674a4a2ab4964', 'file_41205561', '1.jpg'),
(32, 40, 'record_674a4a2abf82f', 'file_67650206', '2.jpg'),
(33, 40, 'record_674a4a2ac3fc0', 'file_20892720', '3.jpg'),
(34, 40, 'record_674a4a2acbeb0', 'file_90072989', '4.jpg'),
(35, 41, 'record_674a680659686', 'file_3368080', '2.jpg'),
(36, 42, 'record_674b120480862', 'file_22612895', '2020-08-04_17-36-46_4k_PiratesHelp.webp');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `record_prescription`
--

INSERT INTO `record_prescription` (`rp_id`, `rp_item`, `rp_quantity`, `rp_remarks`, `rp_record`, `rp_frequency`, `rp_time`) VALUES
(28, 1, '1', 'bb', 10, '100', 1689503815),
(29, 2, '1', 'uu', 10, '200', 1689503816),
(30, 1, '10', 'a', 20, '50', 1700140756),
(32, 5, '1', '150', 29, '150', 1706121185),
(33, 5, '2', '300', 29, '150', 1706121185),
(34, 5, '3', '450', 32, '150', 1706121242),
(35, 5, '3', '450', 33, '150', 1706121296),
(37, 5, '1', '150', 36, '150', 1711373561),
(38, 6, '2', '60', 36, '30', 1711373561),
(39, 5, '1', '150', 37, '150', 1711651794),
(72, 5, '1', '150', 41, '150', 1732951284),
(166, 5, '1', '150', 42, '150', 1732994651),
(167, 6, '1', '30', 42, '30', 1732994651),
(168, 7, '20', '1000', 42, '50', 1732994651),
(169, 5, '1', '150', 44, '150', 1732994892),
(170, 5, '1', '150', 46, '150', 1740730072);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `r_id` int(11) NOT NULL,
  `r_name` varchar(100) NOT NULL,
  `r_menu` varchar(100) NOT NULL,
  `r_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`r_id`, `r_name`, `r_menu`, `r_status`) VALUES
(1, 'Admin', '', 1),
(2, 'User', '', 1),
(3, 'Customer', '', 1),
(4, 'Staff', '', 1),
(10, 'Chong', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `s_id` int(11) NOT NULL,
  `s_client` int(11) NOT NULL,
  `s_doc` varchar(100) NOT NULL,
  `s_date` varchar(100) NOT NULL,
  `s_time` int(15) NOT NULL,
  `s_key` varchar(100) NOT NULL,
  `s_clinic` int(11) NOT NULL,
  `s_user` int(11) NOT NULL,
  `s_paid` double NOT NULL,
  `s_total` double NOT NULL,
  `s_status` varchar(50) NOT NULL,
  `s_remark` varchar(255) DEFAULT NULL,
  `s_summary` varchar(500) DEFAULT NULL,
  `s_type` varchar(50) NOT NULL,
  `s_customer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`s_id`, `s_client`, `s_doc`, `s_date`, `s_time`, `s_key`, `s_clinic`, `s_user`, `s_paid`, `s_total`, `s_status`, `s_remark`, `s_summary`, `s_type`, `s_customer`) VALUES
(28, 1, 'HIT-20250023', '28-Feb-2025', 1740735618, 'sale_67c1302239308', 1, 1, 500, 50, 'paid', '', '', 'invoice', 0),
(29, 1, 'HIT-20250002', '28-Feb-2025', 1740736268, 'sale_67c132ac1613c', 1, 1, 250, 700, 'partial', '', '', 'debit_note', 0),
(30, 1, 'HIT-20250003', '28-Aug-2024', 1740736868, 'sale_67c1350426f22', 1, 1, 320, 680, 'partial', 'fghfh', '', 'debit_note', 0),
(31, 1, 'HIT-20250004', '07-Mar-2025', 1741355877, 'sale_67caa7054dbb7', 1, 1, 0, 0, 'paid', '', '', 'debit_note', 0),
(47, 1, 'HIT-20250005', '07-Mar-2025', 1741357170, 'sale_67caac1291067', 1, 1, 0, 0, 'paid', '', '', 'debit_note', 0),
(48, 1, 'HIT-20250006', '07-Mar-2025', 1741357195, 'sale_67caac2b4e465', 1, 1, 0, 0, 'paid', '', '', 'debit_note', 0),
(49, 1, 'HIT-20250007', '10-Mar-2025', 1741618415, 'sale_67cea88fbc0de', 1, 1, 0, 0, 'paid', '', '', 'debit_note', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sale_item`
--

CREATE TABLE `sale_item` (
  `si_id` int(11) NOT NULL,
  `si_purchase` int(11) NOT NULL,
  `si_clinic` int(11) NOT NULL,
  `si_item` int(11) NOT NULL,
  `si_quantity` int(11) NOT NULL,
  `si_cost` int(11) NOT NULL,
  `si_total_cost` double NOT NULL,
  `si_remark` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `t_id` int(11) NOT NULL,
  `t_created` datetime NOT NULL,
  `t_updated` datetime NOT NULL,
  `t_doc_no` varchar(30) NOT NULL,
  `t_doc_datetime` datetime NOT NULL,
  `t_doc_type` varchar(50) NOT NULL,
  `t_account` varchar(100) NOT NULL,
  `t_account_class` varchar(50) NOT NULL,
  `t_amount` double NOT NULL,
  `t_user` int(11) NOT NULL,
  `t_description` varchar(200) NOT NULL,
  `t_file` varchar(255) NOT NULL,
  `t_notes` varchar(100) NOT NULL,
  `t_key` varchar(100) NOT NULL,
  `t_no` varchar(100) NOT NULL,
  `t_business` int(11) NOT NULL,
  `t_cash_account` int(11) NOT NULL,
  `t_delete` int(11) NOT NULL,
  `t_type` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`t_id`, `t_created`, `t_updated`, `t_doc_no`, `t_doc_datetime`, `t_doc_type`, `t_account`, `t_account_class`, `t_amount`, `t_user`, `t_description`, `t_file`, `t_notes`, `t_key`, `t_no`, `t_business`, `t_cash_account`, `t_delete`, `t_type`) VALUES
(8, '2024-03-24 16:43:07', '2024-03-24 16:43:07', '', '2024-01-01 00:00:00', '', '24', '', -29.9, 1, 'Canva', '', '', 'trx_66004a0b8cb0e', '2024/CF/00002', 1, 2, 0, 'out');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `u_name`, `u_email`, `u_password`, `u_key`, `u_full_name`, `u_ic`, `u_alamat`, `u_area`, `u_phone`, `u_admin`, `u_role`, `u_department`, `u_postcode`, `u_country`, `u_state`, `u_picture`, `u_ukey`) VALUES
(1, 'Mr Hery', 'admin@admin', 'cda8206eb90ff0ff143e5ee404d980102b37b7de52774b414bca3cc69d2ef6e3', 'aaaa', 'Ahmad Khairi Aiman', '123123456', '124 Jalan Cekal 14', '', '0187824900', 1, 1, 1, '', '', '', '0', 'abc123'),
(12, 'Dr Hery', 'intelhost2u@gmail.com', 'cda8206eb90ff0ff143e5ee404d980102b37b7de52774b414bca3cc69d2ef6e3', 'bbbb', '', '324234', 'adsads', '', '123123', 0, 2, 0, '', '', '', '648be4c442285-broomx00wide.JPG', '69925a39ebeb43fc7ef5402b1a762d2760d7256eca910bd50f2b54f281476469'),
(13, 'staff1', 'staff1@gmail.com', 'cda8206eb90ff0ff143e5ee404d980102b37b7de52774b414bca3cc69d2ef6e3', 'cccc', '', '', '', '', '', 0, 4, 0, '', '', '', '', 'def9c215a731e79c1210a16d989ecad181b241a70cae881bad3859fd4d766f1e'),
(14, 'Dr Ahmed', 'ahmed@gmail.com', 'cda8206eb90ff0ff143e5ee404d980102b37b7de52774b414bca3cc69d2ef6e3', 'dddd', '', '', '', '', '', 0, 2, 0, '', '', '', '648c1614affd3-logo-heryit.png', '165e82a12eee08ad7356decb9f4a5203dbc191e658638bd354227ca16455d1ef'),
(15, 'Abu Musa', 'abumusa@gmail.com', '17aad1b88a44dfc77d79d9d68ddcd02795287453acc2054de7b9a012e173bd70', '', '', '903533575555', 'Gelang Patah', '', '014278938734', 0, 2, 0, '', '', '', '67c122b35760b-james.jpg', 'd1a5abcb131c7d171c0ab1fc2ae23c086c8f877011253b422f8e8076060d662a'),
(16, 'Michael Chan', 'michaelchan@gmail.com', 'a09ee65be5f4ae285de1b3fb44e68697edbe8f3f32d0456ba995a17c2cd4e2e2', '', '', '950603594444', 'No, 15, Jalan Nusa Bestari', '', '0158964848', 0, 4, 0, '', '', '', '', '746d875f0403e0c1233952bf701e5db992aeb486ed7d719fe9d5e91e0680be89');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `v_id` int(11) NOT NULL,
  `v_no` varchar(100) NOT NULL,
  `v_model` varchar(100) NOT NULL,
  `v_brand` varchar(100) NOT NULL,
  `v_business` int(11) NOT NULL,
  `v_user` int(11) NOT NULL,
  `v_customer` int(11) NOT NULL,
  `v_key` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`v_id`, `v_no`, `v_model`, `v_brand`, `v_business`, `v_user`, `v_customer`, `v_key`) VALUES
(1, 'asda', '234234a', 'werweruu', 1, 1, 0, 'a');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `account_categories`
--
ALTER TABLE `account_categories`
  ADD PRIMARY KEY (`ac_id`);

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
-- Indexes for table `cashaccounts`
--
ALTER TABLE `cashaccounts`
  ADD PRIMARY KEY (`c_id`);

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
-- Indexes for table `package_item`
--
ALTER TABLE `package_item`
  ADD PRIMARY KEY (`pi_id`);

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
-- Indexes for table `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`r_id`);

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
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `sale_item`
--
ALTER TABLE `sale_item`
  ADD PRIMARY KEY (`si_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`t_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`v_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `account_categories`
--
ALTER TABLE `account_categories`
  MODIFY `ac_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `appointment_status`
--
ALTER TABLE `appointment_status`
  MODIFY `as_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `cashaccounts`
--
ALTER TABLE `cashaccounts`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `clinics`
--
ALTER TABLE `clinics`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `clinic_customer`
--
ALTER TABLE `clinic_customer`
  MODIFY `cc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `clinic_user`
--
ALTER TABLE `clinic_user`
  MODIFY `cu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customer_record`
--
ALTER TABLE `customer_record`
  MODIFY `cr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `i_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `item_inventory`
--
ALTER TABLE `item_inventory`
  MODIFY `ii_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `package_item`
--
ALTER TABLE `package_item`
  MODIFY `pi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `purchase_item`
--
ALTER TABLE `purchase_item`
  MODIFY `pi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `records`
--
ALTER TABLE `records`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `record_file`
--
ALTER TABLE `record_file`
  MODIFY `rf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `record_prescription`
--
ALTER TABLE `record_prescription`
  MODIFY `rp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `sale_item`
--
ALTER TABLE `sale_item`
  MODIFY `si_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `v_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
