Phase 13 converts the existing Policies / Terms data to CMS-managed MySQL records.

Existing database tables used directly:
  legal_documents
  legal_sections
  legal_section_items

No new content tables are required.
No public authentication is introduced.
No public legal-page HTML/CSS/JS is redesigned.

The database supplied with this project already contains four legal documents:
  privacy
  whistleblower
  trademarks
  terms

The frontend adapter reconstructs the same array style used by the original
policiesdata.php and termsOfServicesData.php files.
