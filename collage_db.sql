-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2025 at 10:41 AM
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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `payment_id` varchar(50) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_id`, `product_name`, `amount`, `created_at`) VALUES
(1, 'order_RQaufLGi01IALY', 'pay_RQaupQmmssDDQY', 'The Boy With One Name', 45000, '2025-10-07 18:46:51'),
(2, 'order_RQb65TjEDZGWS2', 'pay_RQb6FS9pNmz2mm', 'calci', 67600, '2025-10-07 18:50:51'),
(3, 'order_RQbrC1HJ4rdfyt', 'pay_RQbrXYm8CFp2vg', 'The Boy With One Name', 45000, '2025-10-07 19:35:37'),
(4, 'order_RQbv3ewELNxiOD', 'pay_RQbvUJbjBrUOjX', 'The Boy With One Name', 45000, '2025-10-07 19:39:21'),
(5, 'order_RQvh6HoDkMSevV', 'pay_RQvhR9BbD5nWBO', 'The Boy With One Name', 45000, '2025-10-08 14:59:54'),
(6, 'order_RQws5JIRwsr4lQ', 'pay_RQwsJbdtTimxJM', 'The Boy With One Name', 45000, '2025-10-08 16:08:54'),
(7, 'order_RR0UFJfOlE8ZLM', 'pay_RR0V0R80ANZyPq', 'Shirt', 67000, '2025-10-08 19:41:36'),
(8, 'order_RRJ6B79wdaPFSw', 'pay_RRJ6dnUz98ojXj', 'phone', 4000000, '2025-10-09 13:53:43');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `photo1` varchar(255) DEFAULT NULL,
  `photo2` varchar(255) DEFAULT NULL,
  `photo3` varchar(255) DEFAULT NULL,
  `photo4` varchar(255) DEFAULT NULL,
  `photo5` varchar(255) DEFAULT NULL,
  `photo6` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `title`, `description`, `price`, `photo1`, `photo2`, `photo3`, `photo4`, `photo5`, `photo6`, `created_at`) VALUES
(7, NULL, 'The Boy With One Name', '\'Delightfully magical and brilliantly told\' Abi Elphinstone, author of Sky Song\r\n\r\nTwelve-year-old Jones is an orphan, training as an apprentice hunter alongside his mentor, Maitland, tackling ogres, trolls and all manner of creatures that live in the Badlands – a hidden part of our own world, and which most people think exist only in fairytales and nightmares. But all Jones secretly wants to be is an ordinary boy and to leave the magical world forever...', 450.00, 'uploads/1759827339_book_.jpg', 'uploads/1759827339_img3.jpg', 'uploads/1759827339_img4.jpg', 'uploads/1759827339_img5.jpg', 'uploads/1759827339_img2.jpg', 'uploads/1759827339_bgimageforlogin.png', '2025-10-07 08:55:39'),
(10, 3, 'indina jersy', 'jklawefjwrljrkljreklt', 500.00, 'uploads/1759920017_Screenshot (334).png', 'uploads/1759920017_Screenshot (307).png', 'uploads/1759920017_Screenshot (308).png', 'uploads/1759920017_Screenshot (304).png', 'uploads/1759920017_Screenshot (313).png', 'uploads/1759920017_Screenshot (309).png', '2025-10-08 10:40:17'),
(11, 3, 'Shirt', 'kdjffjfjfhlflef', 670.00, 'uploads/1759932589_images223.jpeg', 'uploads/1759932589_Screenshot (300).png', 'uploads/1759932589_Screenshot (308).png', 'uploads/1759932589_Screenshot (308).png', 'uploads/1759932589_Screenshot (325).png', 'uploads/1759932589_Screenshot (309).png', '2025-10-08 14:09:49'),
(12, 4, 'Kookaburra Beast pro 4.0 English Willow Cricket Bat', 'The Kookaburra Beast Pro 4.0 English Willow Cricket Bat is designed for aggressive stroke play, featuring a powerful profile and striking aesthetics. Here are its key features and specifications:\r\n\r\nFeatures & Specifications:\r\nWillow Type: Handcrafted from high-quality English Willow.\r\nGrade: Typically Grade 4, ensuring durability and performance.\r\nProfile: Large edges with a thick, power-packed spine for explosive shots.\r\nSweet Spot: Mid-to-low, ideal for dynamic front-foot play.\r\nHandle: Semi-oval handle with multi-piece cane construction for enhanced grip and shock absorption.\r\nWeight: Approx. 1160-1220 grams (may vary based on size and preference).', 1450.00, 'uploads/1759945395_images (2).jpeg', 'uploads/1759945395_IMG-20250305-WA0102-1152x1536.jpg', 'uploads/1759945395_IMG-20250305-WA0100-scaled.jpg', 'uploads/1759945395_IMG-20250305-WA0104-1152x1536.jpg', 'uploads/1759945395_images (2).jpeg', 'uploads/1759945395_IMG-20250305-WA0100-scaled.jpg', '2025-10-08 17:43:15'),
(13, 2, 'phone', 'samsung phone', 40000.00, 'uploads/1759992719_ales-nesetril-Im7lZjxeLhg-unsplash.jpg', 'uploads/1759992719_ChatGPT Image Oct 7, 2025, 07_32_43 PM.png', 'uploads/1759992719_images (1).png', 'uploads/1759992719_Gemini_Generated_Image_8uoxoe8uoxoe8uox.png', 'uploads/1759992719_IMG-20250305-WA0100-scaled.jpg', 'uploads/1759992719_Dfd level 0.png', '2025-10-09 06:51:59');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `enrollment_number` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `otp_code` varchar(6) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL,
  `mobaile_number` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `enrollment_number`, `name`, `email`, `password`, `created_at`, `otp_code`, `otp_expiry`, `mobaile_number`) VALUES
(1, '3344141', 'sameer gawali', 'sameer123@gmail.com', '$2y$10$64gbViiBSA2t6fmQ/t1BXuBBAIHe1k4VFhxQqVWIZiEjWOdD2SgIO', '2025-08-02 16:16:52', NULL, NULL, ''),
(2, '2403070', 'Onkar Badrinath Abuj', 'abujonkar2004@gmail.com', '$2y$10$zjWorVMb8XUlAHihI1I/BOAQM/gGw0t3yKGbk2OyEvcA4jtP50bYW', '2025-08-12 19:29:01', NULL, NULL, ''),
(3, '306090', 'Rushikesh Mahesh Pitmare', 'rushikesh.pitamabre.it.2024@vpkbiet.org', '$2y$10$2X3GACsQOnrIYIGEY8w5YOWBoqw/T74wXtuzXMumPTnM3rGh9SMP6', '2025-08-12 22:11:22', NULL, NULL, ''),
(4, '231090', 'Amol Santosh Arde', 'amol.arde2330@gmail.com', '$2y$10$vR2g66ZJuO1lnsuWlkQmYed0KG9Nn06IlHpO44UyCIQPMwLtsSJcG', '2025-08-12 22:23:21', NULL, NULL, ''),
(5, '1230', 'sjkdjkd', 'ani.rde2330@gmail.com', '$2y$10$AlsGxvjE3oOlye7XvUbXBu4B92cEshbvPK2UGYhT3RBsj2Q4iJqmK', '2025-08-12 22:26:33', NULL, NULL, ''),
(6, '200380002', 'Saurabh Dinkar Gaikwad', 'sgprojectwallah@gmail.com', '$2y$10$CMhugvU3HrexsATdt8nY2.cMBHFcl2C5MFlFamqW1zK7mQwLF4EGK', '2025-08-13 08:01:34', NULL, NULL, ''),
(7, '254649', 'Swaraj Kalyan Dhumal', 'swarajdhumal18@gmail.com', '$2y$10$CoqXMPzRPqVyAHEzYwf/WeD6lqSar0gX8EI26dpr3RztNZVeuCoay', '2025-08-13 08:16:10', NULL, NULL, ''),
(8, '211158', 'Onkar Badrinath Abuj', 'omuabuj9356@gmail.com', '$2y$10$nz1jWtbJtvdKjd18SEPpbe1/SUq/eLuNswr6.9sV1dyalCTB5/MKu', '2025-08-14 10:32:37', NULL, NULL, '9881778347'),
(9, '211158221', 'Nachiket Yadav', 'nachiket8975@outlook.com', '$2y$10$/dQosB9WQf4WOQOPbCBWSub5sg6TOBKieIYxh.xpUU1UN9MIabw7q', '2025-08-16 02:36:16', NULL, NULL, '7020538481'),
(10, '24203050', 'pradip paithane', 'paithanepradip@gmail.com', '$2y$10$QHai63F0HjZkPRlesiD.6urgIydxW.85DFTP8A/k6dH5Utn.aXxy.', '2025-09-11 07:58:19', NULL, NULL, '9881778347'),
(11, '37383434', 'Sanket Sonwane', 'sonyasonwane07@gmail.com', '$2y$10$6JZEtVBm/ehobfE3G4frCOHqqcheyvGTdTjDB2D3Ei9sZBOR/Y8/6', '2025-09-15 16:30:00', NULL, NULL, '7020538481'),
(12, '222231', 'Rushikesh Pitambare', 'rushikeshpitambare222@gmail.com', '$2y$10$3kyA0KaEWMNdOcQ0vmd9TOKRhhV/tlDVkMwCSmjoZclaIHjFGczRu', '2025-10-06 04:54:51', NULL, NULL, '9881778347'),
(13, '2403075', 'Rushikesh Mahesh Pitambare', 'rushikesh.pitambare.it.2024@vpkbiet.org', '$2y$10$ZgxcBvh4boCeiy/L81wXj.YC0pom/8xC9Io1VxsHgjrgE7jlRB22m', '2025-10-09 07:56:50', NULL, NULL, '8421575650'),
(14, '24203070', 'Onkar Badrinath Abuj', 'onkar.abuj.it.2024@vpkbiet.org', '$2y$10$RUfc.eebdfKr0S6JTaZ3ce4EjGcNwAiWzpr2qJXSNzwZn7RDizgU.', '2025-10-09 08:22:12', NULL, NULL, '9881778347');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
