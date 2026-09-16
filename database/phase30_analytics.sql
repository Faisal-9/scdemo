-- Phase 30: first-party public analytics
-- Stores page views and pseudonymous visitor identifiers only.

CREATE TABLE IF NOT EXISTS analytics_page_views (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  visitor_hash CHAR(64) NOT NULL,
  page_path VARCHAR(500) NOT NULL,
  page_key VARCHAR(100) NULL,
  page_title VARCHAR(255) NULL,
  referrer_host VARCHAR(255) NULL,
  device_type ENUM('desktop','mobile','tablet','unknown') NOT NULL DEFAULT 'unknown',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_analytics_created (created_at, id),
  KEY idx_analytics_visitor_created (visitor_hash, created_at),
  KEY idx_analytics_page_created (page_path(191), created_at),
  KEY idx_analytics_referrer_created (referrer_host, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO permissions (permission_key, permission_name, description)
SELECT 'manage_analytics', 'View Analytics', 'View public page views and visitor analytics.'
WHERE NOT EXISTS (
  SELECT 1 FROM permissions WHERE permission_key = 'manage_analytics'
);
