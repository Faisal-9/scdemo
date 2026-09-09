-- Phase 8 requires the Phase 1/2 service tables.
-- No new tables are required.
-- This file is intentionally informational so it can be safely imported.

USE statecorps_DB;

-- Ensure nested service items are supported.
SET @has_parent_id := (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'service_items'
      AND COLUMN_NAME = 'parent_id'
);

SET @sql := IF(
    @has_parent_id = 0,
    'ALTER TABLE service_items ADD COLUMN parent_id INT UNSIGNED NULL AFTER category_id',
    'SELECT 1'
);

PREPARE phase8_stmt FROM @sql;
EXECUTE phase8_stmt;
DEALLOCATE PREPARE phase8_stmt;

SET @has_parent_index := (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.STATISTICS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'service_items'
      AND INDEX_NAME = 'idx_service_items_parent'
);

SET @sql := IF(
    @has_parent_index = 0,
    'ALTER TABLE service_items ADD KEY idx_service_items_parent (parent_id)',
    'SELECT 1'
);

PREPARE phase8_stmt FROM @sql;
EXECUTE phase8_stmt;
DEALLOCATE PREPARE phase8_stmt;

SET @has_parent_fk := (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS
    WHERE CONSTRAINT_SCHEMA = DATABASE()
      AND TABLE_NAME = 'service_items'
      AND CONSTRAINT_NAME = 'fk_service_items_parent'
);

SET @sql := IF(
    @has_parent_fk = 0,
    'ALTER TABLE service_items ADD CONSTRAINT fk_service_items_parent FOREIGN KEY (parent_id) REFERENCES service_items(id) ON DELETE CASCADE',
    'SELECT 1'
);

PREPARE phase8_stmt FROM @sql;
EXECUTE phase8_stmt;
DEALLOCATE PREPARE phase8_stmt;
