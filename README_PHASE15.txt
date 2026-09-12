Phase 15: Global Site Settings

This is an incremental merge package for the existing State Corps CMS.

What it provides:
- SiteSettings helper for reading the existing site_settings table.
- SiteSettingsManager for safe admin edits.
- /scadmin/settings/ admin UI protected by manage_settings.
- Non-destructive database index migration.

Existing database evidence:
site_settings already contains homepage and projects settings. No content migration is required.

Important:
- No public page markup/CSS/JS is changed automatically.
- Existing page-specific settings remain where they are.
- Do not use site_settings for passwords, API secrets, or arbitrary executable code.
- Existing static PHP files remain valid fallback sources.
