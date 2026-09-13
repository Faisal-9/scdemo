-- Phase 22: Asset Reference Checker
-- Non-destructive. No CMS content is modified.
-- Reuses the existing manage_assets permission created in Phase 20.

SET @db := DATABASE();

SET @sql := (
    SELECT IF(
        EXISTS (
            SELECT 1 FROM information_schema.statistics
            WHERE table_schema=@db AND table_name='media_library' AND index_name='idx_media_library_relative_path'
        ),
        'SELECT 1',
        'CREATE INDEX idx_media_library_relative_path ON media_library (relative_path)'
    )
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql := (
    SELECT IF(
        EXISTS (
            SELECT 1 FROM information_schema.statistics
            WHERE table_schema=@db AND table_name='media_library' AND index_name='idx_media_library_mime'
        ),
        'SELECT 1',
        'CREATE INDEX idx_media_library_mime ON media_library (mime_type)'
    )
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
