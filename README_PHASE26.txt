PHASE 26 — SECURE BACKUP VAULT

Adds a single admin module for retained database backups:
/scadmin/backup-vault/index.php

Features:
- saved full/schema SQL backups
- metadata and SHA-256 checksum
- integrity status
- authenticated download
- CSRF-protected deletion
- private storage outside publicV6 by default
- integrates with existing Phase 25 Database Backup Center
