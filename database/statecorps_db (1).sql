-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2026 at 12:45 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `statecorps_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_affiliated_companies`
--

CREATE TABLE `about_affiliated_companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo_path` varchar(500) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_affiliated_companies`
--

INSERT INTO `about_affiliated_companies` (`id`, `name`, `logo_path`, `sort_order`, `is_active`) VALUES
(1, 'State Corps United States', 'assets/images/scompany/sc_us.png', 0, 1),
(2, 'State Corps Turkiye', 'assets/images/scompany/sc_turkey.png', 1, 1),
(3, 'State Corps Uzbikistan', 'assets/images/scompany/sc_us.png', 2, 1),
(4, 'Arya Mineral', 'assets/images/scompany/scom_aryamineral.png', 3, 1),
(5, 'Petropool', 'assets/images/scompany/scom_petropool.png', 4, 1),
(6, 'Aeroparcel', 'assets/images/scompany/scom_aeroparcel.png', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `about_awards`
--

CREATE TABLE `about_awards` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo_path` varchar(500) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_awards`
--

INSERT INTO `about_awards` (`id`, `name`, `logo_path`, `sort_order`, `is_active`) VALUES
(1, 'Engineering Excellence Recognition', 'assets/images/awards/1_Cert.jpg', 0, 1),
(2, 'Infrastructure Project Achievement', 'assets/images/awards/2_Cert.jpg', 1, 1),
(3, 'Operational Safety Recognition', 'assets/images/awards/3_Cert.jpg', 2, 1),
(4, 'VAT Registration Certificate', 'assets/images/awards/VAT-certificate.png', 3, 1),
(5, 'BECO Expo Certificate', 'assets/images/awards/beco-expo-cert.png', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `about_certificates`
--

CREATE TABLE `about_certificates` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo_path` varchar(500) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_certificates`
--

INSERT INTO `about_certificates` (`id`, `name`, `logo_path`, `sort_order`, `is_active`) VALUES
(1, 'Quality Management System (ISO 9001)', 'assets/images/ISO_Certificates/ISO1.jpg', 0, 1),
(2, 'Environmental Management System (ISO 14001)', 'assets/images/ISO_Certificates/ISO2.jpg', 1, 1),
(3, 'Health & Safety Management System (ISO 45001)', 'assets/images/ISO_Certificates/ISO3.jpg', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `about_clients`
--

CREATE TABLE `about_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `logo_path` varchar(500) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_clients`
--

INSERT INTO `about_clients` (`id`, `name`, `logo_path`, `sort_order`, `is_active`) VALUES
(1, NULL, 'assets/images/clients/client_dabs_resized.png', 0, 1),
(2, NULL, 'assets/images/clients/client_mew_resized.png', 1, 1),
(3, NULL, 'assets/images/clients/client_metq_resized.png', 2, 1),
(4, NULL, 'assets/images/clients/client_ABC_resized.png', 3, 1),
(5, NULL, 'assets/images/clients/client_ghazanfar_group.jpg', 4, 1),
(6, NULL, 'assets/images/clients/client_kabul_municipality.png', 5, 1),
(7, NULL, 'assets/images/clients/client_usace_resized.png', 6, 1),
(8, NULL, 'assets/images/clients/client_worldbank_resized.png', 7, 1),
(9, NULL, 'assets/images/clients/client_unama.png', 8, 1),
(10, NULL, 'assets/images/clients/client_unhcr.png', 9, 1),
(11, NULL, 'assets/images/clients/client_ADB_resized.png', 10, 1),
(12, NULL, 'assets/images/clients/client_unops_resized.png', 11, 1),
(13, NULL, 'assets/images/clients/client_wfp.png', 12, 1),
(14, NULL, 'assets/images/clients/client_fao_resized.png', 13, 1),
(15, NULL, 'assets/images/clients/client_dacaar.png', 14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `about_company_profile`
--

CREATE TABLE `about_company_profile` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `link` varchar(500) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `about_core_values`
--

CREATE TABLE `about_core_values` (
  `id` int(10) UNSIGNED NOT NULL,
  `value_text` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_core_values`
--

INSERT INTO `about_core_values` (`id`, `value_text`, `sort_order`) VALUES
(1, 'Integrity — We operate with transparency and honesty in everything we do.', 0),
(2, 'Excellence — We pursue the highest standards in engineering and delivery.', 1),
(3, 'Innovation — We embrace new technologies and methods to solve complex challenges.', 2),
(4, 'Commitment — We honour our promises to clients, partners, and communities.', 3),
(5, 'Safety — We prioritise the health and safety of our people and communities.', 4),
(6, 'Sustainability — We build for the long term with environmental responsibility.', 5);

-- --------------------------------------------------------

--
-- Table structure for table `about_general`
--

CREATE TABLE `about_general` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `about_history`
--

CREATE TABLE `about_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `year` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(500) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_history`
--

INSERT INTO `about_history` (`id`, `year`, `title`, `description`, `image_path`, `sort_order`) VALUES
(1, '2007', 'State Corps Established', 'Establishment of the company in Afghanistan.', 'assets/images/2.jpg', 0),
(2, '2010', 'First Major Project', 'Completion of a major infrastructure project.', 'assets/images/2.jpg', 1),
(3, '2014', 'International Expansion', 'Established offices in Türkiye and the United States.', 'assets/images/about/presenceindex.jpeg', 2),
(4, '2024', 'MOEW & DABS Recognition', 'Awarded recognition for successful energy infrastructure projects.', 'assets/images/2.jpg', 3),
(5, '2025', 'Uzbek-Afghan Energy Projects', 'Transmission Lines, Substations, and Distribution projects with MEW.', 'assets/images/about/0925-kabul.jpeg', 4),
(6, '2025', 'Major Project Milestone', 'Completed over 100 projects valued at more than $500 million.', 'assets/images/about/projectsmaliston.png', 5);

-- --------------------------------------------------------

--
-- Table structure for table `about_hse`
--

CREATE TABLE `about_hse` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `about_mission_vision`
--

CREATE TABLE `about_mission_vision` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `mission` text NOT NULL,
  `mission_img` varchar(500) NOT NULL,
  `vision` text NOT NULL,
  `vision_img` varchar(500) NOT NULL,
  `core_values_img` varchar(500) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `about_page`
--

CREATE TABLE `about_page` (
  `id` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
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
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_page`
--

INSERT INTO `about_page` (`id`, `overview_title`, `overview_content`, `mission_title`, `mission`, `mission_image`, `vision`, `vision_image`, `core_values_image`, `clients_title`, `certificates_title`, `awards_title`, `affiliated_companies_title`, `hse_title`, `hse_content`, `company_profile_title`, `company_profile_content`, `company_profile_file`, `updated_at`) VALUES
(1, 'Overview', 'State Corps warmly welcomes you and appreciates your interest in our company. For approximately two decades, we have grown into one of Afghanistan\'s leading construction and energy firms, delivering high-quality projects through our skilled workforce and experienced management. From major USACE projects to high-voltage transmission lines and substations, we remain committed to excellence, innovation, and contributing to Afghanistan\'s development.', 'Mission & Vision', 'To engineer a sustainable and empowered future for Afghanistan through reliable energy and robust infrastructure, delivering excellence, innovation, and value in every project we undertake.', 'assets/images/6.jpg', 'To be the leading and most trusted engineering and construction partner in the region, recognized for our technical expertise and transformative impact on infrastructure and energy development.', 'assets/images/substation01.jpg', 'assets/images/manpower.jpeg', 'Clients', 'ISO Certifications', 'Awards & Recognitions', 'Affiliated Companies', 'Health, Safety & Environment (HSE)', 'We are committed to protecting people, assets, and the environment through a strong safety culture, proactive risk management, and sustainable operational practices.', 'Company Profile', 'Click the link below to download our comprehensive company profile, showcasing our expertise, project portfolio, and commitment to excellence in engineering and construction.', 'assets/documents/SCProfileLight.pdf', '2026-09-06 19:06:12');

-- --------------------------------------------------------

--
-- Table structure for table `about_sections`
--

CREATE TABLE `about_sections` (
  `id` int(10) UNSIGNED NOT NULL,
  `legacy_id` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `about_sister_companies`
--

CREATE TABLE `about_sister_companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo_path` varchar(500) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `about_timeline`
--

CREATE TABLE `about_timeline` (
  `id` int(10) UNSIGNED NOT NULL,
  `year` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(500) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `entity_type` varchar(100) DEFAULT NULL,
  `entity_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

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
(57, 1, 'login', 'user', 1, 'Successful CMS login.', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36', '2026-09-10 14:43:07');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `content_revisions`
--

CREATE TABLE `content_revisions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `entity_type` varchar(100) NOT NULL,
  `entity_id` bigint(20) UNSIGNED NOT NULL,
  `revision_data` longtext NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `home_hero_slides`
--

CREATE TABLE `home_hero_slides` (
  `id` int(10) UNSIGNED NOT NULL,
  `legacy_id` varchar(100) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(500) NOT NULL,
  `indicator` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_hero_slides`
--

INSERT INTO `home_hero_slides` (`id`, `legacy_id`, `title`, `description`, `image_path`, `indicator`, `sort_order`, `is_active`) VALUES
(1, 'energy', 'Energy & Power Solutions', 'Delivering integrated engineering, procurement, construction, commissioning, and energy infrastructure solutions for transmission, substations, distribution networks, and power development projects.', 'assets/images/home/slider_imgs/hero_energy1.jpg', 'Our Energy Expertise', 0, 1),
(2, 'transport', 'Transportation Infrastructure', 'Designing and developing roads, highways, and transport networks that enhance connectivity, trade flow, and regional economic integration.', 'assets/images/home/slider_imgs/hero_transportation1.jpg', NULL, 1, 1),
(3, 'structure', 'Buildings & Industrial Facilities', 'Engineering and constructing modern commercial, residential, and industrial structures with a focus on durability, efficiency, and long-term value.', 'assets/images/home/slider_imgs/hero_structure1.png', NULL, 2, 1),
(4, 'water', 'Water Resource Management', 'Providing sustainable water supply, treatment, wastewater management, irrigation, and environmental engineering solutions that support economic and social development.', 'assets/images/home/slider_imgs/hero_water1.jpg', NULL, 3, 1),
(5, 'mining', 'Mining', 'Providing end-to-end mining solutions, including exploration support, site development, and infrastructure for efficient mineral extraction.', 'assets/images/home/slider_imgs/hero_mining1.png', NULL, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `home_history`
--

CREATE TABLE `home_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `year` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_history`
--

INSERT INTO `home_history` (`id`, `year`, `title`, `sort_order`, `is_active`) VALUES
(1, '2007', 'State Corps Establishment', 0, 1),
(2, '2010', 'First Major Project', 1, 1),
(3, '2012', 'Awarded by USACE', 2, 1),
(4, '2014', 'International Expansion to Middle East, Turkey and USA', 3, 1),
(5, '2021', 'Successfully completed 60 projects valued at $400M+', 4, 1),
(6, '2024', 'Awarded by MoWE & DABS', 5, 1),
(7, '2025', 'UZBEK-AFGHAN 5 projects', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `home_stats`
--

CREATE TABLE `home_stats` (
  `id` int(10) UNSIGNED NOT NULL,
  `prefix` varchar(20) DEFAULT NULL,
  `number_value` decimal(15,2) NOT NULL,
  `suffix` varchar(50) DEFAULT NULL,
  `label` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_stats`
--

INSERT INTO `home_stats` (`id`, `prefix`, `number_value`, `suffix`, `label`, `sort_order`, `is_active`) VALUES
(1, NULL, 19.00, '+', 'Years of Experience', 0, 1),
(2, NULL, 100.00, '+', 'Completed Projects', 1, 1),
(3, '$', 600.00, 'M+', 'Total Projects Value', 2, 1),
(4, NULL, 4.00, NULL, 'Active Global Offices', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `home_why_items`
--

CREATE TABLE `home_why_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `tab_id` int(10) UNSIGNED NOT NULL,
  `item_text` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_why_items`
--

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

--
-- Table structure for table `home_why_tabs`
--

CREATE TABLE `home_why_tabs` (
  `id` int(10) UNSIGNED NOT NULL,
  `legacy_id` varchar(20) DEFAULT NULL,
  `tab_name` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image_path` varchar(500) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_why_tabs`
--

INSERT INTO `home_why_tabs` (`id`, `legacy_id`, `tab_name`, `title`, `image_path`, `sort_order`, `is_active`) VALUES
(1, '01', 'Delivering Experience', 'Delivering Experience', 'assets/images/home/homedeliveryexperince.jpeg', 0, 1),
(2, '02', 'Regional Presence', NULL, 'assets/images/presenceindex.jpeg', 1, 1),
(3, '03', 'Technical Capabilities', 'Technical Capabilities', 'assets/images/11.jpg', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `legal_documents`
--

CREATE TABLE `legal_documents` (
  `id` int(10) UNSIGNED NOT NULL,
  `document_key` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `legal_documents`
--

INSERT INTO `legal_documents` (`id`, `document_key`, `title`, `sort_order`, `is_active`) VALUES
(1, 'policies_privacy', 'Privacy Policy', 0, 1),
(2, 'policies_whistleblower', 'Whistleblower Policy', 1, 1),
(3, 'policies_trademarks', 'Trademarks Policy', 2, 1),
(4, 'terms_terms', 'Terms of Service', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `legal_sections`
--

CREATE TABLE `legal_sections` (
  `id` int(10) UNSIGNED NOT NULL,
  `document_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(500) NOT NULL,
  `content` longtext DEFAULT NULL,
  `section_type` enum('content','list') NOT NULL DEFAULT 'content',
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `legal_sections`
--

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

--
-- Table structure for table `legal_section_items`
--

CREATE TABLE `legal_section_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `section_id` int(10) UNSIGNED NOT NULL,
  `item_text` longtext NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `legal_section_items`
--

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

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `success` tinyint(1) NOT NULL DEFAULT 0,
  `attempted_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_attempts`
--

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
(33, 'afs@sc.w', '::1', 1, '2026-09-10 14:43:07');

-- --------------------------------------------------------

--
-- Table structure for table `media_descriptions`
--

CREATE TABLE `media_descriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `media_item_id` int(10) UNSIGNED NOT NULL,
  `description_text` longtext NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media_descriptions`
--

INSERT INTO `media_descriptions` (`id`, `media_item_id`, `description_text`, `sort_order`) VALUES
(1, 1, 'State Corps has signed a USD 28.4 million Design-Build agreement for the electrification of Qush Tepa and Darzaab districts in Jawzjan Province. The agreement marks a significant milestone in expanding the country\'s power infrastructure and improving access to reliable electricity for local communities.', 0),
(2, 1, 'The project includes the design, supply, construction, testing, and commissioning of 85.24 km of 220 kV transmission lines, a new 220 kV line bay at the existing Pul-e-Khorasan Substation, two new 220/20 kV substations, and comprehensive 20/0.4 kV distribution networks. The new infrastructure will strengthen the regional transmission system while delivering reliable electricity to households, businesses, and public facilities across both districts.', 1),
(3, 1, 'Scheduled for completion within 36 months, the project reflects State Corps\' commitment to delivering high-quality engineering solutions that meet international standards. Upon completion, it will enhance energy accessibility, support regional economic development, and contribute to the long-term modernization of Afghanistan\'s national power infrastructure.', 2),
(4, 2, 'State Corps and METQ have signed a USD 69.5 million strategic agreement for the development of five major power infrastructure projects connecting Afghanistan and Uzbekistan. The program includes the 201 km Surkhan–Dashti Alwan 500 kV transmission line, 114 km Kabul–Jalalabad 220 kV transmission line, and key substation projects at Dashti Alwan, Shaikh Mesri, and Arghandi.', 0),
(5, 2, 'The projects will be delivered through comprehensive EPC and turnkey solutions, including engineering, procurement, construction, installation, testing, commissioning, and grid integration. The scope covers high-voltage transmission lines, AIS substations, transformer bays, line bays, and advanced shunt reactor systems to enhance network reliability and stability.', 1),
(6, 2, 'With a planned implementation period of 24 months, the initiative will strengthen Afghanistan’s national grid, improve transmission capacity, support regional energy connectivity, and contribute to long-term power system development.', 2),
(7, 3, 'The key participants of this event will be:  China, Iran, India, Uzbekistan, and Kirgizstan. As well as the local market main players will participate in this event', 0),
(8, 3, 'The event held in Kabul, Afghanistan, special focus on Construction, Machinery, Innovation in construction, Foundations, Energy Mechanical & Green Energy, Design & Engineering, Financial Services &Banking, International NGOs and Mining Machinery Sectors.', 1),
(9, 4, 'State Corps is implementing a series of major electricity infrastructure projects in northern Afghanistan with a total value of nearly AFN 4 billion, aimed at expanding reliable electricity access and strengthening regional power networks across Jawzjan, Sar-e Pul, and Faryab provinces.', 0),
(10, 4, 'The projects include the construction of new 110 kV and 220 kV transmission lines, development of multiple substations, line bay extensions, and complete 20/0.4 kV distribution networks in Qush Tepa and Darzaab districts of Jawzjan, Sangcharak, Sozma Qala, and Gosfandi districts of Sar-e Pul, as well as Balchiragh, Garziwan, and Pashtun Kot districts of Faryab. The scope covers survey, design, supply, installation, testing, and commissioning of complete power infrastructure systems.', 1),
(11, 4, 'With an implementation period of 36 months, these projects will significantly enhance electricity availability for local communities, improve regional grid connectivity, create new economic opportunities, and contribute to the long-term development of Afghanistan’s energy infrastructure.', 2),
(12, 5, 'Construction and completion of the 220kV single circuit transmission line from Logar to Gardiz.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `media_items`
--

CREATE TABLE `media_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `legacy_id` varchar(100) DEFAULT NULL,
  `media_type` enum('news','events','gallery') NOT NULL,
  `media_date` varchar(100) DEFAULT NULL,
  `media_date_sort` date DEFAULT NULL,
  `title` varchar(500) NOT NULL,
  `image_path` varchar(500) DEFAULT NULL,
  `external_link` varchar(1000) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media_items`
--

INSERT INTO `media_items` (`id`, `legacy_id`, `media_type`, `media_date`, `media_date_sort`, `title`, `image_path`, `external_link`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'n1', 'news', '23 Dec, 2025', '2025-12-23', 'State Corps Signs USD 28.4 Million Agreement for the Electrification of Qush Tepa and Darzaab Districts of Jawzjan province', 'assets/images/media/23-1225-Jawzjan.jpeg', 'https://pajhwok.com/2025/12/23/power-project-signed-to-electrify-47000-jawzjan-homes/', 0, 1, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(2, 'n2', 'news', '23 Dec, 2025', '2025-12-23', 'State Corps and METQ Sign USD 69.5 Million Agreement for Afghan–Uzbek Power Infrastructure Projects', 'assets/images/media/0925-kabul.jpeg', 'https://gmic.gov.af/en/news_details/188', 1, 1, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(3, 'e1', 'events', '12 Feb, 2026', '2026-02-12', 'Afghanistan 3rd Exhibition on Construction, Rehabilitation, and Energy Sectors', 'assets/images/media/12-0226-beco.jpeg', NULL, 0, 1, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(4, 'n3', 'events', '28 Apr, 2026', '2026-04-28', 'State Corps Launches AFN 4 billion Electrification Projects Across Jawzjan, Sar-e Pul, and Faryab Provinces', 'assets/images/media/28-0426-qoshtepa.jpg', NULL, 1, 1, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(5, 'g1', 'gallery', '3 Dec,2024', '2024-12-03', 'Logar-Gardiz Transmission Line', 'assets/images/2.jpg', NULL, 0, 1, '2026-09-06 19:06:12', '2026-09-06 19:06:12');

-- --------------------------------------------------------

--
-- Table structure for table `media_item_tags`
--

CREATE TABLE `media_item_tags` (
  `media_item_id` int(10) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media_item_tags`
--

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

--
-- Table structure for table `media_tags`
--

CREATE TABLE `media_tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `tag_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media_tags`
--

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

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `permission_key` varchar(100) NOT NULL,
  `permission_name` varchar(150) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `permission_key`, `permission_name`, `description`) VALUES
(1, 'manage_homepage', 'Manage Homepage', 'Edit homepage content'),
(2, 'manage_about', 'Manage About', 'Edit About page content'),
(3, 'manage_projects', 'Manage Projects', 'Create and edit projects'),
(4, 'manage_services', 'Manage Services', 'Create and edit services'),
(5, 'manage_sectors', 'Manage Sectors', 'Create and edit sectors'),
(6, 'manage_media', 'Manage Media', 'Create and edit media'),
(7, 'manage_legal', 'Manage Policies and Terms', 'Edit legal documents'),
(8, 'manage_messages', 'Manage Messages', 'View and manage contact messages'),
(9, 'manage_settings', 'Manage Settings', 'Edit global website settings');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(10) UNSIGNED NOT NULL,
  `legacy_id` varchar(50) DEFAULT NULL,
  `name` varchar(500) NOT NULL,
  `slug` varchar(500) NOT NULL,
  `sector_name` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `completion_year` smallint(5) UNSIGNED DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `client` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `show_on_home` tinyint(1) NOT NULL DEFAULT 0,
  `show_in_category_image` tinyint(1) NOT NULL DEFAULT 0,
  `thumbnail_path` varchar(500) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `legacy_id`, `name`, `slug`, `sector_name`, `category`, `status`, `completion_year`, `location`, `client`, `description`, `show_on_home`, `show_in_category_image`, `thumbnail_path`, `published`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'p1', 'Logar-Gardiz 220 kV Transmission Line ', 'p1', 'Power and Energy', 'transmission line', 'Completed', 2019, 'Logar-Gardiz', NULL, 'This was a Design-Build / EPC project for a 220kV single-circuit transmission line (approx. 60 km) from Pul-e-Alam to Gardez, including towers designed for double-circuit capability. The scope included conductors, OPGW communication system, foundations, stringing, ROW clearance, security, and demining across rough and hilly terrain. The project has been successfully completed.', 1, 1, 'assets/images/projects/01-logar-gardiz-1.jpg', 1, 0, '2026-09-06 19:06:12', '2026-09-08 15:38:58'),
(2, 'p2', 'Jabul Saraj-Gulbahar 220 kV Transmission Line', 'p2', 'Power and Energy', 'transmission line', 'Completed', 2020, 'Kapisa', NULL, 'This was a Design-Build / EPC project for a 220kV single-circuit transmission line from Charikar to Gulbahar. The scope included towers, conductors, insulators, OPGW system, foundations, ROW management, security, and civil works, with towers designed for future double-circuit expansion. The project has been successfully completed.', 0, 0, 'assets/images/projects/2-JabulSaraj-Gulbahar-1.jpeg', 1, 1, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(3, 'p3', 'Gulbahar- Nijrab 110 kV Transmission Line', 'p3', 'Power and Energy', 'transmission line', 'Completed', 2020, 'Gulbahar- Nijrab', NULL, 'This was a Design-Build / EPC project for a 110kV single-circuit transmission line from Gulbahar to Nejrab. The scope included towers, conductors, OPGW communication system, foundations, ROW coordination, security, and demining in mountainous terrain. The project has been successfully completed.', 1, 1, 'assets/images/projects/03-gulbahar-nijrab-1.png', 1, 2, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(4, 'p4', ' Gardiz 220/20 kV Substation', 'p4', 'Power and Energy', 'substation', 'Completed', 2020, 'Gardiz', NULL, 'This was a Design-Build / EPC project for a new 220kV substation located in Gardez, Paktya Province, including 20kV switchgear, a 220/20kV transformer (16 MVA), SCADA/EMS, OPGW communication, grounding, civil works, and provision for future expansion. The project has been successfully completed.', 1, 1, 'assets/images/projects/04-gardiz-1.png', 1, 3, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(5, 'p5', ' Gulbahar 220/110/20 kV Substation', 'p5', 'Power and Energy', 'substation', 'Completed', 2020, 'Kapisa', 'Da Afghanistan Breshna Sherkat (DABS)', 'This was a Design-Build / EPC project for a new 220kV/110kV/20kV substation located in Gulbahar, Kapisa Province, serving as a major grid interconnection hub, including transformers, switchgear, SCADA/EMS, OPGW communication, civil works, and future expansion capability. The project has been successfully completed.', 1, 0, 'assets/images/projects/05-gulbahar-1.jpeg', 1, 4, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(6, 't6', 'Construction of 12.38 Km Concrete Road in Dasht-e-Barchi Area', 't6', 'Transportation', 'road', 'Completed', 2020, 'Kabul, Afghanistan', 'Kabul Municipality', 'This contract was signed between Kabul Municipality (KM) and State Corps. Through this project the construction of 12.38 Km rigid pavement alongside with water drainage structure in Dasht-e-Barchi region of Kabul province of Afghanistan was accomplished. ', 0, 0, 'assets/images/projects/06-kabul-1.png', 1, 5, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(7, 'b7', 'Marshal Fahim National Defense University Phase IIIA (MFNDU - ANDU)', 'b7', 'Building', 'vertical construction', 'completed', 2020, 'Kabul', 'USACE', 'This contract was signed between USACE and State Corps. Through this project the construction of Marshal Fahim national Defense University Complex Phase IIIA for Afghan National Army in Qargha Area of Kabul City, Afghanistan was accomplished.', 1, 1, 'assets/images/projects/07-kabul-1.png', 1, 6, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(8, 'b16', ' Fire Department “FD” Mazar - e- Sharif', 'b16', 'Building', 'vertical construction', 'completed', 2020, 'Balkh', 'USACE', 'This contract was signed between USACE and State Corps. Through this project the construction of Fire Department required facilities at Mazar - e- Sharif City of Balkh Province was accomplished.', 0, 0, 'assets/images/projects/16-balkh-1.png', 1, 7, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(9, 'w28', 'Elevated Water Tower, Balkh', 'w28', 'water Resources', 'water supply networks', 'completed', 2020, 'Balkh', 'USACE', 'This contract was signed between USACE and State Corps. Through this project the construction of Water Towers and Water supply networks in Balkh Province was accomplished.', 0, 0, 'assets/images/projects/28-balkh-1.png', 1, 8, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(10, 'w28-1', 'Water Distribution, Kabul', 'w28-1', 'water Resources', 'water supply networks', 'completed', 2020, 'Kabul', NULL, 'tobe added', 0, 0, 'assets/images/projects/28-1-kabul-1.jpeg', 1, 9, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(11, 'b37', 'Construction of Railway Admin Building of Kandahar', 'b37', 'Building', 'vertical construction', 'completed', 2020, 'Kandahar', 'Ministry of Public Work', 'This contract was signed between Ministry of Public Work (MOPW) and State Corps. The project covers design and construction of ARA Admin building of Kandahar province, Afghanistan.', 1, 0, 'assets/images/projects/37-kandahar-1.png', 1, 10, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(12, 'b38', ' Construction of Railway Admin Building of Herat Province', 'b38', 'Building', 'vertical construction', 'completed', 2020, 'Herat', 'Ministry of Public Works', 'This contract was signed between Ministry of Public Work (MOPW) and State Corps. The project covers design and construction of ARA Admin building of Herat province, Afghanistan.', 0, 0, 'assets/images/projects/38-herat-1.png', 1, 11, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(13, 'b39', 'Construction of Railway Admin Building of Balkh Province', 'b39', 'Building', 'vertical construction', 'completed', 2020, 'Balkh', 'Ministry of Public Works', 'This contract was signed between Ministry of Public Work (MOPW) and State Corps. The project covers design and construction of ARA Admin building of Balkh province, Afghanistan. ', 0, 0, 'assets/images/projects/39-balkh-1.png', 1, 12, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(14, 'p40', 'Gardez Electrification and Wazai Zadran Distribution Networks (Lot 2)', 'p40', 'Power and Energy', 'multi-service', 'completed', 2020, 'Paktya', 'Da Afghanistan Breshna Sherkat (DABS)', 'This Design-Build / EPC project was executed by State Corps as a subcontractor to Angelique International Ltd., with Da Afghanistan Breshna Sherkat (DABS) as the end client, involving engineering, supply, installation, testing, and commissioning of 20kV MV and LV distribution networks in Wazai Zadran and Gardez Districts, Paktya Province. The scope included construction of 6 MV feeders (159.9 km) and LV network (283.45 km), installation of 160 distribution transformers, 7,727 concrete poles, and 2,410 meter boxes, along with complete system integration and commissioning for reliable power distribution.', 0, 0, 'assets/images/projects/40-paktya-1.png', 1, 13, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(15, 'p41', 'Herat Electrification Project (Lot 1)', 'p41', 'Power and Energy', 'multi-service', 'completed', 2020, 'Herat', 'Da Afghanistan Breshna Sherkat (DABS)', 'This EPC contract was signed between Da Afghanistan Breshna Sherkat (DABS) and the ASTER Private Limited - State Corps JV. The scope of work comprises Engineering, Procurement, and Construction (EPC), including design, supply, construction, erection, testing, and commissioning of four (4) 110/20 kV substations located in Chesht Sharif, Aobey, Karokh, and Pashton Zarghoon districts of Herat Province, Afghanistan.', 0, 0, 'assets/images/projects/41-herat-1.jpeg', 1, 14, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(16, 'p75', 'Hairatan to Dasht-e-Alwan 500 kV TL', 'p75', 'Power and Energy', 'transmission line', 'Ongoing', NULL, 'BLK-SMG-BGL', 'METQ', 'This is a Design-Build / EPC program executed under contracts between JSC METQ and State Corps for the expansion of Afghanistan’s high-voltage power transmission network. The projects include key infrastructure such as the Amu Darya Crossing Special Project in Hairatan, the Hairatan–Dashti Alwan 500 kV transmission line, and the Kabul–Jalalabad 220 kV transmission line, covering full scope of survey, design, procurement, civil works, tower erection, stringing, testing, and commissioning. These works are aimed at strengthening national grid stability, increasing transmission capacity, and enhancing regional power connectivity.', 0, 0, 'assets/images/projects/75-SurkhanDashtalwan-1.jpeg', 1, 15, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(17, 'p76', 'Kabul to Jalalabad 220 kV TL', 'p76', 'Power and Energy', 'transmission line', 'Ongoing', NULL, 'Kabul-Nangarhar', 'METQ', 'This is a Design-Build / EPC program executed under contracts between JSC METQ and State Corps for the expansion of Afghanistan’s high-voltage power transmission network. The projects include key infrastructure such as the Amu Darya Crossing Special Project in Hairatan, the Hairatan–Dashti Alwan 500 kV transmission line, and the Kabul–Jalalabad 220 kV transmission line, covering full scope of survey, design, procurement, civil works, tower erection, stringing, testing, and commissioning. These works are aimed at strengthening national grid stability, increasing transmission capacity, and enhancing regional power connectivity.', 0, 0, NULL, 1, 16, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(18, 'p77', 'Dasht-e-Alwan 500 kV SS with Shunt Reactor System', 'p77', 'Power and Energy', 'substation', 'Ongoing', NULL, 'Baghlan', 'METQ', 'This is a Design-Build / EPC program executed under contracts between JSC METQ and State Corps for the expansion of Afghanistan’s high-voltage power transmission network. The projects include key infrastructure such as the Amu Darya Crossing Special Project in Hairatan, the Hairatan–Dashti Alwan 500 kV transmission line, and the Kabul–Jalalabad 220 kV transmission line, covering full scope of survey, design, procurement, civil works, tower erection, stringing, testing, and commissioning. These works are aimed at strengthening national grid stability, increasing transmission capacity, and enhancing regional power connectivity.', 1, 0, NULL, 1, 17, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(19, 'p78', 'Shaikh Mesri 220/110/20 kV Substation', 'p78', 'Power and Energy', 'substation', 'Ongoing', NULL, 'Nangarhar', 'METQ', 'This is a Design-Build / EPC program executed under contracts between JSC METQ and State Corps for the expansion of Afghanistan’s high-voltage power transmission network. The projects include key infrastructure such as the Amu Darya Crossing Special Project in Hairatan, the Hairatan–Dashti Alwan 500 kV transmission line, and the Kabul–Jalalabad 220 kV transmission line, covering full scope of survey, design, procurement, civil works, tower erection, stringing, testing, and commissioning. These works are aimed at strengthening national grid stability, increasing transmission capacity, and enhancing regional power connectivity.', 0, 0, 'assets/images/projects/78-shaikhmesri-1.jpeg', 1, 18, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(20, 'p79', 'Arghandi Transformer Bay', 'p79', 'Power and Energy', 'substation', 'Ongoing', NULL, 'Kabul', 'METQ', 'This is a Design-Build / EPC program executed under contracts between JSC METQ and State Corps for the expansion of Afghanistan’s high-voltage power transmission network. The projects include key infrastructure such as the Amu Darya Crossing Special Project in Hairatan, the Hairatan–Dashti Alwan 500 kV transmission line, and the Kabul–Jalalabad 220 kV transmission line, covering full scope of survey, design, procurement, civil works, tower erection, stringing, testing, and commissioning. These works are aimed at strengthening national grid stability, increasing transmission capacity, and enhancing regional power connectivity .', 0, 0, 'assets/images/projects/79-arghandi-1.jpeg', 1, 19, '2026-09-06 19:06:12', '2026-09-07 10:56:32'),
(21, 'p85', 'Chemtala to Tarakhail 220 kV TL', 'p85', 'Power and Energy', 'transmission line', 'Ongoing', NULL, 'Kabul', 'ABC', 'This was a Design-Build / EPC project awarded to State Corps for the Ministry of Energy and Water (MEW), with financing provided by Awfi Bahram Companies under approvals of the High Economic Council (HEC) and the Economic Deputy Office of the Islamic Emirate of Afghanistan. The project covers the construction of 220 kV double-circuit transmission lines from Chemtala to Tarakhail and from Arghandi to Butkhak, development of 220 kV Tarakhail and Butkhak substations in Kabul, and installation of two 500 kV, 80 MVAR double-bus reactors at Arghandi Substation to enhance the reliability, stability, and operational performance of Afghanistan’s national power system. The project is currently under execution.', 0, 0, 'assets/images/projects/85-ChemtalaTarakhail-1.jpeg', 1, 20, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(22, 'p86', 'Arghandi to Butkhak 220 kv TL', 'p86', 'Power and Energy', 'transmission line', 'Ongoing', NULL, 'Kabul', 'ABC', 'This was a Design-Build / EPC project awarded to State Corps for the Ministry of Energy and Water (MEW), with financing provided by Awfi Bahram Companies under approvals of the High Economic Council (HEC) and the Economic Deputy Office of the Islamic Emirate of Afghanistan. The project covers the construction of 220 kV double-circuit transmission lines from Chemtala to Tarakhail and from Arghandi to Butkhak, development of 220 kV Tarakhail and Butkhak substations in Kabul, and installation of two 500 kV, 80 MVAR double-bus reactors at Arghandi Substation to enhance the reliability, stability, and operational performance of Afghanistan’s national power system. The project is currently under execution.', 0, 0, NULL, 1, 21, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(23, 'p87', 'Tarakhail 220/110kV & 220/20kV SS', 'p87', 'Power and Energy', 'substation', 'Ongoing', NULL, 'Kabul', 'ABC', 'This was a Design-Build / EPC project awarded to State Corps for the Ministry of Energy and Water (MEW), with financing provided by Awfi Bahram Companies under approvals of the High Economic Council (HEC) and the Economic Deputy Office of the Islamic Emirate of Afghanistan. The project covers the construction of 220 kV double-circuit transmission lines from Chemtala to Tarakhail and from Arghandi to Butkhak, development of 220 kV Tarakhail and Butkhak substations in Kabul, and installation of two 500 kV, 80 MVAR double-bus reactors at Arghandi Substation to enhance the reliability, stability, and operational performance of Afghanistan’s national power system. The project is currently under execution.', 0, 0, NULL, 1, 22, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(24, 'p88', 'Butkhak 220/110kV & 220/20kV SS', 'p88', 'Power and Energy', 'substation', 'Ongoing', NULL, 'Kabul', 'ABC', 'This was a Design-Build / EPC project awarded to State Corps for the Ministry of Energy and Water (MEW), with financing provided by Awfi Bahram Companies under approvals of the High Economic Council (HEC) and the Economic Deputy Office of the Islamic Emirate of Afghanistan. The project covers the construction of 220 kV double-circuit transmission lines from Chemtala to Tarakhail and from Arghandi to Butkhak, development of 220 kV Tarakhail and Butkhak substations in Kabul, and installation of two 500 kV, 80 MVAR double-bus reactors at Arghandi Substation to enhance the reliability, stability, and operational performance of Afghanistan’s national power system. The project is currently under execution.', 0, 0, NULL, 1, 23, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(25, 'p89', 'Arghandi SS 500 KV Two Reactor Bays', 'p89', 'Power and Energy', 'substation', 'Ongoing', NULL, 'Kabul', 'ABC', 'This was a Design-Build / EPC project awarded to State Corps for the Ministry of Energy and Water (MEW), with financing provided by Awfi Bahram Companies under approvals of the High Economic Council (HEC) and the Economic Deputy Office of the Islamic Emirate of Afghanistan. The project covers the construction of 220 kV double-circuit transmission lines from Chemtala to Tarakhail and from Arghandi to Butkhak, development of 220 kV Tarakhail and Butkhak substations in Kabul, and installation of two 500 kV, 80 MVAR double-bus reactors at Arghandi Substation to enhance the reliability, stability, and operational performance of Afghanistan’s national power system. The project is currently under execution.', 0, 0, NULL, 1, 24, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(26, 'p91', 'Electrification of Qush Tepa and Darzaab Districts of Jawzjan Province Project ', 'p91', 'Power and Energy', 'multi-service', 'Ongoing', NULL, 'Jawzjan', 'MoWE', 'This is a Design-Build / EPC project currently being executed under a contract between the Ministry of Water and Energy (MoWE) and State Corps, covering the development of the power network in Qush Tepa and Darzab districts of Afghanistan. The scope includes the construction of two new substations with capacities of 20 MVA in Qush Tepa and 32 MVA in Darzab, along with associated 20/0.4 kV MV and LV distribution networks with total capacities of 16 MVA in Qush Tepa and 20 MVA in Darzab. It also involves the construction of an 85.24 km 220 kV transmission line from Pul-e-Khorasan to Qush Tepa and onward to Darzab, along with a 220 kV line bay at Pul-e-Khorasan Substation for integration into the national grid.', 0, 0, 'assets/images/projects/91-QushTepaDarzaab-1.jpeg', 1, 25, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(27, 'p94', 'Electrification of Sangcharak, Sozmaqala & Gusfandi Districts of Sar-e-Pul Province, Afghanistan ', 'p94', 'Power and Energy', 'multi-service', 'Ongoing', NULL, 'Sare Pul', 'MoWE', 'This is a Design-Build / EPC project currently being executed under a contract between the Ministry of Water and Energy (MoWE) and State Corps, covering the electrification of Sangcharak, Sozmaqala, and Gusfandi districts of Afghanistan. The scope includes the construction of a 60 km, 110 kV transmission line from Sar-e Pul to Sangcharak Substation, along with a new 110/20 kV Sangcharak Substation with a capacity of 32 MVA (2x16 MVA). It also includes the construction of a 110 kV line bay at Sar-e Pul Substation for integration into the national grid. In addition, the project involves the development of 20/0.4 kV MV/LV distribution networks with total capacities of 3 MVA in Sangcharak, 18 MVA in Sozmaqala, and 5 MVA in Gusfandi districts.', 0, 0, NULL, 1, 26, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(28, 'p96', 'Electrification of Balchiragh, Garziwan and Pashtun Kot Districts of Faryab Province ', 'p96', 'Power and Energy', 'multi-service', 'Ongoing', NULL, 'Sare Pul', 'MoWE', 'This is a Design-Build / Istisna (EPC) project currently being implemented under a contract between the Ministry of Water and Energy (MoWE) and State Corps, covering the development of the power supply network in Balchiragh, Garziwan, and Pashtun Kot districts of Faryab Province, Afghanistan. The scope of works includes the construction of a 65 km, 110 kV overhead single-circuit transmission line from Maimana Substation to Balchiragh Substation and onward to Garziwan Substation, the establishment of two new 110/20 kV substations at Balchiragh (10 MVA, 2x5 MVA) and Garziwan (10 MVA, 2x5 MVA), the construction of a 110 kV line bay at Maimana Substation for grid integration, and the development of 20/0.4 kV medium- and low-voltage distribution networks to supply residential, commercial, and public service consumers, with total distribution capacities of 8 MVA in Balchiragh, 16 MVA in Garziwan, and 5 MVA in Pashtun Kot', 0, 0, NULL, 1, 27, '2026-09-06 19:06:12', '2026-09-06 19:06:12'),
(29, 'm01', 'Talc Processing Plant', 'm01', 'mining', 'mineral processing', 'ongoing', NULL, 'Sheikh Mesri Industrial Park, Nangarhar Province', 'Arya Mineral', 'Arya Mineral owns talc grinding and crushing plants located in Sheikh Mesri Industrial Park, Nangarhar Province. The plant was designed and manufactured by Zenith and constructed and installed by State Corps. It has a minimum annual grinding capacity of 30,000 tons and a crushing capacity of 100,000 tons, with the potential for further expansion as the business grows. The facility also uses advanced color-sorting technology to sort and segregate different grades and types of talc.', 1, 1, 'assets/images/projects/processingplant.jpg', 1, 28, '2026-09-06 19:06:12', '2026-09-06 19:06:12');

-- --------------------------------------------------------

--
-- Table structure for table `project_images`
--

CREATE TABLE `project_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED NOT NULL,
  `image_path` varchar(500) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `caption` varchar(500) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_images`
--

INSERT INTO `project_images` (`id`, `project_id`, `image_path`, `alt_text`, `caption`, `sort_order`) VALUES
(1, 1, 'assets/images/projects/01-logar-gardiz-1.jpg', 'Logar-Gardiz 220 kV Transmission Line ', NULL, 0),
(2, 2, 'assets/images/projects/2-JabulSaraj-Gulbahar-1.jpeg', 'Jabul Saraj-Gulbahar 220 kV Transmission Line', NULL, 0),
(3, 3, 'assets/images/projects/03-gulbahar-nijrab-1.png', 'Gulbahar- Nijrab 110 kV Transmission Line', NULL, 0),
(4, 4, 'assets/images/projects/04-gardiz-1.png', ' Gardiz 220/20 kV Substation', NULL, 0),
(5, 5, 'assets/images/projects/05-gulbahar-1.jpeg', ' Gulbahar 220/110/20 kV Substation', NULL, 0),
(6, 5, 'assets/images/projects/05-gulbahar-2.jpeg', ' Gulbahar 220/110/20 kV Substation', NULL, 1),
(7, 5, 'assets/images/projects/05-gulbahar-3.jpeg', ' Gulbahar 220/110/20 kV Substation', NULL, 2),
(8, 6, 'assets/images/projects/06-kabul-1.png', 'Construction of 12.38 Km Concrete Road in Dasht-e-Barchi Area', NULL, 0),
(9, 6, 'assets/images/projects/06-kabul-2.png', 'Construction of 12.38 Km Concrete Road in Dasht-e-Barchi Area', NULL, 1),
(10, 6, 'assets/images/projects/06-kabul-3.png', 'Construction of 12.38 Km Concrete Road in Dasht-e-Barchi Area', NULL, 2),
(11, 6, 'assets/images/projects/06-kabul-4.png', 'Construction of 12.38 Km Concrete Road in Dasht-e-Barchi Area', NULL, 3),
(12, 7, 'assets/images/projects/07-kabul-1.png', 'Marshal Fahim National Defense University Phase IIIA (MFNDU - ANDU)', NULL, 0),
(13, 7, 'assets/images/projects/07-kabul-2.png', 'Marshal Fahim National Defense University Phase IIIA (MFNDU - ANDU)', NULL, 1),
(14, 7, 'assets/images/projects/07-kabul-3.png', 'Marshal Fahim National Defense University Phase IIIA (MFNDU - ANDU)', NULL, 2),
(15, 8, 'assets/images/projects/16-balkh-1.png', ' Fire Department “FD” Mazar - e- Sharif', NULL, 0),
(16, 9, 'assets/images/projects/28-balkh-1.png', 'Elevated Water Tower, Balkh', NULL, 0),
(17, 9, 'assets/images/projects/28-balkh-2.png', 'Elevated Water Tower, Balkh', NULL, 1),
(18, 10, 'assets/images/projects/28-1-kabul-1.jpeg', 'Water Distribution, Kabul', NULL, 0),
(19, 11, 'assets/images/projects/37-kandahar-1.png', 'Construction of Railway Admin Building of Kandahar', NULL, 0),
(20, 11, 'assets/images/projects/37-kandahar-2.png', 'Construction of Railway Admin Building of Kandahar', NULL, 1),
(21, 11, 'assets/images/projects/37-kandahar-3.png', 'Construction of Railway Admin Building of Kandahar', NULL, 2),
(22, 12, 'assets/images/projects/38-herat-1.png', ' Construction of Railway Admin Building of Herat Province', NULL, 0),
(23, 12, 'assets/images/projects/38-herat-2.png', ' Construction of Railway Admin Building of Herat Province', NULL, 1),
(24, 12, 'assets/images/projects/38-herat-3.png', ' Construction of Railway Admin Building of Herat Province', NULL, 2),
(25, 13, 'assets/images/projects/39-balkh-1.png', 'Construction of Railway Admin Building of Balkh Province', NULL, 0),
(26, 13, 'assets/images/projects/39-balkh-2.png', 'Construction of Railway Admin Building of Balkh Province', NULL, 1),
(27, 13, 'assets/images/projects/39-balkh-3.png', 'Construction of Railway Admin Building of Balkh Province', NULL, 2),
(28, 14, 'assets/images/projects/40-paktya-1.png', 'Gardez Electrification and Wazai Zadran Distribution Networks (Lot 2)', NULL, 0),
(29, 14, 'assets/images/projects/40-paktya-2.png', 'Gardez Electrification and Wazai Zadran Distribution Networks (Lot 2)', NULL, 1),
(30, 14, 'assets/images/projects/40-paktya-3.png', 'Gardez Electrification and Wazai Zadran Distribution Networks (Lot 2)', NULL, 2),
(31, 14, 'assets/images/projects/40-paktya-4.png', 'Gardez Electrification and Wazai Zadran Distribution Networks (Lot 2)', NULL, 3),
(32, 15, 'assets/images/projects/41-herat-1.jpeg', 'Herat Electrification Project (Lot 1)', NULL, 0),
(33, 15, 'assets/images/projects/41-herat-2.jpeg', 'Herat Electrification Project (Lot 1)', NULL, 1),
(34, 15, 'assets/images/projects/41-herat-3.jpeg', 'Herat Electrification Project (Lot 1)', NULL, 2),
(35, 15, 'assets/images/projects/41-herat-4.jpeg', 'Herat Electrification Project (Lot 1)', NULL, 3),
(36, 16, 'assets/images/projects/75-SurkhanDashtalwan-1.jpeg', 'Hairatan to Dasht-e-Alwan 500 kV TL', NULL, 0),
(37, 16, 'assets/images/projects/75-SurkhanDashtalwan-2.jpeg', 'Hairatan to Dasht-e-Alwan 500 kV TL', NULL, 1),
(38, 16, 'assets/images/projects/75-SurkhanDashtalwan-3.jpeg', 'Hairatan to Dasht-e-Alwan 500 kV TL', NULL, 2),
(39, 19, 'assets/images/projects/78-shaikhmesri-1.jpeg', 'Shaikh Mesri 220/110/20 kV Substation', NULL, 0),
(40, 19, 'assets/images/projects/78-shaikhmesri-2.jpeg', 'Shaikh Mesri 220/110/20 kV Substation', NULL, 1),
(41, 19, 'assets/images/projects/78-shaikhmesri-3.jpeg', 'Shaikh Mesri 220/110/20 kV Substation', NULL, 2),
(43, 21, 'assets/images/projects/85-ChemtalaTarakhail-1.jpeg', 'Chemtala to Tarakhail 220 kV TL', NULL, 0),
(44, 21, 'assets/images/projects/85-ChemtalaTarakhail-2.jpeg', 'Chemtala to Tarakhail 220 kV TL', NULL, 1),
(45, 21, 'assets/images/projects/85-ChemtalaTarakhail-3.jpeg', 'Chemtala to Tarakhail 220 kV TL', NULL, 2),
(46, 26, 'assets/images/projects/91-QushTepaDarzaab-1.jpeg', 'Electrification of Qush Tepa and Darzaab Districts of Jawzjan Province Project ', NULL, 0),
(47, 26, 'assets/images/projects/91-QushTepaDarzaab-2.jpeg', 'Electrification of Qush Tepa and Darzaab Districts of Jawzjan Province Project ', NULL, 1),
(48, 27, 'Survey, design, procurement, construction, testing, and commissioning of the 110 kV transmission line from Sar-e Pul substation to the new substation in Sangcharak', 'Electrification of Sangcharak, Sozmaqala & Gusfandi Districts of Sar-e-Pul Province, Afghanistan ', NULL, 0),
(49, 27, 'Extension of an overhead 110 kV single-circuit line from Sar e Pul Substation to the new substation in Sangcharak (60 Km).', 'Electrification of Sangcharak, Sozmaqala & Gusfandi Districts of Sar-e-Pul Province, Afghanistan ', NULL, 1),
(50, 27, 'Optical Ground Wire (OPGW) for communication and protection purposes', 'Electrification of Sangcharak, Sozmaqala & Gusfandi Districts of Sar-e-Pul Province, Afghanistan ', NULL, 2),
(51, 29, 'assets/images/projects/processingplant.jpg', 'Talc Processing Plant', NULL, 0),
(52, 29, 'assets/images/projects/processingplant1.jpg', 'Talc Processing Plant', NULL, 1),
(53, 20, 'assets/images/projects/79-arghandi-1.jpeg', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `project_scope`
--

CREATE TABLE `project_scope` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED NOT NULL,
  `scope_text` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_scope`
--

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
(105, 27, '110 kV line bay at Sar-e Pul Substation', 4),
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

--
-- Table structure for table `sectors`
--

CREATE TABLE `sectors` (
  `id` int(10) UNSIGNED NOT NULL,
  `sector_key` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `hero_tag` varchar(255) DEFAULT NULL,
  `hero_headline` varchar(500) DEFAULT NULL,
  `hero_subtitle` varchar(500) DEFAULT NULL,
  `hero_cta_text` varchar(255) DEFAULT NULL,
  `hero_cta_link` varchar(500) DEFAULT NULL,
  `hero_image` varchar(500) DEFAULT NULL,
  `featured_project_name` varchar(500) DEFAULT NULL,
  `featured_project_image` varchar(500) DEFAULT NULL,
  `featured_project_cta_text` varchar(255) DEFAULT NULL,
  `featured_project_cta_link` varchar(500) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sectors`
--

INSERT INTO `sectors` (`id`, `sector_key`, `title`, `description`, `hero_tag`, `hero_headline`, `hero_subtitle`, `hero_cta_text`, `hero_cta_link`, `hero_image`, `featured_project_name`, `featured_project_image`, `featured_project_cta_text`, `featured_project_cta_link`, `sort_order`, `is_active`) VALUES
(1, 'powerenergy', 'Power & Energy', 'The Power & Energy sector drives the development, engineering, and delivery of reliable electricity infrastructure across the region, encompassing high-voltage transmission lines, substations, and renewable energy solutions including solar, wind, and hydropower. By integrating advanced technologies with deep engineering expertise, the company designs and implements efficient, sustainable energy systems that meet growing demands. Through active support of national grid expansion, it enhances energy accessibility for communities and industries alike, while contributing to long-term economic growth and strengthening energy security — powering a more resilient and sustainable future for generations to come.', 'Power & Energy Sector', 'Delivering Reliable Power Infrastructure & Renewable Energy Solutions', 'High Voltage • Transmission • Renewable Energy', 'Reach Us', 'contact.php', 'assets/images/home/slider_imgs/hero_energy1.jpg', 'Herat Substation Project', 'assets/images/energy-sector-herat.jpeg', 'View Projects', 'projects.php?category=powerenergy', 0, 1),
(2, 'transport', 'Transportation', 'The transportation infrastructure sector focuses on delivering integrated, efficient, and sustainable mobility solutions including roads, railways, and airports. Through advanced engineering, modern construction techniques, and strict safety standards, the company develops critical transport networks that enhance connectivity, support economic growth, and improve regional accessibility. With a commitment to quality and innovation, projects are executed to meet international standards while addressing local development needs.', 'Transport Sector', 'Building Modern, Safe & Sustainable Transportation Infrastructure', 'Engineering Excellence in Mobility Solutions', 'Reach Us', 'contact.php', 'assets/images/home/slider_imgs/hero_transportation1.jpg', 'National Highway Development Project', 'assets/images/projects/06-kabul-2.png', 'View Projects', 'projects.php?category=transport', 1, 1),
(3, 'Infrastructure', 'Building', 'The infrastructure and construction sector focuses on delivering high-quality, sustainable, and modern built environments including residential, commercial, and industrial developments. With strong engineering expertise, advanced construction methodologies, and adherence to international standards, the company ensures reliable and efficient project delivery. From buildings and bridges to tunnels and large-scale infrastructure, every project is executed with a commitment to safety, durability, and long-term value creation.', 'Infrastructure Sector', 'Delivering Modern, Sustainable & High-Quality Construction Solutions', 'Engineering Excellence in Built Environments', 'Reach Us', 'contact.php', 'assets/images/home/slider_imgs/hero_structure1.png', 'National Infrastructure Development Project', 'assets/images/projects/07-kabul-1.png', 'View Projects', 'projects.php?category=infrastructure', 2, 1),
(4, 'water', 'Water Resources', 'The water resources sector focuses on sustainable management, design, and development of hydraulic infrastructure including water supply systems, dams, irrigation networks, and wastewater treatment facilities. With advanced engineering practices and environmental responsibility, the company delivers efficient water solutions that support agriculture, urban development, and long-term resource sustainability.', 'Water Sector', 'Sustainable Water Management & Hydraulic Infrastructure Solutions', 'Engineering Water for Life & Development', 'Reach Us', 'contact.php', 'assets/images/home/slider_imgs/hero_water1.jpg', 'Regional Water Management Project', 'assets/images/projects/28-balkh-1.png', 'View Projects', 'projects.php?category=water', 3, 1),
(5, 'mining', 'Mining', 'The mining sector at Arya Mineral is focused on delivering efficient, sustainable, and large-scale extraction of industrial minerals and gemstones. Leveraging modern technologies and advanced engineering practices, the company ensures optimized production while maintaining high safety and environmental standards. Its expertise spans mine planning, operational management, and economic analysis, enabling projects to achieve both technical and financial success. With a strong presence in key resource areas such as talc concessions, Arya Mineral combines local knowledge with international expertise to maximize resource value, support regional development, and contribute to long-term growth in Afghanistan\'s mining industry.\r\n\r\n2019: Brand Launch and Global Outreach At the beginning of 2019, the company successfully produced and exported its specialized A grade ultra-fine Afghan talc powder under its own brand name. This achievement was particularly historic as it marked the first-ever shipment of talc from Afghanistan to Jordan. Throughout 2019, Arya Mineral rapidly expanded its footprint, exporting processed talc to a wide array of international markets, including: •	Asia: India, Japan, South Korea, Kazakhstan, and Tajikistan.•	Middle East: Jordan, Iraq, and Turkey.•	Europe & Eurasia: Germany and Russia.\r\n\r\n2019-2021: Market Expansion and Partnerships Between 2019 and 2021, Arya Mineral secured a strategic collaboration and contract with a Chinese firm to penetrate and expand its presence within the Chinese markets. By May 27, 2021, the company remained highly active in the processing and export sector, continuing to build upon the foundation of its established factory and its track record of successful international trade', 'Mining Sector', 'Delivering Sustainable Mining & Mineral Solutions Across Afghanistan and Beyond', 'ISO Certified Operations', 'Reach Us', 'contact.php', 'assets/images/home/slider_imgs/hero_mining1.png', 'Talc Processing Plant', 'assets/images/projects/processingplant1.jpg', 'View Projects', 'projects.php?category=mining', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sector_areas`
--

CREATE TABLE `sector_areas` (
  `id` int(10) UNSIGNED NOT NULL,
  `sector_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sector_areas`
--

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

--
-- Table structure for table `sector_sections`
--

CREATE TABLE `sector_sections` (
  `id` int(10) UNSIGNED NOT NULL,
  `sector_id` int(10) UNSIGNED NOT NULL,
  `legacy_id` varchar(100) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sector_sections`
--

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

--
-- Table structure for table `sector_section_images`
--

CREATE TABLE `sector_section_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `section_id` int(10) UNSIGNED NOT NULL,
  `image_path` varchar(500) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sector_section_images`
--

INSERT INTO `sector_section_images` (`id`, `section_id`, `image_path`, `sort_order`) VALUES
(1, 1, 'assets/images/2.jpg', 0),
(2, 1, 'assets/images/2.jpg', 1),
(3, 1, 'assets/images/2.jpg', 2),
(4, 1, 'assets/images/2.jpg', 3),
(5, 2, 'assets/images/2.jpg', 0),
(6, 2, 'assets/images/2.jpg', 1),
(7, 2, 'assets/images/2.jpg', 2),
(8, 2, 'assets/images/2.jpg', 3),
(9, 3, 'assets/images/2.jpg', 0),
(10, 3, 'assets/images/2.jpg', 1),
(11, 3, 'assets/images/2.jpg', 2),
(12, 3, 'assets/images/2.jpg', 3),
(13, 4, 'assets/images/2.jpg', 0),
(14, 4, 'assets/images/2.jpg', 1),
(15, 4, 'assets/images/2.jpg', 2),
(16, 4, 'assets/images/2.jpg', 3),
(17, 5, 'assets/images/2.jpg', 0),
(18, 5, 'assets/images/2.jpg', 1),
(19, 5, 'assets/images/2.jpg', 2),
(20, 5, 'assets/images/2.jpg', 3),
(21, 6, 'assets/images/2.jpg', 0),
(22, 6, 'assets/images/2.jpg', 1),
(23, 6, 'assets/images/2.jpg', 2),
(24, 6, 'assets/images/2.jpg', 3),
(25, 7, 'assets/images/2.jpg', 0),
(26, 7, 'assets/images/2.jpg', 1),
(27, 7, 'assets/images/2.jpg', 2),
(28, 7, 'assets/images/2.jpg', 3),
(29, 8, 'assets/images/2.jpg', 0),
(30, 8, 'assets/images/2.jpg', 1),
(31, 8, 'assets/images/2.jpg', 2),
(32, 8, 'assets/images/2.jpg', 3),
(33, 9, 'assets/images/2.jpg', 0),
(34, 9, 'assets/images/2.jpg', 1),
(35, 9, 'assets/images/2.jpg', 2),
(36, 9, 'assets/images/2.jpg', 3),
(37, 10, 'assets/images/2.jpg', 0),
(38, 10, 'assets/images/2.jpg', 1),
(39, 10, 'assets/images/2.jpg', 2),
(40, 10, 'assets/images/2.jpg', 3),
(41, 11, 'assets/images/2.jpg', 0),
(42, 11, 'assets/images/2.jpg', 1),
(43, 11, 'assets/images/2.jpg', 2),
(44, 11, 'assets/images/2.jpg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `sector_section_stats`
--

CREATE TABLE `sector_section_stats` (
  `id` int(10) UNSIGNED NOT NULL,
  `section_id` int(10) UNSIGNED NOT NULL,
  `value_text` varchar(100) NOT NULL,
  `label` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sector_section_stats`
--

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

--
-- Table structure for table `sector_stats`
--

CREATE TABLE `sector_stats` (
  `id` int(10) UNSIGNED NOT NULL,
  `sector_id` int(10) UNSIGNED NOT NULL,
  `value_text` varchar(100) NOT NULL,
  `label` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sector_stats`
--

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

--
-- Table structure for table `sector_why`
--

CREATE TABLE `sector_why` (
  `id` int(10) UNSIGNED NOT NULL,
  `sector_id` int(10) UNSIGNED NOT NULL,
  `text_content` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sector_why`
--

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

--
-- Table structure for table `service_categories`
--

CREATE TABLE `service_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED NOT NULL,
  `category_key` varchar(150) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_categories`
--

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

--
-- Table structure for table `service_features`
--

CREATE TABLE `service_features` (
  `id` int(10) UNSIGNED NOT NULL,
  `service_item_id` int(10) UNSIGNED NOT NULL,
  `feature_text` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_features`
--

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
(100, 31, 'Continuous improvement strategies', 3),
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
(170, 50, 'Expert Team', 0),
(171, 50, 'Comprehensive Solutions', 1),
(172, 50, 'Sustainable Practices', 2),
(173, 50, 'Client-Focused Approach', 3),
(174, 51, 'tobe added', 0),
(175, 52, 'tobe added', 0);

-- --------------------------------------------------------

--
-- Table structure for table `service_groups`
--

CREATE TABLE `service_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `service_key` varchar(150) NOT NULL,
  `title` varchar(255) NOT NULL,
  `hero_image` varchar(500) DEFAULT NULL,
  `hero_text` longtext DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_groups`
--

INSERT INTO `service_groups` (`id`, `service_key`, `title`, `hero_image`, `hero_text`, `sort_order`, `is_active`) VALUES
(1, 'engineeringanddesign', 'Engineering and Design', 'assets/images/services/service-eng-hero.jpg', 'Delivering integrated engineering and design solutions across every discipline.', 0, 1),
(2, 'implementation', 'Project Delivery', 'assets/images/services/service-hero.jpg', 'Delivering integrated project delivery solutions from execution and construction through commissioning, operations, and long-term asset performance.', 1, 1),
(3, 'mining', 'Mining', 'assets/images/services/service-mining-hero.png', 'Delivering comprehensive mining solutions from exploration to sustainable extraction.', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `service_items`
--

CREATE TABLE `service_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `service_key` varchar(150) DEFAULT NULL,
  `title` varchar(500) NOT NULL,
  `image_path` varchar(500) DEFAULT NULL,
  `short_description` longtext DEFAULT NULL,
  `why_description` longtext DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_items`
--

INSERT INTO `service_items` (`id`, `category_id`, `parent_id`, `service_key`, `title`, `image_path`, `short_description`, `why_description`, `sort_order`, `is_active`) VALUES
(1, 1, NULL, NULL, 'Feasibility Studies', 'assets/images/services/feasibilitystu1.jpg', 'We provide comprehensive feasibility studies that include initial concept development, technical and financial evaluations, and early-stage planning to assess project viability, identify constraints, and outline practical solutions before moving into detailed design and execution phases.', 'Our studies minimise risks by identifying constraints, validating assumptions, and ensuring informed, cost-effective project decisions from the outset.', 0, 1),
(2, 1, NULL, NULL, 'GIS Mapping and Analysis', 'assets/images/services/gis1.jpg', 'Our GIS mapping and analysis services involve collecting, processing, and interpreting spatial data using advanced geospatial technologies to support accurate planning, decision-making, and visualization for infrastructure, environmental studies, and land management projects across diverse and complex terrains.', 'We deliver precise geospatial insights that improve planning accuracy, optimise resource allocation, and support efficient, data-driven project decisions.', 1, 1),
(3, 1, NULL, NULL, 'Environmental and Social Assessments', 'assets/images/services/enviromental1.jpg', 'We conduct detailed environmental and social assessments to evaluate potential project impacts, ensure regulatory compliance, and promote sustainable development by integrating environmental protection measures and community considerations into planning and execution processes.', 'We ensure regulatory compliance while reducing environmental impact and enhancing positive social outcomes for sustainable project success.', 2, 1),
(4, 2, NULL, NULL, 'Conceptual Engineering Studies', 'assets/images/services/conceptualdesign1.jpg', 'We develop early-stage engineering concepts that translate project objectives into technically sound, feasible, and cost-effective solutions, enabling informed decision-making while aligning design approaches with project goals, site conditions, and stakeholder expectations before advancing into detailed design phases.', 'Strong concepts reduce redesign risks, align stakeholders early, and provide a clear, efficient direction for all subsequent design stages.', 0, 1),
(5, 2, NULL, NULL, 'Architectural Design', 'assets/images/services/architecturaldesign.jpg', 'Our architectural design services deliver innovative and functional solutions across residential, commercial, and infrastructure projects, integrating aesthetics, spatial planning, and technical requirements to create environments that are visually appealing, efficient, and aligned with user needs and regulatory standards.', 'We create designs that balance creativity, functionality, and practicality, ensuring visually compelling spaces that perform efficiently and meet project goals.', 1, 1),
(6, 2, NULL, NULL, 'Civil Design', 'assets/images/services/civildesign.jpg', 'We provide detailed civil engineering design for roads, drainage systems, grading, and site infrastructure, ensuring efficient land use, proper water management, and long-term durability while meeting regulatory requirements and supporting smooth construction processes across a wide range of infrastructure projects.', 'Accurate civil design ensures efficient construction, regulatory compliance, and long-term performance of infrastructure under varying site conditions.', 2, 1),
(7, 2, NULL, NULL, 'Structural Design', 'assets/images/services/structuraldesign.jpg', 'We deliver safe and efficient structural design solutions for buildings, bridges, and industrial facilities, combining advanced analysis with practical construction considerations to ensure stability, durability, and optimal material use while meeting safety standards and project-specific performance requirements.', 'Our structural solutions enhance safety, optimise material use, and ensure reliable performance under environmental and operational loads.', 3, 1),
(8, 2, NULL, NULL, 'Electrical Design', 'assets/images/services/electricaldesign1.jpeg', 'We design comprehensive electrical systems covering power distribution, lighting, instrumentation, and control, ensuring reliable and efficient operation while supporting safety, scalability, and future expansion needs for various building and infrastructure projects across different sectors.', 'Our designs ensure safe, reliable power systems that support operational efficiency, adaptability, and long-term infrastructure performance.', 4, 1),
(9, 2, NULL, NULL, 'Mechanical Design', 'assets/images/services/mechanicaldesign1.jpeg', 'Our mechanical design services cover HVAC, plumbing, fire protection, and process systems, delivering integrated solutions that enhance energy efficiency, occupant comfort, and system reliability while aligning with project specifications and operational requirements across diverse facility types.', 'Integrated mechanical systems improve efficiency, reduce energy costs, and ensure comfortable, safe, and reliable building operations.', 5, 1),
(10, 3, NULL, NULL, 'Building & Structural Design', NULL, NULL, NULL, 0, 1),
(11, 3, 10, NULL, 'Building Design', 'assets/images/projects/07-kabul-1.png', 'We deliver full-cycle structural design for residential, commercial, and mixed-use buildings, covering concept development through detailed engineering to tender documentation, ensuring safety, efficiency, and adaptability while aligning with project requirements, site conditions, and long-term performance expectations.', 'Our designs ensure safety, cost efficiency, and adaptability, creating structures that meet current needs while accommodating future expansion.', 0, 1),
(12, 3, 10, NULL, 'Airport Design', 'assets/images/services/airport-design.jpg', 'We provide specialised structural engineering for airport facilities including terminals, hangars, control towers, and airside pavements, ensuring compliance with aviation standards while delivering durable, efficient, and high-performance infrastructure capable of handling demanding operational and environmental conditions.', 'We deliver durable, compliant airport structures that meet strict aviation standards and support safe, efficient operations.', 1, 1),
(13, 3, 10, NULL, 'Building Retrofit', 'assets/images/services/building-retrofit.jpg', 'We assess and upgrade existing structures to meet current codes, improve performance, and extend service life, incorporating modern engineering solutions to enhance safety, functionality, and sustainability while preserving structural integrity and accommodating new usage or regulatory requirements.', 'Retrofitting enhances safety, extends asset life, and offers a sustainable, cost-effective alternative to complete reconstruction.', 2, 1),
(14, 3, NULL, NULL, 'Road, Rail & Bridge Design', NULL, NULL, NULL, 1, 1),
(15, 3, NULL, NULL, 'Power Transmission & Distribution', NULL, NULL, NULL, 2, 1),
(16, 3, NULL, NULL, 'HVAC & Plumbing Design', NULL, NULL, NULL, 3, 1),
(17, 3, NULL, NULL, 'Master Planning & Landscape Architecture', NULL, NULL, NULL, 4, 1),
(18, 3, NULL, NULL, 'Project Planning, Quality & Cost Management', NULL, NULL, NULL, 5, 1),
(19, 4, NULL, NULL, 'Project Management and Execution', 'assets/images/services/project-management.jpg', 'We provide comprehensive project management and execution services across the full project lifecycle, ensuring effective coordination of scope, schedule, cost, quality, and resources while maintaining alignment with client objectives, operational requirements, and industry standards for successful project delivery.', 'Our structured management systems improve coordination, reduce delays, and ensure projects are delivered safely, efficiently, and within budget.', 0, 1),
(20, 4, NULL, NULL, 'EPC Project Delivery', 'assets/images/services/epc-project.jpg', 'We deliver Engineering, Procurement, and Construction (EPC) solutions under a single-point responsibility model, integrating engineering design, procurement management, construction execution, and commissioning to streamline project delivery while ensuring quality, accountability, and efficient coordination across all project phases.', 'Single-source EPC delivery simplifies execution, reduces interface risks, and ensures consistent quality and accountability throughout the project lifecycle.', 1, 1),
(21, 4, NULL, NULL, 'EPCM & Owner\'s Engineer Services', 'assets/images/services/owners-engineer.jpg', 'We provide EPCM and Owner\'s Engineer services that represent client interests throughout project execution, overseeing engineering, procurement, construction, and contractor performance to ensure projects meet technical, financial, operational, and regulatory requirements while maintaining transparency and effective risk management.', 'Independent oversight enhances transparency, improves contractor performance, and ensures alignment with client expectations and project objectives.', 2, 1),
(22, 5, NULL, NULL, 'Procurement and Supply Chain Management', 'assets/images/services/procurement.jpg', 'We manage procurement and supply chain operations for complex industrial and infrastructure projects, ensuring timely sourcing of quality materials, equipment, and services while optimising costs, managing logistics, and maintaining supply continuity throughout project execution phases.', 'Efficient procurement and logistics reduce delays, improve cost control, and ensure reliable access to critical project resources.', 0, 1),
(23, 5, NULL, NULL, 'Logistics and Material Management', 'assets/images/services/logistics.jpg', 'We coordinate transportation, warehousing, customs clearance, and material handling processes to ensure efficient delivery and management of project equipment and materials, minimising disruptions while supporting smooth site operations and construction activities.', 'Well-managed logistics improve delivery reliability, reduce downtime, and support uninterrupted project execution across remote and challenging locations.', 1, 1),
(24, 5, NULL, NULL, 'Vendor and Contract Management', 'assets/images/services/vendor-management.jpg', 'We administer supplier and contractor agreements throughout procurement and execution stages, ensuring compliance with contractual obligations, performance standards, schedules, and quality requirements while supporting transparent communication and dispute resolution processes.', 'Strong contract management improves accountability, minimises commercial risks, and strengthens supplier and contractor performance.', 2, 1),
(25, 6, NULL, NULL, 'Construction and Site Development', 'assets/images/services/construction-site.jpg', 'We execute civil, structural, mechanical, and infrastructure construction works for industrial, mining, and commercial projects, ensuring safe, efficient, and high-quality delivery through disciplined site management, skilled supervision, and compliance with engineering and regulatory standards.', 'Our construction expertise ensures quality execution, improved safety performance, and reliable project delivery under demanding site conditions.', 0, 1),
(26, 6, NULL, NULL, 'Earthworks and Infrastructure Development', 'assets/images/services/earthworks.jpg', 'We perform bulk earthworks, grading, roadworks, drainage installation, and supporting infrastructure development to prepare and optimise project sites for construction and operations while ensuring stability, accessibility, and long-term operational performance.', 'Proper site preparation improves construction efficiency, reduces operational risks, and supports durable infrastructure performance.', 1, 1),
(27, 6, NULL, NULL, 'Mechanical and Plant Installation', 'assets/images/services/plant-installation.jpg', 'We install industrial process equipment, mechanical systems, piping networks, and supporting plant infrastructure, ensuring accurate alignment, reliable operation, and integration with electrical, control, and structural systems across industrial and mining facilities.', 'Precise installation improves operational reliability, minimises commissioning issues, and supports long-term plant efficiency.', 2, 1),
(28, 7, NULL, NULL, 'Testing and Validation', 'assets/images/services/testing-validation.jpg', 'We perform comprehensive testing and validation of mechanical, electrical, instrumentation, and control systems to verify functionality, safety, compliance, and operational performance before commissioning and final project handover across industrial, infrastructure, and energy facilities.', 'Thorough testing identifies issues early, improves system reliability, and ensures equipment and installations meet operational and regulatory requirements.', 0, 1),
(29, 7, NULL, NULL, 'Commissioning and Start-Up', 'assets/images/services/commissioning.jpg', 'We manage commissioning and start-up activities to ensure systems, equipment, and operational processes are safely integrated, tested, and transitioned into full operational service while achieving performance targets, operational reliability, and compliance with project specifications.', 'Structured commissioning minimises start-up risks, accelerates operational readiness, and ensures stable, efficient facility performance.', 1, 1),
(30, 7, NULL, NULL, 'Operational Readiness and Handover', 'assets/images/services/operational-readiness.jpg', 'We prepare operational teams and facilities for seamless transition into production by developing procedures, maintenance systems, training programmes, and asset documentation that support safe, efficient, and sustainable long-term operations.', 'Effective readiness planning ensures smooth handover, improves operational safety, and enhances long-term asset reliability and performance.', 2, 1),
(31, 7, NULL, NULL, 'Integrated EPC+O Solutions', 'assets/images/services/epco.jpg', 'We deliver integrated EPC+O solutions that extend responsibility beyond project execution into operations, maintenance, and performance optimisation, ensuring continuity, improved operational efficiency, and long-term asset value throughout the facility lifecycle.', 'Integrated execution and operations support improve continuity, reduce operational risks, and maximise long-term project and asset performance.', 3, 1),
(32, 8, NULL, NULL, 'Digital Project Management and Smart Delivery', 'assets/images/services/digital-project.jpg', 'We implement advanced digital technologies, real-time monitoring systems, BIM platforms, and data-driven management tools to improve project visibility, collaboration, forecasting, and decision-making throughout engineering, procurement, construction, and operational phases.', 'Digital solutions improve efficiency, enhance coordination, and enable proactive management of project risks and performance.', 0, 1),
(33, 8, NULL, NULL, 'Quality Assurance and Control', 'assets/images/services/quality-control.jpg', 'We implement quality assurance and quality control systems across all project phases to ensure materials, workmanship, processes, and deliverables comply with technical specifications, regulatory requirements, and international quality standards.', 'Strong quality systems reduce defects, minimise rework, and ensure consistent delivery of reliable project outcomes.', 1, 1),
(34, 8, NULL, NULL, 'Health, Safety and ESG Compliance', 'assets/images/services/hse.jpg', 'We develop and implement integrated health, safety, environmental, and ESG management systems that promote safe working environments, regulatory compliance, environmental protection, and responsible project delivery across all operational and construction activities.', 'Effective HSE and ESG systems protect personnel, reduce operational risks, and support sustainable, responsible project execution.', 2, 1),
(49, 13, NULL, NULL, 'Consulting and Advisory Services', 'assets/images/services/consulting.jpg', 'Arya mineral render consultancy services to the mining and mega infrastructural projects. The scope of our services includes prospection and exploration of mineral resources; provide trainings in mining optimization techniques, environmental and social assessments of mining and infrastructural projects. With our team of professional and experienced geologists and our management, we provide the contemporary exploration, mining facilities to our clients in consideration to their requirements.', 'tobe added', 0, 1),
(50, 13, NULL, 'consulting', 'Consulting and Advisory Services', NULL, 'At Arya Mineral, we provide professional consulting and advisory services for mining and major infrastructure projects. Our experienced team provides practical solutions tailored to each client’s project requirements. For more information kindly read the official website: https://aryamineral.com/', '1. Experienced Team, \r\n2. Tailored Solutions, \r\n3. Practical Expertise, \r\n4. Comprehensive Support, \r\n5. Sustainable Approach', 0, 1),
(51, 13, NULL, NULL, 'abc', NULL, NULL, NULL, 1, 1),
(52, 13, 49, NULL, 'aaa', NULL, NULL, NULL, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `setting_key` varchar(150) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_type` enum('text','textarea','url','email','phone','image','document','boolean','number') NOT NULL DEFAULT 'text',
  `description` varchar(255) DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `setting_key`, `setting_value`, `setting_type`, `description`, `updated_by`, `updated_at`) VALUES
(1, 'homepage_why_background', 'assets/images/home/whybg1.jpg', 'image', 'Homepage Why State Corps background image', NULL, '2026-09-06 19:06:12'),
(2, 'projects_hero_background', 'assets/images/slider_04.jpg', 'image', 'Projects page hero background image', NULL, '2026-09-08 10:21:07'),
(3, 'projects_hero_title', 'Turning Ambition Into <span>Lasting</span> Impact', 'text', 'Projects page hero title; existing frontend intentionally renders this as HTML', NULL, '2026-09-08 10:21:07'),
(4, 'projects_hero_subtitle', 'Delivering infrastructure, power & energy, mining, and development projects across regions.', 'textarea', 'Projects page hero subtitle', NULL, '2026-09-08 10:21:07'),
(5, 'projects_hero_stat_1_count', '100+', 'text', 'Projects hero statistic 1 value', NULL, '2026-09-08 10:21:07'),
(6, 'projects_hero_stat_1_label', 'Completed Projects', 'text', 'Projects hero statistic 1 label', NULL, '2026-09-08 10:21:07'),
(7, 'projects_hero_stat_2_count', '100%', 'text', 'Projects hero statistic 2 value', NULL, '2026-09-08 10:21:07'),
(8, 'projects_hero_stat_2_label', 'On Time Delivery', 'text', 'Projects hero statistic 2 label', NULL, '2026-09-08 10:21:07'),
(9, 'projects_hero_stat_3_count', '99% +', 'text', 'Projects hero statistic 3 value', NULL, '2026-09-08 10:21:07'),
(10, 'projects_hero_stat_3_label', 'Accuracy', 'text', 'Projects hero statistic 3 label', NULL, '2026-09-08 10:21:07'),
(11, 'home_stats_background', 'assets/images/home/whybg1.jpg', 'image', 'Homepage statistics background image', NULL, '2026-09-10 12:23:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `display_name` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','editor') NOT NULL DEFAULT 'editor',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `last_login_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `display_name`, `password_hash`, `role`, `status`, `last_login_at`, `created_at`, `updated_at`) VALUES
(1, 'afs@sc.w', 'SC Web Admin', '$2y$10$ZuxAzm0oSb.LvP2XJ3E2V.zAyAtL.JAXA.CmOw1Y/MUrV9bUqPQ8a', 'admin', 'active', '2026-09-10 14:43:07', '2026-09-06 20:35:45', '2026-09-10 14:43:07'),
(2, 'demo1', 'Demo1', '$2y$10$eIqGT37rzyCmeogrbFUrguZGBYmLr/bEmyxzRLYDE03dnhhSR2Kte', 'editor', 'active', '2026-09-09 20:07:19', '2026-09-07 09:46:04', '2026-09-09 20:07:19');

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

CREATE TABLE `user_permissions` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_permissions`
--

INSERT INTO `user_permissions` (`user_id`, `permission_id`) VALUES
(2, 1),
(2, 3),
(2, 4),
(2, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_affiliated_companies`
--
ALTER TABLE `about_affiliated_companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `about_awards`
--
ALTER TABLE `about_awards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `about_certificates`
--
ALTER TABLE `about_certificates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `about_clients`
--
ALTER TABLE `about_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_about_clients_order` (`sort_order`);

--
-- Indexes for table `about_company_profile`
--
ALTER TABLE `about_company_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `about_core_values`
--
ALTER TABLE `about_core_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_about_values_order` (`sort_order`);

--
-- Indexes for table `about_general`
--
ALTER TABLE `about_general`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `about_history`
--
ALTER TABLE `about_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_about_history_order` (`sort_order`);

--
-- Indexes for table `about_hse`
--
ALTER TABLE `about_hse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `about_mission_vision`
--
ALTER TABLE `about_mission_vision`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `about_page`
--
ALTER TABLE `about_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `about_sections`
--
ALTER TABLE `about_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `legacy_id` (`legacy_id`);

--
-- Indexes for table `about_sister_companies`
--
ALTER TABLE `about_sister_companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_about_sister_order` (`sort_order`,`id`);

--
-- Indexes for table `about_timeline`
--
ALTER TABLE `about_timeline`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_about_timeline_order` (`sort_order`,`id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_audit_user` (`user_id`),
  ADD KEY `idx_audit_entity` (`entity_type`,`entity_id`),
  ADD KEY `idx_audit_created` (`created_at`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_contact_status` (`status`),
  ADD KEY `idx_contact_created` (`created_at`);

--
-- Indexes for table `content_revisions`
--
ALTER TABLE `content_revisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_revision_entity` (`entity_type`,`entity_id`),
  ADD KEY `idx_revision_user` (`user_id`),
  ADD KEY `idx_revision_created` (`created_at`);

--
-- Indexes for table `home_hero_slides`
--
ALTER TABLE `home_hero_slides`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_home_hero_legacy_id` (`legacy_id`),
  ADD KEY `idx_home_hero_order` (`sort_order`),
  ADD KEY `idx_home_hero_active` (`is_active`);

--
-- Indexes for table `home_history`
--
ALTER TABLE `home_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_home_history_order` (`sort_order`);

--
-- Indexes for table `home_stats`
--
ALTER TABLE `home_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_home_stats_order` (`sort_order`);

--
-- Indexes for table `home_why_items`
--
ALTER TABLE `home_why_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_home_why_items_tab` (`tab_id`);

--
-- Indexes for table `home_why_tabs`
--
ALTER TABLE `home_why_tabs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_home_why_legacy_id` (`legacy_id`);

--
-- Indexes for table `legal_documents`
--
ALTER TABLE `legal_documents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_legal_document_key` (`document_key`);

--
-- Indexes for table `legal_sections`
--
ALTER TABLE `legal_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_legal_sections_document` (`document_id`);

--
-- Indexes for table `legal_section_items`
--
ALTER TABLE `legal_section_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_legal_section_items_section` (`section_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_login_attempts_username` (`username`,`attempted_at`),
  ADD KEY `idx_login_attempts_ip` (`ip_address`,`attempted_at`),
  ADD KEY `idx_login_attempts_time` (`attempted_at`);

--
-- Indexes for table `media_descriptions`
--
ALTER TABLE `media_descriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_media_descriptions_item` (`media_item_id`);

--
-- Indexes for table `media_items`
--
ALTER TABLE `media_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_media_legacy_id` (`legacy_id`),
  ADD KEY `idx_media_type` (`media_type`),
  ADD KEY `idx_media_date` (`media_date_sort`),
  ADD KEY `idx_media_order` (`sort_order`);

--
-- Indexes for table `media_item_tags`
--
ALTER TABLE `media_item_tags`
  ADD PRIMARY KEY (`media_item_id`,`tag_id`),
  ADD KEY `fk_media_item_tags_tag` (`tag_id`);

--
-- Indexes for table `media_tags`
--
ALTER TABLE `media_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_media_tag_name` (`tag_name`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_permissions_key` (`permission_key`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_projects_slug` (`slug`),
  ADD UNIQUE KEY `uq_projects_legacy_id` (`legacy_id`),
  ADD KEY `idx_projects_sector` (`sector_name`),
  ADD KEY `idx_projects_category` (`category`),
  ADD KEY `idx_projects_status` (`status`),
  ADD KEY `idx_projects_home` (`show_on_home`),
  ADD KEY `idx_projects_sort` (`sort_order`);

--
-- Indexes for table `project_images`
--
ALTER TABLE `project_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_project_images_project` (`project_id`),
  ADD KEY `idx_project_images_order` (`project_id`,`sort_order`);

--
-- Indexes for table `project_scope`
--
ALTER TABLE `project_scope`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_project_scope_project` (`project_id`);

--
-- Indexes for table `sectors`
--
ALTER TABLE `sectors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_sector_key` (`sector_key`),
  ADD KEY `idx_sector_order` (`sort_order`);

--
-- Indexes for table `sector_areas`
--
ALTER TABLE `sector_areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sector_areas_sector` (`sector_id`);

--
-- Indexes for table `sector_sections`
--
ALTER TABLE `sector_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_sector_section_legacy` (`sector_id`,`legacy_id`),
  ADD KEY `idx_sector_sections_sector` (`sector_id`);

--
-- Indexes for table `sector_section_images`
--
ALTER TABLE `sector_section_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sector_section_images_section` (`section_id`);

--
-- Indexes for table `sector_section_stats`
--
ALTER TABLE `sector_section_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sector_section_stats_section` (`section_id`);

--
-- Indexes for table `sector_stats`
--
ALTER TABLE `sector_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sector_stats_sector` (`sector_id`);

--
-- Indexes for table `sector_why`
--
ALTER TABLE `sector_why`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sector_why_sector` (`sector_id`);

--
-- Indexes for table `service_categories`
--
ALTER TABLE `service_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_service_categories_group` (`group_id`);

--
-- Indexes for table `service_features`
--
ALTER TABLE `service_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_service_features_item` (`service_item_id`);

--
-- Indexes for table `service_groups`
--
ALTER TABLE `service_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_service_group_key` (`service_key`);

--
-- Indexes for table `service_items`
--
ALTER TABLE `service_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_service_items_category` (`category_id`),
  ADD KEY `idx_service_items_parent` (`parent_id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_setting_key` (`setting_key`),
  ADD KEY `fk_settings_user` (`updated_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_users_username` (`username`),
  ADD KEY `idx_users_role` (`role`),
  ADD KEY `idx_users_status` (`status`);

--
-- Indexes for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`user_id`,`permission_id`),
  ADD KEY `fk_user_permissions_permission` (`permission_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_affiliated_companies`
--
ALTER TABLE `about_affiliated_companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `about_awards`
--
ALTER TABLE `about_awards`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `about_certificates`
--
ALTER TABLE `about_certificates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `about_clients`
--
ALTER TABLE `about_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `about_core_values`
--
ALTER TABLE `about_core_values`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `about_history`
--
ALTER TABLE `about_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `about_sections`
--
ALTER TABLE `about_sections`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `about_sister_companies`
--
ALTER TABLE `about_sister_companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `about_timeline`
--
ALTER TABLE `about_timeline`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `content_revisions`
--
ALTER TABLE `content_revisions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `home_hero_slides`
--
ALTER TABLE `home_hero_slides`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `home_history`
--
ALTER TABLE `home_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `home_stats`
--
ALTER TABLE `home_stats`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `home_why_items`
--
ALTER TABLE `home_why_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `home_why_tabs`
--
ALTER TABLE `home_why_tabs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `legal_documents`
--
ALTER TABLE `legal_documents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `legal_sections`
--
ALTER TABLE `legal_sections`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `legal_section_items`
--
ALTER TABLE `legal_section_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `media_descriptions`
--
ALTER TABLE `media_descriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `media_items`
--
ALTER TABLE `media_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `media_tags`
--
ALTER TABLE `media_tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `project_images`
--
ALTER TABLE `project_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `project_scope`
--
ALTER TABLE `project_scope`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `sectors`
--
ALTER TABLE `sectors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sector_areas`
--
ALTER TABLE `sector_areas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `sector_sections`
--
ALTER TABLE `sector_sections`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sector_section_images`
--
ALTER TABLE `sector_section_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `sector_section_stats`
--
ALTER TABLE `sector_section_stats`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `sector_stats`
--
ALTER TABLE `sector_stats`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `sector_why`
--
ALTER TABLE `sector_why`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `service_categories`
--
ALTER TABLE `service_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `service_features`
--
ALTER TABLE `service_features`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `service_groups`
--
ALTER TABLE `service_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `service_items`
--
ALTER TABLE `service_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `fk_audit_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `content_revisions`
--
ALTER TABLE `content_revisions`
  ADD CONSTRAINT `fk_revision_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `home_why_items`
--
ALTER TABLE `home_why_items`
  ADD CONSTRAINT `fk_home_why_items_tab` FOREIGN KEY (`tab_id`) REFERENCES `home_why_tabs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `legal_sections`
--
ALTER TABLE `legal_sections`
  ADD CONSTRAINT `fk_legal_sections_document` FOREIGN KEY (`document_id`) REFERENCES `legal_documents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `legal_section_items`
--
ALTER TABLE `legal_section_items`
  ADD CONSTRAINT `fk_legal_section_items_section` FOREIGN KEY (`section_id`) REFERENCES `legal_sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `media_descriptions`
--
ALTER TABLE `media_descriptions`
  ADD CONSTRAINT `fk_media_descriptions_item` FOREIGN KEY (`media_item_id`) REFERENCES `media_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `media_item_tags`
--
ALTER TABLE `media_item_tags`
  ADD CONSTRAINT `fk_media_item_tags_media` FOREIGN KEY (`media_item_id`) REFERENCES `media_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_media_item_tags_tag` FOREIGN KEY (`tag_id`) REFERENCES `media_tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_images`
--
ALTER TABLE `project_images`
  ADD CONSTRAINT `fk_project_images_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_scope`
--
ALTER TABLE `project_scope`
  ADD CONSTRAINT `fk_project_scope_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sector_areas`
--
ALTER TABLE `sector_areas`
  ADD CONSTRAINT `fk_sector_areas_sector` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sector_sections`
--
ALTER TABLE `sector_sections`
  ADD CONSTRAINT `fk_sector_sections_sector` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sector_section_images`
--
ALTER TABLE `sector_section_images`
  ADD CONSTRAINT `fk_sector_section_images_section` FOREIGN KEY (`section_id`) REFERENCES `sector_sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sector_section_stats`
--
ALTER TABLE `sector_section_stats`
  ADD CONSTRAINT `fk_sector_section_stats_section` FOREIGN KEY (`section_id`) REFERENCES `sector_sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sector_stats`
--
ALTER TABLE `sector_stats`
  ADD CONSTRAINT `fk_sector_stats_sector` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sector_why`
--
ALTER TABLE `sector_why`
  ADD CONSTRAINT `fk_sector_why_sector` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_categories`
--
ALTER TABLE `service_categories`
  ADD CONSTRAINT `fk_service_categories_group` FOREIGN KEY (`group_id`) REFERENCES `service_groups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_features`
--
ALTER TABLE `service_features`
  ADD CONSTRAINT `fk_service_features_item` FOREIGN KEY (`service_item_id`) REFERENCES `service_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_items`
--
ALTER TABLE `service_items`
  ADD CONSTRAINT `fk_service_items_category` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_service_items_parent` FOREIGN KEY (`parent_id`) REFERENCES `service_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD CONSTRAINT `fk_settings_user` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD CONSTRAINT `fk_user_permissions_permission` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_permissions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
