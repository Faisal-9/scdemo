-- Phase 18: SEO / page metadata CMS foundation
-- Additive only. Existing public markup/content is untouched.

CREATE TABLE IF NOT EXISTS page_seo (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  page_key VARCHAR(100) NOT NULL,
  page_name VARCHAR(150) NOT NULL,
  title VARCHAR(255) DEFAULT NULL,
  description VARCHAR(320) DEFAULT NULL,
  keywords VARCHAR(500) DEFAULT NULL,
  canonical_url VARCHAR(500) DEFAULT NULL,
  robots ENUM('index,follow','index,nofollow','noindex,follow','noindex,nofollow') NOT NULL DEFAULT 'index,follow',
  og_title VARCHAR(255) DEFAULT NULL,
  og_description VARCHAR(320) DEFAULT NULL,
  og_image VARCHAR(500) DEFAULT NULL,
  twitter_card ENUM('summary','summary_large_image','') NOT NULL DEFAULT 'summary_large_image',
  sort_order INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_by INT UNSIGNED DEFAULT NULL,
  updated_by INT UNSIGNED DEFAULT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_page_seo_key (page_key),
  KEY idx_page_seo_active_sort (is_active, sort_order, id),
  CONSTRAINT fk_page_seo_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_page_seo_updated_by FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO permissions (permission_key, permission_name, description)
SELECT 'manage_seo', 'Manage SEO', 'Manage page titles, descriptions and social metadata'
WHERE NOT EXISTS (SELECT 1 FROM permissions WHERE permission_key = 'manage_seo');

-- Safe page registry only; all metadata fields remain NULL so current titles/descriptions stay in control
-- until an administrator explicitly enters SEO values.
INSERT INTO page_seo (page_key, page_name, sort_order, is_active)
SELECT 'home', 'Homepage', 10, 1 WHERE NOT EXISTS (SELECT 1 FROM page_seo WHERE page_key='home');
INSERT INTO page_seo (page_key, page_name, sort_order, is_active)
SELECT 'about', 'About', 20, 1 WHERE NOT EXISTS (SELECT 1 FROM page_seo WHERE page_key='about');
INSERT INTO page_seo (page_key, page_name, sort_order, is_active)
SELECT 'projects', 'Projects', 30, 1 WHERE NOT EXISTS (SELECT 1 FROM page_seo WHERE page_key='projects');
INSERT INTO page_seo (page_key, page_name, sort_order, is_active)
SELECT 'project-details', 'Project Details', 35, 1 WHERE NOT EXISTS (SELECT 1 FROM page_seo WHERE page_key='project-details');
INSERT INTO page_seo (page_key, page_name, sort_order, is_active)
SELECT 'services', 'Services', 40, 1 WHERE NOT EXISTS (SELECT 1 FROM page_seo WHERE page_key='services');
INSERT INTO page_seo (page_key, page_name, sort_order, is_active)
SELECT 'sectors', 'Sectors', 50, 1 WHERE NOT EXISTS (SELECT 1 FROM page_seo WHERE page_key='sectors');
INSERT INTO page_seo (page_key, page_name, sort_order, is_active)
SELECT 'media', 'Media', 60, 1 WHERE NOT EXISTS (SELECT 1 FROM page_seo WHERE page_key='media');
INSERT INTO page_seo (page_key, page_name, sort_order, is_active)
SELECT 'contact', 'Contact', 70, 1 WHERE NOT EXISTS (SELECT 1 FROM page_seo WHERE page_key='contact');
INSERT INTO page_seo (page_key, page_name, sort_order, is_active)
SELECT 'policies', 'Policies', 80, 1 WHERE NOT EXISTS (SELECT 1 FROM page_seo WHERE page_key='policies');
INSERT INTO page_seo (page_key, page_name, sort_order, is_active)
SELECT 'terms-of-service', 'Terms of Service', 90, 1 WHERE NOT EXISTS (SELECT 1 FROM page_seo WHERE page_key='terms-of-service');
