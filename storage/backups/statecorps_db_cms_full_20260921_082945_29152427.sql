-- State Corps CMS database backup
-- Generated: 2026-09-21 08:29:45
-- Database: statecorps_db

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

-- --------------------------------------------------------
-- Table: about_affiliated_companies

DROP TABLE IF EXISTS `about_affiliated_companies`;
CREATE TABLE `about_affiliated_companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `about_asset_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `about_affiliated_companies` (`id`, `name`, `sort_order`, `is_active`, `about_asset_id`) VALUES
(1, 'State Corps United States', 0, 1, NULL),
(2, 'State Corps Turkiye', 1, 1, NULL),
(3, 'State Corps Uzbikistan', 2, 1, NULL),
(4, 'Arya Mineral', 3, 1, NULL),
(5, 'Petropool', 4, 1, NULL),
(6, 'Aeroparcel', 5, 1, NULL);

-- --------------------------------------------------------
-- Table: about_awards

DROP TABLE IF EXISTS `about_awards`;
CREATE TABLE `about_awards` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `about_asset_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `about_awards` (`id`, `name`, `sort_order`, `is_active`, `about_asset_id`) VALUES
(1, 'Engineering Excellence Recognition', 0, 1, 254),
(2, 'Infrastructure Project Achievement', 1, 1, 255),
(3, 'Operational Safety Recognition', 2, 1, 256),
(4, 'VAT Registration Certificate', 3, 1, 258),
(5, 'BECO Expo Certificate', 4, 1, 257);

-- --------------------------------------------------------
-- Table: about_certificates

DROP TABLE IF EXISTS `about_certificates`;
CREATE TABLE `about_certificates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `about_asset_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `about_certificates` (`id`, `name`, `sort_order`, `is_active`, `about_asset_id`) VALUES
(1, 'Quality Management System (ISO 9001)', 0, 1, 299),
(2, 'Environmental Management System (ISO 14001)', 1, 1, 300),
(3, 'Health & Safety Management System (ISO 45001)', 2, 1, 301);

-- --------------------------------------------------------
-- Table: about_clients

DROP TABLE IF EXISTS `about_clients`;
CREATE TABLE `about_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `about_asset_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_about_clients_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `about_clients` (`id`, `name`, `sort_order`, `is_active`, `about_asset_id`) VALUES
(1, NULL, 0, 1, 262),
(2, NULL, 1, 1, 268),
(3, NULL, 2, 1, 267),
(4, NULL, 3, 1, 260),
(5, NULL, 4, 1, 265),
(6, NULL, 5, 1, 266),
(7, NULL, 6, 1, 272),
(8, NULL, 7, 1, 274),
(9, NULL, 8, 1, 269),
(10, NULL, 9, 1, 270),
(11, NULL, 10, 1, 261),
(12, NULL, 11, 1, 271),
(13, NULL, 12, 1, 273),
(14, NULL, 13, 1, 264),
(15, NULL, 14, 1, 263);

-- --------------------------------------------------------
-- Table: about_company_profile

DROP TABLE IF EXISTS `about_company_profile`;
CREATE TABLE `about_company_profile` (
  `id` tinyint(3) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `profile_asset_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `about_company_profile` (`id`, `title`, `content`, `updated_at`, `profile_asset_id`) VALUES
(1, 'Company Profile', 'Click the link below to download our comprehensive company profile, showcasing our expertise, project portfolio, and commitment to excellence in engineering and construction.', '2026-09-21 10:34:07', 473);

-- --------------------------------------------------------
-- Table: about_core_values

DROP TABLE IF EXISTS `about_core_values`;
CREATE TABLE `about_core_values` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `value_text` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_about_values_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `about_core_values` (`id`, `value_text`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Integrity — We operate with transparency and honesty in everything we do.', 0, 1, '2026-09-10 19:53:16', '2026-09-10 19:53:16'),
(2, 'Excellence — We pursue the highest standards in engineering and delivery.', 1, 1, '2026-09-10 19:53:16', '2026-09-10 19:53:16'),
(3, 'Innovation — We embrace new technologies and methods to solve complex challenges.', 2, 1, '2026-09-10 19:53:16', '2026-09-10 19:53:16'),
(4, 'Commitment — We honour our promises to clients, partners, and communities.', 3, 1, '2026-09-10 19:53:16', '2026-09-10 19:53:16'),
(5, 'Safety — We prioritise the health and safety of our people and communities.', 4, 1, '2026-09-10 19:53:16', '2026-09-10 19:53:16'),
(6, 'Sustainability — We build for the long term with environmental responsibility.', 5, 1, '2026-09-10 19:53:16', '2026-09-10 19:53:16');

-- --------------------------------------------------------
-- Table: about_general

DROP TABLE IF EXISTS `about_general`;
CREATE TABLE `about_general` (
  `id` tinyint(3) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `about_general` (`id`, `title`, `content`, `updated_at`) VALUES
(1, 'Overview', 'State Corps warmly welcomes you and appreciates your interest in our company. For approximately two decades, we have grown into one of Afghanistan\'s leading construction and energy firms, delivering high-quality projects through our skilled workforce and experienced management. From major USACE projects to high-voltage transmission lines and substations, we remain committed to excellence, innovation, and contributing to Afghanistan\'s development.', '2026-09-10 19:53:16');

-- --------------------------------------------------------
-- Table: about_history

DROP TABLE IF EXISTS `about_history`;
CREATE TABLE `about_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `year` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `timeline_asset_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_about_history_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `about_history` (`id`, `year`, `title`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`, `timeline_asset_id`) VALUES
(1, '2007', 'State Corps Established', 'Establishment of the company in Afghanistan.', 0, 1, '2026-09-10 19:53:16', '2026-09-21 10:34:07', 241),
(2, '2010', 'First Major Project', 'Completion of a major infrastructure project.', 1, 1, '2026-09-10 19:53:16', '2026-09-21 10:34:07', 241),
(3, '2014', 'International Expansion', 'Established offices in Türkiye and the United States.', 2, 1, '2026-09-10 19:53:16', '2026-09-21 10:34:07', 249),
(4, '2024', 'MOEW & DABS Recognition', 'Awarded recognition for successful energy infrastructure projects.', 3, 1, '2026-09-10 19:53:16', '2026-09-21 10:34:07', 241),
(5, '2025', 'Uzbek-Afghan Energy Projects', 'Transmission Lines, Substations, and Distribution projects with MEW.', 4, 1, '2026-09-10 19:53:16', '2026-09-21 10:34:07', 248),
(6, '2025', 'Major Project Milestone', 'Completed over 100 projects valued at more than $500 million.', 5, 1, '2026-09-10 19:53:16', '2026-09-21 10:34:07', 250);

-- --------------------------------------------------------
-- Table: about_hse

DROP TABLE IF EXISTS `about_hse`;
CREATE TABLE `about_hse` (
  `id` tinyint(3) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `about_hse` (`id`, `title`, `content`, `updated_at`) VALUES
(1, 'Health, Safety & Environment (HSE)', 'We are committed to protecting people, assets, and the environment through a strong safety culture, proactive risk management, and sustainable operational practices.', '2026-09-12 14:28:49');

-- --------------------------------------------------------
-- Table: about_mission_vision

DROP TABLE IF EXISTS `about_mission_vision`;
CREATE TABLE `about_mission_vision` (
  `id` tinyint(3) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `mission` text NOT NULL,
  `vision` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `mission_asset_id` int(10) unsigned DEFAULT NULL,
  `vision_asset_id` int(10) unsigned DEFAULT NULL,
  `core_values_asset_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `about_mission_vision` (`id`, `title`, `mission`, `vision`, `updated_at`, `mission_asset_id`, `vision_asset_id`, `core_values_asset_id`) VALUES
(1, 'Mission & Vision', 'To engineer a sustainable and empowered future for Afghanistan through reliable energy and robust infrastructure, delivering excellence, innovation, and value in every project we undertake.', 'To be the leading and most trusted engineering and construction partner in the region, recognized for our technical expertise and transformative impact on infrastructure and energy development.', '2026-09-21 10:34:07', 244, 459, 309);

-- --------------------------------------------------------
-- Table: about_page

DROP TABLE IF EXISTS `about_page`;
CREATE TABLE `about_page` (
  `id` tinyint(3) unsigned NOT NULL DEFAULT 1,
  `overview_title` varchar(255) NOT NULL,
  `overview_content` longtext NOT NULL,
  `mission_title` varchar(255) NOT NULL,
  `mission` text NOT NULL,
  `mission_image` varchar(500) DEFAULT NULL,
  `vision` text NOT NULL,
  `vision_image` varchar(500) DEFAULT NULL,
  `core_values_image` varchar(500) DEFAULT NULL,
  `clients_title` varchar(255) DEFAULT NULL,
  `certificates_title` varchar(255) DEFAULT NULL,
  `awards_title` varchar(255) DEFAULT NULL,
  `affiliated_companies_title` varchar(255) DEFAULT NULL,
  `hse_title` varchar(255) DEFAULT NULL,
  `hse_content` longtext DEFAULT NULL,
  `company_profile_title` varchar(255) DEFAULT NULL,
  `company_profile_content` longtext DEFAULT NULL,
  `company_profile_file` varchar(500) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `about_page` (`id`, `overview_title`, `overview_content`, `mission_title`, `mission`, `mission_image`, `vision`, `vision_image`, `core_values_image`, `clients_title`, `certificates_title`, `awards_title`, `affiliated_companies_title`, `hse_title`, `hse_content`, `company_profile_title`, `company_profile_content`, `company_profile_file`, `updated_at`) VALUES
(1, 'Overview', 'State Corps warmly welcomes you and appreciates your interest in our company. For approximately two decades, we have grown into one of Afghanistan\'s leading construction and energy firms, delivering high-quality projects through our skilled workforce and experienced management. From major USACE projects to high-voltage transmission lines and substations, we remain committed to excellence, innovation, and contributing to Afghanistan\'s development.', 'Mission & Vision', 'To engineer a sustainable and empowered future for Afghanistan through reliable energy and robust infrastructure, delivering excellence, innovation, and value in every project we undertake.', 'assets/uploads/legacy/20260921_073447/6.jpg', 'To be the leading and most trusted engineering and construction partner in the region, recognized for our technical expertise and transformative impact on infrastructure and energy development.', 'assets/uploads/legacy/20260921_073447/substation01.jpg', 'assets/uploads/legacy/20260921_073447/manpower.jpeg', 'Clients', 'ISO Certifications', 'Awards & Recognitions', 'Affiliated Companies', 'Health, Safety & Environment (HSE)', 'We are committed to protecting people, assets, and the environment through a strong safety culture, proactive risk management, and sustainable operational practices.', 'Company Profile', 'Click the link below to download our comprehensive company profile, showcasing our expertise, project portfolio, and commitment to excellence in engineering and construction.', 'assets/uploads/legacy/20260921_073447/SCProfileLight.pdf', '2026-09-21 10:05:23');

-- --------------------------------------------------------
-- Table: about_sections

DROP TABLE IF EXISTS `about_sections`;
CREATE TABLE `about_sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `legacy_id` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `legacy_id` (`legacy_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `about_sections` (`id`, `legacy_id`, `title`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'general-info', 'Overview', 0, 1, '2026-09-10 19:53:16', '2026-09-10 19:53:16'),
(2, 'mission-vision', 'Mission & Vision', 1, 1, '2026-09-10 19:53:16', '2026-09-10 19:53:16'),
(3, 'clients', 'Clients', 2, 1, '2026-09-10 19:53:16', '2026-09-10 19:53:16'),
(4, 'certificates', 'ISO Certifications', 3, 1, '2026-09-10 19:53:16', '2026-09-10 19:53:16'),
(5, 'awards', 'Awards & Recognitions', 4, 1, '2026-09-10 19:53:16', '2026-09-10 19:53:16'),
(6, 'sister', 'Affiliated Companies', 5, 1, '2026-09-10 19:53:16', '2026-09-10 19:53:16'),
(7, 'hse', 'Health, Safety & Environment (HSE)', 6, 1, '2026-09-10 19:53:16', '2026-09-10 19:53:16'),
(8, 'cprofile', 'Company Profile', 7, 1, '2026-09-10 19:53:16', '2026-09-10 19:53:16');

-- --------------------------------------------------------
-- Table: about_sister_companies

DROP TABLE IF EXISTS `about_sister_companies`;
CREATE TABLE `about_sister_companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `logo_path` varchar(500) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_about_sister_order` (`sort_order`,`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `about_sister_companies` (`id`, `name`, `logo_path`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'State Corps United States', 'assets/images/scompany/sc_us.png', 0, 1, '2026-09-10 19:53:16', '2026-09-10 19:53:16'),
(2, 'State Corps Turkiye', 'assets/images/scompany/sc_turkey.png', 1, 1, '2026-09-10 19:53:16', '2026-09-10 19:53:16'),
(3, 'State Corps Uzbikistan', 'assets/images/scompany/sc_us.png', 2, 1, '2026-09-10 19:53:16', '2026-09-10 19:53:16'),
(4, 'Arya Mineral', 'assets/images/scompany/scom_aryamineral.png', 3, 1, '2026-09-10 19:53:16', '2026-09-10 19:53:16'),
(5, 'Petropool', 'assets/images/scompany/scom_petropool.png', 4, 1, '2026-09-10 19:53:16', '2026-09-10 19:53:16'),
(6, 'Aeroparcel', 'assets/images/scompany/scom_aeroparcel.png', 5, 1, '2026-09-10 19:53:16', '2026-09-10 19:53:16');

-- --------------------------------------------------------
-- Table: about_timeline

DROP TABLE IF EXISTS `about_timeline`;
CREATE TABLE `about_timeline` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `year` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `timeline_asset_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_about_timeline_order` (`sort_order`,`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `about_timeline` (`id`, `year`, `title`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`, `timeline_asset_id`) VALUES
(1, '2007', 'State Corps Established', 'Establishment of the company in Afghanistan.', 0, 1, '2026-09-10 19:53:16', '2026-09-21 10:34:07', 241),
(2, '2010', 'First Major Project', 'Completion of a major infrastructure project.', 1, 1, '2026-09-10 19:53:16', '2026-09-21 10:34:07', 241),
(3, '2014', 'International Expansion', 'Established offices in Türkiye and the United States.', 2, 1, '2026-09-10 19:53:16', '2026-09-21 10:34:07', 249),
(4, '2024', 'MOEW & DABS Recognition', 'Awarded recognition for successful energy infrastructure projects.', 3, 1, '2026-09-10 19:53:16', '2026-09-21 10:34:07', 241),
(5, '2025', 'Uzbek-Afghan Energy Projects', 'Transmission Lines, Substations, and Distribution projects with MEW.', 4, 1, '2026-09-10 19:53:16', '2026-09-21 10:34:07', 248),
(6, '2025', 'Major Project Milestone', 'Completed over 100 projects valued at more than $500 million.', 5, 1, '2026-09-10 19:53:16', '2026-09-21 10:34:07', 250);

-- --------------------------------------------------------
-- Table: admin_notifications

DROP TABLE IF EXISTS `admin_notifications`;
CREATE TABLE `admin_notifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'info',
  `title` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  `entity_type` varchar(100) DEFAULT NULL,
  `entity_id` bigint(20) unsigned DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_notifications_user_read` (`user_id`,`is_read`,`created_at`),
  KEY `idx_notifications_created` (`created_at`),
  CONSTRAINT `fk_notifications_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------
-- Table: analytics_page_views

DROP TABLE IF EXISTS `analytics_page_views`;
CREATE TABLE `analytics_page_views` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `visitor_hash` char(64) NOT NULL,
  `page_path` varchar(500) NOT NULL,
  `page_key` varchar(100) DEFAULT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `referrer_host` varchar(255) DEFAULT NULL,
  `device_type` enum('desktop','mobile','tablet','unknown') NOT NULL DEFAULT 'unknown',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_analytics_created` (`created_at`,`id`),
  KEY `idx_analytics_visitor_created` (`visitor_hash`,`created_at`),
  KEY `idx_analytics_page_created` (`page_path`(191),`created_at`),
  KEY `idx_analytics_referrer_created` (`referrer_host`,`created_at`),
  KEY `idx_analytics_device_created` (`device_type`,`created_at`),
  KEY `idx_analytics_key_created` (`page_key`,`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `analytics_page_views` (`id`, `visitor_hash`, `page_path`, `page_key`, `page_title`, `referrer_host`, `device_type`, `created_at`) VALUES
(1, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 13:44:24'),
(2, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 14:15:09'),
(3, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 14:28:14'),
(4, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 14:36:35'),
(5, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:24:10'),
(6, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:27:25'),
(7, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:27:28'),
(8, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:27:29'),
(9, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:27:29'),
(10, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:27:30'),
(11, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:27:30'),
(12, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:29:15'),
(13, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:34:29'),
(14, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:34:42'),
(15, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:34:44'),
(16, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:34:44'),
(17, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:34:45'),
(18, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:34:45'),
(19, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:34:45'),
(20, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:34:45'),
(21, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:34:45'),
(22, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:34:45'),
(23, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:34:46'),
(24, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:34:46'),
(25, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:34:46'),
(26, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:34:46'),
(27, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:34:46'),
(28, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/projects.php', 'projects', 'State Corps', 'localhost', 'desktop', '2026-09-16 15:35:29'),
(29, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/projects.php', 'projects', 'State Corps', 'localhost', 'desktop', '2026-09-16 15:40:19'),
(30, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/projects.php', 'projects', 'State Corps', 'localhost', 'desktop', '2026-09-16 15:47:14'),
(31, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:47:28'),
(32, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:47:49'),
(33, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:47:51'),
(34, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:47:52'),
(35, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:47:52'),
(36, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:47:53'),
(37, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:47:53'),
(38, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:47:53'),
(39, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:47:53'),
(40, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:47:54'),
(41, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:47:55'),
(42, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:47:55'),
(43, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:47:55'),
(44, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:47:55'),
(45, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:47:55'),
(46, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:47:56'),
(47, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:47:56'),
(48, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:47:56'),
(49, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:47:57'),
(50, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:50:55'),
(51, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:50:56'),
(52, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:51:00'),
(53, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:51:05'),
(54, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:51:06'),
(55, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:51:06'),
(56, 'f4245b87d03d18affa85e23a64b4f98acbd8a5f30c348dc5c009ba82c0c09ef4', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:51:06'),
(57, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:51:22'),
(58, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:54:20'),
(59, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 15:54:55'),
(60, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 16:01:43'),
(61, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 16:02:07'),
(62, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 16:02:12'),
(63, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 16:24:59'),
(64, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 16:25:42'),
(65, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 16:26:21'),
(66, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 16:55:47'),
(67, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 16:58:20'),
(68, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 17:04:39'),
(69, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 17:04:43'),
(70, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 17:05:11'),
(71, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 17:05:12'),
(72, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 17:05:13'),
(73, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 17:05:38'),
(74, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 17:05:40'),
(75, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 17:06:03'),
(76, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 17:06:04'),
(77, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 17:06:18'),
(78, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 17:06:50'),
(79, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 17:06:51'),
(80, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 17:06:58'),
(81, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 17:07:15'),
(82, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 17:07:16'),
(83, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 17:07:31'),
(84, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 17:07:32'),
(85, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/index.php', 'home', 'State Corps', 'localhost', 'desktop', '2026-09-16 17:08:43'),
(86, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 17:08:52'),
(87, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/index.php', 'home', 'State Corps', 'localhost', 'desktop', '2026-09-16 17:10:03'),
(88, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/index.php', 'home', 'State Corps', 'localhost', 'desktop', '2026-09-16 17:10:04'),
(89, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 17:11:09'),
(90, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/index.php', 'home', 'State Corps', 'localhost', 'desktop', '2026-09-16 17:13:42'),
(91, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/index.php', 'home', 'State Corps', 'localhost', 'desktop', '2026-09-16 17:14:03'),
(92, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/index.php', 'home', 'State Corps', 'localhost', 'desktop', '2026-09-16 17:14:04'),
(93, 'fd950e3fa7abbea3c2301200c0c85891bb5e34d67e377f9b0b5f67e474224c2e', '/scdemo/index.php', 'home', 'State Corps', 'localhost', 'desktop', '2026-09-16 17:14:28'),
(94, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 17:14:47'),
(95, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-16 17:15:20'),
(96, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/projectdetails.php', 'project-details', 'State Corps', 'localhost', 'desktop', '2026-09-16 17:15:41'),
(97, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/projectdetails.php', 'project-details', 'State Corps', 'localhost', 'desktop', '2026-09-16 17:15:45'),
(98, 'cd9a16d294a4da088aa9fc6c59d47e78e99eab40d2c2f91dfa2d381ea107967e', '/scdemo/index.php', 'home', 'State Corps', NULL, 'desktop', '2026-09-20 10:09:11'),
(99, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/', 'home', 'State Corps', NULL, 'desktop', '2026-09-20 10:10:36'),
(100, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/services.php', 'services', 'State Corps', 'localhost', 'desktop', '2026-09-20 10:11:20');
INSERT INTO `analytics_page_views` (`id`, `visitor_hash`, `page_path`, `page_key`, `page_title`, `referrer_host`, `device_type`, `created_at`) VALUES
(101, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/services.php', 'services', 'State Corps', 'localhost', 'desktop', '2026-09-20 10:11:32'),
(102, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/services.php', 'services', 'State Corps', 'localhost', 'desktop', '2026-09-20 10:21:05'),
(103, '16e006b3c16a4b66bd70e5812e88cd96da12e1fc10e2d638738ad673cf258014', '/scdemo/services.php', 'services', 'State Corps', NULL, 'desktop', '2026-09-20 10:28:07'),
(104, 'd07b3e02b34fedf02c435c0db4b9dbf7a38b43b573b36f40ee064516f6066d9d', '/scdemo/services.php', 'services', 'State Corps', NULL, 'desktop', '2026-09-20 10:28:12'),
(105, '972515aaa844755cb221c24c9181aa9811198f9c0ecba81850969ae138634a69', '/scdemo/services.php', 'services', 'State Corps', NULL, 'desktop', '2026-09-20 10:28:16'),
(106, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/services.php', 'services', 'State Corps', 'localhost', 'desktop', '2026-09-20 10:29:51'),
(107, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/services.php', 'services', 'State Corps', 'localhost', 'desktop', '2026-09-20 10:30:08'),
(108, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/services.php', 'services', 'State Corps', 'localhost', 'desktop', '2026-09-20 10:30:09'),
(109, '918413d85732e267080e3d0b807543479611345cd0d6640b4461b774b3ec31b2', '/scdemo/services.php', 'services', 'State Corps', NULL, 'desktop', '2026-09-20 10:38:16'),
(110, '1c00567f1ec8c4c48f5f38db9ce3f7ab82d43b11dee17442cd0dac260479e9d4', '/scdemo/services.php', 'services', 'State Corps', NULL, 'desktop', '2026-09-20 10:38:22'),
(111, '918413d85732e267080e3d0b807543479611345cd0d6640b4461b774b3ec31b2', '/scdemo/services.php', 'services', 'State Corps', NULL, 'desktop', '2026-09-20 10:51:10'),
(112, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/services.php', 'services', 'State Corps', 'localhost', 'desktop', '2026-09-20 10:51:54'),
(113, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/sectors.php', 'sectors', 'State Corps', 'localhost', 'desktop', '2026-09-20 10:55:25'),
(114, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/services.php', 'services', 'State Corps', 'localhost', 'desktop', '2026-09-20 10:55:36'),
(115, '918413d85732e267080e3d0b807543479611345cd0d6640b4461b774b3ec31b2', '/scdemo/services.php', 'services', 'State Corps', NULL, 'desktop', '2026-09-20 10:57:18'),
(116, '918413d85732e267080e3d0b807543479611345cd0d6640b4461b774b3ec31b2', '/scdemo/services.php', 'services', 'State Corps', NULL, 'desktop', '2026-09-20 10:58:11'),
(117, '918413d85732e267080e3d0b807543479611345cd0d6640b4461b774b3ec31b2', '/scdemo/services.php', 'services', 'State Corps', NULL, 'desktop', '2026-09-20 10:58:33'),
(118, '918413d85732e267080e3d0b807543479611345cd0d6640b4461b774b3ec31b2', '/scdemo/services.php', 'services', 'State Corps', NULL, 'desktop', '2026-09-20 10:58:44'),
(119, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/services.php', 'services', 'State Corps', 'localhost', 'desktop', '2026-09-20 10:58:55'),
(120, '918413d85732e267080e3d0b807543479611345cd0d6640b4461b774b3ec31b2', '/scdemo/services.php', 'services', 'State Corps', NULL, 'desktop', '2026-09-20 10:59:09'),
(121, '918413d85732e267080e3d0b807543479611345cd0d6640b4461b774b3ec31b2', '/scdemo/services.php', 'services', 'State Corps', NULL, 'desktop', '2026-09-20 10:59:25'),
(122, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/about.php', 'about', 'State Corps', 'localhost', 'desktop', '2026-09-20 11:03:21'),
(123, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/sectors.php', 'sectors', 'State Corps', 'localhost', 'desktop', '2026-09-20 11:05:30'),
(124, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/sectors.php', 'sectors', 'State Corps', 'localhost', 'desktop', '2026-09-20 11:05:44'),
(125, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/contact.php', 'contact', 'State Corps', 'localhost', 'desktop', '2026-09-20 11:05:50'),
(126, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/contact.php', 'contact', 'State Corps', 'localhost', 'desktop', '2026-09-20 11:24:26'),
(127, 'ef44f20c1ab2a082efe65b38aff4878f489ed84a7724a6e02cfeef639c0f9e0e', '/scdemo/services.php', 'services', 'State Corps', NULL, 'desktop', '2026-09-20 11:24:27'),
(128, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/services.php', 'services', 'State Corps', 'localhost', 'desktop', '2026-09-20 11:24:38'),
(129, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/services.php', 'services', 'State Corps', 'localhost', 'desktop', '2026-09-20 11:39:35'),
(130, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/about.php', 'about', 'State Corps', 'localhost', 'desktop', '2026-09-20 11:40:40'),
(131, 'ef44f20c1ab2a082efe65b38aff4878f489ed84a7724a6e02cfeef639c0f9e0e', '/scdemo/services.php', 'services', 'State Corps', NULL, 'desktop', '2026-09-20 13:50:30'),
(132, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/about.php', 'about', 'State Corps', 'localhost', 'desktop', '2026-09-20 13:57:49'),
(133, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/index.php', 'home', 'State Corps', 'localhost', 'desktop', '2026-09-20 13:58:01'),
(134, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/about.php', 'about', 'State Corps', 'localhost', 'desktop', '2026-09-20 13:58:03'),
(135, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/index.php', 'home', 'State Corps', 'localhost', 'desktop', '2026-09-20 14:13:54'),
(136, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/sectors.php', 'sectors', 'State Corps', 'localhost', 'desktop', '2026-09-20 14:15:17'),
(137, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/sectors.php', 'sectors', 'State Corps', 'localhost', 'desktop', '2026-09-20 14:15:24'),
(138, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/sectors.php', 'sectors', 'State Corps', 'localhost', 'desktop', '2026-09-20 14:15:30'),
(139, 'ffdde4bb94cce9f2cf68e05b9b61d961d4fdc7b21a30d3cf7073bcdcfada7471', '/scdemo/sectors.php', 'sectors', 'State Corps', 'localhost', 'desktop', '2026-09-21 09:01:44');

-- --------------------------------------------------------
-- Table: audit_logs

DROP TABLE IF EXISTS `audit_logs`;
CREATE TABLE `audit_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `entity_type` varchar(100) DEFAULT NULL,
  `entity_id` bigint(20) unsigned DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_audit_user` (`user_id`),
  KEY `idx_audit_entity` (`entity_type`,`entity_id`),
  KEY `idx_audit_created` (`created_at`),
  KEY `idx_audit_logs_created_at` (`created_at`,`id`),
  KEY `idx_audit_logs_action` (`action`,`created_at`,`id`),
  KEY `idx_audit_logs_entity` (`entity_type`,`entity_id`,`created_at`,`id`),
  KEY `idx_audit_logs_user` (`user_id`,`created_at`,`id`),
  KEY `idx_audit_logs_ip` (`ip_address`,`created_at`,`id`),
  CONSTRAINT `fk_audit_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-06 20:41:27'),
(2, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 08:58:40'),
(3, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 09:37:26'),
(4, 1, 'create', 'editor', 2, 'Created editor account: demo1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 09:46:04'),
(5, 1, 'update', 'editor', 2, 'Updated editor account: demo1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 09:46:16'),
(6, 1, 'logout', 'user', 1, 'CMS logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 09:47:19'),
(7, 2, 'login', 'user', 2, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 09:47:43'),
(8, 2, 'logout', 'user', 2, 'CMS logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 09:48:01'),
(9, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 10:11:30'),
(10, 1, 'logout', 'user', 1, 'CMS logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 10:26:31'),
(11, 2, 'login', 'user', 2, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 10:26:35'),
(12, 2, 'logout', 'user', 2, 'CMS logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 10:52:48'),
(13, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 10:52:53'),
(14, 1, 'update', 'project', 20, 'Updated project: Arghandi Transformer Bay', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 10:56:32'),
(15, 1, 'logout', 'user', 1, 'CMS logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 11:43:28'),
(16, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 11:43:30'),
(17, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-07 13:20:18'),
(18, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 15:24:53'),
(19, 1, 'unpublish', 'project', 1, 'Unpublished: Logar-Gardiz 220 kV Transmission Line ', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 15:25:05'),
(20, 1, 'logout', 'user', 1, 'CMS logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 15:26:53'),
(21, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 15:26:56'),
(22, 1, 'publish', 'project', 1, 'Published: Logar-Gardiz 220 kV Transmission Line ', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 15:38:58'),
(23, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 16:23:08'),
(24, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 16:23:56'),
(25, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 17:05:14'),
(26, 1, 'logout', 'user', 1, 'CMS logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 17:18:19'),
(27, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-08 17:18:21'),
(28, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 16:36:59'),
(29, 1, 'delete', 'service_category', 9, 'Deleted service category.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 16:41:41'),
(30, 1, 'delete', 'service_category', 10, 'Deleted service category.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 16:41:51'),
(31, 1, 'delete', 'service_category', 11, 'Deleted service category.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 16:42:43'),
(32, 1, 'delete', 'service_category', 12, 'Deleted service category.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 16:42:55'),
(33, 1, 'logout', 'user', 1, 'CMS logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 16:43:08'),
(34, 2, 'login', 'user', 2, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 16:43:12'),
(35, 2, 'logout', 'user', 2, 'CMS logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 16:43:18'),
(36, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 16:43:22'),
(37, 1, 'update', 'editor', 2, 'Updated editor account: demo1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 16:44:09'),
(38, 1, 'update', 'editor', 2, 'Updated editor account: demo1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 16:44:16'),
(39, 1, 'logout', 'user', 1, 'CMS logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 16:44:28'),
(40, 2, 'login', 'user', 2, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 16:44:32'),
(41, 2, 'create', 'service_item', 50, 'Created service item: Consulting and Advisory Services', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 16:53:18'),
(42, 2, 'create', 'service_item', 51, 'Created service item: abc', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 16:57:34'),
(43, 2, 'login', 'user', 2, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 17:49:53'),
(44, 2, 'login', 'user', 2, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 18:49:25'),
(45, 2, 'login', 'user', 2, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:07:19'),
(46, 2, 'logout', 'user', 2, 'CMS logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:25:51'),
(47, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-09 20:25:55'),
(48, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-10 08:33:36'),
(49, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-10 09:06:17'),
(50, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-10 09:07:18'),
(51, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-10 10:11:28'),
(52, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-10 11:14:21'),
(53, 1, 'create', 'service_item', 52, 'Created service item: aaa', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-10 11:15:34'),
(54, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-10 12:38:16'),
(55, 1, 'update', 'home_why_tab', 2, 'Updated Why State Corps tab', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-10 12:40:06'),
(56, 1, 'update', 'home_why_tab', 2, 'Updated Why State Corps tab', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-10 12:40:27'),
(57, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-10 14:43:07'),
(58, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-10 15:32:49'),
(59, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 09:57:47'),
(60, 1, 'update', 'about_hse', NULL, 'Updated About HSE', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 09:58:25'),
(61, 1, 'update', 'about_hse', NULL, 'Updated About HSE', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 09:58:49'),
(62, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 10:45:54'),
(63, 1, 'update', 'media_item', 3, 'Update media item: Afghanistan 3rd Exhibition on Construction, Rehabilitation, and Energy Sectors', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 10:47:22'),
(64, 1, 'update', 'media_item', 3, 'Update media item: Afghanistan 3rd Exhibition on Construction, Rehabilitation, and Energy Sectors', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 10:47:49'),
(65, 1, 'update', 'media_item', 3, 'Update media item: Afghanistan 2rd Exhibition on Construction, Rehabilitation, and Energy Sectors', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 10:48:01'),
(66, 1, 'update', 'media_item', 3, 'Update media item: Afghanistan 3rd Exhibition on Construction, Rehabilitation, and Energy Sectors', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 10:48:20'),
(67, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 11:21:08'),
(68, 1, 'update', 'media_item', 3, 'Update media item: Afghanistan 3rd Exhibition on Construction, Rehabilitation, and Energy Sectors', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 11:21:26'),
(69, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 15:54:02'),
(70, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 16:31:32'),
(71, 1, 'update', 'media_item', 3, 'Update media item: Afghanistan 3rd Exhibition on Construction, Rehabilitation, and Energy Sectors', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 16:32:23'),
(72, 1, 'update', 'media_item', 3, 'Update media item: Afghanistan 3rd Exhibition on Construction, Rehabilitation, and Energy Sectors', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 16:32:37'),
(73, 1, 'update', 'media_item', 3, 'Update media item: Afghanistan 2rd Exhibition on Construction, Rehabilitation, and Energy Sectors', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 16:32:49'),
(74, 1, 'logout', 'user', 1, 'CMS logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 16:34:26'),
(75, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 16:34:30'),
(76, 1, 'logout', 'user', 1, 'CMS logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 16:41:55'),
(77, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 16:41:58'),
(78, 1, 'logout', 'user', 1, 'CMS logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 16:42:08'),
(79, 2, 'login', 'user', 2, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 16:42:13'),
(80, 2, 'logout', 'user', 2, 'CMS logout.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 16:42:22'),
(81, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 16:42:25'),
(82, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 18:41:26'),
(83, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 19:59:27'),
(84, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 21:11:45'),
(85, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-13 08:21:46'),
(86, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-13 08:52:49'),
(87, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-13 10:16:03'),
(88, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-13 11:19:07'),
(89, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-13 13:07:49'),
(90, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-13 14:17:34'),
(91, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-13 15:14:58'),
(92, 1, 'delete', 'service_item', 51, 'Deleted service item: abc', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-13 15:44:13'),
(93, 1, 'delete', 'service_item', 50, 'Deleted service item: Consulting and Advisory Services', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-13 15:45:11'),
(94, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-13 22:11:34'),
(95, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-15 17:16:50'),
(96, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-16 13:24:22'),
(97, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-16 15:27:55'),
(98, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-16 15:52:51'),
(99, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-16 16:27:51'),
(100, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 13:58:38');
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `description`, `ip_address`, `user_agent`, `created_at`) VALUES
(101, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 14:26:41'),
(102, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-20 15:20:06'),
(103, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-21 09:01:47'),
(104, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-21 10:08:23'),
(105, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-21 10:34:54');

-- --------------------------------------------------------
-- Table: contact_messages

DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE `contact_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `subject` varchar(500) DEFAULT NULL,
  `message` longtext NOT NULL,
  `status` enum('unread','read','archived') NOT NULL DEFAULT 'unread',
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_contact_status` (`status`),
  KEY `idx_contact_created` (`created_at`),
  KEY `idx_contact_messages_status_created` (`status`,`created_at`),
  KEY `idx_contact_messages_email` (`email`),
  KEY `idx_contact_messages_subject` (`subject`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `contact_messages` (`id`, `name`, `email`, `phone`, `company`, `subject`, `message`, `status`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 'Faisal', 'afs9g9@gmail.com', '+93730660778', NULL, 'test', 'testing the messaging options', 'read', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-12 18:05:43', '2026-09-13 17:24:50'),
(2, 'Ahmad', 'afs9g9@gmail.com', '+93730660778', NULL, 'testing', 'demo testttt', 'unread', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-13 17:24:01', '2026-09-13 17:24:01');

-- --------------------------------------------------------
-- Table: contact_offices

DROP TABLE IF EXISTS `contact_offices`;
CREATE TABLE `contact_offices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `whatsapp` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_contact_offices_order` (`sort_order`,`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `contact_offices` (`id`, `title`, `phone`, `whatsapp`, `email`, `address`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'State Corps Turkey', '+90 212 123 4567', NULL, 'info@statecorps.com.tr', 'İnşaat Sanayi ve Ticaret A.Ş. Kuçukbakkalkoy Mah. Kuçuk Setli Sk. No:5-9 İç Kapı No:4 Ataşehir Istanbul, Türkiye 34750', 0, 1, '2026-09-12 17:42:31', '2026-09-12 17:42:31'),
(2, 'State Corps USA', '+1 123-456-7890', NULL, 'hq@statecorps.com', '42426 Benfold Square Brambleton, VA 20148 United States', 1, 1, '2026-09-12 17:42:31', '2026-09-12 17:42:31'),
(3, 'State Corps Uzbekistan', '+971 4 123 4567', NULL, 'uzbekistan@statecorps.com', 'abc Street, Tashkent, Uzbekistan', 2, 1, '2026-09-12 17:42:31', '2026-09-12 17:42:31');

-- --------------------------------------------------------
-- Table: contact_page

DROP TABLE IF EXISTS `contact_page`;
CREATE TABLE `contact_page` (
  `id` tinyint(3) unsigned NOT NULL,
  `section_title` varchar(255) NOT NULL DEFAULT 'Reach Us',
  `head_office_title` varchar(255) NOT NULL,
  `head_office_phone` varchar(100) NOT NULL,
  `head_office_whatsapp` varchar(100) DEFAULT NULL,
  `head_office_email` varchar(255) NOT NULL,
  `head_office_address` text NOT NULL,
  `map_label` varchar(255) NOT NULL DEFAULT 'Kart-e-Char, Kabul, Afghanistan',
  `map_lat` decimal(10,7) NOT NULL,
  `map_lng` decimal(10,7) NOT NULL,
  `map_zoom` tinyint(3) unsigned NOT NULL DEFAULT 14,
  `form_title` varchar(255) NOT NULL DEFAULT 'Drop Message',
  `overseas_title` varchar(255) NOT NULL DEFAULT 'Overseas Companies',
  `overseas_subtitle` text NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `contact_page` (`id`, `section_title`, `head_office_title`, `head_office_phone`, `head_office_whatsapp`, `head_office_email`, `head_office_address`, `map_label`, `map_lat`, `map_lng`, `map_zoom`, `form_title`, `overseas_title`, `overseas_subtitle`, `updated_at`) VALUES
(1, 'Reach Us', 'Headquarters - State Corps Afghanistan', '+93 791 811 968', '+93 791 811 968', 'comms@statecorps.com', 'Kart-e-char, D#3, Kabul Afghanistan', 'Kart-e-Char, Kabul, Afghanistan', '34.5044737', '69.1409340', 14, 'Drop Message', 'Overseas Companies', 'Contact our offices worldwide for assistance and support.', '2026-09-12 17:42:31');

-- --------------------------------------------------------
-- Table: contact_qr_codes

DROP TABLE IF EXISTS `contact_qr_codes`;
CREATE TABLE `contact_qr_codes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(100) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `asset_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_contact_qr_order` (`sort_order`,`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `contact_qr_codes` (`id`, `label`, `sort_order`, `is_active`, `created_at`, `updated_at`, `asset_id`) VALUES
(1, 'WhatsApp', 0, 1, '2026-09-12 17:42:31', '2026-09-21 10:34:08', 465);

-- --------------------------------------------------------
-- Table: content_revisions

DROP TABLE IF EXISTS `content_revisions`;
CREATE TABLE `content_revisions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `entity_type` varchar(100) NOT NULL,
  `entity_id` bigint(20) unsigned NOT NULL,
  `revision_data` longtext NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_revision_entity` (`entity_type`,`entity_id`),
  KEY `idx_revision_user` (`user_id`),
  KEY `idx_revision_created` (`created_at`),
  CONSTRAINT `fk_revision_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------
-- Table: database_backups

DROP TABLE IF EXISTS `database_backups`;
CREATE TABLE `database_backups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `backup_type` enum('full','schema') NOT NULL DEFAULT 'full',
  `size_bytes` bigint(20) unsigned NOT NULL DEFAULT 0,
  `sha256` char(64) NOT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_database_backups_filename` (`filename`),
  KEY `idx_database_backups_created_at` (`created_at`),
  KEY `idx_database_backups_created_by` (`created_by`),
  CONSTRAINT `fk_database_backups_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `database_backups` (`id`, `filename`, `backup_type`, `size_bytes`, `sha256`, `created_by`, `created_at`) VALUES
(1, 'statecorps_db_cms_full_20260913_124626_84ac27a5.sql', 'full', 178283, 'd179ff0bb851ae53f114e70228f379c0b572ab9bcc27e6662d55d12179204ab2', NULL, '2026-09-13 15:16:26');

-- --------------------------------------------------------
-- Table: home_hero_slides

DROP TABLE IF EXISTS `home_hero_slides`;
CREATE TABLE `home_hero_slides` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `legacy_id` varchar(100) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `indicator` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `hero_asset_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_home_hero_legacy_id` (`legacy_id`),
  KEY `idx_home_hero_order` (`sort_order`),
  KEY `idx_home_hero_active` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `home_hero_slides` (`id`, `legacy_id`, `title`, `description`, `indicator`, `sort_order`, `is_active`, `hero_asset_id`) VALUES
(1, 'energy', 'Energy & Power Solutions', 'Delivering integrated engineering, procurement, construction, commissioning, and energy infrastructure solutions for transmission, substations, distribution networks, and power development projects.', 'Our Energy Expertise', 0, 1, 292),
(2, 'transport', 'Transportation Infrastructure', 'Designing and developing roads, highways, and transport networks that enhance connectivity, trade flow, and regional economic integration.', NULL, 1, 1, 295),
(3, 'structure', 'Buildings & Industrial Facilities', 'Engineering and constructing modern commercial, residential, and industrial structures with a focus on durability, efficiency, and long-term value.', NULL, 2, 1, 294),
(4, 'water', 'Water Resource Management', 'Providing sustainable water supply, treatment, wastewater management, irrigation, and environmental engineering solutions that support economic and social development.', NULL, 3, 1, 296),
(5, 'mining', 'Mining', 'Providing end-to-end mining solutions, including exploration support, site development, and infrastructure for efficient mineral extraction.', NULL, 4, 1, 293);

-- --------------------------------------------------------
-- Table: home_history

DROP TABLE IF EXISTS `home_history`;
CREATE TABLE `home_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `year` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idx_home_history_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `home_history` (`id`, `year`, `title`, `sort_order`, `is_active`) VALUES
(1, '2007', 'State Corps Establishment', 0, 1),
(2, '2010', 'First Major Project', 1, 1),
(3, '2012', 'Awarded by USACE', 2, 1),
(4, '2014', 'International Expansion to Middle East, Turkey and USA', 3, 1),
(5, '2021', 'Successfully completed 60 projects valued at $400M+', 4, 1),
(6, '2024', 'Awarded by MoWE & DABS', 5, 1),
(7, '2025', 'UZBEK-AFGHAN 5 projects', 6, 1);

-- --------------------------------------------------------
-- Table: home_stats

DROP TABLE IF EXISTS `home_stats`;
CREATE TABLE `home_stats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prefix` varchar(20) DEFAULT NULL,
  `number_value` decimal(15,2) NOT NULL,
  `suffix` varchar(50) DEFAULT NULL,
  `label` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idx_home_stats_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `home_stats` (`id`, `prefix`, `number_value`, `suffix`, `label`, `sort_order`, `is_active`) VALUES
(1, NULL, '19.00', '+', 'Years of Experience', 0, 1),
(2, NULL, '100.00', '+', 'Completed Projects', 1, 1),
(3, '$', '600.00', 'M+', 'Total Projects Value', 2, 1),
(4, NULL, '4.00', NULL, 'Active Global Offices', 3, 1);

-- --------------------------------------------------------
-- Table: home_why_items

DROP TABLE IF EXISTS `home_why_items`;
CREATE TABLE `home_why_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tab_id` int(10) unsigned NOT NULL,
  `item_text` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_home_why_items_tab` (`tab_id`),
  CONSTRAINT `fk_home_why_items_tab` FOREIGN KEY (`tab_id`) REFERENCES `home_why_tabs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `home_why_items` (`id`, `tab_id`, `item_text`, `sort_order`) VALUES
(1, 1, 'Proven track record', 0),
(2, 1, 'Deep industrial expertise', 1),
(3, 1, 'On time and within budget delivery.', 2),
(4, 1, 'Strong focus on quality & safety', 3),
(5, 1, 'Results-driven approach ensuring long-term value.', 4),
(6, 3, 'Advanced engineering solutions', 0),
(7, 3, 'Multidisciplinary teams', 1),
(8, 3, 'Innovative Solutions', 2),
(9, 3, 'Project Management Excellence', 3),
(10, 3, 'Digital Transformation Capability', 4);

-- --------------------------------------------------------
-- Table: home_why_tabs

DROP TABLE IF EXISTS `home_why_tabs`;
CREATE TABLE `home_why_tabs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `legacy_id` varchar(20) DEFAULT NULL,
  `tab_name` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `why_asset_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_home_why_legacy_id` (`legacy_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `home_why_tabs` (`id`, `legacy_id`, `tab_name`, `title`, `sort_order`, `is_active`, `why_asset_id`) VALUES
(1, '01', 'Delivering Experience', 'Delivering Experience', 0, 1, 291),
(2, '02', 'Regional Presence', NULL, 1, 1, 319),
(3, '03', 'Technical Capabilities', 'Technical Capabilities', 2, 1, 238);

-- --------------------------------------------------------
-- Table: legal_documents

DROP TABLE IF EXISTS `legal_documents`;
CREATE TABLE `legal_documents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `document_key` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_legal_document_key` (`document_key`),
  KEY `idx_legal_documents_active_order` (`is_active`,`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `legal_documents` (`id`, `document_key`, `title`, `sort_order`, `is_active`) VALUES
(1, 'policies_privacy', 'Privacy Policy', 0, 1),
(2, 'policies_whistleblower', 'Whistleblower Policy', 1, 1),
(3, 'policies_trademarks', 'Trademarks Policy', 2, 1),
(4, 'terms_terms', 'Terms of Service', 3, 1);

-- --------------------------------------------------------
-- Table: legal_sections

DROP TABLE IF EXISTS `legal_sections`;
CREATE TABLE `legal_sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `document_id` int(10) unsigned NOT NULL,
  `title` varchar(500) NOT NULL,
  `content` longtext DEFAULT NULL,
  `section_type` enum('content','list') NOT NULL DEFAULT 'content',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_legal_sections_document_order` (`document_id`,`sort_order`),
  CONSTRAINT `fk_legal_sections_document` FOREIGN KEY (`document_id`) REFERENCES `legal_documents` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `legal_sections` (`id`, `document_id`, `title`, `content`, `section_type`, `sort_order`) VALUES
(1, 1, 'Effective Date: ', '03 May 2026', 'content', 0),
(2, 1, 'Must Read Privacy Policy', NULL, 'list', 1),
(3, 2, 'Overview', 'The vision of <i>STATE CORPS ENGINEERING</i> President is enshrined in this policy and our anti-corruption and transparency efforts. It states that each <i>STATE CORPS ENGINEERING</i> employee and customer must be treated with respect and dignity. As employees, officers, and representatives of <i>STATE CORPS ENGINEERING</i>, we have a duty to live by honesty and integrity and abide by all applicable laws and regulations. This also includes a duty to report when other <i>STATE CORPS ENGINEERING</i> employees violate laws or regulations, or internal <i>STATE CORPS ENGINEERING</i> policies, such as our Gift and Donations Policy, Code of Conduct, of Business Ethics.', 'content', 0),
(4, 2, 'Responsibility to Report', 'All <i>STATE CORPS ENGINEERING</i> employees, directors and officers have a duty to immediately report in good faith real or suspected violations. Such violations should be reported to your supervisor first. All <i>\r\n                STATE CORPS ENGINEERING</i> supervisors have a duty to report all instances of fraud, unethical behavior, or corruption. If you are uncomfortable with reporting it to your supervisor, report it in confidentiality to Whistleblower@StateCorps.com. The individuals who report on such activities will be rewarded, if proven correct. Our company has no tolerance of individuals engaging in fraud, unethical behavior, or corruption.', 'content', 1),
(5, 2, 'Protection and Confidentiality', 'All <i>STATE CORPS ENGINEERING</i> employees, directors, and officers who report violations of laws or regulations or internal <i>STATE CORPS ENGINEERING</i> policies will be protected and not retaliated against. No <i>STATE CORPS ENGINEERING</i> employee, director, and officer will be harassed, or threatened. All harassment or threats must be immediately reported, if any. All <i>STATE CORPS ENGINEERING</i> employees may submit reports of violations in confidence and anonymously. Such reports will be kept confidential to the extent possible to best facilitate thorough investigation.', 'content', 2),
(6, 2, 'Accounting Discrepancies', 'All accounting discrepancies must be immediately reported. <i>STATE CORPS ENGINEERING</i> Compliance Officer will take immediate action to investigate such reports.', 'content', 3),
(7, 2, 'Good Faith Reporting', 'All reports of violations of laws and regulations must be made in good faith and based on reasonable grounds. For our Whistleblower Policy to work, all reports must not be made maliciously or falsely. Such malicious or false reports will be viewed as a serious disciplinary matter.Acknowledgement Each <i>STATE CORPS ENGINEERING</i> employee, officer, or supervisor who reports a violation will receive an acknowledgement within 3 days. All reports will be investigated and corrective actions, if any, will be made based on the findings and recommendation.All investigations warranting corrective actions must be legally reviewed.', 'content', 4),
(8, 3, 'Effective Date: ', '03 May 2026', 'content', 0),
(9, 3, 'Must Read Trademarks Policy', NULL, 'list', 1),
(10, 4, 'Effective Date: ', '03 May 2026', 'content', 0),
(11, 4, 'Must Read Terms of Service', NULL, 'list', 1);

-- --------------------------------------------------------
-- Table: legal_section_items

DROP TABLE IF EXISTS `legal_section_items`;
CREATE TABLE `legal_section_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `section_id` int(10) unsigned NOT NULL,
  `item_text` longtext NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_legal_section_items_section_order` (`section_id`,`sort_order`),
  CONSTRAINT `fk_legal_section_items_section` FOREIGN KEY (`section_id`) REFERENCES `legal_sections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `legal_section_items` (`id`, `section_id`, `item_text`, `sort_order`) VALUES
(1, 2, 'At StateCorps, we are committed to protecting your privacy and handling your personal information responsibly. This Privacy Policy explains how we collect, use, and safeguard the information you provide when visiting our website or contacting us.', 0),
(2, 2, 'We may collect personal information such as your name, email address, phone number, company name, and any details you voluntarily submit through our contact forms. We may also collect basic technical information, including your IP address, browser type, and website usage data, to improve website performance and security.', 1),
(3, 2, 'Your information is used to respond to your inquiries, provide our services, improve our website, communicate with you about our business, and maintain the security and functionality of our systems.', 2),
(4, 2, 'StateCorps does not sell, rent, or trade your personal information. We may share information only with trusted service providers who support our operations or when required by applicable laws or legal authorities.', 3),
(5, 2, 'We implement appropriate technical and organizational measures to protect your information from unauthorized access, disclosure, alteration, or loss.', 4),
(6, 2, 'Our website may use cookies to improve your browsing experience. You can manage cookie preferences through your browser settings.', 5),
(7, 2, 'By using our website, you agree to this Privacy Policy. We may update this policy periodically, and any changes will be posted on this page with a revised effective date.', 6),
(8, 2, 'If you have any questions about this Privacy Policy or your personal information, please contact us at privacy@statecorps.com.', 7),
(9, 9, 'All trademarks, logos, service marks, trade names, and other branding displayed on the StateCorps website are the property of StateCorps or their respective owners and are protected by applicable trademark and intellectual property laws.', 0),
(10, 9, 'You may not copy, reproduce, modify, distribute, or use any StateCorps trademarks, logos, or branding without our prior written permission. Unauthorized use that may cause confusion, imply endorsement, or misrepresent an association with StateCorps is strictly prohibited.', 1),
(11, 9, 'You may refer to the StateCorps name for factual or informational purposes, provided such use is accurate, lawful, and does not suggest sponsorship, partnership, or approval by StateCorps.', 2),
(12, 9, 'If you wish to use our trademarks, logos, or brand assets for business, media, partnership, or promotional purposes, you must obtain written authorization from StateCorps in advance.', 3),
(13, 9, 'StateCorps reserves all rights to its intellectual property and may take appropriate legal action against unauthorized or improper use of its trademarks or branding.', 4),
(14, 9, 'For trademark permissions, licensing requests, or to report unauthorized use, please contact us at comms@statecorps.com.', 5),
(15, 11, 'Welcome to StateCorps. By accessing or using our website, you agree to these Terms of Service.', 0),
(16, 11, 'You agree to use our website only for lawful purposes and not to engage in any activity that may damage, disrupt, or interfere with our services or the experience of other users.', 1),
(17, 11, 'All content on this website, including text, images, logos, graphics, documents, and other materials, is the property of StateCorps unless otherwise stated. You may not copy, reproduce, distribute, or use any content without our prior written permission', 2),
(18, 11, 'While we strive to keep the information on our website accurate and up to date, we do not guarantee that all content is complete, accurate, or error-free. The website and its content are provided on an \'as is\' and \'as available\' basis.', 3),
(19, 11, 'StateCorps is not responsible for any direct or indirect loss or damage resulting from the use of this website or reliance on its content.', 4),
(20, 11, 'We may update, modify, or discontinue any part of our website or these Terms of Service at any time without prior notice. Continued use of the website after changes are posted constitutes acceptance of the updated terms.', 5),
(21, 11, 'If you have any questions regarding these Terms of Service, please contact us at comms@statecorps.com ', 6),
(22, 11, 'Thank you for visiting StateCorps.', 7);

-- --------------------------------------------------------
-- Table: login_attempts

DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE `login_attempts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `success` tinyint(1) NOT NULL DEFAULT 0,
  `attempted_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_login_attempts_username` (`username`,`attempted_at`),
  KEY `idx_login_attempts_ip` (`ip_address`,`attempted_at`),
  KEY `idx_login_attempts_time` (`attempted_at`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `login_attempts` (`id`, `username`, `ip_address`, `success`, `attempted_at`) VALUES
(1, 'afs@sc.w', '::1', 0, '2026-09-06 20:40:06'),
(2, 'top@1', '::1', 0, '2026-09-06 20:40:31'),
(3, 'afs@sc.w', '::1', 1, '2026-09-06 20:41:27'),
(4, 'afs@sc.w', '::1', 1, '2026-09-07 08:58:40'),
(5, 'afs@sc.w', '::1', 1, '2026-09-07 09:37:26'),
(6, 'afs@sc.w', '::1', 0, '2026-09-07 09:47:27'),
(7, 'demo1', '::1', 1, '2026-09-07 09:47:43'),
(8, 'afs@sc.w', '::1', 1, '2026-09-07 10:11:30'),
(9, 'demo1', '::1', 1, '2026-09-07 10:26:35'),
(10, 'afs@sc.w', '::1', 1, '2026-09-07 10:52:53'),
(11, 'afs@sc.w', '::1', 1, '2026-09-07 11:43:30'),
(12, 'afs@sc.w', '::1', 1, '2026-09-07 13:20:18'),
(13, 'afs@sc.w', '::1', 1, '2026-09-08 15:24:53'),
(14, 'afs@sc.w', '::1', 1, '2026-09-08 15:26:56'),
(15, 'afs@sc.w', '::1', 1, '2026-09-08 16:23:08'),
(16, 'afs@sc.w', '::1', 1, '2026-09-08 16:23:56'),
(17, 'afs@sc.w', '::1', 1, '2026-09-08 17:05:14'),
(18, 'afs@sc.w', '::1', 1, '2026-09-08 17:18:21'),
(19, 'afs@sc.w', '::1', 1, '2026-09-09 16:36:59'),
(20, 'demo1', '::1', 1, '2026-09-09 16:43:12'),
(21, 'afs@sc.w', '::1', 1, '2026-09-09 16:43:22'),
(22, 'demo1', '::1', 1, '2026-09-09 16:44:32'),
(23, 'demo1', '::1', 1, '2026-09-09 17:49:53'),
(24, 'demo1', '::1', 1, '2026-09-09 18:49:25'),
(25, 'demo1', '::1', 1, '2026-09-09 20:07:19'),
(26, 'afs@sc.w', '::1', 1, '2026-09-09 20:25:55'),
(27, 'afs@sc.w', '::1', 1, '2026-09-10 08:33:36'),
(28, 'afs@sc.w', '::1', 1, '2026-09-10 09:06:17'),
(29, 'afs@sc.w', '::1', 1, '2026-09-10 09:07:18'),
(30, 'afs@sc.w', '::1', 1, '2026-09-10 10:11:28'),
(31, 'afs@sc.w', '::1', 1, '2026-09-10 11:14:21'),
(32, 'afs@sc.w', '::1', 1, '2026-09-10 12:38:16'),
(33, 'afs@sc.w', '::1', 1, '2026-09-10 14:43:07'),
(34, 'afs@sc.w', '::1', 1, '2026-09-10 15:32:49'),
(35, 'afs@sc.w', '::1', 1, '2026-09-12 09:57:47'),
(36, 'afs@sc.w', '::1', 1, '2026-09-12 10:45:54'),
(37, 'afs@sc.w', '::1', 1, '2026-09-12 11:21:08'),
(38, 'afs@sc.w', '::1', 1, '2026-09-12 15:54:02'),
(39, 'afs@sc.w', '::1', 1, '2026-09-12 16:31:32'),
(40, 'afs@sc.w', '::1', 1, '2026-09-12 16:34:30'),
(41, 'afs@sc.w', '::1', 1, '2026-09-12 16:41:58'),
(42, 'demo1', '::1', 1, '2026-09-12 16:42:13'),
(43, 'afs@sc.w', '::1', 1, '2026-09-12 16:42:25'),
(44, 'afs@sc.w', '::1', 1, '2026-09-12 18:41:26'),
(45, 'afs@sc.w', '::1', 1, '2026-09-12 19:59:27'),
(46, 'afs@sc.w', '::1', 1, '2026-09-12 21:11:45'),
(47, 'afs@sc.w', '::1', 1, '2026-09-13 08:21:46'),
(48, 'afs@sc.w', '::1', 1, '2026-09-13 08:52:49'),
(49, 'afs@sc.w', '::1', 1, '2026-09-13 10:16:03'),
(50, 'afs@sc.w', '::1', 1, '2026-09-13 11:19:07'),
(51, 'afs@sc.w', '::1', 1, '2026-09-13 13:07:49'),
(52, 'afs@sc.w', '::1', 1, '2026-09-13 14:17:34'),
(53, 'afs@sc.w', '::1', 1, '2026-09-13 15:14:58'),
(54, 'afs@sc.w', '::1', 1, '2026-09-13 22:11:34'),
(55, 'afs@sc.w', '::1', 1, '2026-09-15 17:16:50'),
(56, 'afs@sc.w', '::1', 1, '2026-09-16 13:24:22'),
(57, 'afs@sc.w', '::1', 1, '2026-09-16 15:27:55'),
(58, 'afs@sc.w', '::1', 1, '2026-09-16 15:52:51'),
(59, 'afs@sc.w', '::1', 1, '2026-09-16 16:27:51'),
(60, 'afs@sc.w', '::1', 1, '2026-09-20 13:58:38'),
(61, 'afs@sc.w', '::1', 1, '2026-09-20 14:26:41'),
(62, 'afs@sc.w', '::1', 1, '2026-09-20 15:20:06'),
(63, 'afs@sc.w', '::1', 1, '2026-09-21 09:01:47'),
(64, 'afs@sc.w', '::1', 1, '2026-09-21 10:08:23'),
(65, 'afs@sc.w', '::1', 1, '2026-09-21 10:34:54');

-- --------------------------------------------------------
-- Table: media_descriptions

DROP TABLE IF EXISTS `media_descriptions`;
CREATE TABLE `media_descriptions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `media_item_id` int(10) unsigned NOT NULL,
  `description_text` longtext NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_media_descriptions_item_order` (`media_item_id`,`sort_order`),
  CONSTRAINT `fk_media_descriptions_item` FOREIGN KEY (`media_item_id`) REFERENCES `media_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `media_descriptions` (`id`, `media_item_id`, `description_text`, `sort_order`) VALUES
(1, 1, 'State Corps has signed a USD 28.4 million Design-Build agreement for the electrification of Qush Tepa and Darzaab districts in Jawzjan Province. The agreement marks a significant milestone in expanding the country\'s power infrastructure and improving access to reliable electricity for local communities.', 0),
(2, 1, 'The project includes the design, supply, construction, testing, and commissioning of 85.24 km of 220 kV transmission lines, a new 220 kV line bay at the existing Pul-e-Khorasan Substation, two new 220/20 kV substations, and comprehensive 20/0.4 kV distribution networks. The new infrastructure will strengthen the regional transmission system while delivering reliable electricity to households, businesses, and public facilities across both districts.', 1),
(3, 1, 'Scheduled for completion within 36 months, the project reflects State Corps\' commitment to delivering high-quality engineering solutions that meet international standards. Upon completion, it will enhance energy accessibility, support regional economic development, and contribute to the long-term modernization of Afghanistan\'s national power infrastructure.', 2),
(4, 2, 'State Corps and METQ have signed a USD 69.5 million strategic agreement for the development of five major power infrastructure projects connecting Afghanistan and Uzbekistan. The program includes the 201 km Surkhan–Dashti Alwan 500 kV transmission line, 114 km Kabul–Jalalabad 220 kV transmission line, and key substation projects at Dashti Alwan, Shaikh Mesri, and Arghandi.', 0),
(5, 2, 'The projects will be delivered through comprehensive EPC and turnkey solutions, including engineering, procurement, construction, installation, testing, commissioning, and grid integration. The scope covers high-voltage transmission lines, AIS substations, transformer bays, line bays, and advanced shunt reactor systems to enhance network reliability and stability.', 1),
(6, 2, 'With a planned implementation period of 24 months, the initiative will strengthen Afghanistan’s national grid, improve transmission capacity, support regional energy connectivity, and contribute to long-term power system development.', 2),
(9, 4, 'State Corps is implementing a series of major electricity infrastructure projects in northern Afghanistan with a total value of nearly AFN 4 billion, aimed at expanding reliable electricity access and strengthening regional power networks across Jawzjan, Sar-e Pul, and Faryab provinces.', 0),
(10, 4, 'The projects include the construction of new 110 kV and 220 kV transmission lines, development of multiple substations, line bay extensions, and complete 20/0.4 kV distribution networks in Qush Tepa and Darzaab districts of Jawzjan, Sangcharak, Sozma Qala, and Gosfandi districts of Sar-e Pul, as well as Balchiragh, Garziwan, and Pashtun Kot districts of Faryab. The scope covers survey, design, supply, installation, testing, and commissioning of complete power infrastructure systems.', 1),
(11, 4, 'With an implementation period of 36 months, these projects will significantly enhance electricity availability for local communities, improve regional grid connectivity, create new economic opportunities, and contribute to the long-term development of Afghanistan’s energy infrastructure.', 2),
(12, 5, 'Construction and completion of the 220kV single circuit transmission line from Logar to Gardiz.', 0),
(27, 3, 'The key participants of this event will be:  China, Iran, India, Uzbekistan, and Kirgizstan. As well as the local market main players will participate in this event', 0),
(28, 3, 'The event held in Kabul, Afghanistan, special focus on Construction, Machinery, Innovation in construction, Foundations, Energy Mechanical & Green Energy, Design & Engineering, Financial Services &Banking, International NGOs and Mining Machinery Sectors.', 1);

-- --------------------------------------------------------
-- Table: media_items

DROP TABLE IF EXISTS `media_items`;
CREATE TABLE `media_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `legacy_id` varchar(100) DEFAULT NULL,
  `media_type` enum('news','events','gallery') NOT NULL,
  `media_date` varchar(100) DEFAULT NULL,
  `media_date_sort` date DEFAULT NULL,
  `title` varchar(500) NOT NULL,
  `external_link` varchar(1000) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `media_asset_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_media_legacy_id` (`legacy_id`),
  KEY `idx_media_type` (`media_type`),
  KEY `idx_media_date` (`media_date_sort`),
  KEY `idx_media_order` (`sort_order`),
  KEY `idx_media_items_public` (`media_type`,`is_active`,`sort_order`,`media_date_sort`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `media_items` (`id`, `legacy_id`, `media_type`, `media_date`, `media_date_sort`, `title`, `external_link`, `sort_order`, `is_active`, `created_at`, `updated_at`, `media_asset_id`) VALUES
(1, 'n1', 'news', '23 Dec, 2025', '2025-12-23', 'State Corps Signs USD 28.4 Million Agreement for the Electrification of Qush Tepa and Darzaab Districts of Jawzjan province', 'https://pajhwok.com/2025/12/23/power-project-signed-to-electrify-47000-jawzjan-homes/', 0, 1, '2026-09-06 19:06:12', '2026-09-21 10:34:08', 313),
(2, 'n2', 'news', '23 Dec, 2025', '2025-12-23', 'State Corps and METQ Sign USD 69.5 Million Agreement for Afghan–Uzbek Power Infrastructure Projects', 'https://gmic.gov.af/en/news_details/188', 1, 1, '2026-09-06 19:06:12', '2026-09-21 10:34:08', 311),
(3, 'e1', 'events', '12 Feb, 2026', '2026-02-12', 'Afghanistan 2rd Exhibition on Construction, Rehabilitation, and Energy Sectors', NULL, 0, 1, '2026-09-06 19:06:12', '2026-09-21 10:34:08', 312),
(4, 'n3', 'events', '28 Apr, 2026', '2026-04-28', 'State Corps Launches AFN 4 billion Electrification Projects Across Jawzjan, Sar-e Pul, and Faryab Provinces', NULL, 1, 1, '2026-09-06 19:06:12', '2026-09-21 10:34:08', 314),
(5, 'g1', 'gallery', '3 Dec,2024', '2024-12-03', 'Logar-Gardiz Transmission Line', NULL, 0, 1, '2026-09-06 19:06:12', '2026-09-21 10:34:08', 241);

-- --------------------------------------------------------
-- Table: media_item_tags

DROP TABLE IF EXISTS `media_item_tags`;
CREATE TABLE `media_item_tags` (
  `media_item_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`media_item_id`,`tag_id`),
  KEY `fk_media_item_tags_tag` (`tag_id`),
  KEY `idx_media_item_tags_item` (`media_item_id`,`tag_id`),
  CONSTRAINT `fk_media_item_tags_media` FOREIGN KEY (`media_item_id`) REFERENCES `media_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_media_item_tags_tag` FOREIGN KEY (`tag_id`) REFERENCES `media_tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `media_item_tags` (`media_item_id`, `tag_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(2, 1),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 11),
(2, 12),
(2, 13),
(2, 14),
(2, 15),
(3, 3),
(3, 16),
(3, 17),
(3, 18),
(4, 3),
(4, 4),
(4, 8),
(4, 19),
(4, 20),
(4, 21),
(5, 3),
(5, 6);

-- --------------------------------------------------------
-- Table: media_library

DROP TABLE IF EXISTS `media_library`;
CREATE TABLE `media_library` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `original_name` varchar(255) NOT NULL,
  `stored_name` varchar(255) NOT NULL,
  `relative_path` varchar(500) NOT NULL,
  `mime_type` varchar(100) NOT NULL,
  `file_size` bigint(20) unsigned NOT NULL,
  `checksum` char(64) DEFAULT NULL,
  `width_px` int(10) unsigned DEFAULT NULL,
  `height_px` int(10) unsigned DEFAULT NULL,
  `alt_text` varchar(500) DEFAULT NULL,
  `category` varchar(80) DEFAULT NULL,
  `status` enum('active','archived') NOT NULL DEFAULT 'active',
  `storage_scope` varchar(20) NOT NULL DEFAULT 'upload',
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_media_library_path` (`relative_path`),
  KEY `idx_media_library_type` (`mime_type`),
  KEY `idx_media_library_category` (`category`),
  KEY `idx_media_library_created` (`created_at`),
  KEY `fk_media_library_created_by` (`created_by`),
  KEY `idx_media_library_relative_path` (`relative_path`),
  KEY `idx_media_library_mime` (`mime_type`),
  KEY `idx_media_library_scope` (`storage_scope`),
  KEY `idx_media_library_checksum` (`checksum`),
  CONSTRAINT `fk_media_library_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=474 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `media_library` (`id`, `original_name`, `stored_name`, `relative_path`, `mime_type`, `file_size`, `checksum`, `width_px`, `height_px`, `alt_text`, `category`, `status`, `storage_scope`, `created_by`, `created_at`, `updated_at`) VALUES
(238, '11.jpg', '11.jpg', 'assets/uploads/legacy/20260921_073447/11.jpg', 'image/jpeg', 355444, 'd71f62f4efcb42025f2f1a2dcb2e804cb5f904161539d6bfbb476e63ce4ff362', 960, 640, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:48', '2026-09-21 10:04:48'),
(239, '12.jpg', '12.jpg', 'assets/uploads/legacy/20260921_073447/12.jpg', 'image/jpeg', 363498, 'bc5e6231a34a758996d0045db3aeb2a437124c403699199c99b9820a43152a2a', 960, 640, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:48', '2026-09-21 10:04:48'),
(240, '1_Jobs.jpg', '1_Jobs.jpg', 'assets/uploads/legacy/20260921_073447/1_Jobs.jpg', 'image/jpeg', 69996, '6ebf322269a400f4571ceef2d3ef97946acc1328701e4e0e782409e1ed935419', 825, 582, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:48', '2026-09-21 10:04:48'),
(241, '2.jpg', '2.jpg', 'assets/uploads/legacy/20260921_073447/2.jpg', 'image/jpeg', 405532, 'ac5d0e33e683e670f215a06c8aaecb6f0fefa40dce5a3caaed1975460829c1ca', 960, 640, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:49', '2026-09-21 10:04:49'),
(242, '3.jpg', '3.jpg', 'assets/uploads/legacy/20260921_073447/3.jpg', 'image/jpeg', 370625, '2dbb2fcc0bef177dcab390fe0f45612f0a3156f4e9156d26fc7248c058e540c9', 960, 640, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:49', '2026-09-21 10:04:49'),
(243, '4.jpg', '4.jpg', 'assets/uploads/legacy/20260921_073447/4.jpg', 'image/jpeg', 461665, '91e1422529049a96500b8f0dec4446de8ebced7e2ef5ef248df5467d64b450f4', 960, 640, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:49', '2026-09-21 10:04:49'),
(244, '6.jpg', '6.jpg', 'assets/uploads/legacy/20260921_073447/6.jpg', 'image/jpeg', 466325, 'a7db458417b39235e70bc408884b8a2f1a88c36230185b9bcff43f3ff0042b0e', 960, 640, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:49', '2026-09-21 10:04:49'),
(245, '7.jpg', '7.jpg', 'assets/uploads/legacy/20260921_073447/7.jpg', 'image/jpeg', 444407, '269dd26de117ce497dc554b78f8731491f9c86f3e8b59135e4fe4db4a4b429ca', 960, 640, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:49', '2026-09-21 10:04:49'),
(246, '8.jpg', '8.jpg', 'assets/uploads/legacy/20260921_073447/8.jpg', 'image/jpeg', 395573, '13f3bc18d4cab73ef1d407c9ba97492cacdb8a1dbbb811e130b76cac3b25db88', 960, 640, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:49', '2026-09-21 10:04:49'),
(247, '9.jpg', '9.jpg', 'assets/uploads/legacy/20260921_073447/9.jpg', 'image/jpeg', 347728, '24c28a583fda0732f5b0b07d3f64969596ea3c644a6b955e44789711b2ac41bf', 960, 640, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:49', '2026-09-21 10:04:49'),
(248, '0925-kabul.jpeg', '0925-kabul.jpeg', 'assets/uploads/legacy/20260921_073447/0925-kabul.jpeg', 'image/jpeg', 1270488, '2ea2770bff32a9717a10e7744b3ea9ccb5b83fc28421229add9f3a3d84713d03', 2560, 1706, NULL, 'about', 'active', 'upload', NULL, '2026-09-21 10:04:50', '2026-09-21 10:04:50'),
(249, 'presenceindex.jpeg', 'presenceindex.jpeg', 'assets/uploads/legacy/20260921_073447/presenceindex.jpeg', 'image/jpeg', 196135, '48c7391cd20e20238f7e0d9fe192dd0a2e878e368b1a5dc585fda522fadad240', 1600, 900, NULL, 'about', 'active', 'upload', NULL, '2026-09-21 10:04:50', '2026-09-21 10:04:50'),
(250, 'projectsmaliston.png', 'projectsmaliston.png', 'assets/uploads/legacy/20260921_073447/projectsmaliston.png', 'image/png', 1251586, '23277482bab88bd0079a752145e8a4253f4f42654b4e76282d283e60002d91fe', 1672, 941, NULL, 'about', 'active', 'upload', NULL, '2026-09-21 10:04:50', '2026-09-21 10:04:50'),
(251, 'About_new.jpg', 'About_new.jpg', 'assets/uploads/legacy/20260921_073447/About_new.jpg', 'image/jpeg', 415706, '0e655dff966c440f5474d93a4d40935d43834d39ce637ad2a77264c28bfd2843', 1366, 400, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:50', '2026-09-21 10:04:50'),
(252, 'ancop.jpg', 'ancop.jpg', 'assets/uploads/legacy/20260921_073447/ancop.jpg', 'image/jpeg', 95182, 'b05f114d2d5b42c6a6a5b8d4d712eca7a7c5820834044a8f80deb976ce7502e9', 503, 377, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:50', '2026-09-21 10:04:50'),
(253, 'andu.jpg', 'andu.jpg', 'assets/uploads/legacy/20260921_073447/andu.jpg', 'image/jpeg', 294406, '60870db5fc961b075fcf534575e9d1f48d2ede94ee0c8f69e3c6889dafc720f3', 800, 537, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:50', '2026-09-21 10:04:50'),
(254, '1_Cert.jpg', '1_Cert.jpg', 'assets/uploads/legacy/20260921_073447/1_Cert.jpg', 'image/jpeg', 150282, 'bd0068d40db1f1d4a913a5572ec624ebec411ea2abd8f3e917e4be63dce1f74e', 720, 544, NULL, 'awards', 'active', 'upload', NULL, '2026-09-21 10:04:51', '2026-09-21 10:04:51'),
(255, '2_Cert.jpg', '2_Cert.jpg', 'assets/uploads/legacy/20260921_073447/2_Cert.jpg', 'image/jpeg', 96062, 'b4e83ceeb33ac81e0071b31b8901fd7dc83bfd20d4f43d4aef6b240149bbf0a0', 705, 528, NULL, 'awards', 'active', 'upload', NULL, '2026-09-21 10:04:51', '2026-09-21 10:04:51'),
(256, '3_Cert.jpg', '3_Cert.jpg', 'assets/uploads/legacy/20260921_073447/3_Cert.jpg', 'image/jpeg', 91215, 'ec49a42a9c308ef92c43cc392322652e8513c30209ad1ef1a04b9510bf20e4bc', 664, 526, NULL, 'awards', 'active', 'upload', NULL, '2026-09-21 10:04:51', '2026-09-21 10:04:51'),
(257, 'beco-expo-cert.png', 'beco-expo-cert.png', 'assets/uploads/legacy/20260921_073447/beco-expo-cert.png', 'image/png', 773300, '25bc5672c379256bda2330b4c73f99ff75457c07ef3aaf0c7aa90a9db1b14902', 1118, 791, NULL, 'awards', 'active', 'upload', NULL, '2026-09-21 10:04:51', '2026-09-21 10:04:51'),
(258, 'VAT-certificate.png', 'VAT-certificate.png', 'assets/uploads/legacy/20260921_073447/VAT-certificate.png', 'image/png', 970167, '975c84f19537655e5c5bc34d7726760de91ecd3fd5ba0b4be27fa2635b867d56', 1232, 869, NULL, 'awards', 'active', 'upload', NULL, '2026-09-21 10:04:51', '2026-09-21 10:04:51'),
(259, 'client01.jpg', 'client01.jpg', 'assets/uploads/legacy/20260921_073447/client01.jpg', 'image/jpeg', 66564, '0bdf347ddeadd04ca0eede48644a0a78c6944b064e3a9bd35f43858df76be46d', 600, 300, NULL, 'clients', 'active', 'upload', NULL, '2026-09-21 10:04:51', '2026-09-21 10:04:51'),
(260, 'client_ABC_resized.png', 'client_ABC_resized.png', 'assets/uploads/legacy/20260921_073447/client_ABC_resized.png', 'image/png', 214339, '4ef19c3e84325542da50f2bbfc074a6d8895039a41536e82bcfb8a1336052084', 672, 371, NULL, 'clients', 'active', 'upload', NULL, '2026-09-21 10:04:52', '2026-09-21 10:04:52'),
(261, 'client_ADB_resized.png', 'client_ADB_resized.png', 'assets/uploads/legacy/20260921_073447/client_ADB_resized.png', 'image/png', 137421, 'dfb54f39e4158d0d215c66f528ad8b361ce03e8f59a9064d3e570acc152653b8', 800, 600, NULL, 'clients', 'active', 'upload', NULL, '2026-09-21 10:04:52', '2026-09-21 10:04:52'),
(262, 'client_dabs_resized.png', 'client_dabs_resized.png', 'assets/uploads/legacy/20260921_073447/client_dabs_resized.png', 'image/png', 221512, '62ba3b9fbe51071e79a6aeb72b4987a88027c37c2cbb7978cf25ad74605c269f', 800, 600, NULL, 'clients', 'active', 'upload', NULL, '2026-09-21 10:04:52', '2026-09-21 10:04:52'),
(263, 'client_dacaar.png', 'client_dacaar.png', 'assets/uploads/legacy/20260921_073447/client_dacaar.png', 'image/png', 63591, '1fe67af73ceb064c68911efe3da76292e23a195f5fa1ec439665fbf5bf47d6ff', 3060, 795, NULL, 'clients', 'active', 'upload', NULL, '2026-09-21 10:04:52', '2026-09-21 10:04:52'),
(264, 'client_fao_resized.png', 'client_fao_resized.png', 'assets/uploads/legacy/20260921_073447/client_fao_resized.png', 'image/png', 61967, 'ba6c16ae50cb14819657b24d78a5093edb30ef6f3aa7e30a00bbf3e9728303cc', 378, 112, NULL, 'clients', 'active', 'upload', NULL, '2026-09-21 10:04:52', '2026-09-21 10:04:52'),
(265, 'client_ghazanfar_group.jpg', 'client_ghazanfar_group.jpg', 'assets/uploads/legacy/20260921_073447/client_ghazanfar_group.jpg', 'image/jpeg', 5465, '55efda24c74e7ace9c1c90379ae55e82929d2d450de367b0865d42d75935e97b', 200, 200, NULL, 'clients', 'active', 'upload', NULL, '2026-09-21 10:04:52', '2026-09-21 10:04:52'),
(266, 'client_kabul_municipality.png', 'client_kabul_municipality.png', 'assets/uploads/legacy/20260921_073447/client_kabul_municipality.png', 'image/png', 197017, 'b30baaafdbcc9031b1c6e7d77fe23d0949f0590748f91bc3b91cc41287807873', 1920, 1637, NULL, 'clients', 'active', 'upload', NULL, '2026-09-21 10:04:52', '2026-09-21 10:04:52'),
(267, 'client_metq_resized.png', 'client_metq_resized.png', 'assets/uploads/legacy/20260921_073447/client_metq_resized.png', 'image/png', 290744, '9395d5540567a89bb6879ebed55c2a63d4b3dc02bf9799bab05d39670cb6fc6d', 800, 600, NULL, 'clients', 'active', 'upload', NULL, '2026-09-21 10:04:53', '2026-09-21 10:04:53'),
(268, 'client_mew_resized.png', 'client_mew_resized.png', 'assets/uploads/legacy/20260921_073447/client_mew_resized.png', 'image/png', 788579, 'bf0b26836f90f54ebb219e580f96ac4634c5efdf9308234f8893c255856d763a', 800, 800, NULL, 'clients', 'active', 'upload', NULL, '2026-09-21 10:04:53', '2026-09-21 10:04:53'),
(269, 'client_unama.png', 'client_unama.png', 'assets/uploads/legacy/20260921_073447/client_unama.png', 'image/png', 93234, '3631ca51592cb6c581026a15ae10cf112ca936f12e3c1afc693023187288ccbc', 856, 270, NULL, 'clients', 'active', 'upload', NULL, '2026-09-21 10:04:53', '2026-09-21 10:04:53'),
(270, 'client_unhcr.png', 'client_unhcr.png', 'assets/uploads/legacy/20260921_073447/client_unhcr.png', 'image/png', 181313, 'd7c5d9e722b402ca22bc8f5aaa936ac2024a115c0bf478d12d434c7cb1fd96c6', 983, 341, NULL, 'clients', 'active', 'upload', NULL, '2026-09-21 10:04:53', '2026-09-21 10:04:53'),
(271, 'client_unops_resized.png', 'client_unops_resized.png', 'assets/uploads/legacy/20260921_073447/client_unops_resized.png', 'image/png', 114419, '3d98b702f8b064290794d9ce81888e3ebb970f77c1c4801d3eb26d23828ba863', 800, 155, NULL, 'clients', 'active', 'upload', NULL, '2026-09-21 10:04:53', '2026-09-21 10:04:53'),
(272, 'client_usace_resized.png', 'client_usace_resized.png', 'assets/uploads/legacy/20260921_073447/client_usace_resized.png', 'image/png', 119890, '71f997567bfef58904454711d0193c108c4ec7be1b447e944ae27caa31a63f12', 800, 600, NULL, 'clients', 'active', 'upload', NULL, '2026-09-21 10:04:53', '2026-09-21 10:04:53'),
(273, 'client_wfp.png', 'client_wfp.png', 'assets/uploads/legacy/20260921_073447/client_wfp.png', 'image/png', 297276, 'f8bab52c0eec0853ecfa4029570afe326ba95e60a3b1f7b720cd2397c452bce6', 408, 612, NULL, 'clients', 'active', 'upload', NULL, '2026-09-21 10:04:53', '2026-09-21 10:04:53'),
(274, 'client_worldbank_resized.png', 'client_worldbank_resized.png', 'assets/uploads/legacy/20260921_073447/client_worldbank_resized.png', 'image/png', 176904, 'e447f18949e2242d7600ab3eb7cd40a288ba2445292b5aa065e8e028ae000d58', 741, 337, NULL, 'clients', 'active', 'upload', NULL, '2026-09-21 10:04:53', '2026-09-21 10:04:53'),
(275, 'Commercial Building.jpg', 'Commercial-Building.jpg', 'assets/uploads/legacy/20260921_073447/Commercial-Building.jpg', 'image/jpeg', 441357, 'b942f950047b7adfbc5df91ad2a26f76ea8a9a55f7786d4fe4d06f2fb5f10128', 1366, 400, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:54', '2026-09-21 10:04:54'),
(276, 'energy-sector-herat.jpeg', 'energy-sector-herat.jpeg', 'assets/uploads/legacy/20260921_073447/energy-sector-herat.jpeg', 'image/jpeg', 582898, '9e65033ab1d26cd2d34bc4583b3469c55d6af12a1a2d1aca38c71cd4aa28bcef', 1536, 1024, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:54', '2026-09-21 10:04:54'),
(277, 'favicon.png', 'favicon.png', 'assets/uploads/legacy/20260921_073447/favicon.png', 'image/png', 5854, '4848a87fd6fb5822541d0107b779d937d3a36f43ac75ae0617cef60a44dfcaf5', 86, 50, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:54', '2026-09-21 10:04:54'),
(278, 'favicon1.png', 'favicon1.png', 'assets/uploads/legacy/20260921_073447/favicon1.png', 'image/png', 12344, '36e9fbfc0ca8b48b4c27c6bc92a70b43622df69f00e6147f8b1f583ba591456a', 100, 100, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:54', '2026-09-21 10:04:54'),
(279, 'footerbg.jpg', 'footerbg.jpg', 'assets/uploads/legacy/20260921_073447/footerbg.jpg', 'image/jpeg', 202070, '7af69237215c8ebb5ee5a488e22f022de2e86130ea3bee73c88c236ac65ab83b', 1366, 420, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:54', '2026-09-21 10:04:54'),
(280, 'footerbgMobile.jpg', 'footerbgMobile.jpg', 'assets/uploads/legacy/20260921_073447/footerbgMobile.jpg', 'image/jpeg', 282707, '20e46180e49f9af2ae478a3f323bc897e2123254bb60ee8d823761052d01d4dd', 938, 689, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:54', '2026-09-21 10:04:54'),
(281, 'footerlogo.png', 'footerlogo.png', 'assets/uploads/legacy/20260921_073447/footerlogo.png', 'image/png', 58917, '024c67ec8d973c38a9a44f73cc1f46f89f759a79d076d90692506d018494b08f', 300, 212, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:54', '2026-09-21 10:04:54'),
(282, 'gardez.jpg', 'gardez.jpg', 'assets/uploads/legacy/20260921_073447/gardez.jpg', 'image/jpeg', 199000, 'f06179ae900cc446a8ec85f5f810da55e13ceab43b3177da0bffe4c14dd4f55a', 707, 363, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:55', '2026-09-21 10:04:55'),
(283, 'gardiz.jpg', 'gardiz.jpg', 'assets/uploads/legacy/20260921_073447/gardiz.jpg', 'image/jpeg', 383516, '2999684f36f7b013936eff92931ac31a034c28e3cdb117806756c366cf7fdd01', 968, 576, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:55', '2026-09-21 10:04:55'),
(284, 'growth.jpg', 'growth.jpg', 'assets/uploads/legacy/20260921_073447/growth.jpg', 'image/jpeg', 33344, 'ca5faaf4d4bca5598ec093325525de8047724e95effcd443613f328f278cf9ab', 612, 408, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:55', '2026-09-21 10:04:55'),
(285, 'gulbahar.jpg', 'gulbahar.jpg', 'assets/uploads/legacy/20260921_073447/gulbahar.jpg', 'image/jpeg', 296119, 'b852b95657485d965d4cbe5df95c27730a2d3ba6ac4294326ded4c73d386cc7a', 876, 576, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:55', '2026-09-21 10:04:55'),
(286, 'gulnijrab.jpg', 'gulnijrab.jpg', 'assets/uploads/legacy/20260921_073447/gulnijrab.jpg', 'image/jpeg', 288766, 'aeecece533e024bb20ce16d23fd10510d62cd0a464ef7699ab55a04a5d4b9e27', 1024, 768, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:55', '2026-09-21 10:04:55'),
(287, 'Herat SS_1.jpg', 'Herat-SS_1.jpg', 'assets/uploads/legacy/20260921_073447/Herat-SS_1.jpg', 'image/jpeg', 83417, 'b6e050eea0d78e4df71fc7dc7f116741b96b8c8a4611c1d2b0273e63434a0d36', 960, 574, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:55', '2026-09-21 10:04:55'),
(288, 'hero-image1.png', 'hero-image1.png', 'assets/uploads/legacy/20260921_073447/hero-image1.png', 'image/png', 1263177, '2152eb86419cbd3225c647364ee75ad7b07074435d2e20b4bfe96692adbeda7f', 960, 640, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:56', '2026-09-21 10:04:56'),
(289, 'hero-image2.jpg', 'hero-image2.jpg', 'assets/uploads/legacy/20260921_073447/hero-image2.jpg', 'image/jpeg', 1070057, '7852f8c7ef61e4dd0aae712aeb29333d35d9077da93a58c3a5b879cfedcb0c2e', 1650, 600, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:56', '2026-09-21 10:04:56'),
(290, 'hero-image3.jpg', 'hero-image3.jpg', 'assets/uploads/legacy/20260921_073447/hero-image3.jpg', 'image/jpeg', 895120, '4d24cff84966370e4166ce8e5b02c4bbb69201e4db548ced8df61e50ca570d79', 1650, 600, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:56', '2026-09-21 10:04:56'),
(291, 'homedeliveryexperince.jpeg', 'homedeliveryexperince.jpeg', 'assets/uploads/legacy/20260921_073447/homedeliveryexperince.jpeg', 'image/jpeg', 281266, '5edcc805f8b859652c71f969c6aa5e663533eccdc027f5eefada00b9f6c6d1da', 1024, 576, NULL, 'home', 'active', 'upload', NULL, '2026-09-21 10:04:56', '2026-09-21 10:04:56'),
(292, 'hero_energy1.jpg', 'hero_energy1.jpg', 'assets/uploads/legacy/20260921_073447/hero_energy1.jpg', 'image/jpeg', 1216429, '1389d2543a38156b05a9f29fc1ecee9058561f16fe254aeb5200e294a89dd73b', 1650, 600, NULL, 'slider_imgs', 'active', 'upload', NULL, '2026-09-21 10:04:56', '2026-09-21 10:04:56'),
(293, 'hero_mining1.png', 'hero_mining1.png', 'assets/uploads/legacy/20260921_073447/hero_mining1.png', 'image/png', 3202472, '89eb43683249eb967e8982dec1208683cdc332dacacfb0d5bab2789c93268367', 1675, 939, NULL, 'slider_imgs', 'active', 'upload', NULL, '2026-09-21 10:04:57', '2026-09-21 10:04:57'),
(294, 'hero_structure1.png', 'hero_structure1.png', 'assets/uploads/legacy/20260921_073447/hero_structure1.png', 'image/png', 2505394, 'f2496cbc642cde866317ddaf4697daca8e6e531b6a717b3392a8bec87e29a8aa', 1536, 1024, NULL, 'slider_imgs', 'active', 'upload', NULL, '2026-09-21 10:04:57', '2026-09-21 10:04:57'),
(295, 'hero_transportation1.jpg', 'hero_transportation1.jpg', 'assets/uploads/legacy/20260921_073447/hero_transportation1.jpg', 'image/webp', 382672, 'c0dc843c5ccf675837ec86484426a6222f5aeb029d283b7c0a8bc62bf8b5dfcb', 1491, 994, NULL, 'slider_imgs', 'active', 'upload', NULL, '2026-09-21 10:04:57', '2026-09-21 10:04:57'),
(296, 'hero_water1.jpg', 'hero_water1.jpg', 'assets/uploads/legacy/20260921_073447/hero_water1.jpg', 'image/jpeg', 2162337, '3565fb9bfa7e02442ba1712074bc02d489e40865efc9ec7ac3697adcea468296', 5365, 3769, NULL, 'slider_imgs', 'active', 'upload', NULL, '2026-09-21 10:04:57', '2026-09-21 10:04:57'),
(297, 'whybg1.jpg', 'whybg1.jpg', 'assets/uploads/legacy/20260921_073447/whybg1.jpg', 'image/png', 1454906, '0747249661ce047b3e11a628da33650065482b4a07ef4e0944e50beb3d39630e', 960, 640, NULL, 'home', 'active', 'upload', NULL, '2026-09-21 10:04:57', '2026-09-21 10:04:57'),
(298, 'hydropowerdam.jpg', 'hydropowerdam.jpg', 'assets/uploads/legacy/20260921_073447/hydropowerdam.jpg', 'image/jpeg', 118390, 'a72045f607ce109578a8ec0c32a716693e3da16ba89a1f379eb8f70b494322b2', 431, 307, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:57', '2026-09-21 10:04:57'),
(299, 'ISO1.jpg', 'ISO1.jpg', 'assets/uploads/legacy/20260921_073447/ISO1.jpg', 'image/jpeg', 159619, '230868a22f25f095a55e4834f6dcfd0a826104191c80319aa481b1dd0e729a26', 577, 829, NULL, 'ISO_Certificates', 'active', 'upload', NULL, '2026-09-21 10:04:58', '2026-09-21 10:04:58'),
(300, 'ISO2.jpg', 'ISO2.jpg', 'assets/uploads/legacy/20260921_073447/ISO2.jpg', 'image/jpeg', 159612, 'c13a0e00843a97fbaa9ce2bb51cbc25befd5ee900e2b2505e6bfd8c9848dfc6c', 576, 831, NULL, 'ISO_Certificates', 'active', 'upload', NULL, '2026-09-21 10:04:58', '2026-09-21 10:04:58'),
(301, 'ISO3.jpg', 'ISO3.jpg', 'assets/uploads/legacy/20260921_073447/ISO3.jpg', 'image/jpeg', 141484, 'e2b89fd8f30c1db83f79a509be15b95e2d841ec2d54d4acadb67abafd0392b9e', 571, 823, NULL, 'ISO_Certificates', 'active', 'upload', NULL, '2026-09-21 10:04:58', '2026-09-21 10:04:58'),
(302, 'jabulseraj.jpg', 'jabulseraj.jpg', 'assets/uploads/legacy/20260921_073447/jabulseraj.jpg', 'image/jpeg', 307790, '0a6c9de147385c4454fcb26d06c1ac99abc3abe3707f7b3e344de0363f56507a', 1024, 768, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:58', '2026-09-21 10:04:58'),
(303, 'jalaabad.jpg', 'jalaabad.jpg', 'assets/uploads/legacy/20260921_073447/jalaabad.jpg', 'image/jpeg', 251466, 'a82241e136f9806c519baa802c93d7da45471df369899be9df507504b71c54ef', 640, 480, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:58', '2026-09-21 10:04:58'),
(304, 'KM-LogoClient1.jpg', 'KM-LogoClient1.jpg', 'assets/uploads/legacy/20260921_073447/KM-LogoClient1.jpg', 'image/jpeg', 46324, 'f3539e76efecf338f3bed5f6ab6c9ed743c21790be17cd984355fdca59d685e1', 426, 387, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:58', '2026-09-21 10:04:58'),
(305, 'logargardiz.jpg', 'logargardiz.jpg', 'assets/uploads/legacy/20260921_073447/logargardiz.jpg', 'image/jpeg', 400542, '7fa3dd010488062a8ef97f4355740a849f0ca8ce102433082b35aaf9a6efe142', 1024, 768, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:58', '2026-09-21 10:04:58'),
(306, 'logistic.jpg', 'logistic.jpg', 'assets/uploads/legacy/20260921_073447/logistic.jpg', 'image/jpeg', 1325624, '7f5157ff59f4e7c8d190c4f8a575f697720fb2ae6a1797feeb8820431e01f339', 2048, 1536, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:59', '2026-09-21 10:04:59'),
(307, 'logo.png', 'logo.png', 'assets/uploads/legacy/20260921_073447/logo.png', 'image/png', 19094, 'db1b9f053bf3688a4c986458860ea4721cf1ceb5974f5fd8a4f94b7613852f82', 142, 110, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:59', '2026-09-21 10:04:59'),
(308, 'maintenance.jpg', 'maintenance.jpg', 'assets/uploads/legacy/20260921_073447/maintenance.jpg', 'image/jpeg', 497796, 'c10347ed69a2fda1ce09b7bd770586eeb192dd011a8a80aba56e01575e12ebf8', 1366, 342, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:59', '2026-09-21 10:04:59'),
(309, 'manpower.jpeg', 'manpower.jpeg', 'assets/uploads/legacy/20260921_073447/manpower.jpeg', 'image/jpeg', 318622, 'e4cd5f1ba684656905d2e60ee4ef42a233e6bc472f54fba80033063cb9390501', 1553, 686, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:59', '2026-09-21 10:04:59'),
(310, 'mazar.jpg', 'mazar.jpg', 'assets/uploads/legacy/20260921_073447/mazar.jpg', 'image/jpeg', 254916, '7001049aa8d2ab1f81e1dd6bfe178d4373d030081f2253991aaca4c76f380b68', 640, 480, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:04:59', '2026-09-21 10:04:59'),
(311, '0925-kabul.jpeg', '0925-kabul-1.jpeg', 'assets/uploads/legacy/20260921_073447/0925-kabul-1.jpeg', 'image/jpeg', 1270488, '2ea2770bff32a9717a10e7744b3ea9ccb5b83fc28421229add9f3a3d84713d03', 2560, 1706, NULL, 'media', 'active', 'upload', NULL, '2026-09-21 10:04:59', '2026-09-21 10:04:59'),
(312, '12-0226-beco.jpeg', '12-0226-beco.jpeg', 'assets/uploads/legacy/20260921_073447/12-0226-beco.jpeg', 'image/jpeg', 130039, '43959bb8d692a75b19b08859aac586bc39c68324aa6e727afd6119beac241f5d', 1432, 878, NULL, 'media', 'active', 'upload', NULL, '2026-09-21 10:04:59', '2026-09-21 10:04:59'),
(313, '23-1225-Jawzjan.jpeg', '23-1225-Jawzjan.jpeg', 'assets/uploads/legacy/20260921_073447/23-1225-Jawzjan.jpeg', 'image/jpeg', 430263, 'f39538c5832fc712190a0619f66505547e816606e392168b4b330a49fb8798eb', 1600, 1013, NULL, 'media', 'active', 'upload', NULL, '2026-09-21 10:04:59', '2026-09-21 10:04:59'),
(314, '28-0426-qoshtepa.jpg', '28-0426-qoshtepa.jpg', 'assets/uploads/legacy/20260921_073447/28-0426-qoshtepa.jpg', 'image/jpeg', 190489, '137f712953842df0787c006bdaa690e61120a0d84007175908789b2f64a615ab', 1280, 720, NULL, 'media', 'active', 'upload', NULL, '2026-09-21 10:04:59', '2026-09-21 10:04:59'),
(315, 'mehterlam.jpg', 'mehterlam.jpg', 'assets/uploads/legacy/20260921_073447/mehterlam.jpg', 'image/jpeg', 129444, '1e1fae70d68a456d212fbb15bbc32c94fbcb9da9e7a2597960dfccbc650d2298', 640, 480, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:00', '2026-09-21 10:05:00'),
(316, 'Moqur.jpg', 'Moqur.jpg', 'assets/uploads/legacy/20260921_073447/Moqur.jpg', 'image/jpeg', 239976, 'de0abf6a163ce9d0025d53dffbbc86d1c25a2251e3b5a87ce8285b0b557897c5', 1024, 505, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:00', '2026-09-21 10:05:00'),
(317, 'New Banner.jpg', 'New-Banner.jpg', 'assets/uploads/legacy/20260921_073447/New-Banner.jpg', 'image/jpeg', 1272325, '39cff93730beeb374a403a94a284a5567e9c660c5b672b0375ee5b9ef4c1296a', 1650, 600, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:00', '2026-09-21 10:05:00'),
(318, 'presence.png', 'presence.png', 'assets/uploads/legacy/20260921_073447/presence.png', 'image/png', 1002025, 'e7e4d46c6c3ded34b054dbf72f047f4783abe369f4b43cb180207a8e974ff06f', 6400, 3073, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:00', '2026-09-21 10:05:00'),
(319, 'presenceindex.jpeg', 'presenceindex-1.jpeg', 'assets/uploads/legacy/20260921_073447/presenceindex-1.jpeg', 'image/jpeg', 196135, '48c7391cd20e20238f7e0d9fe192dd0a2e878e368b1a5dc585fda522fadad240', 1600, 900, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:00', '2026-09-21 10:05:00'),
(320, '01-logar-gardiz-1.jpg', '01-logar-gardiz-1.jpg', 'assets/uploads/legacy/20260921_073447/01-logar-gardiz-1.jpg', 'image/jpeg', 370625, '2dbb2fcc0bef177dcab390fe0f45612f0a3156f4e9156d26fc7248c058e540c9', 960, 640, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:00', '2026-09-21 10:05:00'),
(321, '02-JabulSaraj-Gulbahar-1.jpeg', '02-JabulSaraj-Gulbahar-1.jpeg', 'assets/uploads/legacy/20260921_073447/02-JabulSaraj-Gulbahar-1.jpeg', 'image/jpeg', 207256, 'e7fbc7abca168bb902d1330445033c4368c91850f4a3180cfd16a5148fa387f2', 1280, 960, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:01', '2026-09-21 10:05:01'),
(322, '03-gulbahar-nijrab-1.png', '03-gulbahar-nijrab-1.png', 'assets/uploads/legacy/20260921_073447/03-gulbahar-nijrab-1.png', 'image/png', 963787, 'eea6d8825e66bb2c84226106b65a0793a13cfa743e2d0f131fd08dda6331374d', 820, 604, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:01', '2026-09-21 10:05:01'),
(323, '04-gardiz-1.png', '04-gardiz-1.png', 'assets/uploads/legacy/20260921_073447/04-gardiz-1.png', 'image/png', 6470168, 'ee15e5060df6bd303093ac6bedfe1a7ac2aa29fbd532c7fe0bcbd2615f0a118b', 2400, 1651, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:01', '2026-09-21 10:05:01'),
(324, '05-gulbahar-1.jpeg', '05-gulbahar-1.jpeg', 'assets/uploads/legacy/20260921_073447/05-gulbahar-1.jpeg', 'image/jpeg', 862152, '06e4622f5e9972718242f3ab8d2a9f74ba601e179dea1aabb00fabe5a8df0bc7', 2560, 1920, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:01', '2026-09-21 10:05:01'),
(325, '05-gulbahar-2.jpeg', '05-gulbahar-2.jpeg', 'assets/uploads/legacy/20260921_073447/05-gulbahar-2.jpeg', 'image/jpeg', 792857, 'db2da9172eb744258e0e47e472195eba35d64194e3d2b77533dc7b3a291fe611', 2560, 1920, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:01', '2026-09-21 10:05:01'),
(326, '05-gulbahar-3.jpeg', '05-gulbahar-3.jpeg', 'assets/uploads/legacy/20260921_073447/05-gulbahar-3.jpeg', 'image/jpeg', 1031044, '668effe4d8c983e770b22005d2b3f880e16b01b861dd70572dcafc335d0c52ba', 2560, 1920, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:01', '2026-09-21 10:05:01'),
(327, '06-kabul-1.png', '06-kabul-1.png', 'assets/uploads/legacy/20260921_073447/06-kabul-1.png', 'image/png', 269153, '52a2fd26b8827fe4e2bec50b82e760fba8df36cf2f9a2fd51550e7ff74b709d3', 380, 345, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:01', '2026-09-21 10:05:01'),
(328, '06-kabul-2.png', '06-kabul-2.png', 'assets/uploads/legacy/20260921_073447/06-kabul-2.png', 'image/png', 211240, '242f95c34f67dc8a18e9acb178cbe815c3940f9c7f66cbade763ba45e6043e16', 382, 344, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:02', '2026-09-21 10:05:02'),
(329, '06-kabul-3.png', '06-kabul-3.png', 'assets/uploads/legacy/20260921_073447/06-kabul-3.png', 'image/png', 230350, '2601ce97f44e0375b21d58dee48f3a6833efc17865cf2991fc87202a850d870d', 380, 343, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:02', '2026-09-21 10:05:02'),
(330, '06-kabul-4.png', '06-kabul-4.png', 'assets/uploads/legacy/20260921_073447/06-kabul-4.png', 'image/png', 264482, 'f4dfa7c875506410d934f09d264b9bfd04423d43c335ccc133ba3b4ac5bfe265', 380, 340, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:02', '2026-09-21 10:05:02'),
(331, '07-kabul-1.png', '07-kabul-1.png', 'assets/uploads/legacy/20260921_073447/07-kabul-1.png', 'image/jpeg', 184141, '204f102842de24550a15c3dbe9774a38a24988baa8c818bde47de58b0d72fea7', 1600, 549, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:02', '2026-09-21 10:05:02'),
(332, '07-kabul-2.png', '07-kabul-2.png', 'assets/uploads/legacy/20260921_073447/07-kabul-2.png', 'image/png', 93869, '751419d943edf26f2042d088a10c873a715bde7c5eb0e701b22a17ba53948307', 376, 230, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:02', '2026-09-21 10:05:02'),
(333, '07-kabul-3.png', '07-kabul-3.png', 'assets/uploads/legacy/20260921_073447/07-kabul-3.png', 'image/png', 272210, 'd05a76c6eb87b2376a9d52013bd5fcd3615b605127b7b1e689e17eefac48b631', 1037, 621, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:03', '2026-09-21 10:05:03'),
(334, '07-kabul-4.png', '07-kabul-4.png', 'assets/uploads/legacy/20260921_073447/07-kabul-4.png', 'image/png', 211857, 'd06bc5634666c777fddcc71277558a00c56dda201e793ea7cbfeaa2274a6ffcd', 1037, 621, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:03', '2026-09-21 10:05:03'),
(335, '07-kabul-5.png', '07-kabul-5.png', 'assets/uploads/legacy/20260921_073447/07-kabul-5.png', 'image/png', 335937, 'c10ac2660106d5137c5f7510fd0d6ee6c4b3a1047feb52f84e234e7c6773060f', 1037, 621, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:03', '2026-09-21 10:05:03'),
(336, '07-kabul-6.png', '07-kabul-6.png', 'assets/uploads/legacy/20260921_073447/07-kabul-6.png', 'image/png', 122186, 'ca053623192af1969c61444509e5c9f2513710b54631f774710cf1750f255cfb', 376, 226, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:03', '2026-09-21 10:05:03'),
(337, '08-kandahar-1.png', '08-kandahar-1.png', 'assets/uploads/legacy/20260921_073447/08-kandahar-1.png', 'image/png', 380483, 'd6fe9d8e17faccb26510a3d84725dbec1a8398b78a7b4874f7493c2c793340cc', 1037, 1014, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:03', '2026-09-21 10:05:03');
INSERT INTO `media_library` (`id`, `original_name`, `stored_name`, `relative_path`, `mime_type`, `file_size`, `checksum`, `width_px`, `height_px`, `alt_text`, `category`, `status`, `storage_scope`, `created_by`, `created_at`, `updated_at`) VALUES
(338, '09-balkh-1.png', '09-balkh-1.png', 'assets/uploads/legacy/20260921_073447/09-balkh-1.png', 'image/png', 853544, '0cf4bbea8e641fa9b4e3ffa8e114ebe3d00fe368aa0c77756464ab63e453a468', 1031, 1021, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:03', '2026-09-21 10:05:03'),
(339, '10-faryab-1.png', '10-faryab-1.png', 'assets/uploads/legacy/20260921_073447/10-faryab-1.png', 'image/png', 314123, 'eba65176e7ef0e2c0a9fd3d14bfb4b7e03d70303bbbed2954738abd938911490', 1037, 1325, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:03', '2026-09-21 10:05:03'),
(340, '11-balkh-1.png', '11-balkh-1.png', 'assets/uploads/legacy/20260921_073447/11-balkh-1.png', 'image/png', 1246982, '6567b0c4f4f12d4665cbc9edee255f96164cdf876afda9932c1fa9b68736de60', 1031, 1325, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:04', '2026-09-21 10:05:04'),
(341, '12-faryab-1.png', '12-faryab-1.png', 'assets/uploads/legacy/20260921_073447/12-faryab-1.png', 'image/png', 1079681, '59970b5fe83f97a1abcbc8bd23bb0b4c635819c2770c2b7d6ea797767116d0e6', 1037, 817, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:04', '2026-09-21 10:05:04'),
(342, '12-faryab-2.png', '12-faryab-2.png', 'assets/uploads/legacy/20260921_073447/12-faryab-2.png', 'image/png', 386249, 'c56243e851e30495105e9cf39ed74bd8ec6541b63b85fa0be356e3e1e0165dc0', 1031, 817, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:04', '2026-09-21 10:05:04'),
(343, '13-baghlan-1.png', '13-baghlan-1.png', 'assets/uploads/legacy/20260921_073447/13-baghlan-1.png', 'image/png', 469799, '5ba1c965b125049ef400aae26ff65372b948c37e95cb483cbc812f46f7aab4dc', 1037, 817, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:04', '2026-09-21 10:05:04'),
(344, '14-badakhshan-1.png', '14-badakhshan-1.png', 'assets/uploads/legacy/20260921_073447/14-badakhshan-1.png', 'image/png', 783434, 'ae186cf42def022bfa5c295f8d685261f5003df44d377644ab9c56ff006fa306', 1031, 817, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:04', '2026-09-21 10:05:04'),
(345, '15-paktia-1.png', '15-paktia-1.png', 'assets/uploads/legacy/20260921_073447/15-paktia-1.png', 'image/png', 720963, '311d93a597014df01b5e5e987e22daa0e6b65398837a28587deddd59a0b43c39', 1037, 818, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:04', '2026-09-21 10:05:04'),
(346, '15-paktia-2.png', '15-paktia-2.png', 'assets/uploads/legacy/20260921_073447/15-paktia-2.png', 'image/png', 757901, '8d315fc254170cd222cbd98adb4630dc97526a22f68aceb8c03c7cce4b981adb', 1037, 818, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:04', '2026-09-21 10:05:04'),
(347, '16-balkh-1.png', '16-balkh-1.png', 'assets/uploads/legacy/20260921_073447/16-balkh-1.png', 'image/png', 809242, 'dc5b85c67e24ce28279d8051b140688ff62b5fbad33ca300a6b6c39541a2c73f', 1036, 1325, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:05', '2026-09-21 10:05:05'),
(348, '17-logar-1.png', '17-logar-1.png', 'assets/uploads/legacy/20260921_073447/17-logar-1.png', 'image/png', 697955, '28053f99237b1b73bd277dcd91495b286f0d7ee55022cb3ffc835c413a59ee0b', 1031, 1325, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:05', '2026-09-21 10:05:05'),
(349, '18-logar-1.png', '18-logar-1.png', 'assets/uploads/legacy/20260921_073447/18-logar-1.png', 'image/png', 572397, '3f9f6b0e11d4f64b4f6c4f7bc32fbf067bf714c201e2a960c18192151a56bbc5', 1036, 1020, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:05', '2026-09-21 10:05:05'),
(350, '19-jawzjan-1.png', '19-jawzjan-1.png', 'assets/uploads/legacy/20260921_073447/19-jawzjan-1.png', 'image/png', 419835, '96b92c2ee39cf7603266a5e16d54916eda7644503c34d3cacd937eb936ae6dbc', 1031, 1020, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:05', '2026-09-21 10:05:05'),
(351, '20-daikundi-1.png', '20-daikundi-1.png', 'assets/uploads/legacy/20260921_073447/20-daikundi-1.png', 'image/png', 809762, 'e2bf56252205fd47c934495f58ba79ac5b92731a51491602a699d58eadc16450', 1036, 1325, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:05', '2026-09-21 10:05:05'),
(352, '21-khost-1.png', '21-khost-1.png', 'assets/uploads/legacy/20260921_073447/21-khost-1.png', 'image/png', 675566, 'ec010960e44edbd70ba40c1ba611de73662873b4704cc11245d999293b7630d2', 1031, 1325, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:05', '2026-09-21 10:05:05'),
(353, '22-kunduz-1.png', '22-kunduz-1.png', 'assets/uploads/legacy/20260921_073447/22-kunduz-1.png', 'image/png', 625663, '7eb30689601326e6ee2d8ad4243043e5e2008920e20b248e3bc0f5c7557705c5', 1036, 1020, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:05', '2026-09-21 10:05:05'),
(354, '23-faryab-1.png', '23-faryab-1.png', 'assets/uploads/legacy/20260921_073447/23-faryab-1.png', 'image/png', 627471, '2aa38af0d87be5802cde834a8abc2bcd67df324699c42cfa716cc66c622bc4fa', 1031, 1020, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:05', '2026-09-21 10:05:05'),
(355, '24-ghazni-1.png', '24-ghazni-1.png', 'assets/uploads/legacy/20260921_073447/24-ghazni-1.png', 'image/png', 905436, 'b6185fcb2f1447e1c2ccd869c5c6de8e2ab0dfab0dcabd15ee431825e70af3ba', 1037, 817, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:05', '2026-09-21 10:05:05'),
(356, '25-kabul-1.png', '25-kabul-1.png', 'assets/uploads/legacy/20260921_073447/25-kabul-1.png', 'image/png', 748312, '1fa9b92c6532f4421a923a41b02c17e705a87c335389858ed0d57eb9c04a1731', 1031, 817, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:06', '2026-09-21 10:05:06'),
(357, '26-ghazni-1.png', '26-ghazni-1.png', 'assets/uploads/legacy/20260921_073447/26-ghazni-1.png', 'image/png', 527916, '1e8830227051f36c9b4bc78b4cb071cf848dbdf2a2d82b412054c29a62818d70', 1037, 1727, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:06', '2026-09-21 10:05:06'),
(358, '27-takhar-1.png', '27-takhar-1.png', 'assets/uploads/legacy/20260921_073447/27-takhar-1.png', 'image/png', 966006, 'faa927bd8fc383e74b4fdd055eff8048c108206d33bf025fa322a91f04f362ff', 1031, 817, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:06', '2026-09-21 10:05:06'),
(359, '27-takhar-2.png', '27-takhar-2.png', 'assets/uploads/legacy/20260921_073447/27-takhar-2.png', 'image/png', 914560, '46fa38837fe0f8e86beff9815ba9149832d5dd8513f63293372ca76b882a4007', 1036, 818, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:06', '2026-09-21 10:05:06'),
(360, '28-1-kabul-1.jpeg', '28-1-kabul-1.jpeg', 'assets/uploads/legacy/20260921_073447/28-1-kabul-1.jpeg', 'image/jpeg', 533803, 'e4b90939da5cba30ac2bddf232535c61e62b6469ebc3f5cb69fb7ee2a2b4db49', 1536, 1024, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:06', '2026-09-21 10:05:06'),
(361, '28-balkh-1.png', '28-balkh-1.png', 'assets/uploads/legacy/20260921_073447/28-balkh-1.png', 'image/png', 1194651, '8530d04d6c580da32006e007818a55fc0cae9f5f16a855d40fec74422dcfcb50', 1037, 1325, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:06', '2026-09-21 10:05:06'),
(362, '29-laghman-1.png', '29-laghman-1.png', 'assets/uploads/legacy/20260921_073447/29-laghman-1.png', 'image/png', 556757, '5b5e53f27c56fc526e8c200eef91113dacd28afe933473a55f7c913c10d4aa29', 1031, 1325, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:06', '2026-09-21 10:05:06'),
(363, '30-ghazni-1.png', '30-ghazni-1.png', 'assets/uploads/legacy/20260921_073447/30-ghazni-1.png', 'image/png', 455404, '2d82eab44f3dab1dfd3886c5714f1f2bb66670de0bc830dde4b6ca70ae5fc3cc', 1037, 1020, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:06', '2026-09-21 10:05:06'),
(364, '31-nangarhar-1.png', '31-nangarhar-1.png', 'assets/uploads/legacy/20260921_073447/31-nangarhar-1.png', 'image/png', 778945, '2c83419ca6bc9e1be0a3656b73cb37306ca47b3454598edc977be70d36297bc8', 1031, 1020, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:07', '2026-09-21 10:05:07'),
(365, '32-kabul-1.png', '32-kabul-1.png', 'assets/uploads/legacy/20260921_073447/32-kabul-1.png', 'image/png', 547803, '654638a8b4ff39224aad0014a98eaf56963cea792433f43cb714203147a06b62', 1037, 817, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:07', '2026-09-21 10:05:07'),
(366, '32-kabul-2.png', '32-kabul-2.png', 'assets/uploads/legacy/20260921_073447/32-kabul-2.png', 'image/png', 500522, 'daf4abad91249b8c4d3e066075a4ca9ad778973a7bccd9c349df24d411ce362b', 1031, 817, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:07', '2026-09-21 10:05:07'),
(367, '33-kabul-1.png', '33-kabul-1.png', 'assets/uploads/legacy/20260921_073447/33-kabul-1.png', 'image/png', 450979, 'b9c89c7648f4585d1f3ee2f328316427e9fa09e65d12deaf838b83a2193e9c4b', 1037, 817, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:07', '2026-09-21 10:05:07'),
(368, '34-jawzjan-1.png', '34-jawzjan-1.png', 'assets/uploads/legacy/20260921_073447/34-jawzjan-1.png', 'image/png', 346159, '845e690cdfd131716549bc4995c71424276a82654bb88199850f4f371bc7c535', 1031, 817, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:07', '2026-09-21 10:05:07'),
(369, '35-badghis-1.png', '35-badghis-1.png', 'assets/uploads/legacy/20260921_073447/35-badghis-1.png', 'image/png', 678499, 'd221da0ca3b349ceda19ca7c6b749c491b29d56fbefb4ee90c7722c6a23fc87c', 1037, 818, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:07', '2026-09-21 10:05:07'),
(370, '36-nangarhar-1.png', '36-nangarhar-1.png', 'assets/uploads/legacy/20260921_073447/36-nangarhar-1.png', 'image/png', 268284, 'b0f89d20488932b6a01e735b1a22ad2359bebd6a0d8be5489ef56c2d4ec41fd2', 1031, 1159, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:07', '2026-09-21 10:05:07'),
(371, '37-kandahar-1.png', '37-kandahar-1.png', 'assets/uploads/legacy/20260921_073447/37-kandahar-1.png', 'image/png', 662982, '9e73761e6d6092a792ba8798cee09844d75d57687ffdd9bc00887e3711665627', 1031, 1159, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:08', '2026-09-21 10:05:08'),
(372, '38-herat-1.png', '38-herat-1.png', 'assets/uploads/legacy/20260921_073447/38-herat-1.png', 'image/png', 719637, 'b9f95d73590f50adc009ca3a2a0f8fd89ef7cf06628bc46189828515f20a4b92', 1037, 1380, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:08', '2026-09-21 10:05:08'),
(373, '39-balkh-1.png', '39-balkh-1.png', 'assets/uploads/legacy/20260921_073447/39-balkh-1.png', 'image/png', 550427, '00adc1f1fe18937854ba6cd7c0890281ffbb14b8371d7f41e6cb13ddc68523e7', 1036, 1380, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:08', '2026-09-21 10:05:08'),
(374, '40-paktya-1.png', '40-paktya-1.png', 'assets/uploads/legacy/20260921_073447/40-paktya-1.png', 'image/png', 149402, '8c1fd2dd53b00737949c12c4f34400b2d5e5beeac017153ad7d16bc824eaa8c6', 379, 249, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:08', '2026-09-21 10:05:08'),
(375, '40-paktya-2.png', '40-paktya-2.png', 'assets/uploads/legacy/20260921_073447/40-paktya-2.png', 'image/png', 202723, '448a14f079f9b15a98806505f112e04e4df0edb9b067488e86f064adf59b52de', 378, 251, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:08', '2026-09-21 10:05:08'),
(376, '40-paktya-3.png', '40-paktya-3.png', 'assets/uploads/legacy/20260921_073447/40-paktya-3.png', 'image/png', 213786, '458d9bd159eed56ba44f3e53185b799a8c49f8b7eee362d89008625f9632b6ae', 377, 246, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:08', '2026-09-21 10:05:08'),
(377, '40-paktya-4.png', '40-paktya-4.png', 'assets/uploads/legacy/20260921_073447/40-paktya-4.png', 'image/png', 161628, 'ce08b57716664936c6cc1ea47e7a013e3e469f4e72f0f4774de538a1fefc400c', 375, 253, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:08', '2026-09-21 10:05:08'),
(378, '41-herat-1.jpeg', '41-herat-1.jpeg', 'assets/uploads/legacy/20260921_073447/41-herat-1.jpeg', 'image/jpeg', 79698, 'dd34f5528fe12f3cd214b5678ee79a4434311225665af9fab1308465e4b14f0b', 1008, 490, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:08', '2026-09-21 10:05:08'),
(379, '41-herat-2.jpeg', '41-herat-2.jpeg', 'assets/uploads/legacy/20260921_073447/41-herat-2.jpeg', 'image/jpeg', 84323, '136456f538c757272e76d85352188dda55fbb81216e18fe893e9d4bf675b3457', 1008, 756, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:09', '2026-09-21 10:05:09'),
(380, '41-herat-3.jpeg', '41-herat-3.jpeg', 'assets/uploads/legacy/20260921_073447/41-herat-3.jpeg', 'image/jpeg', 397392, 'bd841d05810065caac090a950573dc1e641d8112145dc3902e81eacfeb65ba72', 2304, 1728, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:09', '2026-09-21 10:05:09'),
(381, '41-herat-4.jpeg', '41-herat-4.jpeg', 'assets/uploads/legacy/20260921_073447/41-herat-4.jpeg', 'image/jpeg', 107780, 'a2e3f63b0e0d0ed2682cc23629756585598f0da8dfac644c16ce0ca9bf054b18', 1080, 755, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:09', '2026-09-21 10:05:09'),
(382, '42-kabul-1.png', '42-kabul-1.png', 'assets/uploads/legacy/20260921_073447/42-kabul-1.png', 'image/png', 429505, '87235452a11855f42a8571b9ede6631bef2aca33fceb541a91cf13ee018e39a6', 1037, 633, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:09', '2026-09-21 10:05:09'),
(383, '42-kabul-2.png', '42-kabul-2.png', 'assets/uploads/legacy/20260921_073447/42-kabul-2.png', 'image/png', 311359, '7da644d459b090c148e5a34ef8be5fcdbb780c28cf9dcb8d41e494aeff9260e0', 1031, 508, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:09', '2026-09-21 10:05:09'),
(384, '75-SurkhanDashtalwan-1.jpeg', '75-SurkhanDashtalwan-1.jpeg', 'assets/uploads/legacy/20260921_073447/75-SurkhanDashtalwan-1.jpeg', 'image/jpeg', 197300, '6f5964e4aad4f2a2b608d981299df18a2c4bba5ab410ab028eb339ff1be9c723', 1156, 867, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:09', '2026-09-21 10:05:09'),
(385, '75-SurkhanDashtalwan-2.jpeg', '75-SurkhanDashtalwan-2.jpeg', 'assets/uploads/legacy/20260921_073447/75-SurkhanDashtalwan-2.jpeg', 'image/jpeg', 91326, '7a3edd1bb7dbdce8d8f601302dd313213caed76fd938aa88e9c81c9580f021b4', 803, 485, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:09', '2026-09-21 10:05:09'),
(386, '75-SurkhanDashtalwan-3.jpeg', '75-SurkhanDashtalwan-3.jpeg', 'assets/uploads/legacy/20260921_073447/75-SurkhanDashtalwan-3.jpeg', 'image/jpeg', 44646, '4a642b021a4e5d04a3077115e85aab393e2c58d499f11a5a0f78cc94fa2fc23e', 820, 489, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:10', '2026-09-21 10:05:10'),
(387, '78-shaikhmesri-1.jpeg', '78-shaikhmesri-1.jpeg', 'assets/uploads/legacy/20260921_073447/78-shaikhmesri-1.jpeg', 'image/jpeg', 68598, '6658ae58480ecbfbe8781adabe71fd2613d5d0eab1710e5107c8506c13017c64', 1008, 567, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:10', '2026-09-21 10:05:10'),
(388, '78-shaikhmesri-2.jpeg', '78-shaikhmesri-2.jpeg', 'assets/uploads/legacy/20260921_073447/78-shaikhmesri-2.jpeg', 'image/jpeg', 96619, '42fa02ed7ecb248bdc5e0bec86a93fb402e9c6229482ca97a2d138aa77882edc', 567, 1008, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:10', '2026-09-21 10:05:10'),
(389, '78-shaikhmesri-3.jpeg', '78-shaikhmesri-3.jpeg', 'assets/uploads/legacy/20260921_073447/78-shaikhmesri-3.jpeg', 'image/jpeg', 95127, 'f6e74dcb7bb700be4d4fb8c5f72e55787d410504b6e02495f9127411c1bf6bd6', 1008, 567, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:10', '2026-09-21 10:05:10'),
(390, '79-arghandi-1.jpeg', '79-arghandi-1.jpeg', 'assets/uploads/legacy/20260921_073447/79-arghandi-1.jpeg', 'image/jpeg', 270364, 'c9db87d4cc086e197d00a17fea47c8952a473688756fbb8eb6d1c206b945eb8c', 1280, 946, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:10', '2026-09-21 10:05:10'),
(391, '85-ChemtalaTarakhail-1.jpeg', '85-ChemtalaTarakhail-1.jpeg', 'assets/uploads/legacy/20260921_073447/85-ChemtalaTarakhail-1.jpeg', 'image/jpeg', 518327, 'de2abf49450e9bfe088a2535a3b38eaf5699aa575d2d6f67f97a8764ac6b094e', 1440, 1080, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:10', '2026-09-21 10:05:10'),
(392, '85-ChemtalaTarakhail-2.jpeg', '85-ChemtalaTarakhail-2.jpeg', 'assets/uploads/legacy/20260921_073447/85-ChemtalaTarakhail-2.jpeg', 'image/jpeg', 735216, 'a88cd4e3ec0a4909bf3688b73349848a62e420e25b88c213275df7dab28030d8', 1440, 1080, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:10', '2026-09-21 10:05:10'),
(393, '85-ChemtalaTarakhail-3.jpeg', '85-ChemtalaTarakhail-3.jpeg', 'assets/uploads/legacy/20260921_073447/85-ChemtalaTarakhail-3.jpeg', 'image/jpeg', 552842, '8d25fbd38441fdb80c4cee3dad2607b4619ac1c1701148cf0ad7ba4db70c2ab7', 1440, 1080, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:10', '2026-09-21 10:05:10'),
(394, '91-Qush TepaDarzaab-2.jpeg', '91-Qush-TepaDarzaab-2.jpeg', 'assets/uploads/legacy/20260921_073447/91-Qush-TepaDarzaab-2.jpeg', 'image/jpeg', 81350, '8813feb2bd4d03db65df5841efdf8cfa6d6fe73a99045c85ac64657b77ab43cf', 1016, 762, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:10', '2026-09-21 10:05:10'),
(395, '91-QushTepaDarzaab-1.jpeg', '91-QushTepaDarzaab-1.jpeg', 'assets/uploads/legacy/20260921_073447/91-QushTepaDarzaab-1.jpeg', 'image/jpeg', 101356, '1dce8be14b7e22396ac240fbd19b4a199dd580cfd43ff22d5098782f3d9826fa', 1000, 750, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:11', '2026-09-21 10:05:11'),
(396, 'processingplant.jpg', 'processingplant.jpg', 'assets/uploads/legacy/20260921_073447/processingplant.jpg', 'image/jpeg', 38042, '85786fca2213f694bef3074860a4cfbe4835869c815f05c1daae9c5a8d964c47', 633, 358, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:11', '2026-09-21 10:05:11'),
(397, 'processingplant1.jpg', 'processingplant1.jpg', 'assets/uploads/legacy/20260921_073447/processingplant1.jpg', 'image/jpeg', 104494, 'c9cd5e082144b313e8c15c7fd821f93e870cc051dc73bd37217049360340a118', 679, 360, NULL, 'projects', 'active', 'upload', NULL, '2026-09-21 10:05:11', '2026-09-21 10:05:11'),
(398, 'resident.jpg', 'resident.jpg', 'assets/uploads/legacy/20260921_073447/resident.jpg', 'image/jpeg', 202425, '4be2f98aaf1a5ed6cbda4e6ce08f3db907be7757bfd53f6a6d2e5d44d76a4fb2', 800, 600, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:11', '2026-09-21 10:05:11'),
(399, 'roadhighway.jpg', 'roadhighway.jpg', 'assets/uploads/legacy/20260921_073447/roadhighway.jpg', 'image/jpeg', 138381, 'f6e170d353c2f617ded64912242821a92def03e30e4e103431428a3bb49910cb', 500, 341, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:11', '2026-09-21 10:05:11'),
(400, 'SC1.jpg', 'SC1.jpg', 'assets/uploads/legacy/20260921_073447/SC1.jpg', 'image/jpeg', 326276, '10f2c0a74353ca4aaaafff2f7f4383364964b83098d960075f9ac5ea1fa30846', 960, 640, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:11', '2026-09-21 10:05:11'),
(401, 'SC10.jpg', 'SC10.jpg', 'assets/uploads/legacy/20260921_073447/SC10.jpg', 'image/jpeg', 316588, '57c53dd02be43a8a3c99b188829c50425172c45d41a17d896f93523154a48f16', 960, 640, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:11', '2026-09-21 10:05:11'),
(402, 'Scom_aeroparcel.png', 'Scom_aeroparcel.png', 'assets/uploads/legacy/20260921_073447/Scom_aeroparcel.png', 'image/png', 183981, '2192c9b5906b610262e588084b964578b7de014c3e8d80b718746a2284f5414a', 394, 342, NULL, 'SCompany', 'active', 'upload', NULL, '2026-09-21 10:05:11', '2026-09-21 10:05:11'),
(403, 'Scom_aryamineral.png', 'Scom_aryamineral.png', 'assets/uploads/legacy/20260921_073447/Scom_aryamineral.png', 'image/png', 117317, 'cb2bc616c78ee8ef840eeda28d89c58c9cdc5909977b500b568c7f9785add8a1', 348, 367, NULL, 'SCompany', 'active', 'upload', NULL, '2026-09-21 10:05:12', '2026-09-21 10:05:12'),
(404, 'Scom_petropool.png', 'Scom_petropool.png', 'assets/uploads/legacy/20260921_073447/Scom_petropool.png', 'image/png', 59911, 'dc45edbba568be898c105428fc9a825812ac03a820a6c004b5a72e8b9d43c107', 508, 177, NULL, 'SCompany', 'active', 'upload', NULL, '2026-09-21 10:05:12', '2026-09-21 10:05:12'),
(405, 'sc_turkey.png', 'sc_turkey.png', 'assets/uploads/legacy/20260921_073447/sc_turkey.png', 'image/png', 282210, '7197ddd31d9d6b54eca9e76738883fe040b845268c207550aa0e6a17ebd17fe9', 1735, 805, NULL, 'SCompany', 'active', 'upload', NULL, '2026-09-21 10:05:12', '2026-09-21 10:05:12'),
(406, 'sc_us.png', 'sc_us.png', 'assets/uploads/legacy/20260921_073447/sc_us.png', 'image/png', 344178, '65f9490e61e5b88564aac560d50560a4b107c7e9f4ffe9264c9465c0cfeb43ae', 1750, 1520, NULL, 'SCompany', 'active', 'upload', NULL, '2026-09-21 10:05:12', '2026-09-21 10:05:12'),
(407, 'service01.jpg', 'service01.jpg', 'assets/uploads/legacy/20260921_073447/service01.jpg', 'image/jpeg', 292386, 'a66ec0958c9d97e4de5dc9eae7d8c52156a6ae623c15f2dc61faf7341694f28a', 819, 576, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:12', '2026-09-21 10:05:12'),
(408, 'service03.jpg', 'service03.jpg', 'assets/uploads/legacy/20260921_073447/service03.jpg', 'image/jpeg', 272948, '03faeceb91343d9589308dd0eba7a013146e501b65ab67f806419be56f66738c', 800, 600, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:12', '2026-09-21 10:05:12'),
(409, 'service04.jpg', 'service04.jpg', 'assets/uploads/legacy/20260921_073447/service04.jpg', 'image/jpeg', 212636, 'e83b1f13473f6e09b017a02aad9c83aaf3d0e64555d1d9d3967dc014d8d8981b', 640, 480, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:12', '2026-09-21 10:05:12'),
(410, 'service05.jpg', 'service05.jpg', 'assets/uploads/legacy/20260921_073447/service05.jpg', 'image/jpeg', 321295, '3c3dc49b9634a108570e37f76e56219dbc650c566e6c9cb5559dadb5d27ffeb2', 830, 637, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:12', '2026-09-21 10:05:12'),
(411, 'service06.jpg', 'service06.jpg', 'assets/uploads/legacy/20260921_073447/service06.jpg', 'image/jpeg', 143798, '148987a1e4636ef2bb8e6e2e50c2aa1cbeb20898e6d9e98e674e9d556024ebfe', 800, 600, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:12', '2026-09-21 10:05:12'),
(412, 'architecturaldesign.jpg', 'architecturaldesign.jpg', 'assets/uploads/legacy/20260921_073447/architecturaldesign.jpg', 'image/jpeg', 1865973, '34d877ca974410d846ef88a9c94d4f803b956f59c22392f3c0289e1453b46f08', 5472, 3648, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:13', '2026-09-21 10:05:13'),
(413, 'civildesign.jpg', 'civildesign.jpg', 'assets/uploads/legacy/20260921_073447/civildesign.jpg', 'image/jpeg', 4211161, '45fefa580062530b02da01e056d939558e02332b26606ccf1d6012cd40151945', 6720, 4480, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:13', '2026-09-21 10:05:13'),
(414, 'conceptualdesign1.jpg', 'conceptualdesign1.jpg', 'assets/uploads/legacy/20260921_073447/conceptualdesign1.jpg', 'image/jpeg', 1197867, '91474331cc8058ca8b8e4331ded9b4d3117329ab1da5050d545845f82012e527', 4608, 3456, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:13', '2026-09-21 10:05:13'),
(415, 'consulting.jpg', 'consulting.jpg', 'assets/uploads/legacy/20260921_073447/consulting.jpg', 'image/jpeg', 97289, 'd110376c757c20e0cc5947c8eb785e5ba2042243c5b69e1f1cbbe187a119fd02', 624, 485, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:13', '2026-09-21 10:05:13'),
(416, 'crushers1.jpg', 'crushers1.jpg', 'assets/uploads/legacy/20260921_073447/crushers1.jpg', 'image/jpeg', 135146, 'd62df0a78372330a2fa94a921a16941d0dd97df8718db19e891f2b3829df5a7d', 898, 575, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:13', '2026-09-21 10:05:13'),
(417, 'distribution1.jpg', 'distribution1.jpg', 'assets/uploads/legacy/20260921_073447/distribution1.jpg', 'image/jpeg', 370625, '2dbb2fcc0bef177dcab390fe0f45612f0a3156f4e9156d26fc7248c058e540c9', 960, 640, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:13', '2026-09-21 10:05:13'),
(418, 'drill-blast1.jpg', 'drill-blast1.jpg', 'assets/uploads/legacy/20260921_073447/drill-blast1.jpg', 'image/jpeg', 326892, '6d7df80f561b9a30cc6e8d886acbe302e2e71dfce5e497dcca8226c32665035c', 559, 559, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:13', '2026-09-21 10:05:13'),
(419, 'EIA.webp', 'EIA.webp', 'assets/uploads/legacy/20260921_073447/EIA.webp', 'image/webp', 57764, 'e2167a512f3cd609028155ef89897d7bc8a00fed54dbcbc84cf3300b12f941c4', 720, 390, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:13', '2026-09-21 10:05:13'),
(420, 'electricaldesign1.jpeg', 'electricaldesign1.jpeg', 'assets/uploads/legacy/20260921_073447/electricaldesign1.jpeg', 'image/jpeg', 281266, '5edcc805f8b859652c71f969c6aa5e663533eccdc027f5eefada00b9f6c6d1da', 1024, 576, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:14', '2026-09-21 10:05:14'),
(421, 'enviromental1.jpg', 'enviromental1.jpg', 'assets/uploads/legacy/20260921_073447/enviromental1.jpg', 'image/jpeg', 2252367, '468f340d5ed2248a16db138e7592af66a73d95e11c5a517f7ad0d4faec6c5c18', 5472, 3648, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:14', '2026-09-21 10:05:14'),
(422, 'ESG1.png', 'ESG1.png', 'assets/uploads/legacy/20260921_073447/ESG1.png', 'image/png', 639195, '20713d3a94bd4d865972ee889b6bde940276b20074c344c38827cc7c5789cd08', 1024, 699, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:14', '2026-09-21 10:05:14'),
(423, 'feasibilitystu1.jpg', 'feasibilitystu1.jpg', 'assets/uploads/legacy/20260921_073447/feasibilitystu1.jpg', 'image/jpeg', 3653126, '09d056079603d360d6a98b6880b781ac686b924e42c9dd8318cc69a04814aaad', 6240, 4160, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:14', '2026-09-21 10:05:14'),
(424, 'geo-survey1.jpg', 'geo-survey1.jpg', 'assets/uploads/legacy/20260921_073447/geo-survey1.jpg', 'image/jpeg', 759629, 'f9b1e00ab5545b047d3dfba7b79b9d066ed98ccfd80487c8176a92296f36a41d', 2050, 1367, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:14', '2026-09-21 10:05:14'),
(425, 'gis1.jpg', 'gis1.jpg', 'assets/uploads/legacy/20260921_073447/gis1.jpg', 'image/jpeg', 385817, '828629b4833b0692b46c747e3a8e28c452560baf5b9eea2baf2c640b659f5610', 3776, 2360, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:14', '2026-09-21 10:05:14'),
(426, 'mechanicaldesign1.jpeg', 'mechanicaldesign1.jpeg', 'assets/uploads/legacy/20260921_073447/mechanicaldesign1.jpeg', 'image/jpeg', 582898, '9e65033ab1d26cd2d34bc4583b3469c55d6af12a1a2d1aca38c71cd4aa28bcef', 1536, 1024, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:14', '2026-09-21 10:05:14'),
(427, 'mine-closure1.jpg', 'mine-closure1.jpg', 'assets/uploads/legacy/20260921_073447/mine-closure1.jpg', 'image/jpeg', 275559, '3ee4b9c62834641ccbbeb8757b4d8b42c299f99cee1c5cb019b53227e9cf9bbe', 1800, 1054, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:15', '2026-09-21 10:05:15'),
(428, 'mine-tailing.webp', 'mine-tailing.webp', 'assets/uploads/legacy/20260921_073447/mine-tailing.webp', 'image/webp', 243826, 'b2167797cb9d68206221a3eed1ac9bceb45a7650a49853cf10fe2f9aa100abdf', 1080, 690, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:15', '2026-09-21 10:05:15'),
(429, 'mineralseparation1.jpg', 'mineralseparation1.jpg', 'assets/uploads/legacy/20260921_073447/mineralseparation1.jpg', 'image/jpeg', 589380, '256e412f73989d8f64ff863f357571d4a1faf5e436470bbe240b6c8a0d3413ee', 2560, 2105, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:15', '2026-09-21 10:05:15'),
(430, 'open-pit-mining1.jpg', 'open-pit-mining1.jpg', 'assets/uploads/legacy/20260921_073447/open-pit-mining1.jpg', 'image/jpeg', 249513, 'c9e142f5c67ad88b0554a1945b1ed25244eed7b1615614df35d9fc680b9bb25d', 780, 452, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:15', '2026-09-21 10:05:15'),
(431, 'resourse-estimation1.jpg', 'resourse-estimation1.jpg', 'assets/uploads/legacy/20260921_073447/resourse-estimation1.jpg', 'image/jpeg', 185986, '5fa5dd864ba381e1284cbe7788ddcaf020d5a3ad2bc4400335d22e22168b717d', 2184, 1745, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:15', '2026-09-21 10:05:15'),
(432, 'SC10.jpg', 'SC10-1.jpg', 'assets/uploads/legacy/20260921_073447/SC10-1.jpg', 'image/jpeg', 316588, '57c53dd02be43a8a3c99b188829c50425172c45d41a17d896f93523154a48f16', 960, 640, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:15', '2026-09-21 10:05:15'),
(433, 'sensing1.jpg', 'sensing1.jpg', 'assets/uploads/legacy/20260921_073447/sensing1.jpg', 'image/jpeg', 104130, 'dac4c0284d1a91a5896486792ae7f5c340afad0e63c18b4af99971fc0e8e2485', 960, 376, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:15', '2026-09-21 10:05:15'),
(434, 'service-del-hero.jpg', 'service-del-hero.jpg', 'assets/uploads/legacy/20260921_073447/service-del-hero.jpg', 'image/jpeg', 725439, 'bc6082a989a2ada23e559c3731957d1a13cb2b0fc31fd7f85d0181e5edf45d22', 1650, 650, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:15', '2026-09-21 10:05:15'),
(435, 'service-eng-hero.jpg', 'service-eng-hero.jpg', 'assets/uploads/legacy/20260921_073447/service-eng-hero.jpg', 'image/jpeg', 293146, '8717b50f65ec71a0f6dc62dc8c9e547156b0e33f4129b8af2ba5a2a625c6118e', 1366, 400, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:16', '2026-09-21 10:05:16'),
(436, 'service-hero.jpg', 'service-hero.jpg', 'assets/uploads/legacy/20260921_073447/service-hero.jpg', 'image/jpeg', 765334, '7d1c897cefdb4579142e33244b870611bcae12e385f6ccb633e04cfe8876ca2c', 1650, 600, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:16', '2026-09-21 10:05:16'),
(437, 'service-mining-hero.png', 'service-mining-hero.png', 'assets/uploads/legacy/20260921_073447/service-mining-hero.png', 'image/png', 3202472, '89eb43683249eb967e8982dec1208683cdc332dacacfb0d5bab2789c93268367', 1675, 939, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:16', '2026-09-21 10:05:16');
INSERT INTO `media_library` (`id`, `original_name`, `stored_name`, `relative_path`, `mime_type`, `file_size`, `checksum`, `width_px`, `height_px`, `alt_text`, `category`, `status`, `storage_scope`, `created_by`, `created_at`, `updated_at`) VALUES
(438, 'smart-mining.gif', 'smart-mining.gif', 'assets/uploads/legacy/20260921_073447/smart-mining.gif', 'image/gif', 699502, 'fbbbdee1d1bebb8d319bc59ef2ae7c3707f682739590d332ee4df1c431c2bd0b', 840, 296, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:16', '2026-09-21 10:05:16'),
(439, 'structuraldesign.jpg', 'structuraldesign.jpg', 'assets/uploads/legacy/20260921_073447/structuraldesign.jpg', 'image/jpeg', 1470331, '4f2583353a88e04cb27badf1ab89dc38d4c2b0d707f96c8bdeeb59eab73d5e5d', 4080, 3072, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:16', '2026-09-21 10:05:16'),
(440, 'substation1.png', 'substation1.png', 'assets/uploads/legacy/20260921_073447/substation1.png', 'image/png', 3183614, '7c3262178fcc2eca3bd5c618497956c5bbd63a5177aeefa22731f1ddeb7b0787', 1537, 1023, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:16', '2026-09-21 10:05:16'),
(441, 'transmission1.jpg', 'transmission1.jpg', 'assets/uploads/legacy/20260921_073447/transmission1.jpg', 'image/jpeg', 346319, '1e70f2551faa8d693657b7ffebf61e15886c6f16060996a4a54a1bb2716617fe', 600, 600, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:16', '2026-09-21 10:05:16'),
(442, 'underground-mining1.jpg', 'underground-mining1.jpg', 'assets/uploads/legacy/20260921_073447/underground-mining1.jpg', 'image/jpeg', 2553797, '89c0f9d345dc4bacf2423be9c8e8e66da5fca7c56dee5dbc3012fd36eab69f60', 7952, 5304, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:17', '2026-09-21 10:05:17'),
(443, 'urbandev1.jpg', 'urbandev1.jpg', 'assets/uploads/legacy/20260921_073447/urbandev1.jpg', 'image/jpeg', 2043038, 'f00b21501a5ed9d4ff5c0553778d43618b5ad4b5e43bbc67611842439b3fcd54', 6240, 4160, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:17', '2026-09-21 10:05:17'),
(444, 'waste-management.webp', 'waste-management.webp', 'assets/uploads/legacy/20260921_073447/waste-management.webp', 'image/webp', 29692, '4ef66421db008e017ad06971ae9199f75baaa329b41f19b1f4c3090a97d269b5', 697, 464, NULL, 'services', 'active', 'upload', NULL, '2026-09-21 10:05:17', '2026-09-21 10:05:17'),
(445, 'slider01.jpg', 'slider01.jpg', 'assets/uploads/legacy/20260921_073447/slider01.jpg', 'image/jpeg', 194247, 'bdee5dfa5013e95d2edce95801a199908e7317246cde4e8dca21abd0725b8ed4', 1982, 954, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:17', '2026-09-21 10:05:17'),
(446, 'slider_02.jpg', 'slider_02.jpg', 'assets/uploads/legacy/20260921_073447/slider_02.jpg', 'image/jpeg', 918193, 'a54539efc89c6945d062a2c13a5b56054e6a805f678c346a55c3e8c31dd894da', 1650, 650, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:17', '2026-09-21 10:05:17'),
(447, 'Slider_02_New.jpg', 'Slider_02_New.jpg', 'assets/uploads/legacy/20260921_073447/Slider_02_New.jpg', 'image/jpeg', 765334, '7d1c897cefdb4579142e33244b870611bcae12e385f6ccb633e04cfe8876ca2c', 1650, 600, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:18', '2026-09-21 10:05:18'),
(448, 'Slider_03_New.jpg', 'Slider_03_New.jpg', 'assets/uploads/legacy/20260921_073447/Slider_03_New.jpg', 'image/jpeg', 745506, '796cebf1597b2cdecc8a6475d90a28bf90c0b9534d71a456dd793db6967f3894', 1650, 600, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:18', '2026-09-21 10:05:18'),
(449, 'slider_03_old.jpg', 'slider_03_old.jpg', 'assets/uploads/legacy/20260921_073447/slider_03_old.jpg', 'image/jpeg', 647325, 'e2366f4d1778f1c348e962d0551049d2b3da4a8955680d95d98e029d64f4b3c8', 1650, 600, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:18', '2026-09-21 10:05:18'),
(450, 'slider_04.jpg', 'slider_04.jpg', 'assets/uploads/legacy/20260921_073447/slider_04.jpg', 'image/jpeg', 742210, '4905548ce0e70ac390f817152a3d1328cfd0879942c00649fbb3bcaa68f6763f', 1650, 600, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:18', '2026-09-21 10:05:18'),
(451, 'slider_05.jpg', 'slider_05.jpg', 'assets/uploads/legacy/20260921_073447/slider_05.jpg', 'image/jpeg', 833947, '704de8642c1c6d938aa508dd453c2268cbc45a396b541582e5ebd75708bf665d', 1650, 600, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:18', '2026-09-21 10:05:18'),
(452, 'slider_06.jpg', 'slider_06.jpg', 'assets/uploads/legacy/20260921_073447/slider_06.jpg', 'image/jpeg', 537561, '972f0013f68a42ffe4905a2464841827cb7c1c4f6687108f0101451d4da82e27', 1650, 600, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:18', '2026-09-21 10:05:18'),
(453, 'slider_07.jpg', 'slider_07.jpg', 'assets/uploads/legacy/20260921_073447/slider_07.jpg', 'image/jpeg', 751710, '4548e3e1b7c961bf50b0532b726db46fa3e9f98d31ae0e68c6fdb089b26be994', 1650, 600, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:19', '2026-09-21 10:05:19'),
(454, 'Slider_5_New.jpg', 'Slider_5_New.jpg', 'assets/uploads/legacy/20260921_073447/Slider_5_New.jpg', 'image/jpeg', 556061, 'b5ae6469953f9b70b677d49d92d6f2e366ec99b82f8a074e58108a21cfe4073b', 1650, 600, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:19', '2026-09-21 10:05:19'),
(455, 'Slider_6_New.jpg', 'Slider_6_New.jpg', 'assets/uploads/legacy/20260921_073447/Slider_6_New.jpg', 'image/jpeg', 1216429, '1389d2543a38156b05a9f29fc1ecee9058561f16fe254aeb5200e294a89dd73b', 1650, 600, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:19', '2026-09-21 10:05:19'),
(456, 'splproperty.jpg', 'splproperty.jpg', 'assets/uploads/legacy/20260921_073447/splproperty.jpg', 'image/jpeg', 275624, '25070ca0949d494d088c7a2bd6e73ba752ee1bebe01eed7ca9764d25811dd7a4', 800, 600, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:19', '2026-09-21 10:05:19'),
(457, 'steadapt.jpg', 'steadapt.jpg', 'assets/uploads/legacy/20260921_073447/steadapt.jpg', 'image/jpeg', 252254, '21d2e8012e058a40a39edfe42fe673cb58a7192085d7f6aa6caef2bde48872ab', 531, 531, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:19', '2026-09-21 10:05:19'),
(458, 'substation.jpg', 'substation.jpg', 'assets/uploads/legacy/20260921_073447/substation.jpg', 'image/jpeg', 398251, '4cf68d9021b7d7ff76ea2fafeb3809f033c723054e33d696d79c7b35e5eedfea', 1366, 270, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:19', '2026-09-21 10:05:19'),
(459, 'substation01.jpg', 'substation01.jpg', 'assets/uploads/legacy/20260921_073447/substation01.jpg', 'image/jpeg', 561782, '45bf2191006b971ec23408077edc412bdfa26ce033299a32f542aeaba71e56fd', 971, 768, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:20', '2026-09-21 10:05:20'),
(460, 'substation_new.jpg', 'substation_new.jpg', 'assets/uploads/legacy/20260921_073447/substation_new.jpg', 'image/jpeg', 352973, '41a4f7a87d561416048f223b7b1ef6f5d64f00d5a6936269aa74b6ded5fc8cfb', 1366, 270, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:20', '2026-09-21 10:05:20'),
(461, 'taloqan.jpg', 'taloqan.jpg', 'assets/uploads/legacy/20260921_073447/taloqan.jpg', 'image/jpeg', 304662, '602c7d334fee2093d7ae0a25788f6b09e6b7e7f4212e86fde00a985905f5a94a', 857, 576, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:20', '2026-09-21 10:05:20'),
(462, 'transmission02.jpg', 'transmission02.jpg', 'assets/uploads/legacy/20260921_073447/transmission02.jpg', 'image/jpeg', 230946, '36b6a02dfcccb79e6aee13c81686cdfef5f094896b40c18d8bc9bfa408ba8eeb', 576, 576, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:20', '2026-09-21 10:05:20'),
(463, 'transmission03.jpg', 'transmission03.jpg', 'assets/uploads/legacy/20260921_073447/transmission03.jpg', 'image/jpeg', 206431, '07b31719f1a8ccbf1d89d8b7a4d5ddbeccd7d9aa7bc37ed7697a932d5badf320', 1024, 768, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:20', '2026-09-21 10:05:20'),
(464, 'transmission_new.jpg', 'transmission_new.jpg', 'assets/uploads/legacy/20260921_073447/transmission_new.jpg', 'image/jpeg', 368067, '412601207171c9a25ad2f1b0da4ece4cbbffea2e130c214adefe873cc1ec12b1', 600, 600, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:20', '2026-09-21 10:05:20'),
(465, 'WA-QR-Code.jpg', 'WA-QR-Code.jpg', 'assets/uploads/legacy/20260921_073447/WA-QR-Code.jpg', 'image/jpeg', 56551, '88b564d21499a9cba6aabeaeff18c4d961f9c7e49002f7f256729f5a748e0ec4', 610, 616, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:20', '2026-09-21 10:05:20'),
(466, 'watersewer.jpg', 'watersewer.jpg', 'assets/uploads/legacy/20260921_073447/watersewer.jpg', 'image/jpeg', 167035, '5edca2d3a4384504f622a384bf062a2b3a837b1379e4c04f78b0b6f6de1ba717', 572, 322, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:20', '2026-09-21 10:05:20'),
(467, 'WhatWeDoBg.jpg', 'WhatWeDoBg.jpg', 'assets/uploads/legacy/20260921_073447/WhatWeDoBg.jpg', 'image/jpeg', 338322, 'b11e3b86eda92509e589e535a7161f009f59b063a3c621c5c860a29b5a76b64f', 1366, 732, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:21', '2026-09-21 10:05:21'),
(468, 'whybg1.jpg', 'whybg1-1.jpg', 'assets/uploads/legacy/20260921_073447/whybg1-1.jpg', 'image/jpeg', 127595, 'd4bc5dbb8c3f3af8d0fafd49940bebb958f83da04d043ff1e1a6fc4a16b65447', 672, 371, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:21', '2026-09-21 10:05:21'),
(469, 'WhyStateBg1.jpg', 'WhyStateBg1.jpg', 'assets/uploads/legacy/20260921_073447/WhyStateBg1.jpg', 'image/jpeg', 1176206, '5e640c367a74a5e842113cab1a843626a1702dd4657bf9150ca5415057137b4f', 1650, 600, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:21', '2026-09-21 10:05:21'),
(470, 'WhyStateBg1_Old.jpg', 'WhyStateBg1_Old.jpg', 'assets/uploads/legacy/20260921_073447/WhyStateBg1_Old.jpg', 'image/jpeg', 1148850, '33366a9d48c5a14ae5cb498908d3dc1045d4c970581b84d8be500ed4420638a3', 1366, 656, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:21', '2026-09-21 10:05:21'),
(471, 'WhyStateBg_Old.jpg', 'WhyStateBg_Old.jpg', 'assets/uploads/legacy/20260921_073447/WhyStateBg_Old.jpg', 'image/jpeg', 1003693, 'dbfaa74788f32a586f346805dd3c108ccb30811ced224ab7248b355f90d5ebf3', 1366, 656, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:21', '2026-09-21 10:05:21'),
(472, 'yaka.jpg', 'yaka.jpg', 'assets/uploads/legacy/20260921_073447/yaka.jpg', 'image/jpeg', 234070, 'a8d8a14af1b30dc27ccecb92d143fae088e30cecd7560e74f8e0c6f7d9377a06', 640, 480, NULL, 'images', 'active', 'upload', NULL, '2026-09-21 10:05:21', '2026-09-21 10:05:21'),
(473, 'SCProfileLight.pdf', 'SCProfileLight.pdf', 'assets/uploads/legacy/20260921_073447/SCProfileLight.pdf', 'application/pdf', 104409035, '930c426a9f572306442b77ebe12523842101415870a1b4f0b6db7d1e751e6fc5', NULL, NULL, NULL, 'documents', 'active', 'upload', NULL, '2026-09-21 10:05:23', '2026-09-21 10:05:23');

-- --------------------------------------------------------
-- Table: media_tags

DROP TABLE IF EXISTS `media_tags`;
CREATE TABLE `media_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_media_tag_name` (`tag_name`),
  KEY `idx_media_tags_name` (`tag_name`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `media_tags` (`id`, `tag_name`) VALUES
(18, 'Afghanistan'),
(1, 'Agreement'),
(14, 'Arghandi'),
(15, 'Butkhak'),
(17, 'Construction'),
(10, 'Darzaab'),
(12, 'Dashti Alwan'),
(7, 'Distribution'),
(4, 'Electrification'),
(3, 'Energy'),
(16, 'Exhibition'),
(20, 'Faryab'),
(8, 'Jawzjan'),
(19, 'Opening Ceremony'),
(2, 'Power Supply'),
(9, 'Qush Tepa'),
(21, 'Sar-e Pul'),
(13, 'Shaikh Mesri'),
(5, 'Substation'),
(11, 'Surkhan'),
(6, 'Transmission');

-- --------------------------------------------------------
-- Table: page_seo

DROP TABLE IF EXISTS `page_seo`;
CREATE TABLE `page_seo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_key` varchar(100) NOT NULL,
  `page_name` varchar(150) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(320) DEFAULT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `canonical_url` varchar(500) DEFAULT NULL,
  `robots` enum('index,follow','index,nofollow','noindex,follow','noindex,nofollow') NOT NULL DEFAULT 'index,follow',
  `og_title` varchar(255) DEFAULT NULL,
  `og_description` varchar(320) DEFAULT NULL,
  `og_image` varchar(500) DEFAULT NULL,
  `twitter_card` enum('summary','summary_large_image','') NOT NULL DEFAULT 'summary_large_image',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(10) unsigned DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_page_seo_key` (`page_key`),
  KEY `idx_page_seo_active_sort` (`is_active`,`sort_order`,`id`),
  KEY `fk_page_seo_created_by` (`created_by`),
  KEY `fk_page_seo_updated_by` (`updated_by`),
  CONSTRAINT `fk_page_seo_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_page_seo_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `page_seo` (`id`, `page_key`, `page_name`, `title`, `description`, `keywords`, `canonical_url`, `robots`, `og_title`, `og_description`, `og_image`, `twitter_card`, `sort_order`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'home', 'Homepage', NULL, NULL, NULL, NULL, 'index,follow', NULL, NULL, NULL, 'summary_large_image', 10, 1, NULL, NULL, '2026-09-13 09:29:36', '2026-09-13 09:29:36'),
(2, 'about', 'About', NULL, NULL, NULL, NULL, 'index,follow', NULL, NULL, NULL, 'summary_large_image', 20, 1, NULL, NULL, '2026-09-13 09:29:36', '2026-09-13 09:29:36'),
(3, 'projects', 'Projects', NULL, NULL, NULL, NULL, 'index,follow', NULL, NULL, NULL, 'summary_large_image', 30, 1, NULL, NULL, '2026-09-13 09:29:36', '2026-09-13 09:29:36'),
(4, 'project-details', 'Project Details', NULL, NULL, NULL, NULL, 'index,follow', NULL, NULL, NULL, 'summary_large_image', 35, 1, NULL, NULL, '2026-09-13 09:29:36', '2026-09-13 09:29:36'),
(5, 'services', 'Services', NULL, NULL, NULL, NULL, 'index,follow', NULL, NULL, NULL, 'summary_large_image', 40, 1, NULL, NULL, '2026-09-13 09:29:36', '2026-09-13 09:29:36'),
(6, 'sectors', 'Sectors', NULL, NULL, NULL, NULL, 'index,follow', NULL, NULL, NULL, 'summary_large_image', 50, 1, NULL, NULL, '2026-09-13 09:29:36', '2026-09-13 09:29:36'),
(7, 'media', 'Media', NULL, NULL, NULL, NULL, 'index,follow', NULL, NULL, NULL, 'summary_large_image', 60, 1, NULL, NULL, '2026-09-13 09:29:36', '2026-09-13 09:29:36'),
(8, 'contact', 'Contact', NULL, NULL, NULL, NULL, 'index,follow', NULL, NULL, NULL, 'summary_large_image', 70, 1, NULL, NULL, '2026-09-13 09:29:36', '2026-09-13 09:29:36'),
(9, 'policies', 'Policies', NULL, NULL, NULL, NULL, 'index,follow', NULL, NULL, NULL, 'summary_large_image', 80, 1, NULL, NULL, '2026-09-13 09:29:36', '2026-09-13 09:29:36'),
(10, 'terms-of-service', 'Terms of Service', NULL, NULL, NULL, NULL, 'index,follow', NULL, NULL, NULL, 'summary_large_image', 90, 1, NULL, NULL, '2026-09-13 09:29:36', '2026-09-13 09:29:36');

-- --------------------------------------------------------
-- Table: permissions

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_key` varchar(100) NOT NULL,
  `permission_name` varchar(150) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_permissions_key` (`permission_key`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `permissions` (`id`, `permission_key`, `permission_name`, `description`) VALUES
(1, 'manage_homepage', 'Manage Homepage', 'Edit homepage content'),
(2, 'manage_about', 'Manage About', 'Edit About page content'),
(3, 'manage_projects', 'Manage Projects', 'Create and edit projects'),
(4, 'manage_services', 'Manage Services', 'Create and edit services'),
(5, 'manage_sectors', 'Manage Sectors', 'Create and edit sectors'),
(6, 'manage_media', 'Manage Media', 'Create and edit media'),
(7, 'manage_legal', 'Manage Policies and Terms', 'Edit legal documents'),
(8, 'manage_messages', 'Manage Messages', 'View and manage contact messages'),
(9, 'manage_settings', 'Manage Settings', 'Edit global website settings'),
(10, 'manage_navigation', 'Manage Navigation', 'Manage public header and footer navigation'),
(11, 'manage_seo', 'Manage SEO', 'Manage page titles, descriptions and social metadata'),
(12, 'manage_redirects', 'Manage Redirects', 'Create and manage public URL redirects'),
(13, 'manage_assets', 'Manage Assets', 'Upload and manage reusable website assets'),
(14, 'manage_activity_logs', 'Manage Activity Logs', 'View CMS activity and audit logs.'),
(15, 'manage_system_health', 'View System Health', 'View read-only CMS health diagnostics'),
(16, 'manage_backup_vault', '', 'Manage saved CMS database backups'),
(17, 'manage_backup_center', 'Manage database backup center', 'Create, download, verify, and manage CMS database backups'),
(18, 'manage_analytics', 'View Analytics', 'View public page views and visitor analytics.'),
(19, 'manage_notifications', 'Manage Notifications', 'View and manage admin notifications.'),
(20, 'manage_revisions', 'Manage Revisions', 'View and restore content revisions.'),
(21, 'search_content', 'Search Content', 'Search content available to the current user.'),
(22, 'view_projects', 'View Projects', 'View project records.'),
(23, 'create_projects', 'Create Projects', 'Create project records.'),
(24, 'edit_projects', 'Edit Projects', 'Edit project records.'),
(25, 'delete_projects', 'Delete Projects', 'Delete project records.'),
(26, 'publish_projects', 'Publish Projects', 'Publish or unpublish project records.');

-- --------------------------------------------------------
-- Table: projects

DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `legacy_id` varchar(50) DEFAULT NULL,
  `name` varchar(500) NOT NULL,
  `slug` varchar(500) NOT NULL,
  `sector_name` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `completion_year` smallint(5) unsigned DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `client` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `show_on_home` tinyint(1) NOT NULL DEFAULT 0,
  `show_in_category_image` tinyint(1) NOT NULL DEFAULT 0,
  `published` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `thumbnail_asset_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_projects_slug` (`slug`),
  UNIQUE KEY `uq_projects_legacy_id` (`legacy_id`),
  KEY `idx_projects_sector` (`sector_name`),
  KEY `idx_projects_category` (`category`),
  KEY `idx_projects_status` (`status`),
  KEY `idx_projects_home` (`show_on_home`),
  KEY `idx_projects_sort` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `projects` (`id`, `legacy_id`, `name`, `slug`, `sector_name`, `category`, `status`, `completion_year`, `location`, `client`, `description`, `show_on_home`, `show_in_category_image`, `published`, `sort_order`, `created_at`, `updated_at`, `thumbnail_asset_id`) VALUES
(1, 'p1', 'Logar-Gardiz 220 kV Transmission Line ', 'p1', 'Power and Energy', 'transmission line', 'Completed', 2019, 'Logar-Gardiz', NULL, 'This was a Design-Build / EPC project for a 220kV single-circuit transmission line (approx. 60 km) from Pul-e-Alam to Gardez, including towers designed for double-circuit capability. The scope included conductors, OPGW communication system, foundations, stringing, ROW clearance, security, and demining across rough and hilly terrain. The project has been successfully completed.', 1, 1, 1, 0, '2026-09-06 19:06:12', '2026-09-21 10:34:07', 320),
(2, 'p2', 'Jabul Saraj-Gulbahar 220 kV Transmission Line', 'p2', 'Power and Energy', 'transmission line', 'Completed', 2020, 'Kapisa', NULL, 'This was a Design-Build / EPC project for a 220kV single-circuit transmission line from Charikar to Gulbahar. The scope included towers, conductors, insulators, OPGW system, foundations, ROW management, security, and civil works, with towers designed for future double-circuit expansion. The project has been successfully completed.', 0, 0, 1, 1, '2026-09-06 19:06:12', '2026-09-06 19:06:12', NULL),
(3, 'p3', 'Gulbahar- Nijrab 110 kV Transmission Line', 'p3', 'Power and Energy', 'transmission line', 'Completed', 2020, 'Gulbahar- Nijrab', NULL, 'This was a Design-Build / EPC project for a 110kV single-circuit transmission line from Gulbahar to Nejrab. The scope included towers, conductors, OPGW communication system, foundations, ROW coordination, security, and demining in mountainous terrain. The project has been successfully completed.', 1, 1, 1, 2, '2026-09-06 19:06:12', '2026-09-21 10:34:07', 322),
(4, 'p4', ' Gardiz 220/20 kV Substation', 'p4', 'Power and Energy', 'substation', 'Completed', 2020, 'Gardiz', NULL, 'This was a Design-Build / EPC project for a new 220kV substation located in Gardez, Paktya Province, including 20kV switchgear, a 220/20kV transformer (16 MVA), SCADA/EMS, OPGW communication, grounding, civil works, and provision for future expansion. The project has been successfully completed.', 1, 1, 1, 3, '2026-09-06 19:06:12', '2026-09-21 10:34:07', 323),
(5, 'p5', ' Gulbahar 220/110/20 kV Substation', 'p5', 'Power and Energy', 'substation', 'Completed', 2020, 'Kapisa', 'Da Afghanistan Breshna Sherkat (DABS)', 'This was a Design-Build / EPC project for a new 220kV/110kV/20kV substation located in Gulbahar, Kapisa Province, serving as a major grid interconnection hub, including transformers, switchgear, SCADA/EMS, OPGW communication, civil works, and future expansion capability. The project has been successfully completed.', 1, 0, 1, 4, '2026-09-06 19:06:12', '2026-09-21 10:34:07', 324),
(6, 't6', 'Construction of 12.38 Km Concrete Road in Dasht-e-Barchi Area', 't6', 'Transportation', 'road', 'Completed', 2020, 'Kabul, Afghanistan', 'Kabul Municipality', 'This contract was signed between Kabul Municipality (KM) and State Corps. Through this project the construction of 12.38 Km rigid pavement alongside with water drainage structure in Dasht-e-Barchi region of Kabul province of Afghanistan was accomplished. ', 0, 0, 1, 5, '2026-09-06 19:06:12', '2026-09-21 10:34:07', 327),
(7, 'b7', 'Marshal Fahim National Defense University Phase IIIA (MFNDU - ANDU)', 'b7', 'Building', 'vertical construction', 'completed', 2020, 'Kabul', 'USACE', 'This contract was signed between USACE and State Corps. Through this project the construction of Marshal Fahim national Defense University Complex Phase IIIA for Afghan National Army in Qargha Area of Kabul City, Afghanistan was accomplished.', 1, 1, 1, 6, '2026-09-06 19:06:12', '2026-09-21 10:34:07', 331),
(8, 'b16', ' Fire Department “FD” Mazar - e- Sharif', 'b16', 'Building', 'vertical construction', 'completed', 2020, 'Balkh', 'USACE', 'This contract was signed between USACE and State Corps. Through this project the construction of Fire Department required facilities at Mazar - e- Sharif City of Balkh Province was accomplished.', 0, 0, 1, 7, '2026-09-06 19:06:12', '2026-09-21 10:34:07', 347),
(9, 'w28', 'Elevated Water Tower, Balkh', 'w28', 'water Resources', 'water supply networks', 'completed', 2020, 'Balkh', 'USACE', 'This contract was signed between USACE and State Corps. Through this project the construction of Water Towers and Water supply networks in Balkh Province was accomplished.', 0, 0, 1, 8, '2026-09-06 19:06:12', '2026-09-21 10:34:07', 361),
(10, 'w28-1', 'Water Distribution, Kabul', 'w28-1', 'water Resources', 'water supply networks', 'completed', 2020, 'Kabul', NULL, 'tobe added', 0, 0, 1, 9, '2026-09-06 19:06:12', '2026-09-21 10:34:07', 360),
(11, 'b37', 'Construction of Railway Admin Building of Kandahar', 'b37', 'Building', 'vertical construction', 'completed', 2020, 'Kandahar', 'Ministry of Public Work', 'This contract was signed between Ministry of Public Work (MOPW) and State Corps. The project covers design and construction of ARA Admin building of Kandahar province, Afghanistan.', 1, 0, 1, 10, '2026-09-06 19:06:12', '2026-09-21 10:34:07', 371),
(12, 'b38', ' Construction of Railway Admin Building of Herat Province', 'b38', 'Building', 'vertical construction', 'completed', 2020, 'Herat', 'Ministry of Public Works', 'This contract was signed between Ministry of Public Work (MOPW) and State Corps. The project covers design and construction of ARA Admin building of Herat province, Afghanistan.', 0, 0, 1, 11, '2026-09-06 19:06:12', '2026-09-21 10:34:07', 372),
(13, 'b39', 'Construction of Railway Admin Building of Balkh Province', 'b39', 'Building', 'vertical construction', 'completed', 2020, 'Balkh', 'Ministry of Public Works', 'This contract was signed between Ministry of Public Work (MOPW) and State Corps. The project covers design and construction of ARA Admin building of Balkh province, Afghanistan. ', 0, 0, 1, 12, '2026-09-06 19:06:12', '2026-09-21 10:34:07', 373),
(14, 'p40', 'Gardez Electrification and Wazai Zadran Distribution Networks (Lot 2)', 'p40', 'Power and Energy', 'multi-service', 'completed', 2020, 'Paktya', 'Da Afghanistan Breshna Sherkat (DABS)', 'This Design-Build / EPC project was executed by State Corps as a subcontractor to Angelique International Ltd., with Da Afghanistan Breshna Sherkat (DABS) as the end client, involving engineering, supply, installation, testing, and commissioning of 20kV MV and LV distribution networks in Wazai Zadran and Gardez Districts, Paktya Province. The scope included construction of 6 MV feeders (159.9 km) and LV network (283.45 km), installation of 160 distribution transformers, 7,727 concrete poles, and 2,410 meter boxes, along with complete system integration and commissioning for reliable power distribution.', 0, 0, 1, 13, '2026-09-06 19:06:12', '2026-09-21 10:34:07', 374),
(15, 'p41', 'Herat Electrification Project (Lot 1)', 'p41', 'Power and Energy', 'multi-service', 'completed', 2020, 'Herat', 'Da Afghanistan Breshna Sherkat (DABS)', 'This EPC contract was signed between Da Afghanistan Breshna Sherkat (DABS) and the ASTER Private Limited - State Corps JV. The scope of work comprises Engineering, Procurement, and Construction (EPC), including design, supply, construction, erection, testing, and commissioning of four (4) 110/20 kV substations located in Chesht Sharif, Aobey, Karokh, and Pashton Zarghoon districts of Herat Province, Afghanistan.', 0, 0, 1, 14, '2026-09-06 19:06:12', '2026-09-21 10:34:07', 378),
(16, 'p75', 'Hairatan to Dasht-e-Alwan 500 kV TL', 'p75', 'Power and Energy', 'transmission line', 'Ongoing', NULL, 'BLK-SMG-BGL', 'METQ', 'This is a Design-Build / EPC program executed under contracts between JSC METQ and State Corps for the expansion of Afghanistan’s high-voltage power transmission network. The projects include key infrastructure such as the Amu Darya Crossing Special Project in Hairatan, the Hairatan–Dashti Alwan 500 kV transmission line, and the Kabul–Jalalabad 220 kV transmission line, covering full scope of survey, design, procurement, civil works, tower erection, stringing, testing, and commissioning. These works are aimed at strengthening national grid stability, increasing transmission capacity, and enhancing regional power connectivity.', 0, 0, 1, 15, '2026-09-06 19:06:12', '2026-09-21 10:34:07', 384),
(17, 'p76', 'Kabul to Jalalabad 220 kV TL', 'p76', 'Power and Energy', 'transmission line', 'Ongoing', NULL, 'Kabul-Nangarhar', 'METQ', 'This is a Design-Build / EPC program executed under contracts between JSC METQ and State Corps for the expansion of Afghanistan’s high-voltage power transmission network. The projects include key infrastructure such as the Amu Darya Crossing Special Project in Hairatan, the Hairatan–Dashti Alwan 500 kV transmission line, and the Kabul–Jalalabad 220 kV transmission line, covering full scope of survey, design, procurement, civil works, tower erection, stringing, testing, and commissioning. These works are aimed at strengthening national grid stability, increasing transmission capacity, and enhancing regional power connectivity.', 0, 0, 1, 16, '2026-09-06 19:06:12', '2026-09-06 19:06:12', NULL),
(18, 'p77', 'Dasht-e-Alwan 500 kV SS with Shunt Reactor System', 'p77', 'Power and Energy', 'substation', 'Ongoing', NULL, 'Baghlan', 'METQ', 'This is a Design-Build / EPC program executed under contracts between JSC METQ and State Corps for the expansion of Afghanistan’s high-voltage power transmission network. The projects include key infrastructure such as the Amu Darya Crossing Special Project in Hairatan, the Hairatan–Dashti Alwan 500 kV transmission line, and the Kabul–Jalalabad 220 kV transmission line, covering full scope of survey, design, procurement, civil works, tower erection, stringing, testing, and commissioning. These works are aimed at strengthening national grid stability, increasing transmission capacity, and enhancing regional power connectivity.', 1, 0, 1, 17, '2026-09-06 19:06:12', '2026-09-06 19:06:12', NULL),
(19, 'p78', 'Shaikh Mesri 220/110/20 kV Substation', 'p78', 'Power and Energy', 'substation', 'Ongoing', NULL, 'Nangarhar', 'METQ', 'This is a Design-Build / EPC program executed under contracts between JSC METQ and State Corps for the expansion of Afghanistan’s high-voltage power transmission network. The projects include key infrastructure such as the Amu Darya Crossing Special Project in Hairatan, the Hairatan–Dashti Alwan 500 kV transmission line, and the Kabul–Jalalabad 220 kV transmission line, covering full scope of survey, design, procurement, civil works, tower erection, stringing, testing, and commissioning. These works are aimed at strengthening national grid stability, increasing transmission capacity, and enhancing regional power connectivity.', 0, 0, 1, 18, '2026-09-06 19:06:12', '2026-09-21 10:34:07', 387),
(20, 'p79', 'Arghandi Transformer Bay', 'p79', 'Power and Energy', 'substation', 'Ongoing', NULL, 'Kabul', 'METQ', 'This is a Design-Build / EPC program executed under contracts between JSC METQ and State Corps for the expansion of Afghanistan’s high-voltage power transmission network. The projects include key infrastructure such as the Amu Darya Crossing Special Project in Hairatan, the Hairatan–Dashti Alwan 500 kV transmission line, and the Kabul–Jalalabad 220 kV transmission line, covering full scope of survey, design, procurement, civil works, tower erection, stringing, testing, and commissioning. These works are aimed at strengthening national grid stability, increasing transmission capacity, and enhancing regional power connectivity .', 0, 0, 1, 19, '2026-09-06 19:06:12', '2026-09-21 10:34:07', 390),
(21, 'p85', 'Chemtala to Tarakhail 220 kV TL', 'p85', 'Power and Energy', 'transmission line', 'Ongoing', NULL, 'Kabul', 'ABC', 'This was a Design-Build / EPC project awarded to State Corps for the Ministry of Energy and Water (MEW), with financing provided by Awfi Bahram Companies under approvals of the High Economic Council (HEC) and the Economic Deputy Office of the Islamic Emirate of Afghanistan. The project covers the construction of 220 kV double-circuit transmission lines from Chemtala to Tarakhail and from Arghandi to Butkhak, development of 220 kV Tarakhail and Butkhak substations in Kabul, and installation of two 500 kV, 80 MVAR double-bus reactors at Arghandi Substation to enhance the reliability, stability, and operational performance of Afghanistan’s national power system. The project is currently under execution.', 0, 0, 1, 20, '2026-09-06 19:06:12', '2026-09-21 10:34:07', 391),
(22, 'p86', 'Arghandi to Butkhak 220 kv TL', 'p86', 'Power and Energy', 'transmission line', 'Ongoing', NULL, 'Kabul', 'ABC', 'This was a Design-Build / EPC project awarded to State Corps for the Ministry of Energy and Water (MEW), with financing provided by Awfi Bahram Companies under approvals of the High Economic Council (HEC) and the Economic Deputy Office of the Islamic Emirate of Afghanistan. The project covers the construction of 220 kV double-circuit transmission lines from Chemtala to Tarakhail and from Arghandi to Butkhak, development of 220 kV Tarakhail and Butkhak substations in Kabul, and installation of two 500 kV, 80 MVAR double-bus reactors at Arghandi Substation to enhance the reliability, stability, and operational performance of Afghanistan’s national power system. The project is currently under execution.', 0, 0, 1, 21, '2026-09-06 19:06:12', '2026-09-06 19:06:12', NULL),
(23, 'p87', 'Tarakhail 220/110kV & 220/20kV SS', 'p87', 'Power and Energy', 'substation', 'Ongoing', NULL, 'Kabul', 'ABC', 'This was a Design-Build / EPC project awarded to State Corps for the Ministry of Energy and Water (MEW), with financing provided by Awfi Bahram Companies under approvals of the High Economic Council (HEC) and the Economic Deputy Office of the Islamic Emirate of Afghanistan. The project covers the construction of 220 kV double-circuit transmission lines from Chemtala to Tarakhail and from Arghandi to Butkhak, development of 220 kV Tarakhail and Butkhak substations in Kabul, and installation of two 500 kV, 80 MVAR double-bus reactors at Arghandi Substation to enhance the reliability, stability, and operational performance of Afghanistan’s national power system. The project is currently under execution.', 0, 0, 1, 22, '2026-09-06 19:06:12', '2026-09-06 19:06:12', NULL),
(24, 'p88', 'Butkhak 220/110kV & 220/20kV SS', 'p88', 'Power and Energy', 'substation', 'Ongoing', NULL, 'Kabul', 'ABC', 'This was a Design-Build / EPC project awarded to State Corps for the Ministry of Energy and Water (MEW), with financing provided by Awfi Bahram Companies under approvals of the High Economic Council (HEC) and the Economic Deputy Office of the Islamic Emirate of Afghanistan. The project covers the construction of 220 kV double-circuit transmission lines from Chemtala to Tarakhail and from Arghandi to Butkhak, development of 220 kV Tarakhail and Butkhak substations in Kabul, and installation of two 500 kV, 80 MVAR double-bus reactors at Arghandi Substation to enhance the reliability, stability, and operational performance of Afghanistan’s national power system. The project is currently under execution.', 0, 0, 1, 23, '2026-09-06 19:06:12', '2026-09-06 19:06:12', NULL),
(25, 'p89', 'Arghandi SS 500 KV Two Reactor Bays', 'p89', 'Power and Energy', 'substation', 'Ongoing', NULL, 'Kabul', 'ABC', 'This was a Design-Build / EPC project awarded to State Corps for the Ministry of Energy and Water (MEW), with financing provided by Awfi Bahram Companies under approvals of the High Economic Council (HEC) and the Economic Deputy Office of the Islamic Emirate of Afghanistan. The project covers the construction of 220 kV double-circuit transmission lines from Chemtala to Tarakhail and from Arghandi to Butkhak, development of 220 kV Tarakhail and Butkhak substations in Kabul, and installation of two 500 kV, 80 MVAR double-bus reactors at Arghandi Substation to enhance the reliability, stability, and operational performance of Afghanistan’s national power system. The project is currently under execution.', 0, 0, 1, 24, '2026-09-06 19:06:12', '2026-09-06 19:06:12', NULL),
(26, 'p91', 'Electrification of Qush Tepa and Darzaab Districts of Jawzjan Province Project ', 'p91', 'Power and Energy', 'multi-service', 'Ongoing', NULL, 'Jawzjan', 'MoWE', 'This is a Design-Build / EPC project currently being executed under a contract between the Ministry of Water and Energy (MoWE) and State Corps, covering the development of the power network in Qush Tepa and Darzab districts of Afghanistan. The scope includes the construction of two new substations with capacities of 20 MVA in Qush Tepa and 32 MVA in Darzab, along with associated 20/0.4 kV MV and LV distribution networks with total capacities of 16 MVA in Qush Tepa and 20 MVA in Darzab. It also involves the construction of an 85.24 km 220 kV transmission line from Pul-e-Khorasan to Qush Tepa and onward to Darzab, along with a 220 kV line bay at Pul-e-Khorasan Substation for integration into the national grid.', 0, 0, 1, 25, '2026-09-06 19:06:12', '2026-09-21 10:34:07', 395),
(27, 'p94', 'Electrification of Sangcharak, Sozmaqala & Gusfandi Districts of Sar-e-Pul Province, Afghanistan ', 'p94', 'Power and Energy', 'multi-service', 'Ongoing', NULL, 'Sare Pul', 'MoWE', 'This is a Design-Build / EPC project currently being executed under a contract between the Ministry of Water and Energy (MoWE) and State Corps, covering the electrification of Sangcharak, Sozmaqala, and Gusfandi districts of Afghanistan. The scope includes the construction of a 60 km, 110 kV transmission line from Sar-e Pul to Sangcharak Substation, along with a new 110/20 kV Sangcharak Substation with a capacity of 32 MVA (2x16 MVA). It also includes the construction of a 110 kV line bay at Sar-e Pul Substation for integration into the national grid. In addition, the project involves the development of 20/0.4 kV MV/LV distribution networks with total capacities of 3 MVA in Sangcharak, 18 MVA in Sozmaqala, and 5 MVA in Gusfandi districts.', 0, 0, 1, 26, '2026-09-06 19:06:12', '2026-09-06 19:06:12', NULL),
(28, 'p96', 'Electrification of Balchiragh, Garziwan and Pashtun Kot Districts of Faryab Province ', 'p96', 'Power and Energy', 'multi-service', 'Ongoing', NULL, 'Sare Pul', 'MoWE', 'This is a Design-Build / Istisna (EPC) project currently being implemented under a contract between the Ministry of Water and Energy (MoWE) and State Corps, covering the development of the power supply network in Balchiragh, Garziwan, and Pashtun Kot districts of Faryab Province, Afghanistan. The scope of works includes the construction of a 65 km, 110 kV overhead single-circuit transmission line from Maimana Substation to Balchiragh Substation and onward to Garziwan Substation, the establishment of two new 110/20 kV substations at Balchiragh (10 MVA, 2x5 MVA) and Garziwan (10 MVA, 2x5 MVA), the construction of a 110 kV line bay at Maimana Substation for grid integration, and the development of 20/0.4 kV medium- and low-voltage distribution networks to supply residential, commercial, and public service consumers, with total distribution capacities of 8 MVA in Balchiragh, 16 MVA in Garziwan, and 5 MVA in Pashtun Kot', 0, 0, 1, 27, '2026-09-06 19:06:12', '2026-09-06 19:06:12', NULL),
(29, 'm01', 'Talc Processing Plant', 'm01', 'mining', 'mineral processing', 'ongoing', NULL, 'Sheikh Mesri Industrial Park, Nangarhar Province', 'Arya Mineral', 'Arya Mineral owns talc grinding and crushing plants located in Sheikh Mesri Industrial Park, Nangarhar Province. The plant was designed and manufactured by Zenith and constructed and installed by State Corps. It has a minimum annual grinding capacity of 30,000 tons and a crushing capacity of 100,000 tons, with the potential for further expansion as the business grows. The facility also uses advanced color-sorting technology to sort and segregate different grades and types of talc.', 1, 1, 1, 28, '2026-09-06 19:06:12', '2026-09-21 10:34:07', 396);

-- --------------------------------------------------------
-- Table: project_images

DROP TABLE IF EXISTS `project_images`;
CREATE TABLE `project_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `caption` varchar(500) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `project_asset_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_project_images_project` (`project_id`),
  KEY `idx_project_images_order` (`project_id`,`sort_order`),
  CONSTRAINT `fk_project_images_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `project_images` (`id`, `project_id`, `alt_text`, `caption`, `sort_order`, `project_asset_id`) VALUES
(1, 1, 'Logar-Gardiz 220 kV Transmission Line ', NULL, 0, 320),
(2, 2, 'Jabul Saraj-Gulbahar 220 kV Transmission Line', NULL, 0, NULL),
(3, 3, 'Gulbahar- Nijrab 110 kV Transmission Line', NULL, 0, 322),
(4, 4, ' Gardiz 220/20 kV Substation', NULL, 0, 323),
(5, 5, ' Gulbahar 220/110/20 kV Substation', NULL, 0, 324),
(6, 5, ' Gulbahar 220/110/20 kV Substation', NULL, 1, 325),
(7, 5, ' Gulbahar 220/110/20 kV Substation', NULL, 2, 326),
(8, 6, 'Construction of 12.38 Km Concrete Road in Dasht-e-Barchi Area', NULL, 0, 327),
(9, 6, 'Construction of 12.38 Km Concrete Road in Dasht-e-Barchi Area', NULL, 1, 328),
(10, 6, 'Construction of 12.38 Km Concrete Road in Dasht-e-Barchi Area', NULL, 2, 329),
(11, 6, 'Construction of 12.38 Km Concrete Road in Dasht-e-Barchi Area', NULL, 3, 330),
(12, 7, 'Marshal Fahim National Defense University Phase IIIA (MFNDU - ANDU)', NULL, 0, 331),
(13, 7, 'Marshal Fahim National Defense University Phase IIIA (MFNDU - ANDU)', NULL, 1, 332),
(14, 7, 'Marshal Fahim National Defense University Phase IIIA (MFNDU - ANDU)', NULL, 2, 333),
(15, 8, ' Fire Department “FD” Mazar - e- Sharif', NULL, 0, 347),
(16, 9, 'Elevated Water Tower, Balkh', NULL, 0, 361),
(17, 9, 'Elevated Water Tower, Balkh', NULL, 1, NULL),
(18, 10, 'Water Distribution, Kabul', NULL, 0, 360),
(19, 11, 'Construction of Railway Admin Building of Kandahar', NULL, 0, 371),
(20, 11, 'Construction of Railway Admin Building of Kandahar', NULL, 1, NULL),
(21, 11, 'Construction of Railway Admin Building of Kandahar', NULL, 2, NULL),
(22, 12, ' Construction of Railway Admin Building of Herat Province', NULL, 0, 372),
(23, 12, ' Construction of Railway Admin Building of Herat Province', NULL, 1, NULL),
(24, 12, ' Construction of Railway Admin Building of Herat Province', NULL, 2, NULL),
(25, 13, 'Construction of Railway Admin Building of Balkh Province', NULL, 0, 373),
(26, 13, 'Construction of Railway Admin Building of Balkh Province', NULL, 1, NULL),
(27, 13, 'Construction of Railway Admin Building of Balkh Province', NULL, 2, NULL),
(28, 14, 'Gardez Electrification and Wazai Zadran Distribution Networks (Lot 2)', NULL, 0, 374),
(29, 14, 'Gardez Electrification and Wazai Zadran Distribution Networks (Lot 2)', NULL, 1, 375),
(30, 14, 'Gardez Electrification and Wazai Zadran Distribution Networks (Lot 2)', NULL, 2, 376),
(31, 14, 'Gardez Electrification and Wazai Zadran Distribution Networks (Lot 2)', NULL, 3, 377),
(32, 15, 'Herat Electrification Project (Lot 1)', NULL, 0, 378),
(33, 15, 'Herat Electrification Project (Lot 1)', NULL, 1, 379),
(34, 15, 'Herat Electrification Project (Lot 1)', NULL, 2, 380),
(35, 15, 'Herat Electrification Project (Lot 1)', NULL, 3, 381),
(36, 16, 'Hairatan to Dasht-e-Alwan 500 kV TL', NULL, 0, 384),
(37, 16, 'Hairatan to Dasht-e-Alwan 500 kV TL', NULL, 1, 385),
(38, 16, 'Hairatan to Dasht-e-Alwan 500 kV TL', NULL, 2, 386),
(39, 19, 'Shaikh Mesri 220/110/20 kV Substation', NULL, 0, 387),
(40, 19, 'Shaikh Mesri 220/110/20 kV Substation', NULL, 1, 388),
(41, 19, 'Shaikh Mesri 220/110/20 kV Substation', NULL, 2, 389),
(43, 21, 'Chemtala to Tarakhail 220 kV TL', NULL, 0, 391),
(44, 21, 'Chemtala to Tarakhail 220 kV TL', NULL, 1, 392),
(45, 21, 'Chemtala to Tarakhail 220 kV TL', NULL, 2, 393),
(46, 26, 'Electrification of Qush Tepa and Darzaab Districts of Jawzjan Province Project ', NULL, 0, 395),
(47, 26, 'Electrification of Qush Tepa and Darzaab Districts of Jawzjan Province Project ', NULL, 1, NULL),
(48, 27, 'Electrification of Sangcharak, Sozmaqala & Gusfandi Districts of Sar-e-Pul Province, Afghanistan ', NULL, 0, NULL),
(49, 27, 'Electrification of Sangcharak, Sozmaqala & Gusfandi Districts of Sar-e-Pul Province, Afghanistan ', NULL, 1, NULL),
(50, 27, 'Electrification of Sangcharak, Sozmaqala & Gusfandi Districts of Sar-e-Pul Province, Afghanistan ', NULL, 2, NULL),
(51, 29, 'Talc Processing Plant', NULL, 0, 396),
(52, 29, 'Talc Processing Plant', NULL, 1, 397),
(53, 20, NULL, NULL, 0, 390);

-- --------------------------------------------------------
-- Table: project_scope

DROP TABLE IF EXISTS `project_scope`;
CREATE TABLE `project_scope` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `scope_text` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_project_scope_project` (`project_id`),
  CONSTRAINT `fk_project_scope_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `project_scope` (`id`, `project_id`, `scope_text`, `sort_order`) VALUES
(1, 1, 'Construction of a 220kV transmission line from Pul-e-Alam to Gardez', 0),
(2, 1, 'Installation of towers, conductors, and OPGW system', 1),
(3, 1, 'Foundation, stringing, ROW, security, and demining works', 2),
(4, 1, 'Construction across rough and hilly terrain', 3),
(5, 2, 'Construction of a 220kV transmission line from Charikar to Gulbahar', 0),
(6, 2, 'Installation of towers, conductors, insulators, and OPGW system', 1),
(7, 2, 'Foundation, ROW, security, and civil works', 2),
(8, 2, 'Construction across rough, hilly, and desert terrain', 3),
(9, 3, 'Construction of a 110kV transmission line from Gulbahar to Nejrab', 0),
(10, 3, 'Installation of towers, conductors, and OPGW communication system', 1),
(11, 3, 'Foundation, ROW, security, and demining works', 2),
(12, 3, 'Construction across mountainous and difficult terrain', 3),
(13, 4, 'Construction of a new 220kV substation in Gardez', 1),
(14, 4, 'Installation of 20kV switchgear, protection, and SCADA systems', 2),
(15, 4, 'OPGW communication, grounding, and civil works', 3),
(16, 4, 'Future expansion capability included', 4),
(17, 5, 'Construction of a new 220kV/110kV/20kV substation in Gulbahar', 0),
(18, 5, 'Installation of transformers, switchgear, protection, and SCADA systems', 1),
(19, 5, 'OPGW communication and civil works', 2),
(20, 5, 'Designed for future expansion', 3),
(21, 6, 'construction of 12.38 Km rigid pavement alongside with water drainage structure', 0),
(22, 14, 'Design-Build / EPC project', 0),
(23, 14, 'Survey, design, installation, testing, and commissioning of MV/LV networks', 1),
(24, 14, 'Construction of 6 MV feeders (159.9 km) and LV network (283.45 km)', 2),
(25, 14, 'Installation of 160 distribution transformers and 7,727 concrete poles', 3),
(26, 14, 'Installation of 2,410 meter boxes', 4),
(27, 14, 'Complete MV/LV network execution and commissioning for reliable power distribution', 5),
(28, 15, '110/20 kV Chesht Substation (8/10 MVA)', 0),
(29, 15, '110/20 kV Hobai Substation (8/10 MVA)', 1),
(30, 15, '110/20 kV Karokh Substation (8/10 MVA)', 2),
(31, 15, '110/20 kV Pashton Zarghoon Substation (8/10 MVA)', 3),
(32, 16, 'Surkhan - Dashti Alwan Substation (500 kV Single Circuit Triple Conductor)', 0),
(33, 16, 'Butkhak – Sheikh Mesri 220 kV double-circuit double-conductor transmission line.', 1),
(34, 16, '500 kV Dashti Alwan Substation ', 2),
(35, 16, ' 220/110/20 kV Shaikh Mesri Substation', 3),
(36, 16, '500/220/20 kV Arghandi Substation and Shunt Reactor System', 4),
(37, 17, 'Surkhan - Dashti Alwan Substation (500 kV Single Circuit Triple Conductor)', 0),
(38, 17, 'Butkhak – Sheikh Mesri 220 kV double-circuit double-conductor transmission line.', 1),
(39, 17, '500 kV Dashti Alwan Substation ', 2),
(40, 17, ' 220/110/20 kV Shaikh Mesri Substation', 3),
(41, 17, '500/220/20 kV Arghandi Substation and Shunt Reactor System', 4),
(42, 18, 'Surkhan - Dashti Alwan Substation (500 kV Single Circuit Triple Conductor)', 0),
(43, 18, 'Butkhak – Sheikh Mesri 220 kV double-circuit double-conductor transmission line.', 1),
(44, 18, '500 kV Dashti Alwan Substation ', 2),
(45, 18, ' 220/110/20 kV Shaikh Mesri Substation', 3),
(46, 18, '500/220/20 kV Arghandi Substation and Shunt Reactor System', 4),
(47, 19, 'Surkhan - Dashti Alwan Substation (500 kV Single Circuit Triple Conductor)', 0),
(48, 19, 'Butkhak – Sheikh Mesri 220 kV double-circuit double-conductor transmission line.', 1),
(49, 19, '500 kV Dashti Alwan Substation ', 2),
(50, 19, ' 220/110/20 kV Shaikh Mesri Substation', 3),
(51, 19, '500/220/20 kV Arghandi Substation and Shunt Reactor System', 4),
(57, 21, 'Chemtala – Tarakhail (23 km) 220 kV TL', 0),
(58, 21, 'Arghandi – Butkhak (56 km) 220 kV TL', 1),
(59, 21, 'OPGW communication & protection system installation', 2),
(60, 21, 'Tarakhail Substation (220/110/20 kV, 3×63 MVA)', 3),
(61, 21, 'Butkhak Substation (220/110/20 kV, 4×63 MVA)', 4),
(62, 21, 'Butkhak Substation Reactor Bays', 5),
(63, 21, 'Arghandi 500 kV Substation Reactor bays', 6),
(64, 22, 'Chemtala – Tarakhail (23 km) 220 kV TL', 0),
(65, 22, 'Arghandi – Butkhak (56 km) 220 kV TL', 1),
(66, 22, 'OPGW communication & protection system installation', 2),
(67, 22, 'Tarakhail Substation (220/110/20 kV, 3×63 MVA)', 3),
(68, 22, 'Butkhak Substation (220/110/20 kV, 4×63 MVA)', 4),
(69, 22, 'Butkhak Substation Reactor Bays', 5),
(70, 22, 'Arghandi 500 kV Substation Reactor bays', 6),
(71, 23, 'Chemtala – Tarakhail (23 km) 220 kV TL', 0),
(72, 23, 'Arghandi – Butkhak (56 km) 220 kV TL', 1),
(73, 23, 'OPGW communication & protection system installation', 2),
(74, 23, 'Tarakhail Substation (220/110/20 kV, 3×63 MVA)', 3),
(75, 23, 'Butkhak Substation (220/110/20 kV, 4×63 MVA)', 4),
(76, 23, 'Butkhak Substation Reactor Bays', 5),
(77, 23, 'Arghandi 500 kV Substation Reactor bays', 6),
(78, 24, 'Chemtala – Tarakhail (23 km) 220 kV TL', 0),
(79, 24, 'Arghandi – Butkhak (56 km) 220 kV TL', 1),
(80, 24, 'OPGW communication & protection system installation', 2),
(81, 24, 'Tarakhail Substation (220/110/20 kV, 3×63 MVA)', 3),
(82, 24, 'Butkhak Substation (220/110/20 kV, 4×63 MVA)', 4),
(83, 24, 'Butkhak Substation Reactor Bays', 5),
(84, 24, 'Arghandi 500 kV Substation Reactor bays', 6),
(85, 25, 'Chemtala – Tarakhail (23 km) 220 kV TL', 0),
(86, 25, 'Arghandi – Butkhak (56 km) 220 kV TL', 1),
(87, 25, 'OPGW communication & protection system installation', 2),
(88, 25, 'Tarakhail Substation (220/110/20 kV, 3×63 MVA)', 3),
(89, 25, 'Butkhak Substation (220/110/20 kV, 4×63 MVA)', 4),
(90, 25, 'Butkhak Substation Reactor Bays', 5),
(91, 25, 'Arghandi 500 kV Substation Reactor bays', 6),
(92, 26, 'Pul-e-Khorasan - Qush Tepa (52.76 km) 220 kV TL', 0),
(93, 26, 'Qush Tepa - Darzab (32.48 km) 220 kV TL', 1),
(94, 26, 'OPGW communication & protection system installation', 2),
(95, 26, '220/20 kV Substation, Qush Tepa (20 MVA)', 3),
(96, 26, '220/20 kV Substation, Darzab (32 MVA)', 4),
(97, 26, '220 kV line bay at Pul-e-Khorasan Substation', 5),
(98, 26, '20/0.4 kV MV/LV distribution networks (Qush Tepa & Darzab)', 6),
(99, 26, 'Distribution capacity: 16 MVA (Qush Tepa)', 7),
(100, 26, 'Distribution capacity: 20 MVA (Darzab)', 8),
(101, 27, 'Sar-e Pul - Sangcharak Substation (60 km)', 0),
(102, 27, 'Overhead 110 kV single-circuit transmission line', 1),
(103, 27, 'OPGW communication and protection system installation', 2),
(104, 27, '110/20 kV Sangcharak Substation (32 MVA, 2x16 MVA)', 3),
(105, 27, '110 kV line bay at Sar-e Pul Substation', 4);
INSERT INTO `project_scope` (`id`, `project_id`, `scope_text`, `sort_order`) VALUES
(106, 27, '20/0.4 kV MV/LV distribution networks in three districts', 5),
(107, 27, ' Distribution capacity: 3 MVA (Sangcharak)', 6),
(108, 27, ' Distribution capacity: 18 MVA (Sozmaqala)', 7),
(109, 27, ' Distribution capacity: 5 MVA (Gusfandi)', 8),
(110, 28, 'Maimana - Balchiragh Substation (44 km) 110 kV TL', 0),
(111, 28, 'Balchiragh - Garziwan Substation (21 km) 110 kV TL', 1),
(112, 28, 'Overhead 110 kV single-circuit transmission line', 2),
(113, 28, '110/20 kV Balchiragh Substation (10 MVA, 2x5 MVA)', 3),
(114, 28, '110/20 kV Garziwan Substation (10 MVA, 2x5 MVA)', 4),
(115, 28, '110 kV line bay at Maimana Substation', 5),
(116, 28, '20/0.4 kV MV/LV distribution networks in three districts', 6),
(117, 28, 'Distribution capacity: 8 MVA (Balchiragh)', 7),
(118, 28, 'Distribution capacity: 16 MVA (Garziwan)', 8),
(119, 28, 'Distribution capacity: 5 MVA (Pashtun Kot)', 9),
(120, 29, 'Advanced color-sorting technology to sort and segregate different grades and types of talc.', 0),
(121, 29, 'Facility designed with capacity for further expansion as business grows.', 1),
(122, 20, 'Surkhan - Dashti Alwan Substation (500 kV Single Circuit Triple Conductor)', 0),
(123, 20, 'Butkhak – Sheikh Mesri 220 kV double-circuit double-conductor transmission line.', 1),
(124, 20, '500 kV Dashti Alwan Substation', 2),
(125, 20, '220/110/20 kV Shaikh Mesri Substation', 3),
(126, 20, '500/220/20 kV Arghandi Substation and Shunt Reactor System', 4);

-- --------------------------------------------------------
-- Table: sectors

DROP TABLE IF EXISTS `sectors`;
CREATE TABLE `sectors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sector_key` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `hero_tag` varchar(255) DEFAULT NULL,
  `hero_headline` varchar(500) DEFAULT NULL,
  `hero_subtitle` varchar(500) DEFAULT NULL,
  `hero_cta_text` varchar(255) DEFAULT NULL,
  `hero_cta_link` varchar(500) DEFAULT NULL,
  `featured_project_name` varchar(500) DEFAULT NULL,
  `featured_project_cta_text` varchar(255) DEFAULT NULL,
  `featured_project_cta_link` varchar(500) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `hero_asset_id` int(10) unsigned DEFAULT NULL,
  `featured_project_asset_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_sector_key` (`sector_key`),
  KEY `idx_sector_order` (`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sectors` (`id`, `sector_key`, `title`, `description`, `hero_tag`, `hero_headline`, `hero_subtitle`, `hero_cta_text`, `hero_cta_link`, `featured_project_name`, `featured_project_cta_text`, `featured_project_cta_link`, `sort_order`, `is_active`, `hero_asset_id`, `featured_project_asset_id`) VALUES
(1, 'powerenergy', 'Power & Energy', 'The Power & Energy sector drives the development, engineering, and delivery of reliable electricity infrastructure across the region, encompassing high-voltage transmission lines, substations, and renewable energy solutions including solar, wind, and hydropower. By integrating advanced technologies with deep engineering expertise, the company designs and implements efficient, sustainable energy systems that meet growing demands. Through active support of national grid expansion, it enhances energy accessibility for communities and industries alike, while contributing to long-term economic growth and strengthening energy security — powering a more resilient and sustainable future for generations to come.', 'Power & Energy Sector', 'Delivering Reliable Power Infrastructure & Renewable Energy Solutions', 'High Voltage • Transmission • Renewable Energy', 'Reach Us', 'contact.php', 'Herat Substation Project', 'View Projects', 'projects.php?category=powerenergy', 0, 1, 292, 276),
(2, 'transport', 'Transportation', 'The transportation infrastructure sector focuses on delivering integrated, efficient, and sustainable mobility solutions including roads, railways, and airports. Through advanced engineering, modern construction techniques, and strict safety standards, the company develops critical transport networks that enhance connectivity, support economic growth, and improve regional accessibility. With a commitment to quality and innovation, projects are executed to meet international standards while addressing local development needs.', 'Transport Sector', 'Building Modern, Safe & Sustainable Transportation Infrastructure', 'Engineering Excellence in Mobility Solutions', 'Reach Us', 'contact.php', 'National Highway Development Project', 'View Projects', 'projects.php?category=transport', 1, 1, 295, 328),
(3, 'Infrastructure', 'Building', 'The infrastructure and construction sector focuses on delivering high-quality, sustainable, and modern built environments including residential, commercial, and industrial developments. With strong engineering expertise, advanced construction methodologies, and adherence to international standards, the company ensures reliable and efficient project delivery. From buildings and bridges to tunnels and large-scale infrastructure, every project is executed with a commitment to safety, durability, and long-term value creation.', 'Infrastructure Sector', 'Delivering Modern, Sustainable & High-Quality Construction Solutions', 'Engineering Excellence in Built Environments', 'Reach Us', 'contact.php', 'National Infrastructure Development Project', 'View Projects', 'projects.php?category=infrastructure', 2, 1, 294, 331),
(4, 'water', 'Water Resources', 'The water resources sector focuses on sustainable management, design, and development of hydraulic infrastructure including water supply systems, dams, irrigation networks, and wastewater treatment facilities. With advanced engineering practices and environmental responsibility, the company delivers efficient water solutions that support agriculture, urban development, and long-term resource sustainability.', 'Water Sector', 'Sustainable Water Management & Hydraulic Infrastructure Solutions', 'Engineering Water for Life & Development', 'Reach Us', 'contact.php', 'Regional Water Management Project', 'View Projects', 'projects.php?category=water', 3, 1, 296, 361),
(5, 'mining', 'Mining', 'The mining sector at Arya Mineral is focused on delivering efficient, sustainable, and large-scale extraction of industrial minerals and gemstones. Leveraging modern technologies and advanced engineering practices, the company ensures optimized production while maintaining high safety and environmental standards. Its expertise spans mine planning, operational management, and economic analysis, enabling projects to achieve both technical and financial success. With a strong presence in key resource areas such as talc concessions, Arya Mineral combines local knowledge with international expertise to maximize resource value, support regional development, and contribute to long-term growth in Afghanistan\'s mining industry.\r\n\r\n2019: Brand Launch and Global Outreach At the beginning of 2019, the company successfully produced and exported its specialized A grade ultra-fine Afghan talc powder under its own brand name. This achievement was particularly historic as it marked the first-ever shipment of talc from Afghanistan to Jordan. Throughout 2019, Arya Mineral rapidly expanded its footprint, exporting processed talc to a wide array of international markets, including: •	Asia: India, Japan, South Korea, Kazakhstan, and Tajikistan.•	Middle East: Jordan, Iraq, and Turkey.•	Europe & Eurasia: Germany and Russia.\r\n\r\n2019-2021: Market Expansion and Partnerships Between 2019 and 2021, Arya Mineral secured a strategic collaboration and contract with a Chinese firm to penetrate and expand its presence within the Chinese markets. By May 27, 2021, the company remained highly active in the processing and export sector, continuing to build upon the foundation of its established factory and its track record of successful international trade', 'Mining Sector', 'Delivering Sustainable Mining & Mineral Solutions Across Afghanistan and Beyond', 'ISO Certified Operations', 'Reach Us', 'contact.php', 'Talc Processing Plant', 'View Projects', 'projects.php?category=mining', 4, 1, 293, 397);

-- --------------------------------------------------------
-- Table: sector_areas

DROP TABLE IF EXISTS `sector_areas`;
CREATE TABLE `sector_areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sector_id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_sector_areas_sector` (`sector_id`),
  CONSTRAINT `fk_sector_areas_sector` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sector_areas` (`id`, `sector_id`, `title`, `sort_order`) VALUES
(1, 1, 'Substation Engineering', 0),
(2, 1, 'Transmission Line Construction', 1),
(3, 1, 'Power Distribution Networks', 2),
(4, 1, 'Hydropower Development', 3),
(5, 1, 'Solar Energy Systems', 4),
(6, 1, 'Wind Energy Projects', 5),
(7, 2, 'Road Construction', 0),
(8, 2, 'Railway Development', 1),
(9, 2, 'Airport Infrastructure', 2),
(10, 2, 'Bridges & Tunnels', 3),
(11, 2, 'Urban Transport Systems', 4),
(12, 2, 'Logistics Infrastructure', 5),
(13, 3, 'Residential Buildings', 0),
(14, 3, 'Commercial Complexes', 1),
(15, 3, 'Bridges & Structures', 2),
(16, 3, 'Tunnels & Underground Works', 3),
(17, 3, 'Industrial Facilities', 4),
(18, 3, 'Urban Development', 5),
(19, 4, 'Water Supply Systems', 0),
(20, 4, 'Wastewater Treatment', 1),
(21, 4, 'Dams & Reservoirs', 2),
(22, 4, 'Irrigation Networks', 3),
(23, 4, 'Water Channels', 4),
(24, 4, 'Flood Protection Systems', 5),
(25, 5, 'Exploration', 0),
(26, 5, 'Extraction', 1),
(27, 5, 'Processing', 2),
(28, 5, 'Trade', 3),
(29, 5, 'Consultancy', 4);

-- --------------------------------------------------------
-- Table: sector_sections

DROP TABLE IF EXISTS `sector_sections`;
CREATE TABLE `sector_sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sector_id` int(10) unsigned NOT NULL,
  `legacy_id` varchar(100) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_sector_section_legacy` (`sector_id`,`legacy_id`),
  KEY `idx_sector_sections_sector` (`sector_id`),
  CONSTRAINT `fk_sector_sections_sector` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sector_sections` (`id`, `sector_id`, `legacy_id`, `title`, `category`, `content`, `sort_order`, `is_active`) VALUES
(1, 2, 'road', 'Roads', 'construction', 'Development of durable and high-capacity road networks connecting urban and rural areas.', 0, 1),
(2, 2, 'railway', 'Railways', 'construction', 'Design and construction of efficient railway systems for passenger and freight transport.', 1, 1),
(3, 2, 'airports', 'Airports', 'construction', 'Construction and expansion of modern airport facilities supporting national and international travel.', 2, 1),
(4, 3, 'buildings', 'Buildings', 'construction', 'Residential, commercial, industrial, and institutional building development with modern engineering standards.', 0, 1),
(5, 3, 'bridge', 'Bridges', 'construction', 'Design and construction of durable and safe bridge structures for transportation connectivity.', 1, 1),
(6, 3, 'tunnels', 'Tunnels', 'construction', 'Engineering and construction of underground tunnel systems for transport and utilities.', 2, 1),
(7, 4, 'watersupply', 'Water Supply Systems', 'water_resources', 'Design and implementation of efficient and reliable water supply networks for urban and rural areas.', 0, 1),
(8, 4, 'wastewater', 'Wastewater Systems', 'water_resources', 'Engineering modern wastewater collection, treatment, and disposal systems for sustainable environments.', 1, 1),
(9, 4, 'dam', 'Dams', 'construction', 'Design and construction of dams for water storage, irrigation, and hydropower development.', 2, 1),
(10, 4, 'irrigation', 'Canals & Irrigation', 'water_resources', 'Development of irrigation canals and agricultural water distribution systems for sustainable farming.', 3, 1),
(11, 4, 'protection', 'Protection Structures', 'water_resources', 'Flood protection, river training, and erosion control structures for environmental safety.', 4, 1);

-- --------------------------------------------------------
-- Table: sector_section_images

DROP TABLE IF EXISTS `sector_section_images`;
CREATE TABLE `sector_section_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `section_id` int(10) unsigned NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `section_asset_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sector_section_images_section` (`section_id`),
  CONSTRAINT `fk_sector_section_images_section` FOREIGN KEY (`section_id`) REFERENCES `sector_sections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sector_section_images` (`id`, `section_id`, `sort_order`, `section_asset_id`) VALUES
(1, 1, 0, 241),
(2, 1, 1, 241),
(3, 1, 2, 241),
(4, 1, 3, 241),
(5, 2, 0, 241),
(6, 2, 1, 241),
(7, 2, 2, 241),
(8, 2, 3, 241),
(9, 3, 0, 241),
(10, 3, 1, 241),
(11, 3, 2, 241),
(12, 3, 3, 241),
(13, 4, 0, 241),
(14, 4, 1, 241),
(15, 4, 2, 241),
(16, 4, 3, 241),
(17, 5, 0, 241),
(18, 5, 1, 241),
(19, 5, 2, 241),
(20, 5, 3, 241),
(21, 6, 0, 241),
(22, 6, 1, 241),
(23, 6, 2, 241),
(24, 6, 3, 241),
(25, 7, 0, 241),
(26, 7, 1, 241),
(27, 7, 2, 241),
(28, 7, 3, 241),
(29, 8, 0, 241),
(30, 8, 1, 241),
(31, 8, 2, 241),
(32, 8, 3, 241),
(33, 9, 0, 241),
(34, 9, 1, 241),
(35, 9, 2, 241),
(36, 9, 3, 241),
(37, 10, 0, 241),
(38, 10, 1, 241),
(39, 10, 2, 241),
(40, 10, 3, 241),
(41, 11, 0, 241),
(42, 11, 1, 241),
(43, 11, 2, 241),
(44, 11, 3, 241);

-- --------------------------------------------------------
-- Table: sector_section_stats

DROP TABLE IF EXISTS `sector_section_stats`;
CREATE TABLE `sector_section_stats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `section_id` int(10) unsigned NOT NULL,
  `value_text` varchar(100) NOT NULL,
  `label` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_sector_section_stats_section` (`section_id`),
  CONSTRAINT `fk_sector_section_stats_section` FOREIGN KEY (`section_id`) REFERENCES `sector_sections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sector_section_stats` (`id`, `section_id`, `value_text`, `label`, `sort_order`) VALUES
(1, 1, '15+', 'Projects', 0),
(2, 1, '10+', 'Road Types', 1),
(3, 1, '3+', 'Countries', 2),
(4, 1, '$100M+', 'Total Value', 3),
(5, 2, '10+', 'Projects', 0),
(6, 2, '5+', 'Rail Lines', 1),
(7, 2, '3+', 'Countries', 2),
(8, 2, '$80M+', 'Total Value', 3),
(9, 3, '5+', 'Projects', 0),
(10, 3, '2+', 'Major Airports', 1),
(11, 3, '3+', 'Countries', 2),
(12, 3, '$200M+', 'Total Value', 3),
(13, 4, '5+', 'Projects', 0),
(14, 4, '200+', 'Buildings Designed', 1),
(15, 4, '3+', 'Regions', 2),
(16, 4, '$300M+', 'Total Value', 3),
(17, 5, '5+', 'Projects', 0),
(18, 5, '50+', 'Bridges Designed', 1),
(19, 5, '3+', 'Regions', 2),
(20, 5, '$250M+', 'Total Value', 3),
(21, 6, '3+', 'Projects', 0),
(22, 6, '20km+', 'Tunnels Built', 1),
(23, 6, '2+', 'Regions', 2),
(24, 6, '$180M+', 'Total Value', 3),
(25, 7, '20+', 'Systems Built', 0),
(26, 7, '15+', 'Projects', 1),
(27, 7, '5+', 'Regions', 2),
(28, 7, '$500M+', 'Total Value', 3),
(29, 8, '10+', 'Treatment Plants', 0),
(30, 8, '30+', 'Projects', 1),
(31, 8, '100%', 'Compliance', 2),
(32, 8, '$300M+', 'Total Value', 3),
(33, 9, '10+', 'Dams Built', 0),
(34, 9, '5+', 'Regions', 1),
(35, 9, '500+', 'MW Capacity Support', 2),
(36, 9, '$150M+', 'Total Value', 3),
(37, 10, '100km+', 'Canals Built', 0),
(38, 10, '15+', 'Projects', 1),
(39, 10, '10+', 'Regions', 2),
(40, 10, '$200M+', 'Total Value', 3),
(41, 11, '50+', 'Structures Built', 0),
(42, 11, '15+', 'Projects', 1),
(43, 11, '10+', 'Regions', 2),
(44, 11, '$150M+', 'Total Value', 3);

-- --------------------------------------------------------
-- Table: sector_stats

DROP TABLE IF EXISTS `sector_stats`;
CREATE TABLE `sector_stats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sector_id` int(10) unsigned NOT NULL,
  `value_text` varchar(100) NOT NULL,
  `label` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_sector_stats_sector` (`sector_id`),
  CONSTRAINT `fk_sector_stats_sector` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sector_stats` (`id`, `sector_id`, `value_text`, `label`, `sort_order`) VALUES
(1, 1, '50+', 'Projects', 0),
(2, 1, '30+', 'Substations', 1),
(3, 1, '700km+', 'Transmission Lines', 2),
(4, 1, '500kV', 'Max Voltage', 3),
(5, 1, '$350M+', 'Total Value', 4),
(6, 2, '15+', 'Projects Completed', 0),
(7, 2, '10+', 'Infrastructure Types', 1),
(8, 2, '3+', 'Countries Served', 2),
(9, 2, '$100M+', 'Total Project Value', 3),
(10, 3, '20+', 'Projects Delivered', 0),
(11, 3, '500km+', 'Infrastructure Developed', 1),
(12, 3, '5+', 'Regions Covered', 2),
(13, 3, '$300M+', 'Total Project Value', 3),
(14, 4, '20+', 'Projects Completed', 0),
(15, 4, '15+', 'Systems Developed', 1),
(16, 4, '5+', 'Sectors Covered', 2),
(17, 4, '$500M+', 'Total Project Value', 3),
(18, 5, '12+', 'Years of Experience', 0),
(19, 5, '100,000+', 'Tons Processing Capacity', 1),
(20, 5, '5+', 'Projects Delivered', 2),
(21, 5, '$5M+', 'Value', 3);

-- --------------------------------------------------------
-- Table: sector_why

DROP TABLE IF EXISTS `sector_why`;
CREATE TABLE `sector_why` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sector_id` int(10) unsigned NOT NULL,
  `text_content` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_sector_why_sector` (`sector_id`),
  CONSTRAINT `fk_sector_why_sector` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sector_why` (`id`, `sector_id`, `text_content`, `sort_order`) VALUES
(1, 1, 'Capability to handle large-scale EPC power projects', 0),
(2, 1, 'Proven expertise in high-voltage infrastructure', 1),
(3, 1, 'End-to-end power project delivery', 2),
(4, 1, 'Integration of renewable energy solutions', 3),
(5, 1, 'Advanced engineering and modern technologies', 4),
(6, 1, 'Reliable and scalable distribution systems', 5),
(7, 1, 'Compliance with international safety and quality standards', 6),
(8, 1, 'Efficient project management and timely execution', 7),
(9, 1, 'Expertise in both conventional and renewable energy systems', 8),
(10, 1, 'Lifecycle support from design to operation and maintenance', 9),
(11, 2, 'Proven expertise in large-scale infrastructure development', 0),
(12, 2, 'End-to-end transport project delivery', 1),
(13, 2, 'Advanced engineering and modern construction technologies', 2),
(14, 2, 'Strong focus on safety and durability standards', 3),
(15, 2, 'Sustainable and efficient mobility solutions', 4),
(16, 2, 'Experienced multidisciplinary engineering teams', 5),
(17, 2, 'Integration of smart transport systems', 6),
(18, 3, 'Proven expertise in large-scale construction projects', 0),
(19, 3, 'End-to-end infrastructure development capability', 1),
(20, 3, 'Modern engineering and construction technologies', 2),
(21, 3, 'Strong compliance with international standards', 3),
(22, 3, 'Sustainable and efficient design practices', 4),
(23, 3, 'Experienced multidisciplinary teams', 5),
(24, 3, 'Focus on safety and long-term durability', 6),
(25, 4, 'Expertise in large-scale water infrastructure', 0),
(26, 4, 'Advanced hydraulic engineering solutions', 1),
(27, 4, 'Sustainable water resource management', 2),
(28, 4, 'Modern design and construction technologies', 3),
(29, 4, 'Strong environmental compliance focus', 4),
(30, 4, 'Efficient irrigation and distribution systems', 5),
(31, 4, 'Reliable long-term performance solutions', 6),
(32, 5, 'Proven track record in mining & infrastructure', 0),
(33, 5, 'International-standard engineering & operations', 1),
(34, 5, 'Advanced exploration techniques', 2),
(35, 5, 'Advanced processing & modern technology', 3),
(36, 5, 'Sustainable and community-focused approach', 4),
(37, 5, 'Expert engineering teams', 5),
(38, 5, 'Safety-first operations', 6);

-- --------------------------------------------------------
-- Table: service_categories

DROP TABLE IF EXISTS `service_categories`;
CREATE TABLE `service_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `category_key` varchar(150) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idx_service_categories_group` (`group_id`),
  CONSTRAINT `fk_service_categories_group` FOREIGN KEY (`group_id`) REFERENCES `service_groups` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `service_categories` (`id`, `group_id`, `category_key`, `title`, `sort_order`, `is_active`) VALUES
(1, 1, 'engineering-surveys', 'Engineering Surveys', 0, 1),
(2, 1, 'design-services', 'Design Services', 1, 1),
(3, 1, 'engineering-services', 'Engineering Services', 2, 1),
(4, 2, 'project-management', 'Project Management', 0, 1),
(5, 2, 'procurement-logistics', 'Procurement & Supply Chain', 1, 1),
(6, 2, 'construction-site-development', 'Construction & Site Development', 2, 1),
(7, 2, 'testing-commissioning', 'Testing & Commissioning', 3, 1),
(8, 2, 'digital-quality-hse', 'Digital Delivery, Quality & HSE', 4, 1),
(13, 3, 'consulting', 'Consulting', 4, 1);

-- --------------------------------------------------------
-- Table: service_features

DROP TABLE IF EXISTS `service_features`;
CREATE TABLE `service_features` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `service_item_id` int(10) unsigned NOT NULL,
  `feature_text` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_service_features_item` (`service_item_id`),
  CONSTRAINT `fk_service_features_item` FOREIGN KEY (`service_item_id`) REFERENCES `service_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=228 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `service_features` (`id`, `service_item_id`, `feature_text`, `sort_order`) VALUES
(1, 1, 'Site assessment and constraint mapping', 0),
(2, 1, 'Technical and financial viability analysis', 1),
(3, 1, 'Risk identification and mitigation strategies', 2),
(4, 1, 'Preliminary cost estimation', 3),
(5, 2, 'Topographic and cadastral mapping', 0),
(6, 2, 'Aerial and satellite imagery analysis', 1),
(7, 2, '3D terrain modelling', 2),
(8, 2, 'Geospatial data management', 3),
(9, 3, 'Environmental Impact Assessment (EIA)', 0),
(10, 3, 'Social Impact Assessment (SIA)', 1),
(11, 3, 'Stakeholder engagement planning', 2),
(12, 3, 'Mitigation and management plans', 3),
(13, 4, 'Alternatives analysis', 0),
(14, 4, 'Concept-level cost estimates', 1),
(15, 4, 'Design basis memorandum', 2),
(16, 4, 'Stakeholder review support', 3),
(17, 5, 'Schematic and detailed design', 0),
(18, 5, 'BIM-integrated workflows', 1),
(19, 5, 'Planning and permits coordination', 2),
(20, 5, 'Construction document production', 3),
(21, 6, 'Grading and earthwork design', 0),
(22, 6, 'Stormwater and drainage systems', 1),
(23, 6, 'Utility corridor layout', 2),
(24, 6, 'Construction drawings and specifications', 3),
(25, 7, 'Steel, concrete, and composite structures', 0),
(26, 7, 'Seismic and wind load analysis', 1),
(27, 7, 'Foundation design', 2),
(28, 7, 'Structural health monitoring', 3),
(29, 8, 'Load analysis and single-line diagrams', 0),
(30, 8, 'Lighting and power layouts', 1),
(31, 8, 'Protection and control systems', 2),
(32, 8, 'Cable routing and specifications', 3),
(33, 9, 'HVAC load calculations and system selection', 0),
(34, 9, 'Plumbing and sanitation layouts', 1),
(35, 9, 'Fire suppression system design', 2),
(36, 9, 'Process and piping design', 3),
(37, 11, 'Concept through to tender documentation', 0),
(38, 11, 'Multi-storey and high-rise structures', 1),
(39, 11, 'Post-tensioned and pre-stressed concrete', 2),
(40, 11, 'Peer review and checking services', 3),
(41, 12, 'Terminal and concourse structures', 0),
(42, 12, 'Airfield pavement design', 1),
(43, 12, 'Hangar and maintenance facility structures', 2),
(44, 12, 'Blast and progressive collapse analysis', 3),
(45, 13, 'Structural condition assessment', 0),
(46, 13, 'Seismic retrofitting and strengthening', 1),
(47, 13, 'Change-of-use structural upgrades', 2),
(48, 13, 'Heritage building conservation', 3),
(49, 19, 'End-to-end project lifecycle management', 0),
(50, 19, 'Integrated cost and schedule control', 1),
(51, 19, 'Stakeholder and contractor coordination', 2),
(52, 19, 'Performance monitoring and reporting', 3),
(53, 20, 'Turnkey engineering and construction delivery', 0),
(54, 20, 'Integrated procurement management', 1),
(55, 20, 'Construction coordination and supervision', 2),
(56, 20, 'Quality assurance and compliance systems', 3),
(57, 21, 'Engineering review and technical oversight', 0),
(58, 21, 'Contractor and vendor management', 1),
(59, 21, 'Procurement supervision and coordination', 2),
(60, 21, 'Construction monitoring and reporting', 3),
(61, 22, 'Strategic sourcing and vendor evaluation', 0),
(62, 22, 'Tendering and contract negotiations', 1),
(63, 22, 'Supply chain coordination and tracking', 2),
(64, 22, 'Procurement cost optimisation', 3),
(65, 23, 'Transportation and freight coordination', 0),
(66, 23, 'Warehouse and inventory management', 1),
(67, 23, 'Customs and import/export support', 2),
(68, 23, 'Material tracking and reporting systems', 3),
(69, 24, 'Contract administration and compliance', 0),
(70, 24, 'Supplier performance evaluation', 1),
(71, 24, 'Commercial risk management', 2),
(72, 24, 'Claims and variation management', 3),
(73, 25, 'Civil and structural construction works', 0),
(74, 25, 'Mechanical and piping installation', 1),
(75, 25, 'Electrical and instrumentation works', 2),
(76, 25, 'Site supervision and quality control', 3),
(77, 26, 'Bulk earthworks and grading', 0),
(78, 26, 'Road and access infrastructure', 1),
(79, 26, 'Drainage and stormwater systems', 2),
(80, 26, 'Utility installation and coordination', 3),
(81, 27, 'Process equipment installation', 0),
(82, 27, 'Piping fabrication and erection', 1),
(83, 27, 'Structural steel assembly', 2),
(84, 27, 'Alignment and commissioning support', 3),
(85, 28, 'Mechanical and electrical system testing', 0),
(86, 28, 'Instrumentation loop checks and calibration', 1),
(87, 28, 'Factory and Site Acceptance Testing (FAT/SAT)', 2),
(88, 28, 'Performance verification and compliance testing', 3),
(89, 29, 'Pre-commissioning and commissioning activities', 0),
(90, 29, 'System integration and functional testing', 1),
(91, 29, 'Operational readiness assessments', 2),
(92, 29, 'Start-up support and troubleshooting', 3),
(93, 30, 'Operations and maintenance planning', 0),
(94, 30, 'Training and competency development', 1),
(95, 30, 'Asset documentation and turnover', 2),
(96, 30, 'Operational risk and readiness reviews', 3),
(97, 31, 'Execution-to-operation integration', 0),
(98, 31, 'Operational performance optimisation', 1),
(99, 31, 'Maintenance and reliability support', 2),
(100, 31, 'Continuous improvement strategies', 3);
INSERT INTO `service_features` (`id`, `service_item_id`, `feature_text`, `sort_order`) VALUES
(101, 32, 'Digital dashboards and reporting systems', 0),
(102, 32, 'BIM and digital twin integration', 1),
(103, 32, 'AI-assisted planning and forecasting', 2),
(104, 32, 'Real-time project monitoring', 3),
(105, 33, 'Inspection and Test Plans (ITPs)', 0),
(106, 33, 'Quality audits and compliance reviews', 1),
(107, 33, 'Material verification and traceability', 2),
(108, 33, 'Non-conformance management', 3),
(109, 34, 'Health and safety management systems', 0),
(110, 34, 'Environmental compliance monitoring', 1),
(111, 34, 'ESG reporting and implementation', 2),
(112, 34, 'Risk assessment and mitigation planning', 3),
(169, 49, 'tobe added', 0),
(175, 52, 'tobe added', 0),
(176, 53, 'Horizontal and vertical alignment design', 0),
(177, 53, 'Pavement structure and material selection', 1),
(178, 53, 'Road safety audits', 2),
(179, 53, 'Traffic impact assessments', 3),
(180, 54, 'Track alignment and gradient design', 0),
(181, 54, 'Earthwork volume optimisation', 1),
(182, 54, 'Level crossing design', 2),
(183, 54, 'Signalling and communications coordination', 3),
(184, 55, 'Beam, arch, cable-stayed, and suspension bridges', 0),
(185, 55, 'Load rating and bridge assessment', 1),
(186, 55, 'Hydraulic and scour analysis', 2),
(187, 55, 'Inspection and maintenance planning', 3),
(188, 56, 'Route survey and selection', 0),
(189, 56, 'Tower and pole structural design', 1),
(190, 56, 'Conductor sag-tension analysis', 2),
(191, 56, 'Protection and earthing systems', 3),
(192, 57, 'Single-line diagram development', 0),
(193, 57, 'Equipment specification and selection', 1),
(194, 57, 'Protection relay coordination', 2),
(195, 57, 'Civil and structural substation design', 3),
(196, 58, 'Network load flow and fault studies', 0),
(197, 58, 'Distribution automation design', 1),
(198, 58, 'Underground cable and overhead line design', 2),
(199, 58, 'Metering and billing infrastructure', 3),
(200, 59, 'Thermal load calculations', 0),
(201, 59, 'Air handling unit and duct design', 1),
(202, 59, 'Building Management System (BMS) integration', 2),
(203, 59, 'Energy performance modelling', 3),
(204, 60, 'Domestic water supply and distribution', 0),
(205, 60, 'Sanitary and waste drainage design', 1),
(206, 60, 'Greywater and rainwater harvesting', 2),
(207, 60, 'Fire hose reel and hydrant systems', 3),
(208, 61, 'Land-use zoning and density studies', 0),
(209, 61, 'Movement and connectivity networks', 1),
(210, 61, 'Public realm and open space design', 2),
(211, 61, 'Phasing and implementation strategies', 3),
(212, 62, 'Site analysis and concept design', 0),
(213, 62, 'Planting design and species selection', 1),
(214, 62, 'Hardscape and softscape detailing', 2),
(215, 62, 'Environmental revegetation programmes', 3),
(216, 63, 'Master programme development (Primavera / MS Project)', 0),
(217, 63, 'Critical path and float analysis', 1),
(218, 63, 'Look-ahead and short-interval schedules', 2),
(219, 63, 'Delay analysis and recovery planning', 3),
(220, 64, 'Quality Management Plan (QMP) development', 0),
(221, 64, 'Inspection and Test Plans (ITPs)', 1),
(222, 64, 'Non-conformance reporting and close-out', 2),
(223, 64, 'Third-party quality audits', 3),
(224, 65, 'Class 1–5 cost estimates (AACE)', 0),
(225, 65, 'Bill of Quantities (BOQ) preparation', 1),
(226, 65, 'Market benchmarking and escalation forecasting', 2),
(227, 65, 'Value engineering support', 3);

-- --------------------------------------------------------
-- Table: service_groups

DROP TABLE IF EXISTS `service_groups`;
CREATE TABLE `service_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `service_key` varchar(150) NOT NULL,
  `title` varchar(255) NOT NULL,
  `hero_text` longtext DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `hero_asset_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_service_group_key` (`service_key`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `service_groups` (`id`, `service_key`, `title`, `hero_text`, `sort_order`, `is_active`, `hero_asset_id`) VALUES
(1, 'engineeringanddesign', 'Engineering and Design', 'Delivering integrated engineering and design solutions across every discipline.', 0, 1, 435),
(2, 'implementation', 'Project Delivery', 'Delivering integrated project delivery solutions from execution and construction through commissioning, operations, and long-term asset performance.', 1, 1, 436),
(3, 'mining', 'Mining', 'Delivering comprehensive mining solutions from exploration to sustainable extraction.', 2, 1, 437);

-- --------------------------------------------------------
-- Table: service_items

DROP TABLE IF EXISTS `service_items`;
CREATE TABLE `service_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `service_key` varchar(150) DEFAULT NULL,
  `title` varchar(500) NOT NULL,
  `short_description` longtext DEFAULT NULL,
  `why_description` longtext DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `service_asset_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_service_items_category` (`category_id`),
  KEY `idx_service_items_parent` (`parent_id`),
  CONSTRAINT `fk_service_items_category` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_service_items_parent` FOREIGN KEY (`parent_id`) REFERENCES `service_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `service_items` (`id`, `category_id`, `parent_id`, `service_key`, `title`, `short_description`, `why_description`, `sort_order`, `is_active`, `service_asset_id`) VALUES
(1, 1, NULL, NULL, 'Feasibility Studies', 'We provide comprehensive feasibility studies that include initial concept development, technical and financial evaluations, and early-stage planning to assess project viability, identify constraints, and outline practical solutions before moving into detailed design and execution phases.', 'Our studies minimise risks by identifying constraints, validating assumptions, and ensuring informed, cost-effective project decisions from the outset.', 0, 1, 423),
(2, 1, NULL, NULL, 'GIS Mapping and Analysis', 'Our GIS mapping and analysis services involve collecting, processing, and interpreting spatial data using advanced geospatial technologies to support accurate planning, decision-making, and visualization for infrastructure, environmental studies, and land management projects across diverse and complex terrains.', 'We deliver precise geospatial insights that improve planning accuracy, optimise resource allocation, and support efficient, data-driven project decisions.', 1, 1, 425),
(3, 1, NULL, NULL, 'Environmental and Social Assessments', 'We conduct detailed environmental and social assessments to evaluate potential project impacts, ensure regulatory compliance, and promote sustainable development by integrating environmental protection measures and community considerations into planning and execution processes.', 'We ensure regulatory compliance while reducing environmental impact and enhancing positive social outcomes for sustainable project success.', 2, 1, 421),
(4, 2, NULL, NULL, 'Conceptual Engineering Studies', 'We develop early-stage engineering concepts that translate project objectives into technically sound, feasible, and cost-effective solutions, enabling informed decision-making while aligning design approaches with project goals, site conditions, and stakeholder expectations before advancing into detailed design phases.', 'Strong concepts reduce redesign risks, align stakeholders early, and provide a clear, efficient direction for all subsequent design stages.', 0, 1, 414),
(5, 2, NULL, NULL, 'Architectural Design', 'Our architectural design services deliver innovative and functional solutions across residential, commercial, and infrastructure projects, integrating aesthetics, spatial planning, and technical requirements to create environments that are visually appealing, efficient, and aligned with user needs and regulatory standards.', 'We create designs that balance creativity, functionality, and practicality, ensuring visually compelling spaces that perform efficiently and meet project goals.', 1, 1, 412),
(6, 2, NULL, NULL, 'Civil Design', 'We provide detailed civil engineering design for roads, drainage systems, grading, and site infrastructure, ensuring efficient land use, proper water management, and long-term durability while meeting regulatory requirements and supporting smooth construction processes across a wide range of infrastructure projects.', 'Accurate civil design ensures efficient construction, regulatory compliance, and long-term performance of infrastructure under varying site conditions.', 2, 1, 413),
(7, 2, NULL, NULL, 'Structural Design', 'We deliver safe and efficient structural design solutions for buildings, bridges, and industrial facilities, combining advanced analysis with practical construction considerations to ensure stability, durability, and optimal material use while meeting safety standards and project-specific performance requirements.', 'Our structural solutions enhance safety, optimise material use, and ensure reliable performance under environmental and operational loads.', 3, 1, 439),
(8, 2, NULL, NULL, 'Electrical Design', 'We design comprehensive electrical systems covering power distribution, lighting, instrumentation, and control, ensuring reliable and efficient operation while supporting safety, scalability, and future expansion needs for various building and infrastructure projects across different sectors.', 'Our designs ensure safe, reliable power systems that support operational efficiency, adaptability, and long-term infrastructure performance.', 4, 1, 420),
(9, 2, NULL, NULL, 'Mechanical Design', 'Our mechanical design services cover HVAC, plumbing, fire protection, and process systems, delivering integrated solutions that enhance energy efficiency, occupant comfort, and system reliability while aligning with project specifications and operational requirements across diverse facility types.', 'Integrated mechanical systems improve efficiency, reduce energy costs, and ensure comfortable, safe, and reliable building operations.', 5, 1, 426),
(10, 3, NULL, NULL, 'Building & Structural Design', NULL, NULL, 0, 1, NULL),
(11, 3, 10, NULL, 'Building Design', 'We deliver full-cycle structural design for residential, commercial, and mixed-use buildings, covering concept development through detailed engineering to tender documentation, ensuring safety, efficiency, and adaptability while aligning with project requirements, site conditions, and long-term performance expectations.', 'Our designs ensure safety, cost efficiency, and adaptability, creating structures that meet current needs while accommodating future expansion.', 0, 1, 331),
(12, 3, 10, NULL, 'Airport Design', 'We provide specialised structural engineering for airport facilities including terminals, hangars, control towers, and airside pavements, ensuring compliance with aviation standards while delivering durable, efficient, and high-performance infrastructure capable of handling demanding operational and environmental conditions.', 'We deliver durable, compliant airport structures that meet strict aviation standards and support safe, efficient operations.', 1, 1, NULL),
(13, 3, 10, NULL, 'Building Retrofit', 'We assess and upgrade existing structures to meet current codes, improve performance, and extend service life, incorporating modern engineering solutions to enhance safety, functionality, and sustainability while preserving structural integrity and accommodating new usage or regulatory requirements.', 'Retrofitting enhances safety, extends asset life, and offers a sustainable, cost-effective alternative to complete reconstruction.', 2, 1, NULL),
(14, 3, NULL, NULL, 'Road, Rail & Bridge Design', NULL, NULL, 1, 1, NULL),
(15, 3, NULL, NULL, 'Power Transmission & Distribution', NULL, NULL, 2, 1, NULL),
(16, 3, NULL, NULL, 'HVAC & Plumbing Design', NULL, NULL, 3, 1, NULL),
(17, 3, NULL, NULL, 'Master Planning & Landscape Architecture', NULL, NULL, 4, 1, NULL),
(18, 3, NULL, NULL, 'Project Planning, Quality & Cost Management', NULL, NULL, 5, 1, NULL),
(19, 4, NULL, NULL, 'Project Management and Execution', 'We provide comprehensive project management and execution services across the full project lifecycle, ensuring effective coordination of scope, schedule, cost, quality, and resources while maintaining alignment with client objectives, operational requirements, and industry standards for successful project delivery.', 'Our structured management systems improve coordination, reduce delays, and ensure projects are delivered safely, efficiently, and within budget.', 0, 1, NULL),
(20, 4, NULL, NULL, 'EPC Project Delivery', 'We deliver Engineering, Procurement, and Construction (EPC) solutions under a single-point responsibility model, integrating engineering design, procurement management, construction execution, and commissioning to streamline project delivery while ensuring quality, accountability, and efficient coordination across all project phases.', 'Single-source EPC delivery simplifies execution, reduces interface risks, and ensures consistent quality and accountability throughout the project lifecycle.', 1, 1, NULL),
(21, 4, NULL, NULL, 'EPCM & Owner\'s Engineer Services', 'We provide EPCM and Owner\'s Engineer services that represent client interests throughout project execution, overseeing engineering, procurement, construction, and contractor performance to ensure projects meet technical, financial, operational, and regulatory requirements while maintaining transparency and effective risk management.', 'Independent oversight enhances transparency, improves contractor performance, and ensures alignment with client expectations and project objectives.', 2, 1, NULL),
(22, 5, NULL, NULL, 'Procurement and Supply Chain Management', 'We manage procurement and supply chain operations for complex industrial and infrastructure projects, ensuring timely sourcing of quality materials, equipment, and services while optimising costs, managing logistics, and maintaining supply continuity throughout project execution phases.', 'Efficient procurement and logistics reduce delays, improve cost control, and ensure reliable access to critical project resources.', 0, 1, NULL),
(23, 5, NULL, NULL, 'Logistics and Material Management', 'We coordinate transportation, warehousing, customs clearance, and material handling processes to ensure efficient delivery and management of project equipment and materials, minimising disruptions while supporting smooth site operations and construction activities.', 'Well-managed logistics improve delivery reliability, reduce downtime, and support uninterrupted project execution across remote and challenging locations.', 1, 1, NULL),
(24, 5, NULL, NULL, 'Vendor and Contract Management', 'We administer supplier and contractor agreements throughout procurement and execution stages, ensuring compliance with contractual obligations, performance standards, schedules, and quality requirements while supporting transparent communication and dispute resolution processes.', 'Strong contract management improves accountability, minimises commercial risks, and strengthens supplier and contractor performance.', 2, 1, NULL),
(25, 6, NULL, NULL, 'Construction and Site Development', 'We execute civil, structural, mechanical, and infrastructure construction works for industrial, mining, and commercial projects, ensuring safe, efficient, and high-quality delivery through disciplined site management, skilled supervision, and compliance with engineering and regulatory standards.', 'Our construction expertise ensures quality execution, improved safety performance, and reliable project delivery under demanding site conditions.', 0, 1, NULL),
(26, 6, NULL, NULL, 'Earthworks and Infrastructure Development', 'We perform bulk earthworks, grading, roadworks, drainage installation, and supporting infrastructure development to prepare and optimise project sites for construction and operations while ensuring stability, accessibility, and long-term operational performance.', 'Proper site preparation improves construction efficiency, reduces operational risks, and supports durable infrastructure performance.', 1, 1, NULL),
(27, 6, NULL, NULL, 'Mechanical and Plant Installation', 'We install industrial process equipment, mechanical systems, piping networks, and supporting plant infrastructure, ensuring accurate alignment, reliable operation, and integration with electrical, control, and structural systems across industrial and mining facilities.', 'Precise installation improves operational reliability, minimises commissioning issues, and supports long-term plant efficiency.', 2, 1, NULL),
(28, 7, NULL, NULL, 'Testing and Validation', 'We perform comprehensive testing and validation of mechanical, electrical, instrumentation, and control systems to verify functionality, safety, compliance, and operational performance before commissioning and final project handover across industrial, infrastructure, and energy facilities.', 'Thorough testing identifies issues early, improves system reliability, and ensures equipment and installations meet operational and regulatory requirements.', 0, 1, NULL),
(29, 7, NULL, NULL, 'Commissioning and Start-Up', 'We manage commissioning and start-up activities to ensure systems, equipment, and operational processes are safely integrated, tested, and transitioned into full operational service while achieving performance targets, operational reliability, and compliance with project specifications.', 'Structured commissioning minimises start-up risks, accelerates operational readiness, and ensures stable, efficient facility performance.', 1, 1, NULL),
(30, 7, NULL, NULL, 'Operational Readiness and Handover', 'We prepare operational teams and facilities for seamless transition into production by developing procedures, maintenance systems, training programmes, and asset documentation that support safe, efficient, and sustainable long-term operations.', 'Effective readiness planning ensures smooth handover, improves operational safety, and enhances long-term asset reliability and performance.', 2, 1, NULL),
(31, 7, NULL, NULL, 'Integrated EPC+O Solutions', 'We deliver integrated EPC+O solutions that extend responsibility beyond project execution into operations, maintenance, and performance optimisation, ensuring continuity, improved operational efficiency, and long-term asset value throughout the facility lifecycle.', 'Integrated execution and operations support improve continuity, reduce operational risks, and maximise long-term project and asset performance.', 3, 1, NULL),
(32, 8, NULL, NULL, 'Digital Project Management and Smart Delivery', 'We implement advanced digital technologies, real-time monitoring systems, BIM platforms, and data-driven management tools to improve project visibility, collaboration, forecasting, and decision-making throughout engineering, procurement, construction, and operational phases.', 'Digital solutions improve efficiency, enhance coordination, and enable proactive management of project risks and performance.', 0, 1, NULL),
(33, 8, NULL, NULL, 'Quality Assurance and Control', 'We implement quality assurance and quality control systems across all project phases to ensure materials, workmanship, processes, and deliverables comply with technical specifications, regulatory requirements, and international quality standards.', 'Strong quality systems reduce defects, minimise rework, and ensure consistent delivery of reliable project outcomes.', 1, 1, NULL),
(34, 8, NULL, NULL, 'Health, Safety and ESG Compliance', 'We develop and implement integrated health, safety, environmental, and ESG management systems that promote safe working environments, regulatory compliance, environmental protection, and responsible project delivery across all operational and construction activities.', 'Effective HSE and ESG systems protect personnel, reduce operational risks, and support sustainable, responsible project execution.', 2, 1, NULL),
(49, 13, NULL, NULL, 'Consulting and Advisory Services', 'Arya mineral render consultancy services to the mining and mega infrastructural projects. The scope of our services includes prospection and exploration of mineral resources; provide trainings in mining optimization techniques, environmental and social assessments of mining and infrastructural projects. With our team of professional and experienced geologists and our management, we provide the contemporary exploration, mining facilities to our clients in consideration to their requirements.', 'tobe added', 0, 1, 415),
(52, 13, 49, NULL, 'aaa', NULL, NULL, 4, 1, NULL),
(53, 3, 14, NULL, 'Road Design', 'We design highways, urban roads, and rural routes, covering geometric alignment, pavement structures, and drainage systems to ensure safety, durability, and efficient traffic flow while optimising lifecycle costs and meeting regulatory standards across diverse transportation environments.', 'Our road designs enhance safety, improve ride quality, and optimise lifecycle costs for efficient and reliable transportation networks.', 0, 1, NULL),
(54, 3, 14, NULL, 'Railway Design', 'We provide integrated railway design services, including track geometry, earthworks, and system coordination, ensuring safe, efficient, and reliable operations for both freight and passenger networks while aligning with technical standards and project-specific requirements.', 'Our multidisciplinary approach ensures precise, efficient railway systems that meet safety standards and operational performance requirements.', 1, 1, NULL),
(55, 3, 14, NULL, 'Bridge Design', 'We deliver bridge design solutions from concept to detailed engineering, covering various structural types and materials while ensuring durability, safety, and aesthetic value, supported by advanced analysis and consideration of environmental and loading conditions.', 'We design durable, efficient bridges that combine structural integrity with aesthetic appeal and long-term performance.', 2, 1, NULL),
(56, 3, 15, NULL, 'Transmission Line Engineering', 'We design high-voltage overhead and underground transmission systems, including route selection, structural design, and conductor analysis, ensuring reliable, efficient, and safe power delivery across long distances while meeting regulatory and environmental requirements.', 'We ensure reliable, efficient transmission systems through optimised design, improving performance and supporting stable power infrastructure.', 0, 1, 441),
(57, 3, 15, NULL, 'Electrical Substation Engineering', 'We provide comprehensive engineering for substations across all voltage levels, covering primary and secondary systems, equipment specification, and integration to ensure safe, reliable, and efficient power transformation and distribution.', 'Our substation designs ensure reliability, safety, and compliance, supporting efficient power distribution and long-term infrastructure stability.', 1, 1, 440),
(58, 3, 15, NULL, 'Power Distribution Engineering', 'We design medium and low-voltage distribution networks for urban and rural areas, ensuring efficient energy delivery, reduced losses, and reliable supply while supporting future expansion and increasing demand across diverse infrastructure environments.', 'Our experienced electrical engineering team delivers reliable, efficient, and scalable distribution designs, considering load requirements, voltage levels, network capacity, system losses, and future demand to ensure safe and dependable power supply.', 2, 1, 417),
(59, 3, 16, NULL, 'HVAC Design', 'We design heating, ventilation, and air-conditioning systems for residential, commercial, and industrial applications, ensuring energy efficiency, indoor air quality, and occupant comfort while integrating advanced technologies and control systems for optimal performance.', 'Our experienced HVAC team delivers energy-efficient and reliable system designs, considering cooling and heating loads, indoor air quality, ventilation requirements, equipment selection, and applicable standards to ensure comfortable and efficient building operation.', 0, 1, NULL),
(60, 3, 16, NULL, 'Plumbing Design', 'We design water supply, drainage, and specialised plumbing systems for various building types, ensuring efficient water management, hygiene, and compliance with regulations while supporting sustainability through modern design approaches and technologies.', 'Our experienced plumbing engineering team delivers efficient, reliable, and code-compliant designs, considering water demand, drainage requirements, system capacity, water efficiency, and long-term performance to ensure safe and sustainable building operations.', 1, 1, NULL),
(61, 3, 17, NULL, 'Master Plan and Urban Design', 'We develop strategic master plans and urban design frameworks that guide sustainable development, integrating land use, infrastructure, mobility, and public spaces to create functional, connected, and resilient communities aligned with long-term growth objectives.', 'Our experienced planning and urban design team develops integrated, sustainable, and practical master plans, considering land use, mobility, infrastructure, public spaces, development potential, and long-term growth to create connected and resilient communities.', 0, 1, 443),
(62, 3, 17, NULL, 'Landscape Architecture', 'We design outdoor environments that integrate natural systems with human activity, enhancing aesthetics, ecological value, and user experience while supporting sustainability, biodiversity, and long-term environmental performance.', 'Our experienced landscape architecture team creates functional, sustainable, and visually integrated outdoor spaces, considering site conditions, ecology, biodiversity, user needs, and long-term environmental performance.', 1, 1, NULL),
(63, 3, 18, NULL, 'Project Planning and Scheduling', 'We develop detailed project plans, schedules, and resource strategies using industry-standard tools to ensure efficient execution, timely delivery, and effective coordination across all project phases while managing risks and adapting to changing conditions.', 'Our experienced project management team develops structured, realistic, and resource-efficient schedules, considering project scope, resources, dependencies, critical activities, risks, and deadlines to support timely and effective project delivery.', 0, 1, NULL),
(64, 3, 18, NULL, 'Quality Management', 'We implement quality management systems to ensure that materials, processes, and workmanship meet required standards, reducing defects and ensuring consistent performance while supporting compliance and long-term asset reliability.', 'Our experienced quality team ensures consistent, standards-compliant project delivery, using quality control procedures, inspections, testing, documentation, and performance monitoring to minimize defects, reduce rework, and ensure long-term asset reliability.', 1, 1, NULL),
(65, 3, 18, NULL, 'Cost Estimation', 'We provide accurate cost estimation and quantity take-offs throughout all project stages, enabling effective budgeting, financial planning, and control while supporting informed decision-making and minimising cost overruns.', 'Our experienced team delivers accurate and reliable cost estimates, using quantity take-offs, unit-rate analysis, market pricing, and cost benchmarking to support effective budgeting, financial planning, and cost control.', 2, 1, NULL);

-- --------------------------------------------------------
-- Table: site_navigation

DROP TABLE IF EXISTS `site_navigation`;
CREATE TABLE `site_navigation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `location` enum('header','footer') NOT NULL DEFAULT 'header',
  `label` varchar(150) NOT NULL,
  `url` varchar(500) NOT NULL DEFAULT '#',
  `target` enum('_self','_blank') NOT NULL DEFAULT '_self',
  `icon_class` varchar(150) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(10) unsigned DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_site_navigation_location_sort` (`location`,`sort_order`,`id`),
  KEY `idx_site_navigation_parent` (`parent_id`),
  KEY `idx_site_navigation_active` (`location`,`is_active`),
  KEY `fk_site_navigation_created_by` (`created_by`),
  KEY `fk_site_navigation_updated_by` (`updated_by`),
  CONSTRAINT `fk_site_navigation_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_site_navigation_parent` FOREIGN KEY (`parent_id`) REFERENCES `site_navigation` (`id`),
  CONSTRAINT `fk_site_navigation_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `site_navigation` (`id`, `parent_id`, `location`, `label`, `url`, `target`, `icon_class`, `sort_order`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, NULL, 'header', 'Opportunities', 'opportunities.php', '_self', NULL, 10, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(2, NULL, 'header', 'Contact Us', 'contact.php', '_self', NULL, 20, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(3, NULL, 'header', 'Home', 'index.php', '_self', NULL, 100, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(4, NULL, 'header', 'About', 'about.php', '_self', NULL, 110, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(5, NULL, 'header', 'Services', 'services.php', '_self', NULL, 120, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(6, NULL, 'header', 'Expertise', 'sectors.php', '_self', NULL, 130, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(7, NULL, 'header', 'Projects', 'projects.php', '_self', NULL, 140, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(8, NULL, 'header', 'Media', 'media.php', '_self', NULL, 150, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(9, 4, 'header', 'Overview', 'about.php#general-info', '_self', NULL, 100, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(10, 4, 'header', 'Mission & Vision', 'about.php#mission-vision', '_self', NULL, 101, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(11, 4, 'header', 'Clients', 'about.php#clients', '_self', NULL, 102, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(12, 4, 'header', 'ISO Certifications', 'about.php#certificates', '_self', NULL, 103, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(13, 4, 'header', 'Awards & Recognitions', 'about.php#awards', '_self', NULL, 104, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(14, 4, 'header', 'Affiliated Companies', 'about.php#sister', '_self', NULL, 105, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(15, 4, 'header', 'Health, Safety & Environment (HSE)', 'about.php#hse', '_self', NULL, 106, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(16, 4, 'header', 'Company Profile', 'about.php#cprofile', '_self', NULL, 107, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(24, 5, 'header', 'Engineering and Design', 'services.php?tab=engineeringanddesign', '_self', NULL, 100, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(25, 5, 'header', 'Project Delivery', 'services.php?tab=implementation', '_self', NULL, 101, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(26, 5, 'header', 'Mining', 'services.php?tab=mining', '_self', NULL, 102, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(27, 24, 'header', 'Engineering Surveys', 'services.php?tab=engineeringanddesign#engineeringanddesign-engineering-surveys', '_self', NULL, 100, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(28, 24, 'header', 'Design Services', 'services.php?tab=engineeringanddesign#engineeringanddesign-design-services', '_self', NULL, 101, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(29, 24, 'header', 'Engineering Services', 'services.php?tab=engineeringanddesign#engineeringanddesign-engineering-services', '_self', NULL, 102, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(30, 25, 'header', 'Project Management', 'services.php?tab=implementation#implementation-project-management', '_self', NULL, 100, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(31, 25, 'header', 'Procurement & Supply Chain', 'services.php?tab=implementation#implementation-procurement-logistics', '_self', NULL, 101, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(32, 25, 'header', 'Construction & Site Development', 'services.php?tab=implementation#implementation-construction-site-development', '_self', NULL, 102, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(33, 25, 'header', 'Testing & Commissioning', 'services.php?tab=implementation#implementation-testing-commissioning', '_self', NULL, 103, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(34, 25, 'header', 'Digital Delivery, Quality & HSE', 'services.php?tab=implementation#implementation-digital-quality-hse', '_self', NULL, 104, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(35, 26, 'header', 'Consulting', 'services.php?tab=mining#mining-consulting', '_self', NULL, 104, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(42, 6, 'header', 'Power & Energy', 'sectors.php?tab=powerenergy', '_self', NULL, 100, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(43, 6, 'header', 'Transportation', 'sectors.php?tab=transport', '_self', NULL, 101, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(44, 6, 'header', 'Building', 'sectors.php?tab=Infrastructure', '_self', NULL, 102, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(45, 6, 'header', 'Water Resources', 'sectors.php?tab=water', '_self', NULL, 103, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(46, 6, 'header', 'Mining', 'sectors.php?tab=mining', '_self', NULL, 104, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(50, 7, 'header', 'Building', 'projects.php?sector=Building', '_self', NULL, 110, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(51, 7, 'header', 'mining', 'projects.php?sector=mining', '_self', NULL, 110, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(52, 7, 'header', 'Power and Energy', 'projects.php?sector=Power%20and%20Energy', '_self', NULL, 110, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(53, 7, 'header', 'Transportation', 'projects.php?sector=Transportation', '_self', NULL, 110, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(54, 7, 'header', 'water Resources', 'projects.php?sector=water%20Resources', '_self', NULL, 110, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(65, 8, 'header', 'News', 'media.php?tab=news', '_self', NULL, 100, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(66, 8, 'header', 'Events', 'media.php?tab=events', '_self', NULL, 110, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(67, 8, 'header', 'Gallery', 'media.php?tab=gallery', '_self', NULL, 120, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(68, NULL, 'footer', 'Engineering Services', 'services.php?tab=engineeringanddesign#engineeringanddesign-engineering-services', '_self', NULL, 10, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(69, NULL, 'footer', 'Design Services', 'services.php?tab=engineeringanddesign#engineeringanddesign-design-services', '_self', NULL, 20, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(70, NULL, 'footer', 'Mining Services', 'services.php?tab=mining', '_self', NULL, 30, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(71, NULL, 'footer', 'Project Management', 'services.php?tab=implementation#implementation-project-management', '_self', NULL, 40, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(72, NULL, 'footer', 'EPC Solutions', 'services.php?tab=implementation', '_self', NULL, 50, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(73, NULL, 'footer', 'Company Overview', 'about.php#general-info', '_self', NULL, 110, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(74, NULL, 'footer', 'Mission & Vision', 'about.php#mission-vision', '_self', NULL, 120, 1, NULL, NULL, '2026-09-16 14:26:16', '2026-09-16 14:26:16'),
(75, NULL, 'footer', 'Projects', 'projects.php', '_self', NULL, 130, 1, NULL, NULL, '2026-09-16 14:26:17', '2026-09-16 14:26:17'),
(76, NULL, 'footer', 'Company Profile', 'about.php#cprofile', '_self', NULL, 140, 1, NULL, NULL, '2026-09-16 14:26:17', '2026-09-16 14:26:17'),
(77, NULL, 'footer', 'Contact Us', 'contact.php', '_self', NULL, 150, 1, NULL, NULL, '2026-09-16 14:26:17', '2026-09-16 14:26:17'),
(78, NULL, 'footer', 'Policies', 'policies.php', '_self', NULL, 210, 1, NULL, NULL, '2026-09-16 14:26:17', '2026-09-16 14:26:17'),
(79, NULL, 'footer', 'Terms of Service', 'termsOfServices.php', '_self', NULL, 220, 1, NULL, NULL, '2026-09-16 14:26:17', '2026-09-16 14:26:17');

-- --------------------------------------------------------
-- Table: site_settings

DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE `site_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(150) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_type` enum('text','textarea','url','email','phone','image','document','boolean','number') NOT NULL DEFAULT 'text',
  `description` varchar(255) DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_setting_key` (`setting_key`),
  KEY `fk_settings_user` (`updated_by`),
  CONSTRAINT `fk_settings_user` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `site_settings` (`id`, `setting_key`, `setting_value`, `setting_type`, `description`, `updated_by`, `updated_at`) VALUES
(1, 'homepage_why_background', '297', 'image', 'Homepage Why State Corps background image', NULL, '2026-09-21 10:34:08'),
(2, 'projects_hero_background', '450', 'image', 'Projects page hero background image', NULL, '2026-09-21 10:34:08'),
(3, 'projects_hero_title', 'Turning Ambition Into <span>Lasting</span> Impact', 'text', 'Projects page hero title; existing frontend intentionally renders this as HTML', NULL, '2026-09-08 10:21:07'),
(4, 'projects_hero_subtitle', 'Delivering infrastructure, power & energy, mining, and development projects across regions.', 'textarea', 'Projects page hero subtitle', NULL, '2026-09-08 10:21:07'),
(5, 'projects_hero_stat_1_count', '100+', 'text', 'Projects hero statistic 1 value', NULL, '2026-09-08 10:21:07'),
(6, 'projects_hero_stat_1_label', 'Completed Projects', 'text', 'Projects hero statistic 1 label', NULL, '2026-09-08 10:21:07'),
(7, 'projects_hero_stat_2_count', '100%', 'text', 'Projects hero statistic 2 value', NULL, '2026-09-08 10:21:07'),
(8, 'projects_hero_stat_2_label', 'On Time Delivery', 'text', 'Projects hero statistic 2 label', NULL, '2026-09-08 10:21:07'),
(9, 'projects_hero_stat_3_count', '99% +', 'text', 'Projects hero statistic 3 value', NULL, '2026-09-08 10:21:07'),
(10, 'projects_hero_stat_3_label', 'Accuracy', 'text', 'Projects hero statistic 3 label', NULL, '2026-09-08 10:21:07'),
(11, 'home_stats_background', '297', 'image', 'Homepage statistics background image', NULL, '2026-09-21 10:34:08'),
(12, 'site_name', 'State Corps', 'text', 'Global website/company name', NULL, '2026-09-12 21:18:45'),
(13, 'site_logo', '307', 'image', 'Global website header logo path', NULL, '2026-09-21 10:34:08'),
(14, 'footer_logo', '281', 'image', 'Global footer logo path', NULL, '2026-09-21 10:34:08'),
(15, 'company_profile_file', '473', 'document', 'Company profile download path', NULL, '2026-09-21 10:34:08'),
(16, 'footer_copyright', 'State Corps', 'text', 'Global footer copyright owner text', NULL, '2026-09-12 21:18:45'),
(17, 'social_facebook_url', 'https://www.facebook.com/StateCorpsInc/', 'url', 'Facebook profile URL', NULL, '2026-09-16 14:32:42'),
(18, 'social_x_url', 'https://x.com/StateCorps', 'url', 'X profile URL', NULL, '2026-09-16 14:32:42'),
(19, 'social_linkedin_url', 'https://www.linkedin.com/company/state-corps/', 'url', 'LinkedIn profile URL', NULL, '2026-09-16 14:32:42'),
(20, 'header_top_background_color', '#ffffff', 'text', 'Upper header background color', NULL, '2026-09-16 14:33:04'),
(21, 'header_top_text_color', '#0c1c3d', 'text', 'Upper header text and icon color', 1, '2026-09-16 15:40:05'),
(22, 'header_bottom_background_color', '#0c1c3d', 'text', 'Primary navigation background color', NULL, '2026-09-16 14:33:04'),
(23, 'header_bottom_text_color', '#ffffff', 'text', 'Primary navigation text color', NULL, '2026-09-16 14:33:04'),
(24, 'header_hover_color', '#0d1e3f', 'text', 'Header link hover and active color', 1, '2026-09-16 17:01:31'),
(25, 'footer_statement', 'Building Infrastructure.\nEmpowering Communities.\nDriving Sustainable Growth.', 'textarea', 'Footer company statement', NULL, '2026-09-16 16:25:37'),
(26, 'footer_services_label', 'Services', 'text', 'Footer services heading', NULL, '2026-09-16 16:25:37'),
(27, 'footer_company_label', 'Company', 'text', 'Footer company heading', NULL, '2026-09-16 16:25:37'),
(28, 'footer_contact_label', 'Contact', 'text', 'Footer contact heading', NULL, '2026-09-16 16:25:37');

-- --------------------------------------------------------
-- Table: url_redirects

DROP TABLE IF EXISTS `url_redirects`;
CREATE TABLE `url_redirects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `source_path` varchar(500) NOT NULL,
  `destination_url` varchar(1000) NOT NULL,
  `status_code` smallint(5) unsigned NOT NULL DEFAULT 301,
  `preserve_query` tinyint(1) NOT NULL DEFAULT 0,
  `note` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(10) unsigned DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_url_redirect_source` (`source_path`),
  KEY `idx_url_redirect_active_sort` (`is_active`,`sort_order`,`id`),
  KEY `fk_url_redirect_created_by` (`created_by`),
  KEY `fk_url_redirect_updated_by` (`updated_by`),
  CONSTRAINT `fk_url_redirect_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_url_redirect_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------
-- Table: users

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `display_name` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','editor') NOT NULL DEFAULT 'editor',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `last_login_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_users_username` (`username`),
  KEY `idx_users_role` (`role`),
  KEY `idx_users_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `username`, `display_name`, `password_hash`, `role`, `status`, `last_login_at`, `created_at`, `updated_at`) VALUES
(1, 'afs@sc.w', 'SC Web Admin', '$2y$10$ZuxAzm0oSb.LvP2XJ3E2V.zAyAtL.JAXA.CmOw1Y/MUrV9bUqPQ8a', 'admin', 'active', '2026-09-21 10:34:54', '2026-09-06 20:35:45', '2026-09-21 10:34:54'),
(2, 'demo1', 'Demo1', '$2y$10$eIqGT37rzyCmeogrbFUrguZGBYmLr/bEmyxzRLYDE03dnhhSR2Kte', 'editor', 'active', '2026-09-12 16:42:13', '2026-09-07 09:46:04', '2026-09-12 16:42:13');

-- --------------------------------------------------------
-- Table: user_permissions

DROP TABLE IF EXISTS `user_permissions`;
CREATE TABLE `user_permissions` (
  `user_id` int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`),
  KEY `fk_user_permissions_permission` (`permission_id`),
  CONSTRAINT `fk_user_permissions_permission` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_user_permissions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user_permissions` (`user_id`, `permission_id`) VALUES
(2, 1),
(2, 3),
(2, 4),
(2, 6);

SET FOREIGN_KEY_CHECKS=1;
-- End of backup
