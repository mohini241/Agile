-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2022 at 02:11 PM
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
-- Database: `agile`
--

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `title` varchar(500) DEFAULT NULL,
  `description` varchar(500) NOT NULL,
  `start date` date NOT NULL,
  `end date` date NOT NULL,
  `status` varchar(100) NOT NULL,
  `id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`title`, `description`, `start date`, `end date`, `status`, `id`) VALUES
('Agile scrum board', 'create a website', '2022-04-27', '2022-05-01', 'active', 38),
('Business Intelligence', 'Create graphs', '2022-04-29', '2022-04-30', 'active', 39),
('Data Analysis', 'Twitter dataset', '2022-04-19', '2022-05-07', 'active', 40),
('Facebook API', 'Update, Post, Delete ', '2022-04-28', '2022-04-30', 'active', 41);

-- --------------------------------------------------------

--
-- Table structure for table `project_members`
--

CREATE TABLE `project_members` (
  `project_id` int(100) NOT NULL,
  `member_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project_members`
--

INSERT INTO `project_members` (`project_id`, `member_name`) VALUES
(38, 'rudraksh'),
(38, 'aniket'),
(38, 'abhishek'),
(39, 'rudraksh'),
(40, 'rudraksh'),
(40, 'aniket'),
(40, 'abhishek'),
(41, 'rudraksh'),
(41, 'aniket'),
(41, 'abhishek');

-- --------------------------------------------------------

--
-- Table structure for table `sprint`
--

CREATE TABLE `sprint` (
  `id` int(11) NOT NULL,
  `sprint_name` text DEFAULT NULL,
  `sprint_member` varchar(20) DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sprint`
--

INSERT INTO `sprint` (`id`, `sprint_name`, `sprint_member`, `project_id`, `start_date`, `end_date`) VALUES
(1, 'sprint1', NULL, 38, '2022-04-27', '2022-04-30'),
(2, 'sprint2', NULL, 38, '2022-04-29', '2022-04-30'),
(3, 'sprint3', NULL, 38, '2022-04-29', '2022-04-30');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `task_name` varchar(20) NOT NULL,
  `task_description` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `story_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `insert_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`insert_value`) VALUES
('sprint1'),
('sprint2'),
('sprint1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `usertype` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `usertype`) VALUES
(8, 'mohini', 'Mohinimali241@gmail.com', '5d41402abc4b2a76b9719d911017c592', 'scrummaster'),
(9, 'rudraksh', 'rudraksh.lohiya20@gmail.com', '5d41402abc4b2a76b9719d911017c592', 'teammember'),
(10, 'aniket', 'aniket@gmail.com', '5d41402abc4b2a76b9719d911017c592', 'teammember'),
(11, 'abhishek', 'abhishek@gmail.com', '5d41402abc4b2a76b9719d911017c592', 'teammember'),
(12, 'ojas', 'ojas@gmail.com', '5d41402abc4b2a76b9719d911017c592', 'teammember');

-- --------------------------------------------------------

--
-- Table structure for table `user_story`
--

CREATE TABLE `user_story` (
  `story_id` int(15) NOT NULL,
  `story_name` varchar(50) NOT NULL,
  `story_description` text NOT NULL,
  `story_outcome` text NOT NULL,
  `story_priority` text NOT NULL,
  `story_category` text NOT NULL,
  `story_status` text NOT NULL,
  `sprint_id` varchar(10) DEFAULT NULL,
  `project_id` int(15) NOT NULL,
  `estimated_hr` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_story`
--

INSERT INTO `user_story` (`story_id`, `story_name`, `story_description`, `story_outcome`, `story_priority`, `story_category`, `story_status`, `sprint_id`, `project_id`, `estimated_hr`, `start_date`, `end_date`) VALUES
(9, 'Create ui interface', 'Use bootstrap, figma', 'Completion of UI', 'Medium', 'Design', 'ToDo', '1', 38, NULL, NULL, NULL),
(15, 'nwq', 'sdfsd', 'dsfdsf', 'High', 'Non-Technical', 'InProgress', '1', 38, NULL, NULL, NULL),
(16, 'dd', 'dd', 'ddd', 'Critical', 'Technical', 'Completed', '1', 38, NULL, NULL, NULL),
(17, 'dddd', 'dddddd', 'ddddddd', 'Critical', 'Non-Technical', 'Accepted', '1', 38, NULL, NULL, NULL),
(22, 'cccc', 'cc', 'cc', 'High', 'Non-Technical', 'InProgress', '1', 38, NULL, NULL, NULL),
(23, 'nnnnnnn', 'nnn', 'nn', 'High', 'Technical', 'ToDo', '1', 38, NULL, NULL, NULL),
(24, 'ccx', 'fdf', 'sdfsd', 'High', 'Technical', 'ToDo', '1', 38, NULL, NULL, NULL),
(25, 'completed', 'fsdfdfdsdf', 'sdfdsf', 'Critical', 'Technical', 'Completed', '1', 38, NULL, NULL, NULL),
(26, 'accepted', 'dfsdfmf', 'fdgfdgmf', 'Low', 'Technical', 'Accepted', '1', 38, NULL, NULL, NULL),
(27, 'heee', 'sdfdsf', 'dsfdsf', 'High', 'Testing', 'ToDo', '1', 38, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `sprint`
--
ALTER TABLE `sprint`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ForeignKey_Name` (`project_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_story`
--
ALTER TABLE `user_story`
  ADD PRIMARY KEY (`story_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `sprint`
--
ALTER TABLE `sprint`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_story`
--
ALTER TABLE `user_story`
  MODIFY `story_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sprint`
--
ALTER TABLE `sprint`
  ADD CONSTRAINT `sprint_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
