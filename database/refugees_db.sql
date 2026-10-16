-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 04, 2026 at 08:45 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `refugees_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `a_id` int NOT NULL AUTO_INCREMENT,
  `a_name` varchar(45) NOT NULL,
  `a_contact` varchar(45) NOT NULL,
  `a_email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  PRIMARY KEY (`a_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`a_id`, `a_name`, `a_contact`, `a_email`, `password`) VALUES
(1, 'Lucky', '0787293050', 'luckyrazor11@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b');

-- --------------------------------------------------------

--
-- Table structure for table `age_range`
--

DROP TABLE IF EXISTS `age_range`;
CREATE TABLE IF NOT EXISTS `age_range` (
  `age_id` int NOT NULL AUTO_INCREMENT,
  `a_range` varchar(45) NOT NULL,
  `description` varchar(45) NOT NULL,
  PRIMARY KEY (`age_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `age_range`
--

INSERT INTO `age_range` (`age_id`, `a_range`, `description`) VALUES
(1, '1-5', 'Children'),
(2, '6-15', ' Aba Amaryo');

-- --------------------------------------------------------

--
-- Table structure for table `camp`
--

DROP TABLE IF EXISTS `camp`;
CREATE TABLE IF NOT EXISTS `camp` (
  `c_id` int NOT NULL AUTO_INCREMENT,
  `campIMG` varchar(45) NOT NULL,
  `c_name` varchar(45) NOT NULL,
  `l_id` int NOT NULL,
  `r_id` int NOT NULL,
  PRIMARY KEY (`c_id`),
  KEY `fk_camp_location_idx` (`l_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `camp`
--

INSERT INTO `camp` (`c_id`, `campIMG`, `c_name`, `l_id`, `r_id`) VALUES
(1, 'campIMG/16a6c635be3fd1.png', 'Sempiki', 3, 1),
(2, 'campIMG/16a7062efbcb06.jpeg', 'Camp 2', 3, 2),
(3, 'campIMG/16a706ad5b5f34.jpeg', 'Camp 2', 1, 0),
(4, 'campIMG/16a706af1bc270.jpeg', 'Camp 2', 1, 0),
(5, 'campIMG/6a719d7195de68.97579520.jpg', 'Camp 2', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `camp_need`
--

DROP TABLE IF EXISTS `camp_need`;
CREATE TABLE IF NOT EXISTS `camp_need` (
  `need_id` int NOT NULL AUTO_INCREMENT,
  `c_id` int NOT NULL,
  `r_id` int NOT NULL,
  `res_id` int NOT NULL,
  `quantity` varchar(45) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` varchar(45) NOT NULL DEFAULT 'Open',
  `posted_date` varchar(45) NOT NULL,
  PRIMARY KEY (`need_id`),
  KEY `fk_need_camp` (`c_id`),
  KEY `fk_need_registrar` (`r_id`),
  KEY `fk_need_resource` (`res_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `camp_need`
--

INSERT INTO `camp_need` (`need_id`, `c_id`, `r_id`, `res_id`, `quantity`, `description`, `status`, `posted_date`) VALUES
(1, 1, 1, 1, '200 packs', 'Urgent food support for new arrivals', 'Closed', '2026-08-04'),
(2, 1, 1, 4, '50 kits', 'Basic medical kits for the clinic tent', 'Open', '2026-08-04'),
(3, 2, 2, 2, '120', 'Warm blankets ahead of rainy season', 'Open', '2026-08-04'),
(4, 2, 2, 3, '500L', 'Clean drinking water for families', 'Open', '2026-08-04'),
(5, 1, 1, 5, '1000', 'this camp needed 1000kgs of clothes, 500 for kids and 200 for adults and 300 for pregnant women', 'Open', '2026-08-04');

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

DROP TABLE IF EXISTS `donation`;
CREATE TABLE IF NOT EXISTS `donation` (
  `don_id` int NOT NULL AUTO_INCREMENT,
  `d_id` int NOT NULL,
  `res_id` int NOT NULL,
  `quantity` varchar(45) NOT NULL,
  `donation_date` varchar(45) NOT NULL,
  `c_id` int NOT NULL,
  `status` varchar(45) NOT NULL,
  `need_id` int DEFAULT NULL,
  PRIMARY KEY (`don_id`),
  KEY `fk_donation_resources1_idx` (`res_id`),
  KEY `fk_donation_donnor1_idx` (`d_id`),
  KEY `fk_donation_camp1_idx` (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`don_id`, `d_id`, `res_id`, `quantity`, `donation_date`, `c_id`, `status`, `need_id`) VALUES
(1, 1, 1, '100 bags', '2026-08-04', 1, 'Received', NULL),
(2, 2, 2, '1000', '2026-08-04', 1, 'Distributed', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `donnor`
--

DROP TABLE IF EXISTS `donnor`;
CREATE TABLE IF NOT EXISTS `donnor` (
  `d_id` int NOT NULL AUTO_INCREMENT,
  `d_name` varchar(45) NOT NULL,
  `d_contact` varchar(45) NOT NULL,
  `d_email` varchar(45) NOT NULL,
  `n_id` int NOT NULL,
  `password` varchar(45) NOT NULL,
  PRIMARY KEY (`d_id`),
  UNIQUE KEY `d_email_UNIQUE` (`d_email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `donnor`
--

INSERT INTO `donnor` (`d_id`, `d_name`, `d_contact`, `d_email`, `n_id`, `password`) VALUES
(1, 'Test Donor', '0700', 'donor1785829534@test.com', 1, '24509bdd53861f8f468a94c84526f88a'),
(2, 'Lucky', '0797838472', 'info@razortechcompany.com', 4, '827ccb0eea8a706c4c34a16891f84e7b');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
CREATE TABLE IF NOT EXISTS `location` (
  `l_id` int NOT NULL AUTO_INCREMENT,
  `l_name` varchar(45) NOT NULL,
  PRIMARY KEY (`l_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`l_id`, `l_name`) VALUES
(1, 'Kampala'),
(3, 'Kabalagala');

-- --------------------------------------------------------

--
-- Table structure for table `marital_status`
--

DROP TABLE IF EXISTS `marital_status`;
CREATE TABLE IF NOT EXISTS `marital_status` (
  `m_id` int NOT NULL AUTO_INCREMENT,
  `status` varchar(45) NOT NULL,
  PRIMARY KEY (`m_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `marital_status`
--

INSERT INTO `marital_status` (`m_id`, `status`) VALUES
(1, 'Single'),
(2, 'Married');

-- --------------------------------------------------------

--
-- Table structure for table `nationality`
--

DROP TABLE IF EXISTS `nationality`;
CREATE TABLE IF NOT EXISTS `nationality` (
  `n_id` int NOT NULL AUTO_INCREMENT,
  `nationality` varchar(45) NOT NULL,
  PRIMARY KEY (`n_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `nationality`
--

INSERT INTO `nationality` (`n_id`, `nationality`) VALUES
(1, 'Ugandan'),
(2, 'Ugandan'),
(3, 'Kenyan'),
(4, 'Naigerian');

-- --------------------------------------------------------

--
-- Table structure for table `refugee`
--

DROP TABLE IF EXISTS `refugee`;
CREATE TABLE IF NOT EXISTS `refugee` (
  `ref_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `ref_number` varchar(45) NOT NULL,
  `n_id` int NOT NULL,
  `c_id` int NOT NULL,
  `l_id` int NOT NULL,
  `address` varchar(45) NOT NULL,
  `reason` varchar(45) NOT NULL,
  `DOB` varchar(45) NOT NULL,
  `m_id` int NOT NULL,
  `age_id` int NOT NULL,
  `t_id` int NOT NULL,
  `g_id` int NOT NULL,
  `r_id` int NOT NULL,
  PRIMARY KEY (`ref_id`),
  KEY `fk_refugee_refugee_group1_idx` (`g_id`),
  KEY `fk_refugee_refugee_type1_idx` (`t_id`),
  KEY `fk_refugee_marital_status1_idx` (`m_id`),
  KEY `fk_refugee_camp1_idx` (`c_id`),
  KEY `fk_refugee_location1_idx` (`l_id`),
  KEY `fk_refugee_age_range1_idx` (`age_id`),
  KEY `fk_refugee_nationality1_idx` (`n_id`),
  KEY `fk_refugee_registrar1_idx` (`r_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `refugee`
--

INSERT INTO `refugee` (`ref_id`, `name`, `ref_number`, `n_id`, `c_id`, `l_id`, `address`, `reason`, `DOB`, `m_id`, `age_id`, `t_id`, `g_id`, `r_id`) VALUES
(1, 'Test Refugee', 'REF001', 1, 1, 3, 'Kampala', 'Conflict', '2000-01-01', 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `refugee_group`
--

DROP TABLE IF EXISTS `refugee_group`;
CREATE TABLE IF NOT EXISTS `refugee_group` (
  `g_id` int NOT NULL AUTO_INCREMENT,
  `group_type` varchar(45) NOT NULL,
  PRIMARY KEY (`g_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `refugee_group`
--

INSERT INTO `refugee_group` (`g_id`, `group_type`) VALUES
(1, 'Individual Refugee');

-- --------------------------------------------------------

--
-- Table structure for table `refugee_type`
--

DROP TABLE IF EXISTS `refugee_type`;
CREATE TABLE IF NOT EXISTS `refugee_type` (
  `t_id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  PRIMARY KEY (`t_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `refugee_type`
--

INSERT INTO `refugee_type` (`t_id`, `type`) VALUES
(1, 'Type 1'),
(2, 'Type 2');

-- --------------------------------------------------------

--
-- Table structure for table `registrar`
--

DROP TABLE IF EXISTS `registrar`;
CREATE TABLE IF NOT EXISTS `registrar` (
  `r_id` int NOT NULL AUTO_INCREMENT,
  `r_name` varchar(45) NOT NULL,
  `r_contact` varchar(45) NOT NULL,
  `r_email` varchar(45) NOT NULL,
  `n_id` int NOT NULL,
  `l_id` int NOT NULL,
  `c_id` int NOT NULL,
  `password` varchar(45) NOT NULL,
  PRIMARY KEY (`r_id`),
  KEY `fk_register_nationality1_idx` (`n_id`),
  KEY `fk_register_location1_idx` (`l_id`),
  KEY `fk_registrar_camp1` (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `registrar`
--

INSERT INTO `registrar` (`r_id`, `r_name`, `r_contact`, `r_email`, `n_id`, `l_id`, `c_id`, `password`) VALUES
(1, 'Tumuhimbise Lucky', '078729395', 'lucky@gmail.com', 1, 3, 1, '827ccb0eea8a706c4c34a16891f84e7b'),
(2, 'Henry', '078592834', 'henry@gmail.com', 3, 3, 2, '827ccb0eea8a706c4c34a16891f84e7b');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

DROP TABLE IF EXISTS `resources`;
CREATE TABLE IF NOT EXISTS `resources` (
  `res_id` int NOT NULL AUTO_INCREMENT,
  `resource` varchar(45) NOT NULL,
  PRIMARY KEY (`res_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`res_id`, `resource`) VALUES
(1, 'Food Packages'),
(2, 'Blankets'),
(3, 'Clean Water'),
(4, 'Medical Supplies'),
(5, 'Clothing'),
(6, 'School Materials');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `camp`
--
ALTER TABLE `camp`
  ADD CONSTRAINT `fk_camp_location` FOREIGN KEY (`l_id`) REFERENCES `location` (`l_id`);

--
-- Constraints for table `camp_need`
--
ALTER TABLE `camp_need`
  ADD CONSTRAINT `fk_need_camp` FOREIGN KEY (`c_id`) REFERENCES `camp` (`c_id`),
  ADD CONSTRAINT `fk_need_registrar` FOREIGN KEY (`r_id`) REFERENCES `registrar` (`r_id`),
  ADD CONSTRAINT `fk_need_resource` FOREIGN KEY (`res_id`) REFERENCES `resources` (`res_id`);

--
-- Constraints for table `donation`
--
ALTER TABLE `donation`
  ADD CONSTRAINT `fk_donation_camp1` FOREIGN KEY (`c_id`) REFERENCES `camp` (`c_id`),
  ADD CONSTRAINT `fk_donation_donnor1` FOREIGN KEY (`d_id`) REFERENCES `donnor` (`d_id`),
  ADD CONSTRAINT `fk_donation_resources1` FOREIGN KEY (`res_id`) REFERENCES `resources` (`res_id`);

--
-- Constraints for table `refugee`
--
ALTER TABLE `refugee`
  ADD CONSTRAINT `fk_refugee_age_range1` FOREIGN KEY (`age_id`) REFERENCES `age_range` (`age_id`),
  ADD CONSTRAINT `fk_refugee_camp1` FOREIGN KEY (`c_id`) REFERENCES `camp` (`c_id`),
  ADD CONSTRAINT `fk_refugee_location1` FOREIGN KEY (`l_id`) REFERENCES `location` (`l_id`),
  ADD CONSTRAINT `fk_refugee_marital_status1` FOREIGN KEY (`m_id`) REFERENCES `marital_status` (`m_id`),
  ADD CONSTRAINT `fk_refugee_nationality1` FOREIGN KEY (`n_id`) REFERENCES `nationality` (`n_id`),
  ADD CONSTRAINT `fk_refugee_refugee_group1` FOREIGN KEY (`g_id`) REFERENCES `refugee_group` (`g_id`),
  ADD CONSTRAINT `fk_refugee_refugee_type1` FOREIGN KEY (`t_id`) REFERENCES `refugee_type` (`t_id`),
  ADD CONSTRAINT `fk_refugee_registrar1` FOREIGN KEY (`r_id`) REFERENCES `registrar` (`r_id`);

--
-- Constraints for table `registrar`
--
ALTER TABLE `registrar`
  ADD CONSTRAINT `fk_register_location1` FOREIGN KEY (`l_id`) REFERENCES `location` (`l_id`),
  ADD CONSTRAINT `fk_register_nationality1` FOREIGN KEY (`n_id`) REFERENCES `nationality` (`n_id`),
  ADD CONSTRAINT `fk_registrar_camp1` FOREIGN KEY (`c_id`) REFERENCES `camp` (`c_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
