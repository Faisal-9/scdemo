-- Phase 14 FULL CONTACT CMS
-- Safe for the existing StateCorps database.
-- Creates Contact page settings/content tables and adds useful message indexes.

CREATE TABLE IF NOT EXISTS contact_page (
  id TINYINT UNSIGNED NOT NULL PRIMARY KEY,
  section_title VARCHAR(255) NOT NULL DEFAULT 'Reach Us',
  head_office_title VARCHAR(255) NOT NULL,
  head_office_phone VARCHAR(100) NOT NULL,
  head_office_whatsapp VARCHAR(100) DEFAULT NULL,
  head_office_email VARCHAR(255) NOT NULL,
  head_office_address TEXT NOT NULL,
  map_label VARCHAR(255) NOT NULL DEFAULT 'Kart-e-Char, Kabul, Afghanistan',
  map_lat DECIMAL(10,7) NOT NULL,
  map_lng DECIMAL(10,7) NOT NULL,
  map_zoom TINYINT UNSIGNED NOT NULL DEFAULT 14,
  form_title VARCHAR(255) NOT NULL DEFAULT 'Drop Message',
  overseas_title VARCHAR(255) NOT NULL DEFAULT 'Overseas Companies',
  overseas_subtitle TEXT NOT NULL,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS contact_qr_codes (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  image_path VARCHAR(500) NOT NULL,
  label VARCHAR(100) NOT NULL,
  sort_order INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_contact_qr_order (sort_order,id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS contact_offices (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  phone VARCHAR(100) DEFAULT NULL,
  whatsapp VARCHAR(100) DEFAULT NULL,
  email VARCHAR(255) DEFAULT NULL,
  address TEXT NOT NULL,
  sort_order INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_contact_offices_order (sort_order,id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO contact_page
(id,section_title,head_office_title,head_office_phone,head_office_whatsapp,head_office_email,head_office_address,map_label,map_lat,map_lng,map_zoom,form_title,overseas_title,overseas_subtitle)
VALUES
(1,'Reach Us','Headquarters - State Corps Afghanistan','+93 791 811 968','+93 791 811 968','comms@statecorps.com','Kart-e-char, D#3, Kabul Afghanistan','Kart-e-Char, Kabul, Afghanistan',34.5044737,69.1409340,14,'Drop Message','Overseas Companies','Contact our offices worldwide for assistance and support.')
ON DUPLICATE KEY UPDATE
section_title=VALUES(section_title),head_office_title=VALUES(head_office_title),head_office_phone=VALUES(head_office_phone),head_office_whatsapp=VALUES(head_office_whatsapp),head_office_email=VALUES(head_office_email),head_office_address=VALUES(head_office_address),map_label=VALUES(map_label),map_lat=VALUES(map_lat),map_lng=VALUES(map_lng),map_zoom=VALUES(map_zoom),form_title=VALUES(form_title),overseas_title=VALUES(overseas_title),overseas_subtitle=VALUES(overseas_subtitle);

INSERT INTO contact_qr_codes (image_path,label,sort_order,is_active)
SELECT 'assets/images/WA-QR-Code.jpg','WhatsApp',0,1
WHERE NOT EXISTS (SELECT 1 FROM contact_qr_codes);

INSERT INTO contact_offices (title,phone,whatsapp,email,address,sort_order,is_active)
SELECT 'State Corps Turkey','+90 212 123 4567',NULL,'info@statecorps.com.tr','İnşaat Sanayi ve Ticaret A.Ş. Kuçukbakkalkoy Mah. Kuçuk Setli Sk. No:5-9 İç Kapı No:4 Ataşehir Istanbul, Türkiye 34750',0,1
WHERE NOT EXISTS (SELECT 1 FROM contact_offices WHERE title='State Corps Turkey');

INSERT INTO contact_offices (title,phone,whatsapp,email,address,sort_order,is_active)
SELECT 'State Corps USA','+1 123-456-7890',NULL,'hq@statecorps.com','42426 Benfold Square Brambleton, VA 20148 United States',1,1
WHERE NOT EXISTS (SELECT 1 FROM contact_offices WHERE title='State Corps USA');

INSERT INTO contact_offices (title,phone,whatsapp,email,address,sort_order,is_active)
SELECT 'State Corps Uzbekistan','+971 4 123 4567',NULL,'uzbekistan@statecorps.com','abc Street, Tashkent, Uzbekistan',2,1
WHERE NOT EXISTS (SELECT 1 FROM contact_offices WHERE title='State Corps Uzbekistan');

ALTER TABLE contact_messages ADD INDEX idx_contact_messages_status_created (status, created_at);
ALTER TABLE contact_messages ADD INDEX idx_contact_messages_email (email);
ALTER TABLE contact_messages ADD INDEX idx_contact_messages_subject (subject);
