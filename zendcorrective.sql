-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 28, 2016 at 02:39 PM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zendcorrective`
--

-- --------------------------------------------------------

--
-- Table structure for table `rss`
--

CREATE TABLE IF NOT EXISTS `rss` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(250) NOT NULL,
  `site_description` varchar(250) NOT NULL,
  `site_rss_url` varchar(250) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `rss`
--

INSERT INTO `rss` (`id`, `site_name`, `site_description`, `site_rss_url`, `create_date`, `update_date`, `user_id`) VALUES
(2, 'jkljlkjlk', 'fdsafdsafds', 'http://www.youm7.com/rss/SectionRss?SectionID=61', '2016-04-26 11:29:18', '0000-00-00 00:00:00', 1),
(3, 'dsadS', 'DSADSA', 'http://www.youm7.com/rss/SectionRss?SectionID=65', '2016-04-26 11:32:07', '0000-00-00 00:00:00', 7),
(4, 'dsadsa', 'xszdsada', 'http://rss.cnn.com/rss/edition_meast.rss', '2016-04-27 15:58:22', '0000-00-00 00:00:00', 8),
(5, 'fcdsfds', 'dsfdsfdszzzzzzzzzzzzzzzzzzzzz', 'http://rss.cnn.com/rss/edition_world.rss', '2016-04-27 15:59:12', '0000-00-00 00:00:00', 8),
(6, 'nhkjnnlk', 'fdsfds', 'http://www.youm7.com/rss/SectionRss?SectionID=65', '2016-04-27 16:23:37', '0000-00-00 00:00:00', 8);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(250) NOT NULL,
  `photo` varchar(250) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `country` varchar(250) NOT NULL,
  `signture` varchar(250) NOT NULL,
  `status` varchar(11) NOT NULL DEFAULT 'avalible',
  `role` enum('User','Admin') NOT NULL DEFAULT 'User',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `email`, `photo`, `gender`, `country`, `signture`, `status`, `role`) VALUES
(1, 'mohamedkhaled', 'mmm', 'c4ca4238a0b923820dcc509a6f75849b', 'mmm@mmmm.com', '1.jpeg', 'Male', 'Egypt', 'fdsfds', 'Ban', 'Admin'),
(6, 'k', 'kkkkkk', 'c4ca4238a0b923820dcc509a6f75849b', 'kkkk@kkkk.com', '1.jpeg', '', 'Egypt', 'hjkhk', 'Ban', 'User'),
(8, 'k', 'kkkkkkdsadaszzzzzzzzzzz', 'c4ca4238a0b923820dcc509a6f75849b', 'kkkkfdsfds@kkkk.com', '1.jpeg', 'Male', 'Egypt', 'hjkhk', 'Ban', 'Admin'),
(9, 'kdsafds', 'kkkkkk', 'c4ca4238a0b923820dcc509a6f75849b', 'kkkk@kkkk.com', '1.jpeg', '', 'Egypt', 'hjkhk', 'avalible', 'User');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
