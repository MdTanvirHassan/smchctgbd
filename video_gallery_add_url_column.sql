-- SQL to add video_url column to existing video_galleries table
-- Run this if you already created the video_galleries table and need to add the video_url column

ALTER TABLE `video_galleries` 
ADD COLUMN `video_url` varchar(500) DEFAULT NULL AFTER `video_path`;

-- Make video_path nullable if it's not already
ALTER TABLE `video_galleries` 
MODIFY COLUMN `video_path` varchar(255) DEFAULT NULL;

