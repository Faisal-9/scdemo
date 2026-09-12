ALTER TABLE contact_messages
  ADD INDEX idx_contact_messages_status_created (status, created_at),
  ADD INDEX idx_contact_messages_email (email),
  ADD INDEX idx_contact_messages_subject (subject);
