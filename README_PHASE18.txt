STATE CORPS — PHASE 18
SEO / PAGE METADATA CMS FOUNDATION

This is an incremental delta package.

Adds:
- page_seo table
- manage_seo permission
- Seo frontend adapter
- SeoManager admin-side CRUD
- /scadmin/seo/ management screens
- safe registry entries for existing public pages

Does not:
- change existing public pages
- replace includes/head.php
- change current titles/descriptions
- change CSS/JS/design
- add a public login
- grant editors SEO access automatically

The next integration step should inspect the real includes/head.php source before wiring
Seo::meta() into the public <head>.
