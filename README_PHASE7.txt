STATE CORPS CMS - PHASE 7

Purpose
-------
Switch the public Projects listing/detail pages from static PHP arrays to MySQL
without changing the existing public design.

New files
---------
app/public_bootstrap.php
app/core/ProjectFrontend.php
database/phase7_projects_page.sql

Updated public files
--------------------
projects.php
projectdetails.php

IMPORTANT
---------
Do not copy over a branch's unrelated files. Merge these two public PHP files
with your current branch if they have other custom edits.

WHY public_bootstrap.php?
-------------------------
The /scadmin bootstrap starts an Admin session. Public pages should not start
that session just because they need database access. public_bootstrap.php is
therefore deliberately lightweight.

FIRST STEP
----------
Import:
  database/phase7_projects_page.sql

This stores the existing standalone $projecthero content in site_settings.

SECOND STEP
-----------
Add app/public_bootstrap.php and app/core/ProjectFrontend.php.

THIRD STEP
-----------
Replace the current projects.php and projectdetails.php with the Phase 7
versions, preserving any branch-specific unrelated changes.

BEHAVIOR
--------
- Published projects are shown publicly.
- Unpublished projects are hidden publicly.
- Project legacy IDs remain the public ?id= value.
- Existing project asset paths remain unchanged.
- Gallery and scope records come from project_images/project_scope.
- Project hero content comes from site_settings.
- Existing static PHP data files are not deleted yet.
- Public HTML/CSS/JS structure is kept unchanged.

ROLLBACK
--------
To roll back, restore the previous projects.php and projectdetails.php. The
static data files remain available because Phase 7 does not delete them.
