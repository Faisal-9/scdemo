-- Phase 13: Legal CMS indexes only.
-- Safe for the existing State Corps database. No tables are dropped or recreated.

ALTER TABLE legal_documents
  ADD INDEX idx_legal_documents_active_order (is_active, sort_order);

ALTER TABLE legal_sections
  ADD INDEX idx_legal_sections_document_order (document_id, sort_order);

ALTER TABLE legal_section_items
  ADD INDEX idx_legal_section_items_section_order (section_id, sort_order);
