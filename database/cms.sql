-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2020 at 09:46 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(3) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(1, 'JavaScript'),
(2, 'CSS');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(3) NOT NULL,
  `comment_post_id` int(3) NOT NULL,
  `comment_author_id` int(3) NOT NULL,
  `comment_content` varchar(255) NOT NULL,
  `comment_date` date NOT NULL,
  `comment_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment_post_id`, `comment_author_id`, `comment_content`, `comment_date`, `comment_status`) VALUES
(1, 1, 1, 'This is a very fun post!', '2020-09-23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(3) NOT NULL,
  `post_author_id` int(3) NOT NULL,
  `post_category_id` int(3) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_content` text NOT NULL,
  `post_image` text NOT NULL,
  `post_date` date NOT NULL,
  `post_tags` varchar(255) NOT NULL,
  `post_comments_count` int(255) NOT NULL DEFAULT 0,
  `post_status` tinyint(4) NOT NULL DEFAULT 0,
  `post_views` int(255) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `post_author_id`, `post_category_id`, `post_title`, `post_content`, `post_image`, `post_date`, `post_tags`, `post_comments_count`, `post_status`, `post_views`) VALUES
(1, 1, 1, 'Vue JS', 'Yeet', 'sc.PNG', '2020-09-22', 'CSS', 1, 1, 2),
(2, 1, 1, 'React JS', 'haha', 'iOS13_RedDark_FlareZephyr.jpeg', '2020-09-28', 'Javascript, react', 0, 1, 0),
(3, 1, 1, 'Hello world!', 'afadsf', 'kgD3Bnd.jpg', '2020-10-05', 'CSS', 0, 1, 0),
(4, 1, 1, 'ASDFASFASFDASFDF', 'asfd', 'wp3087307.jpg', '2020-10-05', 'afds', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(3) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_isadmin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `user_email`, `user_password`, `user_isadmin`) VALUES
(1, 'Wardell', 'zeewhylin@gmail.com', '$2y$10$xiK8xajw2tjLL4oR0s/Ea.WSAViOw0xYcehpPmx7PKPZzOaciBu.2', 1),
(2, 'John', 'johndoe@gmail.com', '$2y$10$7fIFy4ZxhTc8bH9XvfkjLOqProdHvP9K4YlDCcE2WlwvAL8IXCiYy', 1),
(3, 'Steph', 'steph@gmail.com', '$2y$10$UPv1Ue9NVeUUl61tbFxSx.SmJagx8HKfPcX0a0x/Xnojzj0Xed1vi', 0),
(6, 'mary', 'mary@gmail.com', '$2y$10$AV7/ZrdIO7LacXlYLg1pTeq3EpHYiv9UgmPmfX6.TMoaQ8bEBP/ce', 0);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_author_id` (`comment_author_id`),
  ADD KEY `comment_post_id` (`comment_post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_author_id` (`post_author_id`),
  ADD KEY `post_category_id` (`post_category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`comment_author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`comment_post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`post_author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`post_category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
