-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 16, 2024 at 01:06 AM
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
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` text NOT NULL,
  `content` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `image`, `created_at`, `updated_at`) VALUES
(2, 'Revolutionizing Real Estate Investment with Hamuj Real Estate upp', '<p>The world of real estate is evolving, and Hamuj Real Estate is at the forefront of this transformation. In a market where high costs and complex processes often deter potential investors, our platform upp</p>', 'assets/images/post/1731698783.png', '2024-11-15 18:26:23', '2024-11-15 18:51:19'),
(3, 'Breaking Barriers with Fractional Ownership', '<p>Traditional property ownership has long been reserved for those with significant capital. Hamuj Real Estate changes this narrative by introducing fractional ownership, allowing investors to purchase smaller, affordable land segments. This approach not only makes property investment accessible to a wider audience but also opens doors to high-potential assets that may have previously been out of reach.</p>', 'assets/images/post/1731698812.png', '2024-11-15 18:26:52', '2024-11-15 18:26:52'),
(4, 'Leveraging Technology for Transparency and Growth', '<p>At the heart of our platform is blockchain-inspired technology, designed to ensure transparency and security. Real-time valuation updates provide users with a dynamic view of their investments&rsquo; performance, enabling informed decision-making. Every transaction, from purchase to ownership transfer, is secure, traceable, and seamless.</p>', 'assets/images/post/1731699070.png', '2024-11-15 18:31:10', '2024-11-15 18:31:10'),
(5, 'Empowering Investors with a User-Friendly Experience', '<p>Hamuj Real Estate prioritizes simplicity and inclusivity. From browsing properties to purchasing a segment, every step is designed to be intuitive and efficient. Our platform fosters trust by offering verified documentation, valuation tracking, and secure payment options, ensuring that every user feels confident in their investment journey.</p>', 'assets/images/post/1731699525.png', '2024-11-15 18:38:45', '2024-11-15 18:38:45'),
(6, 'Shaping the Future of Real Estate nn', '<p>With a vision to make property ownership inclusive, Hamuj Real Estate is setting a new standard in real estate investment. By combining traditional principles with modern technology, we&rsquo;re not just transforming how people invest&mdash;we&rsquo;re redefining what&rsquo;s possible in the world of real estate.</p>\r\n<p>Join us in revolutionizing property investment and explore the future with Hamuj Real Estate. vppp</p>', 'assets/images/post/1731700403.png', '2024-11-15 18:39:37', '2024-11-15 18:53:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
