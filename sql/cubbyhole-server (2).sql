-- phpMyAdmin SQL Dump
-- version 4.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 15, 2014 at 02:05 AM
-- Server version: 5.5.37-0+wheezy1
-- PHP Version: 5.4.4-14+deb7u10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cubbyhole-server`
--

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE IF NOT EXISTS `offers` (
`id` int(11) NOT NULL,
  `position_priority` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `month_price` float NOT NULL,
  `size_go` float NOT NULL,
  `maximum_upload_speed` float NOT NULL,
  `maximum_download_speed` float NOT NULL,
  `date_creation` int(22) NOT NULL COMMENT 'timestamp',
  `date_last_edit` int(22) NOT NULL COMMENT 'timestamp',
  `short_description` varchar(255) NOT NULL,
  `long_description` text NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `position_priority`, `title`, `month_price`, `size_go`, `maximum_upload_speed`, `maximum_download_speed`, `date_creation`, `date_last_edit`, `short_description`, `long_description`) VALUES
(1, 10000, 'Free offer', 0, 10, 1, 1, 1402796590, 1402797410, 'sdfdsf', 'dfdsfsdf'),
(2, 1999, 'offer2', 3, 45, 12, 12, 1402797452, 1402797452, 'dfdf sdfsd fsd fdsf', 'sdfdsf dsfdsf sdf sdf sdf'),
(3, 1, 'offer3', 90, 1222, 1223, 1234, 1402797476, 1402797476, 'dsdfssdf sdfsdfsdfsdf', 'df sdfds fdfdf sdfsdsdf sd');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `offer_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `date` int(22) NOT NULL COMMENT 'timestamp',
  `payment_method` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE IF NOT EXISTS `tokens` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(50) NOT NULL,
  `expire` int(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(60) NOT NULL,
  `first_name` varchar(40) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `subscription_date` int(22) NOT NULL COMMENT 'timestamp',
  `last_connection_date` int(22) NOT NULL,
  `subscription_ip` varchar(30) NOT NULL,
  `role` enum('Admin','Support','BI','Customer') NOT NULL,
  `offer_id` int(11) NOT NULL,
  `expire` int(20) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `first_name`, `last_name`, `phone`, `subscription_date`, `last_connection_date`, `subscription_ip`, `role`, `offer_id`, `expire`) VALUES
(22, '124898@supinfo.com', '$2y$10$6BUvquFeHkGrpf.4gR5gtOOSnMQ0G8AzzIcaVA7LfCzau1LC.lJq2', 'jan', 'Lindemann', '15555', 1402623744, 1402623744, '127.0.0.1', 'Admin', 3, 0),
(24, 'edited1122@sdsdfds.fr', '$2y$10$GZsbBXMkxZGAu.rNX7Dbf.0RdFesoqhTh.9TcvvcO9jifbSmVt7ki', 'newbe', 'newbe', '', 1402623744, 1402623744, '', 'Customer', 1, 0),
(25, 'qa@cubbyhole.com', '$2y$10$nKVcGWk6YyD2JV0atUGH.uS9HWWY2RY7N2mynCU9J8XoLsUKEeOVy', 'qa', 'qa', '444444', 1402807550, 1402807550, '127.0.0.1', 'Customer', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `workers`
--

CREATE TABLE IF NOT EXISTS `workers` (
`id` int(11) NOT NULL,
  `location` varchar(120) NOT NULL,
  `ws1` varchar(255) NOT NULL,
  `ws2` varchar(255) NOT NULL,
  `free_space_bytes` int(40) NOT NULL,
  `used_space_bytes` int(20) NOT NULL,
  `date_creation` int(22) NOT NULL,
  `last_update` int(22) NOT NULL COMMENT 'timestamp',
  `status` varchar(55) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `workers`
--

INSERT INTO `workers` (`id`, `location`, `ws1`, `ws2`, `free_space_bytes`, `used_space_bytes`, `date_creation`, `last_update`, `status`) VALUES
(1, 'data center 1', 'http://127.0.0.1:3000/', 'http://127.0.0.1:9999/', 0, 0, 1402802070, 0, 'down'),
(2, 'data center 2', 'http://127.0.0.1:3000/', 'http://127.0.0.1:9999/', 0, 0, 1402806476, 0, 'up');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workers`
--
ALTER TABLE `workers`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `workers`
--
ALTER TABLE `workers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
