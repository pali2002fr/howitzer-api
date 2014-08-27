-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Aug 27, 2014 at 06:24 AM
-- Server version: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `howitzer`
--
CREATE DATABASE IF NOT EXISTS `howitzer` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `howitzer`;

-- --------------------------------------------------------

--
-- Table structure for table `angle`
--

DROP TABLE IF EXISTS `angle`;
CREATE TABLE IF NOT EXISTS `angle` (
  `id` tinyint(10) NOT NULL AUTO_INCREMENT,
  `angle` tinyint(5) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`,`angle`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `angle`
--

INSERT INTO `angle` (`id`, `angle`, `created_date`, `updated_date`) VALUES
(1, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 25, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 30, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 35, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 40, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 45, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 50, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 55, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 60, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 65, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 70, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 75, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 80, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 85, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `distance`
--

DROP TABLE IF EXISTS `distance`;
CREATE TABLE IF NOT EXISTS `distance` (
  `id` tinyint(5) NOT NULL AUTO_INCREMENT,
  `distance` int(5) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`,`distance`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `distance`
--

INSERT INTO `distance` (`id`, `distance`, `created_date`, `updated_date`) VALUES
(1, 100, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 200, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 300, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 400, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 500, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `howitzer`
--

DROP TABLE IF EXISTS `howitzer`;
CREATE TABLE IF NOT EXISTS `howitzer` (
  `id` tinyint(10) NOT NULL AUTO_INCREMENT,
  `weight` int(5) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`,`weight`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `howitzer`
--

INSERT INTO `howitzer` (`id`, `weight`, `created_date`, `updated_date`) VALUES
(1, 1000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 2000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 3000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 4000, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 5000, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

DROP TABLE IF EXISTS `result`;
CREATE TABLE IF NOT EXISTS `result` (
  `id` tinyint(10) NOT NULL AUTO_INCREMENT,
  `id_shot` tinyint(10) NOT NULL,
  `id_user` tinyint(10) NOT NULL,
  `hit` tinyint(1) NOT NULL,
  `impact` int(10) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `result`
--

INSERT INTO `result` (`id`, `id_shot`, `id_user`, `hit`, `impact`, `created_date`, `updated_date`) VALUES
(1, 1, 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 1, 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 1, 1, 1, 101, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 4, 4, 0, 101, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 6, 1, 0, 101, '2014-08-27 10:02:59', '2014-08-27 04:02:59');

-- --------------------------------------------------------

--
-- Table structure for table `shot`
--

DROP TABLE IF EXISTS `shot`;
CREATE TABLE IF NOT EXISTS `shot` (
  `id` tinyint(10) NOT NULL AUTO_INCREMENT,
  `id_user` tinyint(10) NOT NULL,
  `id_howitzer` tinyint(10) NOT NULL,
  `id_target` tinyint(10) NOT NULL,
  `id_distance` tinyint(10) NOT NULL,
  `id_speed` tinyint(10) NOT NULL,
  `id_angle` tinyint(10) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `shot`
--

INSERT INTO `shot` (`id`, `id_user`, `id_howitzer`, `id_target`, `id_distance`, `id_speed`, `id_angle`, `created_date`, `updated_date`) VALUES
(1, 1, 1, 1, 1, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 1, 1, 1, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 1, 1, 1, 1, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 4, 1, 1, 1, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 1, 1, 1, 1, 1, 1, '2014-08-27 09:56:08', '2014-08-27 03:56:08'),
(6, 1, 1, 1, 1, 1, 1, '2014-08-27 10:02:58', '2014-08-27 04:02:58');

-- --------------------------------------------------------

--
-- Table structure for table `speed`
--

DROP TABLE IF EXISTS `speed`;
CREATE TABLE IF NOT EXISTS `speed` (
  `id` tinyint(10) NOT NULL AUTO_INCREMENT,
  `speed` int(5) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`,`speed`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `speed`
--

INSERT INTO `speed` (`id`, `speed`, `created_date`, `updated_date`) VALUES
(1, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 25, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 30, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `target`
--

DROP TABLE IF EXISTS `target`;
CREATE TABLE IF NOT EXISTS `target` (
  `id` tinyint(10) NOT NULL AUTO_INCREMENT,
  `size` int(5) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`,`size`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `target`
--

INSERT INTO `target` (`id`, `size`, `created_date`, `updated_date`) VALUES
(1, 10, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 20, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 30, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 40, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 50, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` tinyint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) CHARACTER SET latin1 NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`,`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `created_date`, `updated_date`) VALUES
(1, 'user_1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'user_2', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'user_3', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'user_4', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'user_5', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'user_6', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'user_7', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'user_8', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'user_9', '0000-00-00 00:00:00', '2014-08-27 04:22:11'),
(10, 'user_10', '0000-00-00 00:00:00', '2014-08-27 04:22:11'),
(11, 'user_11', '0000-00-00 00:00:00', '2014-08-27 04:22:11');
