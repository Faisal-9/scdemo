<?php

declare(strict_types=1);

final class SiteSettingsManager
{
    private const SECTION_KEYS = [
        'header' => [
            'site_logo',
            'social_facebook_url',
            'social_x_url',
            'social_linkedin_url',
            'header_top_background_color',
            'header_top_text_color',
            'header_bottom_background_color',
            'header_bottom_text_color',
            'header_hover_color',
        ],
        'footer' => [
            'footer_logo',
            'footer_logo_enabled',
            'footer_statement',
            'footer_services_label',
            'footer_company_label',
            'footer_contact_label',
            'footer_copyright',
        ],
    ];

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

    public static function rowsForSection(string $section): array
    {
        $keys = self::SECTION_KEYS[$section] ?? [];
        if ($keys === []) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($keys), '?'));
        $stmt = Database::connection()->prepare(
            'SELECT id, setting_key, setting_value, setting_type, description, updated_by, updated_at
             FROM site_settings
             WHERE setting_key IN (' . $placeholders . ')
             ORDER BY FIELD(setting_key, ' . $placeholders . ')'
        );
        $stmt->execute([...$keys, ...$keys]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function sectionForKey(string $key): ?string
    {
        foreach (self::SECTION_KEYS as $section => $keys) {
            if (in_array($key, $keys, true)) {
                return $section;
            }
        }

        return null;
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
        $userId = Auth::id();

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

    public static function saveMany(array $values): void
    {
        $pdo = Database::connection();
        $pdo->beginTransaction();

        try {
            foreach ($values as $id => $value) {
                self::save((int)$id, trim((string)$value));
            }
            $pdo->commit();
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }
    }

    public static function saveManyForSection(string $section, array $values): void
    {
        $allowedIds = [];
        foreach (self::rowsForSection($section) as $row) {
            $allowedIds[(string)$row['id']] = true;
        }

        $values = array_filter(
            $values,
            static fn(mixed $value, int|string $id): bool => isset($allowedIds[(string)$id]),
            ARRAY_FILTER_USE_BOTH
        );
        self::saveMany($values);
    }

    private static function validate(array $row, string $value): void
    {
        $type = (string)$row['setting_type'];
        $key = (string)$row['setting_key'];
        if (str_ends_with($key, '_color') && !preg_match('/^#[0-9a-fA-F]{6}$/', $value)) {
            throw new InvalidArgumentException('Color values must use six-digit hex format, for example #0c1c3d.');
        }
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
