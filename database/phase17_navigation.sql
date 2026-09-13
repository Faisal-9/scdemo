-- Phase 17: Navigation CMS foundation
-- Additive migration only. No existing table is altered and no public content is replaced.

CREATE TABLE IF NOT EXISTS site_navigation (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  parent_id INT UNSIGNED DEFAULT NULL,
  location ENUM('header','footer') NOT NULL DEFAULT 'header',
  label VARCHAR(150) NOT NULL,
  url VARCHAR(500) NOT NULL DEFAULT '#',
  target ENUM('_self','_blank') NOT NULL DEFAULT '_self',
  icon_class VARCHAR(150) DEFAULT NULL,
  sort_order INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_by INT UNSIGNED DEFAULT NULL,
  updated_by INT UNSIGNED DEFAULT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_site_navigation_location_sort (location, sort_order, id),
  KEY idx_site_navigation_parent (parent_id),
  KEY idx_site_navigation_active (location, is_active),
  CONSTRAINT fk_site_navigation_parent FOREIGN KEY (parent_id) REFERENCES site_navigation(id) ON DELETE RESTRICT,
  CONSTRAINT fk_site_navigation_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_site_navigation_updated_by FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO permissions (permission_key, permission_name, description)
SELECT 'manage_navigation', 'Manage Navigation', 'Manage public header and footer navigation'
WHERE NOT EXISTS (
  SELECT 1 FROM permissions WHERE permission_key = 'manage_navigation'
);

-- Intentionally no navigation rows are seeded.
-- This prevents Phase 17 from guessing or changing the existing public menu.
