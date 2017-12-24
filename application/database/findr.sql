-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2017 at 09:44 AM
-- Server version: 5.7.17
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `findr`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('ae6521e332c7b8c03d200bf742ce2b0eaab74e92', '127.0.0.1', 1514107840, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531343130373834303b),
('4133a7af41f1039791757388ef9419a5fe55060c', '127.0.0.1', 1514108365, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531343130383336353b757365725f69647c733a313a2231223b757365725f656d61696c7c733a31313a22656d61696c406d6d2e6363223b757365725f6e616d657c733a353a2241646d696e223b646174655f637265617465647c733a31393a22323031372d31302d30312030303a30303a3030223b646174655f6c6173745f6c6f67696e7c733a31393a22323031372d31302d30312030303a30303a3030223b6163746976657c733a333a22796573223b6c6f676765645f696e7c623a313b747970657c733a353a227573657273223b),
('0aa93218bc9a593f3152add7f5807823b9624b3c', '127.0.0.1', 1514107897, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531343130373839373b),
('e58a9e2ecd7db187554e2f2abd29e647e03bc99a', '127.0.0.1', 1514107898, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531343130373839383b),
('afca1feb8f00c6322ab05bcf9d176852c92ef7a1', '127.0.0.1', 1514107898, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531343130373839383b),
('a2090d73f6a4de69dbebce91bb418a62e65ab5aa', '127.0.0.1', 1514108632, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531343130383336353b757365725f69647c733a313a2231223b757365725f656d61696c7c733a31313a22656d61696c406d6d2e6363223b757365725f6e616d657c733a353a2241646d696e223b646174655f637265617465647c733a31393a22323031372d31302d30312030303a30303a3030223b646174655f6c6173745f6c6f67696e7c733a31393a22323031372d31302d30312030303a30303a3030223b6163746976657c733a333a22796573223b6c6f676765645f696e7c623a313b747970657c733a353a227573657273223b),
('e7a79aa23012838fb1d78c939a64cb872d96ed28', '127.0.0.1', 1514108587, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531343130383538373b),
('4cef4650d6d31198321b3e8e8e28560fe8bae1ce', '127.0.0.1', 1514108587, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531343130383538373b),
('76bf5d65ef509c3286bae3d88ef44343678b669a', '127.0.0.1', 1514108588, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531343130383538383b),
('1b871a18532071eeb69d4c49d3558f44d3afc683', '127.0.0.1', 1514108638, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531343130383633383b),
('68c7b6d2f79731c4b88d01b0ab57af2a9e0341f5', '127.0.0.1', 1514108638, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531343130383633383b),
('c4d8629774daaebf1832638eaf398b453da9e494', '127.0.0.1', 1514108640, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531343130383633393b);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `storage_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_description` text NOT NULL,
  `date_created` datetime NOT NULL,
  `date_last_access` datetime NOT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=86 ;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action` text NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `photoId` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `fileName` varchar(255) NOT NULL,
  `thumbName` varchar(255) NOT NULL,
  PRIMARY KEY (`photoId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=162 ;

-- --------------------------------------------------------

--
-- Table structure for table `storage_spaces`
--

CREATE TABLE IF NOT EXISTS `storage_spaces` (
  `storage_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `storage_prefix` char(1) NOT NULL,
  `storage_number` int(11) NOT NULL,
  `storage_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `storage_description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `date_last_access` datetime NOT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`storage_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_last_login` datetime NOT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_email`, `user_pass`, `user_name`, `date_created`, `date_last_login`, `active`) VALUES
(1, 'email@mm.cc', '$2a$08$tApk5QIvEcCndCT9RVVPQ.kSiDXqRoTLLgHa2NHl3RERoilPlP7CW', 'Admin', '2017-10-01 00:00:00', '2017-10-01 00:00:00', 'yes');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
