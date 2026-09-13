-- Phase 19: Redirect management CMS foundation
-- Additive only. No existing public URL is changed because no redirect rows are seeded.

CREATE TABLE IF NOT EXISTS url_redirects (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  source_path VARCHAR(500) NOT NULL,
  destination_url VARCHAR(1000) NOT NULL,
  status_code SMALLINT UNSIGNED NOT NULL DEFAULT 301,
  preserve_query TINYINT(1) NOT NULL DEFAULT 0,
  note VARCHAR(255) DEFAULT NULL,
  sort_order INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_by INT UNSIGNED DEFAULT NULL,
  updated_by INT UNSIGNED DEFAULT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_url_redirect_source (source_path),
  KEY idx_url_redirect_active_sort (is_active, sort_order, id),
  CONSTRAINT fk_url_redirect_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_url_redirect_updated_by FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO permissions (permission_key, permission_name, description)
SELECT 'manage_redirects', 'Manage Redirects', 'Create and manage public URL redirects'
WHERE NOT EXISTS (SELECT 1 FROM permissions WHERE permission_key='manage_redirects');

-- No redirect rows are inserted intentionally.
