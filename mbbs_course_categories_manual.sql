-- ============================================
-- MBBS Course Categories Table - Manual SQL
-- ============================================
-- This SQL script creates the mbbs_course_categories table
-- with hierarchical parent-child category support
-- 
-- Usage: Copy and paste this entire script into phpMyAdmin,
-- MySQL Workbench, or any MySQL client and execute it.
-- ============================================

-- Drop table if exists (use only if you want to recreate the table)
-- DROP TABLE IF EXISTS `mbbs_course_categories`;

-- Create the mbbs_course_categories table
CREATE TABLE IF NOT EXISTS `mbbs_course_categories` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL COMMENT 'Category name',
  `slug` VARCHAR(255) NOT NULL COMMENT 'URL-friendly slug (unique)',
  `parent_id` BIGINT UNSIGNED NULL DEFAULT NULL COMMENT 'Parent category ID (NULL for root categories)',
  `description` TEXT NULL COMMENT 'Category description',
  `order` INT NOT NULL DEFAULT 0 COMMENT 'Display order (lower numbers appear first)',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1 = Active, 0 = Inactive',
  `created_at` TIMESTAMP NULL DEFAULT NULL COMMENT 'Record creation timestamp',
  `updated_at` TIMESTAMP NULL DEFAULT NULL COMMENT 'Record update timestamp',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mbbs_course_categories_slug_unique` (`slug`),
  KEY `idx_mbbs_course_categories_parent_id` (`parent_id`),
  KEY `idx_mbbs_course_categories_is_active` (`is_active`),
  KEY `idx_mbbs_course_categories_order` (`order`),
  CONSTRAINT `fk_mbbs_course_categories_parent`
    FOREIGN KEY (`parent_id`)
    REFERENCES `mbbs_course_categories` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Sample Data (Optional)
-- ============================================
-- Uncomment the lines below to insert sample data for testing

/*
-- Insert Parent Categories (Root Categories)
INSERT INTO `mbbs_course_categories` (`name`, `slug`, `parent_id`, `description`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
('First Year', 'first-year', NULL, 'First Year MBBS Course Categories', 1, 1, NOW(), NOW()),
('Second Year', 'second-year', NULL, 'Second Year MBBS Course Categories', 2, 1, NOW(), NOW()),
('Third Year', 'third-year', NULL, 'Third Year MBBS Course Categories', 3, 1, NOW(), NOW()),
('Fourth Year', 'fourth-year', NULL, 'Fourth Year MBBS Course Categories', 4, 1, NOW(), NOW());

-- Insert Child Categories (Under First Year)
INSERT INTO `mbbs_course_categories` (`name`, `slug`, `parent_id`, `description`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
('Anatomy', 'anatomy', 1, 'Anatomy subject under First Year', 1, 1, NOW(), NOW()),
('Physiology', 'physiology', 1, 'Physiology subject under First Year', 2, 1, NOW(), NOW()),
('Biochemistry', 'biochemistry', 1, 'Biochemistry subject under First Year', 3, 1, NOW(), NOW());

-- Insert Nested Child Categories (Example: Under Anatomy)
-- Note: Replace '1' with the actual ID of 'Anatomy' from above
-- INSERT INTO `mbbs_course_categories` (`name`, `slug`, `parent_id`, `description`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
-- ('Gross Anatomy', 'gross-anatomy', 5, 'Gross Anatomy under Anatomy', 1, 1, NOW(), NOW()),
-- ('Histology', 'histology', 5, 'Histology under Anatomy', 2, 1, NOW(), NOW()),
-- ('Embryology', 'embryology', 5, 'Embryology under Anatomy', 3, 1, NOW(), NOW());
*/

-- ============================================
-- Table Structure Notes:
-- ============================================
-- 1. parent_id = NULL means it's a root (parent) category
-- 2. parent_id = number means it's a child of that category ID
-- 3. You can create unlimited levels of nesting
-- 4. Order field determines display order (lower numbers first)
-- 5. is_active = 1 means category is active, 0 means inactive
-- 6. Foreign key constraint ensures:
--    - If you delete a parent category, all children are automatically deleted
--    - Referential integrity is maintained
-- 7. Slug must be unique (auto-generated from name in the application)
-- ============================================

-- Verify table creation
-- SELECT * FROM `mbbs_course_categories`;

