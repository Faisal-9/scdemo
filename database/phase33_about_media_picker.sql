-- Phase 33: normalize legacy About images for the media picker.
-- Run after the media_library table has been populated with existing assets.

ALTER TABLE about_sister_companies
  ADD COLUMN IF NOT EXISTS about_asset_id INT UNSIGNED NULL AFTER name;

UPDATE about_sister_companies s
INNER JOIN media_library m ON m.relative_path = s.logo_path
SET s.about_asset_id = m.id
WHERE s.logo_path IS NOT NULL AND s.logo_path <> '';

UPDATE about_sister_companies s
INNER JOIN media_library m
  ON LOWER(SUBSTRING_INDEX(m.relative_path, '/', -1)) = LOWER(SUBSTRING_INDEX(s.logo_path, '/', -1))
SET s.about_asset_id = m.id,
    s.logo_path = m.relative_path
WHERE s.about_asset_id IS NULL AND s.logo_path IS NOT NULL AND s.logo_path <> '';