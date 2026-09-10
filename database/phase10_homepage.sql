USE statecorps;

INSERT INTO site_settings
    (setting_key, setting_value, setting_type, description)
VALUES
    (
        'home_stats_background',
        'assets/images/home/whybg1.jpg',
        'image',
        'Homepage statistics background image'
    )
ON DUPLICATE KEY UPDATE
    setting_value = VALUES(setting_value),
    setting_type = VALUES(setting_type),
    description = VALUES(description);
