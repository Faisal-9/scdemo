-- Phase 35: allow administrators to show or hide the public footer logo.
-- Idempotent default keeps the existing footer logo visible.

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'footer_logo_enabled', '1', 'boolean', 'Show the footer logo on public pages'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'footer_logo_enabled');