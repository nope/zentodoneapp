-- INFORMATION
-- Administration username: admin
-- Administration password: ztda


-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 16, 2010 at 09:46 PM
-- Server version: 5.1.50
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ztda`
--

-- --------------------------------------------------------

--
-- Table structure for table `1_Contexts`
--

CREATE TABLE IF NOT EXISTS `1_Contexts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `task_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=181 ;

-- --------------------------------------------------------

--
-- Table structure for table `1_Tasks`
--

CREATE TABLE IF NOT EXISTS `1_Tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item` varchar(1000) NOT NULL,
  `date_added` date NOT NULL,
  `date_scheduled` date NOT NULL,
  `contexts` text NOT NULL,
  `notes` text NOT NULL,
  `big_rock` tinyint(1) NOT NULL,
  `completed` tinyint(1) NOT NULL,
  `archived` tinyint(1) NOT NULL,
  `date_completed` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=113 ;

-- --------------------------------------------------------

--
-- Table structure for table `password_retrieval`
--

CREATE TABLE IF NOT EXISTS `password_retrieval` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `url` varchar(16) NOT NULL,
  `expiry_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `register_date` date NOT NULL,
  `last_login` date NOT NULL,
  `newsletter` tinyint(1) NOT NULL,
  `invite_code` varchar(255) NOT NULL,
  `invites_left` tinyint(2) NOT NULL,
  `paid` tinyint(1) NOT NULL,
  `week_start` varchar(1) NOT NULL,
  `timezone` varchar(255) NOT NULL,
  `date_format` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2867 ;

INSERT INTO `users` (`id`, `username`, `password`, `email`, `first_name`, `last_name`, `register_date`, `last_login`, `newsletter`, `invite_code`, `invites_left`, `paid`, `week_start`, `timezone`, `date_format`) VALUES
(1, 'admin', '6bdc5ed4d6479036a724e73820a40ba61045f65f', 'dummy@email.com', 'Admin', 'Account', '2010-09-04', '2010-10-16', 1, 'QuXOysg09GM107Ba', 5, 0, 'M', 'America/New_York', 'dd/mm/yy');
