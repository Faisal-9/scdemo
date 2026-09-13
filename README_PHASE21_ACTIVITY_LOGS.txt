# Phase 21 - Activity Logs

This package replaces the deferred content-revisions UI with an Activity Logs module.

Existing database evidence shows audit_logs already contains CMS events such as
successful logins, editor account changes, project updates, and logout events.
The implementation is therefore a viewer/filter layer over the existing audit trail.

Files:
- app/core/ActivityLogManager.php
- scadmin/activity-logs/index.php
- scadmin/activity-logs/view.php
- database/phase21_activity_logs.sql
- PHASE21_ACTIVITY_LOGS_INSTRUCTIONS.txt

No current public design/content is changed.
