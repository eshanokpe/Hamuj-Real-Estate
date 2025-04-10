-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 15, 2024 at 06:44 PM
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
-- Database: `dohmayn_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `abouts`
--

CREATE TABLE `abouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `abouts`
--

INSERT INTO `abouts` (`id`, `title`, `content`, `image`, `created_at`, `updated_at`) VALUES
(3, 'About', '<p class=\"section__heading--desc\">Hamuj Real Estate is a cutting-edge platform dedicated to making property investment accessible, transparent, and secure for everyone. We believe that property ownership shouldn\'t be limited to a select few, which is why we focus on fractional land ownership, allowing investors to purchase smaller, affordable land segments that still hold immense potential. Leveraging blockchain-inspired technology, our platform provides real-time, dynamic valuation updates, ensuring that our users always have a clear view of their investments&rsquo; growth and market value.</p>\r\n<p class=\"section__heading--desc\">With a deep commitment to transparency, security, and user empowerment, Hamuj Real Estate is changing the way people invest in and manage property assets. Our comprehensive approach integrates secure transactions, real-time valuation tracking, and a user-friendly interface, enabling users to make informed decisions confidently. Whether you\'re looking to buy, sell, or manage land assets, Hamuj Real Estate offers the tools you need to thrive in today&rsquo;s property market.</p>', 'assets/images/about/1731672774.png', '2024-11-15 11:10:31', '2024-11-15 11:12:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abouts`
--
ALTER TABLE `abouts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abouts`
--
ALTER TABLE `abouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
