-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 17, 2024 at 01:47 PM
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
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text DEFAULT NULL,
  `slug` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `location` text DEFAULT NULL,
  `price` text DEFAULT NULL,
  `size` text DEFAULT NULL,
  `property_images` text DEFAULT NULL,
  `payment_plan` text DEFAULT NULL,
  `brochure` text DEFAULT NULL,
  `land_survey` text DEFAULT NULL,
  `video_link` text DEFAULT NULL,
  `status` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `name`, `slug`, `description`, `location`, `price`, `size`, `property_images`, `payment_plan`, `brochure`, `land_survey`, `video_link`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Luxury Family Home update nn', 'luxury-family-home-update-nn', '<p class=\"project__details--desc mb-20\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat qui ducimus illum modi? perspiciatis accusamus soluta perferendis, ad illum, nesciunt, reiciendis iusto et cupidit Repudiandae provident to consectetur, sapiente, libero iure necessitatibus corporis nulla voluptate, quisquam aut perspiciatis? Fugiat labore aspernatur eius, perspiciatis ut molestiae, delectus rem.</p>\r\n<p class=\"project__details--desc m-0\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulv inar dapibus leo. Ut enim ad minim veniam. when an unknown printer took a galley of type and scrambled it to make a type specimen book.<br />Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat. There are many variations of passages.n</p>\r\n<h3 class=\"project__details--ui__content--title\">This event will allow participants to:</h3>\r\n<ul class=\"project__details--ui__content--wrapper\">\r\n<li class=\"project__details--ui__desc\">&nbsp;Business\'s managers, leaders</li>\r\n<li class=\"project__details--ui__desc\">&nbsp;Downloadable lectures, code and design assets for all projects</li>\r\n<li class=\"project__details--ui__desc\">&nbsp;Anyone who is finding a chance to get the promotion</li>\r\n</ul>', '1421 San Pedro St, Los Angeles, CA', '1244996', '345 by 5677', 'assets/images/property/1731843706_IMG_3459 (1).png', 'assets/images/property/1731795234_featured-grid2.jpg', 'assets/images/property/1731795234_featured-grid3.jpg', 'assets/images/property/1731846463_Hamoj_Ogombo N_page-0001.jpg', 'https://www.youtube.com/embed/V7LOVb3iAKA?si=hjweiHidvSjt6cp1', 'available', '2024-11-16 21:13:54', '2024-11-17 11:27:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
