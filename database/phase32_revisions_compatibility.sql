-- Phase 32: upgrade legacy content_revisions tables used before version history metadata.

SET @db := DATABASE();

SET @sql := (SELECT IF(EXISTS(
    SELECT 1 FROM information_schema.columns
    WHERE table_schema=@db AND table_name='content_revisions' AND column_name='status'
), 'SELECT 1', "ALTER TABLE content_revisions ADD COLUMN status ENUM('draft','review','approved','published','archived') NOT NULL DEFAULT 'draft' AFTER entity_id"));
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql := (SELECT IF(EXISTS(
    SELECT 1 FROM information_schema.columns
    WHERE table_schema=@db AND table_name='content_revisions' AND column_name='snapshot_json'
), 'SELECT 1', 'ALTER TABLE content_revisions ADD COLUMN snapshot_json LONGTEXT NULL AFTER status'));
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql := (SELECT IF(EXISTS(
    SELECT 1 FROM information_schema.columns
    WHERE table_schema=@db AND table_name='content_revisions' AND column_name='revision_data'
), 'UPDATE content_revisions SET snapshot_json = revision_data WHERE snapshot_json IS NULL', 'SELECT 1'));
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

ALTER TABLE content_revisions MODIFY snapshot_json LONGTEXT NOT NULL;

SET @sql := (SELECT IF(EXISTS(
    SELECT 1 FROM information_schema.columns
    WHERE table_schema=@db AND table_name='content_revisions' AND column_name='note'
), 'SELECT 1', 'ALTER TABLE content_revisions ADD COLUMN note VARCHAR(500) NULL AFTER snapshot_json'));
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;