-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2019 at 03:05 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bt`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_batch`
--

CREATE TABLE `tbl_batch` (
  `batch_id` char(8) NOT NULL,
  `prd_id` char(8) NOT NULL,
  `sup_id` char(5) NOT NULL,
  `batch_date` date NOT NULL,
  `batch_qnty` int(5) NOT NULL,
  `batch_prd_cost_price` double(20,2) NOT NULL,
  `batch_prd_sell_price` double(20,2) NOT NULL,
  `batch_pay_amount` double(20,2) NOT NULL,
  `batch_on_credit` tinyint(1) NOT NULL COMMENT 'oncredit=1 ',
  `batch_credit_amount` double(20,2) NOT NULL,
  `batch_settle_date` date NOT NULL,
  `batch_stat` tinyint(1) NOT NULL COMMENT 'enable=1 disable=0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_batch`
--

INSERT INTO `tbl_batch` (`batch_id`, `prd_id`, `sup_id`, `batch_date`, `batch_qnty`, `batch_prd_cost_price`, `batch_prd_sell_price`, `batch_pay_amount`, `batch_on_credit`, `batch_credit_amount`, `batch_settle_date`, `batch_stat`) VALUES
('K0000001', 'P0000001', 'S0002', '2019-06-28', 10, 4500.00, 5500.00, 45000.00, 0, 0.00, '2019-08-31', 1),
('K0000002', 'P0000002', 'S0001', '2019-06-28', 12, 5250.00, 6250.00, 63000.00, 1, 43000.00, '2019-08-31', 1),
('K0000003', 'P0000003', 'S0001', '2019-06-28', 10, 5150.00, 6000.00, 51500.00, 1, 31500.00, '2019-09-01', 1),
('K0000004', 'P0000004', 'S0002', '2019-06-28', 10, 4250.00, 5250.00, 42500.00, 0, 0.00, '2019-09-01', 1),
('K0000005', 'P0000005', 'S0003', '2019-07-04', 15, 6000.00, 7200.00, 90000.00, 1, 50000.00, '2019-09-05', 1),
('K0000006', 'P0000006', 'S0003', '2019-07-04', 30, 20.00, 50.00, 600.00, 1, 100.00, '2019-09-05', 1),
('K0000007', 'P0000007', 'S0004', '2019-07-04', 10, 350.00, 600.00, 3500.00, 0, 0.00, '2019-09-05', 1),
('K0000008', 'P0000008', 'S0004', '2019-07-06', 10, 550.00, 670.00, 5500.00, 0, 0.00, '2019-08-31', 1),
('K0000009', 'P0000009', 'S0004', '2019-07-06', 10, 650.00, 750.00, 6500.00, 0, 0.00, '2019-08-31', 1),
('K0000010', 'P0000010', 'S0004', '2019-07-11', 12, 750.00, 830.00, 9000.00, 1, 7000.00, '2019-09-12', 1),
('K0000011', 'P0000011', 'S0004', '2019-07-11', 12, 650.00, 760.00, 7800.00, 1, 5800.00, '2019-08-11', 1),
('K0000012', 'P0000012', 'S0002', '2019-07-14', 10, 850.00, 950.00, 8500.00, 0, 0.00, '2019-08-31', 1),
('K0000013', 'P0000013', 'S0003', '2019-07-24', 6, 10500.00, 12050.00, 63000.00, 1, 33000.00, '2019-08-31', 1),
('K0000014', 'P0000014', 'S0003', '2019-08-27', 60, 10.00, 25.00, 600.00, 0, 0.00, '2019-08-31', 1),
('K0000015', 'P0000016', 'S0003', '2019-08-27', 25, 70.00, 120.00, 1750.00, 0, 0.00, '2019-08-31', 1),
('K0000016', 'P0000017', 'S0003', '2019-08-29', 20, 50.00, 95.00, 1000.00, 0, 0.00, '2019-08-31', 1),
('K0000017', 'P0000018', 'S0003', '2019-08-29', 50, 12.00, 35.00, 600.00, 0, 0.00, '2019-08-31', 1),
('K0000018', 'P0000019', 'S0002', '2019-08-31', 20, 100.00, 120.00, 2000.00, 0, 0.00, '2019-08-31', 1),
('K0000019', 'P0000020', 'S0002', '2019-08-31', 30, 85.00, 100.00, 2550.00, 0, 0.00, '2019-08-31', 1),
('K0000020', 'P0000015', 'S0003', '2019-09-05', 5, 70.00, 120.00, 350.00, 0, 0.00, '2019-09-05', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_billing_info`
--

CREATE TABLE `tbl_billing_info` (
  `bill_id` int(11) NOT NULL,
  `cus_id` char(5) NOT NULL,
  `session_id` varchar(26) DEFAULT NULL,
  `bill_fname` varchar(100) NOT NULL,
  `bill_lname` varchar(100) NOT NULL,
  `bill_comp` varchar(50) NOT NULL,
  `bill_add1` varchar(100) NOT NULL,
  `bill_add2` varchar(100) NOT NULL,
  `bill_city` varchar(100) NOT NULL,
  `bill_prov` varchar(100) NOT NULL,
  `bill_tel` char(10) NOT NULL,
  `bill_email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_billing_info`
--

INSERT INTO `tbl_billing_info` (`bill_id`, `cus_id`, `session_id`, `bill_fname`, `bill_lname`, `bill_comp`, `bill_add1`, `bill_add2`, `bill_city`, `bill_prov`, `bill_tel`, `bill_email`) VALUES
(1, '', '91u91bav3ca7uqa14snqmfno65', 'Saduni', 'Silva', '', '1/57', 'Agunawala', 'peradeniya', 'PROV2', '775059818', 'sadunisilva1@gmail.com'),
(3, 'Z0005', '', 'Saduni', 'Silva', '', '1/57', 'Angunawala', 'Peradeniya', 'PROV2', '0812387635', 'ss@gmail.com'),
(4, '', '5llfd7fpo6o7i7gt9me6oivpj5', 'Manil', 'Silva', '', '44', 'Ambagamuwa Road', 'Gampola', 'PROV2', '812352302', 'ms@ymail.com'),
(5, 'Z0006', '', 'Namal ', 'Weerasinghe', '', 'No. 56/A', 'Hill Street', 'Kiribathgoda', 'PROV1', '0112910893', 'namalrocks@gmail.com'),
(6, 'Z0007', '', 'Manel', 'Bandara', '', 'No.24', 'Samatha Mawatha', 'Kiribathkubura', 'PROV2', '0812876980', 'manel@ymail.com'),
(7, '', '006si7a6t5jvcisa7r0hg5i4i3', 'Mariam', 'Shamy', '', '55A', 'Malwatha Road', 'Rathmalkaduwa', 'PROV2', '0718799702', 'mariamS@gmail.com'),
(8, 'Z0013', NULL, 'Lalendra', 'Silva', 'Home', 'Colombo', 'Colombo', 'Colombo', 'PROV1', '7777777777', 'lal@gmail.com'),
(9, 'Z0014', NULL, 'Suranjan', 'Suranjan', 'Home', 'Colombo', 'Colombo', 'Colombo', 'PROV1', '0111111111', 'suranjan@gmail.com'),
(10, 'Z0016', NULL, 'Kasun', 'Ketawala', '', 'No.456/4/6,School Road,Gohagoda,Katugastota', 'Central', 'Kandy', 'PROV2', '0777777777', 'kasunsmbox@hotmail.com'),
(11, 'Z0017', NULL, 'Suranjan', 'Indika', 'asd', 'line1', 'line2', 'Gampaha', 'PROV1', '0722290072', 'suranjan072@gmail.com'),
(12, 'Z0018', NULL, 'Suranjan', 'Indika', 'asd', 'line1', 'line2', 'Gampaha', 'PROV1', '0722290072', 'suranjan072@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_brand`
--

CREATE TABLE `tbl_brand` (
  `brand_id` char(5) NOT NULL,
  `brand_name` varchar(100) NOT NULL,
  `brand_stat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_brand`
--

INSERT INTO `tbl_brand` (`brand_id`, `brand_name`, `brand_stat`) VALUES
('B0001', 'Nike', 1),
('B0002', 'Puma', 1),
('B0003', 'Hameedia ', 1),
('B0004', 'Tommy Hilfiger', 1),
('B0005', 'Armani', 1),
('B0006', 'Gucci ', 1),
('B0007', 'Levi Strauss', 1),
('B0008', 'Adidas ', 1),
('B0009', 'Diesel', 1),
('B0010', 'Calvin Klein', 1),
('B0011', 'Polo Ralph Lauren', 1),
('B0012', 'DSI', 1),
('B0013', 'Reebok', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `cart_id` int(11) NOT NULL,
  `prd_id` char(8) NOT NULL,
  `cus_id` char(5) NOT NULL,
  `session_id` varchar(26) NOT NULL,
  `date_time` datetime NOT NULL,
  `cart_qnty` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_cart`
--

INSERT INTO `tbl_cart` (`cart_id`, `prd_id`, `cus_id`, `session_id`, `date_time`, `cart_qnty`) VALUES
(2, 'P0000001', '', '5mv865rq2cl695aimoqs0otem5', '2019-06-13 15:37:13', 5),
(3, 'P0000002', '', '5mv865rq2cl695aimoqs0otem5', '2019-06-13 15:38:04', 1),
(4, 'P0000003', '', '5mv865rq2cl695aimoqs0otem5', '2019-06-14 12:02:02', 3),
(7, 'P0000001', '', 'agtd5bu1rkdc3jp3vcmar01g74', '2019-06-20 00:15:29', 1),
(8, 'P0000003', '', '7rhs9nnvj7i6ldd1ss6f6otlq1', '2019-06-20 09:27:15', 1),
(30, 'P0000001', '', '06ldmbj757rf4ih6hquhp3i1j6', '2019-06-20 16:54:22', 3),
(31, 'P0000004', '', '06ldmbj757rf4ih6hquhp3i1j6', '2019-06-20 16:54:36', 1),
(38, 'P0000001', '', '25cdkl1ksei6f4actfi7miqsg0', '2019-06-24 16:22:51', 1),
(43, 'P0000001', '', '91u91bav3ca7uqa14snqmfno65', '2019-07-01 10:20:35', 1),
(44, 'P0000001', '', 'bl94ufl25lksnpt04p431taj26', '2019-07-02 10:58:26', 1),
(45, 'P0000001', '', 'qdf3kddni5fb32rpoc38fv60m0', '2019-07-09 12:03:29', 1),
(46, 'P0000001', '', 'm0bv6hpahica288r5u8co7q6t1', '2019-07-31 12:59:18', 1),
(48, 'P0000004', '', 'okk9shp7h6vsp8cc72q14kect5', '2019-08-02 12:45:03', 2),
(49, 'P0000001', '', 'vl2io0lj7frs9hbld1lv3rhpr1', '2019-08-07 16:34:37', 1),
(50, 'P0000002', '', 'at75jf7irjj15goa8o8uqmdsv6', '2019-08-14 13:01:13', 2),
(53, 'P0000001', 'Z0009', '', '2019-08-24 13:43:53', 1),
(54, 'P0000003', 'Z0009', '', '2019-08-24 13:44:39', 1),
(55, 'P0000003', '', '72rbd87056899taiuk9b3di8a3', '2019-08-25 12:35:15', 1),
(59, 'P0000006', '', 's23q1vija0a32p8gqrlq8vvoo2', '2019-08-29 21:51:48', 1),
(60, 'P0000005', 'Z0010', '', '2019-08-30 11:18:09', 1),
(63, 'P0000005', '', 'fti88a2jutvqgr2og9oul538c4', '2019-09-02 22:32:19', 1),
(66, 'P0000020', '', 'hnd3ft1fror3emker3mdk50mr3', '2019-09-05 16:00:54', 1),
(67, 'P0000005', 'Z0013', '', '2019-09-10 14:22:26', 1),
(68, 'P0000007', 'Z0013', '', '2019-09-10 14:22:53', 1),
(69, 'P0000003', 'Z0014', '', '2019-10-17 19:30:00', 1),
(70, 'P0000010', '', '9ahbhfq4sna72f035le986irbb', '2019-11-30 17:57:31', 1),
(71, 'P0000006', 'Z0018', '', '2019-12-05 06:48:17', 4),
(72, 'P0000005', 'Z0018', '', '2019-12-05 06:48:22', 1),
(73, 'P0000007', '', 'dcatbkj4jo3g2kea29tqe7rtk1', '2019-12-07 19:36:45', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `cat_id` char(5) NOT NULL,
  `cat_name` varchar(100) NOT NULL,
  `cat_stat` tinyint(1) NOT NULL,
  `cat_super_cat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`cat_id`, `cat_name`, `cat_stat`, `cat_super_cat`) VALUES
('C0001', 'Shoes', 1, 'Foot Wears'),
('C0002', 'Shirts', 1, 'Smart Casual'),
('C0003', 'Trousers', 1, 'Trousers'),
('C0004', 'T Shirts', 1, 'Smart Casual'),
('C0005', 'Slippers', 1, 'Foot Wears'),
('C0006', 'Jeans', 1, 'Trousers'),
('C0007', 'Office Wear', 1, 'Casual Wears');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cat_feature`
--

CREATE TABLE `tbl_cat_feature` (
  `cat_feature_id` int(11) NOT NULL,
  `cat_id` char(5) NOT NULL,
  `cat_feature` varchar(100) NOT NULL,
  `feature_stat` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_cat_feature`
--

INSERT INTO `tbl_cat_feature` (`cat_feature_id`, `cat_id`, `cat_feature`, `feature_stat`) VALUES
(57, 'C0001', 'Colour', 1),
(59, 'C0002', 'Size', 1),
(60, 'C0002', 'Type', 1),
(63, 'C0003', 'Size', 1),
(64, 'C0003', 'Type', 1),
(70, 'C0005', 'Size', 1),
(74, 'C0006', 'Size', 1),
(76, 'C0006', 'Type', 1),
(77, 'C0007', 'Size', 1),
(78, 'C0007', 'Type', 1),
(81, 'C0001', 'Type', 1),
(82, 'C0004', 'Size', 1),
(83, 'C0004', 'Type', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `cus_id` char(5) NOT NULL,
  `cus_fname` varchar(50) DEFAULT NULL,
  `cus_lname` varchar(50) DEFAULT NULL,
  `cus_company` varchar(200) DEFAULT NULL,
  `cus_add` varchar(200) DEFAULT NULL,
  `cus_add2` varchar(200) DEFAULT NULL,
  `cus_city` varchar(100) DEFAULT NULL,
  `cus_province` char(5) DEFAULT NULL,
  `cus_tel` char(10) DEFAULT NULL,
  `cus_email` varchar(100) NOT NULL,
  `cus_gen` tinyint(1) DEFAULT NULL,
  `cus_pass` varchar(50) NOT NULL,
  `cus_online` smallint(1) DEFAULT NULL COMMENT 'online=1 offline=0',
  `cus_stat` smallint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`cus_id`, `cus_fname`, `cus_lname`, `cus_company`, `cus_add`, `cus_add2`, `cus_city`, `cus_province`, `cus_tel`, `cus_email`, `cus_gen`, `cus_pass`, `cus_online`, `cus_stat`) VALUES
('Z0001', 'Tharaka', 'Silva', '', 'No23, Udahamulla Rd,Peradeniya', '', '', '', '0722059818', 'tharasilva@ymail.com', 1, '', 0, 1),
('Z0003', 'Hasith', 'Bandara', '', '23,Hansa Mw,Kelaniya', '', '', '', '0720201641', 'hasith@yahoo.com', 1, '', 0, 0),
('Z0005', 'Harshika', 'Silva', '', '1/57,Sinharamulla,Kelaniya', 'Angunawala', 'Peradeniya', '', '0112387635', 'harshika@gmail.com', 0, '112a32c44e735a1da6a4f835a673b634', 1, 1),
('Z0006', 'Namal', 'Weerasighe', '', 'No.56/A,Pathima Mawatha,Kiribathgoda', 'Hill street', 'Kiribathgoda', '', '0112345346', 'namalrocks@gmail.com', 1, '7d9e562dda2cfb7904776df67ac8a9d3', 1, 1),
('Z0007', 'Manel', 'Bandara', '', '24,Nagahamua junc,Gonawala', 'samatha mawatha', 'Kiribathkubura', '', '0722359271', 'manel@ymail.com', 0, 'c2f9b9429aafaec8add76bf1a629fcd8', 1, 1),
('Z0008', 'Iresha', 'Abesinghe', '', 'No.13,Jayawrdhana place,Kelaniya', '', '', '', '0112645827', 'iresha@yahoo.com', 0, '', 0, 0),
('Z0010', 'Supun', 'Silva', '', '22,ABC rd,Kiribathgoda', 'baseline road', 'Kandy', '', '0785555666', 'supun@gmail.com', 0, '2048305227552fc0007c261e926efde2', 1, 1),
('Z0011', 'Naween', 'Soysa', '', 'No23,4 kanuwa,Nawalapitiya', '', '', '', '0777123456', 'naween@yahoo.com', 1, '', 0, 0),
('Z0016', 'Bla', 'Bla', NULL, 'Gampaha', 'Gampaha', 'Gampaha', NULL, '0777777777', 'kasunsmbox@hotmail.com', 1, 'ecfa6ea068f046a0d907b376fe7840a6', 1, 1),
('Z0020', 'Suranjan', 'Indika', NULL, '207/21A,Pamunuwila,Gonawala', 'line2', 'Gampaha', NULL, '0722290072', 'suranjan072@gmail.com', 1, '69cf3207d7c4ffec6bac74044f812445', 1, 1),
('Z0021', 'sas', 'sas', NULL, 'sas', NULL, NULL, NULL, NULL, '', 1, '', NULL, NULL),
('Z0022', 'sa', 'sa', NULL, 'sa', NULL, NULL, NULL, NULL, '', 1, '', NULL, NULL),
('Z0023', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'hasith@yahoo.com', NULL, '25d55ad283aa400af464c76d713c07ad', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emp`
--

CREATE TABLE `tbl_emp` (
  `emp_id` char(5) NOT NULL,
  `emp_fname` varchar(50) NOT NULL,
  `emp_lname` varchar(50) NOT NULL,
  `emp_nic` char(10) NOT NULL,
  `emp_gen` smallint(1) NOT NULL COMMENT 'male=1 female=0',
  `emp_add` varchar(200) NOT NULL,
  `emp_tel` char(10) NOT NULL,
  `emp_email` varchar(100) NOT NULL,
  `emp_job_id` char(5) NOT NULL,
  `emp_uname` varchar(50) NOT NULL,
  `emp_pass` varchar(50) NOT NULL,
  `emp_stat` smallint(1) NOT NULL COMMENT 'active=1 inactive=0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_emp`
--

INSERT INTO `tbl_emp` (`emp_id`, `emp_fname`, `emp_lname`, `emp_nic`, `emp_gen`, `emp_add`, `emp_tel`, `emp_email`, `emp_job_id`, `emp_uname`, `emp_pass`, `emp_stat`) VALUES
('E0001', 'Lalindra', 'Silva', '562973451V', 1, '44, Ambagamuwa road, Gampola', '0812352302', 'lsilva@gmail.com', 'J0001', 'lsilva@gmail.com', '112a32c44e735a1da6a4f835a673b634', 1),
('E0002', 'Kolitha', 'Wikramasinghe', '689746579V', 1, '233B, Rathmalkaduwa,Gampola', '0718799702', 'kolithaW@gmail.com', 'J0002', 'kolithaW@gmail.com', '112a32c44e735a1da6a4f835a673b634', 1),
('E0003', 'Suren', 'Abesinghe', '678975687V', 1, 'Bothalapitiya', '0714567859', 'suren@yahoo.com', 'J0003', 'Suren', 'b5345edb82eac237284d6e5b90dc7aed', 1),
('E0004', 'Kaweesha', 'Herath', '893685698V', 0, 'Singhepitiya Gampola', '0758744905', 'kaweesha@gmail.com', 'J0003', 'Kaweesha', '32d9dea66b33fb4c5fe391b1f918dcf8', 1),
('E0005', 'Sumana', 'Thennakoon', '877869879V', 0, 'Jayamalapura', '0722290071', 'sumana@yahoo.com', 'J0003', 'Sumana', '112a32c44e735a1da6a4f835a673b634', 1),
('E0006', 'Suranjan', 'Silva', '777777777V', 1, 'Kelaniya', '0777777777', 'suranjan072@gmail.com', 'J0001', 'Suranjan', '195e12caebc36ca6f33195ab47c3f3f2', 1),
('E0007', 'User', 'User', '898989898V', 1, 'Colombo', '0711225588', 'user@gmail.com', 'J0002', 'user1', 'e10adc3949ba59abbe56e057f20f883e', 1),
('E0008', 'User2', 'User2', '788989898V', 1, 'Colombo', '0711225588', 'user2@gmail.com', 'J0003', 'user2', 'e10adc3949ba59abbe56e057f20f883e', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expense`
--

CREATE TABLE `tbl_expense` (
  `exp_id` char(5) NOT NULL,
  `exp_type` char(3) NOT NULL,
  `exp_pdate` date NOT NULL,
  `exp_amount` double(20,2) NOT NULL,
  `exp_stat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_expense`
--

INSERT INTO `tbl_expense` (`exp_id`, `exp_type`, `exp_pdate`, `exp_amount`, `exp_stat`) VALUES
('X0001', 'ex1', '2019-06-22', 655.00, 1),
('X0002', 'ex1', '2019-12-04', 2500.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expense_type`
--

CREATE TABLE `tbl_expense_type` (
  `exp_type_id` char(3) NOT NULL,
  `exp_type` varchar(100) NOT NULL,
  `exp_stat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_expense_type`
--

INSERT INTO `tbl_expense_type` (`exp_type_id`, `exp_type`, `exp_stat`) VALUES
('ex1', 'Electricity', 1),
('ex2', 'Water', 1),
('ex3', 'Telephone', 1),
('ex4', 'Internet', 1),
('ex5', 'Tax', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice`
--

CREATE TABLE `tbl_invoice` (
  `inv_id` char(10) NOT NULL COMMENT 'INV0000001',
  `inv_date` date NOT NULL,
  `inv_cus_id` char(5) NOT NULL,
  `inv_session_id` varchar(26) NOT NULL,
  `inv_gtot` double(20,2) NOT NULL,
  `inv_disc` double(5,2) NOT NULL,
  `ship_cost` double(20,2) NOT NULL COMMENT 'only for online sales',
  `inv_ntot` double(20,2) NOT NULL,
  `inv_emp_id` char(5) NOT NULL,
  `inv_online` tinyint(1) NOT NULL COMMENT 'online=1 offline=0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_invoice`
--

INSERT INTO `tbl_invoice` (`inv_id`, `inv_date`, `inv_cus_id`, `inv_session_id`, `inv_gtot`, `inv_disc`, `ship_cost`, `inv_ntot`, `inv_emp_id`, `inv_online`) VALUES
('INV0000001', '2019-07-01', 'Z0005', '', 5500.00, 0.00, 10.00, 5510.00, '', 1),
('INV0000002', '2019-07-02', 'Z0003', '', 7200.00, 0.00, 0.00, 7200.00, 'E0002', 0),
('INV0000003', '2019-07-02', 'Z0005', '', 950.00, 0.00, 10.00, 960.00, '', 1),
('INV0000004', '2019-08-04', 'Z0006', '', 760.00, 0.00, 20.00, 780.00, '', 1),
('INV0000005', '2019-08-14', 'Z0002', '', 760.00, 0.00, 0.00, 760.00, 'E0004', 0),
('INV0000006', '2019-08-20', 'Z0011', '', 12050.00, 2.00, 0.00, 11809.00, 'E0004', 0),
('INV0000007', '2019-09-01', 'Z0006', '', 600.00, 0.00, 20.00, 620.00, '', 1),
('INV0000008', '2019-09-01', 'Z0007', '', 770.00, 0.00, 10.00, 780.00, '', 1),
('INV0000009', '2019-09-01', 'Z0008', '', 6000.00, 0.00, 0.00, 6000.00, 'E0004', 0),
('INV0000010', '2019-09-01', 'Z0005', '', 7200.00, 0.00, 10.00, 7210.00, '', 1),
('INV0000011', '2019-09-02', 'Z0008', '', 100.00, 0.00, 0.00, 100.00, 'E0004', 0),
('INV0000012', '2019-09-02', 'Z0012', '', 760.00, 0.00, 0.00, 760.00, 'E0004', 0),
('INV0000013', '2019-09-02', 'Z0005', '', 12050.00, 0.00, 10.00, 12060.00, '', 1),
('INV0000014', '2019-09-02', 'Z0004', '', 5250.00, 0.00, 0.00, 5250.00, 'E0003', 0),
('INV0000015', '2019-09-02', 'Z0003', '', 12050.00, 0.00, 0.00, 12050.00, 'E0003', 0),
('INV0000016', '2019-09-03', 'Z0006', '', 1200.00, 0.00, 0.00, 1200.00, 'E0002', 0),
('INV0000017', '2019-09-03', 'Z0005', '', 7250.00, 0.00, 10.00, 7260.00, '', 1),
('INV0000018', '2019-09-05', 'Z0005', '', 6250.00, 0.00, 10.00, 6260.00, '', 1),
('INV0000019', '2019-09-05', 'Z0005', '', 50.00, 0.00, 10.00, 60.00, '', 1),
('INV0000020', '2019-09-05', 'Z0005', '', 25.00, 0.00, 10.00, 35.00, '', 1),
('INV0000024', '2019-12-04', 'Z0017', '', 12500.00, 0.00, 20.00, 12520.00, '', 1),
('INV0000025', '2019-12-04', 'Z0017', '', 12500.00, 0.00, 20.00, 12520.00, '', 1),
('INV0000026', '2019-12-04', 'Z0017', '', 12500.00, 0.00, 20.00, 12520.00, '', 1),
('INV0000027', '2019-12-07', 'Z0010', '', 0.00, 0.00, 0.00, 0.00, 'E0007', 0),
('INV0000028', '2019-12-07', 'Z0010', '', 0.00, 0.00, 0.00, 0.00, 'E0007', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inv_info`
--

CREATE TABLE `tbl_inv_info` (
  `inv_info_id` int(11) NOT NULL,
  `inv_id` char(10) NOT NULL,
  `inv_date` date NOT NULL,
  `prd_id` char(8) NOT NULL,
  `prd_u_price` double(20,2) NOT NULL,
  `inv_prd_qnty` int(11) NOT NULL,
  `inv_prd_tot` double(20,2) NOT NULL,
  `inv_online` tinyint(1) NOT NULL COMMENT 'online=1 offline=0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_inv_info`
--

INSERT INTO `tbl_inv_info` (`inv_info_id`, `inv_id`, `inv_date`, `prd_id`, `prd_u_price`, `inv_prd_qnty`, `inv_prd_tot`, `inv_online`) VALUES
(23, 'INV0000001', '2019-07-01', 'P0000001', 5500.00, 1, 5500.00, 1),
(24, 'INV0000002', '2019-07-02', 'P0000005', 7200.00, 1, 7200.00, 0),
(25, 'INV0000003', '2019-07-02', 'P0000012', 950.00, 1, 950.00, 1),
(26, 'INV0000004', '2019-09-09', 'P0000011', 760.00, 1, 760.00, 1),
(27, 'INV0000005', '2019-08-14', 'P0000011', 760.00, 1, 760.00, 0),
(28, 'INV0000006', '2019-08-29', 'P0000013', 12050.00, 1, 12050.00, 0),
(29, 'INV0000007', '2019-09-01', 'P0000007', 600.00, 1, 600.00, 1),
(30, 'INV0000008', '2019-09-01', 'P0000008', 670.00, 1, 670.00, 1),
(31, 'INV0000008', '2019-09-01', 'P0000020', 100.00, 1, 100.00, 1),
(32, 'INV0000009', '2019-09-01', 'P0000003', 6000.00, 1, 6000.00, 1),
(33, 'INV0000010', '2019-09-01', 'P0000005', 7200.00, 1, 7200.00, 0),
(34, 'INV0000011', '2019-09-02', 'P0000020', 100.00, 1, 100.00, 0),
(35, 'INV0000012', '2019-09-02', 'P0000011', 760.00, 1, 760.00, 0),
(36, 'INV0000013', '2019-09-02', 'P0000013', 12050.00, 1, 12050.00, 1),
(37, 'INV0000014', '2019-09-02', 'P0000004', 5250.00, 1, 5250.00, 0),
(38, 'INV0000015', '2019-09-02', 'P0000013', 12050.00, 1, 12050.00, 0),
(39, 'INV0000016', '2019-09-03', 'P0000007', 600.00, 2, 1200.00, 0),
(40, 'INV0000017', '2019-09-03', 'P0000006', 50.00, 1, 50.00, 0),
(41, 'INV0000017', '2019-09-03', 'P0000005', 7200.00, 1, 7200.00, 0),
(42, 'INV0000018', '2019-09-05', 'P0000002', 6250.00, 1, 6250.00, 0),
(43, 'INV0000019', '2019-09-05', 'P0000006', 50.00, 1, 50.00, 0),
(44, 'INV0000020', '2019-09-05', 'P0000014', 25.00, 1, 25.00, 0),
(45, 'INV0000021', '2019-09-05', 'P0000010', 830.00, 1, 830.00, 0),
(46, 'INV0000022', '2019-11-30', 'P0000003', 6000.00, 2, 12000.00, 0),
(47, 'INV0000023', '2019-11-30', 'P0000003', 6000.00, 1, 6000.00, 0),
(48, 'INV0000024', '2019-12-04', 'P0000002', 6250.00, 2, 12500.00, 0),
(49, 'INV0000025', '2019-12-04', 'P0000002', 6250.00, 2, 12500.00, 0),
(50, 'INV0000026', '2019-12-04', 'P0000002', 6250.00, 2, 12500.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_job`
--

CREATE TABLE `tbl_job` (
  `job_id` char(5) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `job_stat` smallint(1) NOT NULL COMMENT 'active=1 inactive=0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_job`
--

INSERT INTO `tbl_job` (`job_id`, `job_title`, `job_stat`) VALUES
('J0001', 'Owner', 1),
('J0002', 'Manager', 1),
('J0003', 'Sales Representative', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_prd_info`
--

CREATE TABLE `tbl_prd_info` (
  `pi_id` int(11) NOT NULL,
  `prd_id` char(8) NOT NULL,
  `pi_type` varchar(100) NOT NULL,
  `pi_data` varchar(150) NOT NULL,
  `pi_stat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_prd_info`
--

INSERT INTO `tbl_prd_info` (`pi_id`, `prd_id`, `pi_type`, `pi_data`, `pi_stat`) VALUES
(79, 'P0000020', 'Watt', '3W', 1),
(80, 'P0000020', 'Warrenty', '3 Months', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `prd_id` char(8) NOT NULL,
  `prd_name` varchar(50) NOT NULL,
  `cat_id` char(5) NOT NULL,
  `brand_id` char(5) NOT NULL,
  `prd_img_path` varchar(150) NOT NULL,
  `prd_tot_qnty` int(5) NOT NULL,
  `prd_price` double(20,2) NOT NULL,
  `prd_online_reserved` int(5) NOT NULL,
  `prd_reorder_lvl` int(5) NOT NULL,
  `prd_waste_qnty` int(5) NOT NULL,
  `prd_stat` tinyint(1) NOT NULL COMMENT 'enable=1 disable=0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`prd_id`, `prd_name`, `cat_id`, `brand_id`, `prd_img_path`, `prd_tot_qnty`, `prd_price`, `prd_online_reserved`, `prd_reorder_lvl`, `prd_waste_qnty`, `prd_stat`) VALUES
('P0000001', 'Nike Air Max', 'C0001', 'B0001', 'P0000001_1573227504.jpg', 9, 5500.00, 0, 5, 1, 1),
('P0000002', 'Nike Air Max Motion', 'C0001', 'B0001', 'P0000002_1573227706.jpg', 5, 6250.00, 0, 7, 0, 1),
('P0000003', 'Puma Axelion Running Shoes', 'C0001', 'B0002', 'P0000003_1573227829.jpg', 6, 6000.00, 0, 5, 0, 1),
('P0000004', 'Puma Suede Classic', 'C0001', 'B0002', 'P0000004_1573227996.jpg', 9, 5250.00, 0, 6, 0, 1),
('P0000005', 'TH Shirt', 'C0002', 'B0004', 'P0000005_1575112951.jpg', 12, 7200.00, 0, 10, 0, 1),
('P0000006', 'Armani Shirt', 'C0002', 'B0005', 'P0000006_1575112897.jpg', 28, 50.00, 0, 20, 1, 1),
('P0000007', 'Gucci Trouser', 'C0003', 'B0006', 'P0000007_1575113100.jpg', 7, 600.00, 0, 6, 0, 1),
('P0000008', 'LS Co T Shirt', 'C0004', 'B0007', 'P0000008_1575113379.jpg', 9, 670.00, 0, 5, 0, 1),
('P0000009', 'LS Co Long Sleeves Shirt', 'C0004', 'B0007', 'P0000009_1575113449.jpg', 10, 750.00, 0, 5, 0, 1),
('P0000010', 'Adidas Slippers', 'C0005', 'B0008', 'P0000010_1575113550.jpg', 11, 830.00, 0, 3, 0, 1),
('P0000011', 'Adidas Slippers', 'C0005', 'B0008', 'P0000011_1575113668.jpg', 9, 760.00, 0, 7, 0, 1),
('P0000012', 'G Trouser', 'C0003', 'B0006', 'P0000012_1575113818.jpeg', 9, 950.00, 0, 6, 0, 1),
('P0000013', 'Diesel Denim', 'C0006', 'B0009', 'P0000013_1575113970.jpg', 3, 12050.00, 0, 3, 0, 1),
('P0000014', 'CK Denim', 'C0006', 'B0010', 'P0000014_1575114113.jpg', 59, 25.00, 0, 45, 0, 1),
('P0000015', 'Armani Short Denim', 'C0006', 'B0005', 'P0000015_1575114289.jpg', 25, 120.00, 0, 20, 0, 1),
('P0000016', 'Armani Ripped Denim', 'C0006', 'B0005', 'P0000016_1575114789.jpg', 25, 120.00, 0, 20, 0, 1),
('P0000017', 'Armani Colorful Jeans', 'C0006', 'B0005', 'P0000017_1575114912.jpg', 20, 95.00, 0, 10, 0, 1),
('P0000018', 'CK Office Wear Men', 'C0007', 'B0010', 'P0000018_1575115060.jpg', 50, 35.00, 0, 40, 0, 1),
('P0000019', 'Polo Ralph Lauren Office Wears Women', 'C0007', 'B0011', 'P0000019_1575115171.jpg', 20, 120.00, 0, 10, 0, 1),
('P0000020', 'GUCCI 102', 'C0001', 'B0006', 'P0000020_1575725377.jpg', 0, 0.00, 0, 100, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_province`
--

CREATE TABLE `tbl_province` (
  `prov_id` char(5) NOT NULL COMMENT 'prov1',
  `Prov_name` varchar(100) NOT NULL,
  `ship_cost` double(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_province`
--

INSERT INTO `tbl_province` (`prov_id`, `Prov_name`, `ship_cost`) VALUES
('PROV1', 'Western', 20.00),
('PROV2', 'Central', 10.00),
('PROV3', 'Southern', 30.00),
('PROV4', 'Eastern', 35.00),
('PROV5', 'Northern', 45.00),
('PROV6', 'North Central', 30.00),
('PROV7', 'North West', 40.00),
('PROV8', 'Sabaragamu', 25.00),
('PROV9', 'Uva', 30.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_return`
--

CREATE TABLE `tbl_purchase_return` (
  `pur_retrn_id` char(9) NOT NULL,
  `prd_id` char(8) NOT NULL,
  `pur_retrn_qnty` int(10) NOT NULL,
  `sup_id` char(5) NOT NULL,
  `date_added` date NOT NULL,
  `pur_retrn_stat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_purchase_return`
--

INSERT INTO `tbl_purchase_return` (`pur_retrn_id`, `prd_id`, `pur_retrn_qnty`, `sup_id`, `date_added`, `pur_retrn_stat`) VALUES
('SR0000001', 'P0000007', 1, 'S0004', '2019-09-05', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sales_return`
--

CREATE TABLE `tbl_sales_return` (
  `sal_retrn_id` char(9) NOT NULL COMMENT 'SR000001',
  `sal_retrn_date` date NOT NULL,
  `inv_id` char(10) NOT NULL,
  `prd_id` char(8) NOT NULL,
  `sal_retrn_qnty` int(5) NOT NULL,
  `sal_retrn_prd_price` double(20,2) NOT NULL,
  `sal_retrn_qlity_stat` tinyint(1) NOT NULL COMMENT 'waste=1 addtosell=2 purchasereturn=3'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_sales_return`
--

INSERT INTO `tbl_sales_return` (`sal_retrn_id`, `sal_retrn_date`, `inv_id`, `prd_id`, `sal_retrn_qnty`, `sal_retrn_prd_price`, `sal_retrn_qlity_stat`) VALUES
('SR0000001', '2019-09-05', 'INV0000016', 'P0000007', 1, 600.00, 3),
('SR0000002', '2019-12-07', 'INV0000001', 'P0000001', 1, 5500.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ship_info`
--

CREATE TABLE `tbl_ship_info` (
  `ship_id` int(11) NOT NULL,
  `cus_id` char(5) NOT NULL,
  `session_id` varchar(26) NOT NULL,
  `ship_fname` varchar(100) NOT NULL,
  `ship_lname` varchar(100) NOT NULL,
  `ship_comp` varchar(50) NOT NULL,
  `ship_add1` varchar(100) NOT NULL,
  `ship_add2` varchar(100) NOT NULL,
  `ship_city` varchar(100) NOT NULL,
  `ship_prov` varchar(100) NOT NULL,
  `ship_tel` char(10) NOT NULL,
  `ship_email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_ship_info`
--

INSERT INTO `tbl_ship_info` (`ship_id`, `cus_id`, `session_id`, `ship_fname`, `ship_lname`, `ship_comp`, `ship_add1`, `ship_add2`, `ship_city`, `ship_prov`, `ship_tel`, `ship_email`) VALUES
(1, '', '91u91bav3ca7uqa14snqmfno65', 'Saduni', 'Silva', '', '1/57', 'Agunawala', 'Peradeniya', 'PROV2', '812387635', 'sadunisilva@ymail.com'),
(4, 'Z0005', '', 'Saduni', 'Silva', '', '1/57', 'Angunawala', 'Peradeniya', 'PROV2', '0812387635', 'ss@gmail.com'),
(5, '', '5llfd7fpo6o7i7gt9me6oivpj5', 'Manil', 'Silva', '', '44', 'Ambagamuwa Road', 'Gampola', 'PROV2', '812352302', 'ms@ymail.com'),
(6, 'Z0006', '', 'Namal ', 'Weerasinghe', '', 'No. 56/A', 'Hill Street', 'Kiribathgoda', 'PROV1', '0112910893', 'namalrocks@gmail.com'),
(7, 'Z0007', '', 'Manel', 'Bandara', '', 'No.24', 'Samatha Mawatha', 'Kiribathkubura', 'PROV2', '0812876980', 'manel@ymail.com'),
(8, '', '006si7a6t5jvcisa7r0hg5i4i3', 'Mariam', 'Shamy', '', '55A', 'Malwatha Road', 'Rathmalkaduwa', 'PROV2', '0718799702', 'mariamS@gmail.com'),
(9, 'Z0014', '', 'Suranjan', 'Suranjan', 'Home', 'Colombo', 'Colombo', 'Colombo', 'PROV1', '0111111111', 'suranjan@gmail.com'),
(10, 'Z0016', '', 'Kasun', 'Ketawala', '', 'No.456/4/6,School Road,Gohagoda,Katugastota', 'Central', 'Kandy', 'PROV2', '0777777777', 'kasunsmbox@hotmail.com'),
(11, 'Z0017', '', 'Suranjan', 'Indika', 'asd', 'line1', 'line2', 'Gampaha', 'PROV1', '0722290072', 'suranjan072@gmail.com'),
(12, 'Z0018', '', 'Suranjan', 'Indika', 'asd', 'line1', 'line2', 'Gampaha', 'PROV1', '0722290072', 'suranjan072@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `sup_id` char(5) NOT NULL,
  `sup_fname` varchar(50) NOT NULL,
  `sup_lname` varchar(50) NOT NULL,
  `sup_comp` varchar(50) NOT NULL,
  `sup_gen` tinyint(1) NOT NULL,
  `sup_add` varchar(100) NOT NULL,
  `sup_tel` char(10) NOT NULL,
  `sup_email` varchar(100) NOT NULL,
  `sup_stat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`sup_id`, `sup_fname`, `sup_lname`, `sup_comp`, `sup_gen`, `sup_add`, `sup_tel`, `sup_email`, `sup_stat`) VALUES
('S0001', 'Mohammed', 'Faheem', 'CrystalWatch', 1, '44,1st cross lane,pettah', '112376543', '', 1),
('S0002', 'Ansar', 'Mohammed', 'Unitec', 1, 'No.445,2nd Cross Street,Petta', '112347687', '', 1),
('S0003', 'Malan', 'Serasinghe', 'Kandy & Co', 1, 'No. 231/A, Kotugodalla Veediya,Kandy', '112347687', '', 1),
('S0004', 'Nimal', 'Perera', 'Tesco', 1, '457/B,1st cross street,Petta', '112347687', '', 1),
('S0005', 'Srimal', 'Wijethilaka', 'S and Sons', 1, 'Kurunegala', '0112347687', '', 1),
('S0006', 'Ruwan', 'buddika', 'Arpico', 1, 'addre', '0722290071', 'ruwan@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_wishlist`
--

CREATE TABLE `tbl_wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `prd_id` char(8) NOT NULL,
  `cus_id` char(5) NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_wishlist`
--

INSERT INTO `tbl_wishlist` (`wishlist_id`, `prd_id`, `cus_id`, `date_time`) VALUES
(11, 'P0000002', 'Z0010', '2019-08-30 11:34:02'),
(13, 'P0000002', 'Z0005', '2019-08-30 19:39:30'),
(14, 'P0000007', 'Z0005', '2019-08-30 19:39:54'),
(15, 'P0000005', 'Z0013', '2019-09-10 14:22:28'),
(16, 'P0000007', 'Z0013', '2019-09-10 14:22:49'),
(17, 'P0000007', 'Z0014', '2019-10-17 19:29:50'),
(18, 'P0000005', 'Z0018', '2019-12-05 06:48:02'),
(19, 'P0000006', 'Z0018', '2019-12-05 06:48:09'),
(20, 'P0000007', 'Z0019', '2019-12-05 21:55:36'),
(21, 'P0000005', 'Z0019', '2019-12-05 21:55:39'),
(22, 'P0000003', 'Z0019', '2019-12-05 21:55:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_batch`
--
ALTER TABLE `tbl_batch`
  ADD PRIMARY KEY (`batch_id`);

--
-- Indexes for table `tbl_billing_info`
--
ALTER TABLE `tbl_billing_info`
  ADD PRIMARY KEY (`bill_id`);

--
-- Indexes for table `tbl_brand`
--
ALTER TABLE `tbl_brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `tbl_cat_feature`
--
ALTER TABLE `tbl_cat_feature`
  ADD PRIMARY KEY (`cat_feature_id`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`cus_id`);

--
-- Indexes for table `tbl_emp`
--
ALTER TABLE `tbl_emp`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `tbl_expense`
--
ALTER TABLE `tbl_expense`
  ADD PRIMARY KEY (`exp_id`);

--
-- Indexes for table `tbl_expense_type`
--
ALTER TABLE `tbl_expense_type`
  ADD PRIMARY KEY (`exp_type_id`);

--
-- Indexes for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  ADD PRIMARY KEY (`inv_id`);

--
-- Indexes for table `tbl_inv_info`
--
ALTER TABLE `tbl_inv_info`
  ADD PRIMARY KEY (`inv_info_id`);

--
-- Indexes for table `tbl_job`
--
ALTER TABLE `tbl_job`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `tbl_prd_info`
--
ALTER TABLE `tbl_prd_info`
  ADD PRIMARY KEY (`pi_id`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`prd_id`);

--
-- Indexes for table `tbl_province`
--
ALTER TABLE `tbl_province`
  ADD PRIMARY KEY (`prov_id`);

--
-- Indexes for table `tbl_purchase_return`
--
ALTER TABLE `tbl_purchase_return`
  ADD PRIMARY KEY (`pur_retrn_id`);

--
-- Indexes for table `tbl_sales_return`
--
ALTER TABLE `tbl_sales_return`
  ADD PRIMARY KEY (`sal_retrn_id`);

--
-- Indexes for table `tbl_ship_info`
--
ALTER TABLE `tbl_ship_info`
  ADD PRIMARY KEY (`ship_id`);

--
-- Indexes for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`sup_id`);

--
-- Indexes for table `tbl_wishlist`
--
ALTER TABLE `tbl_wishlist`
  ADD PRIMARY KEY (`wishlist_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_billing_info`
--
ALTER TABLE `tbl_billing_info`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `tbl_cat_feature`
--
ALTER TABLE `tbl_cat_feature`
  MODIFY `cat_feature_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `tbl_inv_info`
--
ALTER TABLE `tbl_inv_info`
  MODIFY `inv_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tbl_prd_info`
--
ALTER TABLE `tbl_prd_info`
  MODIFY `pi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `tbl_ship_info`
--
ALTER TABLE `tbl_ship_info`
  MODIFY `ship_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_wishlist`
--
ALTER TABLE `tbl_wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
