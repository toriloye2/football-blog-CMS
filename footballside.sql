-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2023 at 06:52 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

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
(13, 'Defender', 0),
(14, 'Goalkeeper', 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `player_id` int(11) NOT NULL,
  `comment_text` varchar(700) NOT NULL,
  `category_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`player_id`, `comment_text`, `category_id`, `comment_id`) VALUES
(20, 'hi', 0, 1);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `football_legends`
--

INSERT INTO `football_legends` (`player_id`, `first_name`, `last_name`, `category_id`, `goals`, `appearances`, `images`, `created_at`, `updated_at`) VALUES
(21, 'Lionel', 'Messi', 11, 721, 889, 'images/lionel-messi.jpg', '2023-12-09 05:37:46', '2023-12-09 05:37:46'),
(22, 'Pele', 'Edson  do Nascimento', 11, 1000, 603, 'images/pele.webp', '2023-12-09 05:42:46', '2023-12-09 05:42:46'),
(23, 'Paolo', 'Maldini', 13, 30, 1027, 'images/Maldini.jpg', '2023-12-09 05:43:54', '2023-12-09 05:43:54'),
(24, 'diego', 'Maradona', 12, 344, 160, 'images/diego-maradona1.jpg', '2023-12-09 05:44:52', '2023-12-09 05:44:52'),
(25, 'Eden', 'Harzard', 11, 167, 620, 'images/eden harzaed.png', '2023-12-09 05:45:52', '2023-12-09 05:45:52'),
(26, 'andres', 'Iniesta', 12, 89, 867, 'images/iniesta.jpeg', '2023-12-09 05:47:10', '2023-12-09 05:47:10'),
(27, 'frank', 'lampard', 12, 898, 265, 'images/lampard.jpg', '2023-12-09 05:47:51', '2023-12-09 05:47:51'),
(28, 'ronaldo', 'Nazario', 11, 298, 454, 'images/r9.jpg', '2023-12-09 05:50:02', '2023-12-09 05:50:02'),
(29, 'Zinedine ', 'Zidane', 12, 124, 689, 'images/zidane.jpg', '2023-12-09 05:50:42', '2023-12-09 05:50:42'),
(30, 'Didier', 'Drogba', 11, 302, 685, 'images/Drogba.jpg', '2023-12-09 05:51:27', '2023-12-09 05:51:27');

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
(11, 'toyyib', '$2y$10$dymZ4D0mWQgDmLiIPo2G9.FAWL9P0UwU056u1tBUq82i4CWF7d81y', 'taiyeolabamiji@gmail.com', 0, '2023-12-09 04:49:33'),
(12, 'xrae', '$2y$10$fF39H5eoNE01Ls/3vj/OReNEcbPSwm.1tYrerWpCCbdPm0lA12rYi', 'dshdeb@eimail.com', 1, '2023-12-09 04:50:27');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `football_legends`
--
ALTER TABLE `football_legends`
  MODIFY `player_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
