-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2025 at 11:02 PM
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
-- Database: `footballside`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `position` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `position`, `user_id`) VALUES
(11, 'Forward', 0),
(12, 'Midfielder', 0),
(13, 'Defender', 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `player_id` int(11) NOT NULL,
  `comment_text` varchar(700) NOT NULL,
  `category_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `commenter_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`player_id`, `comment_text`, `category_id`, `comment_id`, `commenter_name`) VALUES
(30, 'boss', 11, 3, 'toy'),
(22, 'fecrc', 11, 7, 'pomo'),
(25, 'danger', 11, 31, 'eden'),
(29, 'zizou', 12, 33, 'zine'),
(26, 'legend', 12, 34, 'la masia'),
(34, 'SIIIIUUUUUUUUUUUU', 11, 37, 'ororo'),
(35, 'how are you', 11, 38, 'taylor'),
(24, 'sa&#039;nksMLXSx&#039;lm', 12, 41, 'eden'),
(24, 'lkcadjcea', 12, 44, 'eden'),
(25, 'hhhhhhh', 11, 45, 'toy'),
(29, 'vvvvv', 12, 46, 'eden'),
(33, 'bbbbb', 11, 47, 'pomo'),
(24, 'cjfigwrlinef', 12, 54, 'fdgrf'),
(23, 'drvr', 13, 57, 'heloo'),
(32, 'wdjldenjded', 11, 63, 'j lni'),
(32, 'wdjldenjded', 11, 64, 'j lni'),
(24, 'ghjk', 12, 65, 'latest'),
(23, 'rc;k4nnk;5', 13, 66, 'latest'),
(35, 'ewkhecbjev', 11, 67, 'latest'),
(26, 'fgjhkjhgh', 12, 68, 'latest'),
(27, 'chelsea say no more', 12, 69, 'toyyib'),
(23, 'jnbvbn', 13, 70, 'latest'),
(23, 'bnmnv', 13, 71, 'latest');

-- --------------------------------------------------------

--
-- Table structure for table `football_legends`
--

CREATE TABLE `football_legends` (
  `player_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `goals` int(11) NOT NULL,
  `appearances` int(11) NOT NULL,
  `images` varchar(255) NOT NULL,
  `bio` text DEFAULT 'Biography not available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `football_legends`
--

INSERT INTO `football_legends` (`player_id`, `first_name`, `last_name`, `category_id`, `goals`, `appearances`, `images`, `bio`, `created_at`, `updated_at`) VALUES
(23, 'Paolo', 'Maldini', 13, 30, 1027, 'images/Maldini.jpg', NULL, '2023-12-09 05:43:54', '2023-12-09 05:43:54'),
(24, 'diego', 'Maradona', 12, 344, 160, 'images/diego-maradona1.jpg', NULL, '2023-12-09 05:44:52', '2023-12-09 05:44:52'),
(25, 'Eden', 'Harzard', 11, 167, 620, 'images/eden harzaed.png', NULL, '2023-12-09 05:45:52', '2023-12-09 05:45:52'),
(26, 'andres', 'Iniesta', 12, 89, 867, 'images/iniesta.jpeg', NULL, '2023-12-09 05:47:10', '2023-12-09 05:47:10'),
(27, 'frank', 'lampard', 12, 898, 265, 'images/lampard.jpg', NULL, '2023-12-09 05:47:51', '2023-12-09 05:47:51'),
(28, 'ronaldo', 'Nazario', 11, 298, 454, 'images/r9.jpg', NULL, '2023-12-09 05:50:02', '2023-12-09 05:50:02'),
(29, 'Zinedine ', 'Zidane', 12, 124, 689, 'images/zidane.jpg', NULL, '2023-12-09 05:50:42', '2023-12-09 05:50:42'),
(32, 'Lionel', 'Messi', 11, 900, 1166, 'images/lionel-messi.jpg', '\r\nLionel Messi: The Maestro of Football\r\nLionel Andrés Messi, born on June 24, 1987, in Rosario, Argentina, is regarded as one of the greatest football players in history. Known for his extraordinary talent, Messi’s journey began at a young age when he joined Newell’s Old Boys, a local football club, where his natural skill set him apart from his peers.\r\n\r\nAt the age of 10, Messi was diagnosed with growth hormone deficiency (GHD), a condition that stunted his physical development. Despite the challenges, his talent caught the attention of FC Barcelona, who offered to pay for his medical treatment and signed him to their youth academy, La Masia, at the age of 13.\r\n\r\nMessi made his first-team debut for Barcelona in 2004 at just 17 years old, quickly becoming a pivotal player. Over 17 years with the club, he won 10 La Liga titles, 7 Copa del Rey titles, and 4 UEFA Champions League titles, while setting numerous records, including Barcelona\'s all-time leading scorer.\r\n\r\nOn the international stage, Messi faced criticism for Argentina\'s struggles in major tournaments, but his perseverance paid off. In 2021, he led Argentina to victory in the Copa América, and in 2022, he crowned his career by winning the FIFA World Cup, cementing his legacy as a global icon.\r\n\r\nNow playing for Inter Miami in the MLS, Messi continues to inspire millions with his passion, skill, and humility, both on and off the pitch.', '2024-04-15 03:23:34', '2025-01-11 04:00:53'),
(33, 'Didier', 'Drogba', 11, 398, 689, 'images/Drogba.jpg', NULL, '2024-04-15 03:24:07', '2024-04-15 03:24:07'),
(34, 'Cristiano', 'Ronaldo', 0, 1009, 1398, 'images/cr7.webp', NULL, '2024-04-15 03:24:54', '2025-01-12 18:11:50'),
(35, 'Pele ', 'Edson  do Nascimento', 11, 1000, 898, 'images/pele.webp', NULL, '2024-04-15 03:27:45', '2024-04-15 03:27:45');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `password`, `email`, `role`, `date`) VALUES
(21, 'latest', '$2y$10$17cmMLtLX84ijE9pCcIgDuJ7JhsZcFyYHP3jfHgOAqKYqsROkhW8K', 'cjbjbcjb@dhfj.com', 1, '2025-01-05 18:36:48'),
(25, 'xrae', '$2y$10$I4pkES/i5PM5fzO5C3GMjO4Bca1QhNJa2Jwch8E2UZrATTOnO4XsK', 'dfghjkiutfdf@cvhjhfc.com', 0, '2025-01-12 19:40:24'),
(26, 'toyyib', '$2y$10$5YpKX/mHffd30eN50GGIkOmpI4bQWYCurkolt2fHXFO9BDLXEpnFy', 'anlnjw@ebce.com', 0, '2025-01-12 19:43:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `football_legends`
--
ALTER TABLE `football_legends`
  ADD PRIMARY KEY (`player_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `football_legends`
--
ALTER TABLE `football_legends`
  MODIFY `player_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
