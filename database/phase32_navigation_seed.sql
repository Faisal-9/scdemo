-- Phase 32: seed the managed public header and footer navigation.
-- Idempotent: existing administrator changes are preserved.

-- Header top-row links.
INSERT INTO site_navigation (location, label, url, sort_order, is_active)
SELECT 'header', 'Opportunities', 'opportunities.php', 10, 1
WHERE NOT EXISTS (SELECT 1 FROM site_navigation WHERE location='header' AND url='opportunities.php');
INSERT INTO site_navigation (location, label, url, sort_order, is_active)
SELECT 'header', 'Contact Us', 'contact.php', 20, 1
WHERE NOT EXISTS (SELECT 1 FROM site_navigation WHERE location='header' AND url='contact.php');

-- Header primary links.
INSERT INTO site_navigation (location, label, url, sort_order, is_active)
SELECT 'header', 'Home', 'index.php', 100, 1
WHERE NOT EXISTS (SELECT 1 FROM site_navigation WHERE location='header' AND url='index.php');
INSERT INTO site_navigation (location, label, url, sort_order, is_active)
SELECT 'header', 'About', 'about.php', 110, 1
WHERE NOT EXISTS (SELECT 1 FROM site_navigation WHERE location='header' AND url='about.php');
INSERT INTO site_navigation (location, label, url, sort_order, is_active)
SELECT 'header', 'Services', 'services.php', 120, 1
WHERE NOT EXISTS (SELECT 1 FROM site_navigation WHERE location='header' AND url='services.php');
INSERT INTO site_navigation (location, label, url, sort_order, is_active)
SELECT 'header', 'Expertise', 'sectors.php', 130, 1
WHERE NOT EXISTS (SELECT 1 FROM site_navigation WHERE location='header' AND url='sectors.php');
INSERT INTO site_navigation (location, label, url, sort_order, is_active)
SELECT 'header', 'Projects', 'projects.php', 140, 1
WHERE NOT EXISTS (SELECT 1 FROM site_navigation WHERE location='header' AND url='projects.php');
INSERT INTO site_navigation (location, label, url, sort_order, is_active)
SELECT 'header', 'Media', 'media.php', 150, 1
WHERE NOT EXISTS (SELECT 1 FROM site_navigation WHERE location='header' AND url='media.php');

-- About sections become managed children of About.
INSERT INTO site_navigation (parent_id, location, label, url, sort_order, is_active)
SELECT p.id, 'header', s.title, CONCAT('about.php#', s.legacy_id), 100 + s.sort_order, 1
FROM about_sections s
JOIN site_navigation p ON p.location='header' AND p.url='about.php'
WHERE s.is_active=1
  AND NOT EXISTS (SELECT 1 FROM site_navigation n WHERE n.location='header' AND n.url=CONCAT('about.php#', s.legacy_id));

-- Service groups and categories become managed children of Services.
INSERT INTO site_navigation (parent_id, location, label, url, sort_order, is_active)
SELECT p.id, 'header', g.title, CONCAT('services.php?tab=', g.service_key), 100 + g.sort_order, 1
FROM service_groups g
JOIN site_navigation p ON p.location='header' AND p.url='services.php'
WHERE g.is_active=1
  AND NOT EXISTS (SELECT 1 FROM site_navigation n WHERE n.location='header' AND n.url=CONCAT('services.php?tab=', g.service_key));

INSERT INTO site_navigation (parent_id, location, label, url, sort_order, is_active)
SELECT gnav.id, 'header', c.title,
       CONCAT('services.php?tab=', g.service_key, '#', g.service_key, '-', c.category_key),
       100 + c.sort_order, 1
FROM service_categories c
JOIN service_groups g ON g.id=c.group_id
JOIN site_navigation gnav ON gnav.location='header' AND gnav.url=CONCAT('services.php?tab=', g.service_key)
WHERE c.is_active=1
  AND NOT EXISTS (
    SELECT 1 FROM site_navigation n
    WHERE n.location='header'
      AND n.url=CONCAT('services.php?tab=', g.service_key, '#', g.service_key, '-', c.category_key)
  );

-- Sectors become managed children of Expertise.
INSERT INTO site_navigation (parent_id, location, label, url, sort_order, is_active)
SELECT p.id, 'header', s.title, CONCAT('sectors.php?tab=', s.sector_key), 100 + s.sort_order, 1
FROM sectors s
JOIN site_navigation p ON p.location='header' AND p.url='sectors.php'
WHERE s.is_active=1
  AND NOT EXISTS (SELECT 1 FROM site_navigation n WHERE n.location='header' AND n.url=CONCAT('sectors.php?tab=', s.sector_key));

-- Project filters become managed children of Projects.
INSERT INTO site_navigation (parent_id, location, label, url, sort_order, is_active)
SELECT p.id, 'header', 'All Projects', 'projects.php', 100, 1
FROM site_navigation p
WHERE p.location='header' AND p.url='projects.php'
  AND NOT EXISTS (SELECT 1 FROM site_navigation n WHERE n.location='header' AND n.url='projects.php' AND n.parent_id=p.id);
INSERT INTO site_navigation (parent_id, location, label, url, sort_order, is_active)
SELECT p.id, 'header', TRIM(pr.sector_name), CONCAT('projects.php?sector=', REPLACE(TRIM(pr.sector_name), ' ', '%20')), 110, 1
FROM (SELECT DISTINCT sector_name FROM projects WHERE published=1 AND TRIM(sector_name) <> '') pr
JOIN site_navigation p ON p.location='header' AND p.url='projects.php'
WHERE NOT EXISTS (
  SELECT 1 FROM site_navigation n
  WHERE n.location='header' AND n.url=CONCAT('projects.php?sector=', REPLACE(TRIM(pr.sector_name), ' ', '%20'))
);

-- Media tabs become managed children of Media.
INSERT INTO site_navigation (parent_id, location, label, url, sort_order, is_active)
SELECT p.id, 'header', 'News', 'media.php?tab=news', 100, 1
FROM site_navigation p
WHERE p.location='header' AND p.url='media.php'
  AND NOT EXISTS (SELECT 1 FROM site_navigation WHERE location='header' AND url='media.php?tab=news');
INSERT INTO site_navigation (parent_id, location, label, url, sort_order, is_active)
SELECT p.id, 'header', 'Events', 'media.php?tab=events', 110, 1
FROM site_navigation p
WHERE p.location='header' AND p.url='media.php'
  AND NOT EXISTS (SELECT 1 FROM site_navigation WHERE location='header' AND url='media.php?tab=events');
INSERT INTO site_navigation (parent_id, location, label, url, sort_order, is_active)
SELECT p.id, 'header', 'Gallery', 'media.php?tab=gallery', 120, 1
FROM site_navigation p
WHERE p.location='header' AND p.url='media.php'
  AND NOT EXISTS (SELECT 1 FROM site_navigation WHERE location='header' AND url='media.php?tab=gallery');

-- Footer service, company, and policy links.
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
