-- SQL Script to Create MBBS Course Categories Table
-- This script creates a hierarchical category system with parent-child relationships

-- Create the table
CREATE TABLE IF NOT EXISTS `mbbs_course_categories` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `parent_id` BIGINT UNSIGNED NULL DEFAULT NULL,
  `description` TEXT NULL,
  `order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_parent_id` (`parent_id`),
  INDEX `idx_is_active` (`is_active`),
  INDEX `idx_order` (`order`),
  CONSTRAINT `fk_mbbs_course_categories_parent`
    FOREIGN KEY (`parent_id`)
    REFERENCES `mbbs_course_categories` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample data (optional - uncomment to insert)
-- INSERT INTO `mbbs_course_categories` (`name`, `slug`, `parent_id`, `description`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
-- ('First Year', 'first-year', NULL, 'First Year MBBS Course', 1, 1, NOW(), NOW()),
-- ('Second Year', 'second-year', NULL, 'Second Year MBBS Course', 2, 1, NOW(), NOW()),
-- ('Anatomy', 'anatomy', 1, 'Anatomy subject under First Year', 1, 1, NOW(), NOW()),
-- ('Physiology', 'physiology', 1, 'Physiology subject under First Year', 2, 1, NOW(), NOW()),
-- ('Biochemistry', 'biochemistry', 1, 'Biochemistry subject under First Year', 3, 1, NOW(), NOW());

-- Notes:
-- 1. The `parent_id` field allows for hierarchical structure
--    - NULL = Root category (parent category)
--    - Numeric ID = Child of that category
-- 2. The `order` field determines display order (lower numbers first)
-- 3. The `is_active` field controls visibility (1 = active, 0 = inactive)
-- 4. The foreign key constraint ensures referential integrity and cascades deletes
-- 5. If you delete a parent category, all child categories will be automatically deleted
-- 6. The `slug` must be unique for SEO-friendly URLs

