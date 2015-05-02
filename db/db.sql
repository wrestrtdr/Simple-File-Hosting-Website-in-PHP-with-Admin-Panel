-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2015 at 07:21 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `filehost`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_info`
--

CREATE TABLE IF NOT EXISTS `admin_info` (
  `admin_index` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` varchar(100) NOT NULL,
  `admin_pass` varchar(100) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin_index` (`admin_index`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin_info`
--

INSERT INTO `admin_info` (`admin_index`, `admin_id`, `admin_pass`, `admin_email`) VALUES
(1, 'admin', 'admin', 'balramverma@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `files_info`
--

CREATE TABLE IF NOT EXISTS `files_info` (
  `file_index` int(11) NOT NULL AUTO_INCREMENT,
  `file_code` varchar(100) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `file_delete_id` varchar(100) NOT NULL,
  `file_size` varchar(100) NOT NULL,
  `file_upload_date` date NOT NULL,
  `file_upload_time` time NOT NULL,
  `file_upload_by` varchar(100) NOT NULL,
  `file_upload_ip` varchar(100) NOT NULL,
  `file_status` varchar(100) NOT NULL,
  `file_downloads_count` int(100) NOT NULL,
  PRIMARY KEY (`file_code`),
  UNIQUE KEY `file_index` (`file_index`),
  UNIQUE KEY `file_code` (`file_code`),
  UNIQUE KEY `file_delete_id` (`file_delete_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=114 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_info`
--

CREATE TABLE IF NOT EXISTS `users_info` (
  `u_index` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` varchar(100) NOT NULL,
  `u_pass` varchar(100) NOT NULL,
  `u_email` varchar(100) NOT NULL,
  `u_ip` varchar(100) NOT NULL,
  `u_reg_date` date NOT NULL,
  `u_reg_time` time NOT NULL,
  `u_status` varchar(100) NOT NULL,
  PRIMARY KEY (`u_id`),
  KEY `u_index` (`u_index`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `users_info`
--

INSERT INTO `users_info` (`u_index`, `u_id`, `u_pass`, `u_email`, `u_ip`, `u_reg_date`, `u_reg_time`, `u_status`) VALUES
(38, 'guest', '%%%$$$ADAD>>>::""""::', 'RESERVED USER', 'RESERVED USER', '2011-10-24', '10:33:36', 'RESERVED USER'),
(39, 'user', 'user', 'a@a.com', '::1', '2015-05-02', '22:50:25', 'active');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
