STATE CORPS — PHASE 17
Global Navigation CMS foundation (incremental delta)

This ZIP is intentionally a delta, not a replacement project.

Included:
- app/core/Navigation.php
- app/core/NavigationManager.php
- database/phase17_navigation.sql
- scadmin/navigation/{index.php,edit.php,toggle.php,delete.php}
- PHASE17_INSTRUCTIONS.txt
- README_PHASE17.txt

What it changes:
- Adds a site_navigation table.
- Adds a manage_navigation permission.
- Adds a permission-protected admin editor for header/footer navigation.
- Adds a frontend adapter ready to consume the navigation tree.

What it does NOT change:
- Existing public templates.
- Existing public menu labels/order.
- Existing CSS/JS.
- Existing pages/content.
- Existing login behavior.

Why no rows are seeded:
The uploaded project structure identifies the shared template filenames, but does not
include the exact PHP bodies of those files. Seeding a guessed menu would risk changing
public content/order. This package therefore creates the CMS capability without touching
the live public menu.
