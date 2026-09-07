STATE CORPS CMS - PHASE 6
=========================

Projects CMS for the existing publicV6 structure.

PUBLIC FRONTEND
---------------
No public page is changed in Phase 6.
The existing projects.php and projectdetails.php remain untouched.
The CMS only reads/writes the existing Phase 1 project tables.

NEW
---
app/core/ProjectManager.php
scadmin/projects/index.php
scadmin/projects/create.php
scadmin/projects/edit.php
scadmin/projects/form.php
scadmin/projects/delete.php
scadmin/projects/toggle.php
scadmin/projects/.htaccess

UPDATED
-------
scadmin/partials/sidebar.php     Projects link is now active
scadmin/assets/css/admin.css     Project list/form styling
scadmin/assets/js/admin.js       Repeatable gallery/scope rows

FEATURES
--------
- Permission-protected project management.
- Search by project, client, location, category.
- Filter by sector and status.
- Pagination.
- Create project.
- Edit project.
- Delete project.
- Publish/unpublish.
- Homepage flag.
- Category-image flag.
- Sort order.
- Thumbnail path.
- Multiple gallery image paths.
- Multiple scope items.
- CSRF-protected POST operations.
- Transactional project + gallery + scope saves.
- Audit logging.

IMPORTANT IMAGE RULE
--------------------
Phase 6 accepts existing public asset paths such as:
assets/images/projects/01-logar-gardiz-1.jpg

It does NOT yet move or replace files and it does NOT redesign the frontend.
A dedicated media/upload workflow can be added later without changing the
public project template.

INSTALL
-------
1. Merge these files into your existing publicV6 project.
2. Keep all current public files and includes/ unchanged.
3. Ensure Phase 1/2/3/4/5 are already installed.
4. Log in to /scadmin using an Admin or an Editor that has manage_projects.
5. Open /scadmin/projects/.

NO DATABASE MIGRATION
---------------------
Phase 6 uses the projects, project_images and project_scope tables from Phase 1.
No new SQL file is required.
