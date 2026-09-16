-- Phase 33: managed header colors and social media settings.
-- Idempotent defaults; administrators can edit every value from Admin > Settings.

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'social_facebook_url', 'https://www.facebook.com/StateCorpsInc/', 'url', 'Facebook profile URL'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key='social_facebook_url');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'social_x_url', 'https://x.com/StateCorps', 'url', 'X profile URL'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key='social_x_url');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'social_linkedin_url', 'https://www.linkedin.com/company/state-corps/', 'url', 'LinkedIn profile URL'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key='social_linkedin_url');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'header_top_background_color', '#ffffff', 'text', 'Upper header background color'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key='header_top_background_color');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'header_top_text_color', '#0c1c3d', 'text', 'Upper header text and icon color'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key='header_top_text_color');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'header_bottom_background_color', '#0c1c3d', 'text', 'Primary navigation background color'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key='header_bottom_background_color');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'header_bottom_text_color', '#ffffff', 'text', 'Primary navigation text color'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key='header_bottom_text_color');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'header_hover_color', '#d4af37', 'text', 'Header link hover and active color'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key='header_hover_color');

-- Repair installations where an earlier attempt stored these values with an unsupported type.
UPDATE site_settings
SET setting_type='text'
WHERE setting_key IN (
	'header_top_background_color',
	'header_top_text_color',
	'header_bottom_background_color',
	'header_bottom_text_color',
	'header_hover_color'
);
