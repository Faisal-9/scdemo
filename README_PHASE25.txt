STATE CORPS CMS — PHASE 25
DATABASE BACKUP CENTER

Purpose
-------
Adds an admin-only database inspection and SQL export center. The backup is streamed directly to the browser and does not depend on shell access, mysqldump, Composer, Laravel, or Node.

New files
---------
app/core/DatabaseBackupManager.php
scadmin/database-backup/index.php
scadmin/database-backup/export.php
database/phase25_database_backup.sql
PHASE25_INSTRUCTIONS.txt

Key behavior
------------
- Read-only inspection of the current database.
- Full SQL backup: schema + data.
- Schema-only backup: schema without table rows.
- Streams the backup to the browser instead of storing it in the web root.
- Records the export action in the existing audit log when available.
- Uses PDO and SHOW CREATE TABLE / SELECT; no mysqldump requirement.

No public frontend changes.
No existing content is modified.
No table is dropped during installation.
