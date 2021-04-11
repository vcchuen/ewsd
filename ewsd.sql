-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2021 at 01:19 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ewsd`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(155) NOT NULL,
  `role` varchar(50) NOT NULL,
  `faculty` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `email`, `password`, `name`, `role`, `faculty`) VALUES
(4, 'voon.chuen@gmail.com', '$2y$10$Hnw0X94qG7lI8WpNH9z1S.TmCKRxc4WDMjWENpHxu3iqDyMsiHzSu', 'Voon', 'Admin', 'None'),
(12, 'lindyyly@gmail.com', '$2y$10$apbgETJ5N5Fqtqe9mJvKC.PRxmdgcPQq6tviopAI8Igz77wv78lrq', 'Lindy', 'Coordinator', 'Art'),
(13, 'voon.chuen1@gmail.com', '$2y$10$rvDOYMF1mLFIyLYWUzEEM.TZhP.u/cUWRLaENrxQ.My7.rjbiBtU.', 'vcc', 'Student', 'Art'),
(15, 'test1@gmail.com', '$2y$10$Ua6ld3PQ4FdH71SfhWMi1ecvAx6ROtVPYQo7mSOldLAz80GlxrJ1u', 'Adam', 'Manager', 'None'),
(16, 'test2@gmail.com', '$2y$10$zVPfZaT4O1WkFkjaQG8sn.jNXuKdtTZNLEn.e7nKRKuhyEuGBAPne', 'Badam', 'Guest', 'IT'),
(17, 'test3@gmail.com', '$2y$10$1k/5lFNdNaRO8caVuR3EFOs4cJK41FHS40v.TOMWwtfhN9pwY12Xi', 'Cadam', 'Guest', 'Art'),
(18, 'wliew10@gmail.com', '$2y$10$cqCnfYlMoefdT8D/tasBPu5zTxP4CwV5760.Ca7g54jX7Shlc2YpW', 'yee wei', 'Admin', 'None');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `comments` varchar(255) NOT NULL,
  `time_posted` datetime NOT NULL,
  `name` varchar(50) NOT NULL,
  `postid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `submission`
--

CREATE TABLE `submission` (
  `id` int(11) NOT NULL,
  `file_name` varchar(250) NOT NULL,
  `uploaded_on` datetime NOT NULL,
  `studentname` varchar(50) NOT NULL,
  `faculty` varchar(50) NOT NULL,
  `description` varchar(300) NOT NULL,
  `comments` varchar(10) DEFAULT NULL,
  `approve` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `submission`
--

INSERT INTO `submission` (`id`, `file_name`, `uploaded_on`, `studentname`, `faculty`, `description`, `comments`, `approve`) VALUES
(28, 'vcc_Uruha_Rushia_-_Portrait.png', '2021-04-09 02:54:58', 'vcc', 'Art', '                    test123', 'false', 'true'),
(29, 'vcc_testpic.jpg', '2021-04-09 02:55:17', 'vcc', 'Art', '                    testpic123', NULL, 'true');

-- --------------------------------------------------------

--
-- Table structure for table `submissiondate`
--

CREATE TABLE `submissiondate` (
  `id` int(11) NOT NULL,
  `submissionDate` datetime NOT NULL,
  `closeNewSubmissionDate` datetime NOT NULL,
  `closeEditSubmissionDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `submissiondate`
--

INSERT INTO `submissiondate` (`id`, `submissionDate`, `closeNewSubmissionDate`, `closeEditSubmissionDate`) VALUES
(1, '2021-04-07 17:44:00', '2021-04-12 17:44:00', '2021-04-21 17:44:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`email`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `submission`
--
ALTER TABLE `submission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `submissiondate`
--
ALTER TABLE `submissiondate`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `submission`
--
ALTER TABLE `submission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `submissiondate`
--
ALTER TABLE `submissiondate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
