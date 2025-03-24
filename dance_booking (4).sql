-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2025 at 04:57 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dance_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'password123');

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE `admin_user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`id`, `username`, `password_hash`) VALUES
(1, 'admin', 'ef92b778bafe771e89245b89ecbc08a44a4e166c06659911881f383d4473e94f');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `age` int(11) NOT NULL,
  `dance_class` varchar(100) NOT NULL,
  `experience` text DEFAULT NULL,
  `fees` int(11) NOT NULL,
  `timing` varchar(100) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `certificate_status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `name`, `email`, `phone`, `age`, `dance_class`, `experience`, `fees`, `timing`, `booking_date`, `certificate_status`) VALUES
(1, 'de', 'r24589919@gmail.com', '7598960709', 22, 'Hip Hop', '', 1000, '2:00 PM - 2:45 PM', '2025-03-24 14:50:43', 'Pending'),
(2, 'de', 'r24589919@gmail.com', '7598960709', 22, 'Bharatanatyam', '', 2000, '11:30 AM - 1:00 PM', '2025-03-24 14:54:19', 'Pending'),
(3, 'de', 'r24589919@gmail.com', '7598960709', 22, 'Bharatanatyam', 'fdgre', 2000, '11:30 AM - 1:00 PM', '2025-03-24 14:54:34', 'Pending'),
(4, 'de', 'r24589919@gmail.com', '7598960709', 22, 'Bharatanatyam', 'fdgre', 2000, '11:30 AM - 1:00 PM', '2025-03-24 14:58:50', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `level` varchar(50) NOT NULL,
  `duration` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dance_booking`
--

CREATE TABLE `dance_booking` (
  `id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `fees` decimal(10,2) NOT NULL DEFAULT 0.00,
  `timing` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dance_booking`
--

INSERT INTO `dance_booking` (`id`, `class_name`, `description`, `duration`, `image`, `fees`, `timing`) VALUES
(18, 'Fusion Dance', 'A dynamic mix of different dance styles blending tradition and modernity.', 60, 'fusion.jpeg', 1000.00, '10:00 AM - 11:00 AM'),
(19, 'Bharatanatyam', 'A classical Indian dance known for its grace, expressions, and intricate footwork.', 90, 'bharatanatyam.jpeg', 2000.00, '11:30 AM - 1:00 PM'),
(20, 'Hip Hop', 'An energetic dance style with freestyle movements and street dance elements.', 45, 'hiphop.jpeg', 1000.00, '2:00 PM - 2:45 PM'),
(21, 'Folk Dance', 'Traditional dance reflecting the culture and heritage of various regions.', 60, 'folk.jpeg', 900.00, '4:00 PM - 5:00 PM'),
(22, 'Aerobics Dance', 'A high-energy workout combining dance and cardio for fitness.', 50, 'aerobics.jpeg', 800.00, '6:00 PM - 6:50 PM'),
(23, 'Kathak', 'A North Indian classical dance form known for its storytelling, footwork, and spins.', 75, 'kathak.jpeg', 1700.00, '7:00 PM - 8:15 PM'),
(27, 'Tap Dance', 'Tap dance is a rhythmic dance style where dancers create percussive sounds using special tap shoes.', 60, 'uploads/1741195808_tap.jpeg', 1000.00, '5:30 PM - 6:30 PM');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `feedback` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `student_name`, `email`, `rating`, `feedback`, `created_at`) VALUES
(2, 'keerthana', 'mathankikeerthana2005@gmail.com', 4, 'nice experience for me', '2025-03-02 07:27:18'),
(3, 'prasana', 'pra$27ana@gmail.com', 3, 'nice', '2025-03-02 07:42:28'),
(4, 'priya', 'priya@gmail.com', 3, 'very nice', '2025-03-02 14:15:29'),
(5, 'latha', 'latha@gmail.com', 5, 'i am satisfied with work', '2025-03-02 16:34:19'),
(6, 'sri', 'sri@gmail.com', 3, 'good', '2025-03-02 16:37:13'),
(7, 'prasana', 'pra$27ana@gmail.com', 4, 'good', '2025-03-05 04:31:49'),
(8, 'leela', 'leela@gmail.com', 5, 'very nice experiece', '2025-03-05 09:33:33'),
(9, 'raji', 'raji@gmail.com', 5, 'very useful for me', '2025-03-06 07:54:22');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'mathanki', '*A0CA93ADEA7CECD27774D8DDD803717816893B10', '2025-02-26 04:31:06'),
(2, 'priya', '*0976C6407BC62F937325233AB2947A8CF2E790B0', '2025-02-26 04:31:06');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `upi_id` varchar(100) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT 'UPI',
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'mathanki', 'mathankikeerthana2005@gmail.com', '$2y$10$AEx5MfCR9TiIaPcNJ2b39OuKxGDRim10/YQQ/jHXWz8nl7NNjKxV2'),
(2, 'mathanki', 'mathankikeerthana2005@gmail.com', '$2y$10$0I9TgwRkj5GaEjOsyFsvbem2bSN3LkJiSRtSMg34cydPv7u7fNlzO'),
(3, 'priya', 'priya@gmail.com', '$2y$10$xuG8KytXks5GMHt04AdfRuTbfkQSo0r3hF1gpVzwubS8rvV.dLN66'),
(4, 'priya', 'priya@gmail.com', '$2y$10$ku4i.jxqHVqWS5VxDBriB.7ypcI5TmWeUcMDZEz19z41M43xWFonK'),
(5, 'maha', 'maha@gmail.com', '$2y$10$vh5ppTuk1bB08Igu9WxUxub18xuytDTEqHWPtZbSOhP3pPvEqWO4K'),
(6, 'latha', 'latha@gmail.com', '$2y$10$B43iIxi5gj4hCDC4Q7608.IC8sAoYQcF1JSWTvfyoSlS7sfCOuZ.S'),
(7, 'sri', 'sri@gmail.com', '$2y$10$64K1fPcJgA6yD7HMMidgve3ECYJUX/IFRRIx2Zlk7z9x..Fg/Xpqq'),
(8, 'prasana', 'pra$27ana@gmail.com', '$2y$10$avqihK0TtP.9rshYmf8HCuXgzlLXCtnhqfhrIGlAXDMX35xDXw0hO'),
(9, 'leela', 'leela@gmail.com', '$2y$10$RdZN/2eeCDcHpPfHUn6ineOII9UjsOxN.qz6A3g9lwEBLjZg3./km'),
(10, 'raji', 'raji@gmail.com', '$2y$10$oq1/ODv5lg2fD1tDRAQQcePoGD/B7MQ0B2S7V6H7qJH7rNzj3VVim'),
(11, 'prasana', 'pra$27ana@gmail.com', '$2y$10$3BjayucLMfbDK5EM4ux5yusuw7oeS73kq6bWFkmomCIPb7nzpepBG'),
(12, 'krithika', 'krithi@gmail.com', '$2y$10$SgmOY.JLSowhCMm0q029geAJDItk90K.ch1FWfcum2TOig2sI97U6'),
(13, 'shalini', 'shalini@gmail.com', '$2y$10$urfSryLZWn30kdkt.Ci01.NPLCHOZJw2kA7HKoVV1f7g0Cqr/qmDq'),
(14, 'mithra', 'mithra@gmail.com', '$2y$10$DkoVkxD7RbaEatgKQny02.S6gC84PyS6EZ1lNxlnnUeq5jE9w3L8G'),
(15, 'kavya', 'kavya@gmail.com', '$2y$10$.RXclZDKEH4hczCuVjDK9.Dt3pZftdzoflIas.lGlcu9WXoUXpIpW'),
(16, 'raveena', 'raveena@gmail.com', '$2y$10$TGDjHvG47uGWhpW2uGXn/O.s5It5d4Q2JWfuwz793sI6a/aCDJTMS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dance_booking`
--
ALTER TABLE `dance_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dance_booking`
--
ALTER TABLE `dance_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
