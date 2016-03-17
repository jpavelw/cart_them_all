-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Mar 16, 2016 at 05:15 AM
-- Server version: 5.5.42
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `jpv8322`
--

USE `jpv8322`;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--


CREATE TABLE `carts` (
  `cart_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `quantity` smallint(5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`cart_id`, `user_id`, `product_id`, `quantity`) VALUES
(11, 8, 3, 1),
(12, 8, 3, 1),
(13, 8, 7, 1),
(14, 8, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(10) NOT NULL,
  `name` varchar(25) NOT NULL,
  `description` varchar(100) NOT NULL,
  `price` float(5,2) NOT NULL,
  `quantity` smallint(5) NOT NULL,
  `image` varchar(100) NOT NULL,
  `sale_price` float(5,2) NOT NULL,
  `on_sale` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `quantity`, `image`, `sale_price`, `on_sale`) VALUES
(1, 'name', 'desc', 9.00, 2, 'assets/img/img.jpg', 89.00, 0),
(2, 'product name 2', 'product desc 2', 5.50, 0, 'assets/img/img.jpg', 0.00, 1),
(3, 'test', 'test2', 123.89, 3, 'assets/img/img.jpg', 45.90, 1),
(4, 'test', 'test2', 123.89, 8, 'assets/img/img.jpg', 45.90, 1),
(5, 'product name 2', 'product desc 2', 5.50, 2, 'assets/img/img.jpg', 0.00, 1),
(6, 'product name 2', 'product desc 2', 5.50, 2, 'assets/img/img.jpg', 0.00, 1),
(7, 'product name 2', 'product desc 2', 5.50, 0, 'assets/img/img.jpg', 0.00, 1),
(8, 'product name 2', 'product desc 2', 5.50, 2, 'assets/img/img.jpg', 0.00, 1),
(9, 'product name 2', 'product desc 2', 5.50, 2, 'assets/img/img.jpg', 0.00, 0),
(10, 'product name 2', 'product desc 2', 5.50, 1, 'assets/img/img.jpg', 0.00, 0),
(11, 'product name 2', 'product desc 2', 5.50, 1, 'assets/img/img.jpg', 0.00, 0),
(12, 'product name 2', 'product desc 2', 5.50, 2, 'assets/img/img.jpg', 0.00, 0),
(13, 'product name 2', 'product desc 2', 5.50, 2, 'assets/img/img.jpg', 0.00, 0),
(14, 'product name 2', 'product desc 2', 5.50, 2, 'assets/img/img.jpg', 0.00, 0),
(15, 'product name 2', 'product desc 2', 5.50, 2, 'assets/img/img.jpg', 0.00, 0),
(16, 'product name 2', 'product desc 2', 5.50, 2, 'assets/img/img.jpg', 0.00, 0),
(17, 'product name 2', 'product desc 2', 5.50, 2, 'assets/img/img.jpg', 0.00, 0),
(18, 'product name 2', 'product desc 2', 5.50, 2, 'assets/img/img.jpg', 0.00, 0),
(19, 'product name 2', 'product desc 2', 5.50, 2, 'assets/img/img.jpg', 0.00, 0),
(20, 'product name 2', 'product desc 2', 5.50, 2, 'assets/img/img.jpg', 0.00, 0),
(21, 'product name 2', 'product desc 2', 5.50, 2, 'assets/img/img.jpg', 0.00, 0),
(22, 'product name 2', 'product desc 2', 5.50, 2, 'assets/img/img.jpg', 0.00, 0),
(23, 'product name 2', 'product desc 2', 5.50, 2, 'assets/img/img.jpg', 0.00, 0),
(24, 'product name 2', 'product desc 2', 5.50, 2, 'assets/img/img.jpg', 0.00, 0),
(25, 'product name 2', 'product desc 2', 5.50, 2, 'assets/img/img.jpg', 0.00, 1),
(26, 'product name 2', 'product desc 2', 5.50, 2, 'assets/img/img.jpg', 0.00, 1),
(27, 'Say', 'Say', 55.00, 1, 'assets/img/img.jpg', 45.00, 1),
(28, 'Some thing', 'More thing', 89.00, 8, 'assets/img/6e593501831767b.png', 45.00, 1),
(29, 'No', 'yes', 78.00, 78, 'assets/img/4d6e23233998a613.png', 70.00, 0),
(30, 'Edit', 'Element', 89.90, 3, 'assets/img/img.jpg', 0.00, 0),
(31, 'Test', 'Desc', 78.00, 78, 'assets/img/3aedeb0a756321e9.png', 78.00, 1),
(32, 'Yes', 'Yes', 1.00, 1, 'assets/img/41fb5b3e5137222a.png', 9.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `user_name` varchar(10) NOT NULL,
  `password` char(64) NOT NULL,
  `salt` char(16) NOT NULL,
  `is_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `password`, `salt`, `is_admin`) VALUES
(3, 'user1', 'f9762e4b4ba09ba4209aad9760b7b83a18d67d4feb6fffee88a19094c55da5f9', '24cfa2d45019b6a9', 0),
(4, 'admin3', '8f937482a1b34cee0cafdd31d183cdeabadffefd523e7a2d015cda2701bc20d1', '6d0f2f5732a6b3', 0),
(5, 'admin2', 'a069b6e2eb6b77b0f0ff992adfa7b68239ed270de51d120401d5b0ac9a0e6ad4', '6986ad8875d5c426', 0),
(6, 'admin9', 'd010f589c2affba8741eab384f93b3478f3516e86d9c06fbeb1accf3bb60ce49', '2dd6304b5431d23e', 0),
(8, 'admin', 'e9ff9971441d84527db52c8fc44fc5580ce7fcae218f32635c97bf31b7b81378', '318dc74429123cbf', 1),
(9, 'awsui', 'a02b3e2c219c5d75ffef6c034c094b57b4eba0afdea596ae8714b6493752b0fd', '3a410cfe6e7c9ce7', 0),
(10, 'aws io', 'e98c3b448256b46a8dcb8b9a27d7b076962fb8b3c9b5c8b5bd26f18703234c75', '6ae2dddfb2766a7', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
