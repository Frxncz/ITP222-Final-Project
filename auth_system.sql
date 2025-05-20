-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2025 at 04:28 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auth_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `trip_plans`
--

CREATE TABLE `trip_plans` (
  `username` varchar(100) NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `activities` text DEFAULT NULL,
  `info` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trip_plans`
--

INSERT INTO `trip_plans` (`username`, `city`, `region`, `activities`, `info`) VALUES
('Sykielnub', 'Mandaluyong', 'Philippines', 'Hiking, Mountain Biking', 'Transportation');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `failed_attempts` int(11) DEFAULT 0,
  `lock_until` datetime DEFAULT NULL,
  `reset_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `failed_attempts`, `lock_until`, `reset_code`) VALUES
(10, 'sikyel', 'ecubezas@gmail.com', '$2y$10$RThmfiUJkZuakJyNtifk8O69Doj3qOsmMEYNXzMzYi2jMkqntMISy', 5, '2025-05-13 04:39:06', NULL),
(11, 'sikyelnub', 'guardsshield@gmail.com', '$2y$10$h6n3SscNJDHkDSQuRDL5m.MjrtiqymI/tH9MvsHqTzGTXjwWohkaK', 0, NULL, NULL),
(12, 'Sykielnub', 'secubeza@gmail.com', '$2y$10$j/ITnrrShCbGG7M29fQn3OmSWKkkIggtTWCNdtKd1OSy9eVe4Wzn2', 0, NULL, '475177');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `trip_plans`
--
ALTER TABLE `trip_plans`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
