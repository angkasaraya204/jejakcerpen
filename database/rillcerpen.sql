-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 24, 2025 at 02:31 PM
-- Server version: 10.6.23-MariaDB
-- PHP Version: 8.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cobaproj_cerpen`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_manormrt05@example.com|114.10.42.15', 'i:1;', 1753121901),
('laravel_cache_manormrt05@example.com|114.10.42.15:timer', 'i:1753121901;', 1753121901);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Romantis', 'romantis', '2025-07-21 17:21:32', '2025-07-21 17:21:32'),
(2, 'Horor', 'horor', '2025-07-21 17:21:32', '2025-07-21 17:21:32'),
(3, 'Komedi', 'komedi', '2025-07-21 17:21:32', '2025-07-21 17:21:32'),
(4, 'Drama', 'drama', '2025-07-21 17:21:32', '2025-07-21 17:21:32'),
(5, 'Fantasi', 'fantasi', '2025-07-21 17:21:32', '2025-07-21 17:21:32'),
(6, 'Inspiratif', 'inspiratif', '2025-07-21 17:21:32', '2025-07-21 17:21:32');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `story_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `anonymous` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `content`, `user_id`, `story_id`, `parent_id`, `anonymous`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'nice', 4, 1, NULL, 0, '2025-07-21 18:25:23', '2025-07-21 18:25:23', NULL),
(2, 'ok lah', 6, 2, NULL, 0, '2025-07-21 18:26:03', '2025-07-21 18:26:03', NULL),
(3, 'gini banyak upvote?', 5, 6, NULL, 0, '2025-07-21 18:26:40', '2025-07-21 18:26:40', NULL),
(4, 'p p p p p p p p p p', 5, 4, NULL, 0, '2025-07-21 18:26:59', '2025-07-21 18:26:59', NULL),
(7, 'tess', 3, 8, NULL, 0, '2025-08-12 00:21:55', '2025-08-12 00:21:55', NULL);

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_04_24_040911_create_permission_tables', 1),
(5, '2025_04_24_041043_create_categories_table', 1),
(6, '2025_04_24_041102_create_stories_table', 1),
(7, '2025_04_24_041144_create_comments_table', 1),
(8, '2025_04_24_041206_create_votes_table', 1),
(9, '2025_04_29_165445_create_follows_table', 1),
(10, '2025_05_05_101619_create_reports_table', 1),
(11, '2025_07_15_222637_create_stories_views_table', 1);

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

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 5),
(2, 'App\\Models\\User', 6),
(2, 'App\\Models\\User', 7),
(2, 'App\\Models\\User', 8),
(2, 'App\\Models\\User', 9);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
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

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view stories', 'web', '2025-07-21 17:21:31', '2025-07-21 17:21:31'),
(2, 'create stories', 'web', '2025-07-21 17:21:31', '2025-07-21 17:21:31'),
(3, 'edit stories', 'web', '2025-07-21 17:21:31', '2025-07-21 17:21:31'),
(4, 'delete stories', 'web', '2025-07-21 17:21:31', '2025-07-21 17:21:31'),
(5, 'mark sensitive', 'web', '2025-07-21 17:21:31', '2025-07-21 17:21:31'),
(6, 'create comments', 'web', '2025-07-21 17:21:31', '2025-07-21 17:21:31'),
(7, 'edit comments', 'web', '2025-07-21 17:21:31', '2025-07-21 17:21:31'),
(8, 'delete comments', 'web', '2025-07-21 17:21:31', '2025-07-21 17:21:31'),
(9, 'view users', 'web', '2025-07-21 17:21:31', '2025-07-21 17:21:31'),
(10, 'edit users', 'web', '2025-07-21 17:21:31', '2025-07-21 17:21:31'),
(11, 'delete users', 'web', '2025-07-21 17:21:31', '2025-07-21 17:21:31'),
(12, 'access dashboard', 'web', '2025-07-21 17:21:31', '2025-07-21 17:21:31'),
(13, 'view statistics', 'web', '2025-07-21 17:21:31', '2025-07-21 17:21:31'),
(14, 'manage categories', 'web', '2025-07-21 17:21:31', '2025-07-21 17:21:31');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reportable_type` varchar(255) NOT NULL,
  `reportable_id` bigint(20) UNSIGNED NOT NULL,
  `reason` varchar(280) DEFAULT NULL,
  `status` enum('pending','valid','tidak-valid') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `user_id`, `reportable_type`, `reportable_id`, `reason`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 'App\\Models\\Comment', 1, 'Ujaran Kebencian', 'pending', '2025-07-21 18:27:33', '2025-07-21 18:27:33'),
(2, 3, 'App\\Models\\Comment', 3, 'Spam', 'pending', '2025-07-21 18:28:22', '2025-07-21 18:28:22'),
(3, 3, 'App\\Models\\Comment', 4, 'Spam', 'pending', '2025-07-21 18:28:44', '2025-07-21 18:28:44'),
(4, 3, 'App\\Models\\Story', 5, 'Spam', 'pending', '2025-07-21 18:29:17', '2025-07-21 18:29:17'),
(5, 8, 'App\\Models\\Story', 6, 'Kekerasan', 'tidak-valid', '2025-07-21 18:31:00', '2025-07-21 18:33:00'),
(6, 7, 'App\\Models\\Comment', 5, 'Pelecehan', 'valid', '2025-07-21 18:32:30', '2025-07-21 18:35:33'),
(7, 7, 'App\\Models\\Comment', 6, 'Informasi Palsu', 'valid', '2025-07-21 18:37:22', '2025-07-21 18:55:52'),
(8, 6, 'App\\Models\\Comment', 7, 'Spam', 'tidak-valid', '2025-08-12 00:24:49', '2025-08-12 00:25:23');

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

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-07-21 17:21:31', '2025-07-21 17:21:31'),
(2, 'penulis', 'web', '2025-07-21 17:21:31', '2025-07-21 17:21:31');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(2, 2),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
(6, 2),
(7, 1),
(7, 2),
(8, 1),
(8, 2),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(12, 2),
(13, 1),
(13, 2),
(14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('4TLBk10oL7CTtaZKwtGI2RoC5zih3MZWhpfrNuG4', NULL, '93.123.109.225', 'NokiaN70-1/5.0609.2.0.1 Series60/2.8 Profile/MIDP-2.0 Configuration/CLDC-1.1 UP.Link/6.3.1.13.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaTdac2p5TXhYS0x2SEdLQ3AxMWp1bTg1Z1dtalRpR2JLSzRBRmVhVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vY2VycGVuLmNvYmFwcm9qZWN0Lm15LmlkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1755985367),
('GuoVUEQmCIVFU2whBYgzDQoLJyt3PtEu8LOQdgwm', NULL, '93.123.109.225', 'Mozilla/5.0 (X11; Linux x86_64; en-US; rv:2.0b2pre) Gecko/20100712 Minefield/4.0b2pre', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNk1WbE00QktJVFhiWUtnUTZRYVRWdG5xVTdIelFQeU05eHI2WUZRaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vd3d3LmNlcnBlbi5jb2JhcHJvamVjdC5teS5pZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756010922),
('jmaVYiXuuXiOYRGHNj8a1T2TuBrmQkJsLM8H2cwd', NULL, '20.55.61.179', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZFNXQlFheGR0SGZKa1BuNEdsYXgzYzVHN1FzT2pZcERNS2piYm41MCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vY2VycGVuLmNvYmFwcm9qZWN0Lm15LmlkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756019818),
('mucAt0V2gbXl7iMIrYVS8HnLVamS45R1EsZulwDq', 1, '114.10.42.112', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoid1V4ZEl0eUxDRkpORGtQRnBCQjVFa3VOOTcxTkZ0bVV3MjBsNFBFcyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTg6Imh0dHBzOi8vY2VycGVuLmNvYmFwcm9qZWN0Lm15LmlkL3N0b3JpZXMvc2ltYmFoZGFucGVueXV0dWEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1756019829),
('SNnBSa1EHmpsErghpVLyrK1XLlnxT9cgpvT3pojj', NULL, '114.10.42.112', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR1V3RjZlaVlpZFBaajlmd2p6azNLM0FXemZMT0RXNTdxVGNxN1pocCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vY2VycGVuLmNvYmFwcm9qZWN0Lm15LmlkL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756019802),
('ZiCJHqkEL47T4JADWGxE41RdcTWtDLN3RHDNdfoY', NULL, '198.235.24.182', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZEk0S01BdTBmMWJxcUJsbk1mT1c2czZvMWlqU1czMjZLeXJsZ213biI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vd3d3LmNlcnBlbi5jb2JhcHJvamVjdC5teS5pZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1755990561);

-- --------------------------------------------------------

--
-- Table structure for table `stories`
--

CREATE TABLE `stories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(80) NOT NULL,
  `content` text NOT NULL,
  `slug` varchar(50) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `anonymous` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stories`
--

INSERT INTO `stories` (`id`, `title`, `content`, `slug`, `user_id`, `category_id`, `anonymous`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Meraih Mimpi (by Adinda Desty)', 'Padahal masih sangat pagi, dan udara terasa dingin, seakan tak ijinkan aku untuk membuka selimut yang menutupi tubuh kurus ini.\r\n\r\nDiluar sudah gaduh, terdengar suara ibu yang sedang sibuk di dapur, dan ayah yang sedang mengasah cangkul. Aku masih tidur dikamarku yg nyaman sebelum ibuku datang dan membangunkan ku dari mimpi-mimpi indah.\r\n\r\n “Na…ayo nak bangun…sebentar lagi kita berangkat ke kebun”\r\n\r\n“sana cuci muka dan sarapan dulu ya…”\r\n\r\n Hmm…sebenarnya aku sudah malas disuruh bantu ibu di ladang terus, diluar disana begitu panas dan berdebu. Jika saja aku bukan penyabar, tapi ini memang sudah bakti ku pada orang tua, jadi aku terpaksa harus melakukan ini. Terkadang terfikir olehku apakah ibu dan bapak punya perasaan, apa dia mengerti dengan apa yang kumau, kenapa dia tak pernah memahami apa yang kucita-citakan?\r\n\r\nHidup sebagai anak petani miskin memang sulit, penuh keterbatasan dan kesulitan, tapi semoga ini menjadi pembelajaran bagiku untuk terus belajar dan berusaha. Dan semua kisah sedih ini aku tulis dalam banyak lembaran kertas yang kususun hingga menjadi buku yang tak pernah tamat. Aku merobah kepahitan di dunia nyata, sebagai loncatan untuk berfantasi di negeri dongen, menjadi rangkaian novel yang panjang. Menulis dan masuk ke dunia yang aku tulis adalah sebuah ‘pelarian’ bagiku!\r\n\r\nSelalu ada kisah baru yang ditulis, dan sayangnya kebanyakan hanya ironi dan cerita kesedihan, ini menjadi puzzle yang hanya bisa ku selesaikan diatas kertas, karena kenyataan kadang terlalu keras untuk dihadapi.\r\n\r\nCita-cita ku ingin menjadi penulis, jadi perantara bagi suara-suara jeritan orang-orang disekitarku. Ingin ku beritahu kepada dunia kalau aku punya bakat dan impian yang suatu saat akan kubuktikan.\r\n\r\n“itu hanya angan-angan ku saja, tapi aku yakin bisa mewujudkan mimpi ini suatu saat nanti”\r\n\r\nKembali ke dunia nyata yang keras dan penuh tekanan, dari jam 6 pagi sampai sekitar pukul 2 aku bantu orang tua di ladang. Sorenya sampai menjelang tidur aku biasa menulis, dan itupun tidak pakai perangkat komputer atau gadget canggih, secara manual aku hanya pakai kertas dan pensil saja untuk menulis.\r\n\r\nDibawah bayang-bayang cahaya lentera yang kuning, aku biasa semalaman asyik bermain dengan imajinasiku. Merangkai setiap huruf hingga menjadi kata, setiap kata kususun menjadi ratusan kalimat, lalu banyak halaman dan akhirnya tak terhitung sudah berapa ratus lembar kertas yang kuhabiskan oleh tulisan tangan ku.\r\n\r\nDua tahun lalu saat aku masih sekolah, bakatku dikenal baik dan menonjol diantara teman-teman, aku sering mendapat perhatian lebih dari guru-guru, hingga aku dipertemukan dengan seorang penulis ternama. Aku dan guruku berbincang sejenak dan aku mendapat banyak motivasi untuk terus menulis.\r\n\r\nNamun, sebelum menginjak kelas 2 SMA. Aku harus putus sekolah karena bapak sudah tidak lagi mampu membiayai biaya sekolah ku setiap harinya. Niatku harua diurungkan untuk sekolah tinggi demi meraih cita-citaku.\r\n\r\nDan bapak terus meyakinkanku kalau sekolah bagi anak perempuan itu tidak penting, kalau akhirnya hanya jadi istri yang seharian terkurung dirumah mengurus rumah tangga saja.\r\n\r\nSekarang sudah dewasa, aku benar-benar sadar pentingnya pendidikan khususnya untuk memudahkan mencari kerja, dan selain itu ilmu yang lebih penting. Bagaimana aku bisa kalau tidak punya wawasan, bagaimana punya wawasan kalau tidak sekolah?\r\n\r\nAkhirnya aku menjadi otodidak dan banyak belajar sendiri, menulis pun tanpa pernah ada arahan guru atau pembimbing semua kubuat hanya mengandalkan naluri dan bakat ku saja.\r\n\r\nAda tiga buku trilogi yang kutulis selama hampir setahun dan aku berniat untuk mencetak dan menawarkan nya kepada penerbit.\r\n\r\nIni adalah perjalanan panjang untuk menyelesaikan buku yang ketiga, yang bercerita tentang petualangan, persahabatan, nilai-nilai heroik dan perjuangan. Aku belum menemukan judul yang tepat untuk buku ini, tapi aku yakin jika suatu hari nanti, ketenaranan buku ini akan memawa harum namaku juga.\r\n\r\nSetiap kata ditulis dengan kerja keras, karena dari dulu ibu dan bapak tidak pernah suka aku menghabiskan banyak waktu hanya untuk duduk dan menulis. Bapak lebih suka kalau aku main keluar dan berusaha cari calon suami yang bisa bantu-bantu keluarga. Ini konyol dan aku sama sekali belum berniat untu mencari pasangan hidup.\r\n\r\nDahulu ayahku pernah membakar sebagian kertas tulisan ku ke perapian. Dan aku tidak bisa berbuat apa-apa, apalagi melawan kecuali menangis…\r\n\r\nTapi itu masa lalu dan aku tidak boleh terjebak, sekarang sudah dewasa. Orang tua mulai sedikit mengerti dengan keinginanku. Mereka memberi ruang dan waktu juga persediaan alat tulis supaya aku terus berkarya sampai sukses.', 'meraih-mimpi', 8, 6, 0, 'approved', '2025-07-21 17:38:10', '2025-07-21 17:54:05', NULL),
(2, 'Kisah kami di bangku kereta', 'Arleta berlari secepat mungkin melalui stasiun Manggarai, dengan nafasnya yang tersengal-sengal. Jam sudah menunjukkan pukul 23:30 malam, dan satu-satunya kereta terakhir menuju Bekasi di peron 8 akan berangkat pada pukul 23:49. Arleta tahu betapa pentingnya untuk tidak melewatkan kereta ini, karena jika ia tertinggal, pilihan transportasinya untuk pulang ke rumah akan sangat terbatas, terutama pada malam hari seperti ini.\r\n\r\nSambil berlari, Arleta memikirkan kemungkinan-kemungkinan yang akan terjadi. Ia merasa khawatir akan kehilangan kereta tersebut dan harus mencari alternatif transportasi yang mungkin memakan waktu lebih lama. Di tengah-tengah kegelapan stasiun yang sepi, ia berusaha untuk mempercepat langkahnya.\r\n\r\nDengan detik-detik yang semakin berkurang, Arleta akhirnya tiba di peron 8 dengan napas yang tersengal-sengal. Jam di tangannya sudah menunjukkan pukul 23:47. Ia berharap bahwa kereta terakhir menuju Bekasi akan tiba tepat waktu.\r\n\r\nTak lama, terdengar suara rem kereta yang menggema di Stasiun Manggarai. Arleta yang telah mengejar waktu dengan wajah kelelahan, berbalik ke arah Bapak security yang berdiri tegak di samping rel kereta. Dalam kegelapan, cahaya lampu stasiun menyoroti wajahnya yang penuh keringat. Dengan nada tergesa-gesa, ia bertanya kepada petugas keamanan, “Ini kereta ke Bekasi ya, Pak?”\r\n\r\nPetugas keamanan yang tampak tenang meskipun sudah tengah malam, mengangguk dan menjawab, “Iya, Kak. Kereta ini menuju ke Bekasi, dan ini kereta terakhir untuk malam ini.”\r\n\r\nDengan lega mendengar jawaban tersebut, Arleta berkata, “Baiklah,” seraya meloncat pelan untuk memasuki gerbong kereta yang kosong.\r\n\r\nGerbong kereta di tengah malam terlihat sepi. Arleta memilih kursi yang terletak di tengah gerbong agar tidak terlalu terkena hembusan angin dingin dari luar. Udara malam yang menusuk itu membuatnya merapatkan jaket jeansnya, mencoba untuk merasa hangat dalam perjalanan yang sebentar lagi akan dimulai.\r\n\r\nTak lama setelah kereta mulai bergerak, Arleta melihat ke sekelilingnya yang sepi kemudian ia memutuskan untuk menikmati momen yang tenang ini dengan memejamkan mata sejenak. Rasa lelah akhirnya mulai terasa menghampirinya. Sepanjang hari, Arleta sudah sibuk bekerja sebagai part-timer di salah satu cafe di daerah Tebet. Rasanya seperti semua tenaga dan semangatnya sudah habis menghilang entah kemana.\r\n\r\nIa bekerja dari mulai pukul 15:00 sore dan berakhir pada pukul 23:00 malam, yang biasanya berlangsung dari hari Senin hingga Minggu. Setelah selesai bekerja, Arleta biasanya pulang ke kosannya yang berlokasi di sekitar Cawang. Namun, pada Minggu malam ini, jadwalnya berbeda, ia berniat untuk pulang ke rumahnya yang ada di Bekasi. Ia ingin bertemu dengan keluarganya dan makan masakan mama nya yang sudah ia rindukan dari beberapa minggu yang lalu. Selain itu, karena Senin adalah hari libur, ia memanfaatkan kesempatan ini untuk berkumpul dengan keluarga dan menikmati waktu bersama.\r\n\r\nMalam ini, seharusnya Arleta bisa pulang tepat waktu setelah menyelesaikan tugasnya di cafe. Namun, takdir berkata lain karena sempat ada salah hitung omset hari ini. Jadi mau tidak mau, Arleta harus tetap berada di cafe lebih lama dari biasanya, sehingga ia terpaksa harus kejar-kejaran dengan jam kereta terakhir yang menuju ke rumahnya.\r\n\r\nKereta berhenti di salah satu stasiun, entah stasiun apa. Dalam keheningan gerbong, Arleta membuka mata saat merasakan ada orang lain yang masuk. Seorang laki-laki dengan wajah dingin dan tanpa ekspresi berjalan lambat masuk dan duduk di kursi seberang dari tempat Arleta duduk. Di belakang laki-laki itu, ada seorang perempuan yang ia tebak berusia sekitar 16 tahun, karena wajahnya terlihat jauh lebih muda darinya. Perempuan itu memegang seorang bayi di tangannya. Ketika mata mereka bertemu, perempuan itu tersenyum ramah padanya, dan Arleta dengan hangat membalas senyumannya. Perempuan tersebut dan bayinya duduk di sebelah laki-laki berwajah dingin tersebut.\r\n\r\nLaki-laki itu tampak asyik dengan handphonenya, seolah-olah tidak menyadari keberadaan Arleta yang memperhatikan mereka. Kemudian Arleta memilih kembali mencoba untuk tidur, menyadari bahwa perjalanan ini masih jauh. Udara malam yang semakin menusuk membuat jaket jeansnya terasa kurang cukup untuk menahan dinginnya malam itu.\r\n\r\n“Oeee.. Oeee…” Suara tangisan bayi memenuhi gerbong yang tadinya sepi. Arleta memicingkan matanya dan memperhatikan orang-orang yang ada di seberangnya. Perempuan tersebut sibuk menepuk-nepuk lembut tangan bayi yang terletak di pangkuan pahanya, berusaha keras untuk menenangkan bayi itu yang masih terus menangis dengan keras. Sedangkan laki-laki yang duduk di sebelahnya hanya diam, tampak tidak ingin membantu menenangkan bayi itu. Wajahnya masih dingin dan tidak menunjukkan reaksi apapun terhadap tangisan bayi itu.', 'kisah-kami-di-bangku-kereta', 7, 1, 0, 'approved', '2025-07-21 17:46:59', '2025-07-21 17:54:05', NULL),
(3, 'Cuma Temen (by Raditya Dika)', 'Kalau ada yang bilang cewek sama cowok mustahil bisa sahabatan tanpa ada perasaan, bawa orangnya ke depanku. Karena aku tahu dengan pasti aku, Audi, adalah seorang perempuan. Aku juga tahu Bimo, sahabatku, adalah laki-laki. Bisa kok kami bersahabat, empat tahun, tanpa ada salah satu dari kami yang tergelincir ke jurang gelap bernama jatuh cinta.\r\n\r\nTidak sulit untuk aku dan Bimo jadi sepasang sahabat yang saling melengkapi, yang bisa membuat sepatu apa pun iri. Kami kiri dan kanan. Kami pagi dan malam. Kami adalah es kopi kekinian dan bola tapioka hitam yang ada di dasar gelasnya.\r\n\r\nKami bertemu di kampus, disatukan karena satu band bareng, di bawah nama band Suara Dari Hati atau disingkat Suri. Band kami band dengan gaya jazz, musik yang terjadi kalau Billie Holiday ngopi bareng Chet Baker, lalu sepakat untuk nge-jam bareng. Kami merasa keren, walapun kata Mamaku: ‘Musiknya bikin ngantuk.’\r\n\r\nAku penyanyinya di band itu bersama Bimo. Sempat laku dimana-mana, sampai akhirnya, ketika kami semua lulus kuliah, demo band yang gagal membuat band kami hilang arah. Label gak ada yang mau. Jualan sendiri gak ada yang beli. Panggung makin sedikit. Kami mulai jarang latihan karena masing-masing sibuk kerja. Band kami bubar. Pemimpin band kami bilang, ‘Udahlah. Musik gini gak bakal laku. Gue mau buat musik pop aja.’\r\n\r\n‘Eh, seni bukan masalah laku gak laku, tapi tentang mencintai apa yang kita lakukan,’ kata Bimo, gagah. Aku setuju.\r\n\r\n‘Tunggu sampai lo punya anak,’ kata salah satu anak band yang lain. ‘Gak ada yang lebih menggoyahkan idealisme dari uang sekolah anak yang harus dibayar.’\r\n\r\nBand kami bubar, tapi aku dan Bimo masih sesekali jadi backing vokal musisi-musisi top di Jakarta.\r\n\r\nDari kuliah, aku ada di setiap jatuh cinta yang Bimo alami, dia juga ada di setiap patah hati yang aku pikul. Bimo adalah orang yang pertama kali aku telepon ketika aku ingin curhat soal laki-laki yang minta nomer teleponku di depan resepsionis Celebrity Fitness. Aku adalah orang yang dia telepon ketika dia cerita soal gebetannya yang dia temani makan di kantin kampus siang-siang.\r\n\r\nBedanya, saat ini, Bimo tidak punya siapa-siapa.Aku punya David.\r\n\r\nPacarku selama 17 bulan ini, David, juga kenal baik dengan Bimo. Untungnya aku punya pacar yang pengertian, tidak seperti cowok lain yang melarang pacarnya tetap berteman dengan sahabat cowoknya. Padahal, si cewek lebih dulu kenal sahabatnya, dibanding si pacar tukang larang ini.\r\n\r\nDavid memang beda, dia dewasa. Mungkin ini karena aku juga pernah bilang ke David, ‘Percaya sama aku, Bimo cuma teman. Selamanya akan cuma teman.’ David bilang, ‘Aku gak curiga kok. Kalau pacaran masih ada kecurigaan, mungkin kita pacaran dengan orang yang salah.’\r\n\r\nDavid juga penuh kejutan. Empat bulan lalu dia melamar di Seggara, Jakarta Utara. Di pinggir pantai, kami duduk berdua di satu meja, lagu favoritku bermain tiba-tiba, dia mengeluarkan cincin sambil membawa satu buket anggrek merah jambu. Tidak banyak yang tahu aku suka bunga itu. David memang penuh kejutan.\r\n\r\n***\r\n\r\nHari ini terasa terlalu ramai untuk hari Sabtu. Di dalam mobil, Bimo menyetir dengan wajah lurus ke depan. Dia memakai baju The Simpsons, orang dewasa lain mungkin terlihat aneh memakai baju kartun seperti ini, tapi entah kenapa di Bimo terlihat cocok.\r\n\r\n‘Makasih udah mau nemenin gue,’ kataku. ‘Sorry ngerepotin.’\r\n\r\n‘Kapan sih lo gak ngerepotin gue?’ tanya Bimo, bercanda.\r\n\r\n‘Gue pulang naik grab kok, janji cuma nganterin doang, gue juga tahu lo ada urusan lain.’ Aku mengepalkan tangan, kesal. ‘Bener-bener ya tinggal tiga hari lagi nikah ada aja dramanya.’\r\n\r\nIni drama yang aku maksud: Catering makanan yang sudah aku sewa untuk resepsi hilang tanpa kabar. Untungnya, ada catering lain yang menyanggupi membuat makanan untuk 400 orang dengan deadline semepet ini. Jadi, hari ini kami buru-buru food testing, memastikan minimal makanannya bisa ditelan. Kekacauan seperti ini bikin kesal, tapi aku yakin setahun kemudian pasti jadi sesuatu yang seru untuk diceritakan.\r\n\r\nBimo aku ajak karena selain aku dan David sedang dipingit, David kebetulan juga lagi di luar kota. Bimo menoleh ke arahku, lalu bertanya, ‘Hari ini ada siapa aja?’\r\n\r\n‘Lo, gue, sama calon ibu mertua.’\r\n\r\n‘Oh baguslah ada si tante, seleranya bagus tuh,’ kata Bimo. Keluarga David cukup akrab dengan Bimo, karena Lebaran kemarin mereka sempat memesan rendang masakannya.\r\n\r\n‘Yang lainnya?’ tanya Bimo.\r\n\r\n‘Cukup sih perwakilan dua keluarga, lo kan perwakilan tamu tuh, sebagai pihak ketiga biar tahu rasanya enak apa enggak.’\r\n\r\nBimo mengangguk, lalu melanjutkan memerhatikan jalanan.\r\n\r\nAda yang beda dengan mobil Bimo hari ini. Mobilnya sunyi, tidak ada apa-apa yang terdengar. Padahal, biasanya tape dinyalakan. Aku menyalakan tape. Lagu bermain di radio. Bimo buru-buru mengecilkan volume, ‘Gue lagi pusing nih, suaranya kecil aja ya.’\r\n\r\nLalu dia, kembali memerhatikan jalan.', 'cuma-temen', 4, 4, 0, 'approved', '2025-07-21 17:49:02', '2025-07-21 17:54:05', NULL),
(4, 'Akhir Cerita yang Tak Diharapkan (by Bamby Cahyadi)', 'PAGI ini tak dapat dihindari lagi peperangan tengah menuju ke arah Jakarta. Di mana-mana terlihat kesibukan di kalangan militer untuk mempersiapkan diri mempertahankan Jakarta setelah Bogor, Depok, Tangerang, Bekasi, Bandung dan kota-kota di Jawa Barat serta Banten tumbang dikuasai pihak musuh.\r\n\r\nDaerah tempatku tinggal di apartemen Kalibata City seolah-olah memang disiapkan menjadi arena perang terbuka, di setiap menara apartemen dikelilingi senjata perang bermacam jenis. Mengingat kawasan apartemen kami bersebelahan dengan Taman Makam Pahlawan Kalibata yang merupakan obyek vital nasional yang perlu dilindungi negara.\r\n\r\nAku tinggal di apartemen ini setelah pindah dari Bandung, sepuluh tahun yang lalu. Dulu rumah perpustakaanku—aku menyebutkan demikian—di Bandung jauh lebih bagus, terdapat halaman yang cukup luas untuk berkebun. Pun isi rumah dilengkapi berbagai mebel perabot dan segala isinya yang kukumpulkan sejak pertama aku bekerja di sebuah restoran cepat saji. Sekarang kupastikan rumah beserta isinya itu telah musnah kena serangan bom dan rata dengan tanah. Membayangkan Kota Bandung kini telah dikuasai pihak musuh hatiku pedih.\r\n\r\nTerlebih lagi rumah di Bandung kurancang laiknya perpustakaan. Dinding rumah dipenuhi barisan buku dengan rak-rak yang tidak begitu tinggi sehingga tidak diperlukan tangga-tangga tinggi beroda yang diletakkan di samping rak-rak buku berselang-seling kayak perpustakaan di luar negeri. Di rumah yang kusebut perpustakaan itulah biasanya aku menyalurkan hobi terpendam, ialah menulis cerita fiksi.\r\n\r\nAku memutuskan membeli apartemen di Jakarta untuk tujuan investasi, setelahnya aku sewakan melalui sebuah biro properti. Hingga suatu ketika aku dipindah tugas ke kantor pusat di Jakarta, aku pun mulai menempati unit apartemen ini. Kini kondisi kawasan apartemen ini sangat penuh dengan pengungsi dari pinggiran Jakarta yang berhasil menyelamatkan diri. Tidak hanya kawasan Kalibata City yang penuh, kurasa semua tempat di Jakarta telah dipenuhi warga kota pinggiran yang berhasil selamat dan mengungsi ke kota ini.\r\n\r\nSejak zaman sebelum perang seperti sekarang ini, Kota Jakarta yang pernah menjadi ibu kota negara rupanya telah mempersiapkan diri dengan infrastruktur pertahanan militer yang mumpuni dan paripurna.\r\n\r\nKudengar kabar saat ini hanya ada 5 kota yang masih bertahan. Ibu Kota Nusantara (IKN) di Kalimantan Timur, diam-diam ketika membangunnya, pemerintah melengkapi dengan peralatan pertahanan perang seperti yang dimiliki zionis Israel. Banda Aceh di Nanggroe Aceh Darussalam pascabencana tsunami besar pada 26 Desember 2004, rupanya telah dibangun benteng besar yang tersembunyi di pesisir pantai sepanjang garis pantai Aceh. Ketika ada bahaya seperti perang saat ini, benteng itu secara otomatis keluar dari tanah dan membentang melindungi wilayah kota. Lalu Denpasar di Bali, jelas, Bali adalah daerah wisata yang menyumbangkan devisa terbesar bagi negara. Denpasar dilengkapi infrastruktur pangkalan militer yang lengkap. Kota lainnya ialah Jayapura di Papua, dalam usaha meredam gerakan separatis ternyata pemerintah melengkapi Jayapura dengan fasilitas militer yang modern. Kota selanjutnya tentu saja Jakarta, tetapi memang fasilitasnya tidak secanggih IKN.\r\n\r\nKondisi Jakarta khususnya di kawasan apartemen ini sesungguhnya amat menyedihkan setelah berminggu-minggu dikepung pasukan musuh, pasokan bahan bakar minyak, sembako gas, listrik, dan air bersih menjadi sangat terbatas. Kemarin aku antre untuk mendapatkan air layak minum dalam kemasan. Dan itu adalah kemasan galon terakhir yang tersisa. Ya, pemerintah melarang kami meminum air yang bersumber dari air tanah atau jaringan PDAM karena dikhawatirkan telah terkontaminasi senjata kimia pihak musuh.\r\n\r\nMalam hari Jakarta gelap gulita. Listrik sengaja dipadamkan agar sirene tanda bahaya serangan udara bisa dibunyikan dengan sisa energi listrik yang tersedia. Menara apartemen tempat tinggal kami sesungguhnya sudah tidak dipergunakan lagi. Di setiap menara mempunyai lahan parkir luas dan besar di rubanah, di tempat itulah kami menetap tidur berlindung dan menyimpan segala macam barang berharga yang tersisa. Area parkir rubanah benar-benar menjelma sebagai lubang perlindungan dari serangan udara musuh.\r\n\r\nDi setiap Menara, kami membentuk kelompok rubanah hampir semuanya perempuan dan anak-anak karena sebagian besar laki-laki dewasa bahkan remaja bertugas di garis depan di batas kota untuk bertempur. Laki-laki yang ada di kelompok kami adalah mereka yang sudah tua atau lelaki muda yang terluka dan cacat akibat perang atau ada juga lelaki muda pengecut yang tidak berani maju ke medan pertempuran. Di kelompok rubanah menara apartemenku, aku ditunjuk sebagai juru bicara karena aku menguasai beberapa bahasa asing\r\n\r\nDari hari ke hari, keadaan Jakarta semakin gawat. Meskipun memiliki infrastruktur pertahanan yang canggih, tetapi karena diisolasi oleh pasukan musuh berpekan-pekan, penghidupan warganya terasa sangat berat karena kebutuhan pokok makin sulit didapatkan. Peluru artileri pun makin kerap berdesingan di angkasa dan suara bom tidak henti-hentinya meledak di hampir semua penjuru langit kota lantas menerjang apa pun yang ditemuinya.\r\n\r\nHARI ini saat cahaya matahari melindap, terjadilah keheningan yang mencekam dan mengerikan. Menjelang tengah malam, komandan pasukan militer yang menjaga wilayah TMP Kalibata mengabarkan kepada kami, para perwakilan kelompok rubanah apartemen, bahwa musuh telah melewati garis pertahanan Kota Jakarta. Pasukan yang berjaga di kawasan TMP dan apartemen Kalibata telah diperintahkan mundur untuk berjaga di kawasan Bundaran Monas dan Istana Merdeka. Sebagian persenjataan laras panjang yang ada di setiap menara diserahkan kepada kami untuk dipakai sekadar mempertahankan diri apabila musuh masuk ke kawasan apartemen.\r\n\r\nKejadian dramatis akhirnya dimulai sore esok harinya. Ketika kami sedang mempersiapkan makan malam, terdengar langkah-langkah kaki yang berat datang mendekat. Satu peleton serdadu musuh rupanya berhasil merangsek ke wilayah apartemen dan satu regu pasukan tempur musuh bersenjata lengkap dengan tangkas menemukan kelompok rubanah kami. Kemunculan seregu serdadu membuat kami terkesiap menggigil ketakutan karena sadar bahwa sesuatu yang mengerikan bakal terjadi. Senjata laras panjang yang disandang beberapa perempuan dewasa di kelompok kami menjadi tak berguna.\r\n\r\n“Siapa yang bertanggung jawab di sini?” tanya seorang yang mungkin komandan regu pasukan.\r\n\r\nAku yang sudah telanjur sanggup menjadi juru bicara terpaksa berdiri dan maju selangkah dari anggota kelompok yang terduduk ketakutan. Tentara yang bertanya itu hanya menatapku. Ia tidak mengucap sepatah kata pun, tetapi ia maju tiga langkah ke arahku, mencoba mengamati wajahku lebih dekat karena memang hari sudah sore dan kondisi rubanah cukup temaram. Anggota pasukan yang lain bersiaga dengan senjata terkokang di tangan.\r\n\r\nTerus terang aku merasakan puncak ketakutan. Gejalanya sama seperti ketakutan menghadapi kematian. Sumsum tulang belakang di punggung terasa dialiri air es yang sangat dingin dari atas ke bawah berulang-ulang. Detak jantung terdengar berdentam-dentam tak keruan. Situasi mengerikan ini mendadak mencair ketika seorang anak kecil dari anggota kelompok kami berdiri dan menyodorkan setangkai permen lolipop yang tengah ia kulum-kulum kepada komandan serdadu yang sedang berhadapan denganku itu.\r\n\r\nTentara itu menyeringai, lantas tersenyum sambil menggelengkan kepala tanda bukan permen manis keras yang berbentuk bulat warna-warni dan memiliki tangkai atau tongkat itu yang ia inginkan. Melihat ia tersenyum dan tampak sedikit ramah, kugunakan kesempatan ini untuk bicara meski dengan suara bergetar.\r\n\r\n“Apakah ada sesuatu yang bisa saya bantu?” spontan kalimat itu yang melesat dari bibirku.\r\n\r\nSi Komandan itu tersenyum lagi mendengar suaraku, mungkin ia tersenyum karena bahasa yang kuucapkan terdengar tidak enak di telinganya. Pertanyaanku sama sekali tidak dijawab, ia menggelengkan kepala ketika kutawari rokok elektrik, minuman beralkohol atau alat pemuas seksual untuk laki-laki. Ia menaikkan alisnya. Sesaat kemudian, ia baru berucap, hanya satu patah kata, “Internet!”\r\n\r\nInternet yang ia maksud bukanlah jaringan komunikasi elektronik yang menghubungkan jaringan komputer dan fasilitas komputer yang terorganisasi di seluruh dunia melalui telefon atau satelit. Bukan! Bukan internet itu yang mereka butuhkan.\r\n\r\nAku dan semua anggota kelompok menggelengkan kepala. Ia memandang kami dengan tajam, menyeringai lagi, tampaknya ia cukup mengerti gelengan kepala kami dan tanpa tambahan kata-kata ia pun meminta pasukannya untuk mundur, pergi meninggalkan kami menuju pusat kota setelah sebelumnya mereka melucuti senjata kami.\r\n\r\nManusia adalah makhluk yang sangat dungu. Mereka mempunyai sesuatu yang mungkin sangat bernilai harganya, namun terkadang mereka abai menjaganya seperti internet yang di maksud. Ya, aku mau jujur perihal cerita ini. Sesungguhnya internet yang mereka butuhkan ialah penyebab negara-negara lain menyerang dan menggempur habis-habisan Indonesia: Indomie Telor Kornet!\r\n\r\nAnda berpikir aku bercanda saat mengarang cerita ini? Kenyataannya, hal sepele itu penyebab perang dunia ini. Kini aku berdiri di atas balkon lantai yang retak-retak dan hampir runtuh sambil tertawa-tawa memandang Menara-menara apartemen lain di depanku yang telah hancur lebur akibat perang tak berkesudahan. ***', 'akhir-cerita-yang-tak-diharapkan', 3, 4, 0, 'approved', '2025-07-21 17:50:26', '2025-07-21 17:54:05', NULL),
(5, 'Untaian Benang Waktu (by @mrizaldic)', 'Tak kira sudah berapa lama waktu menanti sebuah kehadiran baru, yang menghapus jejak generasi lama dan menciptakan generasi baru. Terdengar oleh seruan angin bahwa jejak baru telah lahir.\r\n\r\nMenunggu dan terus menunggu itulah orang tua. Didewasakan oleh waktu begitu pula dimanja oleh keinginan. Tak tersirat dalam pesan, namun tetap utama dalam pandangan seseorang. Merajut waktu hingga membentang samudra yang amat luas.\r\n\r\nBatu krikil yang dilempar menandakan waktu sudah mulai terajut, hingga buku mulai terbuka dalam bentuk lembaran baru yang dipegang oleh tangan si kecil. Dalam sungai waktu, terus berlalu Lalang tangan si kecil yang memegang tangan si dewasa dengan memeluk tanpa ragu dan mencium tanpa malu.\r\n\r\nSaat melintasi pasar terdengar suara si kecil yang meminta ini dan itu sebagai imbalan menemani. Toh hidup perlu dinikmati bukan dirasa hingga menuju Sang Kuasa. “Ibu, aku mau sepeda itu….aku mau mobil mobilan itu…. Ayah ayo jalan jalan ke sana….“ Tak kuasa menahan rasa bahagia, hanya sekedar mendengar, maka mereka kabulkan.\r\n\r\nKini si kecil yang hanya tau meminta sudah mulai memahami cinta. Benih dalam hati tertanam dan tumbuh walau hanya sebentar. Si kecil kini sudah beranjak remaja yang malu untuk mencium dan ragu untuk memeluk orang tuanya. Yang tadi hanya membaca secara terbata kini sudah lancar dalam membaca kehidupan orang lain.\r\n\r\nWaktu mulai terajut Kembali, berjalan diatas waktu tanpa sadar sudah berada dihujung masa remaja, yang hanya memahami cinta mulai mengerti makna dari kehidupan. Tangan si kecil sudah bisa menuntun si dewasa kemanapun mereka pergi. Rasa malu berubah menjadi rasa ragu karena takut kehilangan dia yang sudah sabar menghadapinya saat kecil.\r\n\r\nSi kecil sudah menjadi dewasa, memahami kehidupan dan mendapatkan cinta yang diinginkan. Perubahan sikapnya yang sudah tutur terhadap lingkungan. Yang tadi hanya bisa meminta kini sudah bisa memberi. Si kecil tetaplah kecil di mata si dewasa, toh apapun itu si kecil tetap anak mereka.\r\n\r\nSaat kehilangan waktu begitupun kehilangan si dewasa, kini si kecil sudah menyandang status dewasa. Menangis dengan keras hingga terdengar sampai hati setiap temannya. Memang kehilangan bukan suatu hal yang mudah, namun dengan kehilangan si dewasa kini sudah bisa paham arti mengikhlaskan. Sungai waktu mulai berjalan cepat, saat si dewasa kehilangan orang tuanya justru kini si dewasa diberikan si kecil sebagai generasi penerusnya.\r\n\r\nSi dewasa mulai memiliki si kecil yang selalu mengikutinya kemanapun dia pergi, tak terasa sudah berapa lama si dewasa memegang tangan keluarga. Yang dulu tangannya digenggam saat ini justru tangannya yang menggenggam. Yang dulu hanya bisa membutuhkan sekarang sudah menjadi yang paling dibutuhkan.\r\n\r\nTak terasa sungguh singkat waktu yang dilewati, tergantung masa dan zaman hal inilah yang membuat si kecil berubah ubah ntah menjadi dewasa atau justru hanya menjadi kawasan kanak-kanak. Tergantung pilihan, apakah ia memilih tidak atau justru iya? Apakah ia memilih untuk maju atau justru mundur. Inilah gambaran dari takdir setiap orang, untaian benang waktu selalu ada diawal kehidupan dan di penghujung masa.\r\n\r\nKeseluruhan cerita ini menggambarkan bagaimana waktu membentuk dan mengubah individu, dan bagaimana setiap fase kehidupan merupakan bagian dari untaian takdir yang tidak terelakkan, di mana setiap pilihan dan perubahan merupakan bagian alaminya.', 'untaian-benang-waktu', 5, 5, 0, 'approved', '2025-07-21 17:51:32', '2025-07-21 17:54:05', NULL),
(6, 'Sahabat Jadi Cinta', 'Perjanjian tersebut dikubur di bawah pohon dan akan dibuka saat kami semua menerima hasil ujian kelulusan. Waktu yang kita tunggu pun tiba.\r\n\r\nHari ini adalah hari kita berempat menerima hasil ujian. Bersyukurnya, kami dinyatakan lulus. Kami berempat pun serentak menuju pohon yang menjadi tempat untuk mengubur botol. Kamu semua menggali hingga menemukan botol tersebut.\r\n\r\nSaat botol sudah ditemukan, kami semua bergegas membaca tulisan yang dulu sempat kami tulis. Di dalam kertas tersebut berisikan tulisan \r\n\r\n\\\"Kami berjanji akan selalu bersama untuk selamanya\\\"\r\n\r\nKeesokan harinya, Fariz pun merayakan pesta kelulusan kami berempat. Pada malam itu Fariz menyatakan perasaannya kepadaku. Akhirnya aku dan Fariz berpacaran. Begitu juga dengan Irsyad berpacaran dengan Lala. Malam itu sangat istimewa, namun kami semua harus bergegas pulang.', 'sahabat-jadi-cinta', 3, 1, 0, 'approved', '2025-07-21 17:53:18', '2025-07-21 17:54:05', NULL),
(7, 'Kisah Roro Jonggrang', 'Dahulu kala, di Desa Prambanan, ada sebuah kerajaan yang dipimpin oleh Prabu Baka. la memiliki seorang putri yang sangat cantik bernama Roro Jonggrang.\r\n\r\nSuatu ketika, Prambanan dikalahkan oleh Kerajaan Pengging yang dipimpin oleh Bandung Bondowoso. Prabu Baka tewas di medan perang. Dia terbunuh oleh Bandung Bondowoso yang sangat sakti.\r\n\r\nBandung Bondowoso kemudian menempati Istana Prambanan. Melihat putri dari Prabu Baka yang cantik jelita yaitu Roro Jonggrang, timbul keinginannya untuk memperistri Roro Jonggrang.\r\n\r\nRoro Jonggrang tahu bahwa Bandung Bondowoso adalah orang yang membunuh ayahnya. Karena itu, ia mencari akal untuk menolaknya. Lalu, ia mengajukan syarat dibuatkan 1.000 buah candi dan dua buah sumur yang dalam. Semuanya harus selesai dalam semalam.\r\n\r\nBandung Bondowoso menyanggupi persyaratan Roro Jonggrang. Ia meminta pertolongan kepada ayahnya dan mengerahkan balatentara roh-roh halus untuk membantunya pada hari yang ditentukan. Pukul empat pagi, hanya tinggal lima buah candi yang belum selesai dan kedua sumur hampir selesai.\r\n\r\nMengetahui 1.000 candi telah hampir selesai, Roro Jonggrang ketakutan.\r\n\r\n“Apa yang harus kulakukan untuk menghentikannya?” pikirnya cemas membayangkan ia harus menerima pinangan Bandung Bondowoso yang telah membunuh orangtuanya.\r\n\r\nAkhirnya, ia pergi membangunkan gadis-gadis di Desa Prambanan dan memerintahkan untuk menghidupkan obor-obor dan membakar jerami, memukulkan alu pada lesung, dan menaburkan bunga-bunga yang harum. Suasana saat itu menjadi terang dan riuh. Semburat merah memancar di langit dengan seketika.\r\n\r\nAyam jantan pun berkokok bersahut-sahutan. Mendengar suara itu, para roh halus segera meninggalkan pekerjaan. Mereka menyangka hari telah pagi dan matahari akan segera terbit. Pada saat itu hanya tinggal satu sebuah candi yang belum dibuat.\r\n\r\nBandung Bondowoso sangat terkejut dan marah menyadari usahanya telah gagal. Dalam amarahnya, Bandung Bondowoso mengutuk Roro Jonggrang menjadi sebuah arca untuk melengkapi sebuah buah candi yang belum selesai.\r\n\r\nBatu arca Roro Jonggrang diletakkan di dalam ruang candi yang besar. Hingga kini, candi tersebut disebut dengan Candi Roro Jonggrang. Sementara itu, candi-candi di sekitarnya disebut dengan Candi Sewu (Candi Seribu) meskipun jumlahnya belum mencapai 1.000.', 'kisah-roro-jonggrang', 6, 5, 0, 'approved', '2025-07-21 18:10:32', '2025-08-08 18:00:54', '2025-08-08 18:00:54'),
(8, 'Simbah dan Penyu Tua', 'Si bocah mengendap-endap masuk untuk melanjutkan membaca sebuah buku dongeng klasik yang sudah diburunya sejak bulan lalu. Ia tak lupa melepas sepasang sandal jepitnya yang semakin tipis dimakan jalanan aspal, menepikannya di paving beranda toko yang tidak berubin. Dahulu ia melakukan itu hanya karena ingat pesan Mbah—kalau mau bertamu ke tempat orang harus lepas alas kaki, tapi lambat laun hal ini menjadi bagian dari misinya untuk meredam langkah kaki dari si empu uzhur yang pandangannya mulai lamur.\r\n\r\nTatapannya seketika menjurus pada tumpukan buku yang diingatnya sejak malam kemarin. Biasanya ia akan meletakkan buku itu dengan kesadaran penuh, tak ingin kehilangan akibat keberadaannya yang manunggal di seantero toko buku sepuh itu. Sebelum membaca ia akan menggosok kedua telapak tangannya agar tidak meninggalkan jejak debu di antara lembaran yang sudah membuatnya kepayang beberapa waktu belakangan ini. Ia juga pernah diingatkan Mbahnya berkali-kali: “Jangan mengotori barang yang bukan kepunyaanmu!”\r\n\r\nSegera saja si bocah memulai kembali ritusnya yang kedap itu, melumat deretan kalimat di antara relung pikir dan batinnya seorang. Hari ini ia mengawali dengan menyibak halaman buku bernomor enam puluh delapan, merapikan kembali lipatan lancip di bagian sudut yang hanya berani ia lakukan dalam ukuran yang sangat kecil, khawatir buku itu rusak, meninggalkan retakan di antara spasial narasi cerita yang kadung dicintainya. Meski napasnya masih tersengal akibat menahan suara langkah kaki yang menjengkal lebar-lebar, seketika bunyi kalimat pembuka fragmen kisah klasik itu membuatnya tenang, laiknya predator jinak ketika menatap sang pawang.\r\n\r\nPenyu itu memilih kembali berteduh di sebalik cangkangnya, meredam amarahnya yang kian membuncah akibat perdebatannya dengan kawanan penyu lainnya. Belakangan ini si penyu hendak dihakimi massa penyu lainnya agar cangkangnya saja yang dijadikan mahkota penghias rambut wanita. Ia penyu tertua yang memiliki cangkang paling rapuh, kawanan lainnya menghendaki cangkangnya dijadikan tumbal, agar pemburu mahkota cangkang penyu di pesisir itu kecewa dengan hasil ukir mahkota yang ringkih. Sebagai penyu yang dituakan, ia tengah di persimpangan, di antara kehendak hati untuk bertahan hidup demi keluarga kecilnya atau kewajibannya sebagai tetua yang sudah sebaiknya berkorban bagi kawanan lainnya.', 'simbahdanpenyutua', 6, 4, 1, 'approved', '2025-07-24 17:08:43', '2025-08-07 02:32:57', NULL),
(9, 'tess', '**tess**', 'tess-123', 1, 1, 0, 'approved', '2025-08-08 17:55:28', '2025-08-08 18:00:47', '2025-08-08 18:00:47');

-- --------------------------------------------------------

--
-- Table structure for table `stories_views`
--

CREATE TABLE `stories_views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `story_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stories_views`
--

INSERT INTO `stories_views` (`id`, `story_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 6, 2, '2025-07-21 18:19:35', '2025-07-21 18:19:35'),
(2, 5, 2, '2025-07-21 18:19:40', '2025-07-21 18:19:40'),
(3, 4, 2, '2025-07-21 18:19:46', '2025-07-21 18:19:46'),
(4, 6, 5, '2025-07-21 18:20:11', '2025-07-21 18:20:11'),
(5, 5, 5, '2025-07-21 18:20:34', '2025-07-21 18:20:34'),
(6, 1, 5, '2025-07-21 18:20:40', '2025-07-21 18:20:40'),
(7, 6, 4, '2025-07-21 18:21:19', '2025-07-21 18:21:19'),
(8, 5, 4, '2025-07-21 18:21:24', '2025-07-21 18:21:24'),
(9, 4, 4, '2025-07-21 18:21:28', '2025-07-21 18:21:28'),
(10, 1, 4, '2025-07-21 18:25:16', '2025-07-21 18:25:16'),
(11, 2, 6, '2025-07-21 18:25:56', '2025-07-21 18:25:56'),
(12, 4, 5, '2025-07-21 18:26:51', '2025-07-21 18:26:51'),
(13, 6, 3, '2025-07-21 18:28:16', '2025-07-21 18:28:16'),
(14, 5, 3, '2025-07-21 18:28:29', '2025-07-21 18:28:29'),
(15, 4, 3, '2025-07-21 18:28:36', '2025-07-21 18:28:36'),
(16, 3, 3, '2025-07-21 18:31:46', '2025-07-21 18:31:46'),
(17, 3, 7, '2025-07-21 18:32:22', '2025-07-21 18:32:22'),
(18, 5, 7, '2025-07-21 18:37:17', '2025-07-21 18:37:17'),
(19, 4, NULL, '2025-07-22 17:28:49', '2025-07-22 17:28:49'),
(20, 2, NULL, '2025-07-22 17:28:59', '2025-07-22 17:28:59'),
(21, 5, NULL, '2025-07-22 17:29:00', '2025-07-22 17:29:00'),
(22, 6, NULL, '2025-07-22 17:29:04', '2025-07-22 17:29:04'),
(23, 3, NULL, '2025-07-22 17:29:05', '2025-07-22 17:29:05'),
(24, 1, NULL, '2025-07-22 17:29:06', '2025-07-22 17:29:06'),
(25, 6, NULL, '2025-07-24 05:55:58', '2025-07-24 05:55:58'),
(26, 5, NULL, '2025-07-24 05:56:07', '2025-07-24 05:56:07'),
(27, 5, NULL, '2025-07-24 06:20:25', '2025-07-24 06:20:25'),
(28, 6, NULL, '2025-07-24 06:26:36', '2025-07-24 06:26:36'),
(29, 5, NULL, '2025-07-24 06:27:05', '2025-07-24 06:27:05'),
(30, 4, NULL, '2025-07-24 06:28:48', '2025-07-24 06:28:48'),
(31, 3, NULL, '2025-07-24 08:36:34', '2025-07-24 08:36:34'),
(32, 6, NULL, '2025-07-24 08:36:53', '2025-07-24 08:36:53'),
(33, 4, NULL, '2025-07-24 09:03:57', '2025-07-24 09:03:57'),
(34, 3, NULL, '2025-07-24 09:04:08', '2025-07-24 09:04:08'),
(35, 6, NULL, '2025-07-24 09:52:39', '2025-07-24 09:52:39'),
(36, 6, 1, '2025-07-24 15:51:47', '2025-07-24 15:51:47'),
(37, 8, NULL, '2025-07-25 03:28:20', '2025-07-25 03:28:20'),
(38, 7, 1, '2025-07-25 05:38:07', '2025-07-25 05:38:07'),
(39, 6, NULL, '2025-07-25 09:43:30', '2025-07-25 09:43:30'),
(40, 5, NULL, '2025-07-26 15:00:58', '2025-07-26 15:00:58'),
(41, 4, NULL, '2025-07-26 17:31:41', '2025-07-26 17:31:41'),
(42, 3, NULL, '2025-07-27 06:20:56', '2025-07-27 06:20:56'),
(43, 6, NULL, '2025-07-27 10:50:31', '2025-07-27 10:50:31'),
(44, 2, NULL, '2025-07-27 10:51:45', '2025-07-27 10:51:45'),
(45, 1, NULL, '2025-07-27 12:11:17', '2025-07-27 12:11:17'),
(46, 6, NULL, '2025-07-27 13:51:19', '2025-07-27 13:51:19'),
(47, 7, NULL, '2025-07-27 14:02:06', '2025-07-27 14:02:06'),
(48, 7, NULL, '2025-07-27 14:16:25', '2025-07-27 14:16:25'),
(49, 7, NULL, '2025-07-27 14:16:27', '2025-07-27 14:16:27'),
(50, 7, NULL, '2025-07-27 14:16:28', '2025-07-27 14:16:28'),
(51, 7, NULL, '2025-07-27 14:16:30', '2025-07-27 14:16:30'),
(52, 7, NULL, '2025-07-27 14:16:38', '2025-07-27 14:16:38'),
(53, 7, NULL, '2025-07-27 14:16:42', '2025-07-27 14:16:42'),
(54, 4, NULL, '2025-08-02 09:19:06', '2025-08-02 09:19:06'),
(55, 2, NULL, '2025-08-02 09:19:08', '2025-08-02 09:19:08'),
(56, 5, NULL, '2025-08-02 09:19:12', '2025-08-02 09:19:12'),
(57, 6, NULL, '2025-08-02 09:19:24', '2025-08-02 09:19:24'),
(58, 1, NULL, '2025-08-02 09:19:28', '2025-08-02 09:19:28'),
(59, 3, NULL, '2025-08-02 09:19:30', '2025-08-02 09:19:30'),
(60, 8, NULL, '2025-08-02 09:19:33', '2025-08-02 09:19:33'),
(61, 3, NULL, '2025-08-04 23:39:48', '2025-08-04 23:39:48'),
(62, 8, NULL, '2025-08-05 05:08:56', '2025-08-05 05:08:56'),
(63, 5, NULL, '2025-08-05 05:11:08', '2025-08-05 05:11:08'),
(64, 6, NULL, '2025-08-05 20:15:53', '2025-08-05 20:15:53'),
(65, 6, NULL, '2025-08-06 07:25:30', '2025-08-06 07:25:30'),
(66, 8, NULL, '2025-08-08 13:35:11', '2025-08-08 13:35:11'),
(67, 8, NULL, '2025-08-08 18:03:52', '2025-08-08 18:03:52'),
(68, 8, NULL, '2025-08-10 05:00:14', '2025-08-10 05:00:14'),
(69, 8, NULL, '2025-08-10 05:00:42', '2025-08-10 05:00:42'),
(70, 8, NULL, '2025-08-10 05:01:54', '2025-08-10 05:01:54'),
(71, 8, 3, '2025-08-11 03:01:30', '2025-08-11 03:01:30'),
(72, 8, NULL, '2025-08-11 05:29:28', '2025-08-11 05:29:28'),
(73, 8, 1, '2025-08-11 05:31:03', '2025-08-11 05:31:03'),
(74, 8, NULL, '2025-08-11 12:16:12', '2025-08-11 12:16:12'),
(75, 8, NULL, '2025-08-11 19:58:00', '2025-08-11 19:58:00'),
(76, 3, NULL, '2025-08-11 23:39:27', '2025-08-11 23:39:27'),
(77, 8, 6, '2025-08-12 00:24:45', '2025-08-12 00:24:45'),
(78, 8, NULL, '2025-08-17 19:01:05', '2025-08-17 19:01:05'),
(79, 6, NULL, '2025-08-17 19:01:06', '2025-08-17 19:01:06'),
(80, 5, NULL, '2025-08-17 19:01:06', '2025-08-17 19:01:06'),
(81, 4, NULL, '2025-08-17 19:01:07', '2025-08-17 19:01:07'),
(82, 3, NULL, '2025-08-17 19:01:07', '2025-08-17 19:01:07'),
(83, 2, NULL, '2025-08-17 19:01:08', '2025-08-17 19:01:08'),
(84, 1, NULL, '2025-08-17 19:01:08', '2025-08-17 19:01:08'),
(85, 8, NULL, '2025-08-21 12:48:01', '2025-08-21 12:48:01'),
(86, 1, NULL, '2025-08-21 14:02:16', '2025-08-21 14:02:16'),
(87, 5, NULL, '2025-08-21 14:04:24', '2025-08-21 14:04:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@example.com', NULL, '$2y$12$19KpZ0qdKOSp8nijUHBthuIyF9gO6uU7IPdMp98b43Fdf/Y7eD9CK', NULL, '2025-07-21 17:21:32', '2025-07-21 17:21:32'),
(2, 'User', 'user@example.com', NULL, '$2y$12$dkkZ/8ZuMBZXCw6MW9eNPeITqlgqLuIpEwKuHjK8ePp2JcFEhJgcu', NULL, '2025-07-21 17:21:32', '2025-07-21 17:21:32'),
(3, 'Angkasa Raya', 'angkasaraya@gmail.com', NULL, '$2y$12$Dn53A0dY46Mxqp7Atbn0Tei1ScOgXfbm/GvQfUyy.GvpsUiavEJNC', NULL, '2025-07-21 17:27:26', '2025-08-11 23:56:30'),
(4, 'Andri Hendrawan', 'andri123@gmail.com', NULL, '$2y$12$8JFZeyITLp7Ln48NNo376u4sAvpvruM9Hc9KhZGIffnIdMBzIq9ZK', NULL, '2025-07-21 17:27:42', '2025-07-21 17:27:42'),
(5, 'Iymadha Vakhar', 'karel123@gmail.com', NULL, '$2y$12$SkHKWrvwqtJfW4dTPDfXI.IdVvfz22SCNFSnBLj8ovAG94UMDC54S', NULL, '2025-07-21 17:28:12', '2025-07-21 17:28:12'),
(6, 'Kiwil', 'kiwil@example.com', NULL, '$2y$12$FoivbH0IFuf.yDb56ZDy7.EP.Wh6GhvkDApKPKB0bvPyp7ijjmQ6i', NULL, '2025-07-21 17:28:39', '2025-07-21 17:28:39'),
(7, 'JustAR', 'manormrt05@gmail.com', NULL, '$2y$12$Y1iYmxPzRI3BhUCHwFwYwOrIDmJse9HHu9IHT8MUYBOlRpEU0dlNq', NULL, '2025-07-21 17:29:33', '2025-07-21 17:29:33'),
(8, 'Raden Roro Fadillah Rahayu Sulistyaningrum', 'rorodilla02@gmail.com', NULL, '$2y$12$/k83IKWzSgyuPyZNwE2kqO0YqvWR3n6oInrDu.lEv/QQBWPdvHwgK', NULL, '2025-07-21 17:30:40', '2025-07-21 17:30:40'),
(9, 'Andhika Rizki', 'andhikarizki101@gmail.com', NULL, '$2y$12$pTT/gU6V8UiOLcUd4KzKlOuDOmECSCrdB37a3wGB4IlVgxS/wATdi', NULL, '2025-07-24 09:05:33', '2025-07-24 09:05:33');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `story_id` bigint(20) UNSIGNED NOT NULL,
  `vote_type` enum('upvote','downvote') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `user_id`, `story_id`, `vote_type`, `created_at`, `updated_at`) VALUES
(1, 6, 6, 'upvote', '2025-07-21 18:14:58', '2025-07-21 18:14:58'),
(2, 6, 5, 'downvote', '2025-07-21 18:15:00', '2025-07-21 18:15:00'),
(3, 6, 4, 'upvote', '2025-07-21 18:15:04', '2025-07-21 18:15:04'),
(4, 6, 3, 'downvote', '2025-07-21 18:15:10', '2025-07-21 18:15:10'),
(5, 6, 2, 'upvote', '2025-07-21 18:15:17', '2025-07-21 18:15:17'),
(6, 6, 1, 'downvote', '2025-07-21 18:15:28', '2025-07-21 18:15:28'),
(7, 3, 6, 'downvote', '2025-07-21 18:15:43', '2025-07-21 18:15:43'),
(8, 3, 5, 'upvote', '2025-07-21 18:15:46', '2025-07-21 18:15:46'),
(9, 3, 4, 'downvote', '2025-07-21 18:15:49', '2025-07-21 18:15:49'),
(10, 3, 3, 'upvote', '2025-07-21 18:15:52', '2025-08-11 20:11:10'),
(11, 3, 2, 'downvote', '2025-07-21 18:15:55', '2025-07-21 18:15:55'),
(12, 3, 1, 'upvote', '2025-07-21 18:16:00', '2025-07-21 18:16:00'),
(13, 5, 6, 'upvote', '2025-07-21 18:16:18', '2025-07-21 18:16:18'),
(14, 5, 5, 'downvote', '2025-07-21 18:16:20', '2025-07-21 18:16:20'),
(15, 5, 4, 'upvote', '2025-07-21 18:16:24', '2025-07-21 18:16:24'),
(16, 5, 3, 'downvote', '2025-07-21 18:16:28', '2025-07-21 18:16:28'),
(17, 5, 2, 'upvote', '2025-07-21 18:16:31', '2025-07-21 18:16:31'),
(18, 5, 1, 'downvote', '2025-07-21 18:16:35', '2025-07-21 18:16:35'),
(19, 4, 6, 'downvote', '2025-07-21 18:16:53', '2025-07-21 18:16:53'),
(20, 4, 5, 'upvote', '2025-07-21 18:16:55', '2025-07-21 18:16:55'),
(21, 4, 4, 'downvote', '2025-07-21 18:16:58', '2025-07-21 18:16:58'),
(22, 4, 3, 'upvote', '2025-07-21 18:17:01', '2025-07-21 18:17:01'),
(23, 4, 2, 'downvote', '2025-07-21 18:17:06', '2025-07-21 18:17:06'),
(24, 4, 1, 'upvote', '2025-07-21 18:17:11', '2025-07-21 18:17:11'),
(25, 7, 6, 'upvote', '2025-07-21 18:17:34', '2025-07-21 18:17:34'),
(26, 7, 5, 'downvote', '2025-07-21 18:17:37', '2025-07-21 18:17:37'),
(27, 7, 4, 'upvote', '2025-07-21 18:17:40', '2025-07-21 18:17:40'),
(28, 7, 3, 'downvote', '2025-07-21 18:17:42', '2025-07-21 18:17:42'),
(29, 7, 2, 'upvote', '2025-07-21 18:17:45', '2025-07-21 18:17:45'),
(30, 7, 1, 'downvote', '2025-07-21 18:17:48', '2025-07-21 18:17:48'),
(31, 8, 6, 'downvote', '2025-07-21 18:18:18', '2025-07-21 18:18:18'),
(32, 8, 5, 'upvote', '2025-07-21 18:18:21', '2025-07-21 18:18:21'),
(33, 8, 4, 'downvote', '2025-07-21 18:18:25', '2025-07-21 18:18:25'),
(34, 8, 3, 'upvote', '2025-07-21 18:18:29', '2025-07-21 18:18:29'),
(35, 8, 2, 'downvote', '2025-07-21 18:18:32', '2025-07-21 18:18:32'),
(36, 8, 1, 'upvote', '2025-07-21 18:18:35', '2025-07-21 18:18:35'),
(37, 2, 6, 'downvote', '2025-07-21 18:18:56', '2025-07-21 18:18:56'),
(38, 2, 5, 'downvote', '2025-07-21 18:18:58', '2025-07-21 18:18:58'),
(39, 2, 4, 'upvote', '2025-07-21 18:19:01', '2025-07-21 18:19:01'),
(40, 2, 3, 'upvote', '2025-07-21 18:19:05', '2025-07-21 18:19:05'),
(41, 2, 1, 'downvote', '2025-07-21 18:19:11', '2025-07-21 18:19:11'),
(42, 2, 2, 'downvote', '2025-07-21 18:19:28', '2025-07-21 18:19:28');

--
-- Indexes for dumped tables
--

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_story_id_foreign` (`story_id`),
  ADD KEY `comments_parent_id_foreign` (`parent_id`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reports_user_id_foreign` (`user_id`),
  ADD KEY `reports_reportable_type_reportable_id_index` (`reportable_type`,`reportable_id`);

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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stories`
--
ALTER TABLE `stories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stories_slug_unique` (`slug`),
  ADD KEY `stories_user_id_foreign` (`user_id`),
  ADD KEY `stories_category_id_foreign` (`category_id`);

--
-- Indexes for table `stories_views`
--
ALTER TABLE `stories_views`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stories_views_story_id_user_id_unique` (`story_id`,`user_id`),
  ADD KEY `stories_views_story_id_user_id_index` (`story_id`,`user_id`),
  ADD KEY `stories_views_user_id_created_at_index` (`user_id`,`created_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `votes_user_id_story_id_unique` (`user_id`,`story_id`),
  ADD KEY `votes_story_id_foreign` (`story_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stories`
--
ALTER TABLE `stories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `stories_views`
--
ALTER TABLE `stories_views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_story_id_foreign` FOREIGN KEY (`story_id`) REFERENCES `stories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stories`
--
ALTER TABLE `stories`
  ADD CONSTRAINT `stories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stories_views`
--
ALTER TABLE `stories_views`
  ADD CONSTRAINT `stories_views_story_id_foreign` FOREIGN KEY (`story_id`) REFERENCES `stories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stories_views_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_story_id_foreign` FOREIGN KEY (`story_id`) REFERENCES `stories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `votes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
