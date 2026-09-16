-- Phase 34: restore managed footer labels and statement.
-- Idempotent defaults for installations missing the shared footer settings.

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'footer_statement', 'Building Infrastructure.\nEmpowering Communities.\nDriving Sustainable Growth.', 'textarea', 'Footer company statement'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key='footer_statement');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'footer_services_label', 'Services', 'text', 'Footer services heading'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key='footer_services_label');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'footer_company_label', 'Company', 'text', 'Footer company heading'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key='footer_company_label');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'footer_contact_label', 'Contact', 'text', 'Footer contact heading'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key='footer_contact_label');
