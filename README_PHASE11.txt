State Corps — Phase 11

About CMS + About frontend integration

This package is a merge/delta only. It adds the About CMS and its MySQL frontend adapter; it does
not replace the full State Corps project.

Source contract preserved
-------------------------
The current About data file exposes:
- $generalInfo
- $missionVision
- $clients
- $certificates
- $awards
- $sisterCompanies
- $hse
- $cprofile

The frontend adapter reconstructs those same variables so the existing includes/aboutSection.php
can keep its current HTML/CSS/JS behavior.

Security
--------
Admin routes require manage_about through the existing Auth layer. Mutations use the existing CSRF
implementation and Auth::audit(). No public login is introduced.

Content safety
--------------
The one-time migration requires the branch's existing aboutdata.php. Existing content is not rewritten
by the migration script, and the static file remains as a fallback until the entire CMS is verified.
