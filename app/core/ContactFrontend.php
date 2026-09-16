<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

final class ContactFrontend
{
    public static function data(): array
    {
        $db = Database::connection();
        $page = [];
        $qr = [];
        $offices = [];

        try {
            $page = array_merge(
                $page,
                $db->query('SELECT * FROM contact_page WHERE id=1 LIMIT 1')->fetch(PDO::FETCH_ASSOC) ?: []
            );
            $qrRows = $db->query(
                'SELECT image_path,label FROM contact_qr_codes WHERE is_active=1 ORDER BY sort_order ASC,id ASC'
            )->fetchAll(PDO::FETCH_ASSOC);
            $qr = array_map(static fn(array $row): array => [
                'image' => (string)$row['image_path'],
                'label' => (string)$row['label'],
            ], $qrRows);
            $offices = $db->query(
                'SELECT title,phone,whatsapp,email,address FROM contact_offices WHERE is_active=1 ORDER BY sort_order ASC,id ASC'
            )->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            if (defined('APP_DEBUG') && APP_DEBUG) {
                error_log('Contact CMS tables are unavailable; public contact content is empty: ' . $e->getMessage());
            }
        }

        return [
            'page' => $page,
            'head_office' => [
                'title' => (string)($page['head_office_title'] ?? ''),
                'phone' => (string)($page['head_office_phone'] ?? ''),
                'whatsapp' => (string)($page['head_office_whatsapp'] ?? ''),
                'email' => (string)($page['head_office_email'] ?? ''),
                'address' => (string)($page['head_office_address'] ?? ''),
                'qr_codes' => $qr,
            ],
            'international_offices' => $offices,
        ];
    }
}
