-- State Corps Phase 21: Activity Logs - corrected permission schema
-- Existing audit_logs table is used. No log data is deleted or modified.

INSERT INTO permissions (permission_key, permission_name, description)
SELECT 'manage_activity_logs', 'Manage Activity Logs', 'View CMS activity and audit logs.'
WHERE NOT EXISTS (
    SELECT 1
    FROM permissions
    WHERE permission_key = 'manage_activity_logs'
);

-- Add useful indexes only when they do not already exist.
SET @db := DATABASE();

SET @sql := (
    SELECT IF(
        EXISTS (
            SELECT 1 FROM information_schema.statistics
            WHERE table_schema=@db AND table_name='audit_logs'
              AND index_name='idx_audit_logs_created_at'
        ),
        'SELECT 1',
        'CREATE INDEX idx_audit_logs_created_at ON audit_logs (created_at, id)'
    )
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql := (
    SELECT IF(
        EXISTS (
            SELECT 1 FROM information_schema.statistics
            WHERE table_schema=@db AND table_name='audit_logs'
              AND index_name='idx_audit_logs_action'
        ),
        'SELECT 1',
        'CREATE INDEX idx_audit_logs_action ON audit_logs (action, created_at, id)'
    )
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql := (
    SELECT IF(
        EXISTS (
            SELECT 1 FROM information_schema.statistics
            WHERE table_schema=@db AND table_name='audit_logs'
              AND index_name='idx_audit_logs_entity'
        ),
        'SELECT 1',
        'CREATE INDEX idx_audit_logs_entity ON audit_logs (entity_type, entity_id, created_at, id)'
    )
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql := (
    SELECT IF(
        EXISTS (
            SELECT 1 FROM information_schema.statistics
            WHERE table_schema=@db AND table_name='audit_logs'
              AND index_name='idx_audit_logs_user'
        ),
        'SELECT 1',
        'CREATE INDEX idx_audit_logs_user ON audit_logs (user_id, created_at, id)'
    )
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql := (
    SELECT IF(
        EXISTS (
            SELECT 1 FROM information_schema.statistics
            WHERE table_schema=@db AND table_name='audit_logs'
              AND index_name='idx_audit_logs_ip'
        ),
        'SELECT 1',
        'CREATE INDEX idx_audit_logs_ip ON audit_logs (ip_address, created_at, id)'
    )
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
