-- STATE CORPS CMS — PHASE 24 SYSTEM HEALTH
-- Non-destructive: adds one permission only. No content tables or records are changed.

INSERT INTO permissions (permission_key, permission_name, description)
SELECT 'manage_system_health', 'View System Health', 'View read-only CMS health diagnostics'
WHERE NOT EXISTS (
    SELECT 1 FROM permissions WHERE permission_key = 'manage_system_health'
);
