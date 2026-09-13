-- Phase 20: Asset Library
-- Additive only. No existing frontend asset references are changed.

CREATE TABLE IF NOT EXISTS media_library (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  original_name VARCHAR(255) NOT NULL,
  stored_name VARCHAR(255) NOT NULL,
  relative_path VARCHAR(500) NOT NULL,
  mime_type VARCHAR(100) NOT NULL,
  file_size BIGINT UNSIGNED NOT NULL,
  alt_text VARCHAR(500) DEFAULT NULL,
  category VARCHAR(80) DEFAULT NULL,
  created_by INT UNSIGNED DEFAULT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_media_library_path (relative_path),
  KEY idx_media_library_type (mime_type),
  KEY idx_media_library_category (category),
  KEY idx_media_library_created (created_at),
  CONSTRAINT fk_media_library_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO permissions (permission_key, permission_name, description)
SELECT 'manage_assets', 'Manage Assets', 'Upload and manage reusable website assets'
WHERE NOT EXISTS (SELECT 1 FROM permissions WHERE permission_key='manage_assets');

-- No existing assets are imported automatically. Existing assets remain untouched.
