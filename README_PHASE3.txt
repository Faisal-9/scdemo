STATE CORPS CMS - PHASE 3
=========================

Purpose
-------
Phase 3 adds the private /scadmin authentication foundation.
It does not modify the current public frontend.

FILES
-----
app/config/config.php          DB + URL + security configuration
app/core/Database.php          PDO singleton
app/core/Session.php           Secure PHP sessions and timeouts
app/core/CSRF.php              CSRF token generation/checking
app/core/Auth.php              Login, logout, roles, permissions, audit
app/helpers/functions.php      Escaping, redirects, flash helpers
app/bootstrap.php              Shared CMS bootstrap

database/phase3.sql            login_attempts table
database/create_admin.php      CLI-only first admin creation

scadmin/index.php               Private login screen
scadmin/dashboard.php           Dashboard shell
scadmin/logout.php              Logout endpoint
scadmin/assets/css/admin.css    CMS-only styling

INSTALL
-------
1. Ensure Phase 1 schema and Phase 2 migration are already complete.
2. Import database/phase3.sql in phpMyAdmin.
3. Copy the app/ and scadmin/ folders into your project root.
4. Edit app/config/config.php:
   - BASE_URL = '/scdemo' for http://localhost/scdemo
   - BASE_URL = '' for a cPanel domain whose files are in public_html
   - database credentials as appropriate
5. From Command Prompt/Terminal, from the project root, run:

   php database/create_admin.php

6. Open:

   http://localhost/scdemo/scadmin

7. Sign in with the Admin account you just created.

PRODUCTION
----------
- Set APP_DEBUG to false.
- Use a strong database password.
- Use HTTPS.
- Do not expose create_admin.php through the browser. It is CLI-only.
- Keep app/ and database/ blocked from direct browser access.

EDITOR LIMITS
-------------
The database schema permits user records, but account-management code in the next phase will enforce:
- maximum 1 active Admin
- maximum 3 active Editors
- no public registration
- Admin-created editor accounts only

IMPORTANT
---------
No public PHP page needs to include app/bootstrap.php yet.
That integration happens later, after the CMS foundation is verified.
