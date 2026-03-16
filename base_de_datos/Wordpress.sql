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


-- Volcando estructura de base de datos para laravel_maison
CREATE DATABASE IF NOT EXISTS `laravel_maison` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `laravel_maison`;

-- Volcando estructura para tabla laravel_maison.contacts
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla laravel_maison.contacts: ~0 rows (aproximadamente)

-- Volcando estructura para tabla laravel_maison.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla laravel_maison.migrations: ~5 rows (aproximadamente)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '2026_03_08_135243_create_personal_access_tokens_table', 1),
	(3, '2026_03_12_170221_create_contact_table', 1),
	(4, '2026_03_14_184100_create_reservations_table', 1),
	(5, '2026_03_16_154301_create_password_reset_tokens_table', 2);

-- Volcando estructura para tabla laravel_maison.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla laravel_maison.password_reset_tokens: ~0 rows (aproximadamente)

-- Volcando estructura para tabla laravel_maison.personal_access_tokens
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla laravel_maison.personal_access_tokens: ~8 rows (aproximadamente)
INSERT INTO `personal_access_tokens` (`id`, `tokenable_id`, `tokenable_type`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
	(1, '1', 'App\\Models\\User', 'auth_token', '6ac5955172fdf2aa697b74be6d9f521bb89c96e942e49a444f02e8cd96571179', '["*"]', NULL, NULL, '2026-03-14 18:33:53', '2026-03-14 18:33:53'),
	(3, '1', 'App\\Models\\User', 'auth_token', 'f0bfafc582ed8e62fd6529f37cf5e1266513c20e18ae59b434cc302d1f6f94b7', '["*"]', '2026-03-14 18:34:41', NULL, '2026-03-14 18:34:40', '2026-03-14 18:34:41'),
	(4, '1', 'App\\Models\\User', 'auth_token', 'a762ceee29f5bcefa14555a2f30733dde5da29ec7710f5d226151edac51de6cb', '["*"]', '2026-03-14 18:34:45', NULL, '2026-03-14 18:34:44', '2026-03-14 18:34:45'),
	(12, '2', 'App\\Models\\User', 'auth_token', 'b8cec59d8bb26ce89345de01185e1f3f0129d6eb8b864fe597d176698f3a2b9a', '["*"]', NULL, NULL, '2026-03-15 08:49:00', '2026-03-15 08:49:00'),
	(14, '1', 'App\\Models\\User', 'auth_token', 'f41f6111d98e673a7298ba847067fd7644a20344a0b1c9db492ecac3f1cdaa88', '["*"]', '2026-03-15 09:05:35', NULL, '2026-03-15 09:05:34', '2026-03-15 09:05:35'),
	(15, '1', 'App\\Models\\User', 'auth_token', '2154e008c40b8ddde6b78ebea8c15767a6a23578d2518af21bb73efb53bcb8e5', '["*"]', '2026-03-15 09:06:37', NULL, '2026-03-15 09:06:37', '2026-03-15 09:06:37'),
	(16, '1', 'App\\Models\\User', 'auth_token', 'ca76e7d0730090221b30b926acf25ff1ed56684fe47988fe59c23bf6127b455b', '["*"]', '2026-03-15 09:06:46', NULL, '2026-03-15 09:06:46', '2026-03-15 09:06:46'),
	(17, '1', 'App\\Models\\User', 'auth_token', '209e5e463dbb855ce1bd57bcfbb6bd65da722de177f141caaa36ac06677f131d', '["*"]', '2026-03-15 09:06:48', NULL, '2026-03-15 09:06:48', '2026-03-15 09:06:48');

-- Volcando estructura para tabla laravel_maison.reservations
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
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reservations_user_id_foreign` (`user_id`),
  CONSTRAINT `reservations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla laravel_maison.reservations: ~2 rows (aproximadamente)
INSERT INTO `reservations` (`id`, `user_id`, `first_name`, `last_name`, `email`, `phone`, `date`, `time`, `guests`, `section`, `notes`, `created_at`, `updated_at`) VALUES
	(1, NULL, 'Alejandro', 'Suárez Durán', 'asuadur14@gmail.com', '55629526', '2026-03-25', '10:50:00', '4', 'interior', NULL, '2026-03-15 08:45:28', '2026-03-15 08:45:28'),
	(3, NULL, 'Alejandro', 'Suárez Durán', 'asuadur14@gmail.com', '55629526', '2026-03-25', '10:52:00', '2', 'terrace', 'a', '2026-03-15 08:49:51', '2026-03-15 08:49:51');

-- Volcando estructura para tabla laravel_maison.users
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

-- Volcando datos para la tabla laravel_maison.users: ~2 rows (aproximadamente)
INSERT INTO `users` (`id`, `name`, `email`, `password`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'AdminMaison', 'proyectomaison20@gmail.com', '$2y$12$a/2GpX860ysKncQ.zWHUUuYsQfiZ3TgW1.Mxe7KEOtifZrP2UxSHq', '2026-03-14 18:33:53', NULL, '2026-03-14 18:28:29', '2026-03-14 18:33:53'),
	(2, 'Alejandro', 'asuadur14@gmail.com', '$2y$12$4/LKLDRcGjlv7rjRBkAqJu2CkIjFFJlDcD5/ImjRt4M/u35LhbtWy', '2026-03-15 08:49:00', '8wimsOqtX9JXw2hYJDIhH7kWAsqSudOFR8B8UoW9TS2fwJVPwAzaXohxzgvZ', '2026-03-15 08:48:39', '2026-03-16 14:44:57');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
