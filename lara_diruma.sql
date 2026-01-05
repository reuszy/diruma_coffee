-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 05, 2026 at 03:25 AM
-- Server version: 8.4.3
-- PHP Version: 8.5.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lara_diruma`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `valid_until` date DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `name`, `content`, `valid_until`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Katering Akan Datang', '<h1>Katering Minggu Depan</h1><p><br /></p><p> Diruma akan menyajikan menu Ayam Bakar Sehat untuk Catering minggu depan, yuk pesan sekarang!!</p>', '2026-01-03', 'blog-images/1765064755-ayambakar.jpg', '2025-12-02 12:10:10', '2025-12-22 17:03:56'),
(2, 'Katering Saat Ini', '<h1>TODAY\'S CATERING!</h1><p><br /></p><p> Saat ini Diruma Coffee Living sedang menyajikan Menu Katering Nasi Kuning!</p><p> Nasi Kuning itu sehat loh, dengan kandungan gizi abcdefghijk</p>', '2025-12-24', 'blog-images/1766385091-naskun.jpeg', '2025-12-03 00:30:18', '2025-12-23 11:19:05');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Coffee', '2025-10-28 02:14:29', '2025-12-12 14:32:35'),
(2, 'Creamy', '2025-10-28 02:14:34', '2025-12-12 13:08:39'),
(11, 'Strawberry Series', '2025-12-12 13:09:16', '2025-12-12 13:09:16'),
(12, 'Nyeger', '2025-12-12 13:09:40', '2025-12-12 13:09:40'),
(13, 'Ngeteh', '2025-12-12 13:09:49', '2025-12-12 13:09:49'),
(14, 'Mocktail', '2025-12-12 13:10:02', '2025-12-12 13:10:02'),
(16, 'Mangkuk Diruma', '2025-12-12 13:10:32', '2025-12-12 13:10:32'),
(17, 'Asli Diruma', '2025-12-12 13:10:49', '2025-12-12 13:10:49'),
(18, 'Western', '2025-12-12 13:11:00', '2025-12-12 13:11:00'),
(19, 'Snack', '2025-12-12 13:11:09', '2025-12-12 13:11:09'),
(20, 'Sourdough', '2025-12-12 13:11:27', '2025-12-12 13:11:27'),
(21, 'Soft Cookies', '2025-12-12 13:12:07', '2025-12-12 13:12:07'),
(22, 'Bomboloni', '2025-12-12 13:12:18', '2025-12-12 13:12:18'),
(23, 'Donat', '2025-12-12 13:12:29', '2025-12-12 13:12:29'),
(24, 'Chiffon', '2025-12-12 13:12:48', '2025-12-12 13:12:48'),
(25, 'Chiffon Mini', '2025-12-12 13:12:58', '2025-12-12 13:12:58'),
(26, 'Brownies', '2025-12-12 13:13:09', '2025-12-12 13:13:09'),
(27, 'Cookies', '2025-12-12 13:13:21', '2025-12-12 13:13:21'),
(29, 'Indomie', '2025-12-23 11:20:59', '2025-12-23 11:20:59'),
(30, 'Katering', '2025-12-23 18:03:54', '2025-12-23 18:03:54');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone_number`, `address`, `created_at`, `updated_at`) VALUES
(84, 'Izma', 'izma@gmail.com', '087784734099', 'Perumahan Puri Hijau Purwokerto 12345', '2025-12-07 14:15:49', '2025-12-07 14:15:49'),
(85, 'Izma', 'izma@gmail.com', '087784734099', 'Perumahan Puri Hijau Purwokerto 123', '2025-12-10 00:56:32', '2025-12-10 00:56:32'),
(86, 'Alexios', 'alexios@gmail.com', '08145678912', 'jl. pumas 16 no 14 Purwokerto 16418', '2025-12-10 01:13:39', '2025-12-10 01:13:39'),
(87, 'Alexios', 'alexios@gmail.com', '08145678912', 'pumas pwt 16418', '2025-12-10 01:22:23', '2025-12-10 01:22:23'),
(91, 'Saputra', 'saputra@gmail.com', '08123456789', 'Perumahan Puri Hijau Purwokerto 12345', '2025-12-12 14:26:37', '2025-12-12 14:26:37'),
(93, 'Testing', 'test1@gmail.com', '0812345', 'Perumahan Puri Hijau Purwokerto 12345', '2025-12-13 08:24:40', '2025-12-13 08:24:40'),
(94, 'jempol', 'dadar@dadar.com', '81822828', 'asd asd asd', '2025-12-15 03:14:08', '2025-12-15 03:14:08'),
(95, 'Izma', 'izma@gmail.com', '087', 'Perumahan Puri Hijau Purwokerto 12345', '2025-12-18 07:07:25', '2025-12-18 07:07:25'),
(96, 'Izma', 'izma@gmail.com', '0877', 'Perumahan Puri Hijau Purwokerto 12345', '2025-12-18 11:22:21', '2025-12-18 11:22:21'),
(101, 'Izma', 'izma@gmail.com', '087', 'Perumahan Puri Hijau Purwokerto 123', '2025-12-18 15:10:38', '2025-12-18 15:10:38'),
(102, 'Izma', 'izma@gmail.com', '08712345678', 'Perumahan Puri Hijau Purwokerto 123', '2025-12-18 15:21:09', '2025-12-18 15:21:09'),
(105, 'Izma', 'izma@gmail.com', '087', 'Perumahan Puri Hijau Purwokerto 123', '2025-12-19 13:42:34', '2025-12-19 13:42:34'),
(106, 'Izma', 'izma@gmail.com', '087', 'Purwokerto Purwokerto 123', '2025-12-19 13:44:14', '2025-12-19 13:44:14'),
(107, 'Izma', 'izma@gmail.com', '087', 'Perumahan Puri Hijau, Purwokerto, 123', '2025-12-19 13:54:43', '2025-12-19 13:54:43'),
(108, 'Daffa', 'daffa@gmail.com', '123456789', 'Perumahan Puri Hijau, Jl. Pumas no. 100, Rumah no 800, Purwokerto selatan, Purwokerto, 123', '2025-12-19 14:00:37', '2025-12-19 14:00:37'),
(111, 'Dwi Saputra', 'dwis080817@gmail.com', '08771234567', 'pe, Purwokerto, 12345', '2025-12-21 19:42:42', '2025-12-21 19:42:42'),
(112, 'Rafi', 'rafivalorant06@gmail.com', '088271376471', 'Jl. Puri Hijau Pumas 16 No 14, Windusara, KarangKlesem, Kec.Purwokerto Selatan, Kab.Banyumas, purwokerto, 21341423', '2025-12-22 07:02:24', '2025-12-22 07:02:24'),
(113, 'Rafi', 'rafivalorant06@gmail.com', '088271376471', 'Jl. Puri Hijau Pumas 16 No 14, Windusara, KarangKlesem, Kec.Purwokerto Selatan, Kab.Banyumas, purwokerto, 21341423', '2025-12-22 07:06:49', '2025-12-22 07:06:49'),
(114, 'Rafi', 'rafivalorant06@gmail.com', '088271376471', 'Jl. Puri Hijau Pumas 16 No 14, Windusara, KarangKlesem, Kec.Purwokerto Selatan, Kab.Banyumas, purwokerto, 21341423', '2025-12-22 07:18:03', '2025-12-22 07:18:03'),
(115, 'Izma', 'drawing77rz@gmail.com', '088290366459', 'Perumahan Puri Hijau, Pumas 16 No. 14 Karangklesem, Purwokerto Selatan, Banyumas, 53144', '2025-12-22 11:13:53', '2025-12-22 11:13:53'),
(118, 'Izma', 'drawing77rz@gmail.com', '088290366459', 'Perumahan Puri Hijau, Pumas 16 No. 14 Karangklesem, Purwokerto Selatan, Banyumas, 53144', '2025-12-23 10:33:28', '2025-12-23 10:33:28'),
(121, 'Dwi', 'dwis080817@gmail.com', '0812345678', 'Perumahan Puri Hijau 16, Purwokerto, 12345', '2025-12-23 16:24:12', '2025-12-23 16:24:12'),
(123, 'Raditya', 'raditt@gmail.com', '081229427958', 'Pumas 16, Purwokerto Selatan, 53322', '2025-12-23 17:30:03', '2025-12-23 17:30:03'),
(125, 'Dwi', 'dwis080817@gmail.com', '0812345678', 'Perumahan Puri Hijau, Jl. Pumas no. 100, Rumah no 800, Purwokerto selatan, Puerto Rico Selatan, 12345', '2025-12-23 18:18:32', '2025-12-23 18:18:32'),
(129, 'Messi', 'messi@gmail.com', '12345678', 'Perumahan Puri Hijau, Purwokerto Selatan, 12345', '2025-12-24 03:49:17', '2025-12-24 03:49:17'),
(146, 'Messi', 'messi@gmail.com', '1234567', 'Perumahan Puri Hijau, Jl. Pumas no. 100, Rumah no 800, Puerto Rico Selatan, 12345', '2025-12-31 00:33:14', '2025-12-31 00:33:14'),
(147, 'Messi', 'messi@gmail.com', '1234567', 'Perumahan Puri Hijau, Jl. Pumas no. 100, Rumah no 800, Puerto Rico Selatan, 12345', '2025-12-31 00:48:45', '2025-12-31 00:48:45'),
(148, 'Messi', 'messi@gmail.com', '1234567', 'Perumahan Puri Hijau, Jl. Pumas no. 100, Rumah no 800, Puerto Rico Selatan, 12345', '2025-12-31 02:05:40', '2025-12-31 02:05:40'),
(149, 'Messi', 'messi@gmail.com', '1234567', 'Perumahan Puri Hijau, Jl. Pumas no. 100, Rumah no 800, Purwokerto selatan, Puerto Rico Selatan, 12345', '2025-12-31 02:10:18', '2025-12-31 02:10:18');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `live_chat_scripts`
--

CREATE TABLE `live_chat_scripts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `script_code` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `description`, `price`, `stock`, `image`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Americano (Ice/Hot)', 'Espresso & air', 20000.00, 0, 'menus/1765548281-Need a simple, energizing and refreshing drink_….jpg', 1, '2025-10-28 02:30:17', '2025-12-22 18:13:28'),
(2, 'Chocolate Milkshake', 'Enak banget', 18000.00, 10, 'menus/1764979325-Chocolate-Milkshake-A_chocolate-milkshake-final-shot-2.jpg', 2, '2025-10-28 02:59:02', '2025-12-23 11:03:37'),
(4, 'Cafe Latte (Ice/Hot)', 'campuran espresso dan susu', 24000.00, 0, 'menus/1765548303-Latte Macchiato Recipe for Home Baristas.jpg', 1, '2025-12-05 17:00:51', '2025-12-12 14:05:03'),
(9, 'Cappucino', 'campuran espresso dan susu yang di steam', 24000.00, 0, 'menus/1765547778-Here’s how to make cappuccino at home! This….jpg', 1, '2025-12-12 13:21:10', '2025-12-12 13:56:18'),
(10, 'Affogtao', 'campuran ice cream dengan espresso', 20000.00, 0, 'menus/1765545742-Plongez dans l’élégance d’un dessert italien….jpg', 1, '2025-12-12 13:22:22', '2025-12-12 13:22:22'),
(11, 'Iced Black Lime', 'campuran esspresso dengan lime yang segar', 22000.00, 0, 'menus/1765547795-Dark Stormy Cocktail🍹 5 ingredients  Produce • 1….jpg', 1, '2025-12-12 13:23:31', '2025-12-12 13:56:35'),
(12, 'Iced Vanilla Oreo', 'campuran vanilla, oreo dan espresso', 26000.00, 0, 'menus/1765546084-Indulge a little with this super easy Oreo….jpg', 1, '2025-12-12 13:28:04', '2025-12-12 13:28:04'),
(13, 'Iced Caremel Machiato', 'canpuran caramel yang creamy dengan essprresso', 26000.00, 0, 'menus/1765546182-Iced Caramel Macchiato Copycat_ 5-Minute Magic….jpg', 1, '2025-12-12 13:29:42', '2025-12-12 13:29:42'),
(14, 'Iced Rum Regal Latte', 'campuran rum dan regal dengan esspresso', 26000.00, 0, 'menus/1765546255-Cinnamon Rum Iced Coffee.jpg', 1, '2025-12-12 13:30:55', '2025-12-12 13:30:55'),
(15, 'Iced Sea Salt Butterscoth', 'campuran butterscoth dengan sea salt yang creamy', 28000.00, 0, 'menus/1765547257-Butterscotch Latte – A delicious homemade latte….jpg', 1, '2025-12-12 13:47:37', '2025-12-12 13:47:37'),
(16, 'Iced Salted Caramel', 'campuran salted caramel dengan susu', 26000.00, 0, 'menus/1765547412-Iced Salted Caramel Latte – Cravi Recipes.jpg', 1, '2025-12-12 13:50:12', '2025-12-12 13:50:12'),
(17, 'Iced Banana Latte', 'campuran syrup bananan dan susu', 24000.00, 0, 'menus/1765547454-Banana Latte_ A Sweet Twist on Your Morning Brew….jpg', 1, '2025-12-12 13:50:54', '2025-12-12 13:50:54'),
(18, 'Kopi Cube Diruma', 'esspresso yang di bekukan lalu dicampur dengan susu', 26000.00, 0, 'menus/1765547531-Coffee Ice Cubes - coffeecopycat_com.jpg', 1, '2025-12-12 13:52:11', '2025-12-12 13:52:11'),
(19, 'Coconut Latte (Ice/Hot)', 'campuran syrup coconut atau kelapa yang segar dan creamy', 24000.00, 0, 'menus/1765547587-Some things seem far too decadent to go together….jpg', 1, '2025-12-12 13:53:07', '2025-12-12 13:57:16'),
(20, 'Hazelnut Latte (Ice/Hot)', 'campuran hazelnut susu dan espresso', 24000.00, 0, 'menus/1765547639-Homemade Hazelnut Latte.jpg', 1, '2025-12-12 13:53:59', '2025-12-12 13:57:42'),
(21, 'Caramel Latte (Ice/Hot)', 'campuran caramel dan susu', 24000.00, 0, 'menus/1765547681-Making a hot caramel latte at home has never been….jpg', 1, '2025-12-12 13:54:41', '2025-12-12 13:58:17'),
(22, 'Vanilla Latte (Ice/Hot)', 'campuran vanila dan susu', 24000.00, 0, 'menus/1765547728-Nespresso Iced Vanilla Oat Milk Latte.jpg', 1, '2025-12-12 13:55:28', '2025-12-12 13:58:59'),
(30, 'Chicken Grilled With Healthy Rice', 'Perpaduan ayam panggang yang gurih dengan nasi low sugar dan protein tinggi', 35000.00, 17, 'menus/1766513574-IMG_7119 (1).jpg', 30, '2025-12-23 18:12:55', '2025-12-31 02:10:18'),
(31, 'Chicken Spicy With Red Rice', 'perpaduan ayam panggang bumbu pedas dengan nasi merah', 37000.00, 31, 'menus/1766513694-IMG_7109.jpg', 30, '2025-12-23 18:14:55', '2025-12-31 02:05:40'),
(32, 'Potato Wedges With Chicken Blackpapper', 'Perpaduan kentang panggang yang gurih dengan potongan ayam saus blackpapper', 40000.00, 46, 'menus/1766513783-IMG_7115.jpg', 30, '2025-12-23 18:16:24', '2025-12-31 02:10:18'),
(33, 'Chicken Grilled With Red Rice', 'Perpaduan ayam panggang yang gurih dengan nasi merah', 36000.00, 24, 'menus/1766514481-IMG_5879 (1).jpg', 30, '2025-12-23 18:28:02', '2025-12-31 00:48:45'),
(34, 'Meatball With Potato Wedges', 'Perpaduan meatball yang gurih dengan campuran kentang panggang yang gurih', 4500000.00, 49, 'menus/1766514567-IMG_6095 (1).jpg', 30, '2025-12-23 18:29:27', '2025-12-23 18:29:27');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_11_30_165529_create_menus_table', 1),
(5, '2024_11_30_165534_create_categories_table', 1),
(6, '2024_11_30_165540_create_orders_table', 1),
(7, '2024_11_30_165547_create_order_items_table', 1),
(8, '2024_11_30_165554_create_site_settings_table', 1),
(9, '2024_11_30_172226_add_category_id_to_menus_table', 1),
(10, '2024_12_02_201208_move_timestamps_to_end_of_menus_table', 1),
(11, '2024_12_02_221650_create_blogs_table', 1),
(12, '2024_12_03_215710_create_restaurant_addresses_table', 1),
(13, '2024_12_03_215715_create_restaurant_phone_numbers_table', 1),
(14, '2024_12_03_215721_create_restaurant_working_hours_table', 1),
(15, '2024_12_03_223705_rename_restaurant_phonenumbers_table', 1),
(16, '2024_12_03_224414_rename_restaurant_workinghours_table', 1),
(17, '2024_12_05_213918_add_use_whatsapp_to_restaurant_phone_numbers_table', 1),
(18, '2024_12_05_231222_create_social_media_handles_table', 1),
(19, '2024_12_06_182927_create_live_chat_scripts_table', 1),
(20, '2024_12_08_161220_recreate_users_table', 1),
(21, '2024_12_11_212508_create_customers_table', 1),
(22, '2024_12_11_213333_edit_orders_table', 1),
(23, '2024_12_12_212054_rename_price_to_subtotal_in_order_items_table', 1),
(24, '2024_12_12_225521_make_customer_fields_nullable', 1),
(25, '2024_12_13_200343_update_order_items_table', 1),
(26, '2024_12_13_212418_alter_orders_table_add_payment_method_and_order_no', 1),
(27, '2024_12_23_073028_create_order_settings_table', 1),
(28, '2024_12_23_140957_add_fields_to_orders_table', 1),
(29, '2024_12_25_191851_update_site_settings_table', 1),
(30, '2024_12_27_163605_create_testimonies_table', 1),
(31, '2024_12_27_185121_create_terms_and_conditions_table', 1),
(32, '2024_12_27_193555_create_privacy_policies_table', 1),
(33, '2024_12_27_220756_create_table_bookings_table', 1),
(34, '2024_12_29_214054_add_status_online_pay_and_session_id_to_orders_table', 1),
(35, '2025_10_26_111825_add_customer_role_to_users_table', 1),
(36, '2025_12_05_232424_create_personal_access_tokens_table', 2),
(37, '2025_12_18_172311_add_stock_menu', 3),
(38, '2025_12_19_232907_add_google_login', 4),
(39, '2025_12_22_204950_add_sampai_tanggal', 5);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `order_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `order_type` enum('online','instore') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by_user_id` bigint UNSIGNED DEFAULT NULL,
  `updated_by_user_id` bigint UNSIGNED DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','delivered','completed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `status_online_pay` enum('paid','unpaid') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `additional_info` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_fee` decimal(8,2) DEFAULT NULL,
  `delivery_distance` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_per_mile` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_no`, `customer_id`, `order_type`, `created_by_user_id`, `updated_by_user_id`, `total_price`, `status`, `status_online_pay`, `session_id`, `payment_method`, `additional_info`, `delivery_fee`, `delivery_distance`, `price_per_mile`, `created_at`, `updated_at`) VALUES
(84, 'ORD-20251207211549', 84, 'online', 9, 1, 21000.00, 'completed', 'paid', NULL, 'MIDTRANS', NULL, 0.00, NULL, 0.00, '2025-12-07 14:15:49', '2025-12-18 11:26:37'),
(85, 'ORD-20251210075632', 85, 'online', 9, 1, 42000.00, 'completed', 'paid', NULL, 'MIDTRANS', NULL, 0.00, NULL, 0.00, '2025-12-10 00:56:32', '2025-12-18 11:26:34'),
(86, 'ORD-20251210081339', 86, 'online', 11, 1, 21000.00, 'completed', 'paid', NULL, 'MIDTRANS', 'alergi nasi', 0.00, NULL, 0.00, '2025-12-10 01:13:39', '2025-12-18 11:26:32'),
(87, 'ORD-20251210082223', 87, 'online', 11, 1, 42000.00, 'completed', 'paid', NULL, 'MIDTRANS', 'alergi telur', 0.00, NULL, 0.00, '2025-12-10 01:22:23', '2025-12-18 11:26:29'),
(97, 'ORD-20251218140725', 95, 'online', 9, 1, 63000.00, 'completed', 'paid', NULL, 'MIDTRANS', NULL, 0.00, NULL, 0.00, '2025-12-18 07:07:25', '2025-12-18 07:10:19'),
(98, 'ORD-20251218182221', 96, 'online', 9, 1, 85000.00, 'completed', 'paid', NULL, 'MIDTRANS', NULL, 0.00, NULL, 0.00, '2025-12-18 11:22:21', '2025-12-21 19:46:20'),
(103, 'ORD-20251218221038', 101, 'online', 9, 1, 24000.00, 'completed', 'paid', NULL, 'MIDTRANS', NULL, 0.00, NULL, 0.00, '2025-12-18 15:10:38', '2025-12-21 19:46:41'),
(104, 'ORD-20251218222109', 102, 'online', 9, 1, 34000.00, 'completed', 'paid', NULL, 'QRIS', 'JANGAN PEDES', 0.00, NULL, 0.00, '2025-12-18 15:21:09', '2025-12-21 19:46:37'),
(107, 'ORD-20251219204234', 105, 'online', 9, 1, 34000.00, 'completed', 'paid', NULL, 'QRIS', NULL, 0.00, NULL, 0.00, '2025-12-19 13:42:34', '2025-12-21 19:46:33'),
(108, 'ORD-20251219204414', 106, 'online', 9, 1, 17000.00, 'completed', 'paid', NULL, 'Mandiri VA', NULL, 0.00, NULL, 0.00, '2025-12-19 13:44:14', '2025-12-21 19:46:30'),
(109, 'ORD-20251219205443', 107, 'online', 9, 1, 17000.00, 'completed', 'paid', NULL, 'QRIS', NULL, 0.00, NULL, 0.00, '2025-12-19 13:54:43', '2025-12-21 19:46:26'),
(110, 'ORD-20251219210037', 108, 'online', 10, 1, 34000.00, 'completed', 'paid', NULL, 'QRIS', NULL, 0.00, NULL, 0.00, '2025-12-19 14:00:37', '2025-12-21 19:46:23'),
(113, 'ORD-20251222024242', 111, 'online', 20, 1, 17000.00, 'completed', 'paid', NULL, 'QRIS', NULL, 0.00, NULL, 0.00, '2025-12-21 19:42:42', '2025-12-23 09:47:52'),
(114, 'ORD-20251222140224', 112, 'online', 22, NULL, 13000.00, 'pending', 'unpaid', NULL, 'MIDTRANS', 'adfceawsfwq', 0.00, NULL, 0.00, '2025-12-22 07:02:24', '2025-12-22 07:02:24'),
(115, 'ORD-20251222140649', 113, 'online', 22, NULL, 13000.00, 'pending', 'unpaid', NULL, 'MIDTRANS', 'wawfdwawdad', 0.00, NULL, 0.00, '2025-12-22 07:06:49', '2025-12-22 07:06:49'),
(116, 'ORD-20251222141803', 114, 'online', 22, NULL, 13000.00, 'pending', 'unpaid', NULL, 'MIDTRANS', 'sdad', 0.00, NULL, 0.00, '2025-12-22 07:18:03', '2025-12-22 11:55:07'),
(117, 'ORD-20251222181353', 115, 'online', 24, 1, 13000.00, 'completed', 'paid', NULL, 'QRIS', NULL, 0.00, NULL, 0.00, '2025-12-22 11:13:53', '2025-12-22 18:12:13'),
(124, 'ORD-20251223173328', 118, 'online', 24, NULL, 12000.00, 'pending', 'unpaid', NULL, 'MIDTRANS', '-', 0.00, NULL, 0.00, '2025-12-23 10:33:28', '2025-12-23 10:33:28'),
(127, 'ORD-20251223232412', 121, 'online', 20, 1, 36000.00, 'completed', 'paid', NULL, 'QRIS', 'Minta ekstra sambal', 0.00, NULL, 0.00, '2025-12-23 16:24:12', '2025-12-23 16:27:02'),
(129, 'ORD-20251224003003', 123, 'online', 26, NULL, 12000.00, 'pending', 'unpaid', NULL, 'MIDTRANS', NULL, 0.00, NULL, 0.00, '2025-12-23 17:30:03', '2025-12-23 17:30:03'),
(131, 'ORD-20251224011832', 125, 'online', 20, 1, 80000.00, 'delivered', 'paid', NULL, 'Mandiri VA', NULL, 0.00, NULL, 0.00, '2025-12-23 18:18:32', '2025-12-24 05:04:05'),
(135, 'ORD-20251224104917', 129, 'online', 33, 1, 36000.00, 'completed', 'paid', NULL, 'QRIS', NULL, 0.00, NULL, 0.00, '2025-12-24 03:49:17', '2025-12-31 00:34:16'),
(152, 'ORD-20251231073314', 146, 'online', 33, 1, 37000.00, 'completed', 'paid', NULL, 'Mandiri VA', NULL, 0.00, NULL, 0.00, '2025-12-31 00:33:14', '2025-12-31 00:50:04'),
(153, 'ORD-20251231074845', 147, 'online', 33, 1, 72000.00, 'delivered', 'paid', NULL, 'QRIS', 'Jangan pedas karena aku tidak suka pedas', 0.00, NULL, 0.00, '2025-12-31 00:48:45', '2025-12-31 00:50:29'),
(154, 'ORD-20251231090540', 148, 'online', 33, NULL, 37000.00, 'pending', 'unpaid', NULL, 'MIDTRANS', NULL, 0.00, NULL, 0.00, '2025-12-31 02:05:40', '2025-12-31 02:05:40'),
(155, 'ORD-20251231091018', 149, 'online', 33, 1, 75000.00, 'completed', 'paid', NULL, 'QRIS', NULL, 0.00, NULL, 0.00, '2025-12-31 02:10:18', '2025-12-31 02:12:40');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `menu_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `menu_name`, `order_id`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(84, 'Nasi Kuning', 84, 1, 21000.00, '2025-12-07 14:15:49', '2025-12-07 14:15:49'),
(85, 'Nasi Kuning', 85, 2, 42000.00, '2025-12-10 00:56:32', '2025-12-10 00:56:32'),
(86, 'Nasi Kuning', 86, 1, 21000.00, '2025-12-10 01:13:39', '2025-12-10 01:13:39'),
(87, 'Nasi Kuning', 87, 2, 42000.00, '2025-12-10 01:22:23', '2025-12-10 01:22:23'),
(97, 'Nasi Kuning', 97, 3, 63000.00, '2025-12-18 07:07:25', '2025-12-18 07:07:25'),
(98, 'Nasi Uduk', 98, 5, 85000.00, '2025-12-18 11:22:21', '2025-12-18 11:22:21'),
(103, 'Nasi Kuning', 103, 2, 24000.00, '2025-12-18 15:10:38', '2025-12-18 15:10:38'),
(104, 'Nasi Uduk', 104, 2, 34000.00, '2025-12-18 15:21:09', '2025-12-18 15:21:09'),
(107, 'Nasi Uduk', 107, 2, 34000.00, '2025-12-19 13:42:34', '2025-12-19 13:42:34'),
(108, 'Nasi Uduk', 108, 1, 17000.00, '2025-12-19 13:44:14', '2025-12-19 13:44:14'),
(109, 'Nasi Uduk', 109, 1, 17000.00, '2025-12-19 13:54:43', '2025-12-19 13:54:43'),
(110, 'Nasi Uduk', 110, 2, 34000.00, '2025-12-19 14:00:37', '2025-12-19 14:00:37'),
(113, 'Nasi Uduk', 113, 1, 17000.00, '2025-12-21 19:42:42', '2025-12-21 19:42:42'),
(114, 'Nasi Uduk', 114, 1, 13000.00, '2025-12-22 07:02:24', '2025-12-22 07:02:24'),
(115, 'Nasi Uduk', 115, 1, 13000.00, '2025-12-22 07:06:49', '2025-12-22 07:06:49'),
(116, 'Nasi Uduk', 116, 1, 13000.00, '2025-12-22 07:18:03', '2025-12-22 07:18:03'),
(117, 'Nasi Uduk', 117, 1, 13000.00, '2025-12-22 11:13:53', '2025-12-22 11:13:53'),
(122, 'Nasi Kuning', 124, 1, 12000.00, '2025-12-23 10:33:28', '2025-12-23 10:33:28'),
(125, 'Nasi Kuning', 127, 3, 36000.00, '2025-12-23 16:24:12', '2025-12-23 16:24:12'),
(127, 'Nasi Kuning', 129, 1, 12000.00, '2025-12-23 17:30:03', '2025-12-23 17:30:03'),
(129, 'Potato Wedges With Chicken Blackpapper', 131, 2, 80000.00, '2025-12-23 18:18:32', '2025-12-23 18:18:32'),
(133, 'Chicken Grilled With Red Rice', 135, 1, 36000.00, '2025-12-24 03:49:17', '2025-12-24 03:49:17'),
(151, 'Chicken Spicy With Red Rice', 152, 1, 37000.00, '2025-12-31 00:33:14', '2025-12-31 00:33:14'),
(152, 'Chicken Grilled With Red Rice', 153, 2, 72000.00, '2025-12-31 00:48:45', '2025-12-31 00:48:45'),
(153, 'Chicken Spicy With Red Rice', 154, 1, 37000.00, '2025-12-31 02:05:40', '2025-12-31 02:05:40'),
(154, 'Chicken Grilled With Healthy Rice', 155, 1, 35000.00, '2025-12-31 02:10:18', '2025-12-31 02:10:18'),
(155, 'Potato Wedges With Chicken Blackpapper', 155, 1, 40000.00, '2025-12-31 02:10:18', '2025-12-31 02:10:18');

-- --------------------------------------------------------

--
-- Table structure for table `order_settings`
--

CREATE TABLE `order_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `price_per_mile` decimal(8,2) NOT NULL,
  `distance_limit_in_miles` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_settings`
--

INSERT INTO `order_settings` (`id`, `price_per_mile`, `distance_limit_in_miles`, `created_at`, `updated_at`) VALUES
(1, 0.00, 0, '2025-12-02 18:20:18', '2025-12-02 20:10:44');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('dwwis090505@gmail.com', '$2y$12$Kq6qznbaby6L8rwHVe4q5O9v2OktiIOACxcXx.HwJKi9RIIAXYu.K', '2025-12-13 09:23:03'),
('reuszy@gmail.com', '$2y$12$/x3FaRIBgWfk3TWRW.UowewyYIWGeNkkxOOWITxE0gYMiPiajCY7q', '2025-12-02 12:04:19');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `privacy_policies`
--

CREATE TABLE `privacy_policies` (
  `id` bigint UNSIGNED NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_addresses`
--

CREATE TABLE `restaurant_addresses` (
  `id` bigint UNSIGNED NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `restaurant_addresses`
--

INSERT INTO `restaurant_addresses` (`id`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Jl. Sultan Agung No.255, Karang Malang, Teluk, Kec. Purwokerto Selatan, Kabupaten Banyumas, Jawa Tengah 53145', '2025-10-28 17:41:27', '2025-12-23 12:00:39');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_phone_numbers`
--

CREATE TABLE `restaurant_phone_numbers` (
  `id` bigint UNSIGNED NOT NULL,
  `phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `use_whatsapp` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `restaurant_phone_numbers`
--

INSERT INTO `restaurant_phone_numbers` (`id`, `phone_number`, `use_whatsapp`, `created_at`, `updated_at`) VALUES
(1, '+6288290366459', 1, '2025-10-28 17:40:41', '2025-12-12 13:48:53');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_working_hours`
--

CREATE TABLE `restaurant_working_hours` (
  `id` bigint UNSIGNED NOT NULL,
  `working_hours` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `restaurant_working_hours`
--

INSERT INTO `restaurant_working_hours` (`id`, `working_hours`, `created_at`, `updated_at`) VALUES
(1, 'Setiap Hari : 07.00 sd 22.00 WIB', '2025-10-28 17:46:34', '2025-12-18 08:21:33');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('2mwlBRdFthrF51pE1ugvuNcboxmORkysWlIZjDwD', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRVpoZmF4bXFRZkg5Uk9GS2VtM0ZIZ0daSFR6dzF3YjVPNnZkZjlSaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9kaXJ1bWEucmV1c3p5LnNpdGUvYWRtaW4vb3JkZXJzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1767141256),
('bRtDMEsvigJofXRWqt8Ck9NzjqXcnsZn1pZeF8MI', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoibEMweWJORWR6elo0Z0lqallUeG81V1NyazRaUG9VNXVqWUdweDBnciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9kaXJ1bWEucmV1c3p5LnNpdGUvYWRtaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjg6ImN1c3RvbWVyIjthOjE6e2k6MzE7YTo1OntzOjI6ImlkIjtzOjI6IjMxIjtzOjQ6Im5hbWUiO3M6Mjc6IkNoaWNrZW4gU3BpY3kgV2l0aCBSZWQgUmljZSI7czo1OiJwcmljZSI7czo4OiIzNzAwMC4wMCI7czo3OiJpbWdfc3JjIjtzOjY0OiJodHRwczovL2RpcnVtYS5yZXVzenkuc2l0ZS9zdG9yYWdlL21lbnVzLzE3NjY1MTM2OTQtSU1HXzcxMDkuanBnIjtzOjg6InF1YW50aXR5IjtpOjE7fX1zOjM6InVybCI7YTowOnt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1767147894),
('iXmdNNiURzwhbr4Z1Oh14PUz4xTqy8UYfSCSBi0B', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY0lmbWlqODNMeUk1ekcyWkRudnRETGhVV3RnSUxuT1g3cmVFQkpTVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9kaXJ1bWEucmV1c3p5LnNpdGUvbWVudS1pdGVtLzE2Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1767582952),
('MOygyAwMzLnNvheHUTIC0WPAWnaSej1Hyuip6ls5', 33, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoicFFEWlZ0aWV1aWwwR05ISFd3TkwyRUJ6aVJaZVExclJmMHE3enZFciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly9kaXJ1bWEucmV1c3p5LnNpdGUvY3VzdG9tZXIvZGV0YWlsLzE1NSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjMzO3M6ODoiY3VzdG9tZXIiO2E6Mjp7aTozMDthOjU6e3M6MjoiaWQiO3M6MjoiMzAiO3M6NDoibmFtZSI7czozMzoiQ2hpY2tlbiBHcmlsbGVkIFdpdGggSGVhbHRoeSBSaWNlIjtzOjU6InByaWNlIjtzOjg6IjM1MDAwLjAwIjtzOjc6ImltZ19zcmMiO3M6Njg6Imh0dHBzOi8vZGlydW1hLnJldXN6eS5zaXRlL3N0b3JhZ2UvbWVudXMvMTc2NjUxMzU3NC1JTUdfNzExOSAoMSkuanBnIjtzOjg6InF1YW50aXR5IjtzOjE6IjEiO31pOjMyO2E6NTp7czoyOiJpZCI7czoyOiIzMiI7czo0OiJuYW1lIjtzOjM4OiJQb3RhdG8gV2VkZ2VzIFdpdGggQ2hpY2tlbiBCbGFja3BhcHBlciI7czo1OiJwcmljZSI7czo4OiI0MDAwMC4wMCI7czo3OiJpbWdfc3JjIjtzOjY0OiJodHRwczovL2RpcnVtYS5yZXVzenkuc2l0ZS9zdG9yYWdlL21lbnVzLzE3NjY1MTM3ODMtSU1HXzcxMTUuanBnIjtzOjg6InF1YW50aXR5IjtpOjE7fX19', 1767147166);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_symbol` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `country`, `currency_symbol`, `currency_code`, `created_at`, `updated_at`) VALUES
(1, 'Indonesia', 'Rp.', 'IDR', '2025-10-28 02:09:13', '2025-10-28 02:09:13');

-- --------------------------------------------------------

--
-- Table structure for table `social_media_handles`
--

CREATE TABLE `social_media_handles` (
  `id` bigint UNSIGNED NOT NULL,
  `handle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `social_media` enum('facebook','instagram','youtube','tiktok') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `social_media_handles`
--

INSERT INTO `social_media_handles` (`id`, `handle`, `social_media`, `created_at`, `updated_at`) VALUES
(3, 'xxreuszy', 'tiktok', '2025-12-11 23:44:33', '2025-12-11 23:44:33'),
(5, '_.saputra', 'instagram', '2025-12-12 10:06:13', '2025-12-12 10:06:13');

-- --------------------------------------------------------

--
-- Table structure for table `table_bookings`
--

CREATE TABLE `table_bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `persons` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `table_bookings`
--

INSERT INTO `table_bookings` (`id`, `name`, `email`, `phone`, `date`, `time`, `persons`, `created_at`, `updated_at`) VALUES
(1, 'Radit', 'radit1@gmail.com', '12345678', '2025-12-23', '12.00 WIB', 5, '2025-12-22 06:07:58', '2025-12-22 06:07:58');

-- --------------------------------------------------------

--
-- Table structure for table `terms_and_conditions`
--

CREATE TABLE `terms_and_conditions` (
  `id` bigint UNSIGNED NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terms_and_conditions`
--

INSERT INTO `terms_and_conditions` (`id`, `content`, `created_at`, `updated_at`) VALUES
(1, '<p>Jangan bawa sajam</p>', '2025-12-22 08:25:51', '2025-12-22 08:25:51');

-- --------------------------------------------------------

--
-- Table structure for table `testimonies`
--

CREATE TABLE `testimonies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonies`
--

INSERT INTO `testimonies` (`id`, `name`, `content`, `created_at`, `updated_at`) VALUES
(1, 'Saputra', 'Kopi nya enak kak', '2025-10-28 17:58:01', '2025-12-12 01:17:29'),
(2, 'Izma Syabrian', 'Tempat nya cozy abis cocok buat venue event TUPEC', '2025-12-12 01:03:23', '2025-12-12 01:03:23'),
(4, 'Rafi Awalaisal', 'Tempatnya nyaman dan deket dari rumah', '2025-12-12 04:14:29', '2025-12-12 04:35:30'),
(6, 'TUP Esport', 'Keren ya tempatnya', '2025-12-12 09:02:46', '2025-12-12 09:02:46'),
(8, 'Rhojay', 'Ngga terlalu mahal, cozy dan ga terlalu ramai. cocok buat saya yang suka sendiri', '2025-12-22 14:10:58', '2025-12-23 11:56:36'),
(9, 'Calistee', 'Deket terminal, enak jadinya bisa mampir dulu kalau mau berpergian menggunakan bus', '2025-12-22 17:18:51', '2025-12-22 17:23:23'),
(10, 'Reevergarden', 'Enakkkkk', '2025-12-24 04:01:45', '2025-12-24 04:01:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','global_admin','customer') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `status` tinyint NOT NULL DEFAULT '0',
  `notice` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `profile_picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activation_token` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_auth` tinyint NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `middle_name`, `last_name`, `email`, `password`, `google_id`, `role`, `status`, `notice`, `phone_number`, `address`, `profile_picture`, `activation_token`, `remember_token`, `two_factor_auth`, `email_verified_at`, `created_at`, `updated_at`) VALUES
(1, 'Rizqi', 'Dwi', 'Saputra', 'reuszy@gmail.com', '$2y$12$WtXcDit6FPZujjxcuWodfOre4WuRNNBQfcYN4cT4SarqpB3K5JC2K', NULL, 'global_admin', 1, NULL, '08123456789', 'Cirebon Pride', '9VeOYICTf0R7vwF7dQUoid3nKktwfqkTl2e84NTM.png', NULL, NULL, 0, '2025-10-28 02:13:42', '2025-10-28 02:13:42', '2025-12-23 16:32:39'),
(8, 'Rafi', NULL, 'Aw', 'rafi@gmail.com', '$2y$12$Gsy2jduY5pdm4Adah5KZ.ulCWQGeHoJrU1I98XzRbAvygSpfbBDam', NULL, 'customer', 1, NULL, '087', NULL, NULL, NULL, NULL, 0, NULL, '2025-12-02 14:54:32', '2025-12-02 14:54:32'),
(9, 'Izma', NULL, 'Syab', 'izma@gmail.com', '$2y$12$rBmdiPPZRKloqAjASk/SkOQqMJ2k4C7g5iOlaGxgRkMFzUUptociu', NULL, 'customer', 1, NULL, '087', NULL, NULL, NULL, NULL, 0, NULL, '2025-12-02 14:56:17', '2025-12-22 19:05:30'),
(10, 'Daffa', NULL, 'Zach', 'daffa@gmail.com', '$2y$12$9gqBmXeW8Mb2XWnUcVq14O34C.v2EnAo1tYCkEy8VOH57xlWTssqS', NULL, 'customer', 1, NULL, '123', NULL, NULL, NULL, NULL, 0, NULL, '2025-12-02 14:58:01', '2025-12-02 14:58:01'),
(11, 'Alexios', NULL, 'Leonidas', 'alexios@gmail.com', '$2y$12$eEEeeqwR0.zXeDBxAzHGqOld5zuJJ.gi0gMsA7yBScrwIDFZuk8jq', NULL, 'customer', 1, NULL, '08145678912', NULL, NULL, NULL, NULL, 0, NULL, '2025-12-10 01:10:21', '2025-12-10 01:10:21'),
(13, 'Radit', NULL, 'Esther', 'radit@gmail.com', '$2y$12$bnc3fnuEXejU8l.ocZSW/er36vS.BfDUbwpw2sTa8hlk9/ASjlW9K', NULL, 'customer', 1, NULL, '0812345', NULL, NULL, NULL, NULL, 0, NULL, '2025-12-13 08:12:35', '2025-12-13 08:12:35'),
(18, 'wang', NULL, 'lin', 'alexios21@gmail.com', '$2y$12$I/y3RZK.t5GT0rkBphg.keruXVa.mlvq4YSDYjuXAHLh2c9AgB29q', NULL, 'customer', 1, NULL, '08145678912', NULL, NULL, NULL, NULL, 0, NULL, '2025-12-19 15:23:26', '2025-12-19 15:23:26'),
(20, 'Dwi', NULL, 'SapuTra', 'dwis080817@gmail.com', '$2y$12$eFzNAxaDIMawEP/2X02vjuNJwtZCaoYPv9NjjL99A9mQ9R9bhPYb2', '113666931450490250452', 'customer', 1, NULL, '0812345678', 'Perumahan Puri Hijau, Jl. Pumas no. 100, Rumah no 800, Purwokerto selatan', NULL, NULL, NULL, 0, NULL, '2025-12-19 17:04:39', '2025-12-23 18:18:32'),
(22, 'Rafi', NULL, 'Awallaisal', 'rafivalorant06@gmail.com', '$2y$12$.1CYmTHicMCxcg7qX61BD.JDkCphQUv7ydASYUqLV.s7xv2IEYKnq', '105365310201470709544', 'customer', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-12-22 07:01:45', '2025-12-22 07:01:45'),
(24, 'Izma', NULL, 'Syabrian', 'drawing77rz@gmail.com', '$2y$12$24/iIUVD2ETIH7EoTN/IJecQjmb3XeH6T2VvjHFgiVBxbPJd87jCa', NULL, 'customer', 1, NULL, '088290366459', NULL, NULL, NULL, NULL, 0, NULL, '2025-12-22 08:11:54', '2025-12-24 04:05:22'),
(26, 'Raditya', NULL, 'Putra', 'raditt@gmail.com', '$2y$12$Kxy8KqcnvwLisL5JR0qML.tsewOnNUnFa73sj.iDfUrbky.wti8de', NULL, 'customer', 1, NULL, '081229427958', 'dada', NULL, NULL, NULL, 0, NULL, '2025-12-22 17:21:58', '2025-12-23 17:52:13'),
(28, 'Rizqi', 'D', 'Saputra', 'saputra@gmail.com', '$2y$12$/XRF7Z4JsdwdEKesfSsaGeav233NEl79oQPAbj/75SvtLmWB4JjlC', NULL, 'admin', 1, NULL, '+62877', 'Puerto Rico Selatan', NULL, NULL, NULL, 0, '2025-12-22 18:08:06', '2025-12-22 18:08:06', '2025-12-23 18:14:14'),
(29, 'Test', '', '1', 'test1@gmail.com', '$2y$12$535qjw1PV5nLQTczu90UKuIndMYjFnTyog.xqMY85iX6gA98pm08a', NULL, 'customer', 1, 'change_password_to_activate_account', NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-12-22 18:24:56', '2025-12-22 18:24:56'),
(30, 'Alfinna', NULL, 'swandayani', 'alfinnaswandayani01@gmail.com', '$2y$12$0RxrtwcX6ZJYSZ8/2.X7bO307i0hp5Kp7a3s0zLqEuwvMu.6liGxi', '106699143939951917075', 'customer', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-12-23 12:05:20', '2025-12-23 12:05:20'),
(32, 'Rian', NULL, 'IDS', 'izmabmc@gmail.com', '$2y$12$/VnSUrqDpwaXFKPuCqOrRuKBuoHfFxXkmfQAtbp0XQqAO5lqPhJPi', '107904663444811748079', 'customer', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-12-23 13:35:53', '2025-12-23 13:35:53'),
(33, 'Messi', NULL, 'Lionel', 'messi@gmail.com', '$2y$12$CL7UFrICkhfxNvqYSadkYumW/lVBCw3P2lWmxzvKsj9SPDta1ogIq', NULL, 'customer', 1, NULL, '1234567', 'Perumahan Puri Hijau, Jl. Pumas no. 100, Rumah no 800, Purwokerto selatan', NULL, NULL, NULL, 0, NULL, '2025-12-24 03:45:58', '2025-12-31 02:10:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `live_chat_scripts`
--
ALTER TABLE `live_chat_scripts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_category_id_foreign` (`category_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`),
  ADD KEY `orders_created_by_user_id_foreign` (`created_by_user_id`),
  ADD KEY `orders_updated_by_user_id_foreign` (`updated_by_user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`);

--
-- Indexes for table `order_settings`
--
ALTER TABLE `order_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `privacy_policies`
--
ALTER TABLE `privacy_policies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_addresses`
--
ALTER TABLE `restaurant_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_phone_numbers`
--
ALTER TABLE `restaurant_phone_numbers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_working_hours`
--
ALTER TABLE `restaurant_working_hours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_media_handles`
--
ALTER TABLE `social_media_handles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_bookings`
--
ALTER TABLE `table_bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms_and_conditions`
--
ALTER TABLE `terms_and_conditions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonies`
--
ALTER TABLE `testimonies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `live_chat_scripts`
--
ALTER TABLE `live_chat_scripts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `order_settings`
--
ALTER TABLE `order_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `privacy_policies`
--
ALTER TABLE `privacy_policies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restaurant_addresses`
--
ALTER TABLE `restaurant_addresses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `restaurant_phone_numbers`
--
ALTER TABLE `restaurant_phone_numbers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `restaurant_working_hours`
--
ALTER TABLE `restaurant_working_hours`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `social_media_handles`
--
ALTER TABLE `social_media_handles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `table_bookings`
--
ALTER TABLE `table_bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `terms_and_conditions`
--
ALTER TABLE `terms_and_conditions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `testimonies`
--
ALTER TABLE `testimonies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_created_by_user_id_foreign` FOREIGN KEY (`created_by_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_updated_by_user_id_foreign` FOREIGN KEY (`updated_by_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
