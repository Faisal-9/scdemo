-- Phase 16: safe seed for global site settings.
-- Non-destructive. Existing values are preserved.

INSERT INTO site_settings
    (setting_key, setting_value, setting_type, description)
SELECT 'site_name', 'State Corps', 'text', 'Global website/company name'
WHERE NOT EXISTS (
    SELECT 1 FROM site_settings WHERE setting_key = 'site_name'
);

INSERT INTO site_settings
    (setting_key, setting_value, setting_type, description)
SELECT 'site_logo', 'assets/images/logo.png', 'image', 'Global website header logo path'
WHERE NOT EXISTS (
    SELECT 1 FROM site_settings WHERE setting_key = 'site_logo'
);

INSERT INTO site_settings
    (setting_key, setting_value, setting_type, description)
SELECT 'footer_logo', 'assets/images/footerlogo.png', 'image', 'Global footer logo path'
WHERE NOT EXISTS (
    SELECT 1 FROM site_settings WHERE setting_key = 'footer_logo'
);

INSERT INTO site_settings
    (setting_key, setting_value, setting_type, description)
SELECT 'company_profile_file', 'assets/documents/SCProfileLight.pdf', 'document', 'Company profile download path'
WHERE NOT EXISTS (
    SELECT 1 FROM site_settings WHERE setting_key = 'company_profile_file'
);

INSERT INTO site_settings
    (setting_key, setting_value, setting_type, description)
SELECT 'footer_copyright', 'State Corps', 'text', 'Global footer copyright owner text'
WHERE NOT EXISTS (
    SELECT 1 FROM site_settings WHERE setting_key = 'footer_copyright'
);
