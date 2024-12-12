-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2024 at 02:34 PM
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
-- Table structure for table `educational_credential_earned`
--

CREATE TABLE `educational_credential_earned` (
  `credential_id` int(11) NOT NULL,
  `teaching_faculty_id` int(11) DEFAULT NULL,
  `non_teaching_faculty_id` int(11) DEFAULT NULL,
  `highest_degree_attained_code` varchar(50) DEFAULT NULL,
  `bachelors_degree_program_name` varchar(50) DEFAULT NULL,
  `bachelors_degree_code` varchar(50) DEFAULT NULL,
  `masters_degree_program_name` varchar(50) DEFAULT NULL,
  `masters_degree_code` varchar(50) DEFAULT NULL,
  `doctorate_program_name` varchar(50) DEFAULT NULL,
  `doctorate_program_code` varchar(50) DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `non_teaching_faculty_information`
--

CREATE TABLE `non_teaching_faculty_information` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `middle_initial` char(1) DEFAULT NULL,
  `designation_code` varchar(50) DEFAULT NULL,
  `employment_status_code` varchar(50) DEFAULT NULL,
  `gender_code` varchar(50) DEFAULT NULL,
  `professional_license_code` varchar(50) DEFAULT NULL,
  `tenure_of_employment_code` varchar(50) DEFAULT NULL,
  `annual_salary_code` varchar(50) DEFAULT NULL,
  `years_of_service` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teaching_faculty_information`
--

CREATE TABLE `teaching_faculty_information` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `middle_initial` char(1) DEFAULT NULL,
  `employment_status_code` varchar(50) DEFAULT NULL,
  `gender_code` varchar(50) DEFAULT NULL,
  `primary_teaching_discipline_code` varchar(50) DEFAULT NULL,
  `professional_license_code` varchar(50) DEFAULT NULL,
  `tenure_of_employment_code` varchar(50) DEFAULT NULL,
  `faculty_rank_code` varchar(50) DEFAULT NULL,
  `teaching_load_code` varchar(50) DEFAULT NULL,
  `subjects_taught` varchar(255) DEFAULT NULL,
  `annual_salary_code` varchar(50) DEFAULT NULL
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
-- Indexes for table `educational_credential_earned`
--
ALTER TABLE `educational_credential_earned`
  ADD PRIMARY KEY (`credential_id`),
  ADD KEY `fk_teaching_faculty` (`teaching_faculty_id`),
  ADD KEY `fk_non_teaching_faculty` (`non_teaching_faculty_id`);

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `educational_credential_earned`
--
ALTER TABLE `educational_credential_earned`
  MODIFY `credential_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `non_teaching_faculty_information`
--
ALTER TABLE `non_teaching_faculty_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teaching_faculty_information`
--
ALTER TABLE `teaching_faculty_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `educational_credential_earned`
--
ALTER TABLE `educational_credential_earned`
  ADD CONSTRAINT `fk_non_teaching_faculty` FOREIGN KEY (`non_teaching_faculty_id`) REFERENCES `non_teaching_faculty_information` (`id`),
  ADD CONSTRAINT `fk_teaching_faculty` FOREIGN KEY (`teaching_faculty_id`) REFERENCES `teaching_faculty_information` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
