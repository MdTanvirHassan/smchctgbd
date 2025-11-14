-- ============================================
-- MBBS Course Categories Table - Updated SQL
-- ============================================
-- This SQL script creates the mbbs_course_categories table
-- with hierarchical parent-child category support
-- Support for adding parent categories with multiple child categories at once
-- ============================================

-- Drop table if exists (use only if you want to recreate the table)
-- DROP TABLE IF EXISTS `mbbs_course_categories`;

-- Create the mbbs_course_categories table
CREATE TABLE IF NOT EXISTS `mbbs_course_categories` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL COMMENT 'Category name',
  `slug` VARCHAR(255) NOT NULL COMMENT 'URL-friendly slug (unique)',
  `parent_id` BIGINT UNSIGNED NULL DEFAULT NULL COMMENT 'Parent category ID (NULL for root/parent categories)',
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
-- Sample Data Based on MBBS Professional Courses
-- ============================================
-- This inserts the structure shown in the image:
-- 1st Professional MBBS Course with 3 departments
-- 2nd Professional MBBS Course with 2 departments
-- 3rd Professional MBBS Course with 3 departments

-- Insert Parent Categories (Professional MBBS Courses)
INSERT INTO `mbbs_course_categories` (`name`, `slug`, `parent_id`, `description`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
('1st Professional MBBS Course', '1st-professional-mbbs-course', NULL, 'First Professional MBBS Course', 1, 1, NOW(), NOW()),
('2nd Professional MBBS Course', '2nd-professional-mbbs-course', NULL, 'Second Professional MBBS Course', 2, 1, NOW(), NOW()),
('3rd Professional MBBS Course', '3rd-professional-mbbs-course', NULL, 'Third Professional MBBS Course', 3, 1, NOW(), NOW());

-- Insert Child Categories for 1st Professional MBBS Course (parent_id = 1)
INSERT INTO `mbbs_course_categories` (`name`, `slug`, `parent_id`, `description`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
('Department of Anatomy', 'department-of-anatomy', 1, 'Department of Anatomy under 1st Professional MBBS Course', 1, 1, NOW(), NOW()),
('Department of Biochemistry', 'department-of-biochemistry', 1, 'Department of Biochemistry under 1st Professional MBBS Course', 2, 1, NOW(), NOW()),
('Department of Physiology', 'department-of-physiology', 1, 'Department of Physiology under 1st Professional MBBS Course', 3, 1, NOW(), NOW());

-- Insert Child Categories for 2nd Professional MBBS Course (parent_id = 2)
INSERT INTO `mbbs_course_categories` (`name`, `slug`, `parent_id`, `description`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
('Department of Forensic Medicine', 'department-of-forensic-medicine', 2, 'Department of Forensic Medicine under 2nd Professional MBBS Course', 1, 1, NOW(), NOW()),
('Department of Pharmacology', 'department-of-pharmacology', 2, 'Department of Pharmacology under 2nd Professional MBBS Course', 2, 1, NOW(), NOW());

-- Insert Child Categories for 3rd Professional MBBS Course (parent_id = 3)
INSERT INTO `mbbs_course_categories` (`name`, `slug`, `parent_id`, `description`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
('Department of Community Medicine', 'department-of-community-medicine', 3, 'Department of Community Medicine under 3rd Professional MBBS Course', 1, 1, NOW(), NOW()),
('Department of Microbiology', 'department-of-microbiology', 3, 'Department of Microbiology under 3rd Professional MBBS Course', 2, 1, NOW(), NOW()),
('Department of Pathology', 'department-of-pathology', 3, 'Department of Pathology under 3rd Professional MBBS Course', 3, 1, NOW(), NOW());

-- ============================================
-- Table Structure Notes:
-- ============================================
-- 1. parent_id = NULL means it's a root (parent) category (shown in BLUE)
-- 2. parent_id = number means it's a child/subcategory of that category ID
-- 3. You can create unlimited levels of nesting
-- 4. Order field determines display order (lower numbers appear first)
-- 5. is_active = 1 means category is active, 0 means inactive
-- 6. Foreign key constraint ensures:
--    - If you delete a parent category, all children are automatically deleted
--    - Referential integrity is maintained
-- 7. Slug must be unique (auto-generated from name in the application)
-- 8. Parent categories are displayed in blue color on the frontend
-- ============================================

-- Verify table creation and data
-- SELECT * FROM `mbbs_course_categories` ORDER BY `parent_id`, `order`;

