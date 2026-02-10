CREATE TABLE `ierb_members` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name_affiliation` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `sort_order` int unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `ierb_activities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `topic` varchar(500) NOT NULL,
  `principal_investigator` varchar(255) NOT NULL,
  `activity_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
