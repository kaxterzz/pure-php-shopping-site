/*
SQLyog Ultimate - MySQL GUI v8.2 
MySQL - 5.5.5-10.1.30-MariaDB : Database - bt
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bt` /*!40100 DEFAULT CHARACTER SET latin1 */;

/*Table structure for table `tbl_batch` */

DROP TABLE IF EXISTS `tbl_batch`;

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
  `batch_stat` tinyint(1) NOT NULL COMMENT 'enable=1 disable=0',
  PRIMARY KEY (`batch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_batch` */

insert  into `tbl_batch`(`batch_id`,`prd_id`,`sup_id`,`batch_date`,`batch_qnty`,`batch_prd_cost_price`,`batch_prd_sell_price`,`batch_pay_amount`,`batch_on_credit`,`batch_credit_amount`,`batch_settle_date`,`batch_stat`) values ('K0000001','P0000001','S0002','2015-06-28',10,4500.00,5500.00,45000.00,1,25000.00,'2015-08-31',1),('K0000002','P0000002','S0001','2015-06-28',12,5250.00,6250.00,63000.00,1,43000.00,'2015-08-31',1),('K0000003','P0000003','S0001','2015-06-28',10,5150.00,6000.00,51500.00,1,31500.00,'2015-09-01',1),('K0000004','P0000004','S0002','2015-06-28',10,4250.00,5250.00,42500.00,0,0.00,'2015-09-01',1),('K0000005','P0000005','S0003','2015-07-04',15,6000.00,7200.00,90000.00,1,50000.00,'2015-09-05',1),('K0000006','P0000006','S0003','2015-07-04',30,20.00,50.00,600.00,1,100.00,'2015-09-05',1),('K0000007','P0000007','S0004','2015-07-04',10,350.00,600.00,3500.00,0,0.00,'2015-09-05',1),('K0000008','P0000008','S0004','2015-07-06',10,550.00,670.00,5500.00,0,0.00,'0000-00-00',1),('K0000009','P0000009','S0004','2015-07-06',10,650.00,750.00,6500.00,0,0.00,'0000-00-00',1),('K0000010','P0000010','S0004','2015-07-11',12,750.00,830.00,9000.00,1,7000.00,'2015-09-12',1),('K0000011','P0000011','S0004','2015-07-11',12,650.00,760.00,7800.00,1,5800.00,'2015-08-11',1),('K0000012','P0000012','S0002','2015-07-14',10,850.00,950.00,8500.00,0,0.00,'0000-00-00',1),('K0000013','P0000013','S0003','2015-07-24',6,10500.00,12050.00,63000.00,1,33000.00,'2015-08-31',1),('K0000014','P0000014','S0003','2015-08-27',60,10.00,25.00,600.00,0,0.00,'0000-00-00',1),('K0000015','P0000016','S0003','2015-08-27',25,70.00,120.00,1750.00,0,0.00,'0000-00-00',1),('K0000016','P0000017','S0003','2015-08-29',20,50.00,95.00,1000.00,0,0.00,'0000-00-00',1),('K0000017','P0000018','S0003','2015-08-29',50,12.00,35.00,600.00,0,0.00,'0000-00-00',1),('K0000018','P0000019','S0002','2015-08-31',20,100.00,120.00,2000.00,0,0.00,'0000-00-00',1),('K0000019','P0000020','S0002','2015-08-31',30,85.00,100.00,2550.00,0,0.00,'0000-00-00',1),('K0000020','P0000015','S0003','2015-09-05',5,70.00,120.00,350.00,0,0.00,'0000-00-00',1);

/*Table structure for table `tbl_billing_info` */

DROP TABLE IF EXISTS `tbl_billing_info`;

CREATE TABLE `tbl_billing_info` (
  `bill_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `bill_email` varchar(50) NOT NULL,
  PRIMARY KEY (`bill_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_billing_info` */

insert  into `tbl_billing_info`(`bill_id`,`cus_id`,`session_id`,`bill_fname`,`bill_lname`,`bill_comp`,`bill_add1`,`bill_add2`,`bill_city`,`bill_prov`,`bill_tel`,`bill_email`) values (1,'','91u91bav3ca7uqa14snqmfno65','Saduni','Silva','','1/57','Agunawala','peradeniya','PROV2','775059818','sadunisilva1@gmail.com'),(3,'Z0005','','Saduni','Silva','','1/57','Angunawala','Peradeniya','PROV2','0812387635','ss@gmail.com'),(4,'','5llfd7fpo6o7i7gt9me6oivpj5','Manil','Silva','','44','Ambagamuwa Road','Gampola','PROV2','812352302','ms@ymail.com'),(5,'Z0006','','Namal ','Weerasinghe','','No. 56/A','Hill Street','Kiribathgoda','PROV1','0112910893','namalrocks@gmail.com'),(6,'Z0007','','Manel','Bandara','','No.24','Samatha Mawatha','Kiribathkubura','PROV2','0812876980','manel@ymail.com'),(7,'','006si7a6t5jvcisa7r0hg5i4i3','Mariam','Shamy','','55A','Malwatha Road','Rathmalkaduwa','PROV2','0718799702','mariamS@gmail.com'),(8,'Z0013',NULL,'Lalendra','Silva','Home','Colombo','Colombo','Colombo','PROV1','7777777777','lal@gmail.com');

/*Table structure for table `tbl_brand` */

DROP TABLE IF EXISTS `tbl_brand`;

CREATE TABLE `tbl_brand` (
  `brand_id` char(5) NOT NULL,
  `brand_name` varchar(100) NOT NULL,
  `brand_stat` tinyint(1) NOT NULL,
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_brand` */

insert  into `tbl_brand`(`brand_id`,`brand_name`,`brand_stat`) values ('B0001','Bajaj',1),('B0002','Crystal Watch',1),('B0003','Usha',1),('B0004','Lark',1),('B0005','Alice',1),('B0006','Bright',1),('B0007','Tiancheng',1),('B0008','Casio',1),('B0009','Suzuki',1),('B0010','Dunlop',1),('B0011','Philips',1),('B0012','Spectrum',1);

/*Table structure for table `tbl_cart` */

DROP TABLE IF EXISTS `tbl_cart`;

CREATE TABLE `tbl_cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `prd_id` char(8) NOT NULL,
  `cus_id` char(5) NOT NULL,
  `session_id` varchar(26) NOT NULL,
  `date_time` datetime NOT NULL,
  `cart_qnty` int(5) NOT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_cart` */

insert  into `tbl_cart`(`cart_id`,`prd_id`,`cus_id`,`session_id`,`date_time`,`cart_qnty`) values (2,'P0000001','','5mv865rq2cl695aimoqs0otem5','2015-06-13 15:37:13',5),(3,'P0000002','','5mv865rq2cl695aimoqs0otem5','2015-06-13 15:38:04',1),(4,'P0000003','','5mv865rq2cl695aimoqs0otem5','2015-06-14 12:02:02',3),(7,'P0000001','','agtd5bu1rkdc3jp3vcmar01g74','2015-06-20 00:15:29',1),(8,'P0000003','','7rhs9nnvj7i6ldd1ss6f6otlq1','2015-06-20 09:27:15',1),(30,'P0000001','','06ldmbj757rf4ih6hquhp3i1j6','2015-06-20 16:54:22',3),(31,'P0000004','','06ldmbj757rf4ih6hquhp3i1j6','2015-06-20 16:54:36',1),(38,'P0000001','','25cdkl1ksei6f4actfi7miqsg0','2015-06-24 16:22:51',1),(43,'P0000001','','91u91bav3ca7uqa14snqmfno65','2015-07-01 10:20:35',1),(44,'P0000001','','bl94ufl25lksnpt04p431taj26','2015-07-02 10:58:26',1),(45,'P0000001','','qdf3kddni5fb32rpoc38fv60m0','2015-07-09 12:03:29',1),(46,'P0000001','','m0bv6hpahica288r5u8co7q6t1','2015-07-31 12:59:18',1),(48,'P0000004','','okk9shp7h6vsp8cc72q14kect5','2015-08-02 12:45:03',2),(49,'P0000001','','vl2io0lj7frs9hbld1lv3rhpr1','2015-08-07 16:34:37',1),(50,'P0000002','','at75jf7irjj15goa8o8uqmdsv6','2015-08-14 13:01:13',2),(53,'P0000001','Z0009','','2015-08-24 13:43:53',1),(54,'P0000003','Z0009','','2015-08-24 13:44:39',1),(55,'P0000003','','72rbd87056899taiuk9b3di8a3','2015-08-25 12:35:15',1),(59,'P0000006','','s23q1vija0a32p8gqrlq8vvoo2','2015-08-29 21:51:48',1),(60,'P0000005','Z0010','','2015-08-30 11:18:09',1),(63,'P0000005','','fti88a2jutvqgr2og9oul538c4','2015-09-02 22:32:19',1),(66,'P0000020','','hnd3ft1fror3emker3mdk50mr3','2015-09-05 16:00:54',1),(67,'P0000005','Z0013','','2019-09-10 14:22:26',1),(68,'P0000007','Z0013','','2019-09-10 14:22:53',1);

/*Table structure for table `tbl_cat_feature` */

DROP TABLE IF EXISTS `tbl_cat_feature`;

CREATE TABLE `tbl_cat_feature` (
  `cat_feature_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` char(5) NOT NULL,
  `cat_feature` varchar(100) NOT NULL,
  `feature_stat` int(1) NOT NULL,
  PRIMARY KEY (`cat_feature_id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_cat_feature` */

insert  into `tbl_cat_feature`(`cat_feature_id`,`cat_id`,`cat_feature`,`feature_stat`) values (54,'C0001','Fan type',1),(55,'C0001','Meterial',1),(56,'C0001','Power Consumption',1),(57,'C0001','Colour',1),(58,'C0001','Speed',1),(59,'C0002','Size',1),(60,'C0002','Case',1),(61,'C0002','Rosin',1),(62,'C0002','Bow',1),(63,'C0003','Modal',1),(64,'C0003','Watt',1),(65,'C0003','Rechargable',1),(66,'C0003','Durability',1),(67,'C0004','Input volt',1),(68,'C0004','Output volt',1),(69,'C0004','Current',1),(70,'C0005','Warrenty',1),(71,'C0005','Size',1),(72,'C0005','Power',1),(73,'C0005','Functions',1),(74,'C0006','Size',1),(75,'C0006','Colour',1),(76,'C0006','Type',1),(77,'C0007','Watt',1),(78,'C0007','Warrenty',1);

/*Table structure for table `tbl_category` */

DROP TABLE IF EXISTS `tbl_category`;

CREATE TABLE `tbl_category` (
  `cat_id` char(5) NOT NULL,
  `cat_name` varchar(100) NOT NULL,
  `cat_stat` tinyint(1) NOT NULL,
  `cat_super_cat` varchar(100) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_category` */

insert  into `tbl_category`(`cat_id`,`cat_name`,`cat_stat`,`cat_super_cat`) values ('C0001','Fan',1,'Electrical'),('C0002','Violin',1,'Musical'),('C0003','Torch',1,'Lightings'),('C0004','DC Electrical commutator',1,'Electronics'),('C0005','Calculator',1,'Electronics'),('C0006','Guitar',1,'Musical'),('C0007','Bulb',1,'Lightings');

/*Table structure for table `tbl_customer` */

DROP TABLE IF EXISTS `tbl_customer`;

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
  `cus_stat` smallint(1) DEFAULT NULL,
  PRIMARY KEY (`cus_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_customer` */

insert  into `tbl_customer`(`cus_id`,`cus_fname`,`cus_lname`,`cus_company`,`cus_add`,`cus_add2`,`cus_city`,`cus_province`,`cus_tel`,`cus_email`,`cus_gen`,`cus_pass`,`cus_online`,`cus_stat`) values ('Z0001','Saduni','Silva','','Peradeniya','','','','0775059818','sadunisilva@ymail.com',0,'',0,1),('Z0002','Manil','Silva','','Kandy','','','','0','',1,'',0,0),('Z0003','Hasith','Bandara','','Kandy','','','','0','',1,'',0,0),('Z0004','Isuru','Samarakoon','','Pilimathalawa','','','','0','',1,'',0,1),('Z0005','Harshika','Silva','','1/57','Angunawala','Peradeniya','','0812387635','ss@gmail.com',0,'112a32c44e735a1da6a4f835a673b634',1,1),('Z0006','Namal','Weerasighe','','No.56/A','Hill street','Kiribathgoda','','0','namalrocks@gmail.com',1,'7d9e562dda2cfb7904776df67ac8a9d3',1,1),('Z0007','Manel ','Bandara','','24','samatha mawatha','Kiribathkubura','','0','manel@ymail.com',0,'c2f9b9429aafaec8add76bf1a629fcd8',1,1),('Z0008','Iresha','Abesinghe','','Nuwaraeliya','','','','0','',0,'',0,0),('Z0009','Saduni','Silva','','1/57','Angunawala','Peradeniya','','0775059818','sadunisilvabuyer@ymail.com',0,'33a398e8afb9913408fedc8a39a3581f',1,1),('Z0010','SaduHarshi','Silva','','22','baseline road','Kandy','','','shs@gmail.com',0,'2048305227552fc0007c261e926efde2',1,1),('Z0011','Naween','Soysa','','Nawalapitiya','','','','','',1,'',0,0),('Z0012','Naleef','Mohammed','','Gelioya','','','','','admin@admin.com',1,'202cb962ac59075b964b07152d234b70',1,1),('Z0013',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'lal@gmail.com',NULL,'9fab6755cd2e8817d3e73b0978ca54a6',1,1);

/*Table structure for table `tbl_emp` */

DROP TABLE IF EXISTS `tbl_emp`;

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
  `emp_stat` smallint(1) NOT NULL COMMENT 'active=1 inactive=0',
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_emp` */

insert  into `tbl_emp`(`emp_id`,`emp_fname`,`emp_lname`,`emp_nic`,`emp_gen`,`emp_add`,`emp_tel`,`emp_email`,`emp_job_id`,`emp_uname`,`emp_pass`,`emp_stat`) values ('E0001','Lalindra','Silva','562973451V',1,'44, Ambagamuwa road, Gampola','0812352302','lsilva@gmail.com','J0001','lsilva@gmail.com','112a32c44e735a1da6a4f835a673b634',1),('E0002','Kolitha','Wikramasinghe','689746579V',1,'233B, Rathmalkaduwa,Gampola','0718799702','kolithaW@gmail.com','J0002','kolithaW@gmail.com','112a32c44e735a1da6a4f835a673b634',1),('E0003','Suren','Abesinghe','678975687V',1,'Bothalapitiya','0714567859','','J0003','Suren','b5345edb82eac237284d6e5b90dc7aed',1),('E0004','Kaweesha','Herath','893685698V',0,'Singhepitiya Gampola','0758744905','','J0003','Kaweesha','32d9dea66b33fb4c5fe391b1f918dcf8',1),('E0005','Sumana','Thennakoon','877869879V',0,'Jayamalapura','','','J0003','Sumana','112a32c44e735a1da6a4f835a673b634',1),('E0006','Suranjan','Suranjan','777777777V',1,'Kelaniya','1111111111','suranjan@gmail.com','J0001','Suranjan','e10adc3949ba59abbe56e057f20f883e',1);

/*Table structure for table `tbl_expense` */

DROP TABLE IF EXISTS `tbl_expense`;

CREATE TABLE `tbl_expense` (
  `exp_id` char(5) NOT NULL,
  `exp_type` char(3) NOT NULL,
  `exp_pdate` date NOT NULL,
  `exp_amount` double(20,2) NOT NULL,
  `exp_stat` tinyint(1) NOT NULL,
  PRIMARY KEY (`exp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_expense` */

insert  into `tbl_expense`(`exp_id`,`exp_type`,`exp_pdate`,`exp_amount`,`exp_stat`) values ('X0001','ex1','2015-06-22',650.00,1);

/*Table structure for table `tbl_expense_type` */

DROP TABLE IF EXISTS `tbl_expense_type`;

CREATE TABLE `tbl_expense_type` (
  `exp_type_id` char(3) NOT NULL,
  `exp_type` varchar(100) NOT NULL,
  `exp_stat` tinyint(1) NOT NULL,
  PRIMARY KEY (`exp_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_expense_type` */

insert  into `tbl_expense_type`(`exp_type_id`,`exp_type`,`exp_stat`) values ('ex1','Electricity',1),('ex2','Water',1),('ex3','Telephone',1),('ex4','Internet',1),('ex5','Tax',1);

/*Table structure for table `tbl_inv_info` */

DROP TABLE IF EXISTS `tbl_inv_info`;

CREATE TABLE `tbl_inv_info` (
  `inv_info_id` int(11) NOT NULL AUTO_INCREMENT,
  `inv_id` char(10) NOT NULL,
  `inv_date` date NOT NULL,
  `prd_id` char(8) NOT NULL,
  `prd_u_price` double(20,2) NOT NULL,
  `inv_prd_qnty` int(11) NOT NULL,
  `inv_prd_tot` double(20,2) NOT NULL,
  `inv_online` tinyint(1) NOT NULL COMMENT 'online=1 offline=0',
  PRIMARY KEY (`inv_info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_inv_info` */

insert  into `tbl_inv_info`(`inv_info_id`,`inv_id`,`inv_date`,`prd_id`,`prd_u_price`,`inv_prd_qnty`,`inv_prd_tot`,`inv_online`) values (23,'INV0000001','2015-07-01','P0000001',5500.00,1,5500.00,1),(24,'INV0000002','2015-07-02','P0000005',7200.00,1,7200.00,0),(25,'INV0000003','2015-07-02','P0000012',950.00,1,950.00,1),(26,'INV0000004','2015-09-04','P0000011',760.00,1,760.00,1),(27,'INV0000005','2015-08-14','P0000011',760.00,1,760.00,0),(28,'INV0000006','2015-08-20','P0000013',12050.00,1,12050.00,0),(29,'INV0000007','2015-09-01','P0000007',600.00,1,600.00,1),(30,'INV0000008','2015-09-01','P0000008',670.00,1,670.00,1),(31,'INV0000008','2015-09-01','P0000020',100.00,1,100.00,1),(32,'INV0000009','2015-09-01','P0000003',6000.00,1,6000.00,1),(33,'INV0000010','2015-09-01','P0000005',7200.00,1,7200.00,0),(34,'INV0000011','2015-09-02','P0000020',100.00,1,100.00,0),(35,'INV0000012','2015-09-02','P0000011',760.00,1,760.00,0),(36,'INV0000013','2015-09-02','P0000013',12050.00,1,12050.00,1),(37,'INV0000014','2015-09-02','P0000004',5250.00,1,5250.00,0),(38,'INV0000015','2015-09-02','P0000013',12050.00,1,12050.00,0),(39,'INV0000016','2015-09-03','P0000007',600.00,2,1200.00,0),(40,'INV0000017','2015-09-03','P0000006',50.00,1,50.00,0),(41,'INV0000017','2015-09-03','P0000005',7200.00,1,7200.00,0),(42,'INV0000018','2015-09-05','P0000002',6250.00,1,6250.00,0),(43,'INV0000019','2015-09-05','P0000006',50.00,1,50.00,0),(44,'INV0000020','2015-09-05','P0000014',25.00,1,25.00,0),(45,'INV0000021','2015-09-05','P0000010',830.00,1,830.00,0);

/*Table structure for table `tbl_invoice` */

DROP TABLE IF EXISTS `tbl_invoice`;

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
  `inv_online` tinyint(1) NOT NULL COMMENT 'online=1 offline=0',
  PRIMARY KEY (`inv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_invoice` */

insert  into `tbl_invoice`(`inv_id`,`inv_date`,`inv_cus_id`,`inv_session_id`,`inv_gtot`,`inv_disc`,`ship_cost`,`inv_ntot`,`inv_emp_id`,`inv_online`) values ('INV0000001','2015-07-01','Z0005','',5500.00,0.00,10.00,5510.00,'',1),('INV0000002','2015-07-02','Z0003','',7200.00,0.00,0.00,7200.00,'E0002',0),('INV0000003','2015-07-02','Z0005','',950.00,0.00,10.00,960.00,'',1),('INV0000004','2015-08-04','Z0006','',760.00,0.00,20.00,780.00,'',1),('INV0000005','2015-08-14','Z0002','',760.00,0.00,0.00,760.00,'E0004',0),('INV0000006','2015-08-20','Z0011','',12050.00,2.00,0.00,11809.00,'E0004',0),('INV0000007','2015-09-01','Z0006','',600.00,0.00,20.00,620.00,'',1),('INV0000008','2015-09-01','Z0007','',770.00,0.00,10.00,780.00,'',1),('INV0000009','2015-09-01','Z0008','',6000.00,0.00,0.00,6000.00,'E0004',0),('INV0000010','2015-09-01','Z0005','',7200.00,0.00,10.00,7210.00,'',1),('INV0000011','2015-09-02','Z0008','',100.00,0.00,0.00,100.00,'E0004',0),('INV0000012','2015-09-02','Z0012','',760.00,0.00,0.00,760.00,'E0004',0),('INV0000013','2015-09-02','Z0005','',12050.00,0.00,10.00,12060.00,'',1),('INV0000014','2015-09-02','Z0004','',5250.00,0.00,0.00,5250.00,'E0003',0),('INV0000015','2015-09-02','Z0003','',12050.00,0.00,0.00,12050.00,'E0003',0),('INV0000016','2015-09-03','Z0006','',1200.00,0.00,0.00,1200.00,'E0002',0),('INV0000017','2015-09-03','Z0005','',7250.00,0.00,10.00,7260.00,'',1),('INV0000018','2015-09-05','Z0005','',6250.00,0.00,10.00,6260.00,'',1),('INV0000019','2015-09-05','Z0005','',50.00,0.00,10.00,60.00,'',1),('INV0000020','2015-09-05','Z0005','',25.00,0.00,10.00,35.00,'',1),('INV0000021','2015-09-05','','006si7a6t5jvcisa7r0hg5i4i3',0.00,0.00,0.00,0.00,'',1);

/*Table structure for table `tbl_job` */

DROP TABLE IF EXISTS `tbl_job`;

CREATE TABLE `tbl_job` (
  `job_id` char(5) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `job_stat` smallint(1) NOT NULL COMMENT 'active=1 inactive=0',
  PRIMARY KEY (`job_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_job` */

insert  into `tbl_job`(`job_id`,`job_title`,`job_stat`) values ('J0001','Owner',1),('J0002','Manager',1),('J0003','Sales Representative',1);

/*Table structure for table `tbl_prd_info` */

DROP TABLE IF EXISTS `tbl_prd_info`;

CREATE TABLE `tbl_prd_info` (
  `pi_id` int(11) NOT NULL AUTO_INCREMENT,
  `prd_id` char(8) NOT NULL,
  `pi_type` varchar(100) NOT NULL,
  `pi_data` varchar(150) NOT NULL,
  `pi_stat` tinyint(1) NOT NULL,
  PRIMARY KEY (`pi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_prd_info` */

insert  into `tbl_prd_info`(`pi_id`,`prd_id`,`pi_type`,`pi_data`,`pi_stat`) values (20,'P0000001','Fan','Ceiling',1),(21,'P0000001','Meterial','Aluminium',1),(22,'P0000001','Power','80W',1),(23,'P0000001','Colour','White',1),(24,'P0000001','Speed','380rpm',1),(25,'P0000002','Fan','Table',1),(26,'P0000002','Meterial','Aluminium,Plastic',1),(27,'P0000002','Power','55W',1),(28,'P0000002','Colour','White',1),(29,'P0000002','Speed','450rpm',1),(30,'P0000003','Fan','Stand-able',1),(31,'P0000003','Meterial','Aluminium,Plastic',1),(32,'P0000003','Power','60W',1),(33,'P0000003','Colour','White',1),(34,'P0000003','Speed','450rpm',1),(35,'P0000004','Fan','Wall',1),(36,'P0000004','Meterial','Plastic',1),(37,'P0000004','Power','45W',1),(38,'P0000004','Colour','Blue',1),(39,'P0000004','Speed','350rpm',1),(40,'P0000005','Size','Medium',1),(41,'P0000005','Case','Available',1),(42,'P0000005','Rosin','Available',1),(43,'P0000005','Bow','Available',1),(44,'P0000006','Size','A4',1),(45,'P0000007','Modal','BR-1217',1),(46,'P0000007','Watt','20W',1),(47,'P0000007','Rechargable','Yes',1),(48,'P0000007','Durability','13hr',1),(49,'P0000008','Input','220V',1),(50,'P0000008','Output','3-12V',1),(51,'P0000008','Current','300mA',1),(52,'P0000009','Input','240V',1),(53,'P0000009','Output','3V-12V',1),(54,'P0000009','Current','200mA',1),(55,'P0000010','Warrenty','2 Years',1),(56,'P0000010','Size','3.15 x 0.44 x 6.38',1),(57,'P0000010','Power','Solar/Battery',1),(58,'P0000010','Functions','Scientific/Trigonometry/Calculus',1),(59,'P0000011','Warrenty','1Year',1),(60,'P0000011','Size','3.15 x 0.44 x 6.38',1),(61,'P0000011','Power','Battery',1),(62,'P0000011','Functions','Calculus',1),(63,'P0000012','Modal','BR7799',1),(64,'P0000012','Rechargable','Yes',1),(65,'P0000012','Durability','12hr',1),(66,'P0000012','Watt','40W',1),(67,'P0000013','Size','Large',1),(68,'P0000013','Colour','Black',1),(69,'P0000013','Type','Base/non',1),(70,'P0000014','Size','0.38mm',1),(71,'P0000014','Colour','White',1),(72,'P0000015','Type','Electric',1),(73,'P0000016','Type','Electric',1),(74,'P0000017','Type','AP12D',1),(75,'P0000018','Size','0.88mm',1),(76,'P0000018','Colour','Red',1),(77,'P0000019','Watt','60W',1),(78,'P0000019','Warrenty','6 Months',1),(79,'P0000020','Watt','3W',1),(80,'P0000020','Warrenty','3 Months',1);

/*Table structure for table `tbl_products` */

DROP TABLE IF EXISTS `tbl_products`;

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
  `prd_stat` tinyint(1) NOT NULL COMMENT 'enable=1 disable=0',
  PRIMARY KEY (`prd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_products` */

insert  into `tbl_products`(`prd_id`,`prd_name`,`cat_id`,`brand_id`,`prd_img_path`,`prd_tot_qnty`,`prd_price`,`prd_online_reserved`,`prd_reorder_lvl`,`prd_waste_qnty`,`prd_stat`) values ('P0000001','Bajaj Ceiling Fan','C0001','B0001','P0000001_1440736598.jpg',9,5500.00,0,5,0,1),('P0000002','Crystal Watch Table Fan','C0001','B0002','P0000002_1440737054.jpg',11,6250.00,0,7,0,1),('P0000003','Crystal Watch Standable Fan','C0001','B0002','P0000003_1440737359.jpg',9,6000.00,0,5,0,1),('P0000004','Usha Wall Fan','C0001','B0003','P0000004_1440737635.jpg',9,5250.00,0,6,0,1),('P0000005','Super Lark Violin','C0002','B0004','P0000005_1440738141.jpg',12,7200.00,0,10,0,1),('P0000006','Alice Violin String A4','C0002','B0005','P0000006_1440739023.JPG',28,50.00,0,20,1,1),('P0000007','Bright Rechargable LED Torch','C0003','B0006','P0000007_1440745035.jpg',7,600.00,0,6,0,1),('P0000008','DC Electrical Adaptable Commutator TC318','C0004','B0007','P0000008_1441031376.jpg',9,670.00,0,5,0,1),('P0000009','DC Electrical Adaptable Commutator TC2008','C0004','B0007','P0000009_1441031840.jpg',10,750.00,0,5,0,1),('P0000010','Casio fx100MS Calculator','C0005','B0008','P0000010_1441032434.jpg',11,830.00,0,3,0,1),('P0000011','Casio DJ240D Calculator','C0005','B0008','P0000011_1441032679.jpg',9,760.00,0,7,0,1),('P0000012','Bright BR7799 Search Light Touch','C0003','B0006','P0000012_1441033265.jpg',9,950.00,0,6,0,1),('P0000013','Suzuki Base Guitar','C0006','B0009','P0000013_1441033703.jpg',3,12050.00,0,3,0,1),('P0000014','Dunlop Guitar Pick 0.38mm','C0006','B0010','P0000014_1441033918.jpg',59,25.00,0,45,0,1),('P0000015','Alice Electric Guitar String Set A508','C0006','B0005','P0000015_1441034165.jpg',25,120.00,0,20,0,1),('P0000016','Alice Electric Guitar String Set A503','C0006','B0005','P0000016_1441034268.jpg',25,120.00,0,20,0,1),('P0000017','Alice Guitar Pick Set AP12D','C0006','B0005','P0000017_1441034412.jpg',20,95.00,0,10,0,1),('P0000018','Dunlop Guitar Pick 0.88mm','C0006','B0010','P0000018_1441034596.jpg',50,35.00,0,40,0,1),('P0000019','Philips Tungstan Bulb 60W','C0007','B0011','P0000019_1441034828.jpg',20,120.00,0,10,0,1),('P0000020','Spectrum LED Candle Bulb','C0007','B0012','P0000020_1441034954.jpg',28,100.00,0,25,0,1);

/*Table structure for table `tbl_province` */

DROP TABLE IF EXISTS `tbl_province`;

CREATE TABLE `tbl_province` (
  `prov_id` char(5) NOT NULL COMMENT 'prov1',
  `Prov_name` varchar(100) NOT NULL,
  `ship_cost` double(20,2) NOT NULL,
  PRIMARY KEY (`prov_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_province` */

insert  into `tbl_province`(`prov_id`,`Prov_name`,`ship_cost`) values ('PROV1','Western',20.00),('PROV2','Central',10.00),('PROV3','Southern',30.00),('PROV4','Eastern',35.00),('PROV5','Northern',45.00),('PROV6','North Central',30.00),('PROV7','North West',40.00),('PROV8','Sabaragamu',25.00),('PROV9','Uva',30.00);

/*Table structure for table `tbl_purchase_return` */

DROP TABLE IF EXISTS `tbl_purchase_return`;

CREATE TABLE `tbl_purchase_return` (
  `pur_retrn_id` char(9) NOT NULL,
  `prd_id` char(8) NOT NULL,
  `pur_retrn_qnty` int(10) NOT NULL,
  `sup_id` char(5) NOT NULL,
  `date_added` date NOT NULL,
  `pur_retrn_stat` tinyint(1) NOT NULL,
  PRIMARY KEY (`pur_retrn_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_purchase_return` */

insert  into `tbl_purchase_return`(`pur_retrn_id`,`prd_id`,`pur_retrn_qnty`,`sup_id`,`date_added`,`pur_retrn_stat`) values ('SR0000001','P0000007',1,'S0004','2015-09-05',0);

/*Table structure for table `tbl_sales_return` */

DROP TABLE IF EXISTS `tbl_sales_return`;

CREATE TABLE `tbl_sales_return` (
  `sal_retrn_id` char(9) NOT NULL COMMENT 'SR000001',
  `sal_retrn_date` date NOT NULL,
  `inv_id` char(10) NOT NULL,
  `prd_id` char(8) NOT NULL,
  `sal_retrn_qnty` int(5) NOT NULL,
  `sal_retrn_prd_price` double(20,2) NOT NULL,
  `sal_retrn_qlity_stat` tinyint(1) NOT NULL COMMENT 'waste=1 addtosell=2 purchasereturn=3',
  PRIMARY KEY (`sal_retrn_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_sales_return` */

insert  into `tbl_sales_return`(`sal_retrn_id`,`sal_retrn_date`,`inv_id`,`prd_id`,`sal_retrn_qnty`,`sal_retrn_prd_price`,`sal_retrn_qlity_stat`) values ('SR0000001','2015-09-05','INV0000016','P0000007',1,600.00,3);

/*Table structure for table `tbl_ship_info` */

DROP TABLE IF EXISTS `tbl_ship_info`;

CREATE TABLE `tbl_ship_info` (
  `ship_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `ship_email` varchar(50) NOT NULL,
  PRIMARY KEY (`ship_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_ship_info` */

insert  into `tbl_ship_info`(`ship_id`,`cus_id`,`session_id`,`ship_fname`,`ship_lname`,`ship_comp`,`ship_add1`,`ship_add2`,`ship_city`,`ship_prov`,`ship_tel`,`ship_email`) values (1,'','91u91bav3ca7uqa14snqmfno65','Saduni','Silva','','1/57','Agunawala','Peradeniya','PROV2','812387635','sadunisilva@ymail.com'),(4,'Z0005','','Saduni','Silva','','1/57','Angunawala','Peradeniya','PROV2','0812387635','ss@gmail.com'),(5,'','5llfd7fpo6o7i7gt9me6oivpj5','Manil','Silva','','44','Ambagamuwa Road','Gampola','PROV2','812352302','ms@ymail.com'),(6,'Z0006','','Namal ','Weerasinghe','','No. 56/A','Hill Street','Kiribathgoda','PROV1','0112910893','namalrocks@gmail.com'),(7,'Z0007','','Manel','Bandara','','No.24','Samatha Mawatha','Kiribathkubura','PROV2','0812876980','manel@ymail.com'),(8,'','006si7a6t5jvcisa7r0hg5i4i3','Mariam','Shamy','','55A','Malwatha Road','Rathmalkaduwa','PROV2','0718799702','mariamS@gmail.com');

/*Table structure for table `tbl_supplier` */

DROP TABLE IF EXISTS `tbl_supplier`;

CREATE TABLE `tbl_supplier` (
  `sup_id` char(5) NOT NULL,
  `sup_fname` varchar(50) NOT NULL,
  `sup_lname` varchar(50) NOT NULL,
  `sup_comp` varchar(50) NOT NULL,
  `sup_gen` tinyint(1) NOT NULL,
  `sup_add` varchar(100) NOT NULL,
  `sup_tel` char(10) NOT NULL,
  `sup_email` varchar(100) NOT NULL,
  `sup_stat` tinyint(1) NOT NULL,
  PRIMARY KEY (`sup_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_supplier` */

insert  into `tbl_supplier`(`sup_id`,`sup_fname`,`sup_lname`,`sup_comp`,`sup_gen`,`sup_add`,`sup_tel`,`sup_email`,`sup_stat`) values ('S0001','Mohammed','Faheem','CrystalWatch',1,'44,1st cross lane,pettah','112376543','',1),('S0002','Ansar','Mohammed','Unitec',1,'No.445,2nd Cross Street,Petta','112347687','',1),('S0003','Malan','Serasinghe','Kandy Musical',1,'No. 231/A, Kotugodalla Veediya,Kandy','812456346','kandymusical@yahoomail.com',1),('S0004','Nimal','Perera','Tesco',1,'457/B,1st cross street,Petta','112598087','tesco@gmail.com',1);

/*Table structure for table `tbl_wishlist` */

DROP TABLE IF EXISTS `tbl_wishlist`;

CREATE TABLE `tbl_wishlist` (
  `wishlist_id` int(11) NOT NULL AUTO_INCREMENT,
  `prd_id` char(8) NOT NULL,
  `cus_id` char(5) NOT NULL,
  `date_time` datetime NOT NULL,
  PRIMARY KEY (`wishlist_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_wishlist` */

insert  into `tbl_wishlist`(`wishlist_id`,`prd_id`,`cus_id`,`date_time`) values (11,'P0000002','Z0010','2015-08-30 11:34:02'),(13,'P0000002','Z0005','2015-08-30 19:39:30'),(14,'P0000007','Z0005','2015-08-30 19:39:54'),(15,'P0000005','Z0013','2019-09-10 14:22:28'),(16,'P0000007','Z0013','2019-09-10 14:22:49');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
