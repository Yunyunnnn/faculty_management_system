-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2025 at 08:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `faculty_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `bachelors_degree_earned`
--

CREATE TABLE `bachelors_degree_earned` (
  `id` int(11) NOT NULL,
  `teaching_faculty_id` int(11) DEFAULT NULL,
  `non_teaching_faculty_id` int(11) DEFAULT NULL,
  `bachelors_degree_program_name` varchar(100) DEFAULT NULL,
  `bachelors_degree_code` varchar(100) DEFAULT NULL,
  `bachelors_degree_major` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctorate_degree_earned`
--

CREATE TABLE `doctorate_degree_earned` (
  `id` int(11) NOT NULL,
  `teaching_faculty_id` int(11) DEFAULT NULL,
  `non_teaching_faculty_id` int(11) DEFAULT NULL,
  `doctorate_program_name` varchar(100) DEFAULT NULL,
  `doctorate_program_code` varchar(100) DEFAULT NULL,
  `doctorate_degree_major` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `masters_degree_earned`
--

CREATE TABLE `masters_degree_earned` (
  `id` int(11) NOT NULL,
  `teaching_faculty_id` int(11) DEFAULT NULL,
  `non_teaching_faculty_id` int(11) DEFAULT NULL,
  `masters_degree_program_name` varchar(100) DEFAULT NULL,
  `masters_degree_code` varchar(100) DEFAULT NULL,
  `masters_degree_major` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `non_teaching_faculty_information`
--

CREATE TABLE `non_teaching_faculty_information` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `middle_initial` char(25) DEFAULT NULL,
  `designation_code` varchar(50) DEFAULT NULL,
  `employment_status_code` varchar(50) DEFAULT NULL,
  `gender_code` varchar(50) DEFAULT NULL,
  `professional_license_code` varchar(50) DEFAULT NULL,
  `tenure_of_employment_code` varchar(50) DEFAULT NULL,
  `annual_salary_code` varchar(50) DEFAULT NULL,
  `years_of_service` decimal(5,2) DEFAULT NULL,
  `highest_degree_attained_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teaching_faculty_information`
--

CREATE TABLE `teaching_faculty_information` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `middle_initial` char(25) DEFAULT NULL,
  `employment_status_code` varchar(50) DEFAULT NULL,
  `gender_code` varchar(50) DEFAULT NULL,
  `primary_teaching_discipline_code` varchar(50) DEFAULT NULL,
  `professional_license_code` varchar(50) DEFAULT NULL,
  `tenure_of_employment_code` varchar(50) DEFAULT NULL,
  `faculty_rank_code` varchar(50) DEFAULT NULL,
  `teaching_load_code` varchar(50) DEFAULT NULL,
  `annual_salary_code` varchar(50) DEFAULT NULL,
  `highest_degree_attained_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teaching_faculty_subjects`
--

CREATE TABLE `teaching_faculty_subjects` (
  `id` int(11) NOT NULL,
  `teaching_faculty_id` int(11) DEFAULT NULL,
  `subjects_taught` varchar(255) NOT NULL,
  `semester` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', 'ef92b778bafe771e89245b89ecbc08a44a4e166c06659911881f383d4473e94f');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bachelors_degree_earned`
--
ALTER TABLE `bachelors_degree_earned`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teaching_faculty_id` (`teaching_faculty_id`),
  ADD KEY `non_teaching_faculty_id` (`non_teaching_faculty_id`);

--
-- Indexes for table `doctorate_degree_earned`
--
ALTER TABLE `doctorate_degree_earned`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teaching_faculty_id` (`teaching_faculty_id`),
  ADD KEY `non_teaching_faculty_id` (`non_teaching_faculty_id`);

--
-- Indexes for table `masters_degree_earned`
--
ALTER TABLE `masters_degree_earned`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teaching_faculty_id` (`teaching_faculty_id`),
  ADD KEY `non_teaching_faculty_id` (`non_teaching_faculty_id`);

--
-- Indexes for table `non_teaching_faculty_information`
--
ALTER TABLE `non_teaching_faculty_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teaching_faculty_information`
--
ALTER TABLE `teaching_faculty_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teaching_faculty_subjects`
--
ALTER TABLE `teaching_faculty_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teaching_faculty_id` (`teaching_faculty_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bachelors_degree_earned`
--
ALTER TABLE `bachelors_degree_earned`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `doctorate_degree_earned`
--
ALTER TABLE `doctorate_degree_earned`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `masters_degree_earned`
--
ALTER TABLE `masters_degree_earned`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `non_teaching_faculty_information`
--
ALTER TABLE `non_teaching_faculty_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `teaching_faculty_information`
--
ALTER TABLE `teaching_faculty_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `teaching_faculty_subjects`
--
ALTER TABLE `teaching_faculty_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bachelors_degree_earned`
--
ALTER TABLE `bachelors_degree_earned`
  ADD CONSTRAINT `bachelors_degree_earned_ibfk_1` FOREIGN KEY (`teaching_faculty_id`) REFERENCES `teaching_faculty_information` (`id`),
  ADD CONSTRAINT `bachelors_degree_earned_ibfk_2` FOREIGN KEY (`non_teaching_faculty_id`) REFERENCES `non_teaching_faculty_information` (`id`);

--
-- Constraints for table `doctorate_degree_earned`
--
ALTER TABLE `doctorate_degree_earned`
  ADD CONSTRAINT `doctorate_degree_earned_ibfk_1` FOREIGN KEY (`teaching_faculty_id`) REFERENCES `teaching_faculty_information` (`id`),
  ADD CONSTRAINT `doctorate_degree_earned_ibfk_2` FOREIGN KEY (`non_teaching_faculty_id`) REFERENCES `non_teaching_faculty_information` (`id`);

--
-- Constraints for table `masters_degree_earned`
--
ALTER TABLE `masters_degree_earned`
  ADD CONSTRAINT `masters_degree_earned_ibfk_1` FOREIGN KEY (`teaching_faculty_id`) REFERENCES `teaching_faculty_information` (`id`),
  ADD CONSTRAINT `masters_degree_earned_ibfk_2` FOREIGN KEY (`non_teaching_faculty_id`) REFERENCES `non_teaching_faculty_information` (`id`);

--
-- Constraints for table `teaching_faculty_subjects`
--
ALTER TABLE `teaching_faculty_subjects`
  ADD CONSTRAINT `teaching_faculty_subjects_ibfk_1` FOREIGN KEY (`teaching_faculty_id`) REFERENCES `teaching_faculty_information` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
