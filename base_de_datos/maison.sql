-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.4.3 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para maison
CREATE DATABASE IF NOT EXISTS `maison` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `maison`;

-- Volcando estructura para tabla maison.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla maison.cache: ~6 rows (aproximadamente)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('maison-dune-cache-356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1775750056),
	('maison-dune-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1775750056;', 1775750056),
	('maison-dune-cache-5c785c036466adea360111aa28563bfd556b5fba', 'i:1;', 1775749488),
	('maison-dune-cache-5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1775749488;', 1775749488),
	('maison-dune-cache-da4b9237bacccdf19c0760cab7aec4a8359010b0', 'i:1;', 1775636541),
	('maison-dune-cache-da4b9237bacccdf19c0760cab7aec4a8359010b0:timer', 'i:1775636541;', 1775636541);

-- Volcando estructura para tabla maison.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla maison.cache_locks: ~0 rows (aproximadamente)

-- Volcando estructura para tabla maison.contacts
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contacts_email_index` (`email`),
  KEY `contacts_created_at_index` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla maison.contacts: ~0 rows (aproximadamente)
INSERT INTO `contacts` (`id`, `name`, `email`, `subject`, `message`, `created_at`, `updated_at`) VALUES
	(1, 'Alejandro', 'proyectomaison20@gmail.com', 'info', 'Hola', '2026-04-08 06:12:01', '2026-04-08 06:12:01'),
	(2, 'Alex', 'asuadur14@gmail.com', 'feedback', 'Hola', '2026-04-08 08:36:39', '2026-04-08 08:36:39');

-- Volcando estructura para tabla maison.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla maison.migrations: ~0 rows (aproximadamente)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '2026_03_08_135243_create_personal_access_tokens_table', 1),
	(3, '2026_03_12_170221_create_contact_table', 1),
	(4, '2026_03_14_184100_create_reservations_table', 1),
	(5, '2026_03_16_154301_create_password_reset_tokens_table', 1),
	(6, '2026_04_03_100000_create_tables_table', 1),
	(7, '2026_04_03_200000_create_sessions_table', 1),
	(8, '2026_04_03_300000_create_cache_table', 1);

-- Volcando estructura para tabla maison.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla maison.password_reset_tokens: ~0 rows (aproximadamente)

-- Volcando estructura para tabla maison.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_id_tokenable_type_index` (`tokenable_id`,`tokenable_type`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla maison.personal_access_tokens: ~17 rows (aproximadamente)
INSERT INTO `personal_access_tokens` (`id`, `tokenable_id`, `tokenable_type`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
	(1, '1', 'App\\Models\\User', 'auth_token', '682a304a6f7d3b53576e643837ef10aa2bb07200a3ccebbd297fecf3ecc3194b', '["*"]', NULL, NULL, '2026-04-07 14:56:54', '2026-04-07 14:56:54'),
	(2, '1', 'App\\Models\\User', 'auth_token', '1cbb74d9c8090c8f69cba57df1989f4724ea6a01772760a3fe80f71d56a6baf7', '["*"]', NULL, NULL, '2026-04-07 15:00:55', '2026-04-07 15:00:55'),
	(3, '1', 'App\\Models\\User', 'auth_token', '209685a96215aafad4c44fa75910186f65c660b1115ac7201b249825947f28f7', '["*"]', NULL, NULL, '2026-04-07 15:01:11', '2026-04-07 15:01:11'),
	(4, '1', 'App\\Models\\User', 'auth_token', 'abc7f5909f1bc9ca10b1ae158f6ea4047a4f27523a5fec388a65119f78e7c243', '["*"]', NULL, NULL, '2026-04-08 05:13:52', '2026-04-08 05:13:52'),
	(5, '1', 'App\\Models\\User', 'auth_token', 'c7acfd1dc62d8c093d414554797bb8135d668ed39a6c6fd9a1c8f9291a2c4194', '["*"]', '2026-04-08 05:14:09', NULL, '2026-04-08 05:14:09', '2026-04-08 05:14:09'),
	(6, '1', 'App\\Models\\User', 'auth_token', '31727d14417c9d9fd4b011456365701968d50a112854d0a232b8b55bf5e5ed47', '["*"]', '2026-04-08 05:14:31', NULL, '2026-04-08 05:14:30', '2026-04-08 05:14:31'),
	(7, '1', 'App\\Models\\User', 'auth_token', '0ec3013c33367494a43983323dc6f5ec7caf5d45380285e19e18838ca8ece54f', '["*"]', NULL, NULL, '2026-04-08 05:24:09', '2026-04-08 05:24:09'),
	(8, '1', 'App\\Models\\User', 'auth_token', 'c35eec7cd488c82cbbf2b45140919d97a677ec45f71aa8b63a385601450a3480', '["*"]', NULL, NULL, '2026-04-08 06:10:09', '2026-04-08 06:10:09'),
	(9, '1', 'App\\Models\\User', 'auth_token', 'e9d1aed80445c81a715feba7fa765c771dbfa8e89edb9027cf40280d6362cd0b', '["*"]', '2026-04-08 06:12:16', NULL, '2026-04-08 06:12:15', '2026-04-08 06:12:16'),
	(10, '1', 'App\\Models\\User', 'auth_token', 'ca13059aff7328e7c821c63ce591a1657bfada3a83973cce8eba28a5ece985a8', '["*"]', '2026-04-08 06:12:27', NULL, '2026-04-08 06:12:26', '2026-04-08 06:12:27'),
	(11, '2', 'App\\Models\\User', 'auth_token', 'a0d9aee849fbd2bf9f32544294a678afae177e3e966e6a85b68b08ecb3a45222', '["*"]', NULL, NULL, '2026-04-08 06:15:12', '2026-04-08 06:15:12'),
	(12, '2', 'App\\Models\\User', 'auth_token', 'c9a522da0b1118d7bf185f1a0cb966bc251ab33a8775c3c1c1a8d1ed391c3d0c', '["*"]', NULL, NULL, '2026-04-08 06:15:32', '2026-04-08 06:15:32'),
	(13, '2', 'App\\Models\\User', 'auth_token', '36894a56f51019021a2a20e2adf6932955733002419ffff79602df7061bceaad', '["*"]', NULL, NULL, '2026-04-08 06:21:22', '2026-04-08 06:21:22'),
	(14, '1', 'App\\Models\\User', 'auth_token', '2f95d103e4396bae5a2386ef6cb209fc01825a8cdeb02cb7c54038e1c562a5fa', '["*"]', NULL, NULL, '2026-04-09 08:04:54', '2026-04-09 08:04:54'),
	(15, '1', 'App\\Models\\User', 'auth_token', '5001216597394f509de5da24296c8c0054bbdedbc52981e255c782bfbf989751', '["*"]', NULL, NULL, '2026-04-09 13:43:49', '2026-04-09 13:43:49'),
	(16, '1', 'App\\Models\\User', 'auth_token', '1dbaea784f75a76ab29d3f2811032c6be1b7749f36a7f81070e821103d4cc41a', '["*"]', NULL, NULL, '2026-04-09 13:44:21', '2026-04-09 13:44:21'),
	(17, '2', 'App\\Models\\User', 'auth_token', '3b73f3f8bbabe3011d0273af483e00fdefac2b0a6f5b41830a76ae211885c6ea', '["*"]', NULL, NULL, '2026-04-09 13:53:17', '2026-04-09 13:53:17');

-- Volcando estructura para tabla maison.reservations
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `guests` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `table_number` int DEFAULT NULL,
  `room_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reservations_user_id_foreign` (`user_id`),
  CONSTRAINT `reservations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla maison.reservations: ~2 rows (aproximadamente)
INSERT INTO `reservations` (`id`, `user_id`, `first_name`, `last_name`, `email`, `phone`, `date`, `time`, `guests`, `section`, `table_number`, `room_number`, `notes`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Alex', 'Suarez', 'proyectomaison20@gmail.com', '6447237823', '2026-04-08', '11:02:00', '3', 'interior', 5, NULL, NULL, '2026-04-07 15:02:26', '2026-04-07 15:02:26'),
	(2, 1, 'Alejandro', 'SUarez', 'proyectomaison20@gmail.com', '836283623', '2026-04-16', '14:09:00', '4', 'interior', 5, NULL, NULL, '2026-04-08 06:10:45', '2026-04-08 06:10:45');

-- Volcando estructura para tabla maison.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla maison.sessions: ~4 rows (aproximadamente)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('gwBCIkkxe1EGttfBZKYe8MN148OezhS75IliZCyQ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiZm5IY21pOXkxWVVSTk5nNXY0eDJTa1B0ckNjZU9xdmxFbGhuNmw5SyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1775644569),
	('qyaCrRHBpvqbT5QxuwAJ9DFKlL4XnwKcH12qTVA7', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVFZNU3RweDhuZEVzbUlqTGJKelg0M3luVG1BdlRjRjNpdnZTdGd3YiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NzE6Imh0dHA6Ly9tYWlzb24udGVzdC9tYWlzb25fZHVuZV9hcGkvcHVibGljL2luZGV4LnBocC9zYW5jdHVtL2NzcmYtY29va2llIjtzOjU6InJvdXRlIjtzOjE5OiJzYW5jdHVtLmNzcmYtY29va2llIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiOGQzNmRiMGJhNWI1NDA5YWViYjAwNmJiN2JmYmY2MzdlZTczZmFhMmJkZjAwYzU1OWRhOGJmMTY1ZWNhMWQ1OCI7fQ==', 1775636482),
	('UL3zIUm1Y1jihZSgYyPwAP31hLJVC7vSjeJJnsa5', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWVpHekNZQ2FwdXJvd1ZBdjRRd3RBVkE1YUF3aUZIN1FsTWdGbEdReiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NzE6Imh0dHA6Ly9tYWlzb24udGVzdC9tYWlzb25fZHVuZV9hcGkvcHVibGljL2luZGV4LnBocC9zYW5jdHVtL2NzcmYtY29va2llIjtzOjU6InJvdXRlIjtzOjE5OiJzYW5jdHVtLmNzcmYtY29va2llIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiOGQzNmRiMGJhNWI1NDA5YWViYjAwNmJiN2JmYmY2MzdlZTczZmFhMmJkZjAwYzU1OWRhOGJmMTY1ZWNhMWQ1OCI7fQ==', 1775750465),
	('wrWXDEbxmk5OhKPYngrjm1QSXVAEX1VzSFEyubNL', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidHVyNGxtV2tlc2VqM2pRcE1nN09LUWJuYkZoeDdZWUJkSGx6N0xYZCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NzE6Imh0dHA6Ly9tYWlzb24udGVzdC9tYWlzb25fZHVuZV9hcGkvcHVibGljL2luZGV4LnBocC9zYW5jdHVtL2NzcmYtY29va2llIjtzOjU6InJvdXRlIjtzOjE5OiJzYW5jdHVtLmNzcmYtY29va2llIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1775729935);

-- Volcando estructura para tabla maison.tables
CREATE TABLE IF NOT EXISTS `tables` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `table_number` int NOT NULL,
  `section` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tables_table_number_unique` (`table_number`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla maison.tables: ~18 rows (aproximadamente)
INSERT INTO `tables` (`id`, `table_number`, `section`, `capacity`, `created_at`, `updated_at`) VALUES
	(1, 1, 'interior', 2, NULL, NULL),
	(2, 2, 'interior', 2, NULL, NULL),
	(3, 3, 'interior', 4, NULL, NULL),
	(4, 4, 'interior', 4, NULL, NULL),
	(5, 5, 'interior', 4, NULL, NULL),
	(6, 6, 'interior', 6, NULL, NULL),
	(7, 7, 'interior', 6, NULL, NULL),
	(8, 8, 'interior', 2, NULL, NULL),
	(9, 9, 'interior', 4, NULL, NULL),
	(10, 10, 'interior', 6, NULL, NULL),
	(11, 11, 'terrace', 2, NULL, NULL),
	(12, 12, 'terrace', 2, NULL, NULL),
	(13, 13, 'terrace', 4, NULL, NULL),
	(14, 14, 'terrace', 4, NULL, NULL),
	(15, 15, 'terrace', 6, NULL, NULL),
	(16, 16, 'terrace', 6, NULL, NULL),
	(17, 17, 'terrace', 2, NULL, NULL),
	(18, 18, 'terrace', 4, NULL, NULL);

-- Volcando estructura para tabla maison.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla maison.users: ~2 rows (aproximadamente)
INSERT INTO `users` (`id`, `name`, `email`, `password`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'AdminMaison', 'proyectomaison20@gmail.com', '$2y$12$rJxDmrnt.85thUr7XWz9ruNmG9xVEi6RtpgmyWcCfsuvc06R2hZbu', '2026-04-07 15:00:55', NULL, '2026-04-04 10:20:01', '2026-04-07 15:00:55'),
	(2, 'Ana', 'asuadur14@gmail.com', '$2y$12$1fXJCMEXC6o8B3ipHr6p1elaN727/khdBYrr2cl0QrcmdyScCgCua', '2026-04-08 06:15:12', NULL, '2026-04-08 06:14:54', '2026-04-08 06:15:12');

-- Volcando estructura para tabla maison.wp_commentmeta
CREATE TABLE IF NOT EXISTS `wp_commentmeta` (
  `meta_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Volcando datos para la tabla maison.wp_commentmeta: ~0 rows (aproximadamente)

-- Volcando estructura para tabla maison.wp_comments
CREATE TABLE IF NOT EXISTS `wp_comments` (
  `comment_ID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint unsigned NOT NULL DEFAULT '0',
  `comment_author` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `comment_author_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `comment_karma` int NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'comment',
  `comment_parent` bigint unsigned NOT NULL DEFAULT '0',
  `user_id` bigint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_ID`),
  KEY `comment_post_ID` (`comment_post_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  KEY `comment_date_gmt` (`comment_date_gmt`),
  KEY `comment_parent` (`comment_parent`),
  KEY `comment_author_email` (`comment_author_email`(10))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Volcando datos para la tabla maison.wp_comments: ~0 rows (aproximadamente)
INSERT INTO `wp_comments` (`comment_ID`, `comment_post_ID`, `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_date`, `comment_date_gmt`, `comment_content`, `comment_karma`, `comment_approved`, `comment_agent`, `comment_type`, `comment_parent`, `user_id`) VALUES
	(1, 1, 'Un comentarista de WordPress', 'wapuu@wordpress.example', 'https://es.wordpress.org/', '', '2026-02-11 18:15:01', '2026-02-11 17:15:01', 'Hola, esto es un comentario.\nPara empezar a moderar, editar y borrar comentarios, por favor, visita en el escritorio la pantalla de comentarios.\nLos avatares de los comentaristas provienen de <a href="https://es.gravatar.com/">Gravatar</a>.', 0, '1', '', 'comment', 0, 0);

-- Volcando estructura para tabla maison.wp_contact_messages
CREATE TABLE IF NOT EXISTS `wp_contact_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `subject` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Volcando datos para la tabla maison.wp_contact_messages: ~0 rows (aproximadamente)

-- Volcando estructura para tabla maison.wp_links
CREATE TABLE IF NOT EXISTS `wp_links` (
  `link_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_target` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_visible` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'Y',
  `link_owner` bigint unsigned NOT NULL DEFAULT '1',
  `link_rating` int NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_notes` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `link_rss` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_visible`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Volcando datos para la tabla maison.wp_links: ~0 rows (aproximadamente)

-- Volcando estructura para tabla maison.wp_options
CREATE TABLE IF NOT EXISTS `wp_options` (
  `option_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `option_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `autoload` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`),
  KEY `autoload` (`autoload`)
) ENGINE=InnoDB AUTO_INCREMENT=1033 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Volcando datos para la tabla maison.wp_options: ~152 rows (aproximadamente)
INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
	(1, 'cron', 'a:11:{i:1775751031;a:1:{s:30:"wp_delete_temp_updater_backups";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:6:"weekly";s:4:"args";a:0:{}s:8:"interval";i:604800;}}}i:1775751302;a:1:{s:34:"wp_privacy_delete_old_export_files";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:6:"hourly";s:4:"args";a:0:{}s:8:"interval";i:3600;}}}i:1775754901;a:2:{s:30:"wp_site_health_scheduled_check";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:6:"weekly";s:4:"args";a:0:{}s:8:"interval";i:604800;}}s:32:"recovery_mode_clean_expired_keys";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1775754975;a:2:{s:19:"wp_scheduled_delete";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}s:25:"delete_expired_transients";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1775754976;a:1:{s:21:"wp_update_user_counts";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}}i:1775754983;a:1:{s:30:"wp_scheduled_auto_draft_delete";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1775758500;a:1:{s:16:"wp_version_check";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}}i:1775760300;a:1:{s:17:"wp_update_plugins";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}}i:1775762100;a:1:{s:16:"wp_update_themes";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}}i:1776100470;a:1:{s:27:"acf_update_site_health_data";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:6:"weekly";s:4:"args";a:0:{}s:8:"interval";i:604800;}}}s:7:"version";i:2;}', 'on'),
	(2, 'siteurl', 'http://maison.test', 'on'),
	(3, 'home', 'http://maison.test', 'on'),
	(4, 'blogname', 'Maison · Dune', 'on'),
	(5, 'blogdescription', '', 'on'),
	(6, 'users_can_register', '0', 'on'),
	(7, 'admin_email', 'asuadur14@gmail.com', 'on'),
	(8, 'start_of_week', '1', 'on'),
	(9, 'use_balanceTags', '0', 'on'),
	(10, 'use_smilies', '1', 'on'),
	(11, 'require_name_email', '1', 'on'),
	(12, 'comments_notify', '1', 'on'),
	(13, 'posts_per_rss', '10', 'on'),
	(14, 'rss_use_excerpt', '0', 'on'),
	(15, 'mailserver_url', 'mail.example.com', 'on'),
	(16, 'mailserver_login', 'login@example.com', 'on'),
	(17, 'mailserver_pass', '', 'on'),
	(18, 'mailserver_port', '110', 'on'),
	(19, 'default_category', '1', 'on'),
	(20, 'default_comment_status', 'open', 'on'),
	(21, 'default_ping_status', 'open', 'on'),
	(22, 'default_pingback_flag', '1', 'on'),
	(23, 'posts_per_page', '10', 'on'),
	(24, 'date_format', 'j \\d\\e F \\d\\e Y', 'on'),
	(25, 'time_format', 'H:i', 'on'),
	(26, 'links_updated_date_format', 'j \\d\\e F \\d\\e Y H:i', 'on'),
	(27, 'comment_moderation', '0', 'on'),
	(28, 'moderation_notify', '1', 'on'),
	(29, 'permalink_structure', '/%postname%/', 'on'),
	(30, 'rewrite_rules', 'a:95:{s:11:"^wp-json/?$";s:22:"index.php?rest_route=/";s:14:"^wp-json/(.*)?";s:33:"index.php?rest_route=/$matches[1]";s:21:"^index.php/wp-json/?$";s:22:"index.php?rest_route=/";s:24:"^index.php/wp-json/(.*)?";s:33:"index.php?rest_route=/$matches[1]";s:17:"^wp-sitemap\\.xml$";s:23:"index.php?sitemap=index";s:17:"^wp-sitemap\\.xsl$";s:36:"index.php?sitemap-stylesheet=sitemap";s:23:"^wp-sitemap-index\\.xsl$";s:34:"index.php?sitemap-stylesheet=index";s:48:"^wp-sitemap-([a-z]+?)-([a-z\\d_-]+?)-(\\d+?)\\.xml$";s:75:"index.php?sitemap=$matches[1]&sitemap-subtype=$matches[2]&paged=$matches[3]";s:34:"^wp-sitemap-([a-z]+?)-(\\d+?)\\.xml$";s:47:"index.php?sitemap=$matches[1]&paged=$matches[2]";s:47:"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$";s:52:"index.php?category_name=$matches[1]&feed=$matches[2]";s:42:"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$";s:52:"index.php?category_name=$matches[1]&feed=$matches[2]";s:23:"category/(.+?)/embed/?$";s:46:"index.php?category_name=$matches[1]&embed=true";s:35:"category/(.+?)/page/?([0-9]{1,})/?$";s:53:"index.php?category_name=$matches[1]&paged=$matches[2]";s:17:"category/(.+?)/?$";s:35:"index.php?category_name=$matches[1]";s:44:"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?tag=$matches[1]&feed=$matches[2]";s:39:"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?tag=$matches[1]&feed=$matches[2]";s:20:"tag/([^/]+)/embed/?$";s:36:"index.php?tag=$matches[1]&embed=true";s:32:"tag/([^/]+)/page/?([0-9]{1,})/?$";s:43:"index.php?tag=$matches[1]&paged=$matches[2]";s:14:"tag/([^/]+)/?$";s:25:"index.php?tag=$matches[1]";s:45:"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?post_format=$matches[1]&feed=$matches[2]";s:40:"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?post_format=$matches[1]&feed=$matches[2]";s:21:"type/([^/]+)/embed/?$";s:44:"index.php?post_format=$matches[1]&embed=true";s:33:"type/([^/]+)/page/?([0-9]{1,})/?$";s:51:"index.php?post_format=$matches[1]&paged=$matches[2]";s:15:"type/([^/]+)/?$";s:33:"index.php?post_format=$matches[1]";s:12:"robots\\.txt$";s:18:"index.php?robots=1";s:13:"favicon\\.ico$";s:19:"index.php?favicon=1";s:12:"sitemap\\.xml";s:23:"index.php?sitemap=index";s:48:".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$";s:18:"index.php?feed=old";s:20:".*wp-app\\.php(/.*)?$";s:19:"index.php?error=403";s:18:".*wp-register.php$";s:23:"index.php?register=true";s:32:"feed/(feed|rdf|rss|rss2|atom)/?$";s:27:"index.php?&feed=$matches[1]";s:27:"(feed|rdf|rss|rss2|atom)/?$";s:27:"index.php?&feed=$matches[1]";s:8:"embed/?$";s:21:"index.php?&embed=true";s:20:"page/?([0-9]{1,})/?$";s:28:"index.php?&paged=$matches[1]";s:27:"comment-page-([0-9]{1,})/?$";s:38:"index.php?&page_id=8&cpage=$matches[1]";s:41:"comments/feed/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?&feed=$matches[1]&withcomments=1";s:36:"comments/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?&feed=$matches[1]&withcomments=1";s:17:"comments/embed/?$";s:21:"index.php?&embed=true";s:44:"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:40:"index.php?s=$matches[1]&feed=$matches[2]";s:39:"search/(.+)/(feed|rdf|rss|rss2|atom)/?$";s:40:"index.php?s=$matches[1]&feed=$matches[2]";s:20:"search/(.+)/embed/?$";s:34:"index.php?s=$matches[1]&embed=true";s:32:"search/(.+)/page/?([0-9]{1,})/?$";s:41:"index.php?s=$matches[1]&paged=$matches[2]";s:14:"search/(.+)/?$";s:23:"index.php?s=$matches[1]";s:47:"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?author_name=$matches[1]&feed=$matches[2]";s:42:"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?author_name=$matches[1]&feed=$matches[2]";s:23:"author/([^/]+)/embed/?$";s:44:"index.php?author_name=$matches[1]&embed=true";s:35:"author/([^/]+)/page/?([0-9]{1,})/?$";s:51:"index.php?author_name=$matches[1]&paged=$matches[2]";s:17:"author/([^/]+)/?$";s:33:"index.php?author_name=$matches[1]";s:69:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$";s:80:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]";s:64:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$";s:80:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]";s:45:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/embed/?$";s:74:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&embed=true";s:57:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$";s:81:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]";s:39:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$";s:63:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]";s:56:"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$";s:64:"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]";s:51:"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$";s:64:"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]";s:32:"([0-9]{4})/([0-9]{1,2})/embed/?$";s:58:"index.php?year=$matches[1]&monthnum=$matches[2]&embed=true";s:44:"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$";s:65:"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]";s:26:"([0-9]{4})/([0-9]{1,2})/?$";s:47:"index.php?year=$matches[1]&monthnum=$matches[2]";s:43:"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$";s:43:"index.php?year=$matches[1]&feed=$matches[2]";s:38:"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$";s:43:"index.php?year=$matches[1]&feed=$matches[2]";s:19:"([0-9]{4})/embed/?$";s:37:"index.php?year=$matches[1]&embed=true";s:31:"([0-9]{4})/page/?([0-9]{1,})/?$";s:44:"index.php?year=$matches[1]&paged=$matches[2]";s:13:"([0-9]{4})/?$";s:26:"index.php?year=$matches[1]";s:27:".?.+?/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:37:".?.+?/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:57:".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:52:".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:52:".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:33:".?.+?/attachment/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:16:"(.?.+?)/embed/?$";s:41:"index.php?pagename=$matches[1]&embed=true";s:20:"(.?.+?)/trackback/?$";s:35:"index.php?pagename=$matches[1]&tb=1";s:40:"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$";s:47:"index.php?pagename=$matches[1]&feed=$matches[2]";s:35:"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$";s:47:"index.php?pagename=$matches[1]&feed=$matches[2]";s:28:"(.?.+?)/page/?([0-9]{1,})/?$";s:48:"index.php?pagename=$matches[1]&paged=$matches[2]";s:35:"(.?.+?)/comment-page-([0-9]{1,})/?$";s:48:"index.php?pagename=$matches[1]&cpage=$matches[2]";s:24:"(.?.+?)(?:/([0-9]+))?/?$";s:47:"index.php?pagename=$matches[1]&page=$matches[2]";s:27:"[^/]+/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:37:"[^/]+/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:57:"[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:52:"[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:52:"[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:33:"[^/]+/attachment/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:16:"([^/]+)/embed/?$";s:37:"index.php?name=$matches[1]&embed=true";s:20:"([^/]+)/trackback/?$";s:31:"index.php?name=$matches[1]&tb=1";s:40:"([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:43:"index.php?name=$matches[1]&feed=$matches[2]";s:35:"([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:43:"index.php?name=$matches[1]&feed=$matches[2]";s:28:"([^/]+)/page/?([0-9]{1,})/?$";s:44:"index.php?name=$matches[1]&paged=$matches[2]";s:35:"([^/]+)/comment-page-([0-9]{1,})/?$";s:44:"index.php?name=$matches[1]&cpage=$matches[2]";s:24:"([^/]+)(?:/([0-9]+))?/?$";s:43:"index.php?name=$matches[1]&page=$matches[2]";s:16:"[^/]+/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:26:"[^/]+/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:46:"[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:41:"[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:41:"[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:22:"[^/]+/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";}', 'on'),
	(31, 'hack_file', '0', 'on'),
	(32, 'blog_charset', 'UTF-8', 'on'),
	(33, 'moderation_keys', '', 'off'),
	(34, 'active_plugins', 'a:5:{i:0;s:30:"advanced-custom-fields/acf.php";i:1;s:43:"maison-dune-contact/maison-dune-contact.php";i:2;s:49:"maison-dune-table-book/maison-dune-table-book.php";i:3;s:43:"smart-custom-fields/smart-custom-fields.php";i:4;s:45:"taxonomy-terms-order/taxonomy-terms-order.php";}', 'on'),
	(35, 'category_base', '', 'on'),
	(36, 'ping_sites', 'https://rpc.pingomatic.com/', 'on'),
	(37, 'comment_max_links', '2', 'on'),
	(38, 'gmt_offset', '0', 'on'),
	(39, 'default_email_category', '1', 'on'),
	(40, 'recently_edited', '', 'off'),
	(41, 'template', 'maison_dune', 'on'),
	(42, 'stylesheet', 'maison_dune', 'on'),
	(43, 'comment_registration', '0', 'on'),
	(44, 'html_type', 'text/html', 'on'),
	(45, 'use_trackback', '0', 'on'),
	(46, 'default_role', 'subscriber', 'on'),
	(47, 'db_version', '60717', 'on'),
	(48, 'uploads_use_yearmonth_folders', '1', 'on'),
	(49, 'upload_path', '', 'on'),
	(50, 'blog_public', '1', 'on'),
	(51, 'default_link_category', '2', 'on'),
	(52, 'show_on_front', 'page', 'on'),
	(53, 'tag_base', '', 'on'),
	(54, 'show_avatars', '1', 'on'),
	(55, 'avatar_rating', 'G', 'on'),
	(56, 'upload_url_path', '', 'on'),
	(57, 'thumbnail_size_w', '150', 'on'),
	(58, 'thumbnail_size_h', '150', 'on'),
	(59, 'thumbnail_crop', '1', 'on'),
	(60, 'medium_size_w', '300', 'on'),
	(61, 'medium_size_h', '300', 'on'),
	(62, 'avatar_default', 'mystery', 'on'),
	(63, 'large_size_w', '1024', 'on'),
	(64, 'large_size_h', '1024', 'on'),
	(65, 'image_default_link_type', 'none', 'on'),
	(66, 'image_default_size', '', 'on'),
	(67, 'image_default_align', '', 'on'),
	(68, 'close_comments_for_old_posts', '0', 'on'),
	(69, 'close_comments_days_old', '14', 'on'),
	(70, 'thread_comments', '1', 'on'),
	(71, 'thread_comments_depth', '5', 'on'),
	(72, 'page_comments', '0', 'on'),
	(73, 'comments_per_page', '50', 'on'),
	(74, 'default_comments_page', 'newest', 'on'),
	(75, 'comment_order', 'asc', 'on'),
	(76, 'sticky_posts', 'a:0:{}', 'on'),
	(77, 'widget_categories', 'a:0:{}', 'on'),
	(78, 'widget_text', 'a:0:{}', 'on'),
	(79, 'widget_rss', 'a:0:{}', 'on'),
	(80, 'uninstall_plugins', 'a:1:{s:43:"smart-custom-fields/smart-custom-fields.php";a:2:{i:0;s:19:"Smart_Custom_Fields";i:1;s:9:"uninstall";}}', 'off'),
	(81, 'timezone_string', 'Europe/Madrid', 'on'),
	(82, 'page_for_posts', '0', 'on'),
	(83, 'page_on_front', '8', 'on'),
	(84, 'default_post_format', '0', 'on'),
	(85, 'link_manager_enabled', '0', 'on'),
	(86, 'finished_splitting_shared_terms', '1', 'on'),
	(87, 'site_icon', '0', 'on'),
	(88, 'medium_large_size_w', '768', 'on'),
	(89, 'medium_large_size_h', '0', 'on'),
	(90, 'wp_page_for_privacy_policy', '3', 'on'),
	(91, 'show_comments_cookies_opt_in', '1', 'on'),
	(92, 'admin_email_lifespan', '1786382100', 'on'),
	(93, 'disallowed_keys', '', 'off'),
	(94, 'comment_previously_approved', '1', 'on'),
	(95, 'auto_plugin_theme_update_emails', 'a:0:{}', 'off'),
	(96, 'auto_update_core_dev', 'enabled', 'on'),
	(97, 'auto_update_core_minor', 'enabled', 'on'),
	(98, 'auto_update_core_major', 'enabled', 'on'),
	(99, 'wp_force_deactivated_plugins', 'a:0:{}', 'on'),
	(100, 'wp_attachment_pages_enabled', '0', 'on'),
	(101, 'wp_notes_notify', '1', 'on'),
	(102, 'initial_db_version', '60717', 'on'),
	(103, 'wp_user_roles', 'a:5:{s:13:"administrator";a:2:{s:4:"name";s:13:"Administrator";s:12:"capabilities";a:61:{s:13:"switch_themes";b:1;s:11:"edit_themes";b:1;s:16:"activate_plugins";b:1;s:12:"edit_plugins";b:1;s:10:"edit_users";b:1;s:10:"edit_files";b:1;s:14:"manage_options";b:1;s:17:"moderate_comments";b:1;s:17:"manage_categories";b:1;s:12:"manage_links";b:1;s:12:"upload_files";b:1;s:6:"import";b:1;s:15:"unfiltered_html";b:1;s:10:"edit_posts";b:1;s:17:"edit_others_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:10:"edit_pages";b:1;s:4:"read";b:1;s:8:"level_10";b:1;s:7:"level_9";b:1;s:7:"level_8";b:1;s:7:"level_7";b:1;s:7:"level_6";b:1;s:7:"level_5";b:1;s:7:"level_4";b:1;s:7:"level_3";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:17:"edit_others_pages";b:1;s:20:"edit_published_pages";b:1;s:13:"publish_pages";b:1;s:12:"delete_pages";b:1;s:19:"delete_others_pages";b:1;s:22:"delete_published_pages";b:1;s:12:"delete_posts";b:1;s:19:"delete_others_posts";b:1;s:22:"delete_published_posts";b:1;s:20:"delete_private_posts";b:1;s:18:"edit_private_posts";b:1;s:18:"read_private_posts";b:1;s:20:"delete_private_pages";b:1;s:18:"edit_private_pages";b:1;s:18:"read_private_pages";b:1;s:12:"delete_users";b:1;s:12:"create_users";b:1;s:17:"unfiltered_upload";b:1;s:14:"edit_dashboard";b:1;s:14:"update_plugins";b:1;s:14:"delete_plugins";b:1;s:15:"install_plugins";b:1;s:13:"update_themes";b:1;s:14:"install_themes";b:1;s:11:"update_core";b:1;s:10:"list_users";b:1;s:12:"remove_users";b:1;s:13:"promote_users";b:1;s:18:"edit_theme_options";b:1;s:13:"delete_themes";b:1;s:6:"export";b:1;}}s:6:"editor";a:2:{s:4:"name";s:6:"Editor";s:12:"capabilities";a:34:{s:17:"moderate_comments";b:1;s:17:"manage_categories";b:1;s:12:"manage_links";b:1;s:12:"upload_files";b:1;s:15:"unfiltered_html";b:1;s:10:"edit_posts";b:1;s:17:"edit_others_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:10:"edit_pages";b:1;s:4:"read";b:1;s:7:"level_7";b:1;s:7:"level_6";b:1;s:7:"level_5";b:1;s:7:"level_4";b:1;s:7:"level_3";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:17:"edit_others_pages";b:1;s:20:"edit_published_pages";b:1;s:13:"publish_pages";b:1;s:12:"delete_pages";b:1;s:19:"delete_others_pages";b:1;s:22:"delete_published_pages";b:1;s:12:"delete_posts";b:1;s:19:"delete_others_posts";b:1;s:22:"delete_published_posts";b:1;s:20:"delete_private_posts";b:1;s:18:"edit_private_posts";b:1;s:18:"read_private_posts";b:1;s:20:"delete_private_pages";b:1;s:18:"edit_private_pages";b:1;s:18:"read_private_pages";b:1;}}s:6:"author";a:2:{s:4:"name";s:6:"Author";s:12:"capabilities";a:10:{s:12:"upload_files";b:1;s:10:"edit_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:4:"read";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:12:"delete_posts";b:1;s:22:"delete_published_posts";b:1;}}s:11:"contributor";a:2:{s:4:"name";s:11:"Contributor";s:12:"capabilities";a:5:{s:10:"edit_posts";b:1;s:4:"read";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:12:"delete_posts";b:1;}}s:10:"subscriber";a:2:{s:4:"name";s:10:"Subscriber";s:12:"capabilities";a:2:{s:4:"read";b:1;s:7:"level_0";b:1;}}}', 'on'),
	(104, 'fresh_site', '0', 'off'),
	(105, 'WPLANG', 'es_ES', 'auto'),
	(106, 'user_count', '1', 'off'),
	(107, 'widget_block', 'a:6:{i:2;a:1:{s:7:"content";s:19:"<!-- wp:search /-->";}i:3;a:1:{s:7:"content";s:160:"<!-- wp:group --><div class="wp-block-group"><!-- wp:heading --><h2>Entradas recientes</h2><!-- /wp:heading --><!-- wp:latest-posts /--></div><!-- /wp:group -->";}i:4;a:1:{s:7:"content";s:233:"<!-- wp:group --><div class="wp-block-group"><!-- wp:heading --><h2>Comentarios recientes</h2><!-- /wp:heading --><!-- wp:latest-comments {"displayAvatar":false,"displayDate":false,"displayExcerpt":false} /--></div><!-- /wp:group -->";}i:5;a:1:{s:7:"content";s:146:"<!-- wp:group --><div class="wp-block-group"><!-- wp:heading --><h2>Archivos</h2><!-- /wp:heading --><!-- wp:archives /--></div><!-- /wp:group -->";}i:6;a:1:{s:7:"content";s:151:"<!-- wp:group --><div class="wp-block-group"><!-- wp:heading --><h2>Categorías</h2><!-- /wp:heading --><!-- wp:categories /--></div><!-- /wp:group -->";}s:12:"_multiwidget";i:1;}', 'auto'),
	(108, 'sidebars_widgets', 'a:2:{s:19:"wp_inactive_widgets";a:5:{i:0;s:7:"block-2";i:1;s:7:"block-3";i:2;s:7:"block-4";i:3;s:7:"block-5";i:4;s:7:"block-6";}s:13:"array_version";i:3;}', 'auto'),
	(109, 'widget_pages', 'a:1:{s:12:"_multiwidget";i:1;}', 'auto'),
	(110, 'widget_calendar', 'a:1:{s:12:"_multiwidget";i:1;}', 'auto'),
	(111, 'widget_archives', 'a:1:{s:12:"_multiwidget";i:1;}', 'auto'),
	(112, 'widget_media_audio', 'a:1:{s:12:"_multiwidget";i:1;}', 'auto'),
	(113, 'widget_media_image', 'a:1:{s:12:"_multiwidget";i:1;}', 'auto'),
	(114, 'widget_media_gallery', 'a:1:{s:12:"_multiwidget";i:1;}', 'auto'),
	(115, 'widget_media_video', 'a:1:{s:12:"_multiwidget";i:1;}', 'auto'),
	(116, 'widget_meta', 'a:1:{s:12:"_multiwidget";i:1;}', 'auto'),
	(117, 'widget_search', 'a:1:{s:12:"_multiwidget";i:1;}', 'auto'),
	(118, 'widget_recent-posts', 'a:1:{s:12:"_multiwidget";i:1;}', 'auto'),
	(119, 'widget_recent-comments', 'a:1:{s:12:"_multiwidget";i:1;}', 'auto'),
	(120, 'widget_tag_cloud', 'a:1:{s:12:"_multiwidget";i:1;}', 'auto'),
	(121, 'widget_nav_menu', 'a:1:{s:12:"_multiwidget";i:1;}', 'auto'),
	(122, 'widget_custom_html', 'a:1:{s:12:"_multiwidget";i:1;}', 'auto'),
	(123, '_transient_wp_core_block_css_files', 'a:2:{s:7:"version";s:5:"6.9.4";s:5:"files";a:584:{i:0;s:31:"accordion-heading/style-rtl.css";i:1;s:35:"accordion-heading/style-rtl.min.css";i:2;s:27:"accordion-heading/style.css";i:3;s:31:"accordion-heading/style.min.css";i:4;s:28:"accordion-item/style-rtl.css";i:5;s:32:"accordion-item/style-rtl.min.css";i:6;s:24:"accordion-item/style.css";i:7;s:28:"accordion-item/style.min.css";i:8;s:29:"accordion-panel/style-rtl.css";i:9;s:33:"accordion-panel/style-rtl.min.css";i:10;s:25:"accordion-panel/style.css";i:11;s:29:"accordion-panel/style.min.css";i:12;s:23:"accordion/style-rtl.css";i:13;s:27:"accordion/style-rtl.min.css";i:14;s:19:"accordion/style.css";i:15;s:23:"accordion/style.min.css";i:16;s:23:"archives/editor-rtl.css";i:17;s:27:"archives/editor-rtl.min.css";i:18;s:19:"archives/editor.css";i:19;s:23:"archives/editor.min.css";i:20;s:22:"archives/style-rtl.css";i:21;s:26:"archives/style-rtl.min.css";i:22;s:18:"archives/style.css";i:23;s:22:"archives/style.min.css";i:24;s:20:"audio/editor-rtl.css";i:25;s:24:"audio/editor-rtl.min.css";i:26;s:16:"audio/editor.css";i:27;s:20:"audio/editor.min.css";i:28;s:19:"audio/style-rtl.css";i:29;s:23:"audio/style-rtl.min.css";i:30;s:15:"audio/style.css";i:31;s:19:"audio/style.min.css";i:32;s:19:"audio/theme-rtl.css";i:33;s:23:"audio/theme-rtl.min.css";i:34;s:15:"audio/theme.css";i:35;s:19:"audio/theme.min.css";i:36;s:21:"avatar/editor-rtl.css";i:37;s:25:"avatar/editor-rtl.min.css";i:38;s:17:"avatar/editor.css";i:39;s:21:"avatar/editor.min.css";i:40;s:20:"avatar/style-rtl.css";i:41;s:24:"avatar/style-rtl.min.css";i:42;s:16:"avatar/style.css";i:43;s:20:"avatar/style.min.css";i:44;s:21:"button/editor-rtl.css";i:45;s:25:"button/editor-rtl.min.css";i:46;s:17:"button/editor.css";i:47;s:21:"button/editor.min.css";i:48;s:20:"button/style-rtl.css";i:49;s:24:"button/style-rtl.min.css";i:50;s:16:"button/style.css";i:51;s:20:"button/style.min.css";i:52;s:22:"buttons/editor-rtl.css";i:53;s:26:"buttons/editor-rtl.min.css";i:54;s:18:"buttons/editor.css";i:55;s:22:"buttons/editor.min.css";i:56;s:21:"buttons/style-rtl.css";i:57;s:25:"buttons/style-rtl.min.css";i:58;s:17:"buttons/style.css";i:59;s:21:"buttons/style.min.css";i:60;s:22:"calendar/style-rtl.css";i:61;s:26:"calendar/style-rtl.min.css";i:62;s:18:"calendar/style.css";i:63;s:22:"calendar/style.min.css";i:64;s:25:"categories/editor-rtl.css";i:65;s:29:"categories/editor-rtl.min.css";i:66;s:21:"categories/editor.css";i:67;s:25:"categories/editor.min.css";i:68;s:24:"categories/style-rtl.css";i:69;s:28:"categories/style-rtl.min.css";i:70;s:20:"categories/style.css";i:71;s:24:"categories/style.min.css";i:72;s:19:"code/editor-rtl.css";i:73;s:23:"code/editor-rtl.min.css";i:74;s:15:"code/editor.css";i:75;s:19:"code/editor.min.css";i:76;s:18:"code/style-rtl.css";i:77;s:22:"code/style-rtl.min.css";i:78;s:14:"code/style.css";i:79;s:18:"code/style.min.css";i:80;s:18:"code/theme-rtl.css";i:81;s:22:"code/theme-rtl.min.css";i:82;s:14:"code/theme.css";i:83;s:18:"code/theme.min.css";i:84;s:22:"columns/editor-rtl.css";i:85;s:26:"columns/editor-rtl.min.css";i:86;s:18:"columns/editor.css";i:87;s:22:"columns/editor.min.css";i:88;s:21:"columns/style-rtl.css";i:89;s:25:"columns/style-rtl.min.css";i:90;s:17:"columns/style.css";i:91;s:21:"columns/style.min.css";i:92;s:33:"comment-author-name/style-rtl.css";i:93;s:37:"comment-author-name/style-rtl.min.css";i:94;s:29:"comment-author-name/style.css";i:95;s:33:"comment-author-name/style.min.css";i:96;s:29:"comment-content/style-rtl.css";i:97;s:33:"comment-content/style-rtl.min.css";i:98;s:25:"comment-content/style.css";i:99;s:29:"comment-content/style.min.css";i:100;s:26:"comment-date/style-rtl.css";i:101;s:30:"comment-date/style-rtl.min.css";i:102;s:22:"comment-date/style.css";i:103;s:26:"comment-date/style.min.css";i:104;s:31:"comment-edit-link/style-rtl.css";i:105;s:35:"comment-edit-link/style-rtl.min.css";i:106;s:27:"comment-edit-link/style.css";i:107;s:31:"comment-edit-link/style.min.css";i:108;s:32:"comment-reply-link/style-rtl.css";i:109;s:36:"comment-reply-link/style-rtl.min.css";i:110;s:28:"comment-reply-link/style.css";i:111;s:32:"comment-reply-link/style.min.css";i:112;s:30:"comment-template/style-rtl.css";i:113;s:34:"comment-template/style-rtl.min.css";i:114;s:26:"comment-template/style.css";i:115;s:30:"comment-template/style.min.css";i:116;s:42:"comments-pagination-numbers/editor-rtl.css";i:117;s:46:"comments-pagination-numbers/editor-rtl.min.css";i:118;s:38:"comments-pagination-numbers/editor.css";i:119;s:42:"comments-pagination-numbers/editor.min.css";i:120;s:34:"comments-pagination/editor-rtl.css";i:121;s:38:"comments-pagination/editor-rtl.min.css";i:122;s:30:"comments-pagination/editor.css";i:123;s:34:"comments-pagination/editor.min.css";i:124;s:33:"comments-pagination/style-rtl.css";i:125;s:37:"comments-pagination/style-rtl.min.css";i:126;s:29:"comments-pagination/style.css";i:127;s:33:"comments-pagination/style.min.css";i:128;s:29:"comments-title/editor-rtl.css";i:129;s:33:"comments-title/editor-rtl.min.css";i:130;s:25:"comments-title/editor.css";i:131;s:29:"comments-title/editor.min.css";i:132;s:23:"comments/editor-rtl.css";i:133;s:27:"comments/editor-rtl.min.css";i:134;s:19:"comments/editor.css";i:135;s:23:"comments/editor.min.css";i:136;s:22:"comments/style-rtl.css";i:137;s:26:"comments/style-rtl.min.css";i:138;s:18:"comments/style.css";i:139;s:22:"comments/style.min.css";i:140;s:20:"cover/editor-rtl.css";i:141;s:24:"cover/editor-rtl.min.css";i:142;s:16:"cover/editor.css";i:143;s:20:"cover/editor.min.css";i:144;s:19:"cover/style-rtl.css";i:145;s:23:"cover/style-rtl.min.css";i:146;s:15:"cover/style.css";i:147;s:19:"cover/style.min.css";i:148;s:22:"details/editor-rtl.css";i:149;s:26:"details/editor-rtl.min.css";i:150;s:18:"details/editor.css";i:151;s:22:"details/editor.min.css";i:152;s:21:"details/style-rtl.css";i:153;s:25:"details/style-rtl.min.css";i:154;s:17:"details/style.css";i:155;s:21:"details/style.min.css";i:156;s:20:"embed/editor-rtl.css";i:157;s:24:"embed/editor-rtl.min.css";i:158;s:16:"embed/editor.css";i:159;s:20:"embed/editor.min.css";i:160;s:19:"embed/style-rtl.css";i:161;s:23:"embed/style-rtl.min.css";i:162;s:15:"embed/style.css";i:163;s:19:"embed/style.min.css";i:164;s:19:"embed/theme-rtl.css";i:165;s:23:"embed/theme-rtl.min.css";i:166;s:15:"embed/theme.css";i:167;s:19:"embed/theme.min.css";i:168;s:19:"file/editor-rtl.css";i:169;s:23:"file/editor-rtl.min.css";i:170;s:15:"file/editor.css";i:171;s:19:"file/editor.min.css";i:172;s:18:"file/style-rtl.css";i:173;s:22:"file/style-rtl.min.css";i:174;s:14:"file/style.css";i:175;s:18:"file/style.min.css";i:176;s:23:"footnotes/style-rtl.css";i:177;s:27:"footnotes/style-rtl.min.css";i:178;s:19:"footnotes/style.css";i:179;s:23:"footnotes/style.min.css";i:180;s:23:"freeform/editor-rtl.css";i:181;s:27:"freeform/editor-rtl.min.css";i:182;s:19:"freeform/editor.css";i:183;s:23:"freeform/editor.min.css";i:184;s:22:"gallery/editor-rtl.css";i:185;s:26:"gallery/editor-rtl.min.css";i:186;s:18:"gallery/editor.css";i:187;s:22:"gallery/editor.min.css";i:188;s:21:"gallery/style-rtl.css";i:189;s:25:"gallery/style-rtl.min.css";i:190;s:17:"gallery/style.css";i:191;s:21:"gallery/style.min.css";i:192;s:21:"gallery/theme-rtl.css";i:193;s:25:"gallery/theme-rtl.min.css";i:194;s:17:"gallery/theme.css";i:195;s:21:"gallery/theme.min.css";i:196;s:20:"group/editor-rtl.css";i:197;s:24:"group/editor-rtl.min.css";i:198;s:16:"group/editor.css";i:199;s:20:"group/editor.min.css";i:200;s:19:"group/style-rtl.css";i:201;s:23:"group/style-rtl.min.css";i:202;s:15:"group/style.css";i:203;s:19:"group/style.min.css";i:204;s:19:"group/theme-rtl.css";i:205;s:23:"group/theme-rtl.min.css";i:206;s:15:"group/theme.css";i:207;s:19:"group/theme.min.css";i:208;s:21:"heading/style-rtl.css";i:209;s:25:"heading/style-rtl.min.css";i:210;s:17:"heading/style.css";i:211;s:21:"heading/style.min.css";i:212;s:19:"html/editor-rtl.css";i:213;s:23:"html/editor-rtl.min.css";i:214;s:15:"html/editor.css";i:215;s:19:"html/editor.min.css";i:216;s:20:"image/editor-rtl.css";i:217;s:24:"image/editor-rtl.min.css";i:218;s:16:"image/editor.css";i:219;s:20:"image/editor.min.css";i:220;s:19:"image/style-rtl.css";i:221;s:23:"image/style-rtl.min.css";i:222;s:15:"image/style.css";i:223;s:19:"image/style.min.css";i:224;s:19:"image/theme-rtl.css";i:225;s:23:"image/theme-rtl.min.css";i:226;s:15:"image/theme.css";i:227;s:19:"image/theme.min.css";i:228;s:29:"latest-comments/style-rtl.css";i:229;s:33:"latest-comments/style-rtl.min.css";i:230;s:25:"latest-comments/style.css";i:231;s:29:"latest-comments/style.min.css";i:232;s:27:"latest-posts/editor-rtl.css";i:233;s:31:"latest-posts/editor-rtl.min.css";i:234;s:23:"latest-posts/editor.css";i:235;s:27:"latest-posts/editor.min.css";i:236;s:26:"latest-posts/style-rtl.css";i:237;s:30:"latest-posts/style-rtl.min.css";i:238;s:22:"latest-posts/style.css";i:239;s:26:"latest-posts/style.min.css";i:240;s:18:"list/style-rtl.css";i:241;s:22:"list/style-rtl.min.css";i:242;s:14:"list/style.css";i:243;s:18:"list/style.min.css";i:244;s:22:"loginout/style-rtl.css";i:245;s:26:"loginout/style-rtl.min.css";i:246;s:18:"loginout/style.css";i:247;s:22:"loginout/style.min.css";i:248;s:19:"math/editor-rtl.css";i:249;s:23:"math/editor-rtl.min.css";i:250;s:15:"math/editor.css";i:251;s:19:"math/editor.min.css";i:252;s:18:"math/style-rtl.css";i:253;s:22:"math/style-rtl.min.css";i:254;s:14:"math/style.css";i:255;s:18:"math/style.min.css";i:256;s:25:"media-text/editor-rtl.css";i:257;s:29:"media-text/editor-rtl.min.css";i:258;s:21:"media-text/editor.css";i:259;s:25:"media-text/editor.min.css";i:260;s:24:"media-text/style-rtl.css";i:261;s:28:"media-text/style-rtl.min.css";i:262;s:20:"media-text/style.css";i:263;s:24:"media-text/style.min.css";i:264;s:19:"more/editor-rtl.css";i:265;s:23:"more/editor-rtl.min.css";i:266;s:15:"more/editor.css";i:267;s:19:"more/editor.min.css";i:268;s:30:"navigation-link/editor-rtl.css";i:269;s:34:"navigation-link/editor-rtl.min.css";i:270;s:26:"navigation-link/editor.css";i:271;s:30:"navigation-link/editor.min.css";i:272;s:29:"navigation-link/style-rtl.css";i:273;s:33:"navigation-link/style-rtl.min.css";i:274;s:25:"navigation-link/style.css";i:275;s:29:"navigation-link/style.min.css";i:276;s:33:"navigation-submenu/editor-rtl.css";i:277;s:37:"navigation-submenu/editor-rtl.min.css";i:278;s:29:"navigation-submenu/editor.css";i:279;s:33:"navigation-submenu/editor.min.css";i:280;s:25:"navigation/editor-rtl.css";i:281;s:29:"navigation/editor-rtl.min.css";i:282;s:21:"navigation/editor.css";i:283;s:25:"navigation/editor.min.css";i:284;s:24:"navigation/style-rtl.css";i:285;s:28:"navigation/style-rtl.min.css";i:286;s:20:"navigation/style.css";i:287;s:24:"navigation/style.min.css";i:288;s:23:"nextpage/editor-rtl.css";i:289;s:27:"nextpage/editor-rtl.min.css";i:290;s:19:"nextpage/editor.css";i:291;s:23:"nextpage/editor.min.css";i:292;s:24:"page-list/editor-rtl.css";i:293;s:28:"page-list/editor-rtl.min.css";i:294;s:20:"page-list/editor.css";i:295;s:24:"page-list/editor.min.css";i:296;s:23:"page-list/style-rtl.css";i:297;s:27:"page-list/style-rtl.min.css";i:298;s:19:"page-list/style.css";i:299;s:23:"page-list/style.min.css";i:300;s:24:"paragraph/editor-rtl.css";i:301;s:28:"paragraph/editor-rtl.min.css";i:302;s:20:"paragraph/editor.css";i:303;s:24:"paragraph/editor.min.css";i:304;s:23:"paragraph/style-rtl.css";i:305;s:27:"paragraph/style-rtl.min.css";i:306;s:19:"paragraph/style.css";i:307;s:23:"paragraph/style.min.css";i:308;s:35:"post-author-biography/style-rtl.css";i:309;s:39:"post-author-biography/style-rtl.min.css";i:310;s:31:"post-author-biography/style.css";i:311;s:35:"post-author-biography/style.min.css";i:312;s:30:"post-author-name/style-rtl.css";i:313;s:34:"post-author-name/style-rtl.min.css";i:314;s:26:"post-author-name/style.css";i:315;s:30:"post-author-name/style.min.css";i:316;s:25:"post-author/style-rtl.css";i:317;s:29:"post-author/style-rtl.min.css";i:318;s:21:"post-author/style.css";i:319;s:25:"post-author/style.min.css";i:320;s:33:"post-comments-count/style-rtl.css";i:321;s:37:"post-comments-count/style-rtl.min.css";i:322;s:29:"post-comments-count/style.css";i:323;s:33:"post-comments-count/style.min.css";i:324;s:33:"post-comments-form/editor-rtl.css";i:325;s:37:"post-comments-form/editor-rtl.min.css";i:326;s:29:"post-comments-form/editor.css";i:327;s:33:"post-comments-form/editor.min.css";i:328;s:32:"post-comments-form/style-rtl.css";i:329;s:36:"post-comments-form/style-rtl.min.css";i:330;s:28:"post-comments-form/style.css";i:331;s:32:"post-comments-form/style.min.css";i:332;s:32:"post-comments-link/style-rtl.css";i:333;s:36:"post-comments-link/style-rtl.min.css";i:334;s:28:"post-comments-link/style.css";i:335;s:32:"post-comments-link/style.min.css";i:336;s:26:"post-content/style-rtl.css";i:337;s:30:"post-content/style-rtl.min.css";i:338;s:22:"post-content/style.css";i:339;s:26:"post-content/style.min.css";i:340;s:23:"post-date/style-rtl.css";i:341;s:27:"post-date/style-rtl.min.css";i:342;s:19:"post-date/style.css";i:343;s:23:"post-date/style.min.css";i:344;s:27:"post-excerpt/editor-rtl.css";i:345;s:31:"post-excerpt/editor-rtl.min.css";i:346;s:23:"post-excerpt/editor.css";i:347;s:27:"post-excerpt/editor.min.css";i:348;s:26:"post-excerpt/style-rtl.css";i:349;s:30:"post-excerpt/style-rtl.min.css";i:350;s:22:"post-excerpt/style.css";i:351;s:26:"post-excerpt/style.min.css";i:352;s:34:"post-featured-image/editor-rtl.css";i:353;s:38:"post-featured-image/editor-rtl.min.css";i:354;s:30:"post-featured-image/editor.css";i:355;s:34:"post-featured-image/editor.min.css";i:356;s:33:"post-featured-image/style-rtl.css";i:357;s:37:"post-featured-image/style-rtl.min.css";i:358;s:29:"post-featured-image/style.css";i:359;s:33:"post-featured-image/style.min.css";i:360;s:34:"post-navigation-link/style-rtl.css";i:361;s:38:"post-navigation-link/style-rtl.min.css";i:362;s:30:"post-navigation-link/style.css";i:363;s:34:"post-navigation-link/style.min.css";i:364;s:27:"post-template/style-rtl.css";i:365;s:31:"post-template/style-rtl.min.css";i:366;s:23:"post-template/style.css";i:367;s:27:"post-template/style.min.css";i:368;s:24:"post-terms/style-rtl.css";i:369;s:28:"post-terms/style-rtl.min.css";i:370;s:20:"post-terms/style.css";i:371;s:24:"post-terms/style.min.css";i:372;s:31:"post-time-to-read/style-rtl.css";i:373;s:35:"post-time-to-read/style-rtl.min.css";i:374;s:27:"post-time-to-read/style.css";i:375;s:31:"post-time-to-read/style.min.css";i:376;s:24:"post-title/style-rtl.css";i:377;s:28:"post-title/style-rtl.min.css";i:378;s:20:"post-title/style.css";i:379;s:24:"post-title/style.min.css";i:380;s:26:"preformatted/style-rtl.css";i:381;s:30:"preformatted/style-rtl.min.css";i:382;s:22:"preformatted/style.css";i:383;s:26:"preformatted/style.min.css";i:384;s:24:"pullquote/editor-rtl.css";i:385;s:28:"pullquote/editor-rtl.min.css";i:386;s:20:"pullquote/editor.css";i:387;s:24:"pullquote/editor.min.css";i:388;s:23:"pullquote/style-rtl.css";i:389;s:27:"pullquote/style-rtl.min.css";i:390;s:19:"pullquote/style.css";i:391;s:23:"pullquote/style.min.css";i:392;s:23:"pullquote/theme-rtl.css";i:393;s:27:"pullquote/theme-rtl.min.css";i:394;s:19:"pullquote/theme.css";i:395;s:23:"pullquote/theme.min.css";i:396;s:39:"query-pagination-numbers/editor-rtl.css";i:397;s:43:"query-pagination-numbers/editor-rtl.min.css";i:398;s:35:"query-pagination-numbers/editor.css";i:399;s:39:"query-pagination-numbers/editor.min.css";i:400;s:31:"query-pagination/editor-rtl.css";i:401;s:35:"query-pagination/editor-rtl.min.css";i:402;s:27:"query-pagination/editor.css";i:403;s:31:"query-pagination/editor.min.css";i:404;s:30:"query-pagination/style-rtl.css";i:405;s:34:"query-pagination/style-rtl.min.css";i:406;s:26:"query-pagination/style.css";i:407;s:30:"query-pagination/style.min.css";i:408;s:25:"query-title/style-rtl.css";i:409;s:29:"query-title/style-rtl.min.css";i:410;s:21:"query-title/style.css";i:411;s:25:"query-title/style.min.css";i:412;s:25:"query-total/style-rtl.css";i:413;s:29:"query-total/style-rtl.min.css";i:414;s:21:"query-total/style.css";i:415;s:25:"query-total/style.min.css";i:416;s:20:"query/editor-rtl.css";i:417;s:24:"query/editor-rtl.min.css";i:418;s:16:"query/editor.css";i:419;s:20:"query/editor.min.css";i:420;s:19:"quote/style-rtl.css";i:421;s:23:"quote/style-rtl.min.css";i:422;s:15:"quote/style.css";i:423;s:19:"quote/style.min.css";i:424;s:19:"quote/theme-rtl.css";i:425;s:23:"quote/theme-rtl.min.css";i:426;s:15:"quote/theme.css";i:427;s:19:"quote/theme.min.css";i:428;s:23:"read-more/style-rtl.css";i:429;s:27:"read-more/style-rtl.min.css";i:430;s:19:"read-more/style.css";i:431;s:23:"read-more/style.min.css";i:432;s:18:"rss/editor-rtl.css";i:433;s:22:"rss/editor-rtl.min.css";i:434;s:14:"rss/editor.css";i:435;s:18:"rss/editor.min.css";i:436;s:17:"rss/style-rtl.css";i:437;s:21:"rss/style-rtl.min.css";i:438;s:13:"rss/style.css";i:439;s:17:"rss/style.min.css";i:440;s:21:"search/editor-rtl.css";i:441;s:25:"search/editor-rtl.min.css";i:442;s:17:"search/editor.css";i:443;s:21:"search/editor.min.css";i:444;s:20:"search/style-rtl.css";i:445;s:24:"search/style-rtl.min.css";i:446;s:16:"search/style.css";i:447;s:20:"search/style.min.css";i:448;s:20:"search/theme-rtl.css";i:449;s:24:"search/theme-rtl.min.css";i:450;s:16:"search/theme.css";i:451;s:20:"search/theme.min.css";i:452;s:24:"separator/editor-rtl.css";i:453;s:28:"separator/editor-rtl.min.css";i:454;s:20:"separator/editor.css";i:455;s:24:"separator/editor.min.css";i:456;s:23:"separator/style-rtl.css";i:457;s:27:"separator/style-rtl.min.css";i:458;s:19:"separator/style.css";i:459;s:23:"separator/style.min.css";i:460;s:23:"separator/theme-rtl.css";i:461;s:27:"separator/theme-rtl.min.css";i:462;s:19:"separator/theme.css";i:463;s:23:"separator/theme.min.css";i:464;s:24:"shortcode/editor-rtl.css";i:465;s:28:"shortcode/editor-rtl.min.css";i:466;s:20:"shortcode/editor.css";i:467;s:24:"shortcode/editor.min.css";i:468;s:24:"site-logo/editor-rtl.css";i:469;s:28:"site-logo/editor-rtl.min.css";i:470;s:20:"site-logo/editor.css";i:471;s:24:"site-logo/editor.min.css";i:472;s:23:"site-logo/style-rtl.css";i:473;s:27:"site-logo/style-rtl.min.css";i:474;s:19:"site-logo/style.css";i:475;s:23:"site-logo/style.min.css";i:476;s:27:"site-tagline/editor-rtl.css";i:477;s:31:"site-tagline/editor-rtl.min.css";i:478;s:23:"site-tagline/editor.css";i:479;s:27:"site-tagline/editor.min.css";i:480;s:26:"site-tagline/style-rtl.css";i:481;s:30:"site-tagline/style-rtl.min.css";i:482;s:22:"site-tagline/style.css";i:483;s:26:"site-tagline/style.min.css";i:484;s:25:"site-title/editor-rtl.css";i:485;s:29:"site-title/editor-rtl.min.css";i:486;s:21:"site-title/editor.css";i:487;s:25:"site-title/editor.min.css";i:488;s:24:"site-title/style-rtl.css";i:489;s:28:"site-title/style-rtl.min.css";i:490;s:20:"site-title/style.css";i:491;s:24:"site-title/style.min.css";i:492;s:26:"social-link/editor-rtl.css";i:493;s:30:"social-link/editor-rtl.min.css";i:494;s:22:"social-link/editor.css";i:495;s:26:"social-link/editor.min.css";i:496;s:27:"social-links/editor-rtl.css";i:497;s:31:"social-links/editor-rtl.min.css";i:498;s:23:"social-links/editor.css";i:499;s:27:"social-links/editor.min.css";i:500;s:26:"social-links/style-rtl.css";i:501;s:30:"social-links/style-rtl.min.css";i:502;s:22:"social-links/style.css";i:503;s:26:"social-links/style.min.css";i:504;s:21:"spacer/editor-rtl.css";i:505;s:25:"spacer/editor-rtl.min.css";i:506;s:17:"spacer/editor.css";i:507;s:21:"spacer/editor.min.css";i:508;s:20:"spacer/style-rtl.css";i:509;s:24:"spacer/style-rtl.min.css";i:510;s:16:"spacer/style.css";i:511;s:20:"spacer/style.min.css";i:512;s:20:"table/editor-rtl.css";i:513;s:24:"table/editor-rtl.min.css";i:514;s:16:"table/editor.css";i:515;s:20:"table/editor.min.css";i:516;s:19:"table/style-rtl.css";i:517;s:23:"table/style-rtl.min.css";i:518;s:15:"table/style.css";i:519;s:19:"table/style.min.css";i:520;s:19:"table/theme-rtl.css";i:521;s:23:"table/theme-rtl.min.css";i:522;s:15:"table/theme.css";i:523;s:19:"table/theme.min.css";i:524;s:24:"tag-cloud/editor-rtl.css";i:525;s:28:"tag-cloud/editor-rtl.min.css";i:526;s:20:"tag-cloud/editor.css";i:527;s:24:"tag-cloud/editor.min.css";i:528;s:23:"tag-cloud/style-rtl.css";i:529;s:27:"tag-cloud/style-rtl.min.css";i:530;s:19:"tag-cloud/style.css";i:531;s:23:"tag-cloud/style.min.css";i:532;s:28:"template-part/editor-rtl.css";i:533;s:32:"template-part/editor-rtl.min.css";i:534;s:24:"template-part/editor.css";i:535;s:28:"template-part/editor.min.css";i:536;s:27:"template-part/theme-rtl.css";i:537;s:31:"template-part/theme-rtl.min.css";i:538;s:23:"template-part/theme.css";i:539;s:27:"template-part/theme.min.css";i:540;s:24:"term-count/style-rtl.css";i:541;s:28:"term-count/style-rtl.min.css";i:542;s:20:"term-count/style.css";i:543;s:24:"term-count/style.min.css";i:544;s:30:"term-description/style-rtl.css";i:545;s:34:"term-description/style-rtl.min.css";i:546;s:26:"term-description/style.css";i:547;s:30:"term-description/style.min.css";i:548;s:23:"term-name/style-rtl.css";i:549;s:27:"term-name/style-rtl.min.css";i:550;s:19:"term-name/style.css";i:551;s:23:"term-name/style.min.css";i:552;s:28:"term-template/editor-rtl.css";i:553;s:32:"term-template/editor-rtl.min.css";i:554;s:24:"term-template/editor.css";i:555;s:28:"term-template/editor.min.css";i:556;s:27:"term-template/style-rtl.css";i:557;s:31:"term-template/style-rtl.min.css";i:558;s:23:"term-template/style.css";i:559;s:27:"term-template/style.min.css";i:560;s:27:"text-columns/editor-rtl.css";i:561;s:31:"text-columns/editor-rtl.min.css";i:562;s:23:"text-columns/editor.css";i:563;s:27:"text-columns/editor.min.css";i:564;s:26:"text-columns/style-rtl.css";i:565;s:30:"text-columns/style-rtl.min.css";i:566;s:22:"text-columns/style.css";i:567;s:26:"text-columns/style.min.css";i:568;s:19:"verse/style-rtl.css";i:569;s:23:"verse/style-rtl.min.css";i:570;s:15:"verse/style.css";i:571;s:19:"verse/style.min.css";i:572;s:20:"video/editor-rtl.css";i:573;s:24:"video/editor-rtl.min.css";i:574;s:16:"video/editor.css";i:575;s:20:"video/editor.min.css";i:576;s:19:"video/style-rtl.css";i:577;s:23:"video/style-rtl.min.css";i:578;s:15:"video/style.css";i:579;s:19:"video/style.min.css";i:580;s:19:"video/theme-rtl.css";i:581;s:23:"video/theme-rtl.min.css";i:582;s:15:"video/theme.css";i:583;s:19:"video/theme.min.css";}}', 'on'),
	(128, 'nonce_key', 'wWDc.xr~*)@i}qRPa=6w%MRLLU@W!Op,x.]QhP36v<f!A0v-y*0hi4Wvb7+B&9av', 'off'),
	(130, 'nonce_salt', 'n]~V?nIe?,<9nDk?KM:CaZq^Ov.j7Y;jo7&(JtMBdP %Jw6Rd*XL~JbpSIOQbqm?', 'off'),
	(132, 'theme_mods_twentytwentyfive', 'a:2:{s:18:"custom_css_post_id";i:-1;s:16:"sidebars_widgets";a:2:{s:4:"time";i:1770830449;s:4:"data";a:3:{s:19:"wp_inactive_widgets";a:0:{}s:9:"sidebar-1";a:3:{i:0;s:7:"block-2";i:1;s:7:"block-3";i:2;s:7:"block-4";}s:9:"sidebar-2";a:2:{i:0;s:7:"block-5";i:1;s:7:"block-6";}}}}', 'off'),
	(135, '_transient_wp_styles_for_blocks', 'a:2:{s:4:"hash";s:32:"e6d0d097fa71e03c12289db6df63064a";s:6:"blocks";a:6:{s:11:"core/button";s:0:"";s:14:"core/site-logo";s:0:"";s:18:"core/post-template";s:120:":where(.wp-block-post-template.is-layout-flex){gap: 1.25em;}:where(.wp-block-post-template.is-layout-grid){gap: 1.25em;}";s:18:"core/term-template";s:120:":where(.wp-block-term-template.is-layout-flex){gap: 1.25em;}:where(.wp-block-term-template.is-layout-grid){gap: 1.25em;}";s:12:"core/columns";s:102:":where(.wp-block-columns.is-layout-flex){gap: 2em;}:where(.wp-block-columns.is-layout-grid){gap: 2em;}";s:14:"core/pullquote";s:69:":root :where(.wp-block-pullquote){font-size: 1.5em;line-height: 1.6;}";}}', 'on'),
	(137, 'recovery_keys', 'a:0:{}', 'off'),
	(140, 'auth_key', '#4FAh_p6X8DF_bISMlA%&Zr?{gS@UWj~1QP{QycM4M4H+,<IZnj$P4he2$is[E2s', 'off'),
	(141, 'auth_salt', 'g_<%G`4UVB$)B`,XP?>rXrRpE{g =BBH/QPRU+/o%!BJ?`kIv+%?s%#NTb;(!2[o', 'off'),
	(142, 'logged_in_key', 'l=Fr)&wdt1bfWRaGTiJ~^e8c2bz /!vPlfxIw-m##J_|n.c>4{~X|o2uy23plCf-', 'off'),
	(143, 'logged_in_salt', '@~.)i[w_!lSmV[=;JL3 6(Yx|zi~_7t_{]vW4P6a`_z]zM_ogJsZQSVb:Vmm~i^9', 'off'),
	(156, 'can_compress_scripts', '1', 'on'),
	(169, 'finished_updating_comment_type', '1', 'auto'),
	(170, 'current_theme', 'Maison', 'auto'),
	(171, 'theme_mods_maison_dune', 'a:3:{i:0;b:0;s:18:"nav_menu_locations";a:4:{s:14:"menu-izquierdo";i:0;s:12:"menu-derecho";i:0;s:9:"left-menu";i:3;s:10:"right-menu";i:4;}s:18:"custom_css_post_id";i:-1;}', 'on'),
	(172, 'theme_switched', '', 'auto'),
	(205, 'nav_menu_options', 'a:2:{i:0;b:0;s:8:"auto_add";a:0:{}}', 'off'),
	(218, '_transient_health-check-site-status-result', '{"good":17,"recommended":4,"critical":3}', 'on'),
	(293, '_site_transient_wp_plugin_dependencies_plugin_data', 'a:0:{}', 'off'),
	(294, 'recently_activated', 'a:0:{}', 'off'),
	(305, 'acf_first_activated_version', '6.7.0', 'on'),
	(306, 'acf_site_health', '{"version":"6.7.0","plugin_type":"Free","update_source":"wordpress.org","wp_version":"6.9.4","mysql_version":"8.4.3","is_multisite":false,"active_theme":{"name":"Maison","version":"","theme_uri":"","stylesheet":false},"active_plugins":{"advanced-custom-fields\\/acf.php":{"name":"Advanced Custom Fields","version":"6.7.0","plugin_uri":"https:\\/\\/www.advancedcustomfields.com"},"taxonomy-terms-order\\/taxonomy-terms-order.php":{"name":"Category Order and Taxonomy Terms Order","version":"1.9.3","plugin_uri":"http:\\/\\/www.nsp-code.com"},"maison-dune-contact\\/maison-dune-contact.php":{"name":"Maison Dune Contact","version":"2.1","plugin_uri":""},"maison-dune-table-book\\/maison-dune-table-book.php":{"name":"Maison Dune Reservations","version":"1.0","plugin_uri":""},"smart-custom-fields\\/smart-custom-fields.php":{"name":"Smart Custom Fields","version":"5.0.6","plugin_uri":"https:\\/\\/github.com\\/inc2734\\/smart-custom-fields\\/"}},"ui_field_groups":"2","php_field_groups":"0","json_field_groups":"0","rest_field_groups":"0","all_location_rules":["post_type==menu_dish","post_type==wine"],"number_of_fields_by_type":{"number":2},"number_of_third_party_fields_by_type":[],"post_types_enabled":true,"ui_post_types":"6","json_post_types":"0","ui_taxonomies":"5","json_taxonomies":"0","rest_api_format":"light","admin_ui_enabled":true,"field_type-modal_enabled":true,"field_settings_tabs_enabled":false,"shortcode_enabled":false,"registered_acf_forms":"0","json_save_paths":1,"json_load_paths":1,"event_first_activated":1771262070,"event_first_created_field_group":1771265968,"last_updated":1775579799}', 'off'),
	(308, 'acf_version', '6.7.0', 'auto'),
	(340, 'wine_type_children', 'a:0:{}', 'auto'),
	(380, 'menu_category_children', 'a:0:{}', 'auto'),
	(585, 'recovery_mode_email_last_sent', '1773335932', 'auto'),
	(1021, '_site_transient_timeout_theme_roots', '1775730873', 'off'),
	(1022, '_site_transient_theme_roots', 'a:2:{s:11:"maison_dune";s:7:"/themes";s:16:"twentytwentyfive";s:7:"/themes";}', 'off'),
	(1024, '_site_transient_update_core', 'O:8:"stdClass":4:{s:7:"updates";a:1:{i:0;O:8:"stdClass":10:{s:8:"response";s:6:"latest";s:8:"download";s:65:"https://downloads.wordpress.org/release/es_ES/wordpress-6.9.4.zip";s:6:"locale";s:5:"es_ES";s:8:"packages";O:8:"stdClass":5:{s:4:"full";s:65:"https://downloads.wordpress.org/release/es_ES/wordpress-6.9.4.zip";s:10:"no_content";s:0:"";s:11:"new_bundled";s:0:"";s:7:"partial";s:0:"";s:8:"rollback";s:0:"";}s:7:"current";s:5:"6.9.4";s:7:"version";s:5:"6.9.4";s:11:"php_version";s:6:"7.2.24";s:13:"mysql_version";s:5:"5.5.5";s:11:"new_bundled";s:3:"6.7";s:15:"partial_version";s:0:"";}}s:12:"last_checked";i:1775729080;s:15:"version_checked";s:5:"6.9.4";s:12:"translations";a:0:{}}', 'off'),
	(1025, '_site_transient_update_themes', 'O:8:"stdClass":5:{s:12:"last_checked";i:1775729081;s:7:"checked";a:2:{s:11:"maison_dune";s:0:"";s:16:"twentytwentyfive";s:3:"1.4";}s:8:"response";a:0:{}s:9:"no_update";a:1:{s:16:"twentytwentyfive";a:6:{s:5:"theme";s:16:"twentytwentyfive";s:11:"new_version";s:3:"1.4";s:3:"url";s:46:"https://wordpress.org/themes/twentytwentyfive/";s:7:"package";s:62:"https://downloads.wordpress.org/theme/twentytwentyfive.1.4.zip";s:8:"requires";s:3:"6.7";s:12:"requires_php";s:3:"7.2";}}s:12:"translations";a:0:{}}', 'off'),
	(1026, '_site_transient_update_plugins', 'O:8:"stdClass":5:{s:12:"last_checked";i:1775729082;s:8:"response";a:3:{s:30:"advanced-custom-fields/acf.php";O:8:"stdClass":13:{s:2:"id";s:36:"w.org/plugins/advanced-custom-fields";s:4:"slug";s:22:"advanced-custom-fields";s:6:"plugin";s:30:"advanced-custom-fields/acf.php";s:11:"new_version";s:5:"6.8.0";s:3:"url";s:53:"https://wordpress.org/plugins/advanced-custom-fields/";s:7:"package";s:71:"https://downloads.wordpress.org/plugin/advanced-custom-fields.6.8.0.zip";s:5:"icons";a:2:{s:2:"1x";s:67:"https://ps.w.org/advanced-custom-fields/assets/icon.svg?rev=3207824";s:3:"svg";s:67:"https://ps.w.org/advanced-custom-fields/assets/icon.svg?rev=3207824";}s:7:"banners";a:2:{s:2:"2x";s:78:"https://ps.w.org/advanced-custom-fields/assets/banner-1544x500.jpg?rev=3374528";s:2:"1x";s:77:"https://ps.w.org/advanced-custom-fields/assets/banner-772x250.jpg?rev=3374528";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"6.2";s:6:"tested";s:5:"6.9.4";s:12:"requires_php";s:3:"7.4";s:16:"requires_plugins";a:0:{}}s:45:"taxonomy-terms-order/taxonomy-terms-order.php";O:8:"stdClass":13:{s:2:"id";s:34:"w.org/plugins/taxonomy-terms-order";s:4:"slug";s:20:"taxonomy-terms-order";s:6:"plugin";s:45:"taxonomy-terms-order/taxonomy-terms-order.php";s:11:"new_version";s:5:"1.9.5";s:3:"url";s:51:"https://wordpress.org/plugins/taxonomy-terms-order/";s:7:"package";s:69:"https://downloads.wordpress.org/plugin/taxonomy-terms-order.1.9.5.zip";s:5:"icons";a:2:{s:2:"2x";s:73:"https://ps.w.org/taxonomy-terms-order/assets/icon-256x256.png?rev=1564412";s:2:"1x";s:73:"https://ps.w.org/taxonomy-terms-order/assets/icon-128x128.png?rev=1564412";}s:7:"banners";a:2:{s:2:"2x";s:76:"https://ps.w.org/taxonomy-terms-order/assets/banner-1544x500.png?rev=3300841";s:2:"1x";s:75:"https://ps.w.org/taxonomy-terms-order/assets/banner-772x250.png?rev=3300841";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"2.8";s:6:"tested";s:5:"6.9.4";s:12:"requires_php";b:0;s:16:"requires_plugins";a:0:{}}s:43:"smart-custom-fields/smart-custom-fields.php";O:8:"stdClass":13:{s:2:"id";s:33:"w.org/plugins/smart-custom-fields";s:4:"slug";s:19:"smart-custom-fields";s:6:"plugin";s:43:"smart-custom-fields/smart-custom-fields.php";s:11:"new_version";s:5:"5.0.7";s:3:"url";s:50:"https://wordpress.org/plugins/smart-custom-fields/";s:7:"package";s:68:"https://downloads.wordpress.org/plugin/smart-custom-fields.5.0.7.zip";s:5:"icons";a:1:{s:7:"default";s:70:"https://s.w.org/plugins/geopattern-icon/smart-custom-fields_043846.svg";}s:7:"banners";a:2:{s:2:"2x";s:75:"https://ps.w.org/smart-custom-fields/assets/banner-1544x500.png?rev=1799490";s:2:"1x";s:74:"https://ps.w.org/smart-custom-fields/assets/banner-772x250.png?rev=1799490";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"6.4";s:6:"tested";s:5:"6.8.5";s:12:"requires_php";s:3:"7.4";s:16:"requires_plugins";a:0:{}}}s:12:"translations";a:0:{}s:9:"no_update";a:1:{s:19:"akismet/akismet.php";O:8:"stdClass":10:{s:2:"id";s:21:"w.org/plugins/akismet";s:4:"slug";s:7:"akismet";s:6:"plugin";s:19:"akismet/akismet.php";s:11:"new_version";s:3:"5.6";s:3:"url";s:38:"https://wordpress.org/plugins/akismet/";s:7:"package";s:54:"https://downloads.wordpress.org/plugin/akismet.5.6.zip";s:5:"icons";a:2:{s:2:"2x";s:60:"https://ps.w.org/akismet/assets/icon-256x256.png?rev=2818463";s:2:"1x";s:60:"https://ps.w.org/akismet/assets/icon-128x128.png?rev=2818463";}s:7:"banners";a:2:{s:2:"2x";s:63:"https://ps.w.org/akismet/assets/banner-1544x500.png?rev=2900731";s:2:"1x";s:62:"https://ps.w.org/akismet/assets/banner-772x250.png?rev=2900731";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"5.8";}}s:7:"checked";a:6:{s:30:"advanced-custom-fields/acf.php";s:5:"6.7.0";s:19:"akismet/akismet.php";s:3:"5.6";s:45:"taxonomy-terms-order/taxonomy-terms-order.php";s:5:"1.9.3";s:43:"maison-dune-contact/maison-dune-contact.php";s:3:"2.1";s:49:"maison-dune-table-book/maison-dune-table-book.php";s:3:"1.0";s:43:"smart-custom-fields/smart-custom-fields.php";s:5:"5.0.6";}}', 'off'),
	(1030, '_site_transient_timeout_wp_theme_files_patterns-94231310a42add71a233fa91f027d92f', '1775751160', 'off'),
	(1031, '_site_transient_wp_theme_files_patterns-94231310a42add71a233fa91f027d92f', 'a:2:{s:7:"version";s:0:"";s:8:"patterns";a:0:{}}', 'off');

-- Volcando estructura para tabla maison.wp_postmeta
CREATE TABLE IF NOT EXISTS `wp_postmeta` (
  `meta_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB AUTO_INCREMENT=291 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Volcando datos para la tabla maison.wp_postmeta: ~249 rows (aproximadamente)
INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
	(2, 3, '_wp_page_template', 'page-privacy-policy.php'),
	(6, 3, '_edit_lock', '1773674718:1'),
	(7, 8, '_edit_lock', '1771346777:1'),
	(8, 10, '_edit_lock', '1770913062:1'),
	(9, 13, '_edit_lock', '1772562011:1'),
	(10, 15, '_edit_lock', '1770913177:1'),
	(11, 17, '_edit_lock', '1770913200:1'),
	(12, 19, '_menu_item_type', 'post_type'),
	(13, 19, '_menu_item_menu_item_parent', '0'),
	(14, 19, '_menu_item_object_id', '17'),
	(15, 19, '_menu_item_object', 'page'),
	(16, 19, '_menu_item_target', ''),
	(17, 19, '_menu_item_classes', 'a:1:{i:0;s:0:"";}'),
	(18, 19, '_menu_item_xfn', ''),
	(19, 19, '_menu_item_url', ''),
	(20, 19, '_menu_item_orphaned', '1770913430'),
	(21, 20, '_menu_item_type', 'post_type'),
	(22, 20, '_menu_item_menu_item_parent', '0'),
	(23, 20, '_menu_item_object_id', '15'),
	(24, 20, '_menu_item_object', 'page'),
	(25, 20, '_menu_item_target', ''),
	(26, 20, '_menu_item_classes', 'a:1:{i:0;s:0:"";}'),
	(27, 20, '_menu_item_xfn', ''),
	(28, 20, '_menu_item_url', ''),
	(29, 20, '_menu_item_orphaned', '1770913430'),
	(30, 21, '_menu_item_type', 'post_type'),
	(31, 21, '_menu_item_menu_item_parent', '0'),
	(32, 21, '_menu_item_object_id', '13'),
	(33, 21, '_menu_item_object', 'page'),
	(34, 21, '_menu_item_target', ''),
	(35, 21, '_menu_item_classes', 'a:1:{i:0;s:0:"";}'),
	(36, 21, '_menu_item_xfn', ''),
	(37, 21, '_menu_item_url', ''),
	(38, 21, '_menu_item_orphaned', '1770913430'),
	(39, 22, '_menu_item_type', 'post_type'),
	(40, 22, '_menu_item_menu_item_parent', '0'),
	(41, 22, '_menu_item_object_id', '10'),
	(42, 22, '_menu_item_object', 'page'),
	(43, 22, '_menu_item_target', ''),
	(44, 22, '_menu_item_classes', 'a:1:{i:0;s:0:"";}'),
	(45, 22, '_menu_item_xfn', ''),
	(46, 22, '_menu_item_url', ''),
	(47, 22, '_menu_item_orphaned', '1770913430'),
	(48, 23, '_menu_item_type', 'post_type'),
	(49, 23, '_menu_item_menu_item_parent', '0'),
	(50, 23, '_menu_item_object_id', '8'),
	(51, 23, '_menu_item_object', 'page'),
	(52, 23, '_menu_item_target', ''),
	(53, 23, '_menu_item_classes', 'a:1:{i:0;s:0:"";}'),
	(54, 23, '_menu_item_xfn', ''),
	(55, 23, '_menu_item_url', ''),
	(56, 23, '_menu_item_orphaned', '1770913430'),
	(57, 24, '_menu_item_type', 'post_type'),
	(58, 24, '_menu_item_menu_item_parent', '0'),
	(59, 24, '_menu_item_object_id', '13'),
	(60, 24, '_menu_item_object', 'page'),
	(61, 24, '_menu_item_target', ''),
	(62, 24, '_menu_item_classes', 'a:1:{i:0;s:0:"";}'),
	(63, 24, '_menu_item_xfn', ''),
	(64, 24, '_menu_item_url', ''),
	(66, 25, '_menu_item_type', 'post_type'),
	(67, 25, '_menu_item_menu_item_parent', '0'),
	(68, 25, '_menu_item_object_id', '10'),
	(69, 25, '_menu_item_object', 'page'),
	(70, 25, '_menu_item_target', ''),
	(71, 25, '_menu_item_classes', 'a:1:{i:0;s:0:"";}'),
	(72, 25, '_menu_item_xfn', ''),
	(73, 25, '_menu_item_url', ''),
	(75, 26, '_menu_item_type', 'post_type'),
	(76, 26, '_menu_item_menu_item_parent', '0'),
	(77, 26, '_menu_item_object_id', '17'),
	(78, 26, '_menu_item_object', 'page'),
	(79, 26, '_menu_item_target', ''),
	(80, 26, '_menu_item_classes', 'a:1:{i:0;s:0:"";}'),
	(81, 26, '_menu_item_xfn', ''),
	(82, 26, '_menu_item_url', ''),
	(84, 27, '_menu_item_type', 'post_type'),
	(85, 27, '_menu_item_menu_item_parent', '0'),
	(86, 27, '_menu_item_object_id', '15'),
	(87, 27, '_menu_item_object', 'page'),
	(88, 27, '_menu_item_target', ''),
	(89, 27, '_menu_item_classes', 'a:1:{i:0;s:0:"";}'),
	(90, 27, '_menu_item_xfn', ''),
	(91, 27, '_menu_item_url', ''),
	(98, 30, '_edit_last', '1'),
	(99, 30, '_edit_lock', '1771342578:1'),
	(100, 32, '_edit_last', '1'),
	(101, 32, '_edit_lock', '1771341364:1'),
	(103, 37, '_edit_lock', '1771267172:1'),
	(104, 37, '_edit_last', '1'),
	(105, 37, 'price', '45'),
	(106, 37, '_price', 'field_69935e85bc8a8'),
	(107, 37, 'region', 'Lebanon'),
	(108, 37, '_region', 'field_699361164df33'),
	(109, 38, '_edit_lock', '1771267298:1'),
	(110, 38, '_edit_last', '1'),
	(111, 38, 'price', '64'),
	(112, 38, '_price', 'field_69935e85bc8a8'),
	(113, 39, '_edit_lock', '1771267337:1'),
	(114, 39, '_edit_last', '1'),
	(115, 39, 'price', '60'),
	(116, 39, '_price', 'field_69935e85bc8a8'),
	(117, 40, '_edit_lock', '1771342083:1'),
	(118, 41, '_wp_attached_file', '2026/02/musar-blanc.png'),
	(119, 41, '_wp_attachment_metadata', 'a:6:{s:5:"width";i:450;s:6:"height";i:450;s:4:"file";s:23:"2026/02/musar-blanc.png";s:8:"filesize";i:60403;s:5:"sizes";a:2:{s:6:"medium";a:5:{s:4:"file";s:23:"musar-blanc-300x300.png";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:28832;}s:9:"thumbnail";a:5:{s:4:"file";s:23:"musar-blanc-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:8678;}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
	(120, 40, '_edit_last', '1'),
	(121, 43, '_edit_lock', '1771267800:1'),
	(122, 43, '_edit_last', '1'),
	(123, 43, 'price', '38'),
	(124, 43, '_price', 'field_69935e85bc8a8'),
	(125, 44, '_edit_lock', '1771268721:1'),
	(126, 44, '_edit_last', '1'),
	(127, 44, 'price', '65'),
	(128, 44, '_price', 'field_69935e85bc8a8'),
	(130, 45, '_wp_attached_file', '2026/02/musar-blanc-1.png'),
	(131, 45, '_wp_attachment_metadata', 'a:6:{s:5:"width";i:450;s:6:"height";i:450;s:4:"file";s:25:"2026/02/musar-blanc-1.png";s:8:"filesize";i:60403;s:5:"sizes";a:2:{s:6:"medium";a:5:{s:4:"file";s:25:"musar-blanc-1-300x300.png";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:28832;}s:9:"thumbnail";a:5:{s:4:"file";s:25:"musar-blanc-1-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:8678;}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
	(132, 40, '_thumbnail_id', '45'),
	(133, 40, 'wine_data', '50'),
	(134, 40, '_wine_data', 'field_69935fcabfc11'),
	(135, 40, 'year', '2016'),
	(136, 40, '_year', 'field_6993620465478'),
	(137, 40, 'price', '84'),
	(138, 40, '_price', 'field_69935fcabfc11'),
	(139, 46, '_edit_lock', '1771342164:1'),
	(140, 46, '_edit_last', '1'),
	(141, 46, 'price', '19'),
	(142, 46, '_price', 'field_69935e85bc8a8'),
	(143, 47, '_edit_lock', '1771342310:1'),
	(144, 47, '_edit_last', '1'),
	(145, 47, 'price', '54'),
	(146, 47, '_price', 'field_69935e85bc8a8'),
	(147, 48, '_edit_lock', '1771342374:1'),
	(148, 48, '_edit_last', '1'),
	(149, 48, 'price', '47'),
	(150, 48, '_price', 'field_69935e85bc8a8'),
	(151, 49, '_edit_lock', '1771342446:1'),
	(152, 49, '_edit_last', '1'),
	(153, 49, 'price', '48'),
	(154, 49, '_price', 'field_69935e85bc8a8'),
	(155, 50, '_edit_lock', '1771342516:1'),
	(156, 50, '_edit_last', '1'),
	(157, 50, 'price', '38'),
	(158, 50, '_price', 'field_69935e85bc8a8'),
	(159, 51, '_edit_lock', '1771342625:1'),
	(160, 51, '_edit_last', '1'),
	(161, 51, 'price', '45'),
	(162, 51, '_price', 'field_69935e85bc8a8'),
	(163, 52, '_edit_lock', '1771342681:1'),
	(164, 52, '_edit_last', '1'),
	(165, 52, 'price', '65'),
	(166, 52, '_price', 'field_69935e85bc8a8'),
	(167, 53, '_edit_lock', '1771342950:1'),
	(168, 53, '_edit_last', '1'),
	(169, 53, 'price', '48'),
	(170, 53, '_price', 'field_69935e85bc8a8'),
	(171, 54, '_edit_lock', '1771342986:1'),
	(172, 54, '_edit_last', '1'),
	(173, 54, 'price', '72'),
	(174, 54, '_price', 'field_69935e85bc8a8'),
	(175, 55, '_edit_lock', '1771343224:1'),
	(176, 55, '_edit_last', '1'),
	(177, 55, 'price', '32'),
	(178, 55, '_price', 'field_69935e85bc8a8'),
	(180, 57, '_edit_lock', '1771343326:1'),
	(181, 57, '_edit_last', '1'),
	(182, 57, 'price', '20'),
	(183, 57, '_price', 'field_69935e85bc8a8'),
	(184, 58, '_edit_lock', '1771343357:1'),
	(185, 58, '_edit_last', '1'),
	(186, 58, 'price', '18'),
	(187, 58, '_price', 'field_69935e85bc8a8'),
	(188, 59, '_edit_lock', '1771343446:1'),
	(189, 59, '_edit_last', '1'),
	(190, 59, 'price', '16'),
	(191, 59, '_price', 'field_69935e85bc8a8'),
	(192, 60, '_edit_lock', '1771343699:1'),
	(193, 61, '_wp_attached_file', '2026/02/bargylus.png'),
	(194, 61, '_wp_attachment_metadata', 'a:6:{s:5:"width";i:253;s:6:"height";i:954;s:4:"file";s:20:"2026/02/bargylus.png";s:8:"filesize";i:152697;s:5:"sizes";a:2:{s:6:"medium";a:5:{s:4:"file";s:19:"bargylus-80x300.png";s:5:"width";i:80;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:21718;}s:9:"thumbnail";a:5:{s:4:"file";s:20:"bargylus-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:18422;}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
	(195, 60, '_thumbnail_id', '61'),
	(196, 60, '_edit_last', '1'),
	(197, 60, 'price', '95'),
	(198, 60, '_price', 'field_69935fcabfc11'),
	(199, 62, '_edit_lock', '1771343824:1'),
	(200, 62, '_edit_last', '1'),
	(201, 62, 'price', '55'),
	(202, 62, '_price', 'field_69935fcabfc11'),
	(203, 63, '_wp_attached_file', '2026/02/altitudes.png'),
	(204, 63, '_wp_attachment_metadata', 'a:6:{s:5:"width";i:275;s:6:"height";i:907;s:4:"file";s:21:"2026/02/altitudes.png";s:8:"filesize";i:175123;s:5:"sizes";a:2:{s:6:"medium";a:5:{s:4:"file";s:20:"altitudes-91x300.png";s:5:"width";i:91;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:23832;}s:9:"thumbnail";a:5:{s:4:"file";s:21:"altitudes-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:19841;}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
	(205, 62, '_thumbnail_id', '63'),
	(213, 65, '_edit_lock', '1771344020:1'),
	(214, 65, '_edit_last', '1'),
	(215, 65, 'price', '110'),
	(216, 65, '_price', 'field_69935fcabfc11'),
	(217, 66, '_wp_attached_file', '2026/02/chateau-white.png'),
	(218, 66, '_wp_attachment_metadata', 'a:6:{s:5:"width";i:111;s:6:"height";i:433;s:4:"file";s:25:"2026/02/chateau-white.png";s:8:"filesize";i:58844;s:5:"sizes";a:2:{s:6:"medium";a:5:{s:4:"file";s:24:"chateau-white-77x300.png";s:5:"width";i:77;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:29730;}s:9:"thumbnail";a:5:{s:4:"file";s:25:"chateau-white-111x150.png";s:5:"width";i:111;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:21643;}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
	(219, 65, '_thumbnail_id', '66'),
	(220, 67, '_edit_lock', '1771344138:1'),
	(221, 68, '_wp_attached_file', '2026/02/lebnani.png'),
	(222, 68, '_wp_attachment_metadata', 'a:6:{s:5:"width";i:217;s:6:"height";i:681;s:4:"file";s:19:"2026/02/lebnani.png";s:8:"filesize";i:200454;s:5:"sizes";a:2:{s:6:"medium";a:5:{s:4:"file";s:18:"lebnani-96x300.png";s:5:"width";i:96;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:44081;}s:9:"thumbnail";a:5:{s:4:"file";s:19:"lebnani-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:38393;}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
	(223, 67, '_thumbnail_id', '68'),
	(224, 67, '_edit_last', '1'),
	(225, 67, 'price', '48'),
	(226, 67, '_price', 'field_69935fcabfc11'),
	(227, 69, '_edit_lock', '1771344248:1'),
	(228, 69, '_edit_last', '1'),
	(229, 69, 'price', '65'),
	(230, 69, '_price', 'field_69935fcabfc11'),
	(231, 70, '_wp_attached_file', '2026/02/cloudy.png'),
	(232, 70, '_wp_attachment_metadata', 'a:6:{s:5:"width";i:223;s:6:"height";i:650;s:4:"file";s:18:"2026/02/cloudy.png";s:8:"filesize";i:100846;s:5:"sizes";a:2:{s:6:"medium";a:5:{s:4:"file";s:18:"cloudy-103x300.png";s:5:"width";i:103;s:6:"height";i:300;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:23900;}s:9:"thumbnail";a:5:{s:4:"file";s:18:"cloudy-150x150.png";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:9:"image/png";s:8:"filesize";i:18381;}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
	(233, 69, '_thumbnail_id', '70'),
	(234, 71, '_edit_lock', '1771344334:1'),
	(235, 72, '_wp_attached_file', '2026/02/moroccan-tea.jpg'),
	(236, 72, '_wp_attachment_metadata', 'a:6:{s:5:"width";i:1024;s:6:"height";i:720;s:4:"file";s:24:"2026/02/moroccan-tea.jpg";s:8:"filesize";i:173860;s:5:"sizes";a:3:{s:6:"medium";a:5:{s:4:"file";s:24:"moroccan-tea-300x211.jpg";s:5:"width";i:300;s:6:"height";i:211;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:21272;}s:9:"thumbnail";a:5:{s:4:"file";s:24:"moroccan-tea-150x150.jpg";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:9876;}s:12:"medium_large";a:5:{s:4:"file";s:24:"moroccan-tea-768x540.jpg";s:5:"width";i:768;s:6:"height";i:540;s:9:"mime-type";s:10:"image/jpeg";s:8:"filesize";i:108016;}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
	(237, 71, '_thumbnail_id', '72'),
	(238, 71, '_edit_last', '1'),
	(239, 71, 'price', '12'),
	(240, 71, '_price', 'field_69935fcabfc11'),
	(241, 73, '_edit_lock', '1771344481:1'),
	(242, 74, '_wp_attached_file', '2026/02/mocktail.webp'),
	(243, 74, '_wp_attachment_metadata', 'a:6:{s:5:"width";i:2048;s:6:"height";i:2560;s:4:"file";s:21:"2026/02/mocktail.webp";s:8:"filesize";i:440080;s:5:"sizes";a:6:{s:6:"medium";a:5:{s:4:"file";s:21:"mocktail-240x300.webp";s:5:"width";i:240;s:6:"height";i:300;s:9:"mime-type";s:10:"image/webp";s:8:"filesize";i:23098;}s:5:"large";a:5:{s:4:"file";s:22:"mocktail-819x1024.webp";s:5:"width";i:819;s:6:"height";i:1024;s:9:"mime-type";s:10:"image/webp";s:8:"filesize";i:130726;}s:9:"thumbnail";a:5:{s:4:"file";s:21:"mocktail-150x150.webp";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/webp";s:8:"filesize";i:9394;}s:12:"medium_large";a:5:{s:4:"file";s:21:"mocktail-768x960.webp";s:5:"width";i:768;s:6:"height";i:960;s:9:"mime-type";s:10:"image/webp";s:8:"filesize";i:119460;}s:9:"1536x1536";a:5:{s:4:"file";s:23:"mocktail-1229x1536.webp";s:5:"width";i:1229;s:6:"height";i:1536;s:9:"mime-type";s:10:"image/webp";s:8:"filesize";i:213950;}s:9:"2048x2048";a:5:{s:4:"file";s:23:"mocktail-1638x2048.webp";s:5:"width";i:1638;s:6:"height";i:2048;s:9:"mime-type";s:10:"image/webp";s:8:"filesize";i:302224;}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
	(244, 73, '_thumbnail_id', '74'),
	(245, 73, '_edit_last', '1'),
	(246, 73, 'price', '14'),
	(247, 73, '_price', 'field_69935fcabfc11'),
	(248, 75, '_edit_lock', '1771346691:1'),
	(249, 75, '_edit_last', '1'),
	(250, 75, 'price', '10'),
	(251, 75, '_price', 'field_69935fcabfc11'),
	(252, 76, '_wp_attached_file', '2026/02/moroccan-tea.webp'),
	(253, 76, '_wp_attachment_metadata', 'a:6:{s:5:"width";i:426;s:6:"height";i:661;s:4:"file";s:25:"2026/02/moroccan-tea.webp";s:8:"filesize";i:55806;s:5:"sizes";a:2:{s:6:"medium";a:5:{s:4:"file";s:25:"moroccan-tea-193x300.webp";s:5:"width";i:193;s:6:"height";i:300;s:9:"mime-type";s:10:"image/webp";s:8:"filesize";i:13668;}s:9:"thumbnail";a:5:{s:4:"file";s:25:"moroccan-tea-150x150.webp";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/webp";s:8:"filesize";i:7758;}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}'),
	(254, 75, '_thumbnail_id', '76'),
	(277, 81, '_edit_lock', '1771862166:1'),
	(278, 81, '_wp_page_template', 'page-login.php'),
	(279, 83, '_edit_lock', '1771862483:1'),
	(280, 85, '_edit_lock', '1772035731:1'),
	(286, 91, '_edit_lock', '1773674752:1'),
	(287, 93, '_edit_lock', '1773675858:1'),
	(288, 96, '_wp_page_template', 'page-room-service.php'),
	(289, 98, '_edit_lock', '1775635921:1'),
	(290, 99, '_wp_page_template', 'page-my-reservations.php');

-- Volcando estructura para tabla maison.wp_posts
CREATE TABLE IF NOT EXISTS `wp_posts` (
  `ID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint unsigned NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_excerpt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'open',
  `post_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `post_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `to_ping` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `pinged` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_parent` bigint unsigned NOT NULL DEFAULT '0',
  `guid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `menu_order` int NOT NULL DEFAULT '0',
  `post_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_count` bigint NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `post_name` (`post_name`(191)),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  KEY `post_parent` (`post_parent`),
  KEY `post_author` (`post_author`),
  KEY `type_status_author` (`post_type`,`post_status`,`post_author`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Volcando datos para la tabla maison.wp_posts: ~76 rows (aproximadamente)
INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
	(1, 1, '2026-02-11 18:15:01', '2026-02-11 17:15:01', '<!-- wp:paragraph -->\n<p>Te damos la bienvenida a WordPress. Esta es tu primera entrada. Edítala o bórrala, ¡luego empieza a escribir!</p>\n<!-- /wp:paragraph -->', '¡Hola, mundo!', '', 'publish', 'open', 'open', '', 'hola-mundo', '', '', '2026-02-11 18:15:01', '2026-02-11 17:15:01', '', 0, 'http://maison.test/?p=1', 0, 'post', '', 1),
	(3, 1, '2026-02-11 18:15:01', '2026-02-11 17:15:01', '<!-- wp:heading -->\n<h2 class="wp-block-heading">Quiénes somos</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>La dirección de nuestra web es: http://maison.test.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Comentarios</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>Cuando los visitantes dejan comentarios en la web, recopilamos los datos que se muestran en el formulario de comentarios, así como la dirección IP del visitante y la cadena de agentes de usuario del navegador para ayudar a la detección de spam.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Una cadena anónima creada a partir de tu dirección de correo electrónico (también llamada hash) puede ser proporcionada al servicio de Gravatar para ver si la estás usando. La política de privacidad del servicio Gravatar está disponible aquí: https://automattic.com/privacy/. Después de la aprobación de tu comentario, la imagen de tu perfil es visible para el público en el contexto de tu comentario.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Medios</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>Si subes imágenes a la web, deberías evitar subir imágenes con datos de ubicación (GPS EXIF) incluidos. Los visitantes de la web pueden descargar y extraer cualquier dato de ubicación de las imágenes de la web.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Cookies</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>Si dejas un comentario en nuestro sitio puedes elegir guardar tu nombre, dirección de correo electrónico y web en cookies. Esto es para tu comodidad, para que no tengas que volver a rellenar tus datos cuando dejes otro comentario. Estas cookies tendrán una duración de un año.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Si tienes una cuenta y te conectas a este sitio, instalaremos una cookie temporal para determinar si tu navegador acepta cookies. Esta cookie no contiene datos personales y se elimina al cerrar el navegador.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Cuando accedas, también instalaremos varias cookies para guardar tu información de acceso y tus opciones de visualización de pantalla. Las cookies de acceso duran dos días, y las cookies de opciones de pantalla duran un año. Si seleccionas «Recuérdarme», tu acceso perdurará durante dos semanas. Si sales de tu cuenta, las cookies de acceso se eliminarán.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Si editas o publicas un artículo se guardará una cookie adicional en tu navegador. Esta cookie no incluye datos personales y simplemente indica el ID del artículo que acabas de editar. Caduca después de 1 día.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Contenido incrustado de otros sitios web</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>Los artículos de este sitio pueden incluir contenido incrustado (por ejemplo, vídeos, imágenes, artículos, etc.). El contenido incrustado de otras webs se comporta exactamente de la misma manera que si el visitante hubiera visitado la otra web.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Estas web pueden recopilar datos sobre ti, utilizar cookies, incrustar un seguimiento adicional de terceros, y supervisar tu interacción con ese contenido incrustado, incluido el seguimiento de tu interacción con el contenido incrustado si tienes una cuenta y estás conectado a esa web.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Con quién compartimos tus datos</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>Si solicitas un restablecimiento de contraseña, tu dirección IP será incluida en el correo electrónico de restablecimiento.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Cuánto tiempo conservamos tus datos</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>Si dejas un comentario, el comentario y sus metadatos se conservan indefinidamente. Esto es para que podamos reconocer y aprobar comentarios sucesivos automáticamente, en lugar de mantenerlos en una cola de moderación.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>De los usuarios que se registran en nuestra web (si los hay), también almacenamos la información personal que proporcionan en su perfil de usuario. Todos los usuarios pueden ver, editar o eliminar su información personal en cualquier momento (excepto que no pueden cambiar su nombre de usuario). Los administradores de la web también pueden ver y editar esa información.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Qué derechos tienes sobre tus datos</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>Si tienes una cuenta o has dejado comentarios en esta web, puedes solicitar recibir un archivo de exportación de los datos personales que tenemos sobre ti, incluyendo cualquier dato que nos hayas proporcionado. También puedes solicitar que eliminemos cualquier dato personal que tengamos sobre ti. Esto no incluye ningún dato que estemos obligados a conservar con fines administrativos, legales o de seguridad.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Dónde se envían tus datos</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>Los comentarios de los visitantes puede que los revise un servicio de detección automática de spam.</p>\n<!-- /wp:paragraph -->\n', 'Privacy Policy', '', 'publish', 'closed', 'open', '', 'privacy-policy', '', '', '2026-04-04 14:21:42', '2026-04-04 12:21:42', '', 0, 'http://maison.test/?page_id=3', 10, 'page', '', 0),
	(4, 0, '2026-02-11 18:15:10', '2026-02-11 17:15:10', '<!-- wp:page-list /-->', 'Navegación', '', 'publish', 'closed', 'closed', '', 'navigation', '', '', '2026-02-11 18:15:10', '2026-02-11 17:15:10', '', 0, 'http://maison.test/2026/02/11/navigation/', 0, 'wp_navigation', '', 0),
	(5, 0, '2026-02-11 18:15:10', '2026-02-11 17:15:10', '<!-- wp:page-list /-->', 'Navegación', '', 'publish', 'closed', 'closed', '', 'navigation', '', '', '2026-02-11 18:15:10', '2026-02-11 17:15:10', '', 0, 'http://maison.test/index.php/2026/02/11/navigation/', 0, 'wp_navigation', '', 0),
	(8, 1, '2026-02-12 17:17:27', '2026-02-12 16:17:27', '', 'Home', '', 'publish', 'closed', 'closed', '', 'home', '', '', '2026-02-12 17:17:27', '2026-02-12 16:17:27', '', 0, 'http://maison.test/?page_id=8', 0, 'page', '', 0),
	(9, 1, '2026-02-12 17:17:25', '2026-02-12 16:17:25', '', 'Home', '', 'inherit', 'closed', 'closed', '', '8-revision-v1', '', '', '2026-02-12 17:17:25', '2026-02-12 16:17:25', '', 8, 'http://maison.test/?p=9', 0, 'revision', '', 0),
	(10, 1, '2026-02-12 17:17:43', '2026-02-12 16:17:43', '', 'Restaurant', '', 'publish', 'closed', 'closed', '', 'restaurant', '', '', '2026-02-12 17:17:43', '2026-02-12 16:17:43', '', 0, 'http://maison.test/?page_id=10', 1, 'page', '', 0),
	(11, 1, '2026-02-12 17:17:41', '2026-02-12 16:17:41', '', 'Restaurant', '', 'inherit', 'closed', 'closed', '', '10-revision-v1', '', '', '2026-02-12 17:17:41', '2026-02-12 16:17:41', '', 10, 'http://maison.test/?p=11', 0, 'revision', '', 0),
	(12, 1, '2026-02-12 17:17:57', '2026-02-12 16:17:57', '<!-- wp:heading -->\n<h2 class="wp-block-heading">Quiénes somos</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>La dirección de nuestra web es: http://maison.test.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Comentarios</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>Cuando los visitantes dejan comentarios en la web, recopilamos los datos que se muestran en el formulario de comentarios, así como la dirección IP del visitante y la cadena de agentes de usuario del navegador para ayudar a la detección de spam.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Una cadena anónima creada a partir de tu dirección de correo electrónico (también llamada hash) puede ser proporcionada al servicio de Gravatar para ver si la estás usando. La política de privacidad del servicio Gravatar está disponible aquí: https://automattic.com/privacy/. Después de la aprobación de tu comentario, la imagen de tu perfil es visible para el público en el contexto de tu comentario.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Medios</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>Si subes imágenes a la web, deberías evitar subir imágenes con datos de ubicación (GPS EXIF) incluidos. Los visitantes de la web pueden descargar y extraer cualquier dato de ubicación de las imágenes de la web.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Cookies</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>Si dejas un comentario en nuestro sitio puedes elegir guardar tu nombre, dirección de correo electrónico y web en cookies. Esto es para tu comodidad, para que no tengas que volver a rellenar tus datos cuando dejes otro comentario. Estas cookies tendrán una duración de un año.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Si tienes una cuenta y te conectas a este sitio, instalaremos una cookie temporal para determinar si tu navegador acepta cookies. Esta cookie no contiene datos personales y se elimina al cerrar el navegador.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Cuando accedas, también instalaremos varias cookies para guardar tu información de acceso y tus opciones de visualización de pantalla. Las cookies de acceso duran dos días, y las cookies de opciones de pantalla duran un año. Si seleccionas «Recuérdarme», tu acceso perdurará durante dos semanas. Si sales de tu cuenta, las cookies de acceso se eliminarán.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Si editas o publicas un artículo se guardará una cookie adicional en tu navegador. Esta cookie no incluye datos personales y simplemente indica el ID del artículo que acabas de editar. Caduca después de 1 día.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Contenido incrustado de otros sitios web</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>Los artículos de este sitio pueden incluir contenido incrustado (por ejemplo, vídeos, imágenes, artículos, etc.). El contenido incrustado de otras webs se comporta exactamente de la misma manera que si el visitante hubiera visitado la otra web.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Estas web pueden recopilar datos sobre ti, utilizar cookies, incrustar un seguimiento adicional de terceros, y supervisar tu interacción con ese contenido incrustado, incluido el seguimiento de tu interacción con el contenido incrustado si tienes una cuenta y estás conectado a esa web.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Con quién compartimos tus datos</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>Si solicitas un restablecimiento de contraseña, tu dirección IP será incluida en el correo electrónico de restablecimiento.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Cuánto tiempo conservamos tus datos</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>Si dejas un comentario, el comentario y sus metadatos se conservan indefinidamente. Esto es para que podamos reconocer y aprobar comentarios sucesivos automáticamente, en lugar de mantenerlos en una cola de moderación.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>De los usuarios que se registran en nuestra web (si los hay), también almacenamos la información personal que proporcionan en su perfil de usuario. Todos los usuarios pueden ver, editar o eliminar su información personal en cualquier momento (excepto que no pueden cambiar su nombre de usuario). Los administradores de la web también pueden ver y editar esa información.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Qué derechos tienes sobre tus datos</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>Si tienes una cuenta o has dejado comentarios en esta web, puedes solicitar recibir un archivo de exportación de los datos personales que tenemos sobre ti, incluyendo cualquier dato que nos hayas proporcionado. También puedes solicitar que eliminemos cualquier dato personal que tengamos sobre ti. Esto no incluye ningún dato que estemos obligados a conservar con fines administrativos, legales o de seguridad.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Dónde se envían tus datos</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>Los comentarios de los visitantes puede que los revise un servicio de detección automática de spam.</p>\n<!-- /wp:paragraph -->\n', 'Política de privacidad', '', 'inherit', 'closed', 'closed', '', '3-revision-v1', '', '', '2026-02-12 17:17:57', '2026-02-12 16:17:57', '', 3, 'http://maison.test/?p=12', 0, 'revision', '', 0),
	(13, 1, '2026-02-12 17:19:22', '2026-02-12 16:19:22', '', 'Rooms &amp; Suites', '', 'publish', 'closed', 'closed', '', 'rooms-suites', '', '', '2026-02-12 17:19:22', '2026-02-12 16:19:22', '', 0, 'http://maison.test/?page_id=13', 2, 'page', '', 0),
	(14, 1, '2026-02-12 17:19:20', '2026-02-12 16:19:20', '', 'Rooms &amp; Suites', '', 'inherit', 'closed', 'closed', '', '13-revision-v1', '', '', '2026-02-12 17:19:20', '2026-02-12 16:19:20', '', 13, 'http://maison.test/?p=14', 0, 'revision', '', 0),
	(15, 1, '2026-02-12 17:19:44', '2026-02-12 16:19:44', '', 'Events', '', 'publish', 'closed', 'closed', '', 'events', '', '', '2026-02-12 17:19:44', '2026-02-12 16:19:44', '', 0, 'http://maison.test/?page_id=15', 3, 'page', '', 0),
	(16, 1, '2026-02-12 17:19:39', '2026-02-12 16:19:39', '', 'Events', '', 'inherit', 'closed', 'closed', '', '15-revision-v1', '', '', '2026-02-12 17:19:39', '2026-02-12 16:19:39', '', 15, 'http://maison.test/?p=16', 0, 'revision', '', 0),
	(17, 1, '2026-02-12 17:20:05', '2026-02-12 16:20:05', '', 'Contact', '', 'publish', 'closed', 'closed', '', 'contact', '', '', '2026-02-12 17:20:05', '2026-02-12 16:20:05', '', 0, 'http://maison.test/?page_id=17', 4, 'page', '', 0),
	(18, 1, '2026-02-12 17:20:03', '2026-02-12 16:20:03', '', 'Contact', '', 'inherit', 'closed', 'closed', '', '17-revision-v1', '', '', '2026-02-12 17:20:03', '2026-02-12 16:20:03', '', 17, 'http://maison.test/?p=18', 0, 'revision', '', 0),
	(19, 1, '2026-02-12 17:23:50', '0000-00-00 00:00:00', ' ', '', '', 'draft', 'closed', 'closed', '', '', '', '', '2026-02-12 17:23:50', '0000-00-00 00:00:00', '', 0, 'http://maison.test/?p=19', 1, 'nav_menu_item', '', 0),
	(20, 1, '2026-02-12 17:23:50', '0000-00-00 00:00:00', ' ', '', '', 'draft', 'closed', 'closed', '', '', '', '', '2026-02-12 17:23:50', '0000-00-00 00:00:00', '', 0, 'http://maison.test/?p=20', 1, 'nav_menu_item', '', 0),
	(21, 1, '2026-02-12 17:23:50', '0000-00-00 00:00:00', ' ', '', '', 'draft', 'closed', 'closed', '', '', '', '', '2026-02-12 17:23:50', '0000-00-00 00:00:00', '', 0, 'http://maison.test/?p=21', 1, 'nav_menu_item', '', 0),
	(22, 1, '2026-02-12 17:23:50', '0000-00-00 00:00:00', ' ', '', '', 'draft', 'closed', 'closed', '', '', '', '', '2026-02-12 17:23:50', '0000-00-00 00:00:00', '', 0, 'http://maison.test/?p=22', 1, 'nav_menu_item', '', 0),
	(23, 1, '2026-02-12 17:23:50', '0000-00-00 00:00:00', ' ', '', '', 'draft', 'closed', 'closed', '', '', '', '', '2026-02-12 17:23:50', '0000-00-00 00:00:00', '', 0, 'http://maison.test/?p=23', 1, 'nav_menu_item', '', 0),
	(24, 1, '2026-02-12 17:31:27', '2026-02-12 16:31:27', ' ', '', '', 'publish', 'closed', 'closed', '', '24', '', '', '2026-02-12 17:31:27', '2026-02-12 16:31:27', '', 0, 'http://maison.test/?p=24', 1, 'nav_menu_item', '', 0),
	(25, 1, '2026-02-12 17:31:27', '2026-02-12 16:31:27', ' ', '', '', 'publish', 'closed', 'closed', '', '25', '', '', '2026-02-12 17:31:27', '2026-02-12 16:31:27', '', 0, 'http://maison.test/?p=25', 2, 'nav_menu_item', '', 0),
	(26, 1, '2026-02-12 17:31:54', '2026-02-12 16:31:54', ' ', '', '', 'publish', 'closed', 'closed', '', '26', '', '', '2026-02-12 17:31:54', '2026-02-12 16:31:54', '', 0, 'http://maison.test/?p=26', 2, 'nav_menu_item', '', 0),
	(27, 1, '2026-02-12 17:31:54', '2026-02-12 16:31:54', ' ', '', '', 'publish', 'closed', 'closed', '', '27', '', '', '2026-02-12 17:31:54', '2026-02-12 16:31:54', '', 0, 'http://maison.test/?p=27', 1, 'nav_menu_item', '', 0),
	(30, 1, '2026-02-16 19:19:28', '2026-02-16 18:19:28', 'a:9:{s:8:"location";a:1:{i:0;a:1:{i:0;a:3:{s:5:"param";s:9:"post_type";s:8:"operator";s:2:"==";s:5:"value";s:9:"menu_dish";}}}s:8:"position";s:6:"normal";s:5:"style";s:7:"default";s:15:"label_placement";s:3:"top";s:21:"instruction_placement";s:5:"label";s:14:"hide_on_screen";s:0:"";s:11:"description";s:0:"";s:12:"show_in_rest";i:0;s:13:"display_title";s:0:"";}', 'Dish Data', 'dish-data', 'publish', 'closed', 'closed', '', 'group_69935e853c96c', '', '', '2026-02-16 19:39:52', '2026-02-16 18:39:52', '', 0, 'http://maison.test/?post_type=acf-field-group&#038;p=30', 0, 'acf-field-group', '', 0),
	(31, 1, '2026-02-16 19:19:28', '2026-02-16 18:19:28', 'a:14:{s:10:"aria-label";s:0:"";s:4:"type";s:6:"number";s:12:"instructions";s:35:"Enter the dish price (numbers only)";s:8:"required";i:1;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:3:"100";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:13:"default_value";s:0:"";s:3:"min";s:0:"";s:3:"max";s:0:"";s:17:"allow_in_bindings";i:0;s:11:"placeholder";i:45;s:4:"step";s:4:"0.01";s:7:"prepend";s:3:"€";s:6:"append";s:0:"";}', 'Price', 'price', 'publish', 'closed', 'closed', '', 'field_69935e85bc8a8', '', '', '2026-02-16 19:29:15', '2026-02-16 18:29:15', '', 30, 'http://maison.test/?post_type=acf-field&#038;p=31', 0, 'acf-field', '', 0),
	(32, 1, '2026-02-16 19:23:51', '2026-02-16 18:23:51', 'a:9:{s:8:"location";a:1:{i:0;a:1:{i:0;a:3:{s:5:"param";s:9:"post_type";s:8:"operator";s:2:"==";s:5:"value";s:4:"wine";}}}s:8:"position";s:6:"normal";s:5:"style";s:7:"default";s:15:"label_placement";s:3:"top";s:21:"instruction_placement";s:5:"label";s:14:"hide_on_screen";s:0:"";s:11:"description";s:0:"";s:12:"show_in_rest";i:0;s:13:"display_title";s:0:"";}', 'Wine Data', 'wine-data', 'publish', 'closed', 'closed', '', 'group_69935fca2bfa7', '', '', '2026-02-17 16:17:41', '2026-02-17 15:17:41', '', 0, 'http://maison.test/?post_type=acf-field-group&#038;p=32', 0, 'acf-field-group', '', 0),
	(33, 1, '2026-02-16 19:23:51', '2026-02-16 18:23:51', 'a:14:{s:10:"aria-label";s:0:"";s:4:"type";s:6:"number";s:12:"instructions";s:44:"Enter the wine price in euros (numbers only)";s:8:"required";i:1;s:17:"conditional_logic";i:0;s:7:"wrapper";a:3:{s:5:"width";s:3:"100";s:5:"class";s:0:"";s:2:"id";s:0:"";}s:13:"default_value";s:0:"";s:3:"min";s:0:"";s:3:"max";s:0:"";s:17:"allow_in_bindings";i:0;s:11:"placeholder";i:55;s:4:"step";s:4:"0.01";s:7:"prepend";s:3:"€";s:6:"append";s:0:"";}', 'Price', 'price', 'publish', 'closed', 'closed', '', 'field_69935fcabfc11', '', '', '2026-02-17 16:17:41', '2026-02-17 15:17:41', '', 32, 'http://maison.test/?post_type=acf-field&#038;p=33', 0, 'acf-field', '', 0),
	(37, 1, '2026-02-16 19:37:43', '2026-02-16 18:37:43', '<!-- wp:paragraph -->\n<p>Silky organic chickpeas blended with premium tahini, topped with shaved black winter truffle and extra virgin olive oil from Jordan.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p></p>\n<!-- /wp:paragraph -->', 'Royal Truffle Hummus', '', 'publish', 'closed', 'closed', '', 'royal-truffle-hummus', '', '', '2026-02-16 19:37:44', '2026-02-16 18:37:44', '', 0, 'http://maison.test/?post_type=menu_dish&#038;p=37', 0, 'menu_dish', '', 0),
	(38, 1, '2026-02-16 19:40:45', '2026-02-16 18:40:45', '<!-- wp:paragraph -->\n<p>Crispy bulgur shells filled with minced Wagyu beef A5, pine nuts, and seven spices.</p>\n<!-- /wp:paragraph -->', 'Wagyu Beef Kibbeh', '', 'publish', 'closed', 'closed', '', 'wagyu-beef-kibbeh', '', '', '2026-02-16 19:40:46', '2026-02-16 18:40:46', '', 0, 'http://maison.test/?post_type=menu_dish&#038;p=38', 0, 'menu_dish', '', 0),
	(39, 1, '2026-02-16 19:42:15', '2026-02-16 18:42:15', '<!-- wp:paragraph -->\n<p>French-trimmed lamb chops crusted with Aleppo pistachios, served with pomegranate reduction.</p>\n<!-- /wp:paragraph -->', 'Pistachio Crusted Lamb Chops', '', 'publish', 'closed', 'closed', '', 'pistachio-crusted-lamb-chops', '', '', '2026-02-16 19:42:16', '2026-02-16 18:42:16', '', 0, 'http://maison.test/?post_type=menu_dish&#038;p=39', 0, 'menu_dish', '', 0),
	(40, 1, '2026-02-16 19:45:27', '2026-02-16 18:45:27', '<!-- wp:paragraph -->\n<p>Bekaa Valley, Lebanon. A legendary vintage with notes of figs, plums, and cigar box. The most prestigious wine of the Levant.</p>\n<!-- /wp:paragraph -->', 'Château Musar 2016', '', 'publish', 'closed', 'closed', '', 'chateau-musar-2016', '', '', '2026-02-17 16:18:48', '2026-02-17 15:18:48', '', 0, 'http://maison.test/?post_type=wine&#038;p=40', 0, 'wine', '', 0),
	(41, 1, '2026-02-16 19:45:05', '2026-02-16 18:45:05', '', 'musar-blanc', '', 'inherit', 'open', 'closed', '', 'musar-blanc', '', '', '2026-02-16 19:45:05', '2026-02-16 18:45:05', '', 40, 'http://maison.test/wp-content/uploads/2026/02/musar-blanc.png', 0, 'attachment', 'image/png', 0),
	(43, 1, '2026-02-16 19:49:35', '2026-02-16 18:49:35', '<!-- wp:paragraph -->\n<p>Char-grilled eggplant pulp mashed with sesame paste, pomegranate seeds, and a mist of hickory smoke.</p>\n<!-- /wp:paragraph -->', 'Smoked Mutabal', '', 'publish', 'closed', 'closed', '', 'smoked-mutabal', '', '', '2026-02-16 19:49:36', '2026-02-16 18:49:36', '', 0, 'http://maison.test/?post_type=menu_dish&#038;p=43', 0, 'menu_dish', '', 0),
	(44, 1, '2026-02-16 19:51:01', '2026-02-16 18:51:01', '<!-- wp:paragraph -->\n<p>Vine leaves stuffed with rice, herbs, and lemon, slow-cooked in olive oil and finished with edible 24k gold dust.</p>\n<!-- /wp:paragraph -->', 'Waraq Enab with Gold Dust', '', 'publish', 'closed', 'closed', '', 'waraq-enab-with-gold-dust', '', '', '2026-02-16 19:51:02', '2026-02-16 18:51:02', '', 0, 'http://maison.test/?post_type=menu_dish&#038;p=44', 0, 'menu_dish', '', 0),
	(45, 1, '2026-02-17 16:11:09', '2026-02-17 15:11:09', '', 'musar-blanc', '', 'inherit', 'open', 'closed', '', 'musar-blanc-2', '', '', '2026-02-17 16:11:09', '2026-02-17 15:11:09', '', 40, 'http://maison.test/wp-content/uploads/2026/02/musar-blanc-1.png', 0, 'attachment', 'image/png', 0),
	(46, 1, '2026-02-17 16:29:00', '2026-02-17 15:29:00', '<!-- wp:paragraph -->\n<p>Roasted red pepper and walnut dip, spiced with cumin and pomegranate molasses, served with warm pita.</p>\n<!-- /wp:paragraph -->', 'Muhammara of Aleppo', '', 'publish', 'closed', 'closed', '', 'muhammara-of-aleppo', '', '', '2026-02-17 16:29:01', '2026-02-17 15:29:01', '', 0, 'http://maison.test/?post_type=menu_dish&#038;p=46', 0, 'menu_dish', '', 0),
	(47, 1, '2026-02-17 16:30:58', '2026-02-17 15:30:58', '<!-- wp:paragraph -->\n<p>Green herb and Iranian pistachio falafels, served on a bed of beetroot hummus and tahini foam.</p>\n<!-- /wp:paragraph -->', 'Emerald Pistachio Falafel', '', 'publish', 'closed', 'closed', '', 'emerald-pistachio-falafel', '', '', '2026-02-17 16:31:33', '2026-02-17 15:31:33', '', 0, 'http://maison.test/?post_type=menu_dish&#038;p=47', 0, 'menu_dish', '', 0),
	(48, 1, '2026-02-17 16:32:36', '2026-02-17 15:32:36', '<!-- wp:paragraph -->\n<p>Cypriot cheese grilled to golden perfection, served with caramelized fresh figs and wild honey.</p>\n<!-- /wp:paragraph -->', 'Grilled Halloumi with Figs', '', 'publish', 'closed', 'closed', '', 'grilled-halloumi-with-figs', '', '', '2026-02-17 16:32:37', '2026-02-17 15:32:37', '', 0, 'http://maison.test/?post_type=menu_dish&#038;p=48', 0, 'menu_dish', '', 0),
	(49, 1, '2026-02-17 16:33:25', '2026-02-17 15:33:25', '<!-- wp:paragraph -->\n<p>Tiger prawns sautéed with garlic, coriander, lemon juice, and a hint of chili.</p>\n<!-- /wp:paragraph -->', 'Shrimp Provençal', '', 'publish', 'closed', 'closed', '', 'shrimp-provencal', '', '', '2026-02-17 16:33:26', '2026-02-17 15:33:26', '', 0, 'http://maison.test/?post_type=menu_dish&#038;p=49', 0, 'menu_dish', '', 0),
	(50, 1, '2026-02-17 16:34:46', '2026-02-17 15:34:46', '<!-- wp:paragraph -->\n<p>A lavish platter of lamb chops, shish tawook, wagyu kafta, and beef tenderloin, served with garlic whip.</p>\n<!-- /wp:paragraph -->', 'Sultan\'s Mixed Grill', '', 'publish', 'closed', 'closed', '', 'sultans-mixed-grill', '', '', '2026-02-17 16:34:47', '2026-02-17 15:34:47', '', 0, 'http://maison.test/?post_type=menu_dish&#038;p=50', 0, 'menu_dish', '', 0),
	(51, 1, '2026-02-17 16:35:43', '2026-02-17 15:35:43', '<!-- wp:paragraph -->\n<p>Chicken breast skewers marinated in saffron yogurt and lemon for 24 hours, charcoal grilled.</p>\n<!-- /wp:paragraph -->', 'Shish Tawook Saffron', '', 'publish', 'closed', 'closed', '', 'shish-tawook-saffron', '', '', '2026-02-17 16:35:45', '2026-02-17 15:35:45', '', 0, 'http://maison.test/?post_type=menu_dish&#038;p=51', 0, 'menu_dish', '', 0),
	(52, 1, '2026-02-17 16:37:53', '2026-02-17 15:37:53', '<!-- wp:paragraph -->\n<p>The national dish of Jordan. Tender lamb cooked in fermented dried yogurt (jameed), served over turmeric rice and shrak bread.</p>\n<!-- /wp:paragraph -->', 'Imperial Mansaf', '', 'publish', 'closed', 'closed', '', 'imperial-mansaf', '', '', '2026-02-17 16:37:55', '2026-02-17 15:37:55', '', 0, 'http://maison.test/?post_type=menu_dish&#038;p=52', 0, 'menu_dish', '', 0),
	(53, 1, '2026-02-17 16:42:25', '2026-02-17 15:42:25', '<!-- wp:paragraph -->\n<p>Wild-caught seabass slow-cooked in a clay pot with chermoula, preserved lemons, and violet olives.</p>\n<!-- /wp:paragraph -->', 'Wild Seabass Tajine', '', 'publish', 'closed', 'closed', '', 'wild-seabass-tajine', '', '', '2026-02-17 16:42:27', '2026-02-17 15:42:27', '', 0, 'http://maison.test/?post_type=menu_dish&#038;p=53', 0, 'menu_dish', '', 0),
	(54, 1, '2026-02-17 16:43:03', '2026-02-17 15:43:03', '<!-- wp:paragraph -->\n<p>Bahraini spiced rice dish with Canadian lobster tail, dried limes, and aromatic spices.</p>\n<!-- /wp:paragraph -->', 'Lobster Machboos', '', 'publish', 'closed', 'closed', '', 'lobster-machboos', '', '', '2026-02-17 16:43:05', '2026-02-17 15:43:05', '', 0, 'http://maison.test/?post_type=menu_dish&#038;p=54', 0, 'menu_dish', '', 0),
	(55, 1, '2026-02-17 16:43:33', '2026-02-17 15:43:33', '<!-- wp:paragraph -->\n<p>Layers of eggplant, chickpeas, and tomatoes baked in an earthenware pot, topped with feta crumble.</p>\n<!-- /wp:paragraph -->', 'Vegetarian Moussaka', '', 'publish', 'closed', 'closed', '', 'vegetarian-moussaka', '', '', '2026-02-17 16:43:34', '2026-02-17 15:43:34', '', 0, 'http://maison.test/?post_type=menu_dish&#038;p=55', 0, 'menu_dish', '', 0),
	(57, 1, '2026-02-17 16:48:43', '2026-02-17 15:48:43', '<!-- wp:paragraph -->\n<p>Layers of delicate filo pastry filled with premium nuts, bathed in wild flower honey and rose water.</p>\n<!-- /wp:paragraph -->', 'Signature Baklava Tower', '', 'publish', 'closed', 'closed', '', 'signature-baklava-tower', '', '', '2026-02-17 16:48:44', '2026-02-17 15:48:44', '', 0, 'http://maison.test/?post_type=menu_dish&#038;p=57', 0, 'menu_dish', '', 0),
	(58, 1, '2026-02-17 16:49:15', '2026-02-17 15:49:15', '<!-- wp:paragraph -->\n<p>Stretchy Nablusi cheese topped with crispy kataifi dough and soaked in hot blossom syrup.</p>\n<!-- /wp:paragraph -->', 'Warm Nablusi Kunafa', '', 'publish', 'closed', 'closed', '', 'warm-nablusi-kunafa', '', '', '2026-02-17 16:49:16', '2026-02-17 15:49:16', '', 0, 'http://maison.test/?post_type=menu_dish&#038;p=58', 0, 'menu_dish', '', 0),
	(59, 1, '2026-02-17 16:50:09', '2026-02-17 15:50:09', '<!-- wp:paragraph -->\n<p>Sponge cake soaked in three kinds of milk infused with saffron, topped with chantilly cream.</p>\n<!-- /wp:paragraph -->', 'Saffron Milk Cake', '', 'publish', 'closed', 'closed', '', 'saffron-milk-cake', '', '', '2026-02-17 16:50:10', '2026-02-17 15:50:10', '', 0, 'http://maison.test/?post_type=menu_dish&#038;p=59', 0, 'menu_dish', '', 0),
	(60, 1, '2026-02-17 16:54:25', '2026-02-17 15:54:25', '<!-- wp:paragraph -->\n<p>Latakia, Syria. Known as "the most dangerous wine in the world." Intense, complex, with hints of truffle and black fruit.</p>\n<!-- /wp:paragraph -->', 'Domaine de Bargylus 2015', '', 'publish', 'closed', 'closed', '', 'domaine-de-bargylus-2015', '', '', '2026-02-17 16:54:45', '2026-02-17 15:54:45', '', 0, 'http://maison.test/?post_type=wine&#038;p=60', 0, 'wine', '', 0),
	(61, 1, '2026-02-17 16:54:20', '2026-02-17 15:54:20', '', 'bargylus', '', 'inherit', 'open', 'closed', '', 'bargylus', '', '', '2026-02-17 16:54:20', '2026-02-17 15:54:20', '', 60, 'http://maison.test/wp-content/uploads/2026/02/bargylus.png', 0, 'attachment', 'image/png', 0),
	(62, 1, '2026-02-17 16:55:35', '2026-02-17 15:55:35', '<!-- wp:paragraph -->\n<p>Batroun, Lebanon. A blend of Cabernet Sauvignon, Syrah, and Caladoc. Grown at 1,800m altitude, offering exceptional freshness.</p>\n<!-- /wp:paragraph -->', 'Ixsir Altitudes Red', '', 'publish', 'closed', 'closed', '', 'ixsir-altitudes-red', '', '', '2026-02-17 16:56:46', '2026-02-17 15:56:46', '', 0, 'http://maison.test/?post_type=wine&#038;p=62', 0, 'wine', '', 0),
	(63, 1, '2026-02-17 16:56:06', '2026-02-17 15:56:06', '', 'altitudes', '', 'inherit', 'open', 'closed', '', 'altitudes', '', '', '2026-02-17 16:56:06', '2026-02-17 15:56:06', '', 62, 'http://maison.test/wp-content/uploads/2026/02/altitudes.png', 0, 'attachment', 'image/png', 0),
	(65, 1, '2026-02-17 16:59:28', '2026-02-17 15:59:28', '<!-- wp:paragraph -->\n<p>Bekaa Valley, Lebanon. An oxidative style white made from ancient Obaideh and Merwah grapes. Honey, nuts, and dried apricot.</p>\n<!-- /wp:paragraph -->', 'Château Musar White 2012', '', 'publish', 'closed', 'closed', '', 'chateau-musar-white-2012', '', '', '2026-02-17 17:00:08', '2026-02-17 16:00:08', '', 0, 'http://maison.test/?post_type=wine&#038;p=65', 0, 'wine', '', 0),
	(66, 1, '2026-02-17 17:00:02', '2026-02-17 16:00:02', '', 'chateau-white', '', 'inherit', 'open', 'closed', '', 'chateau-white', '', '', '2026-02-17 17:00:02', '2026-02-17 16:00:02', '', 65, 'http://maison.test/wp-content/uploads/2026/02/chateau-white.png', 0, 'attachment', 'image/png', 0),
	(67, 1, '2026-02-17 17:01:09', '2026-02-17 16:01:09', '<!-- wp:paragraph -->\n<p>Qannboubine Valley, Lebanon. Unfiltered, organic white wine. Crisp, citrusy, with a touch of saline minerality.</p>\n<!-- /wp:paragraph -->', 'Mersel Lebnani Abyad', '', 'publish', 'closed', 'closed', '', 'mersel-lebnani-abyad', '', '', '2026-02-17 17:01:20', '2026-02-17 16:01:20', '', 0, 'http://maison.test/?post_type=wine&#038;p=67', 0, 'wine', '', 0),
	(68, 1, '2026-02-17 17:00:59', '2026-02-17 16:00:59', '', 'lebnani', '', 'inherit', 'open', 'closed', '', 'lebnani', '', '', '2026-02-17 17:00:59', '2026-02-17 16:00:59', '', 67, 'http://maison.test/wp-content/uploads/2026/02/lebnani.png', 0, 'attachment', 'image/png', 0),
	(69, 1, '2026-02-17 17:02:46', '2026-02-17 16:02:46', '<!-- wp:paragraph -->\n<p>Marlborough, New Zealand. Iconic notes of kaffir lime, passionfruit, and lemongrass. A perfect contrast to spicy mezze.</p>\n<!-- /wp:paragraph -->', 'Cloudy Bay Sauvignon Blanc', '', 'publish', 'closed', 'closed', '', 'cloudy-bay-sauvignon-blanc', '', '', '2026-02-17 17:03:12', '2026-02-17 16:03:12', '', 0, 'http://maison.test/?post_type=wine&#038;p=69', 0, 'wine', '', 0),
	(70, 1, '2026-02-17 17:03:07', '2026-02-17 16:03:07', '', 'cloudy', '', 'inherit', 'open', 'closed', '', 'cloudy', '', '', '2026-02-17 17:03:07', '2026-02-17 16:03:07', '', 69, 'http://maison.test/wp-content/uploads/2026/02/cloudy.png', 0, 'attachment', 'image/png', 0),
	(71, 1, '2026-02-17 17:04:59', '2026-02-17 16:04:59', '<!-- wp:paragraph -->\n<p>Gunpowder green tea with fresh organic mint and sugar, poured from a height for aeration.</p>\n<!-- /wp:paragraph -->', 'Ceremonial Moroccan Tea', '', 'publish', 'closed', 'closed', '', 'ceremonial-moroccan-tea', '', '', '2026-02-17 17:05:00', '2026-02-17 16:05:00', '', 0, 'http://maison.test/?post_type=wine&#038;p=71', 0, 'wine', '', 0),
	(72, 1, '2026-02-17 17:04:51', '2026-02-17 16:04:51', '', 'moroccan-tea', '', 'inherit', 'open', 'closed', '', 'moroccan-tea', '', '', '2026-02-17 17:04:51', '2026-02-17 16:04:51', '', 71, 'http://maison.test/wp-content/uploads/2026/02/moroccan-tea.jpg', 0, 'attachment', 'image/jpeg', 0),
	(73, 1, '2026-02-17 17:07:27', '2026-02-17 16:07:27', '<!-- wp:paragraph -->\n<p>Fresh pressed pomegranate juice, rose water, sparkling water, and crushed ice.</p>\n<!-- /wp:paragraph -->', 'Pomegranate &amp; Rose Mocktail', '', 'publish', 'closed', 'closed', '', 'pomegranate-rose-mocktail', '', '', '2026-02-17 17:07:29', '2026-02-17 16:07:29', '', 0, 'http://maison.test/?post_type=wine&#038;p=73', 0, 'wine', '', 0),
	(74, 1, '2026-02-17 17:07:15', '2026-02-17 16:07:15', '', 'mocktail', '', 'inherit', 'open', 'closed', '', 'mocktail', '', '', '2026-02-17 17:07:15', '2026-02-17 16:07:15', '', 73, 'http://maison.test/wp-content/uploads/2026/02/mocktail.webp', 0, 'attachment', 'image/webp', 0),
	(75, 1, '2026-02-17 17:08:48', '2026-02-17 16:08:48', '<!-- wp:paragraph -->\n<p>Traditional Qahwa brewed with roasted Arabica beans and green cardamom, served with premium dates.</p>\n<!-- /wp:paragraph -->', 'Cardamom Arabic Coffee', '', 'publish', 'closed', 'closed', '', 'cardamom-arabic-coffee', '', '', '2026-02-17 17:09:28', '2026-02-17 16:09:28', '', 0, 'http://maison.test/?post_type=wine&#038;p=75', 0, 'wine', '', 0),
	(76, 1, '2026-02-17 17:09:20', '2026-02-17 16:09:20', '', 'moroccan-tea', '', 'inherit', 'open', 'closed', '', 'moroccan-tea-2', '', '', '2026-02-17 17:09:20', '2026-02-17 16:09:20', '', 75, 'http://maison.test/wp-content/uploads/2026/02/moroccan-tea.webp', 0, 'attachment', 'image/webp', 0),
	(81, 1, '2026-02-23 16:22:31', '2026-02-23 15:22:31', '', 'Login', '', 'publish', 'closed', 'closed', '', 'login', '', '', '2026-02-23 16:22:31', '2026-02-23 15:22:31', '', 0, 'http://maison.test/?page_id=81', 5, 'page', '', 0),
	(82, 1, '2026-02-23 16:21:55', '2026-02-23 15:21:55', '', 'Login', '', 'inherit', 'closed', 'closed', '', '81-revision-v1', '', '', '2026-02-23 16:21:55', '2026-02-23 15:21:55', '', 81, 'http://maison.test/?p=82', 0, 'revision', '', 0),
	(83, 1, '2026-02-23 16:56:41', '2026-02-23 15:56:41', '', 'Register', '', 'publish', 'closed', 'closed', '', 'register', '', '', '2026-02-23 16:56:41', '2026-02-23 15:56:41', '', 0, 'http://maison.test/?page_id=83', 6, 'page', '', 0),
	(84, 1, '2026-02-23 16:56:35', '2026-02-23 15:56:35', '', 'Register', '', 'inherit', 'closed', 'closed', '', '83-revision-v1', '', '', '2026-02-23 16:56:35', '2026-02-23 15:56:35', '', 83, 'http://maison.test/?p=84', 0, 'revision', '', 0),
	(85, 1, '2026-02-25 17:08:54', '2026-02-25 16:08:54', '', 'Table', '', 'publish', 'closed', 'closed', '', 'table', '', '', '2026-02-25 17:08:54', '2026-02-25 16:08:54', '', 0, 'http://maison.test/?page_id=85', 7, 'page', '', 0),
	(86, 1, '2026-02-25 17:08:52', '2026-02-25 16:08:52', '', 'Table', '', 'inherit', 'closed', 'closed', '', '85-revision-v1', '', '', '2026-02-25 17:08:52', '2026-02-25 16:08:52', '', 85, 'http://maison.test/?p=86', 0, 'revision', '', 0),
	(91, 1, '2026-03-16 16:25:49', '2026-03-16 15:25:49', '', 'Forgot Password', '', 'publish', 'closed', 'closed', '', 'forgot-password', '', '', '2026-03-16 16:25:49', '2026-03-16 15:25:49', '', 0, 'http://maison.test/?page_id=91', 9, 'page', '', 0),
	(92, 1, '2026-03-16 16:25:46', '2026-03-16 15:25:46', '', 'Forgot Password', '', 'inherit', 'closed', 'closed', '', '91-revision-v1', '', '', '2026-03-16 16:25:46', '2026-03-16 15:25:46', '', 91, 'http://maison.test/?p=92', 0, 'revision', '', 0),
	(93, 1, '2026-03-16 16:26:45', '2026-03-16 15:26:45', '', 'Reset Password', '', 'publish', 'closed', 'closed', '', 'reset-password', '', '', '2026-03-16 16:27:02', '2026-03-16 15:27:02', '', 0, 'http://maison.test/?page_id=93', 9, 'page', '', 0),
	(94, 1, '2026-03-16 16:26:45', '2026-03-16 15:26:45', '', 'Reset Password', '', 'inherit', 'closed', 'closed', '', '93-revision-v1', '', '', '2026-03-16 16:26:45', '2026-03-16 15:26:45', '', 93, 'http://maison.test/?p=94', 0, 'revision', '', 0),
	(95, 0, '2026-04-04 14:21:42', '2026-04-04 12:21:42', '<!-- wp:heading -->\n<h2 class="wp-block-heading">Quiénes somos</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>La dirección de nuestra web es: http://maison.test.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Comentarios</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>Cuando los visitantes dejan comentarios en la web, recopilamos los datos que se muestran en el formulario de comentarios, así como la dirección IP del visitante y la cadena de agentes de usuario del navegador para ayudar a la detección de spam.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Una cadena anónima creada a partir de tu dirección de correo electrónico (también llamada hash) puede ser proporcionada al servicio de Gravatar para ver si la estás usando. La política de privacidad del servicio Gravatar está disponible aquí: https://automattic.com/privacy/. Después de la aprobación de tu comentario, la imagen de tu perfil es visible para el público en el contexto de tu comentario.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Medios</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>Si subes imágenes a la web, deberías evitar subir imágenes con datos de ubicación (GPS EXIF) incluidos. Los visitantes de la web pueden descargar y extraer cualquier dato de ubicación de las imágenes de la web.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Cookies</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>Si dejas un comentario en nuestro sitio puedes elegir guardar tu nombre, dirección de correo electrónico y web en cookies. Esto es para tu comodidad, para que no tengas que volver a rellenar tus datos cuando dejes otro comentario. Estas cookies tendrán una duración de un año.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Si tienes una cuenta y te conectas a este sitio, instalaremos una cookie temporal para determinar si tu navegador acepta cookies. Esta cookie no contiene datos personales y se elimina al cerrar el navegador.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Cuando accedas, también instalaremos varias cookies para guardar tu información de acceso y tus opciones de visualización de pantalla. Las cookies de acceso duran dos días, y las cookies de opciones de pantalla duran un año. Si seleccionas «Recuérdarme», tu acceso perdurará durante dos semanas. Si sales de tu cuenta, las cookies de acceso se eliminarán.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Si editas o publicas un artículo se guardará una cookie adicional en tu navegador. Esta cookie no incluye datos personales y simplemente indica el ID del artículo que acabas de editar. Caduca después de 1 día.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Contenido incrustado de otros sitios web</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>Los artículos de este sitio pueden incluir contenido incrustado (por ejemplo, vídeos, imágenes, artículos, etc.). El contenido incrustado de otras webs se comporta exactamente de la misma manera que si el visitante hubiera visitado la otra web.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Estas web pueden recopilar datos sobre ti, utilizar cookies, incrustar un seguimiento adicional de terceros, y supervisar tu interacción con ese contenido incrustado, incluido el seguimiento de tu interacción con el contenido incrustado si tienes una cuenta y estás conectado a esa web.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Con quién compartimos tus datos</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>Si solicitas un restablecimiento de contraseña, tu dirección IP será incluida en el correo electrónico de restablecimiento.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Cuánto tiempo conservamos tus datos</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>Si dejas un comentario, el comentario y sus metadatos se conservan indefinidamente. Esto es para que podamos reconocer y aprobar comentarios sucesivos automáticamente, en lugar de mantenerlos en una cola de moderación.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>De los usuarios que se registran en nuestra web (si los hay), también almacenamos la información personal que proporcionan en su perfil de usuario. Todos los usuarios pueden ver, editar o eliminar su información personal en cualquier momento (excepto que no pueden cambiar su nombre de usuario). Los administradores de la web también pueden ver y editar esa información.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Qué derechos tienes sobre tus datos</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>Si tienes una cuenta o has dejado comentarios en esta web, puedes solicitar recibir un archivo de exportación de los datos personales que tenemos sobre ti, incluyendo cualquier dato que nos hayas proporcionado. También puedes solicitar que eliminemos cualquier dato personal que tengamos sobre ti. Esto no incluye ningún dato que estemos obligados a conservar con fines administrativos, legales o de seguridad.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class="wp-block-heading">Dónde se envían tus datos</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class="privacy-policy-tutorial">Texto sugerido: </strong>Los comentarios de los visitantes puede que los revise un servicio de detección automática de spam.</p>\n<!-- /wp:paragraph -->\n', 'Privacy Policy', '', 'inherit', 'closed', 'closed', '', '3-revision-v1', '', '', '2026-04-04 14:21:42', '2026-04-04 12:21:42', '', 3, ':/?p=95', 0, 'revision', '', 0),
	(96, 0, '2026-04-04 14:21:43', '2026-04-04 12:21:43', '', 'Room Service', '', 'publish', 'closed', 'closed', '', 'room-service', '', '', '2026-04-04 14:21:43', '2026-04-04 12:21:43', '', 0, ':/room-service/', 8, 'page', '', 0),
	(97, 1, '2026-04-07 19:00:32', '0000-00-00 00:00:00', '', 'Borrador automático', '', 'auto-draft', 'open', 'open', '', '', '', '', '2026-04-07 19:00:32', '0000-00-00 00:00:00', '', 0, 'http://maison.test/?p=97', 0, 'post', '', 0),
	(98, 1, '2026-04-08 10:08:13', '0000-00-00 00:00:00', '', 'Borrador automático', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2026-04-08 10:08:13', '0000-00-00 00:00:00', '', 0, 'http://maison.test/?post_type=menu_dish&p=98', 0, 'menu_dish', '', 0),
	(99, 1, '2026-04-09 12:08:45', '2026-04-09 10:08:45', '', 'My Reservations', '', 'publish', 'closed', 'closed', '', 'my-reservations', '', '', '2026-04-09 12:08:45', '2026-04-09 10:08:45', '', 0, '', 0, 'page', '', 0);

-- Volcando estructura para tabla maison.wp_table_messages
CREATE TABLE IF NOT EXISTS `wp_table_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `last_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `guests` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `section` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Volcando datos para la tabla maison.wp_table_messages: ~3 rows (aproximadamente)
INSERT INTO `wp_table_messages` (`id`, `first_name`, `last_name`, `email`, `phone`, `date`, `time`, `guests`, `section`, `notes`, `created_at`) VALUES
	(1, 'Alejandro', 'Suárez Durán', 'asuadur14@gmail.com', '55629526', '2026-03-23', '16:58:00', '5', 'interior', 'ASS', '2026-03-04 16:30:57'),
	(2, 'Alejandro', 'Suárez Durán', 'asuadur14@gmail.com', '55629526', '2026-03-27', '19:42:00', '7+', 'private', '', '2026-03-04 19:39:06'),
	(4, 'Alejandro', 'Suárez Durán', 'asuadur14@gmail.com', '55629526', '2026-03-27', '12:31:00', '4', 'interior', 'Aceite', '2026-03-08 12:27:30');

-- Volcando estructura para tabla maison.wp_termmeta
CREATE TABLE IF NOT EXISTS `wp_termmeta` (
  `meta_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`meta_id`),
  KEY `term_id` (`term_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Volcando datos para la tabla maison.wp_termmeta: ~0 rows (aproximadamente)

-- Volcando estructura para tabla maison.wp_terms
CREATE TABLE IF NOT EXISTS `wp_terms` (
  `term_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `slug` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `term_group` bigint NOT NULL DEFAULT '0',
  `term_order` int DEFAULT '0',
  PRIMARY KEY (`term_id`),
  KEY `slug` (`slug`(191)),
  KEY `name` (`name`(191))
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Volcando datos para la tabla maison.wp_terms: ~11 rows (aproximadamente)
INSERT INTO `wp_terms` (`term_id`, `name`, `slug`, `term_group`, `term_order`) VALUES
	(1, 'Sin categoría', 'sin-categoria', 0, 0),
	(3, 'Left Nav', 'left-nav', 0, 0),
	(4, 'Right Nav', 'right-nav', 0, 0),
	(5, 'Cold Mezze', 'cold-mezze', 0, 1),
	(6, 'Hot Mezze', 'hot-mezze', 0, 2),
	(7, 'From The Grill', 'from-the-grill', 0, 3),
	(8, 'Main Course', 'main-course', 0, 4),
	(9, 'Desserts', 'desserts', 0, 5),
	(10, 'Red Wines', 'red-wines', 0, 0),
	(11, 'White Wines', 'white-wines', 0, 0),
	(12, 'Elixirs &amp; Tea', 'elixirs-tea', 0, 0);

-- Volcando estructura para tabla maison.wp_term_relationships
CREATE TABLE IF NOT EXISTS `wp_term_relationships` (
  `object_id` bigint unsigned NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint unsigned NOT NULL DEFAULT '0',
  `term_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Volcando datos para la tabla maison.wp_term_relationships: ~36 rows (aproximadamente)
INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
	(1, 1, 0),
	(24, 3, 0),
	(25, 3, 0),
	(26, 4, 0),
	(27, 4, 0),
	(37, 5, 0),
	(38, 6, 0),
	(39, 7, 0),
	(40, 10, 0),
	(43, 5, 0),
	(44, 5, 0),
	(46, 5, 0),
	(47, 6, 0),
	(48, 6, 0),
	(49, 6, 0),
	(50, 7, 0),
	(51, 7, 0),
	(52, 8, 0),
	(53, 8, 0),
	(54, 8, 0),
	(55, 8, 0),
	(57, 9, 0),
	(58, 9, 0),
	(59, 9, 0),
	(60, 10, 0),
	(62, 10, 0),
	(65, 11, 0),
	(67, 11, 0),
	(69, 11, 0),
	(71, 12, 0),
	(73, 12, 0),
	(75, 12, 0);

-- Volcando estructura para tabla maison.wp_term_taxonomy
CREATE TABLE IF NOT EXISTS `wp_term_taxonomy` (
  `term_taxonomy_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `parent` bigint unsigned NOT NULL DEFAULT '0',
  `count` bigint NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Volcando datos para la tabla maison.wp_term_taxonomy: ~11 rows (aproximadamente)
INSERT INTO `wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
	(1, 1, 'category', '', 0, 1),
	(3, 3, 'nav_menu', '', 0, 2),
	(4, 4, 'nav_menu', '', 0, 2),
	(5, 5, 'menu_category', '', 0, 4),
	(6, 6, 'menu_category', '', 0, 4),
	(7, 7, 'menu_category', '', 0, 3),
	(8, 8, 'menu_category', '', 0, 4),
	(9, 9, 'menu_category', '', 0, 3),
	(10, 10, 'wine_type', '', 0, 3),
	(11, 11, 'wine_type', '', 0, 3),
	(12, 12, 'wine_type', '', 0, 3);

-- Volcando estructura para tabla maison.wp_usermeta
CREATE TABLE IF NOT EXISTS `wp_usermeta` (
  `umeta_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Volcando datos para la tabla maison.wp_usermeta: ~29 rows (aproximadamente)
INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
	(1, 1, 'nickname', 'maison_user'),
	(2, 1, 'first_name', ''),
	(3, 1, 'last_name', ''),
	(4, 1, 'description', ''),
	(5, 1, 'rich_editing', 'true'),
	(6, 1, 'syntax_highlighting', 'true'),
	(7, 1, 'comment_shortcuts', 'false'),
	(8, 1, 'admin_color', 'fresh'),
	(9, 1, 'use_ssl', '0'),
	(10, 1, 'show_admin_bar_front', 'true'),
	(11, 1, 'locale', ''),
	(12, 1, 'wp_capabilities', 'a:1:{s:13:"administrator";b:1;}'),
	(13, 1, 'wp_user_level', '10'),
	(14, 1, 'dismissed_wp_pointers', ''),
	(15, 1, 'show_welcome_panel', '1'),
	(16, 1, 'session_tokens', 'a:2:{s:64:"c15997cc1472f7b95b30fb373a1dde54f1b38face74fc4ffda12b7be0602118e";a:4:{s:10:"expiration";i:1775754028;s:2:"ip";s:9:"127.0.0.1";s:2:"ua";s:111:"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36";s:5:"login";i:1775581228;}s:64:"34f5dcaba6802c81f5fbc2699173f72789cb92c2d3a981e9bca54d6341679005";a:4:{s:10:"expiration";i:1775804942;s:2:"ip";s:9:"127.0.0.1";s:2:"ua";s:111:"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36";s:5:"login";i:1775632142;}}'),
	(17, 1, 'wp_dashboard_quick_press_last_post_id', '97'),
	(18, 1, 'community-events-location', 'a:1:{s:2:"ip";s:9:"127.0.0.0";}'),
	(19, 1, 'wp_persisted_preferences', 'a:3:{s:4:"core";a:2:{s:26:"isComplementaryAreaVisible";b:1;s:10:"openPanels";a:3:{i:0;s:11:"post-status";i:1;s:24:"taxonomy-panel-wine_type";i:2;s:28:"taxonomy-panel-menu_category";}}s:14:"core/edit-post";a:2:{s:12:"welcomeGuide";b:0;s:19:"metaBoxesMainIsOpen";b:1;}s:9:"_modified";s:24:"2026-03-03T18:11:42.350Z";}'),
	(20, 1, 'managenav-menuscolumnshidden', 'a:5:{i:0;s:11:"link-target";i:1;s:11:"css-classes";i:2;s:3:"xfn";i:3;s:11:"description";i:4;s:15:"title-attribute";}'),
	(21, 1, 'metaboxhidden_nav-menus', 'a:1:{i:0;s:12:"add-post_tag";}'),
	(22, 1, 'nav_menu_recently_edited', '3'),
	(23, 1, 'meta-box-order_wine', 'a:4:{s:6:"normal";s:0:"";s:8:"advanced";s:0:"";s:4:"side";s:23:"acf-group_69935fca2bfa7";s:15:"acf_after_title";s:0:"";}'),
	(24, 1, 'wp_user-settings', 'libraryContent=browse'),
	(25, 1, 'wp_user-settings-time', '1771344004'),
	(26, 1, 'meta-box-order_menu_dish', 'a:4:{s:6:"normal";s:0:"";s:8:"advanced";s:0:"";s:4:"side";s:23:"acf-group_69935e853c96c";s:15:"acf_after_title";s:0:"";}'),
	(27, 1, 'manageedit-acf-post-typecolumnshidden', 'a:1:{i:0;s:7:"acf-key";}'),
	(28, 1, 'acf_user_settings', 'a:2:{s:19:"post-type-first-run";b:1;s:20:"taxonomies-first-run";b:1;}'),
	(29, 1, 'manageedit-acf-taxonomycolumnshidden', 'a:1:{i:0;s:7:"acf-key";}');

-- Volcando estructura para tabla maison.wp_users
CREATE TABLE IF NOT EXISTS `wp_users` (
  `ID` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_status` int NOT NULL DEFAULT '0',
  `display_name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`),
  KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Volcando datos para la tabla maison.wp_users: ~0 rows (aproximadamente)
INSERT INTO `wp_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES
	(1, 'maison_user', '$wp$2y$10$2qsgSlbguWUn7i0jW9eRpuGELUadfXdE8Qor8HaSfxh3cGzwpBAka', 'maison_user', 'asuadur14@gmail.com', 'http://maison.test', '2026-02-11 17:15:00', '', 0, 'maison_user');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
