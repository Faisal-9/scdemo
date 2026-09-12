STATE CORPS CMS — PHASE 12
Media CMS + frontend integration

This is an incremental merge package. It does not replace your project.

Scope:
- News, Events, Gallery media items
- descriptions, tags, images, dates, external links
- active/inactive status and display ordering
- admin CRUD protected by existing manage_media permission
- public MediaFrontend adapter preserving the existing $media structure
- existing includes/components/mediasection.php remains untouched

Current database evidence:
media_items, media_descriptions, media_tags, and media_item_tags already exist and contain the current content, so Phase 12 does not migrate or duplicate records.
