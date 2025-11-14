-- ============================================
-- Check if MBBS Course Categories Table Exists
-- ============================================
-- Run this query first to check if the table exists

-- Check if table exists (MySQL)
SELECT COUNT(*) as table_exists
FROM information_schema.tables 
WHERE table_schema = DATABASE() 
AND table_name = 'mbbs_course_categories';

-- If the result is 0, the table doesn't exist. Run the CREATE TABLE command below.
-- ============================================

