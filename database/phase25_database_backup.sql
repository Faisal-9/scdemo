-- Phase 25 — Database Backup Center
-- Non-destructive migration. Adds a permission only if missing.

INSERT INTO permissions (permission_key, permission_name, description)
SELECT 'manage_database_backups', 'Manage database backups', 'Inspect and export CMS database backups'
WHERE NOT EXISTS (
    SELECT 1 FROM permissions WHERE permission_key = 'manage_database_backups'
);
