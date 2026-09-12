-- Phase 12: Media CMS safety patch.
-- The media tables already exist in the Phase 1/2 schema and are populated.
-- This script intentionally does NOT drop, recreate, or delete media content.

ALTER TABLE media_items
  MODIFY media_type ENUM('news','events','gallery') NOT NULL;

CREATE INDEX IF NOT EXISTS idx_media_items_public
  ON media_items (media_type, is_active, sort_order, media_date_sort);

CREATE INDEX IF NOT EXISTS idx_media_descriptions_item_order
  ON media_descriptions (media_item_id, sort_order);

CREATE INDEX IF NOT EXISTS idx_media_item_tags_item
  ON media_item_tags (media_item_id, tag_id);

CREATE INDEX IF NOT EXISTS idx_media_tags_name
  ON media_tags (tag_name);
