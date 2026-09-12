-- State Corps Phase 11 repair
-- MariaDB 10.4+/MySQL-compatible SQL
-- In-place repair for databases where Phase 1 About tables already existed.
-- Does NOT drop tables or delete existing content.

SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
START TRANSACTION;

-- 1) Bring older About tables up to the Phase 11 manager contract.
SET @sql = IF(
    EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'about_core_values')
    AND NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'about_core_values' AND COLUMN_NAME = 'is_active'),
    'ALTER TABLE about_core_values ADD COLUMN is_active TINYINT(1) NOT NULL DEFAULT 1 AFTER sort_order',
    'SELECT 1'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql = IF(
    EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'about_core_values')
    AND NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'about_core_values' AND COLUMN_NAME = 'created_at'),
    'ALTER TABLE about_core_values ADD COLUMN created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
    'SELECT 1'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql = IF(
    EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'about_core_values')
    AND NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'about_core_values' AND COLUMN_NAME = 'updated_at'),
    'ALTER TABLE about_core_values ADD COLUMN updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
    'SELECT 1'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql = IF(
    EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'about_history')
    AND NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'about_history' AND COLUMN_NAME = 'is_active'),
    'ALTER TABLE about_history ADD COLUMN is_active TINYINT(1) NOT NULL DEFAULT 1 AFTER sort_order',
    'SELECT 1'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql = IF(
    EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'about_history')
    AND NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'about_history' AND COLUMN_NAME = 'created_at'),
    'ALTER TABLE about_history ADD COLUMN created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
    'SELECT 1'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql = IF(
    EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'about_history')
    AND NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'about_history' AND COLUMN_NAME = 'updated_at'),
    'ALTER TABLE about_history ADD COLUMN updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
    'SELECT 1'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Ensure existing records are active when the new flag was absent/null.
UPDATE about_core_values SET is_active = 1 WHERE is_active IS NULL;
UPDATE about_history SET is_active = 1 WHERE is_active IS NULL;

-- 2) Populate Phase 11 singleton tables from the already-populated about_page row.
INSERT INTO about_general (id, title, content)
SELECT 1, p.overview_title, p.overview_content
FROM about_page p
WHERE p.id = 1
  AND NOT EXISTS (SELECT 1 FROM about_general WHERE id = 1);

INSERT INTO about_mission_vision (id, title, mission, mission_img, vision, vision_img, core_values_img)
SELECT 1, p.mission_title, p.mission, COALESCE(p.mission_image, ''), p.vision,
       COALESCE(p.vision_image, ''), COALESCE(p.core_values_image, '')
FROM about_page p
WHERE p.id = 1
  AND NOT EXISTS (SELECT 1 FROM about_mission_vision WHERE id = 1);

INSERT INTO about_hse (id, title, content)
SELECT 1, p.hse_title, COALESCE(p.hse_content, '')
FROM about_page p
WHERE p.id = 1
  AND NOT EXISTS (SELECT 1 FROM about_hse WHERE id = 1);

INSERT INTO about_company_profile (id, title, content, link)
SELECT 1, p.company_profile_title, COALESCE(p.company_profile_content, ''), COALESCE(p.company_profile_file, '')
FROM about_page p
WHERE p.id = 1
  AND NOT EXISTS (SELECT 1 FROM about_company_profile WHERE id = 1);

-- 3) Populate the Phase 11 section registry from the current About page headings.
INSERT INTO about_sections (legacy_id, title, sort_order, is_active)
SELECT v.legacy_id, v.title, v.sort_order, 1
FROM (
    SELECT 'general-info' AS legacy_id, overview_title AS title, 0 AS sort_order FROM about_page WHERE id = 1
    UNION ALL SELECT 'mission-vision', mission_title, 1 FROM about_page WHERE id = 1
    UNION ALL SELECT 'clients', clients_title, 2 FROM about_page WHERE id = 1
    UNION ALL SELECT 'certificates', certificates_title, 3 FROM about_page WHERE id = 1
    UNION ALL SELECT 'awards', awards_title, 4 FROM about_page WHERE id = 1
    UNION ALL SELECT 'sister', affiliated_companies_title, 5 FROM about_page WHERE id = 1
    UNION ALL SELECT 'hse', hse_title, 6 FROM about_page WHERE id = 1
    UNION ALL SELECT 'cprofile', company_profile_title, 7 FROM about_page WHERE id = 1
) v
WHERE NOT EXISTS (SELECT 1 FROM about_sections);

-- 4) Move the existing six history records into the Phase 11 timeline table only when it is empty.
INSERT INTO about_timeline (id, year, title, description, image_path, sort_order, is_active)
SELECT h.id,
       h.year,
       h.title,
       COALESCE(h.description, ''),
       COALESCE(h.image_path, ''),
       h.sort_order,
       h.is_active
FROM about_history h
WHERE NOT EXISTS (SELECT 1 FROM about_timeline);

-- 5) Move the existing affiliated-company records into the Phase 11 sister-company table only when empty.
INSERT INTO about_sister_companies (id, name, logo_path, sort_order, is_active)
SELECT a.id, a.name, COALESCE(a.logo_path, ''), a.sort_order, a.is_active
FROM about_affiliated_companies a
WHERE NOT EXISTS (SELECT 1 FROM about_sister_companies);

COMMIT;
