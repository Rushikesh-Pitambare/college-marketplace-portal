-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2025 at 10:06 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `collage_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `enrollment_number` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `otp_code` varchar(6) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `enrollment_number`, `name`, `dob`, `email`, `password`, `created_at`, `otp_code`, `otp_expiry`) VALUES
(1, '3344141', 'sameer gawali', '2024-02-10', 'sameer123@gmail.com', '$2y$10$64gbViiBSA2t6fmQ/t1BXuBBAIHe1k4VFhxQqVWIZiEjWOdD2SgIO', '2025-08-02 16:16:52', NULL, NULL),
(2, '2403070', 'Onkar Badrinath Abuj', '2025-08-01', 'abujonkar2004@gmail.com', '$2y$10$3ig4S1S9jtAlMc8FHYIqduwh2JEl5RIRJ4I/mQMoGkSDoFZcs3hPS', '2025-08-12 19:29:01', NULL, NULL),
(3, '306090', 'Rushikesh Mahesh Pitmare', '2025-08-08', 'rushikesh.pitamabre.it.2024@vpkbiet.org', '$2y$10$2X3GACsQOnrIYIGEY8w5YOWBoqw/T74wXtuzXMumPTnM3rGh9SMP6', '2025-08-12 22:11:22', NULL, NULL),
(4, '231090', 'Amol Santosh Arde', '2008-03-07', 'amol.arde2330@gmail.com', '$2y$10$vR2g66ZJuO1lnsuWlkQmYed0KG9Nn06IlHpO44UyCIQPMwLtsSJcG', '2025-08-12 22:23:21', NULL, NULL),
(5, '1230', 'sjkdjkd', '2025-08-01', 'ani.rde2330@gmail.com', '$2y$10$AlsGxvjE3oOlye7XvUbXBu4B92cEshbvPK2UGYhT3RBsj2Q4iJqmK', '2025-08-12 22:26:33', NULL, NULL),
(6, '200380002', 'Saurabh Dinkar Gaikwad', '2000-10-05', 'sgprojectwallah@gmail.com', '$2y$10$CMhugvU3HrexsATdt8nY2.cMBHFcl2C5MFlFamqW1zK7mQwLF4EGK', '2025-08-13 08:01:34', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `enrollment_number` (`enrollment_number`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
