-- Phase 27 — Unified Database Backup Center
-- Non-destructive. Keeps legacy permissions and metadata intact.

INSERT INTO permissions (permission_key, permission_name, description)
SELECT 'manage_backup_center', 'Manage database backup center', 'Create, download, verify, and manage CMS database backups'
WHERE NOT EXISTS (
    SELECT 1 FROM permissions WHERE permission_key = 'manage_backup_center'
);
