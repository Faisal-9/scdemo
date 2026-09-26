ALTER TABLE `site_settings`
    MODIFY `setting_type` enum('text','textarea','url','email','phone','image','document','boolean','number','timezone') NOT NULL DEFAULT 'text';

INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_type`, `description`)
VALUES ('timezone', 'UTC', 'timezone', 'Timezone used for application-generated dates and times')
ON DUPLICATE KEY UPDATE `setting_type` = VALUES(`setting_type`), `description` = VALUES(`description`);