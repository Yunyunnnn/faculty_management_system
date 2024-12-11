-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2024 at 10:09 PM
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
  `highest_degree_attained_code` int(11) DEFAULT NULL,
  `bachelors_degree_program_name` varchar(100) DEFAULT NULL,
  `bachelors_degree_code` int(11) DEFAULT NULL,
  `masters_degree_program_name` varchar(100) DEFAULT NULL,
  `masters_degree_code` int(11) DEFAULT NULL,
  `doctorate_program_name` varchar(100) DEFAULT NULL,
  `doctorate_program_code` int(11) DEFAULT NULL
) ;

--
-- Dumping data for table `educational_credential_earned`
--

INSERT INTO `educational_credential_earned` (`credential_id`, `teaching_faculty_id`, `non_teaching_faculty_id`, `highest_degree_attained_code`, `bachelors_degree_program_name`, `bachelors_degree_code`, `masters_degree_program_name`, `masters_degree_code`, `doctorate_program_name`, `doctorate_program_code`) VALUES
(79, 15, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(80, 15, NULL, NULL, 'A', 0, NULL, NULL, NULL, NULL),
(81, 15, NULL, NULL, NULL, NULL, 'C', 0, NULL, NULL),
(82, 15, NULL, NULL, NULL, NULL, NULL, NULL, 'E', 0),
(83, NULL, 16, NULL, 'G', 0, NULL, NULL, NULL, NULL),
(84, NULL, 16, NULL, NULL, NULL, 'I', 0, NULL, NULL),
(85, NULL, 16, NULL, NULL, NULL, NULL, NULL, 'K', 0),
(86, 16, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(87, 16, NULL, NULL, 'none', 0, NULL, NULL, NULL, NULL),
(88, 16, NULL, NULL, NULL, NULL, 'none', 0, NULL, NULL),
(89, 16, NULL, NULL, NULL, NULL, NULL, NULL, 'none', 0);

-- --------------------------------------------------------

--
-- Table structure for table `non_teaching_faculty_information`
--

CREATE TABLE `non_teaching_faculty_information` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `middle_initial` char(1) DEFAULT NULL,
  `designation_code` int(11) DEFAULT NULL,
  `employment_status_code` int(11) DEFAULT NULL,
  `gender_code` int(11) DEFAULT NULL,
  `professional_license_code` int(11) DEFAULT NULL,
  `tenure_of_employment_code` int(11) DEFAULT NULL,
  `annual_salary_code` int(11) DEFAULT NULL,
  `years_of_service` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `non_teaching_faculty_information`
--

INSERT INTO `non_teaching_faculty_information` (`id`, `first_name`, `last_name`, `middle_initial`, `designation_code`, `employment_status_code`, `gender_code`, `professional_license_code`, `tenure_of_employment_code`, `annual_salary_code`, `years_of_service`) VALUES
(16, 'Zian', 'Avila', 'R', 0, 1, 1, 1, 1, 1, 8.00);

-- --------------------------------------------------------

--
-- Table structure for table `teaching_faculty_information`
--

CREATE TABLE `teaching_faculty_information` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `middle_initial` char(1) DEFAULT NULL,
  `employment_status_code` int(11) DEFAULT NULL,
  `gender_code` int(11) DEFAULT NULL,
  `primary_teaching_discipline_code` int(11) DEFAULT NULL,
  `professional_license_code` int(11) DEFAULT NULL,
  `tenure_of_employment_code` int(11) DEFAULT NULL,
  `faculty_rank_code` int(11) DEFAULT NULL,
  `teaching_load_code` int(11) DEFAULT NULL,
  `subjects_taught` varchar(255) DEFAULT NULL,
  `annual_salary_code` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teaching_faculty_information`
--

INSERT INTO `teaching_faculty_information` (`id`, `first_name`, `last_name`, `middle_initial`, `employment_status_code`, `gender_code`, `primary_teaching_discipline_code`, `professional_license_code`, `tenure_of_employment_code`, `faculty_rank_code`, `teaching_load_code`, `subjects_taught`, `annual_salary_code`) VALUES
(15, 'Gojo', 'Saturo', 'S', 2, 1, 2, 1, 1, 1, 1, 'hamburgers, donuts', 1),
(16, 'Nobara', 'Kugisaki', 'A', 2, 2, 3, 2, 2, 3, 2, 'edawdasdfasdasfas', 2);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `teaching_faculty_information`
--
ALTER TABLE `teaching_faculty_information`
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
-- Constraints for table `educational_credential_earned`
--
ALTER TABLE `educational_credential_earned`
  ADD CONSTRAINT `educational_credential_earned_ibfk_1` FOREIGN KEY (`teaching_faculty_id`) REFERENCES `teaching_faculty_information` (`id`),
  ADD CONSTRAINT `educational_credential_earned_ibfk_2` FOREIGN KEY (`non_teaching_faculty_id`) REFERENCES `non_teaching_faculty_information` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
