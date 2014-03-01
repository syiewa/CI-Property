-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 10, 2014 at 03:23 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `property`
--
CREATE DATABASE IF NOT EXISTS `property` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `property`;

-- --------------------------------------------------------

--
-- Table structure for table `details_place`
--

CREATE TABLE IF NOT EXISTS `details_place` (
  `id_detail` int(10) NOT NULL AUTO_INCREMENT,
  `id_type` int(10) DEFAULT NULL,
  `prices` int(100) DEFAULT '0',
  `year_built` int(5) DEFAULT NULL,
  `lot_dim` float DEFAULT '0',
  `floor_dim` float DEFAULT '0',
  `bedrooms` int(5) DEFAULT NULL,
  `bathrooms` int(5) DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  `desc` text,
  `id_places` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_detail`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `details_place`
--

INSERT INTO `details_place` (`id_detail`, `id_type`, `prices`, `year_built`, `lot_dim`, `floor_dim`, `bedrooms`, `bathrooms`, `status`, `desc`, `id_places`) VALUES
(1, 1, 1000000, 1980, 1000, 1000, 2, 2, 1, 'dadadada', 1),
(7, 1, 0, NULL, 0, 0, NULL, NULL, 0, NULL, 11),
(8, 1, 0, NULL, 0, 0, NULL, NULL, 0, NULL, 12),
(9, 1, 0, NULL, 0, 0, NULL, NULL, 0, NULL, 13),
(10, 1, 0, NULL, 0, 0, NULL, NULL, 0, NULL, 14),
(11, 1, 10000, 1999, 1000, 1000, 5, 5, 1, 'adadada', 15);

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE IF NOT EXISTS `features` (
  `id_features` int(10) NOT NULL AUTO_INCREMENT,
  `title_features` varchar(255) DEFAULT NULL,
  `type_features` int(2) DEFAULT NULL,
  `id_places` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_features`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `maps`
--

CREATE TABLE IF NOT EXISTS `maps` (
  `id_map` int(10) NOT NULL AUTO_INCREMENT,
  `province` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `town` varchar(100) DEFAULT NULL,
  `address1` text,
  `address2` text,
  `zip` int(10) DEFAULT NULL,
  `lang` float DEFAULT NULL,
  `long` float DEFAULT NULL,
  `google` int(1) DEFAULT NULL,
  `id_places` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_map`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `id_photo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_places` int(10) unsigned NOT NULL,
  `image` text,
  `thumb` text,
  `photoplan` text,
  `photoplan_thumb` text,
  `default` enum('1','0') DEFAULT '0',
  PRIMARY KEY (`id_photo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id_photo`, `id_places`, `image`, `thumb`, `photoplan`, `photoplan_thumb`, `default`) VALUES
(1, 1, 'aaaaa', 'adadada', NULL, NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE IF NOT EXISTS `places` (
  `id_places` int(10) NOT NULL AUTO_INCREMENT,
  `title_places` varchar(255) DEFAULT NULL,
  `status_places` varchar(1) DEFAULT '0',
  `created_on` datetime DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  PRIMARY KEY (`id_places`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id_places`, `title_places`, `status_places`, `created_on`, `last_update`) VALUES
(1, 'test1', '1', '2014-02-07 13:07:44', '2014-02-07 13:07:47'),
(11, 'adaaaa', '0', '2014-02-09 11:02:37', NULL),
(12, 'telo', '0', '2014-02-09 09:02:19', '2014-02-09 11:24:25'),
(13, 'hmmm', '0', '2014-02-09 11:02:42', NULL),
(14, 'hmmm', '0', '2014-02-09 11:02:45', NULL),
(15, 'hmmm123', '0', '2014-02-09 11:02:14', '2014-02-09 23:33:36');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE IF NOT EXISTS `types` (
  `id_type` int(10) NOT NULL AUTO_INCREMENT,
  `title_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id_type`, `title_type`) VALUES
(1, 'Home');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
