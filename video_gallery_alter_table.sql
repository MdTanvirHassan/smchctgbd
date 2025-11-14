-- ALTER TABLE SQL for existing video_galleries table
-- Run this if you already have the video_galleries table and need to add the video_url column

-- Add video_url column to video_galleries table
ALTER TABLE `video_galleries` 
ADD COLUMN IF NOT EXISTS `video_url` varchar(500) DEFAULT NULL AFTER `video_path`;

-- Make video_path nullable if it's not already
ALTER TABLE `video_galleries` 
MODIFY COLUMN `video_path` varchar(255) DEFAULT NULL;

