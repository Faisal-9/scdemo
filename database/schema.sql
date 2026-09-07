-- ============================================================
-- STATE CORPS CMS
-- Phase 1 - Database Schema
-- Plain PHP + MySQL/MariaDB
-- ============================================================

CREATE DATABASE IF NOT EXISTS statecorps_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE statecorps_db;

SET NAMES utf8mb4;

-- ============================================================
-- 1. SYSTEM / USERS
-- ============================================================

CREATE TABLE users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL,
    display_name VARCHAR(150) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor') NOT NULL DEFAULT 'editor',
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    last_login_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY uq_users_username (username),
    KEY idx_users_role (role),
    KEY idx_users_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE permissions (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    permission_key VARCHAR(100) NOT NULL,
    permission_name VARCHAR(150) NOT NULL,
    description VARCHAR(255) NULL,

    PRIMARY KEY (id),
    UNIQUE KEY uq_permissions_key (permission_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE user_permissions (
    user_id INT UNSIGNED NOT NULL,
    permission_id INT UNSIGNED NOT NULL,

    PRIMARY KEY (user_id, permission_id),

    CONSTRAINT fk_user_permissions_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_user_permissions_permission
        FOREIGN KEY (permission_id)
        REFERENCES permissions(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE audit_logs (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id INT UNSIGNED NULL,
    action VARCHAR(100) NOT NULL,
    entity_type VARCHAR(100) NULL,
    entity_id BIGINT UNSIGNED NULL,
    description TEXT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent VARCHAR(500) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    KEY idx_audit_user (user_id),
    KEY idx_audit_entity (entity_type, entity_id),
    KEY idx_audit_created (created_at),

    CONSTRAINT fk_audit_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- 2. GLOBAL WEBSITE SETTINGS
-- ============================================================

CREATE TABLE site_settings (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    setting_key VARCHAR(150) NOT NULL,
    setting_value TEXT NULL,
    setting_type ENUM(
        'text',
        'textarea',
        'url',
        'email',
        'phone',
        'image',
        'document',
        'boolean',
        'number'
    ) NOT NULL DEFAULT 'text',
    description VARCHAR(255) NULL,
    updated_by INT UNSIGNED NULL,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY uq_setting_key (setting_key),

    CONSTRAINT fk_settings_user
        FOREIGN KEY (updated_by)
        REFERENCES users(id)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- 3. HOMEPAGE
-- ============================================================

CREATE TABLE home_hero_slides (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    legacy_id VARCHAR(100) NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    image_path VARCHAR(500) NOT NULL,
    indicator VARCHAR(255) NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,

    PRIMARY KEY (id),
    UNIQUE KEY uq_home_hero_legacy_id (legacy_id),
    KEY idx_home_hero_order (sort_order),
    KEY idx_home_hero_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE home_stats (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    prefix VARCHAR(20) NULL,
    number_value DECIMAL(15,2) NOT NULL,
    suffix VARCHAR(50) NULL,
    label VARCHAR(255) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,

    PRIMARY KEY (id),
    KEY idx_home_stats_order (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE home_history (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    year VARCHAR(20) NOT NULL,
    title VARCHAR(255) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,

    PRIMARY KEY (id),
    KEY idx_home_history_order (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE home_why_tabs (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    legacy_id VARCHAR(20) NULL,
    tab_name VARCHAR(255) NOT NULL,
    title VARCHAR(255) NULL,
    image_path VARCHAR(500) NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,

    PRIMARY KEY (id),
    UNIQUE KEY uq_home_why_legacy_id (legacy_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE home_why_items (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    tab_id INT UNSIGNED NOT NULL,
    item_text TEXT NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,

    PRIMARY KEY (id),
    KEY idx_home_why_items_tab (tab_id),

    CONSTRAINT fk_home_why_items_tab
        FOREIGN KEY (tab_id)
        REFERENCES home_why_tabs(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- 4. ABOUT PAGE
-- ============================================================

CREATE TABLE about_page (
    id TINYINT UNSIGNED NOT NULL DEFAULT 1,

    overview_title VARCHAR(255) NOT NULL,
    overview_content LONGTEXT NOT NULL,

    mission_title VARCHAR(255) NOT NULL,
    mission TEXT NOT NULL,
    mission_image VARCHAR(500) NULL,

    vision TEXT NOT NULL,
    vision_image VARCHAR(500) NULL,

    core_values_image VARCHAR(500) NULL,

    clients_title VARCHAR(255) NULL,
    certificates_title VARCHAR(255) NULL,
    awards_title VARCHAR(255) NULL,
    affiliated_companies_title VARCHAR(255) NULL,

    hse_title VARCHAR(255) NULL,
    hse_content LONGTEXT NULL,

    company_profile_title VARCHAR(255) NULL,
    company_profile_content LONGTEXT NULL,
    company_profile_file VARCHAR(500) NULL,

    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE about_history (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    year VARCHAR(20) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    image_path VARCHAR(500) NULL,
    sort_order INT NOT NULL DEFAULT 0,

    PRIMARY KEY (id),
    KEY idx_about_history_order (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE about_core_values (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    value_text TEXT NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,

    PRIMARY KEY (id),
    KEY idx_about_values_order (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE about_clients (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NULL,
    logo_path VARCHAR(500) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,

    PRIMARY KEY (id),
    KEY idx_about_clients_order (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE about_certificates (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    logo_path VARCHAR(500) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,

    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE about_awards (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    logo_path VARCHAR(500) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,

    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE about_affiliated_companies (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    logo_path VARCHAR(500) NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,

    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- 5. PROJECTS
-- ============================================================

CREATE TABLE projects (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,

    legacy_id VARCHAR(50) NULL,

    name VARCHAR(500) NOT NULL,
    slug VARCHAR(500) NOT NULL,

    sector_name VARCHAR(255) NULL,
    category VARCHAR(255) NULL,

    status VARCHAR(100) NULL,
    completion_year SMALLINT UNSIGNED NULL,

    location VARCHAR(255) NULL,
    client VARCHAR(255) NULL,

    description LONGTEXT NULL,

    show_on_home TINYINT(1) NOT NULL DEFAULT 0,
    show_in_category_image TINYINT(1) NOT NULL DEFAULT 0,

    thumbnail_path VARCHAR(500) NULL,

    published TINYINT(1) NOT NULL DEFAULT 1,
    sort_order INT NOT NULL DEFAULT 0,

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY uq_projects_legacy_id (legacy_id),
    UNIQUE KEY uq_projects_slug (slug),
    KEY idx_projects_sector (sector_name),
    KEY idx_projects_category (category),
    KEY idx_projects_status (status),
    KEY idx_projects_home (show_on_home),
    KEY idx_projects_sort (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE project_images (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_id INT UNSIGNED NOT NULL,
    image_path VARCHAR(500) NOT NULL,
    alt_text VARCHAR(255) NULL,
    caption VARCHAR(500) NULL,
    sort_order INT NOT NULL DEFAULT 0,

    PRIMARY KEY (id),
    KEY idx_project_images_project (project_id),
    KEY idx_project_images_order (project_id, sort_order),

    CONSTRAINT fk_project_images_project
        FOREIGN KEY (project_id)
        REFERENCES projects(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE project_scope (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_id INT UNSIGNED NOT NULL,
    scope_text TEXT NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,

    PRIMARY KEY (id),
    KEY idx_project_scope_project (project_id),

    CONSTRAINT fk_project_scope_project
        FOREIGN KEY (project_id)
        REFERENCES projects(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- 6. SECTORS
-- ============================================================

CREATE TABLE sectors (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,

    sector_key VARCHAR(100) NOT NULL,
    title VARCHAR(255) NOT NULL,

    description LONGTEXT NULL,

    hero_tag VARCHAR(255) NULL,
    hero_headline VARCHAR(500) NULL,
    hero_subtitle VARCHAR(500) NULL,
    hero_cta_text VARCHAR(255) NULL,
    hero_cta_link VARCHAR(500) NULL,
    hero_image VARCHAR(500) NULL,

    featured_project_name VARCHAR(500) NULL,
    featured_project_image VARCHAR(500) NULL,
    featured_project_cta_text VARCHAR(255) NULL,
    featured_project_cta_link VARCHAR(500) NULL,

    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,

    PRIMARY KEY (id),
    UNIQUE KEY uq_sector_key (sector_key),
    KEY idx_sector_order (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE sector_stats (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    sector_id INT UNSIGNED NOT NULL,
    value_text VARCHAR(100) NOT NULL,
    label VARCHAR(255) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,

    PRIMARY KEY (id),

    CONSTRAINT fk_sector_stats_sector
        FOREIGN KEY (sector_id)
        REFERENCES sectors(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE sector_why (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    sector_id INT UNSIGNED NOT NULL,
    text_content TEXT NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,

    PRIMARY KEY (id),

    CONSTRAINT fk_sector_why_sector
        FOREIGN KEY (sector_id)
        REFERENCES sectors(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE sector_areas (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    sector_id INT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,

    PRIMARY KEY (id),

    CONSTRAINT fk_sector_areas_sector
        FOREIGN KEY (sector_id)
        REFERENCES sectors(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE sector_sections (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    sector_id INT UNSIGNED NOT NULL,

    legacy_id VARCHAR(100) NULL,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(255) NULL,
    content LONGTEXT NULL,

    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,

    PRIMARY KEY (id),
    UNIQUE KEY uq_sector_section_legacy (sector_id, legacy_id),
    KEY idx_sector_sections_sector (sector_id),

    CONSTRAINT fk_sector_sections_sector
        FOREIGN KEY (sector_id)
        REFERENCES sectors(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE sector_section_images (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    section_id INT UNSIGNED NOT NULL,
    image_path VARCHAR(500) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,

    PRIMARY KEY (id),

    CONSTRAINT fk_sector_section_images_section
        FOREIGN KEY (section_id)
        REFERENCES sector_sections(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE sector_section_stats (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    section_id INT UNSIGNED NOT NULL,
    value_text VARCHAR(100) NOT NULL,
    label VARCHAR(255) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,

    PRIMARY KEY (id),

    CONSTRAINT fk_sector_section_stats_section
        FOREIGN KEY (section_id)
        REFERENCES sector_sections(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- 7. SERVICES
-- ============================================================

CREATE TABLE service_groups (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,

    service_key VARCHAR(150) NOT NULL,
    title VARCHAR(255) NOT NULL,
    hero_image VARCHAR(500) NULL,
    hero_text LONGTEXT NULL,

    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,

    PRIMARY KEY (id),
    UNIQUE KEY uq_service_group_key (service_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE service_categories (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,

    group_id INT UNSIGNED NOT NULL,
    category_key VARCHAR(150) NULL,
    title VARCHAR(255) NOT NULL,

    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,

    PRIMARY KEY (id),
    KEY idx_service_categories_group (group_id),

    CONSTRAINT fk_service_categories_group
        FOREIGN KEY (group_id)
        REFERENCES service_groups(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE service_items (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,

    category_id INT UNSIGNED NOT NULL,

    service_key VARCHAR(150) NULL,
    title VARCHAR(500) NOT NULL,
    image_path VARCHAR(500) NULL,

    short_description LONGTEXT NULL,
    why_description LONGTEXT NULL,

    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,

    PRIMARY KEY (id),
    KEY idx_service_items_category (category_id),

    CONSTRAINT fk_service_items_category
        FOREIGN KEY (category_id)
        REFERENCES service_categories(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE service_features (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    service_item_id INT UNSIGNED NOT NULL,
    feature_text TEXT NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,

    PRIMARY KEY (id),

    CONSTRAINT fk_service_features_item
        FOREIGN KEY (service_item_id)
        REFERENCES service_items(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- 8. MEDIA
-- ============================================================

CREATE TABLE media_items (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,

    legacy_id VARCHAR(100) NULL,

    media_type ENUM('news', 'events', 'gallery') NOT NULL,

    media_date VARCHAR(100) NULL,
    media_date_sort DATE NULL,

    title VARCHAR(500) NOT NULL,
    image_path VARCHAR(500) NULL,
    external_link VARCHAR(1000) NULL,

    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY uq_media_legacy_id (legacy_id),
    KEY idx_media_type (media_type),
    KEY idx_media_date (media_date_sort),
    KEY idx_media_order (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE media_descriptions (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    media_item_id INT UNSIGNED NOT NULL,
    description_text LONGTEXT NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,

    PRIMARY KEY (id),

    CONSTRAINT fk_media_descriptions_item
        FOREIGN KEY (media_item_id)
        REFERENCES media_items(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE media_tags (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    tag_name VARCHAR(150) NOT NULL,

    PRIMARY KEY (id),
    UNIQUE KEY uq_media_tag_name (tag_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE media_item_tags (
    media_item_id INT UNSIGNED NOT NULL,
    tag_id INT UNSIGNED NOT NULL,

    PRIMARY KEY (media_item_id, tag_id),

    CONSTRAINT fk_media_item_tags_media
        FOREIGN KEY (media_item_id)
        REFERENCES media_items(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_media_item_tags_tag
        FOREIGN KEY (tag_id)
        REFERENCES media_tags(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- 9. LEGAL DOCUMENTS
--    Privacy / Whistleblower / Trademarks / Terms
-- ============================================================

CREATE TABLE legal_documents (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,

    document_key VARCHAR(100) NOT NULL,
    title VARCHAR(255) NOT NULL,

    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,

    PRIMARY KEY (id),
    UNIQUE KEY uq_legal_document_key (document_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE legal_sections (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,

    document_id INT UNSIGNED NOT NULL,
    title VARCHAR(500) NOT NULL,

    content LONGTEXT NULL,
    section_type ENUM('content', 'list') NOT NULL DEFAULT 'content',

    sort_order INT NOT NULL DEFAULT 0,

    PRIMARY KEY (id),

    CONSTRAINT fk_legal_sections_document
        FOREIGN KEY (document_id)
        REFERENCES legal_documents(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE legal_section_items (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,

    section_id INT UNSIGNED NOT NULL,
    item_text LONGTEXT NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,

    PRIMARY KEY (id),

    CONSTRAINT fk_legal_section_items_section
        FOREIGN KEY (section_id)
        REFERENCES legal_sections(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- 10. CONTACT MESSAGES
-- ============================================================

CREATE TABLE contact_messages (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(100) NULL,
    company VARCHAR(255) NULL,
    subject VARCHAR(500) NULL,
    message LONGTEXT NOT NULL,

    status ENUM('unread', 'read', 'archived') NOT NULL DEFAULT 'unread',

    ip_address VARCHAR(45) NULL,
    user_agent VARCHAR(500) NULL,

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    KEY idx_contact_status (status),
    KEY idx_contact_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- 11. CONTENT REVISIONS
-- ============================================================

CREATE TABLE content_revisions (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

    user_id INT UNSIGNED NULL,

    entity_type VARCHAR(100) NOT NULL,
    entity_id BIGINT UNSIGNED NOT NULL,

    revision_data LONGTEXT NOT NULL,

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),

    KEY idx_revision_entity (entity_type, entity_id),
    KEY idx_revision_user (user_id),
    KEY idx_revision_created (created_at),

    CONSTRAINT fk_revision_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- 12. INITIAL PERMISSION DEFINITIONS
-- ============================================================

INSERT INTO permissions
    (permission_key, permission_name, description)
VALUES
    (
        'manage_homepage',
        'Manage Homepage',
        'Edit homepage content'
    ),
    (
        'manage_about',
        'Manage About',
        'Edit About page content'
    ),
    (
        'manage_projects',
        'Manage Projects',
        'Create and edit projects'
    ),
    (
        'manage_services',
        'Manage Services',
        'Create and edit services'
    ),
    (
        'manage_sectors',
        'Manage Sectors',
        'Create and edit sectors'
    ),
    (
        'manage_media',
        'Manage Media',
        'Create and edit media'
    ),
    (
        'manage_legal',
        'Manage Policies and Terms',
        'Edit legal documents'
    ),
    (
        'manage_messages',
        'Manage Messages',
        'View and manage contact messages'
    ),
    (
        'manage_settings',
        'Manage Settings',
        'Edit global website settings'
    );


-- ============================================================
-- END
-- ============================================================