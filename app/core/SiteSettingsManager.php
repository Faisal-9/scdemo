<?php
declare(strict_types=1);

final class SiteSettingsManager
{
    public static function rows(): array
    {
        $pdo = Database::connection();
        $stmt = $pdo->query(
            'SELECT id, setting_key, setting_value, setting_type, description, updated_by, updated_at
             FROM site_settings
             ORDER BY setting_key ASC'
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(int $id): ?array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('SELECT * FROM site_settings WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function save(int $id, string $value): void
    {
        $pdo = Database::connection();
        $row = self::find($id);
        if (!$row) {
            throw new RuntimeException('Setting not found.');
        }

        self::validate($row, $value);
        $userId = null;
        if (isset($_SESSION['user_id']) && is_numeric($_SESSION['user_id'])) {
            $userId = (int)$_SESSION['user_id'];
        }

        $stmt = $pdo->prepare(
            'UPDATE site_settings
             SET setting_value = ?, updated_by = ?, updated_at = NOW()
             WHERE id = ?'
        );
        $stmt->execute([$value, $userId, $id]);
        SiteSettings::clearCache();

        if (class_exists('AuditLogger')) {
            AuditLogger::log('update', 'site_setting', $id, 'Updated site setting: ' . $row['setting_key']);
        }
    }

    private static function validate(array $row, string $value): void
    {
        $type = (string)$row['setting_type'];
        if ($type === 'email' && $value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Please enter a valid email address.');
        }
        if (in_array($type, ['url', 'document', 'image'], true) && $value !== '') {
            if (preg_match('/\s/', $value)) {
                throw new InvalidArgumentException('The path/value cannot contain spaces.');
            }
            if ($type === 'url' && !preg_match('~^(https?://|/|#)~i', $value)) {
                throw new InvalidArgumentException('URL must begin with http://, https://, /, or #.');
            }
        }
        if ($type === 'phone' && $value !== '' && !preg_match('/^[0-9+().\-\s]{5,50}$/', $value)) {
            throw new InvalidArgumentException('Please enter a valid phone number.');
        }
        if ($type === 'number' && $value !== '' && !is_numeric($value)) {
            throw new InvalidArgumentException('Please enter a numeric value.');
        }
        if ($type === 'boolean' && !in_array(strtolower($value), ['0', '1', 'true', 'false', 'yes', 'no', 'on', 'off'], true)) {
            throw new InvalidArgumentException('Boolean settings must use a true/false value.');
        }
    }
}
