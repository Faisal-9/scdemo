Phase 19 is an incremental/delta package. It adds a redirect management CMS foundation.
No redirect records are seeded, so current public URL behavior remains unchanged until the admin creates and enables redirects.

Files:
- app/core/Redirect.php
- app/core/RedirectManager.php
- database/phase19_redirects.sql
- scadmin/redirects/{index,edit,toggle,delete}.php
- PHASE19_INSTRUCTIONS.txt
