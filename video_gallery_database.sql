-- Video Gallery Database Tables
-- Run this SQL in your database to create the video gallery tables

-- 1. Create video_gallery_categories table
CREATE TABLE IF NOT EXISTS `video_gallery_categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `thumbnail_path` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `video_gallery_categories_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Create video_galleries table
CREATE TABLE IF NOT EXISTS `video_galleries` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `video_path` varchar(255) DEFAULT NULL,
  `video_url` varchar(500) DEFAULT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `video_galleries_category_id_foreign` (`category_id`),
  CONSTRAINT `video_galleries_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `video_gallery_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

