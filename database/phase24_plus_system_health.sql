-- Phase 24 Plus — Extended System Health
-- Non-destructive: permission already introduced in Phase 24. Kept here as an idempotent safety check.
INSERT INTO permissions (permission_key, permission_name, description)
SELECT 'manage_system_health', 'View System Health', 'View read-only CMS health diagnostics'
WHERE NOT EXISTS (SELECT 1 FROM permissions WHERE permission_key = 'manage_system_health');
