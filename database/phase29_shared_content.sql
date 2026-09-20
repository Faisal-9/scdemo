-- Phase 29: shared public content CMS integration
-- Non-destructive seed. Existing settings/navigation rows are preserved.

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'site_description', 'Leading infrastructure company delivering 100+ projects valued at $600M+ for government and international partners since 2007', 'textarea', 'Default website description'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'site_description');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'site_author', 'State Corps Engineering', 'text', 'Default website author'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'site_author');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'footer_statement', 'Building Infrastructure.\nEmpowering Communities.\nDriving Sustainable Growth.', 'textarea', 'Footer company statement'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'footer_statement');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'social_linkedin_url', 'https://www.linkedin.com/company/state-corps/', 'url', 'LinkedIn profile URL'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'social_linkedin_url');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'social_facebook_url', 'https://www.facebook.com/StateCorpsInc/', 'url', 'Facebook profile URL'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'social_facebook_url');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'social_x_url', 'https://x.com/StateCorps', 'url', 'X profile URL'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'social_x_url');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'header_opportunities_label', 'Opportunities', 'text', 'Top navigation opportunities label'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'header_opportunities_label');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'header_contact_label', 'Contact Us', 'text', 'Top navigation contact label'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'header_contact_label');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'nav_home_label', 'Home', 'text', 'Main navigation home label'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'nav_home_label');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'nav_about_label', 'About', 'text', 'Main navigation about label'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'nav_about_label');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'nav_services_label', 'Services', 'text', 'Main navigation services label'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'nav_services_label');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'nav_expertise_label', 'Expertise', 'text', 'Main navigation expertise label'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'nav_expertise_label');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'nav_projects_label', 'Projects', 'text', 'Main navigation projects label'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'nav_projects_label');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'nav_media_label', 'Media', 'text', 'Main navigation media label'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'nav_media_label');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'footer_services_label', 'Services', 'text', 'Footer services heading'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'footer_services_label');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'footer_company_label', 'Company', 'text', 'Footer company heading'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'footer_company_label');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'footer_contact_label', 'Contact', 'text', 'Footer contact heading'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'footer_contact_label');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'about_mission_section_title', 'Mission, Vision & Core Values', 'text', 'About page mission and vision section heading'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'about_mission_section_title');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'about_mission_label', 'Our Mission', 'text', 'About page mission label'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'about_mission_label');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'about_vision_label', 'Our Vision', 'text', 'About page vision label'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'about_vision_label');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'about_core_values_label', 'Core Values', 'text', 'About page core values label'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'about_core_values_label');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'home_about_section_title', 'Why State Corps', 'text', 'Homepage about heading'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'home_about_section_title');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'home_services_section_title', 'Services', 'text', 'Homepage services section heading'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'home_services_section_title');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'home_explore_projects_label', 'Explore Projects', 'text', 'Homepage hero CTA label'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'home_explore_projects_label');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'home_read_more_label', 'Read More +', 'text', 'Homepage service card CTA label'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'home_read_more_label');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'sector_why_choose_title', 'Why Choose Us', 'text', 'Sector page why-choose heading'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'sector_why_choose_title');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'sector_areas_title', 'Areas of Expertise', 'text', 'Sector page expertise heading'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'sector_areas_title');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'service_features_label', 'Key Features', 'text', 'Service detail features heading'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'service_features_label');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'service_why_choose_template', 'Why Choose Our %s Service?', 'text', 'Service detail why-choose heading template with %s for the service title'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'service_why_choose_template');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'footer_policies_label', 'Policies', 'text', 'Footer policies link label'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'footer_policies_label');

INSERT INTO site_settings (setting_key, setting_value, setting_type, description)
SELECT 'footer_terms_label', 'Terms of Service', 'text', 'Footer terms link label'
WHERE NOT EXISTS (SELECT 1 FROM site_settings WHERE setting_key = 'footer_terms_label');

INSERT INTO site_navigation (location, label, url, sort_order, is_active)
SELECT 'footer', 'Engineering Services', 'services.php?tab=engineeringanddesign#engineeringanddesign-engineering-services', 10, 1
WHERE NOT EXISTS (SELECT 1 FROM site_navigation WHERE location='footer' AND url='services.php?tab=engineeringanddesign#engineeringanddesign-engineering-services');

INSERT INTO site_navigation (location, label, url, sort_order, is_active)
SELECT 'footer', 'Design Services', 'services.php?tab=engineeringanddesign#engineeringanddesign-design-services', 20, 1
WHERE NOT EXISTS (SELECT 1 FROM site_navigation WHERE location='footer' AND url='services.php?tab=engineeringanddesign#engineeringanddesign-design-services');

INSERT INTO site_navigation (location, label, url, sort_order, is_active)
SELECT 'footer', 'Mining Services', 'services.php?tab=mining', 30, 1
WHERE NOT EXISTS (SELECT 1 FROM site_navigation WHERE location='footer' AND url='services.php?tab=mining');

INSERT INTO site_navigation (location, label, url, sort_order, is_active)
SELECT 'footer', 'Project Management', 'services.php?tab=implementation#implementation-project-management', 40, 1
WHERE NOT EXISTS (SELECT 1 FROM site_navigation WHERE location='footer' AND url='services.php?tab=implementation#implementation-project-management');

INSERT INTO site_navigation (location, label, url, sort_order, is_active)
SELECT 'footer', 'EPC Solutions', 'services.php?tab=implementation', 50, 1
WHERE NOT EXISTS (SELECT 1 FROM site_navigation WHERE location='footer' AND url='services.php?tab=implementation');

INSERT INTO site_navigation (location, label, url, sort_order, is_active)
SELECT 'footer', 'Company Overview', 'about.php#general-info', 110, 1
WHERE NOT EXISTS (SELECT 1 FROM site_navigation WHERE location='footer' AND url='about.php#general-info');

INSERT INTO site_navigation (location, label, url, sort_order, is_active)
SELECT 'footer', 'Mission & Vision', 'about.php#mission-vision', 120, 1
WHERE NOT EXISTS (SELECT 1 FROM site_navigation WHERE location='footer' AND url='about.php#mission-vision');

INSERT INTO site_navigation (location, label, url, sort_order, is_active)
SELECT 'footer', 'Projects', 'projects.php', 130, 1
WHERE NOT EXISTS (SELECT 1 FROM site_navigation WHERE location='footer' AND url='projects.php');

INSERT INTO site_navigation (location, label, url, sort_order, is_active)
SELECT 'footer', 'Company Profile', 'about.php#cprofile', 140, 1
WHERE NOT EXISTS (SELECT 1 FROM site_navigation WHERE location='footer' AND url='about.php#cprofile');

INSERT INTO site_navigation (location, label, url, sort_order, is_active)
SELECT 'footer', 'Contact Us', 'contact.php', 150, 1
WHERE NOT EXISTS (SELECT 1 FROM site_navigation WHERE location='footer' AND url='contact.php');

INSERT INTO site_navigation (location, label, url, sort_order, is_active)
SELECT 'footer', 'Policies', 'policies.php', 210, 1
WHERE NOT EXISTS (SELECT 1 FROM site_navigation WHERE location='footer' AND url='policies.php');

INSERT INTO site_navigation (location, label, url, sort_order, is_active)
SELECT 'footer', 'Terms of Service', 'termsOfServices.php', 220, 1
WHERE NOT EXISTS (SELECT 1 FROM site_navigation WHERE location='footer' AND url='termsOfServices.php');

