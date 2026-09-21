-- Phase 32: picker-selected media is stored by media_library numeric ID.
-- Run after media_library has been populated with legacy assets.

ALTER TABLE site_settings
  MODIFY setting_value TEXT NULL;

ALTER TABLE home_hero_slides ADD COLUMN IF NOT EXISTS hero_asset_id INT UNSIGNED NULL;
UPDATE home_hero_slides h INNER JOIN media_library m ON m.relative_path = h.image_path SET h.hero_asset_id = m.id WHERE h.image_path IS NOT NULL AND h.image_path <> '';
ALTER TABLE home_hero_slides DROP COLUMN IF EXISTS image_path;

ALTER TABLE home_why_tabs ADD COLUMN IF NOT EXISTS why_asset_id INT UNSIGNED NULL;
UPDATE home_why_tabs h INNER JOIN media_library m ON m.relative_path = h.image_path SET h.why_asset_id = m.id WHERE h.image_path IS NOT NULL AND h.image_path <> '';
ALTER TABLE home_why_tabs DROP COLUMN IF EXISTS image_path;

ALTER TABLE about_history ADD COLUMN IF NOT EXISTS timeline_asset_id INT UNSIGNED NULL;
UPDATE about_history h INNER JOIN media_library m ON m.relative_path=h.image_path SET h.timeline_asset_id=m.id WHERE h.image_path IS NOT NULL AND h.image_path<>'';
ALTER TABLE about_history DROP COLUMN IF EXISTS image_path;

ALTER TABLE about_timeline ADD COLUMN IF NOT EXISTS timeline_asset_id INT UNSIGNED NULL;
UPDATE about_timeline h INNER JOIN media_library m ON m.relative_path=h.image_path SET h.timeline_asset_id=m.id WHERE h.image_path IS NOT NULL AND h.image_path<>'';
ALTER TABLE about_timeline DROP COLUMN IF EXISTS image_path;
ALTER TABLE about_mission_vision ADD COLUMN IF NOT EXISTS mission_asset_id INT UNSIGNED NULL, ADD COLUMN IF NOT EXISTS vision_asset_id INT UNSIGNED NULL, ADD COLUMN IF NOT EXISTS core_values_asset_id INT UNSIGNED NULL;
UPDATE about_mission_vision a LEFT JOIN media_library m1 ON m1.relative_path=a.mission_img LEFT JOIN media_library m2 ON m2.relative_path=a.vision_img LEFT JOIN media_library m3 ON m3.relative_path=a.core_values_img SET a.mission_asset_id=m1.id,a.vision_asset_id=m2.id,a.core_values_asset_id=m3.id;
ALTER TABLE about_mission_vision DROP COLUMN IF EXISTS mission_img, DROP COLUMN IF EXISTS vision_img, DROP COLUMN IF EXISTS core_values_img;
ALTER TABLE about_company_profile ADD COLUMN IF NOT EXISTS profile_asset_id INT UNSIGNED NULL;
UPDATE about_company_profile a INNER JOIN media_library m ON m.relative_path=a.link SET a.profile_asset_id=m.id WHERE a.link IS NOT NULL AND a.link<>'';
ALTER TABLE about_company_profile DROP COLUMN IF EXISTS link;

ALTER TABLE about_clients ADD COLUMN IF NOT EXISTS about_asset_id INT UNSIGNED NULL;
UPDATE about_clients a INNER JOIN media_library m ON m.relative_path=a.logo_path SET a.about_asset_id=m.id WHERE a.logo_path IS NOT NULL AND a.logo_path<>'';
ALTER TABLE about_clients DROP COLUMN IF EXISTS logo_path;
ALTER TABLE about_certificates ADD COLUMN IF NOT EXISTS about_asset_id INT UNSIGNED NULL;
UPDATE about_certificates a INNER JOIN media_library m ON m.relative_path=a.logo_path SET a.about_asset_id=m.id WHERE a.logo_path IS NOT NULL AND a.logo_path<>'';
ALTER TABLE about_certificates DROP COLUMN IF EXISTS logo_path;
ALTER TABLE about_awards ADD COLUMN IF NOT EXISTS about_asset_id INT UNSIGNED NULL;
UPDATE about_awards a INNER JOIN media_library m ON m.relative_path=a.logo_path SET a.about_asset_id=m.id WHERE a.logo_path IS NOT NULL AND a.logo_path<>'';
ALTER TABLE about_awards DROP COLUMN IF EXISTS logo_path;
ALTER TABLE about_affiliated_companies ADD COLUMN IF NOT EXISTS about_asset_id INT UNSIGNED NULL;
UPDATE about_affiliated_companies a INNER JOIN media_library m ON m.relative_path=a.logo_path SET a.about_asset_id=m.id WHERE a.logo_path IS NOT NULL AND a.logo_path<>'';
ALTER TABLE about_affiliated_companies DROP COLUMN IF EXISTS logo_path;

ALTER TABLE projects ADD COLUMN IF NOT EXISTS thumbnail_asset_id INT UNSIGNED NULL;
UPDATE projects p INNER JOIN media_library m ON m.relative_path=p.thumbnail_path SET p.thumbnail_asset_id=m.id WHERE p.thumbnail_path IS NOT NULL AND p.thumbnail_path<>'';
ALTER TABLE projects DROP COLUMN IF EXISTS thumbnail_path;
ALTER TABLE project_images ADD COLUMN IF NOT EXISTS project_asset_id INT UNSIGNED NULL;
UPDATE project_images p INNER JOIN media_library m ON m.relative_path=p.image_path SET p.project_asset_id=m.id WHERE p.image_path IS NOT NULL AND p.image_path<>'';
ALTER TABLE project_images DROP COLUMN IF EXISTS image_path;

ALTER TABLE sectors ADD COLUMN IF NOT EXISTS hero_asset_id INT UNSIGNED NULL, ADD COLUMN IF NOT EXISTS featured_project_asset_id INT UNSIGNED NULL;
UPDATE sectors s LEFT JOIN media_library m1 ON m1.relative_path=s.hero_image LEFT JOIN media_library m2 ON m2.relative_path=s.featured_project_image SET s.hero_asset_id=m1.id,s.featured_project_asset_id=m2.id;
ALTER TABLE sectors DROP COLUMN IF EXISTS hero_image, DROP COLUMN IF EXISTS featured_project_image;
ALTER TABLE sector_section_images ADD COLUMN IF NOT EXISTS section_asset_id INT UNSIGNED NULL;
UPDATE sector_section_images s INNER JOIN media_library m ON m.relative_path=s.image_path SET s.section_asset_id=m.id WHERE s.image_path IS NOT NULL AND s.image_path<>'';
ALTER TABLE sector_section_images DROP COLUMN IF EXISTS image_path;

ALTER TABLE service_groups ADD COLUMN IF NOT EXISTS hero_asset_id INT UNSIGNED NULL;
UPDATE service_groups s INNER JOIN media_library m ON m.relative_path=s.hero_image SET s.hero_asset_id=m.id WHERE s.hero_image IS NOT NULL AND s.hero_image<>'';
ALTER TABLE service_groups DROP COLUMN IF EXISTS hero_image;
ALTER TABLE service_items ADD COLUMN IF NOT EXISTS service_asset_id INT UNSIGNED NULL;
UPDATE service_items s INNER JOIN media_library m ON m.relative_path=s.image_path SET s.service_asset_id=m.id WHERE s.image_path IS NOT NULL AND s.image_path<>'';
ALTER TABLE service_items DROP COLUMN IF EXISTS image_path;

ALTER TABLE media_items ADD COLUMN IF NOT EXISTS media_asset_id INT UNSIGNED NULL;
UPDATE media_items i INNER JOIN media_library m ON m.relative_path=i.image_path SET i.media_asset_id=m.id WHERE i.image_path IS NOT NULL AND i.image_path<>'';
ALTER TABLE media_items DROP COLUMN IF EXISTS image_path;

ALTER TABLE contact_qr_codes ADD COLUMN IF NOT EXISTS asset_id INT UNSIGNED NULL;
UPDATE contact_qr_codes q INNER JOIN media_library m ON m.relative_path=q.image_path SET q.asset_id=m.id WHERE q.image_path IS NOT NULL AND q.image_path<>'';
ALTER TABLE contact_qr_codes DROP COLUMN IF EXISTS image_path;

UPDATE site_settings s INNER JOIN media_library m ON m.relative_path=s.setting_value SET s.setting_value=CAST(m.id AS CHAR) WHERE s.setting_type IN ('image','document');
