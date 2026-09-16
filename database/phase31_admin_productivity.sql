-- Phase 31: admin productivity, workflow, granular permissions, and media metadata

CREATE TABLE IF NOT EXISTS admin_notifications (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id INT UNSIGNED NULL,
  type VARCHAR(50) NOT NULL DEFAULT 'info',
  title VARCHAR(255) NOT NULL,
  message TEXT NULL,
  url VARCHAR(500) NULL,
  entity_type VARCHAR(100) NULL,
  entity_id BIGINT UNSIGNED NULL,
  is_read TINYINT(1) NOT NULL DEFAULT 0,
  read_at DATETIME NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_notifications_user_read (user_id, is_read, created_at),
  KEY idx_notifications_created (created_at),
  CONSTRAINT fk_notifications_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS content_revisions (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  entity_type VARCHAR(100) NOT NULL,
  entity_id BIGINT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NULL,
  status ENUM('draft','review','approved','published','archived') NOT NULL DEFAULT 'draft',
  snapshot_json LONGTEXT NOT NULL,
  note VARCHAR(500) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_revisions_entity (entity_type, entity_id, created_at),
  KEY idx_revisions_status (status, created_at),
  CONSTRAINT fk_revisions_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO permissions (permission_key, permission_name, description)
SELECT 'manage_notifications', 'Manage Notifications', 'View and manage admin notifications.'
WHERE NOT EXISTS (SELECT 1 FROM permissions WHERE permission_key='manage_notifications');
INSERT INTO permissions (permission_key, permission_name, description)
SELECT 'manage_revisions', 'Manage Revisions', 'View and restore content revisions.'
WHERE NOT EXISTS (SELECT 1 FROM permissions WHERE permission_key='manage_revisions');
INSERT INTO permissions (permission_key, permission_name, description)
SELECT 'search_content', 'Search Content', 'Search content available to the current user.'
WHERE NOT EXISTS (SELECT 1 FROM permissions WHERE permission_key='search_content');

INSERT INTO permissions (permission_key, permission_name, description)
SELECT 'view_projects', 'View Projects', 'View project records.'
WHERE NOT EXISTS (SELECT 1 FROM permissions WHERE permission_key='view_projects');
INSERT INTO permissions (permission_key, permission_name, description)
SELECT 'create_projects', 'Create Projects', 'Create project records.'
WHERE NOT EXISTS (SELECT 1 FROM permissions WHERE permission_key='create_projects');
INSERT INTO permissions (permission_key, permission_name, description)
SELECT 'edit_projects', 'Edit Projects', 'Edit project records.'
WHERE NOT EXISTS (SELECT 1 FROM permissions WHERE permission_key='edit_projects');
INSERT INTO permissions (permission_key, permission_name, description)
SELECT 'delete_projects', 'Delete Projects', 'Delete project records.'
WHERE NOT EXISTS (SELECT 1 FROM permissions WHERE permission_key='delete_projects');
INSERT INTO permissions (permission_key, permission_name, description)
SELECT 'publish_projects', 'Publish Projects', 'Publish or unpublish project records.'
WHERE NOT EXISTS (SELECT 1 FROM permissions WHERE permission_key='publish_projects');

SET @db := DATABASE();
SET @sql := (SELECT IF(EXISTS(SELECT 1 FROM information_schema.statistics WHERE table_schema=@db AND table_name='analytics_page_views' AND index_name='idx_analytics_device_created'),'SELECT 1','CREATE INDEX idx_analytics_device_created ON analytics_page_views (device_type, created_at)'));
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
SET @sql := (SELECT IF(EXISTS(SELECT 1 FROM information_schema.statistics WHERE table_schema=@db AND table_name='analytics_page_views' AND index_name='idx_analytics_key_created'),'SELECT 1','CREATE INDEX idx_analytics_key_created ON analytics_page_views (page_key, created_at)'));
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql := (SELECT IF(EXISTS(SELECT 1 FROM information_schema.columns WHERE table_schema=@db AND table_name='media_library' AND column_name='checksum'),'SELECT 1','ALTER TABLE media_library ADD COLUMN checksum CHAR(64) NULL AFTER file_size'));
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
SET @sql := (SELECT IF(EXISTS(SELECT 1 FROM information_schema.columns WHERE table_schema=@db AND table_name='media_library' AND column_name='width_px'),'SELECT 1','ALTER TABLE media_library ADD COLUMN width_px INT UNSIGNED NULL AFTER checksum'));
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
SET @sql := (SELECT IF(EXISTS(SELECT 1 FROM information_schema.columns WHERE table_schema=@db AND table_name='media_library' AND column_name='height_px'),'SELECT 1','ALTER TABLE media_library ADD COLUMN height_px INT UNSIGNED NULL AFTER width_px'));
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
SET @sql := (SELECT IF(EXISTS(SELECT 1 FROM information_schema.columns WHERE table_schema=@db AND table_name='media_library' AND column_name='status'),'SELECT 1','ALTER TABLE media_library ADD COLUMN status ENUM(\'active\',\'archived\') NOT NULL DEFAULT \'active\' AFTER category'));
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
SET @sql := (SELECT IF(EXISTS(SELECT 1 FROM information_schema.statistics WHERE table_schema=@db AND table_name='media_library' AND index_name='idx_media_library_checksum'),'SELECT 1','CREATE INDEX idx_media_library_checksum ON media_library (checksum)'));
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
