STATE CORPS CMS - PHASE 4

This package extends Phase 3 with Admin-only editor management.

Features:
- One Admin account (already enforced by the Phase 3 CLI setup).
- Maximum 3 Editor accounts.
- Create, edit, deactivate, and delete Editors.
- Reset/change an Editor password from the Edit screen.
- Assign CMS permissions to each Editor.
- Permissions are checked server-side by Auth::requirePermission().
- Editor actions are recorded in audit_logs.
- No changes to the public website are included.

INSTALL
1. Copy the app/, scadmin/, and database/ files into your existing project,
   or merge this package over the Phase 3 files.
2. Keep your existing public files and includes/ unchanged.
3. Keep database credentials in app/config/config.php correct for XAMPP.
4. Ensure Phase 1 schema and Phase 3 login_attempts table already exist.
5. Log in at /scadmin as the Admin.
6. Open /scadmin/editors/.

EDITOR LIMIT
- The application allows at most 3 users with role='editor'.
- Disabling an editor does not free a slot.
- Deleting an editor frees a slot.

EDITOR ACCESS
Editors will later access actual CMS pages only when they have the matching
permission. The Phase 4 editor manager already stores those permissions and
provides the server-side authorization foundation.
