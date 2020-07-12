-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2020 at 09:11 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simple_cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cid` int(11) NOT NULL,
  `cat_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cid`, `cat_name`) VALUES
(5, 'test12'),
(1, 'testtest');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `comment_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `comment_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `pid`, `uid`, `author`, `comment_date`, `status`, `comment_content`) VALUES
(6, 10, 1, 'Administrator', '2019-05-31 16:03:13', 1, 'lorem lorem ipsum'),
(7, 10, 1, 'Administrator', '2019-06-03 10:43:59', 1, 'Test'),
(8, 10, 3, 'user', '2019-06-03 15:53:12', 0, 'A test comment by a simple user level. Does it save though?');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `oid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`oid`, `title`, `content`) VALUES
(1, 'Site name', 'Tundra');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `title` text NOT NULL,
  `content` longtext NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` varchar(25) NOT NULL,
  `author_id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `comments_status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`title`, `content`, `date`, `author`, `author_id`, `pid`, `comments_status`) VALUES
('Hello world post', '<h1>Hello World</h1>\r\n<p>This is another test post that acts as a dummy.</p>', '2019-05-28 17:27:15', 'Test', 2, 2, 1),
('This is a post create by Administrator', 'Post created by Administrator', '2019-05-31 14:20:10', 'Administrator', 1, 7, 0),
('Lorem Ipsum', 'Lorem ipsum dolor sit amet consectetur adipiscing elit, diam eleifend fringilla facilisi pellentesque neque, et aptent natoque fermentum aliquet scelerisque. Lobortis tortor erat quisque eros porttitor ridiculus pellentesque, consequat habitant tellus velit turpis habitasse magna enim, per suscipit semper donec integer fringilla. Placerat taciti ligula nisi sagittis dictum dis porta, class iaculis sociosqu pharetra phasellus dignissim mi maecenas, in hac odio torquent curabitur lectus.', '2019-05-31 15:59:24', 'Administrator', 1, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts_categories`
--

CREATE TABLE `posts_categories` (
  `pid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `cat_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(25) NOT NULL,
  `display_name` varchar(25) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `access_level` tinyint(4) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `display_name`, `pwd`, `access_level`, `uid`, `user_email`) VALUES
('dev_adm', 'Administrator', '12345', 4, 1, 'admin.test@gmail.com'),
('test', 'Test', '12345', 1, 2, 'test@gmail.com'),
('user', 'user', '12345', 0, 3, 'user@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cid`),
  ADD UNIQUE KEY `cat_name` (`cat_name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`oid`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `display_name` (`display_name`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
