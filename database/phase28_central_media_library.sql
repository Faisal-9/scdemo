-- Phase 28 — Central Media Library + Picker
-- Non-destructive. Requires Phase 20 media_library.

ALTER TABLE media_library
  ADD COLUMN IF NOT EXISTS storage_scope VARCHAR(20) NOT NULL DEFAULT 'upload' AFTER category;

UPDATE media_library
SET storage_scope = CASE
  WHEN relative_path LIKE 'assets/uploads/%' THEN 'upload'
  ELSE 'legacy'
END;

CREATE INDEX idx_media_library_scope ON media_library (storage_scope);

-- Existing permission from Phase 20 is reused; no new permission is required.
-- Existing files under assets/images and assets/documents are registered from the admin UI
-- so that their references and physical paths remain unchanged.
