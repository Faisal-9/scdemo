StateCorps Phase 14 — Contact & Messages

Incremental/delta package only. Does not replace the project.
Uses existing contact_messages table and manage_messages permission.

Copy app/core/ContactMessageManager.php and scadmin/messages/ into publicV6.
Import database/phase14_messages.sql once.

Public form integration:
Point the EXISTING contact form POST action to a public endpoint such as /contact_submit.php,
without changing its HTML/CSS presentation. The endpoint should call:

require_once __DIR__ . '/app/public_bootstrap.php';
require_once __DIR__ . '/app/core/ContactMessageManager.php';
ContactMessageManager::create($_POST);

See PHASE14_INSTRUCTIONS.txt.
