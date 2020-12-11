-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 03, 2020 at 07:56 PM
-- Server version: 5.7.29-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vartvalds`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_guests`
--

CREATE TABLE `active_guests` (
  `ip` varchar(15) NOT NULL,
  `timestamp` int(11) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `active_users`
--

CREATE TABLE `active_users` (
  `username` varchar(30) NOT NULL,
  `timestamp` int(11) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `active_users`
--

INSERT INTO `active_users` (`username`, `timestamp`) VALUES
('Administratorius', 1607016317);

-- --------------------------------------------------------

--
-- Table structure for table `banned_users`
--

CREATE TABLE `banned_users` (
  `username` varchar(30) NOT NULL,
  `timestamp` int(11) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`) VALUES
(21, 'Kaunas'),
(20, 'Vilnius');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `client_username` varchar(30) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `client_surname` varchar(100) NOT NULL,
  `tickets_count` int(11) NOT NULL,
  `trip_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trains`
--

CREATE TABLE `trains` (
  `nr` int(11) NOT NULL,
  `seats_count` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trains`
--

INSERT INTO `trains` (`nr`, `seats_count`) VALUES
(10, 100),
(3310, 30);

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `id` int(11) NOT NULL,
  `departure_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ticket_count` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `train_nr` int(11) NOT NULL,
  `departure_city_id` int(11) NOT NULL,
  `arrival_city_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`id`, `departure_time`, `ticket_count`, `price`, `train_nr`, `departure_city_id`, `arrival_city_id`) VALUES
(29, '2020-12-17 15:10:00', 30, '5', 3310, 21, 20);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(30) NOT NULL,
  `password` varchar(32) DEFAULT NULL,
  `userid` varchar(32) DEFAULT NULL,
  `userlevel` tinyint(1) UNSIGNED NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `timestamp` int(11) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `userid`, `userlevel`, `email`, `timestamp`) VALUES
('Valdytojas', 'fe01ce2a7fbac8fafaed7c982a04e229', 'f508febebdc922ea0dd364e32749a629', 5, 'demo@ktu.lt', 1604541574),
('Administratorius', 'eabd8ce9404507aa8c22714d3f5eada9', 'dccbeb31909f58f3b8d3e4ee12031238', 9, 'demo@ktu.lt', 1607016317),
('Vartotojas', 'fe01ce2a7fbac8fafaed7c982a04e229', '9a47f4552955b91bcd8850d73b00e703', 1, 'demo@ktu.lt', 1330553730),
('tomas', 'eabd8ce9404507aa8c22714d3f5eada9', 'c8b44fdf8198415039804932463451e6', 1, 'aaa@gmail.com', 1607013430),
('tomas1', 'eabd8ce9404507aa8c22714d3f5eada9', '587edb570d8fc83793a5723c8a335157', 1, 'aaa1@gmail.com', 1604540549),
('vadybininkas', 'eabd8ce9404507aa8c22714d3f5eada9', 'bc3c3df153710274559b7fad57d9cf66', 5, 'aaa0@gmail.com', 1607013280);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active_guests`
--
ALTER TABLE `active_guests`
  ADD PRIMARY KEY (`ip`);

--
-- Indexes for table `active_users`
--
ALTER TABLE `active_users`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `banned_users`
--
ALTER TABLE `banned_users`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_trip_id` (`trip_id`);

--
-- Indexes for table `trains`
--
ALTER TABLE `trains`
  ADD PRIMARY KEY (`nr`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_train_nr` (`train_nr`),
  ADD KEY `fk_departure_city_id` (`departure_city_id`),
  ADD KEY `fk_arrival_city_id` (`arrival_city_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD KEY `username` (`username`),
  ADD KEY `username_2` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `trains`
--
ALTER TABLE `trains`
  MODIFY `nr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3311;
--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `fk_trip_id` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`);

--
-- Constraints for table `trips`
--
ALTER TABLE `trips`
  ADD CONSTRAINT `fk_arrival_city_id` FOREIGN KEY (`arrival_city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `fk_departure_city_id` FOREIGN KEY (`departure_city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `fk_train_nr` FOREIGN KEY (`train_nr`) REFERENCES `trains` (`nr`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
