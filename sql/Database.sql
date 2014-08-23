-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 23, 2014 at 03:00 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `howitzer`
--

-- --------------------------------------------------------

--
-- Table structure for table `angle`
--

CREATE TABLE `angle` (
  `id` tinyint(10) NOT NULL AUTO_INCREMENT,
  `angle` tinyint(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `angle`
--

INSERT INTO `angle` VALUES(1, 5);
INSERT INTO `angle` VALUES(2, 10);
INSERT INTO `angle` VALUES(3, 15);
INSERT INTO `angle` VALUES(4, 20);
INSERT INTO `angle` VALUES(5, 25);
INSERT INTO `angle` VALUES(6, 30);
INSERT INTO `angle` VALUES(7, 35);
INSERT INTO `angle` VALUES(8, 40);
INSERT INTO `angle` VALUES(9, 45);
INSERT INTO `angle` VALUES(10, 50);
INSERT INTO `angle` VALUES(11, 55);
INSERT INTO `angle` VALUES(12, 60);
INSERT INTO `angle` VALUES(13, 65);
INSERT INTO `angle` VALUES(14, 70);
INSERT INTO `angle` VALUES(15, 75);
INSERT INTO `angle` VALUES(16, 80);
INSERT INTO `angle` VALUES(17, 85);

-- --------------------------------------------------------

--
-- Table structure for table `distance`
--

CREATE TABLE `distance` (
  `id` tinyint(5) NOT NULL AUTO_INCREMENT,
  `distance` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `distance`
--

INSERT INTO `distance` VALUES(1, 100);
INSERT INTO `distance` VALUES(2, 200);
INSERT INTO `distance` VALUES(3, 300);
INSERT INTO `distance` VALUES(4, 400);
INSERT INTO `distance` VALUES(5, 500);

-- --------------------------------------------------------

--
-- Table structure for table `howitzer`
--

CREATE TABLE `howitzer` (
  `id` tinyint(10) NOT NULL AUTO_INCREMENT,
  `weight` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `howitzer`
--

INSERT INTO `howitzer` VALUES(1, 1000);
INSERT INTO `howitzer` VALUES(2, 2000);
INSERT INTO `howitzer` VALUES(3, 3000);
INSERT INTO `howitzer` VALUES(4, 4000);
INSERT INTO `howitzer` VALUES(5, 5000);

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `id` tinyint(10) NOT NULL AUTO_INCREMENT,
  `id_shot` tinyint(10) NOT NULL,
  `id_user` tinyint(10) NOT NULL,
  `hit` tinyint(1) NOT NULL,
  `impact` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `result`
--

INSERT INTO `result` VALUES(1, 1, 1, 1, 0);
INSERT INTO `result` VALUES(2, 1, 1, 1, 0);
INSERT INTO `result` VALUES(3, 1, 1, 1, 0);
INSERT INTO `result` VALUES(4, 1, 1, 1, 101);

-- --------------------------------------------------------

--
-- Table structure for table `shot`
--

CREATE TABLE `shot` (
  `id` tinyint(10) NOT NULL AUTO_INCREMENT,
  `id_user` tinyint(10) NOT NULL,
  `id_howitzer` tinyint(10) NOT NULL,
  `id_target` tinyint(10) NOT NULL,
  `id_distance` tinyint(10) NOT NULL,
  `id_speed` tinyint(10) NOT NULL,
  `id_angle` tinyint(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `shot`
--

INSERT INTO `shot` VALUES(1, 1, 1, 1, 1, 1, 1);
INSERT INTO `shot` VALUES(2, 1, 1, 1, 1, 1, 1);
INSERT INTO `shot` VALUES(3, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `speed`
--

CREATE TABLE `speed` (
  `id` tinyint(10) NOT NULL AUTO_INCREMENT,
  `speed` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `speed`
--

INSERT INTO `speed` VALUES(1, 5);
INSERT INTO `speed` VALUES(2, 10);
INSERT INTO `speed` VALUES(3, 15);
INSERT INTO `speed` VALUES(4, 20);
INSERT INTO `speed` VALUES(5, 25);
INSERT INTO `speed` VALUES(6, 30);

-- --------------------------------------------------------

--
-- Table structure for table `target`
--

CREATE TABLE `target` (
  `id` tinyint(10) NOT NULL AUTO_INCREMENT,
  `size` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `target`
--

INSERT INTO `target` VALUES(1, 10);
INSERT INTO `target` VALUES(2, 20);
INSERT INTO `target` VALUES(3, 30);
INSERT INTO `target` VALUES(4, 40);
INSERT INTO `target` VALUES(5, 50);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` tinyint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` VALUES(1, 'user_1');
INSERT INTO `user` VALUES(2, 'user_2');
INSERT INTO `user` VALUES(3, 'user_3');
INSERT INTO `user` VALUES(4, 'user_4');
INSERT INTO `user` VALUES(5, 'user_5');
INSERT INTO `user` VALUES(6, 'user_6');
INSERT INTO `user` VALUES(7, 'user_7');
INSERT INTO `user` VALUES(8, 'user_8');
INSERT INTO `user` VALUES(9, 'user_8');
INSERT INTO `user` VALUES(10, 'user_8');
INSERT INTO `user` VALUES(11, 'user_8');
