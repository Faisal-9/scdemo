<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

final class ContactFrontend
{
    public static function data(): array
    {
        $db = Database::connection();
        $page = [
            'section_title' => 'Reach Us',
            'head_office_title' => 'Headquarters - State Corps Afghanistan',
            'head_office_phone' => '+93 791 811 968',
            'head_office_whatsapp' => '+93 791 811 968',
            'head_office_email' => 'comms@statecorps.com',
            'head_office_address' => 'Kart-e-char, D#3, Kabul Afghanistan',
            'map_label' => 'Kart-e-Char, Kabul, Afghanistan',
            'map_lat' => '34.5044737',
            'map_lng' => '69.1409340',
            'map_zoom' => 14,
            'form_title' => 'Drop Message',
            'overseas_title' => 'Overseas Companies',
            'overseas_subtitle' => 'Contact our offices worldwide for assistance and support.',
        ];
        $qr = [[
            'image' => 'assets/images/WA-QR-Code.jpg',
            'label' => 'WhatsApp',
        ]];
        $offices = [
            [
                'title' => 'State Corps Turkey',
                'phone' => '+90 212 123 4567',
                'whatsapp' => null,
                'email' => 'info@statecorps.com.tr',
                'address' => 'İnşaat Sanayi ve Ticaret A.Ş. Kuçukbakkalkoy Mah. Kuçuk Setli Sk. No:5-9 İç Kapı No:4 Ataşehir Istanbul, Türkiye 34750',
            ],
            [
                'title' => 'State Corps USA',
                'phone' => '+1 123-456-7890',
                'whatsapp' => null,
                'email' => 'hq@statecorps.com',
                'address' => '42426 Benfold Square Brambleton, VA 20148 United States',
            ],
            [
                'title' => 'State Corps Uzbekistan',
                'phone' => '+971 4 123 4567',
                'whatsapp' => null,
                'email' => 'uzbekistan@statecorps.com',
                'address' => 'abc Street, Tashkent, Uzbekistan',
            ],
        ];

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
            if (APP_DEBUG) {
                error_log('Contact CMS tables are unavailable; using public defaults: ' . $e->getMessage());
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
