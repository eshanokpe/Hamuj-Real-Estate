-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 09, 2025 at 12:07 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `last_login` varchar(255) NOT NULL,
  `login_ip` varchar(255) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `last_login`, `login_ip`, `otp`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$10$SDWpI4m9YUWunhV9hP/spuxDlU25RYtkN52ts4CzC5fZjnHxv.Zwq', '', '', '', '', NULL, '2024-11-09 17:28:25', '2024-11-09 17:28:25');

-- --------------------------------------------------------

--
-- Table structure for table `buys`
--

CREATE TABLE `buys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_email` text DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `selected_size_land` varchar(255) DEFAULT NULL,
  `remaining_size` varchar(255) NOT NULL,
  `total_price` double(10,2) NOT NULL,
  `status` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `buys`
--

INSERT INTO `buys` (`id`, `user_id`, `user_email`, `property_id`, `transaction_id`, `selected_size_land`, `remaining_size`, `total_price`, `status`, `created_at`, `updated_at`) VALUES
(14, 11, 'eshanokpe77@gmail.com', 1, 14, '1', '300', 209998.00, 'available', '2024-12-14 19:32:51', '2024-12-14 19:32:51'),
(15, 10, 'eshanokpe@gmail.com', 1, 15, '0', '300', 209998.00, 'available', '2024-12-15 12:25:35', '2024-12-19 07:24:34'),
(18, 10, 'eshanokpe@gmail.com', 1, 18, '1', '300', 209998.00, 'available', '2024-12-16 20:24:04', '2024-12-16 20:24:04'),
(19, 10, 'eshanokpe@gmail.com', 1, 20, '1', '300', 209998.00, 'available', '2024-12-16 20:30:27', '2024-12-16 20:30:27'),
(20, 11, 'eshanokpe77@gmail.com', 1, 1, '1', '', 20999800.00, 'tranfer', '2024-12-22 17:36:12', '2024-12-22 17:36:12'),
(21, 26, 'eshanokpe@gmail.com', 1, 21, '1', '300', 289000.00, 'sold', '2025-01-12 06:29:28', '2025-01-12 06:29:28'),
(22, 29, 'eshanokpe77@gmail.com', 1, 27, '1', '300', 25800.00, 'available', '2025-04-07 04:56:56', '2025-04-07 04:56:56'),
(23, 29, 'eshanokpe77@gmail.com', 1, 28, '1', '299', 25800.00, 'sold out', '2025-04-07 07:56:27', '2025-04-07 07:56:27'),
(24, 29, 'eshanokpe77@gmail.com', 1, 29, '1', '299', 25800.00, 'available', '2025-04-07 07:57:12', '2025-04-07 07:57:12'),
(25, 29, 'eshanokpe77@gmail.com', 1, 30, '1', '299', 25800.00, 'available', '2025-04-07 08:14:50', '2025-04-07 08:14:50'),
(26, 29, 'eshanokpe77@gmail.com', 1, 31, '1', '299', 25800.00, 'available', '2025-04-07 08:17:04', '2025-04-07 08:17:04'),
(27, 29, 'eshanokpe77@gmail.com', 1, 32, '1', '299', 25800.00, 'available', '2025-04-07 08:25:53', '2025-04-07 08:25:53'),
(28, 29, 'eshanokpe77@gmail.com', 1, 33, '1', '299', 25800.00, 'available', '2025-04-07 08:27:48', '2025-04-07 08:27:48');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `author_name` varchar(255) NOT NULL,
  `author_email` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_detials`
--

CREATE TABLE `contact_detials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `first_phone` varchar(255) DEFAULT NULL,
  `second_phone` varchar(255) DEFAULT NULL,
  `first_email` varchar(255) DEFAULT NULL,
  `second_email` varchar(255) DEFAULT NULL,
  `first_address` text DEFAULT NULL,
  `second_address` text DEFAULT NULL,
  `site_logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `contactUs_logo` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_detials`
--

INSERT INTO `contact_detials` (`id`, `company_name`, `first_phone`, `second_phone`, `first_email`, `second_email`, `first_address`, `second_address`, `site_logo`, `favicon`, `contactUs_logo`, `created_at`, `updated_at`) VALUES
(1, 'Dohmayn', '+234 805 712 1255', '+234 805 712 1255', 'email@gmail.com', 'secondemail@gmail.com', 'Address', NULL, 'assets/images/logo/673781b09e8f3.png', 'assets/images/logo/673781b09ea84.png', 'assets/images/logo/6780dbb5da267.jpg', '2024-11-15 16:10:17', '2025-01-10 07:35:01');

-- --------------------------------------------------------

--
-- Table structure for table `dropdown_items`
--

CREATE TABLE `dropdown_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_item_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `created_at`, `updated_at`) VALUES
(1, 'What types of solutions does Infoscert provide?', 'asnwer', '2024-11-15 12:21:32', '2024-11-15 12:21:32'),
(2, 'often are Continuous Professional Development (CPD) courses required?', 'ssssvvv', '2024-11-15 12:26:55', '2024-11-15 12:34:25');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `slug` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(4, 'Home', 'home', '2024-11-10 14:21:06', '2024-11-10 14:21:06'),
(5, 'About', 'about', '2024-11-10 14:21:23', '2024-11-10 14:21:23'),
(6, 'Properties', 'properties', '2024-11-10 14:21:34', '2024-11-10 14:21:34'),
(8, 'FAQs', 'faqs', '2024-11-10 14:21:54', '2024-11-10 14:21:54'),
(9, 'Contact', 'contact', '2024-11-10 14:22:05', '2024-11-10 14:22:05');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_11_09_172245_create_admins_table', 2),
(6, '2024_11_09_210419_create_menu_items_table', 3),
(7, '2024_11_10_145241_create_dropdown_items_table', 4),
(8, '2024_11_15_114316_create_abouts_table', 5),
(9, '2024_11_15_124143_create_vision_missions_table', 6),
(10, '2024_11_15_131943_create_faqs_table', 7),
(11, '2024_11_15_165658_create_contact_detials_table', 8),
(12, '2024_11_15_185814_create_posts_table', 9),
(13, '2024_11_15_204908_create_comments_table', 10),
(14, '2024_11_16_211606_create_properties_table', 11),
(15, '2024_11_23_115714_create_terms_table', 12),
(16, '2024_11_23_170415_create_privacies_table', 13),
(17, '2024_11_23_180114_create_transactions_table', 14),
(18, '2024_11_26_192758_create_buys_table', 15),
(19, '2024_11_30_083059_create_offerprices_table', 16),
(20, '2024_11_30_142252_create_property_price_updates_table', 17),
(21, '2024_12_13_180255_create_virtual_accounts_table', 18),
(22, '2024_12_14_165546_create_wallet_transactions_table', 19),
(23, '2024_12_15_142323_create_sells_table', 20),
(24, '2024_12_21_142328_add_confirmation_to_transfers_table', 21),
(25, '2024_12_21_145240_create_notifications_table', 22),
(26, '2024_12_29_103747_create_property_valuations_table', 23),
(27, '2024_12_29_160424_create_referral_logs_table', 24),
(28, '2024_12_29_163712_remove_unique_from_referral_code_in_referral_logs', 25),
(29, '2025_01_05_101603_create_neighborhood_categories_table', 26),
(30, '2025_01_05_101801_add_neighborhood_category_id_to_properties_table', 26),
(31, '2025_01_05_102850_create_neighborhoods_table', 27),
(32, '2025_01_05_152019_create_sociallinks_table', 28),
(33, '2025_01_08_175124_create_property_valuation_predictions_table', 29),
(34, '2025_01_18_214723_create_property_valuation_summaries_table', 30),
(35, '2025_01_26_193221_add_recipient_details_to_transactions_table', 31),
(36, '2025_01_26_215701_add_recipient_details_to_transactions_table', 32),
(37, '2025_03_29_085433_add_commission_to_referral_logs', 33),
(38, '2025_03_29_090836_add_status_to_referral_logs', 34),
(39, '2025_04_01_195146_add_app_passcode_to_users_table', 35),
(40, '2025_04_05_041851_add_auth_method_to_users_table', 36),
(41, '2025_04_05_063547_add_auth_method_fields_to_users_table', 37),
(42, '2025_04_06_064315_add_source_to_transactions_table', 38),
(43, '2025_04_06_121957_add_metadata_to_transactions_table', 39),
(44, '2025_04_07_085445_add_pin_columns_to_users_table', 40),
(45, '2025_04_07_185927_create_user_activities_table', 41),
(46, '2025_04_07_190130_add_last_login_to_users_table', 41),
(47, '2025_04_07_192341_create_permission_tables', 42);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `neighborhoods`
--

CREATE TABLE `neighborhoods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `neighborhood_category_id` bigint(20) UNSIGNED NOT NULL,
  `neighborhood_name` varchar(255) NOT NULL,
  `distance` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `neighborhoods`
--

INSERT INTO `neighborhoods` (`id`, `property_id`, `neighborhood_category_id`, `neighborhood_name`, `distance`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Fairlop station', '0.65', '2025-01-05 09:36:19', '2025-01-05 10:49:48'),
(2, 1, 1, 'Tradefair', '0.33', '2025-01-05 09:58:42', '2025-01-05 09:58:42'),
(3, 1, 2, 'Station', '1.3', '2025-01-05 13:09:21', '2025-01-05 13:09:21');

-- --------------------------------------------------------

--
-- Table structure for table `neighborhood_categories`
--

CREATE TABLE `neighborhood_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `neighborhood_categories`
--

INSERT INTO `neighborhood_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Residential', '2025-01-05 09:19:10', '2025-01-05 09:19:10'),
(2, 'Commercial', '2025-01-05 09:19:10', '2025-01-05 09:19:10'),
(3, 'Recreational', '2025-01-05 09:19:10', '2025-01-05 09:19:10'),
(4, 'Industrial', '2025-01-05 09:19:10', '2025-01-05 09:19:10'),
(5, 'Educationally', '2025-01-05 09:19:10', '2025-01-05 11:37:21');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('0ca83616-d173-4c09-a249-9d94fe200bb9', 'App\\Notifications\\PropertyValuationPredictionNotification', 'App\\Models\\User', 17, '{\"notification_status\":\"PropertyValuationPredictionNotification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"current_market_value\":\"825800.00\",\"future_market_value\":\"835800.00\",\"future_date\":\"11 April, 2025\",\"percentage_increase\":543}', NULL, '2025-01-22 22:29:28', '2025-01-22 22:29:28'),
('0d099868-030e-4b2d-abd8-7d1f69e64fd5', 'App\\Notifications\\PropertyValuationNotification', 'App\\Models\\User', 30, '{\"notification_status\":\"Property Valuation Notification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"market_value\":\"500000.00\",\"percentage_increase\":234}', NULL, '2025-04-08 08:19:09', '2025-04-08 08:19:09'),
('1cd3bade-8a92-4677-bc50-de0d5580d32d', 'App\\Notifications\\PropertyValuationNotification', 'App\\Models\\User', 19, '{\"notification_status\":\"Property Valuation Notification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"market_value\":\"250000.00\",\"percentage_increase\":67}', NULL, '2025-04-08 08:18:35', '2025-04-08 08:18:35'),
('1ecda09b-7f35-4987-8297-743fa56dd263', 'App\\Notifications\\PropertyValuationPredictionNotification', 'App\\Models\\User', 31, '{\"notification_status\":\"PropertyValuationPredictionNotification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"current_market_value\":\"825800.00\",\"future_market_value\":\"835800.00\",\"future_date\":\"11 April, 2025\",\"percentage_increase\":543}', NULL, '2025-01-22 22:29:46', '2025-01-22 22:29:46'),
('271a2cc6-4977-4746-a4ca-59245a6e2593', 'App\\Notifications\\PropertyValuationPredictionNotification', 'App\\Models\\User', 15, '{\"notification_status\":\"PropertyValuationPredictionNotification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"current_market_value\":\"825800.00\",\"future_market_value\":\"835800.00\",\"future_date\":\"11 April, 2025\",\"percentage_increase\":543}', NULL, '2025-01-22 22:29:27', '2025-01-22 22:29:27'),
('34890cd6-fd97-4a11-a8da-9708d9590825', 'App\\Notifications\\PropertyValuationPredictionNotification', 'App\\Models\\User', 29, '{\"notification_status\":\"PropertyValuationPredictionNotification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"current_market_value\":\"825800.00\",\"future_market_value\":\"835800.00\",\"future_date\":\"11 April, 2025\",\"percentage_increase\":543}', NULL, '2025-01-22 22:29:43', '2025-01-22 22:29:43'),
('3d3190c0-14a6-4b94-bae0-d0bd8aa30b93', 'App\\Notifications\\PropertyValuationNotification', 'App\\Models\\User', 15, '{\"notification_status\":\"Property Valuation Notification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"market_value\":\"500000.00\",\"percentage_increase\":234}', NULL, '2025-04-08 08:18:53', '2025-04-08 08:18:53'),
('3d36b046-5a98-405b-aa2f-bc470196cf00', 'App\\Notifications\\PropertyValuationPredictionNotification', 'App\\Models\\User', 12, '{\"notification_status\":\"PropertyValuationPredictionNotification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"current_market_value\":\"825800.00\",\"future_market_value\":\"835800.00\",\"future_date\":\"11 April, 2025\",\"percentage_increase\":543}', NULL, '2025-01-22 22:29:25', '2025-01-22 22:29:25'),
('481e3dc5-b326-4973-92c2-5d589d197712', 'App\\Notifications\\PropertyValuationPredictionNotification', 'App\\Models\\User', 31, '{\"notification_status\":\"PropertyValuationPredictionNotification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"current_market_value\":\"825800.00\",\"future_market_value\":\"845800.00\",\"future_date\":\"23 January, 2025\",\"percentage_increase\":551}', NULL, '2025-01-22 22:26:18', '2025-01-22 22:26:18'),
('543a61b6-e4f1-4d26-ac2e-c831d403840f', 'App\\Notifications\\PropertyValuationNotification', 'App\\Models\\User', 12, '{\"notification_status\":\"Property Valuation Notification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"market_value\":\"250000.00\",\"percentage_increase\":67}', NULL, '2025-04-08 08:18:25', '2025-04-08 08:18:25'),
('570c49f1-b889-47a7-bc9a-c165ea6b37e3', 'App\\Notifications\\PropertyValuationNotification', 'App\\Models\\User', 18, '{\"notification_status\":\"Property Valuation Notification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"market_value\":\"250000.00\",\"percentage_increase\":67}', NULL, '2025-04-08 08:18:33', '2025-04-08 08:18:33'),
('59212aea-34b0-4303-851f-3a204c32fba7', 'App\\Notifications\\PropertyValuationNotification', 'App\\Models\\User', 26, '{\"notification_status\":\"Property Valuation Notification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"market_value\":\"250000.00\",\"percentage_increase\":67}', NULL, '2025-04-08 08:18:37', '2025-04-08 08:18:37'),
('5c8970b1-ca4f-4be2-a9bb-a32b1ecec7cb', 'App\\Notifications\\PropertyValuationNotification', 'App\\Models\\User', 29, '{\"notification_status\":\"Property Valuation Notification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"market_value\":\"250000.00\",\"percentage_increase\":67}', NULL, '2025-04-08 08:18:39', '2025-04-08 08:18:39'),
('5d541dc2-035c-4c86-a658-9c9b2ebe3a33', 'App\\Notifications\\RecipientSubmittedNotification', 'App\\Models\\User', 12, '{\"notification_status\":\"Recipient Submitted Notification\",\"property_id\":1,\"property_slug\":\"luxury-family-home-update-nn\",\"property_name\":\"Luxury Family Home update nn\",\"property_image\":\"assets\\/images\\/property\\/1731843706_IMG_3459 (1).png\",\"land_size\":\"1\",\"total_price\":\"2580000\",\"status\":\"pending\",\"created_date\":\"2025-04-08T18:49:11.516448Z\",\"reference\":\"TRANS-ZGUQM7MMCU\",\"sender_id\":26,\"recipient_id\":\"12\",\"property_mode\":\"transfer\",\"message\":\"You have received \\u20a625,800.00 asset transfer from . Please accept the transfer.\"}', NULL, '2025-04-08 17:49:11', '2025-04-08 17:49:11'),
('5d586777-5a66-48b8-b413-bc180caa7292', 'App\\Notifications\\PropertyValuationPredictionNotification', 'App\\Models\\User', 15, '{\"notification_status\":\"PropertyValuationPredictionNotification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"current_market_value\":\"825800.00\",\"future_market_value\":\"845800.00\",\"future_date\":\"23 January, 2025\",\"percentage_increase\":551}', NULL, '2025-01-22 22:25:59', '2025-01-22 22:25:59'),
('5f56fc9f-9caa-4d15-b9d1-c9a41f770972', 'App\\Notifications\\RecipientSubmittedNotification', 'App\\Models\\User', 12, '{\"notification_status\":\"Recipient Submitted Notification\",\"property_id\":1,\"property_slug\":\"luxury-family-home-update-nn\",\"property_name\":\"Luxury Family Home update nn\",\"property_image\":\"assets\\/images\\/property\\/1731843706_IMG_3459 (1).png\",\"land_size\":\"1\",\"total_price\":\"2580000\",\"status\":\"pending\",\"created_date\":\"2025-04-08T18:37:27.668336Z\",\"reference\":\"TRANS-PAPPMVGFDV\",\"sender_id\":26,\"recipient_id\":\"12\",\"property_mode\":\"transfer\",\"message\":\"You have received \\u20a625,800.00 asset transfer from . Please accept the transfer.\"}', NULL, '2025-04-08 17:37:27', '2025-04-08 17:37:27'),
('624b9a40-dc28-48c9-8a51-4955562f6958', 'App\\Notifications\\PropertyValuationNotification', 'App\\Models\\User', 12, '{\"notification_status\":\"Property Valuation Notification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"market_value\":\"500000.00\",\"percentage_increase\":234}', NULL, '2025-04-08 08:18:50', '2025-04-08 08:18:50'),
('685fd241-b8ed-440a-906f-ab581ee75cf1', 'App\\Notifications\\PropertyValuationNotification', 'App\\Models\\User', 18, '{\"notification_status\":\"Property Valuation Notification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"market_value\":\"500000.00\",\"percentage_increase\":234}', NULL, '2025-04-08 08:18:59', '2025-04-08 08:18:59'),
('6a44e422-6380-4665-a7cf-4fd307397330', 'App\\Notifications\\PropertyValuationPredictionNotification', 'App\\Models\\User', 19, '{\"notification_status\":\"PropertyValuationPredictionNotification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"current_market_value\":\"825800.00\",\"future_market_value\":\"835800.00\",\"future_date\":\"11 April, 2025\",\"percentage_increase\":543}', NULL, '2025-01-22 22:29:37', '2025-01-22 22:29:37'),
('6eb24c72-a333-41a1-b17e-e7540896e0c5', 'App\\Notifications\\PropertyValuationPredictionNotification', 'App\\Models\\User', 19, '{\"notification_status\":\"PropertyValuationPredictionNotification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"current_market_value\":\"825800.00\",\"future_market_value\":\"845800.00\",\"future_date\":\"23 January, 2025\",\"percentage_increase\":551}', NULL, '2025-01-22 22:26:07', '2025-01-22 22:26:07'),
('7c1f244e-2631-4ca9-83a1-02a3afb03b0f', 'App\\Notifications\\PropertyValuationPredictionNotification', 'App\\Models\\User', 12, '{\"notification_status\":\"PropertyValuationPredictionNotification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"current_market_value\":\"825800.00\",\"future_market_value\":\"845800.00\",\"future_date\":\"23 January, 2025\",\"percentage_increase\":551}', NULL, '2025-01-22 22:25:56', '2025-01-22 22:25:56'),
('7d3b8f35-24aa-4836-ad73-219c287ab5d4', 'App\\Notifications\\PropertyValuationNotification', 'App\\Models\\User', 29, '{\"notification_status\":\"Property Valuation Notification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"market_value\":\"500000.00\",\"percentage_increase\":234}', NULL, '2025-04-08 08:19:07', '2025-04-08 08:19:07'),
('7f4fb1fc-1666-4511-ae7b-7253b2db962a', 'App\\Notifications\\SenderTransferNotification', 'App\\Models\\User', 26, '{\"notification_status\":\"senderTransferNotification\",\"property_name\":\"Luxury Family Home update nn\",\"land_size\":\"1\",\"total_price\":25800,\"reference\":\"TRANS-ZGUQM7MMCU\",\"status\":\"pending\",\"message\":\"You have initiated a property transfer. Please wait for recipient to accept.\"}', NULL, '2025-04-08 17:49:14', '2025-04-08 17:49:14'),
('8601fd8c-c18a-45bd-bd55-eb2f16cc5a1a', 'App\\Notifications\\PropertyValuationPredictionNotification', 'App\\Models\\User', 30, '{\"notification_status\":\"PropertyValuationPredictionNotification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"current_market_value\":\"825800.00\",\"future_market_value\":\"835800.00\",\"future_date\":\"11 April, 2025\",\"percentage_increase\":543}', NULL, '2025-01-22 22:29:44', '2025-01-22 22:29:44'),
('87ad5b79-6fcf-4494-ae77-083a3a778518', 'App\\Notifications\\PropertyValuationPredictionNotification', 'App\\Models\\User', 31, '{\"notification_status\":\"PropertyValuationPredictionNotification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"current_market_value\":\"825800.00\",\"future_market_value\":\"840800.00\",\"future_date\":\"23 May, 2025\",\"percentage_increase\":547}', NULL, '2025-01-22 22:24:22', '2025-01-22 22:24:22'),
('8b6f230d-34b9-4c7e-bbed-3ae2e0b82337', 'App\\Notifications\\PropertyValuationPredictionNotification', 'App\\Models\\User', 30, '{\"notification_status\":\"PropertyValuationPredictionNotification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"current_market_value\":\"825800.00\",\"future_market_value\":\"840800.00\",\"future_date\":\"23 May, 2025\",\"percentage_increase\":547}', NULL, '2025-01-22 22:24:15', '2025-01-22 22:24:15'),
('8f020526-d2aa-44b8-9c33-2e179bef4737', 'App\\Notifications\\PropertyValuationPredictionNotification', 'App\\Models\\User', 26, '{\"notification_status\":\"PropertyValuationPredictionNotification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"current_market_value\":\"825800.00\",\"future_market_value\":\"845800.00\",\"future_date\":\"23 January, 2025\",\"percentage_increase\":551}', NULL, '2025-01-22 22:26:10', '2025-01-22 22:26:10'),
('8f7a5bf2-b147-4f8c-aee0-75f36a720ead', 'App\\Notifications\\PropertyValuationPredictionNotification', 'App\\Models\\User', 18, '{\"notification_status\":\"PropertyValuationPredictionNotification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"current_market_value\":\"825800.00\",\"future_market_value\":\"845800.00\",\"future_date\":\"23 January, 2025\",\"percentage_increase\":551}', NULL, '2025-01-22 22:26:05', '2025-01-22 22:26:05'),
('8ff893cb-71d9-4b12-9f91-d791c7e14050', 'App\\Notifications\\PropertyValuationNotification', 'App\\Models\\User', 31, '{\"notification_status\":\"Property Valuation Notification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"market_value\":\"500000.00\",\"percentage_increase\":234}', NULL, '2025-04-08 08:19:12', '2025-04-08 08:19:12'),
('9550fe6f-5486-40f8-bba8-18e4c145ddc6', 'App\\Notifications\\PropertyValuationNotification', 'App\\Models\\User', 15, '{\"notification_status\":\"Property Valuation Notification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"market_value\":\"250000.00\",\"percentage_increase\":67}', NULL, '2025-04-08 08:18:28', '2025-04-08 08:18:28'),
('a7238c76-a57b-4eca-aed6-b98a97c0fc15', 'App\\Notifications\\PropertyValuationPredictionNotification', 'App\\Models\\User', 18, '{\"notification_status\":\"PropertyValuationPredictionNotification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"current_market_value\":\"825800.00\",\"future_market_value\":\"835800.00\",\"future_date\":\"11 April, 2025\",\"percentage_increase\":543}', NULL, '2025-01-22 22:29:34', '2025-01-22 22:29:34'),
('b1b4b5a4-be94-4a4e-9b24-c9074c3de7dd', 'App\\Notifications\\PropertyValuationPredictionNotification', 'App\\Models\\User', 30, '{\"notification_status\":\"PropertyValuationPredictionNotification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"current_market_value\":\"825800.00\",\"future_market_value\":\"845800.00\",\"future_date\":\"23 January, 2025\",\"percentage_increase\":551}', NULL, '2025-01-22 22:26:15', '2025-01-22 22:26:15'),
('b2b94d49-f9c1-4745-9696-235267454546', 'App\\Notifications\\PropertyValuationNotification', 'App\\Models\\User', 31, '{\"notification_status\":\"Property Valuation Notification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"market_value\":\"250000.00\",\"percentage_increase\":67}', NULL, '2025-04-08 08:18:43', '2025-04-08 08:18:43'),
('b7ec0a35-4afa-4bc6-b819-f14785772aca', 'App\\Notifications\\PropertyValuationNotification', 'App\\Models\\User', 30, '{\"notification_status\":\"Property Valuation Notification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"market_value\":\"250000.00\",\"percentage_increase\":67}', NULL, '2025-04-08 08:18:41', '2025-04-08 08:18:41'),
('c2344659-8d19-4d6c-bad4-cff6cc33a1d4', 'App\\Notifications\\PropertyValuationNotification', 'App\\Models\\User', 17, '{\"notification_status\":\"Property Valuation Notification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"market_value\":\"500000.00\",\"percentage_increase\":234}', NULL, '2025-04-08 08:18:57', '2025-04-08 08:18:57'),
('c9f54c7f-980d-4a7e-a8d8-66a34beff495', 'App\\Notifications\\PropertyValuationPredictionNotification', 'App\\Models\\User', 29, '{\"notification_status\":\"PropertyValuationPredictionNotification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"current_market_value\":\"825800.00\",\"future_market_value\":\"845800.00\",\"future_date\":\"23 January, 2025\",\"percentage_increase\":551}', NULL, '2025-01-22 22:26:13', '2025-01-22 22:26:13'),
('cf15444c-c6ee-4030-ae91-e00307288f67', 'App\\Notifications\\PropertyValuationNotification', 'App\\Models\\User', 26, '{\"notification_status\":\"Property Valuation Notification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"market_value\":\"500000.00\",\"percentage_increase\":234}', NULL, '2025-04-08 08:19:04', '2025-04-08 08:19:04'),
('cfac6f91-009f-44f8-86d8-d15a1543ab17', 'App\\Notifications\\PropertyValuationNotification', 'App\\Models\\User', 19, '{\"notification_status\":\"Property Valuation Notification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"market_value\":\"500000.00\",\"percentage_increase\":234}', NULL, '2025-04-08 08:19:02', '2025-04-08 08:19:02'),
('d99e3899-7729-45be-b049-b5fa68bd8ff8', 'App\\Notifications\\SenderTransferNotification', 'App\\Models\\User', 26, '{\"notification_status\":\"senderTransferNotification\",\"property_name\":\"Luxury Family Home update nn\",\"land_size\":\"1\",\"total_price\":25800,\"reference\":\"TRANS-W82YOYLHEZ\",\"status\":\"pending\",\"message\":\"You have initiated a property transfer. Please wait for recipient to accept.\"}', NULL, '2025-04-08 17:38:47', '2025-04-08 17:38:47'),
('d9e282a7-a7e9-442a-9e69-25d052f8ac90', 'App\\Notifications\\PropertyValuationNotification', 'App\\Models\\User', 17, '{\"notification_status\":\"Property Valuation Notification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"market_value\":\"250000.00\",\"percentage_increase\":67}', NULL, '2025-04-08 08:18:30', '2025-04-08 08:18:30'),
('e22eac61-2f91-40bf-b612-ad9f62b51a9c', 'App\\Notifications\\RecipientSubmittedNotification', 'App\\Models\\User', 12, '{\"notification_status\":\"Recipient Submitted Notification\",\"property_id\":1,\"property_slug\":\"luxury-family-home-update-nn\",\"property_name\":\"Luxury Family Home update nn\",\"property_image\":\"assets\\/images\\/property\\/1731843706_IMG_3459 (1).png\",\"land_size\":\"1\",\"total_price\":\"2580000\",\"status\":\"pending\",\"created_date\":\"2025-04-08T18:38:45.148543Z\",\"reference\":\"TRANS-W82YOYLHEZ\",\"sender_id\":26,\"recipient_id\":\"12\",\"property_mode\":\"transfer\",\"message\":\"You have received \\u20a625,800.00 asset transfer from . Please accept the transfer.\"}', NULL, '2025-04-08 17:38:45', '2025-04-08 17:38:45'),
('e28e8f52-4e03-45a8-9238-768331fb94e0', 'App\\Notifications\\PropertyValuationPredictionNotification', 'App\\Models\\User', 26, '{\"notification_status\":\"PropertyValuationPredictionNotification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"current_market_value\":\"825800.00\",\"future_market_value\":\"835800.00\",\"future_date\":\"11 April, 2025\",\"percentage_increase\":543}', NULL, '2025-01-22 22:29:40', '2025-01-22 22:29:40'),
('e3543847-74e0-472d-a55d-b45a71413ed9', 'App\\Notifications\\PropertyValuationPredictionNotification', 'App\\Models\\User', 17, '{\"notification_status\":\"PropertyValuationPredictionNotification\",\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"current_market_value\":\"825800.00\",\"future_market_value\":\"845800.00\",\"future_date\":\"23 January, 2025\",\"percentage_increase\":551}', NULL, '2025-01-22 22:26:02', '2025-01-22 22:26:02');

-- --------------------------------------------------------

--
-- Table structure for table `offerprices`
--

CREATE TABLE `offerprices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` int(11) NOT NULL,
  `buy_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offerprices`
--

INSERT INTO `offerprices` (`id`, `property_id`, `buy_id`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, 13, 200000.00, '2024-11-30 07:52:35', '2024-11-30 07:52:35');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` text NOT NULL,
  `slug` text NOT NULL,
  `content` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `image`, `created_at`, `updated_at`) VALUES
(2, 'Revolutionizing Real Estate Investment with Hamuj Real Estate upp', 'revolutionizing-real-estate-lnvestment-with-hamuj-rea-estate-upp', '<p>The world of real estate is evolving, and Hamuj Real Estate is at the forefront of this transformation. In a market where high costs and complex processes often deter potential investors, our platform upp</p>', 'assets/images/post/1731698783.png', '2024-11-15 18:26:23', '2024-11-15 18:51:19'),
(3, 'Breaking Barriers with Fractional Ownership', 'breaking-barriers', '<p>Traditional property ownership has long been reserved for those with significant capital. Hamuj Real Estate changes this narrative by introducing fractional ownership, allowing investors to purchase smaller, affordable land segments. This approach not only makes property investment accessible to a wider audience but also opens doors to high-potential assets that may have previously been out of reach.</p>', 'assets/images/post/1731698812.png', '2024-11-15 18:26:52', '2024-11-15 18:26:52'),
(4, 'Leveraging Technology for Transparency and Growth', 'leveraging-technology', '<p>At the heart of our platform is blockchain-inspired technology, designed to ensure transparency and security. Real-time valuation updates provide users with a dynamic view of their investments&rsquo; performance, enabling informed decision-making. Every transaction, from purchase to ownership transfer, is secure, traceable, and seamless.</p>', 'assets/images/post/1731699070.png', '2024-11-15 18:31:10', '2024-11-15 18:31:10'),
(5, 'Empowering Investors with a User-Friendly Experience', 'empowering-investors', '<p>Hamuj Real Estate prioritizes simplicity and inclusivity. From browsing properties to purchasing a segment, every step is designed to be intuitive and efficient. Our platform fosters trust by offering verified documentation, valuation tracking, and secure payment options, ensuring that every user feels confident in their investment journey.</p>', 'assets/images/post/1731699525.png', '2024-11-15 18:38:45', '2024-11-15 18:38:45'),
(6, 'Shaping the Future of Real Estate nn', 'shaping-the-future', '<p>With a vision to make property ownership inclusive, Hamuj Real Estate is setting a new standard in real estate investment. By combining traditional principles with modern technology, we&rsquo;re not just transforming how people invest&mdash;we&rsquo;re redefining what&rsquo;s possible in the world of real estate.</p>\r\n<p>Join us in revolutionizing property investment and explore the future with Hamuj Real Estate. vppp</p>', 'assets/images/post/1731700403.png', '2024-11-15 18:39:37', '2024-11-15 18:53:23');

-- --------------------------------------------------------

--
-- Table structure for table `privacies`
--

CREATE TABLE `privacies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `privacies`
--

INSERT INTO `privacies` (`id`, `content`, `created_at`, `updated_at`) VALUES
(1, '<h2 style=\"text-align: justify;\">Privacy Policy</h2>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<h3 style=\"text-align: justify;\">Consumer Privacy Policy Highlights</h3>\r\n<p style=\"text-align: justify;\">Protecting your privacy is important to us; we want to be open with you on how and why we use your personal information. Below are some key highlights of our policy, however you can still view our full privacy policy here.</p>\r\n<h3 style=\"text-align: justify;\">Who we are</h3>\r\n<p style=\"text-align: justify;\">This privacy policy covers Dohmayn platform.</p>\r\n<p style=\"text-align: justify;\">Sources of personal data</p>\r\n<p style=\"text-align: justify;\">We process personal data that we receive from:</p>\r\n<div class=\"s3\" style=\"text-align: justify;\"><span class=\"s2\">&bull; </span>You: when you get in touch with us, create and use your Dohmayn Account, make use of our websites and services, enquire about a property or request a valuation, or apply for a job with us.</div>\r\n<div class=\"s3\" style=\"text-align: justify;\"><span class=\"s2\">&bull; </span>Our members ( Real estate company&rsquo;s and Real Estate developer&rsquo;s): when we advertise there properties on our sites or needs to conduct their business checks.</div>\r\n<div class=\"s3\" style=\"text-align: justify;\"><span class=\"s2\">&bull; </span>Third parties: land registry , OSSG</div>\r\n<div class=\"s3\" style=\"text-align: justify;\"><span class=\"s2\">&bull; </span>Public available sources such as CAC .</div>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<h3 style=\"text-align: justify;\">Purpose and lawful basis</h3>\r\n<p style=\"text-align: justify;\">We rely on a mixture of performance of contract, legitimate interests, consent and legal obligations to process your personal data in order to:</p>\r\n<div class=\"s4\" style=\"text-align: justify;\"><span class=\"s2\">&bull; </span>Advertise properties on our sites.</div>\r\n<div class=\"s4\" style=\"text-align: justify;\"><span class=\"s2\">&bull; </span>Build property databases, valuation and surveyor tools.</div>\r\n<div class=\"s4\" style=\"text-align: justify;\"><span class=\"s2\">&bull; </span>Provide current and historical market and property trends.</div>\r\n<div class=\"s4\" style=\"text-align: justify;\"><span class=\"s2\">&bull; </span>Provide services such as:</div>\r\n<div class=\"s4\" style=\"text-align: justify;\">&nbsp;</div>\r\n<div class=\"s5\" style=\"text-align: justify;\">1. Enabling you to get all information about properties and track dynamic property valuations over time</div>\r\n<div class=\"s5\" style=\"text-align: justify;\">2. Resolve any queries or complaints you may have</div>\r\n<div class=\"s5\" style=\"text-align: justify;\">3. Customize and enrich your experience on our sites.</div>\r\n<div class=\"s5\" style=\"text-align: justify;\">4. Process your job application and consider you for our vacancies.</div>\r\n<div class=\"s5\" style=\"text-align: justify;\">5. Help keep our site safe and secure.</div>\r\n<div class=\"s5\" style=\"text-align: justify;\">6. Improve our site and services and to help trouble shoot.</div>\r\n<div class=\"s5\" style=\"text-align: justify;\">7. Monitor for quality assurance and internal training.</div>\r\n<div class=\"s5\" style=\"text-align: justify;\">&nbsp;</div>\r\n<h3 style=\"text-align: justify;\">How long we keep it for</h3>\r\n<p style=\"text-align: justify;\">We will only retain your personal information for as long as necessary to fulfil the purposes we collected it for, including for any legal, accounting, or reporting requirements. To determine the appropriate retention period for personal information so that it can no longer be associated with you.</p>\r\n<h3 class=\"s6\" style=\"text-align: justify;\">Contact us</h3>\r\n<p class=\"s6\" style=\"text-align: justify;\">If you have any questions about this policy, ho e use your personal data, wish to exercise any of your rights, or want to report a suspected breach of your personal data, please contact us at <a href=\"mailto:dpo@dohmayn.com\"><span class=\"s7\">dpo@dohmayn.com</span></a> or alternatively you can write to Data protection Officer, 1637, Ibukun House Ademola Adetokunbo, Victoria Island, Lagos.</p>\r\n<h3 class=\"s6\" style=\"text-align: justify;\">Change of Purpose</h3>\r\n<p class=\"s6\" style=\"text-align: justify;\">We will only use your personal information for the purposes for which we collected it, unless we reasonably consider that we need to use it for another reason and that reason is compatible with the original purpose. If you wish to get an explanation as to how the processing for new purpose is compatible with the original purpose, please contact us. If we need to use your personal information for an unrelated purpose, we will notify you and we will explain the legal basis which allows us to do so. Please note that we may process your personal information without your knowledge or consent, in compliance with the above rules, where this required or permitted by law.</p>\r\n<h3 class=\"s6\" style=\"text-align: justify;\">Change to this policy</h3>\r\n<p class=\"s6\" style=\"text-align: justify;\">We may change the terms of this policy at anytime. Any changes we may make to this policy in the future will be posted on our platforms and displayed on screen when you use Our App.</p>\r\n<p class=\"s6\" style=\"text-align: justify;\">You may be required to read and accept any revised Policy to continue your use of our Platfroms. The amended terms will be made available with new uploads or updates of the App and will be displayed in the Privacy Policy section of the App.</p>\r\n<p class=\"s6\" style=\"text-align: justify;\">Please check back frequently to see any updates or changes to this policy, as you will be deemed to accept such changes from your continued use of our platforms.</p>\r\n<p class=\"s6\" style=\"text-align: justify;\"><strong>Issue date:</strong> 5<span class=\"s8\">th</span> January 2025<a name=\"_GoBack\"></a></p>\r\n<p class=\"s6\" style=\"text-align: justify;\">&nbsp;</p>', '2024-11-23 16:20:35', '2024-11-23 16:35:39');

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
  `state` text DEFAULT NULL,
  `city` text DEFAULT NULL,
  `country` text DEFAULT NULL,
  `price` text DEFAULT NULL,
  `lunch_price` double DEFAULT NULL,
  `percentage_increase` decimal(5,0) DEFAULT NULL,
  `size` text DEFAULT NULL,
  `available_size` text DEFAULT NULL,
  `gazette_number` text DEFAULT NULL,
  `tenure_free` text DEFAULT NULL,
  `property_images` text DEFAULT NULL,
  `payment_plan` text DEFAULT NULL,
  `brochure` text DEFAULT NULL,
  `contract_deed` text DEFAULT NULL,
  `land_survey` text DEFAULT NULL,
  `video_link` text DEFAULT NULL,
  `google_map` text DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `status` text DEFAULT NULL,
  `property_state` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `neighborhood_category_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `name`, `slug`, `description`, `location`, `state`, `city`, `country`, `price`, `lunch_price`, `percentage_increase`, `size`, `available_size`, `gazette_number`, `tenure_free`, `property_images`, `payment_plan`, `brochure`, `contract_deed`, `land_survey`, `video_link`, `google_map`, `year`, `status`, `property_state`, `created_at`, `updated_at`, `neighborhood_category_id`) VALUES
(1, 'Luxury Family Home update nn', 'luxury-family-home-update-nn', '<p class=\"project__details--desc mb-20\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat qui ducimus illum modi? perspiciatis accusamus soluta perferendis, ad illum, nesciunt, reiciendis iusto et cupidit Repudiandae provident to consectetur, sapiente, libero iure necessitatibus corporis nulla voluptate, quisquam aut perspiciatis? Fugiat labore aspernatur eius, perspiciatis ut molestiae, delectus rem.</p>\r\n<p class=\"project__details--desc m-0\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulv inar dapibus leo. Ut enim ad minim veniam. when an unknown printer took a galley of type and scrambled it to make a type specimen book.<br />Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat. There are many variations of passages.n</p>\r\n<h3 class=\"project__details--ui__content--title\">This event will allow participants to:</h3>\r\n<ul class=\"project__details--ui__content--wrapper\">\r\n<li class=\"project__details--ui__desc\">&nbsp;Business\'s managers, leaders</li>\r\n<li class=\"project__details--ui__desc\">&nbsp;Downloadable lectures, code and design assets for all projects</li>\r\n<li class=\"project__details--ui__desc\">&nbsp;Anyone who is finding a chance to get the promotion</li>\r\n</ul>', '1421 San Pedro St', 'Jigawa', 'IKORODU(Laspotech)', 'Nigeria', '500000.00', 150000, 233, '300', '300', '73/73/1996, Source (OSSG Lagos state)', 'Freehold', 'assets/images/property/1731843706_IMG_3459 (1).png', 'assets/images/property/1731795234_featured-grid2.jpg', 'assets/images/property/1731795234_featured-grid3.jpg', 'assets/images/property/1732440393_Hamoj_Ogombo N_page-0001.jpg', 'assets/images/property/1731846463_Hamoj_Ogombo N_page-0001.jpg', 'https://www.youtube.com/embed/V7LOVb3iAKA?si=hjweiHidvSjt6cp1', 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d19868.373358018045!2d-0.11951900000000001!3d51.503186!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487604b900d26973%3A0x4291f3172409ea92!2slastminute.com%20London%20Eye!5e0!3m2!1sen!2sus!4v1699801088151!5m2!1sen!2sus', '2023', 'available', NULL, '2024-11-16 21:13:54', '2025-04-08 08:18:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `property_price_updates`
--

CREATE TABLE `property_price_updates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `previous_price` decimal(15,2) DEFAULT NULL,
  `previous_percentage_increase` decimal(5,0) DEFAULT NULL,
  `previous_year` year(4) DEFAULT NULL,
  `updated_price` decimal(15,2) DEFAULT NULL,
  `percentage_increase` decimal(5,0) DEFAULT NULL,
  `updated_year` year(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_price_updates`
--

INSERT INTO `property_price_updates` (`id`, `property_id`, `previous_price`, `previous_percentage_increase`, `previous_year`, `updated_price`, `percentage_increase`, `updated_year`, `created_at`, `updated_at`) VALUES
(17, 1, 0.00, NULL, '2024', 200.00, 0, '2025', '2025-04-08 08:54:53', '2025-04-08 08:54:53'),
(18, 1, 200.00, NULL, '2025', 300.00, 50, '2025', '2025-04-08 09:01:00', '2025-04-08 09:01:00'),
(19, 1, 300.00, NULL, '2025', 320.00, 7, '2025', '2025-04-08 09:01:12', '2025-04-08 09:01:12'),
(20, 1, 320.00, NULL, '2025', 350.00, 9, '2022', '2025-04-08 09:01:58', '2025-04-08 09:01:58');

-- --------------------------------------------------------

--
-- Table structure for table `property_valuations`
--

CREATE TABLE `property_valuations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `valuation_type` varchar(255) NOT NULL,
  `current_price` decimal(15,2) NOT NULL,
  `market_value` decimal(15,2) NOT NULL,
  `percentage_increase` decimal(5,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_valuations`
--

INSERT INTO `property_valuations` (`id`, `property_id`, `valuation_type`, `current_price`, `market_value`, `percentage_increase`, `created_at`, `updated_at`) VALUES
(15, 1, 'testing', 200000.00, 500000.00, 150.00, '2025-04-08 08:18:44', '2025-04-08 08:18:44');

-- --------------------------------------------------------

--
-- Table structure for table `property_valuation_predictions`
--

CREATE TABLE `property_valuation_predictions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `future_date` varchar(255) NOT NULL,
  `current_price` decimal(15,2) NOT NULL,
  `future_market_value` decimal(15,2) NOT NULL,
  `percentage_increase` decimal(5,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property_valuation_summaries`
--

CREATE TABLE `property_valuation_summaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED DEFAULT NULL,
  `property_valuation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `initial_value_sum` decimal(15,2) DEFAULT 0.00,
  `current_value_sum` decimal(15,2) DEFAULT NULL,
  `percentage_value` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_valuation_summaries`
--

INSERT INTO `property_valuation_summaries` (`id`, `property_id`, `property_valuation_id`, `initial_value_sum`, `current_value_sum`, `percentage_value`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 25550.00, 25800.00, 1, '2025-01-18 21:59:52', '2025-01-19 16:57:44'),
(2, 1, 14, 2000000.00, NULL, 0, '2025-04-08 08:18:17', '2025-04-08 08:18:17'),
(3, 1, 15, 200000.00, NULL, 0, '2025-04-08 08:18:44', '2025-04-08 08:18:44');

-- --------------------------------------------------------

--
-- Table structure for table `referral_logs`
--

CREATE TABLE `referral_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `referrer_id` bigint(20) UNSIGNED NOT NULL,
  `referred_id` bigint(20) UNSIGNED DEFAULT NULL,
  `referral_code` varchar(255) NOT NULL,
  `referred_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'registered' COMMENT 'registered, purchased, commission_pending, paid, cancelled',
  `commission_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `commission_paid` tinyint(1) NOT NULL DEFAULT 0,
  `commission_paid_at` timestamp NULL DEFAULT NULL,
  `property_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sells`
--

CREATE TABLE `sells` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `property_name` varchar(255) NOT NULL,
  `transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `selected_size_land` int(11) NOT NULL,
  `remaining_size` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `total_price` decimal(15,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sociallinks`
--

CREATE TABLE `sociallinks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` text DEFAULT NULL,
  `youtube` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sociallinks`
--

INSERT INTO `sociallinks` (`id`, `facebook`, `twitter`, `whatsapp`, `instagram`, `linkedin`, `youtube`, `created_at`, `updated_at`) VALUES
(1, 'www.facebook.com', 'www.twitter.com', 'www', 'https://www.instagram.com/womeningrcfp/', 'https://www.linkedin.com/showcase/105828153/admin/page-posts/published/', 'youtube', '2025-01-05 14:28:39', '2025-01-05 14:28:39');

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `content`, `created_at`, `updated_at`) VALUES
(1, '<h2 style=\"text-align: justify;\"><strong><span class=\"s2\">Website terms of use </span></strong></h2>\r\n<p style=\"text-align: justify;\"><em>Please read these terms and conditions carefully before using this site as they are a legally binding agreement between you and us.</em></p>\r\n<h3 style=\"text-align: justify;\">What&rsquo;s in these terms?</h3>\r\n<p style=\"text-align: justify;\">These terms tell you rules for using our domain (dohmayn.com) including our website(dohmayn), as well as any sub-domain or sibling-domain registered to Dohmayn and any uniform resource locator (URL) or Application Programming Interface (API) by which Dohmayn&rsquo;s data may be accessed (reffered to as site&rdquo;). Throughout this document we refer to them as the &ldquo;Term&rdquo;. A reference to &ldquo;you&rdquo; or &ldquo;your&rdquo; is a reference to the user to the site.</p>\r\n<div class=\"s3\" style=\"text-align: justify;\">1. Who we are and how to contact us</div>\r\n<div class=\"s3\" style=\"text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">1.1. We are Hamuj Group Limited (company number 1833794 ) and our address(1637, Ibukun House Ademola Adetokunbo, Victoria Island, Lagos<a name=\"_GoBack\"></a>). We built a trust platform called Dohmyn, Dohmayn is a property platform focused on making property investment accessible, transparent, and scalable, it allows users to explore, buy, sell and manage fractional property ownership in a tech-driven. We are provider of the site. Dohmayn will be serving as a redress scheme between the real estate company and the consumers. A redress scheme is an independent organization that works to resolve disputes between real estate company and the consumers.</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">1.2. To contact us, please email <a href=\"mail:customersupport@rightmove.com\">customersupport@rightmove.com</a> or write to us via the postal address above</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify;\">2. By using our site you accept these terms</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">2.1. These Terms set out all of the rules and obligations that apply to your use of the site.</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">2.2. By using our Site, you confirm that you accept these Terms and that you agree to comply with them. If you do not agree to these Terms, you must not our site.</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">2.3. We recommend that you download and store a copy of these Terms for future reference. They are a legally binding agreement between you and us</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">2.4. These Terms may also make reference to other terms that apply when using our site, such as our Privacy policy and Cookie Policy.</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify;\">3. We may make changes to our terms</div>\r\n<div class=\"s3\" style=\"text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">3.1. We amend these Terms from time to time by updating them on the Site. Every time you wish to use our Site, please check these Terms to ensure you understand the Terms that apply at that time.</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify;\">4. We may make changes to our site</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">4.1. We may from time to time change the content of this site or suspend or discontinue any aspect of this Site, which may include your access to it.</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify;\">5. Your obligation and acceptable use</div>\r\n<div class=\"s3\" style=\"text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">5.1. You accept that you are solely responsible for ensuring that your computer system meets all relevant technical specification necessary to use this site and that your computer system is compatible with this Site.</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">5.2. You must not misuse our system or this site. In particular, you must not hack into, circumvent security or otherwise disrupt the operation of our system and this site, or attempt to carry out any of the foregoing. This includes introducing viruses, Trojans, worms, logic bombs or other material which is or could be malicious or technologically harmful. You must not misuse any forms on the Site and any forms you submit must be a genuine enquiry.</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">5.3. You must not use or attempt to use any automated program (including, without limitation, any spider or other web crawler) to access our system or this site by means of any such automated programs is strictly unauthorized.</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">5.4. You must not upload or use inappropriate or offensive language or content or solicit any commercial services in any communication, form or email you send or submit, from or to the Site.</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">5.5. Unless you have our prior written consent from our Legal team, you must not do or attempt to do any of the following:</div>\r\n<div class=\"s6\" style=\"padding-left: 80px; text-align: justify;\">5.5.1. Access this Site in order to obtain property information available from it other than by means of direct human interaction with its human-readable web pages by using either (a) a web browser which is directly accessing this Site or (b) a mobile app or other computer program published by us.</div>\r\n<div class=\"s6\" style=\"padding-left: 80px; text-align: justify;\">&nbsp;</div>\r\n<div class=\"s6\" style=\"padding-left: 80px; text-align: justify;\">5.5.2. Use technical means to access this Site which enables, causes or facilitates you or others to access this Site in a manner prohibited by clause 5.5.1.</div>\r\n<div class=\"s6\" style=\"padding-left: 40px; text-align: justify;\">&nbsp;</div>\r\n<div class=\"s6\" style=\"padding-left: 80px; text-align: justify;\">5.5.3. In a particular and without limitation, unless you or others have our prior written consent you or others may not extract or seek to extract property information from site other than by means of direct human interaction with the menu system, hyperlinks and search and filters functions displayed on the human-readable pages of this Site by using either (a) a web browser which is directly accessing this Site or (b) a mobile app or other computer program.</div>\r\n<div class=\"s3\" style=\"text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify;\">6. Interactive services and content</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">6.1. When you fill out and submit an enquiry form on our site, your personal information will be processed in accordance with our Privacy Policy.</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">6.2. Enquiry forms on our site should only be used for the purpose for which they are intended. If we (in our reasonable opinion and at our sole discretion) suspect a form have been misused, irrespective of whether the misuse is a result of recklessness or negligence as to the proper use of that form to the intended recipient(s) without notice to you.</div>\r\n<div class=\"s3\" style=\"text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify;\">7. Registration</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">7.1. To gain access to certain details and services on our site you will need to register (free of charge) as a Dohmayn user. If we accept your application for registration, you will be given access at the point of application.</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">7.2. Each registration is for a single user only. You must not share your username and password with any other person or with multiple users on a network.</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">7.3. You must ensure the password you use is unique and not be re-used anywhere else such as other websites, portals, or any other accounts.</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">7.4. You undertake that all information provided by you for the purposes of registering with us is accurate and complete.</div>\r\n<div class=\"s3\" style=\"padding-left: 40px; text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify;\">7.5. You accept sole responsibility for all use of and for keeping secret any password that may have been given to you or chosen by you for use on this site. You will notify us immediately of any unauthorized use of them or any other breach of security of this site of which you become aware.</div>\r\n<div class=\"s3\" style=\"text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify;\">7.6. We have the right to disable any account or password, whether chosen by you or allocated by us, any time, it in our reasonable opinion you have failed to comply with any of the provision of these Terms.</div>\r\n<div class=\"s3\" style=\"text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify;\">8. Intellectual property</div>\r\n<div class=\"s3\" style=\"text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">8.1. The copyright and all other intellectual property rights in this site(including all database rights, trademarks, service marks, trading names, text, graphics, code, files, links and other materials published on it) belong to us or our licensor(s). All rights are reserved.</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">8.2. Our registered trademarks include the following devices and word marks: you must not use or copy them without our prior written consent.</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify;\">9. Warranty</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">9.1. Whilst we endeavor to ensure that any material available for downloading from this site (such as property brochure) is not contaminated in any way, we do not warrant that such material will be free from infection, viruses and/or similar code.</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">9.2. Due to the nature of software and internet, we do not warrant that your access to, or the running of, this site will be uninterrupted or error free. We may suspend, withdraw, discontinue or change all or any part of our site with notice. We shall not be liable if we cannot process your details due to circumstance beyond our reasonable control.</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify;\">10. Customer feedback and quality</div>\r\n<div class=\"s3\" style=\"text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">10.1. We try to ensure that all customer feedback is dealth with fairly and consistently, and is properly recorded. We welcome any suggestions that you make about how we may improve our services. Please write to us at Customer Services, Hamuj Group Limite, using the address provided at the beginning of these Terms or via the Contact Us section on our site. We aim to acknowledge all customer feedback.</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify;\">11. General provisions</div>\r\n<div class=\"s3\" style=\"text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">11.1. The headings in these Terms of use are solely used for convenience only.</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">11.2. You may not assign or delegate any or all of your rights or obligations in these Terms of use.</div>\r\n<div class=\"s3\" style=\"text-align: justify;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">11.3. We may assign this agreement at any time without notice to you.</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">&nbsp;</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">11.4. Our delay or failure to exercise or enforce any right or provision of these Terms of use shall not constitute or be construed as a waiver of such right to act.</div>\r\n<div class=\"s3\" style=\"text-align: justify; padding-left: 40px;\">&nbsp;</div>\r\n<p style=\"text-align: justify;\">Thank you for visiting Dohmayn.</p>\r\n<p style=\"text-align: justify;\">5<span class=\"s8\">th</span> January 2025</p>\r\n<p class=\"s4\" style=\"text-align: justify;\">&nbsp;&nbsp;</p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p class=\"s4\" style=\"text-align: justify;\">&nbsp;</p>', '2024-11-23 11:04:06', '2024-11-23 15:45:34');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `source` varchar(255) NOT NULL DEFAULT 'web',
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `property_id` text DEFAULT NULL,
  `property_name` text DEFAULT NULL,
  `user_id` text NOT NULL,
  `reference` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `email` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `transaction_state` text DEFAULT NULL,
  `paid_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `recipient_name` varchar(255) DEFAULT NULL,
  `recipient_code` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `source`, `metadata`, `property_id`, `property_name`, `user_id`, `reference`, `status`, `amount`, `email`, `payment_method`, `description`, `transaction_state`, `paid_at`, `created_at`, `updated_at`, `recipient_name`, `recipient_code`, `account_number`, `account_name`, `bank_name`) VALUES
(8, 'web', NULL, '1', 'Luxury Family Home update nn', '22', 'PROREF-1732915350-AMDVIZJH', 'success', 150000.00, 'eshanokpe@gmail.com', 'card', NULL, NULL, '2024-11-29 21:23:33', '2024-11-29 20:22:30', '2024-11-29 20:23:33', NULL, NULL, NULL, NULL, NULL),
(9, 'web', NULL, '1', 'Luxury Family Home update nn', '22', 'PROREF-1732916543-QHHOU186', 'pending', 150000.00, 'eshanokpe@gmail.com', '', NULL, NULL, '2024-11-29 21:42:23', '2024-11-29 20:42:23', '2024-11-29 20:42:23', NULL, NULL, NULL, NULL, NULL),
(10, 'web', NULL, '1', 'Luxury Family Home update nn', '22', 'PROREF-1732917272-UZDJYIRH', 'success', 150000.00, 'eshanokpe@gmail.com', 'card', NULL, NULL, '2024-11-29 21:54:52', '2024-11-29 20:54:32', '2024-11-29 20:54:52', NULL, NULL, NULL, NULL, NULL),
(11, 'web', NULL, '1', 'Luxury Family Home update nn', '22', 'PROREF-1732917712-HCQW4KWB', 'success', 150000.00, 'eshanokpe@gmail.com', 'card', NULL, NULL, '2024-11-29 22:02:36', '2024-11-29 21:01:52', '2024-11-29 21:02:36', NULL, NULL, NULL, NULL, NULL),
(12, 'web', NULL, '1', 'Luxury Family Home update nn', '22', 'PROREF-1732918286-FKPRHUPX', 'pending', 300000.00, 'eshanokpe@gmail.com', '', NULL, NULL, '2024-11-29 22:11:26', '2024-11-29 21:11:26', '2024-11-29 21:11:26', NULL, NULL, NULL, NULL, NULL),
(13, 'web', NULL, '1', 'Luxury Family Home update nn', '22', 'PROREF-1732918412-S1W2U1Y5', 'success', 150000.00, 'eshanokpe@gmail.com', 'card', NULL, NULL, '2024-11-29 22:13:54', '2024-11-29 21:13:32', '2024-11-29 21:13:54', NULL, NULL, NULL, NULL, NULL),
(14, 'web', NULL, '1', 'Luxury Family Home update nn', '11', 'PROREF-1734208371-MYZPJDVY', 'pending', 209998.00, 'eshanokpe77@gmail.com', '', NULL, NULL, '2024-12-14 20:32:51', '2024-12-14 19:32:51', '2024-12-14 19:32:51', NULL, NULL, NULL, NULL, NULL),
(15, 'web', NULL, '1', 'Luxury Family Home update nn', '10', 'PROREF-1734269135-QV87OJRH', 'success', 209998.00, 'eshanokpe@gmail.com', 'card', NULL, NULL, '2024-12-15 13:25:51', '2024-12-15 12:25:35', '2024-12-15 12:25:51', NULL, NULL, NULL, NULL, NULL),
(16, 'web', NULL, '1', 'Luxury Family Home update nn', '10', 'PROREF-1734273566-VWOVKG59', 'pending', 209998.00, 'eshanokpe@gmail.com', '', NULL, NULL, '2024-12-15 14:39:26', '2024-12-15 13:39:26', '2024-12-15 13:39:26', NULL, NULL, NULL, NULL, NULL),
(17, 'web', NULL, '1', 'Luxury Family Home update nn', '10', 'PROREF-1734273570-PSDDR0GI', 'pending', 209998.00, 'eshanokpe@gmail.com', '', NULL, NULL, '2024-12-15 14:39:31', '2024-12-15 13:39:31', '2024-12-15 13:39:31', NULL, NULL, NULL, NULL, NULL),
(18, 'web', NULL, '1', 'Luxury Family Home update nn', '10', 'PROREF-1734384155-BSUMNK8G', 'success', 209998.00, 'eshanokpe@gmail.com', 'card', NULL, 'success', '2024-12-16 21:24:04', '2024-12-16 20:24:04', '2024-12-16 20:24:04', NULL, NULL, NULL, NULL, NULL),
(20, 'web', NULL, '1', 'Luxury Family Home update nn', '10', 'PROREF-1734384592-2ETT9RUM', 'success', 209998.00, 'eshanokpe@gmail.com', 'card', NULL, 'success', '2024-12-16 21:30:27', '2024-12-16 20:30:27', '2024-12-16 20:30:27', NULL, NULL, NULL, NULL, NULL),
(21, 'web', NULL, '1', 'Luxury Family Home update nn', '26', 'PROREF-1736666951-VMUW0MAP', 'success', 289000.00, 'eshanokpe@gmail.com', 'card', NULL, 'success', '2025-01-12 07:29:28', '2025-01-12 06:29:28', '2025-01-12 06:29:28', NULL, NULL, NULL, NULL, NULL),
(22, 'web', NULL, NULL, NULL, '29', '100004250115024631125459445989', 'success', 100.00, 'eshanokpe77@gmail.com', 'Transfer', 'Fund added to wallet', NULL, '2025-01-15 02:46:38', '2025-01-15 01:46:38', '2025-01-15 01:46:38', NULL, NULL, NULL, NULL, NULL),
(23, 'web', NULL, NULL, NULL, '29', '100004250115024410125460526672', 'success', 100.00, 'eshanokpe77@gmail.com', 'Transfer', 'Fund added to wallet', NULL, '2025-01-15 02:51:17', '2025-01-15 01:51:17', '2025-01-15 01:51:17', NULL, NULL, NULL, NULL, NULL),
(24, 'web', NULL, NULL, NULL, '29', '100004250115024152125459444430', 'success', 100.00, 'eshanokpe77@gmail.com', 'Transfer', 'Fund added to wallet', NULL, '2025-01-15 02:51:25', '2025-01-15 01:51:25', '2025-01-15 01:51:25', NULL, NULL, NULL, NULL, NULL),
(25, 'web', NULL, NULL, NULL, '29', '100004250115083416125467508100', 'success', 100.00, 'eshanokpe77@gmail.com', 'Transfer', 'Fund added to wallet', NULL, '2025-01-15 08:34:24', '2025-01-15 07:34:24', '2025-01-15 07:34:24', NULL, NULL, NULL, NULL, NULL),
(26, 'web', '{\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"remaining_size\":\"300\",\"selected_size_land\":\"1\"}', NULL, NULL, '29', 'DOHREF-1744005301-ES4OQW6P', 'completed', 25800.00, 'eshanokpe77@gmail.com', 'wallet', NULL, NULL, '2025-04-07 05:55:01', '2025-04-07 04:55:01', '2025-04-07 04:55:01', NULL, NULL, NULL, NULL, NULL),
(27, 'web', '{\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"remaining_size\":\"300\",\"selected_size_land\":\"1\"}', NULL, NULL, '29', 'DOHREF-1744005416-U0YCJA2B', 'completed', 25800.00, 'eshanokpe77@gmail.com', 'wallet', NULL, NULL, '2025-04-07 05:56:56', '2025-04-07 04:56:56', '2025-04-07 04:56:56', NULL, NULL, NULL, NULL, NULL),
(28, 'web', '{\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"remaining_size\":\"300\",\"selected_size_land\":\"1\"}', NULL, NULL, '29', 'DOHREF-1744016187-GOUVW1NX', 'completed', 25800.00, 'eshanokpe77@gmail.com', 'wallet', NULL, NULL, '2025-04-07 08:56:27', '2025-04-07 07:56:27', '2025-04-07 07:56:27', NULL, NULL, NULL, NULL, NULL),
(29, 'web', '{\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"remaining_size\":\"300\",\"selected_size_land\":\"1\"}', NULL, NULL, '29', 'DOHREF-1744016232-VMX8RAWT', 'completed', 25800.00, 'eshanokpe77@gmail.com', 'wallet', NULL, NULL, '2025-04-07 08:57:12', '2025-04-07 07:57:12', '2025-04-07 07:57:12', NULL, NULL, NULL, NULL, NULL),
(30, 'web', '{\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"remaining_size\":\"300\",\"selected_size_land\":\"1\"}', NULL, NULL, '29', 'DOHREF-1744017290-XHJZU1DX', 'completed', 25800.00, 'eshanokpe77@gmail.com', 'wallet', NULL, NULL, '2025-04-07 09:14:50', '2025-04-07 08:14:50', '2025-04-07 08:14:50', NULL, NULL, NULL, NULL, NULL),
(31, 'web', '{\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"remaining_size\":\"300\",\"selected_size_land\":\"1\"}', NULL, NULL, '29', 'DOHREF-1744017424-GZYUNDQG', 'completed', 25800.00, 'eshanokpe77@gmail.com', 'wallet', NULL, NULL, '2025-04-07 09:17:04', '2025-04-07 08:17:04', '2025-04-07 08:17:04', NULL, NULL, NULL, NULL, NULL),
(32, 'web', '{\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"remaining_size\":\"300\",\"selected_size_land\":\"1\"}', NULL, NULL, '29', 'DOHREF-1744017953-PK66BQ5C', 'completed', 25800.00, 'eshanokpe77@gmail.com', 'wallet', NULL, NULL, '2025-04-07 09:25:53', '2025-04-07 08:25:53', '2025-04-07 08:25:53', NULL, NULL, NULL, NULL, NULL),
(33, 'web', '{\"property_id\":1,\"property_name\":\"Luxury Family Home update nn\",\"remaining_size\":\"300\",\"selected_size_land\":\"1\"}', NULL, NULL, '29', 'DOHREF-1744018068-TJV1XMRZ', 'completed', 25800.00, 'eshanokpe77@gmail.com', 'wallet', NULL, NULL, '2025-04-07 09:27:48', '2025-04-07 08:27:48', '2025-04-07 08:27:48', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `property_name` varchar(255) NOT NULL,
  `land_size` int(11) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `recipient_id` text DEFAULT NULL,
  `total_price` decimal(15,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `confirmation_status` enum('pending','confirmed','declined') NOT NULL DEFAULT 'pending',
  `confirmation_date` timestamp NULL DEFAULT NULL,
  `confirmed_by` bigint(11) DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transfers`
--

INSERT INTO `transfers` (`id`, `property_id`, `property_name`, `land_size`, `user_id`, `user_email`, `reference`, `recipient_id`, `total_price`, `status`, `confirmation_status`, `confirmation_date`, `confirmed_by`, `rejection_reason`, `created_at`, `updated_at`) VALUES
(19, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-XWU3NJCOAN', 'DOHMAYN-63922-AHQL1CXGM5', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 06:42:02', '2025-01-12 06:42:02'),
(20, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-9CVB6H5E7D', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 16:45:55', '2025-01-12 16:45:55'),
(21, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-6254LZPS8I', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 16:55:48', '2025-01-12 16:55:48'),
(22, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-7FWJ91R4UP', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:02:47', '2025-01-12 17:02:47'),
(23, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-20Z0M9XX1J', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:09:05', '2025-01-12 17:09:05'),
(24, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-OGFMRSLUB9', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:10:52', '2025-01-12 17:10:52'),
(25, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-JP3NKIP3FV', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:11:07', '2025-01-12 17:11:07'),
(26, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-W0MBGH43TP', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:12:05', '2025-01-12 17:12:05'),
(27, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-N5DCSJJOQZ', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:12:27', '2025-01-12 17:12:27'),
(28, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-VCD6GDERNF', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:12:53', '2025-01-12 17:12:53'),
(29, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-KIB0TPUZJJ', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:16:02', '2025-01-12 17:16:02'),
(30, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-MD5EZKPIQO', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:18:18', '2025-01-12 17:18:18'),
(31, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-IWFFHU23G7', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:21:42', '2025-01-12 17:21:42'),
(32, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-ZLJT1NNFHY', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:22:40', '2025-01-12 17:22:40'),
(33, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-WPTQARGYFV', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:23:09', '2025-01-12 17:23:09'),
(34, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-IZFPCIRAI0', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:23:33', '2025-01-12 17:23:33'),
(35, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-ISXJLK42CC', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:24:40', '2025-01-12 17:24:40'),
(36, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-WCCFFVMIBH', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:25:36', '2025-01-12 17:25:36'),
(37, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-KUPSBY5Z5T', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:27:16', '2025-01-12 17:27:16'),
(38, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-ZPONHDEV8P', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:31:21', '2025-01-12 17:31:21'),
(39, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-REDWJAUJFL', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:32:42', '2025-01-12 17:32:42'),
(40, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-YWNKVU6U5G', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:34:11', '2025-01-12 17:34:11'),
(41, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-5VLNJBIOLB', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:35:20', '2025-01-12 17:35:20'),
(42, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-OTJCPK0ZXC', '19', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:38:25', '2025-01-12 17:38:25'),
(44, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-RPSCFX59BJ', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:41:42', '2025-01-12 17:41:42'),
(45, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-YMWOTZQRYV', '19', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:46:27', '2025-01-12 17:46:27'),
(46, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-O6NZ9X0JHH', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:48:10', '2025-01-12 17:48:10'),
(47, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-4MUG0T86WF', '19', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 17:52:03', '2025-01-12 17:52:03'),
(48, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-WIYMUSG8NE', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 18:01:30', '2025-01-12 18:01:30'),
(49, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-H6CTBSCD4J', '19', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 18:09:57', '2025-01-12 18:09:57'),
(50, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-UANJHDEAW2', '29', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 18:17:11', '2025-01-12 18:17:11'),
(51, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-5UTMRUYAFQ', '19', 28900000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-01-12 18:22:03', '2025-01-12 18:22:03'),
(52, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-PAPPMVGFDV', '12', 2580000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-04-08 17:37:22', '2025-04-08 17:37:22'),
(53, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-W82YOYLHEZ', '12', 2580000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-04-08 17:38:39', '2025-04-08 17:38:39'),
(54, 1, 'Luxury Family Home update nn', 1, 26, 'eshanokpe@gmail.com', 'TRANS-ZGUQM7MMCU', '12', 2580000.00, 'pending', 'pending', NULL, NULL, NULL, '2025-04-08 17:49:03', '2025-04-08 17:49:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` text DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone` text DEFAULT NULL,
  `recipient_id` text DEFAULT NULL,
  `profile_image` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `referral_code` text DEFAULT NULL,
  `referred_by` text DEFAULT NULL,
  `transaction_pin` text DEFAULT NULL,
  `failed_pin_attempts` int(11) NOT NULL DEFAULT 0,
  `hide_balance` tinyint(1) DEFAULT 0,
  `app_passcode` varchar(255) DEFAULT NULL,
  `auth_method` varchar(255) NOT NULL DEFAULT 'pin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `biometric_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Stores supported biometric types as JSON' CHECK (json_valid(`biometric_data`)),
  `biometric_enabled_at` timestamp NULL DEFAULT NULL COMMENT 'When biometric was enabled',
  `last_failed_pin_attempt` timestamp NULL DEFAULT NULL,
  `pin_locked_until` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `dob`, `email_verified_at`, `phone`, `recipient_id`, `profile_image`, `password`, `remember_token`, `referral_code`, `referred_by`, `transaction_pin`, `failed_pin_attempts`, `hide_balance`, `app_passcode`, `auth_method`, `created_at`, `updated_at`, `biometric_data`, `biometric_enabled_at`, `last_failed_pin_attempt`, `pin_locked_until`, `last_login_at`, `last_login_ip`) VALUES
(12, 'Belle', 'Bright', 'somuguf@mailinator.com', NULL, NULL, '23456789876', 'DOHMAYN-33376-PCXKYCT1PT', NULL, '$2y$10$mDDtvVhWILdDemvHfToC5OFJS.7mR9DX1075JO5rrQQEllTHeKpwW', NULL, 'DOHMAYN-6771772F1E5D20.10516972', '10', NULL, 0, 0, NULL, 'pin', '2024-12-29 15:22:07', '2024-12-29 15:22:07', NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'Eric', 'Ewing', 'pezyjelu@mailinator.com', NULL, NULL, '+12323343344', 'DOHMAYN-56464-9IGTSFWFV2', NULL, '$2y$10$0eDmVFgeySZ4SGoXvTAjEeP197LJNJfxGk29VXYoTuEnQG4x5yjza', NULL, '461F6919', '10', NULL, 0, 0, NULL, 'pin', '2024-12-29 15:27:00', '2024-12-29 15:27:00', NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'Quail', 'Mccoy', 'qafugimawi@mailinator.com', NULL, NULL, '+1223332323232', 'DOHMAYN-91546-Q2USTATFPH', NULL, '$2y$10$ZoHkdF1vV0VPSateUF5Ge.IN2NMLVXeixduDxSHZa5j1dJ.jiJuBG', NULL, '38C0F2C2', NULL, NULL, 0, 0, NULL, 'pin', '2024-12-29 15:35:28', '2024-12-29 15:35:28', NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'Daria', 'Lane', 'weca@mailinator.com', NULL, NULL, '+1 (561) 561-4617', 'DOHMAYN-64603-JMTXG6XSNR', NULL, '$2y$10$.xxHMG8a/w.TS5vpDQ8at.Ypnuc/XsTQy.87cQKnZpHK07/1O3egi', NULL, '92A643E3', NULL, NULL, 0, 0, NULL, 'pin', '2024-12-29 15:39:47', '2024-12-29 15:39:47', NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'Jana', 'Daniels', 'jotyqivazu@mailinator.com', NULL, '2025-01-12 07:31:56', '+1 (515) 572-9647', 'DOHMAYN-63922-AHQL1CXGM5', NULL, '$2y$10$SbvrXLgnrZ/NIcaO/d512.erIx.BHaM2ZM1glAY0CJr.RAbN4plM6', NULL, '6EE90E6F', NULL, NULL, 0, 0, NULL, 'pin', '2024-12-29 15:50:00', '2024-12-29 15:50:00', NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'Eshanokpe', 'Daniel', 'eshanokpe@gmail.com', '1990-09-15', '2025-01-12 03:26:26', '+23481392679600', 'DOHMAYN-63189-UMYGSTQC5B', NULL, '$2y$10$Uf4G.XK2DEN3mq6DBOfV5e71LTWgRysXK3cyh0t8UYtU0AlA76AWO', NULL, 'DOHMAYNR0IC2X', NULL, '$2y$10$70iqbCPK0GvtBT245WMGzu2jAfyUfk60Z5G/f1Z7dlU4O6GGvBygW', 1, 0, NULL, 'pin', '2025-01-12 03:22:04', '2025-04-08 17:37:00', NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'Dannic', 'Code', 'eshanokpe77@gmail.com', NULL, '2025-01-12 17:34:51', '+23481392', 'DOHMAYN-50134-YF6MNUO2Y2', NULL, '$2y$10$AQfMc16VPL6YUQiLFdJvzuJt0U.syXfx5uADuiTJ7cm3saS6vxAzK', NULL, 'DOHMAYNDAN5ZF', NULL, '$2y$10$zk2JqlIZm3AhDGFIj1XB2u/YveMcM4z5D7ezR6fSiCFVJs4f5eIb6', 3, 0, NULL, 'pin', '2025-01-12 16:33:30', '2025-04-08 14:31:12', NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'Leslie', 'Ingram', 'hini@mailinator.com', NULL, NULL, '+1 (479) 497-1169', 'DOHMAYN-78177-RFON4EO6UJ', NULL, '$2y$10$jvHtFogNn6mGthX8Z7Du4uJNCMBecxej5qzlOlFLXS4wQaWYzZmoe', NULL, 'DOHMAYNIFHIP9', NULL, NULL, 0, 0, NULL, 'pin', '2025-01-16 17:31:14', '2025-01-16 17:31:14', NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'Hector', 'Sandoval', 'pazupiby@mailinator.com', '1989-02-15', NULL, '+1 (444) 431-2052', 'DOHMAYN-94260-DTLTFO21D7', NULL, '$2y$10$RTCt3m6XfopSpHVH2zd6NuNqYmqiXeLXVgfOEMb3Rf1wEppwq8lyO', NULL, 'DOHMAYNZNWZ2G', NULL, NULL, 0, 0, NULL, 'pin', '2025-01-16 17:33:41', '2025-01-16 17:33:41', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_activities`
--

CREATE TABLE `user_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `activity` varchar(255) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_activities`
--

INSERT INTO `user_activities` (`id`, `user_id`, `activity`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 26, 'logged in', '127.0.0.1', '2025-04-07 18:47:48', '2025-04-07 18:47:48'),
(2, 29, 'logged in', '127.0.0.1', '2025-04-08 12:39:11', '2025-04-08 12:39:11'),
(3, 26, 'logged in', '127.0.0.1', '2025-04-08 17:35:07', '2025-04-08 17:35:07'),
(4, 26, 'logged in', '127.0.0.1', '2025-04-08 17:35:19', '2025-04-08 17:35:19');

-- --------------------------------------------------------

--
-- Table structure for table `virtual_accounts`
--

CREATE TABLE `virtual_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `currency` varchar(255) NOT NULL DEFAULT 'NGN',
  `customer_code` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `virtual_accounts`
--

INSERT INTO `virtual_accounts` (`id`, `user_id`, `user_email`, `bank_name`, `account_name`, `account_number`, `currency`, `customer_code`, `is_active`, `created_at`, `updated_at`) VALUES
(7, 15, 'pezyjelu@mailinator.com', 'Test Bank', 'TEST-MANAGED-ACCOUNT', '1238240012', 'NGN', 'CUS_us8df5031eexx8i', 1, '2024-12-29 15:27:04', '2024-12-29 15:27:04'),
(8, 18, 'weca@mailinator.com', 'Test Bank', 'TEST-MANAGED-ACCOUNT', '1238240036', 'NGN', 'CUS_nxj2l24gxdl6wb3', 1, '2024-12-29 15:39:50', '2024-12-29 15:39:50'),
(9, 19, 'jotyqivazu@mailinator.com', 'Test Bank', 'TEST-MANAGED-ACCOUNT', '1238240043', 'NGN', 'CUS_6bocn6d33a27euw', 1, '2024-12-29 15:50:04', '2024-12-29 15:50:04'),
(10, 26, 'eshanokpe@gmail.com', 'Wema Bank', 'BRAVETECH/DANIEL ESHANOKPE', '9787088232', 'NGN', 'CUS_jyrxvdv5uuorjp0', 1, '2025-01-12 03:22:05', '2025-01-12 03:22:05'),
(11, 29, 'eshanokpe77@gmail.com', 'Test Bank', 'TEST-MANAGED-ACCOUNT', '1238237045', 'NGN', 'CUS_5fsh48hsg2925zu', 1, '2025-01-12 16:33:35', '2025-01-12 16:33:35'),
(12, 30, 'hini@mailinator.com', 'Paystack-Titan', 'BRAVETECH/INGRAM LESLIE', '9965139816', 'NGN', 'CUS_sslh3hfydvrbl5o', 1, '2025-01-16 17:31:19', '2025-01-16 17:31:19'),
(13, 31, 'pazupiby@mailinator.com', 'Paystack-Titan', 'BRAVETECH/SANDOVAL HECTOR', '9965060213', 'NGN', 'CUS_4zxe6c6bxpoecko', 1, '2025-01-16 17:33:47', '2025-01-16 17:33:47');

-- --------------------------------------------------------

--
-- Table structure for table `vision_missions`
--

CREATE TABLE `vision_missions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vision` text DEFAULT NULL,
  `mission` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vision_missions`
--

INSERT INTO `vision_missions` (`id`, `vision`, `mission`, `created_at`, `updated_at`) VALUES
(1, 'To be a transformative force in real estate, empowering people from all walks of life to invest in, own, and manage property assets with transparency, security, and ease. Our vision is a world where property ownership is inclusive, digital, and accessible to everyone, driven by cutting-edge technology and a commitment to integrity.', 'Our mission is to democratize property ownership by building a transparent, technology-driven platform where anyone can confidently invest in real estate. We strive to make property investment accessible through fractional ownership, reducing traditional barriers to entry. By ensuring security, real-time valuation updates, and a user-friendly experience.', '2024-11-15 11:51:49', '2024-11-15 11:52:13');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `currency` varchar(10) NOT NULL DEFAULT 'NGN',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `user_id`, `user_email`, `balance`, `currency`, `created_at`, `updated_at`) VALUES
(3, 15, 'pezyjelu@mailinator.com', 500000.00, 'NGN', '2024-12-29 15:27:04', '2024-12-29 15:27:04'),
(4, 18, 'weca@mailinator.com', 500000.00, 'NGN', '2024-12-29 15:39:50', '2024-12-29 15:39:50'),
(5, 19, 'jotyqivazu@mailinator.com', 500000.00, 'NGN', '2024-12-29 15:50:04', '2024-12-29 15:50:04'),
(6, 26, 'eshanokpe@gmail.com', 211000.00, 'NGN', '2025-01-12 03:22:05', '2025-01-12 06:29:28'),
(7, 29, 'eshanokpe77@gmail.com', 167800.00, 'NGN', '2025-01-12 16:33:35', '2025-04-07 08:27:48'),
(8, 30, 'hini@mailinator.com', 0.00, 'NGN', '2025-01-16 17:31:19', '2025-01-16 17:31:19'),
(9, 31, 'pazupiby@mailinator.com', 0.00, 'NGN', '2025-01-16 17:33:47', '2025-01-16 17:33:47');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transactions`
--

CREATE TABLE `wallet_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wallet_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('credit','debit') NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abouts`
--
ALTER TABLE `abouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `buys`
--
ALTER TABLE `buys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_post_id_foreign` (`post_id`),
  ADD KEY `comments_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `contact_detials`
--
ALTER TABLE `contact_detials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dropdown_items`
--
ALTER TABLE `dropdown_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dropdown_items_menu_item_id_foreign` (`menu_item_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `neighborhoods`
--
ALTER TABLE `neighborhoods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `neighborhoods_property_id_foreign` (`property_id`),
  ADD KEY `neighborhoods_neighborhood_category_id_foreign` (`neighborhood_category_id`);

--
-- Indexes for table `neighborhood_categories`
--
ALTER TABLE `neighborhood_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `neighborhood_categories_name_unique` (`name`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `offerprices`
--
ALTER TABLE `offerprices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privacies`
--
ALTER TABLE `privacies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `properties_neighborhood_category_id_foreign` (`neighborhood_category_id`);

--
-- Indexes for table `property_price_updates`
--
ALTER TABLE `property_price_updates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_price_updates_property_id_foreign` (`property_id`);

--
-- Indexes for table `property_valuations`
--
ALTER TABLE `property_valuations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_valuations_property_id_foreign` (`property_id`);

--
-- Indexes for table `property_valuation_predictions`
--
ALTER TABLE `property_valuation_predictions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_valuation_predictions_property_id_foreign` (`property_id`);

--
-- Indexes for table `property_valuation_summaries`
--
ALTER TABLE `property_valuation_summaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `referral_logs`
--
ALTER TABLE `referral_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `referral_logs_referrer_id_foreign` (`referrer_id`),
  ADD KEY `referral_logs_referred_id_foreign` (`referred_id`),
  ADD KEY `referral_logs_property_id_foreign` (`property_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sells`
--
ALTER TABLE `sells`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sells_reference_unique` (`reference`),
  ADD KEY `sells_property_id_foreign` (`property_id`),
  ADD KEY `sells_transaction_id_foreign` (`transaction_id`),
  ADD KEY `sells_user_id_foreign` (`user_id`);

--
-- Indexes for table `sociallinks`
--
ALTER TABLE `sociallinks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_reference_unique` (`reference`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transfers_property_id_foreign` (`property_id`),
  ADD KEY `transfers_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_activities`
--
ALTER TABLE `user_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_activities_user_id_foreign` (`user_id`);

--
-- Indexes for table `virtual_accounts`
--
ALTER TABLE `virtual_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `virtual_accounts_user_id_foreign` (`user_id`),
  ADD KEY `virtual_accounts_user_email_foreign` (`user_email`);

--
-- Indexes for table `vision_missions`
--
ALTER TABLE `vision_missions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallets_user_id_foreign` (`user_id`);

--
-- Indexes for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_transactions_wallet_id_foreign` (`wallet_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abouts`
--
ALTER TABLE `abouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `buys`
--
ALTER TABLE `buys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact_detials`
--
ALTER TABLE `contact_detials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dropdown_items`
--
ALTER TABLE `dropdown_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `neighborhoods`
--
ALTER TABLE `neighborhoods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `neighborhood_categories`
--
ALTER TABLE `neighborhood_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `offerprices`
--
ALTER TABLE `offerprices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `privacies`
--
ALTER TABLE `privacies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `property_price_updates`
--
ALTER TABLE `property_price_updates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `property_valuations`
--
ALTER TABLE `property_valuations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `property_valuation_predictions`
--
ALTER TABLE `property_valuation_predictions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `property_valuation_summaries`
--
ALTER TABLE `property_valuation_summaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `referral_logs`
--
ALTER TABLE `referral_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sells`
--
ALTER TABLE `sells`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sociallinks`
--
ALTER TABLE `sociallinks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_activities`
--
ALTER TABLE `user_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `virtual_accounts`
--
ALTER TABLE `virtual_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `vision_missions`
--
ALTER TABLE `vision_missions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dropdown_items`
--
ALTER TABLE `dropdown_items`
  ADD CONSTRAINT `dropdown_items_menu_item_id_foreign` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `neighborhoods`
--
ALTER TABLE `neighborhoods`
  ADD CONSTRAINT `neighborhoods_neighborhood_category_id_foreign` FOREIGN KEY (`neighborhood_category_id`) REFERENCES `neighborhood_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `neighborhoods_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_neighborhood_category_id_foreign` FOREIGN KEY (`neighborhood_category_id`) REFERENCES `neighborhood_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `property_price_updates`
--
ALTER TABLE `property_price_updates`
  ADD CONSTRAINT `property_price_updates_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `property_valuations`
--
ALTER TABLE `property_valuations`
  ADD CONSTRAINT `property_valuations_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `property_valuation_predictions`
--
ALTER TABLE `property_valuation_predictions`
  ADD CONSTRAINT `property_valuation_predictions_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `referral_logs`
--
ALTER TABLE `referral_logs`
  ADD CONSTRAINT `referral_logs_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `referral_logs_referred_id_foreign` FOREIGN KEY (`referred_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `referral_logs_referrer_id_foreign` FOREIGN KEY (`referrer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sells`
--
ALTER TABLE `sells`
  ADD CONSTRAINT `sells_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sells_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sells_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transfers`
--
ALTER TABLE `transfers`
  ADD CONSTRAINT `transfers_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transfers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_activities`
--
ALTER TABLE `user_activities`
  ADD CONSTRAINT `user_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `virtual_accounts`
--
ALTER TABLE `virtual_accounts`
  ADD CONSTRAINT `virtual_accounts_user_email_foreign` FOREIGN KEY (`user_email`) REFERENCES `users` (`email`) ON DELETE CASCADE,
  ADD CONSTRAINT `virtual_accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallets`
--
ALTER TABLE `wallets`
  ADD CONSTRAINT `wallets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD CONSTRAINT `wallet_transactions_wallet_id_foreign` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
