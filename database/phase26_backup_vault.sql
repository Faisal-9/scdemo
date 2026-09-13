-- Phase 26 — Secure Backup Vault
-- Non-destructive. Creates metadata only; backup files are created by the CMS.

CREATE TABLE IF NOT EXISTS `database_backups` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `backup_type` enum('full','schema') NOT NULL DEFAULT 'full',
  `size_bytes` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `sha256` char(64) NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_database_backups_filename` (`filename`),
  KEY `idx_database_backups_created_at` (`created_at`),
  KEY `idx_database_backups_created_by` (`created_by`),
  CONSTRAINT `fk_database_backups_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `permissions` (`permission_key`, `description`)
SELECT 'manage_backup_vault', 'Manage saved CMS database backups'
WHERE NOT EXISTS (
  SELECT 1 FROM `permissions` WHERE `permission_key` = 'manage_backup_vault'
);
