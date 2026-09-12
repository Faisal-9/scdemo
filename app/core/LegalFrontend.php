<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

final class LegalFrontend
{
    /**
     * Rebuilds the exact array keys expected by the existing policiesdata.php:
     * privacy, whistleblower, trademarks.
     * The database intentionally uses namespaced document keys such as
     * policies_privacy and policies_whistleblower.
     */
    public static function policies(): array
    {
        $mapping = [
            'privacy' => 'policies_privacy',
            'whistleblower' => 'policies_whistleblower',
            'trademarks' => 'policies_trademarks',
        ];

        $policies = [];

        foreach ($mapping as $publicKey => $databaseKey) {
            $document = self::documentByDatabaseKey($databaseKey);
            if ($document !== null) {
                $policies[$publicKey] = $document;
            }
        }

        return $policies;
    }

    /**
     * Rebuilds the exact array structure expected by termsOfServicesData.php:
     * $TermsOfService['terms'].
     */
    public static function termsOfService(): array
    {
        $document = self::documentByDatabaseKey('terms_terms');

        return $document === null ? [] : ['terms' => $document];
    }

    private static function documentByDatabaseKey(string $databaseKey): ?array
    {
        $pdo = Database::connection();

        $stmt = $pdo->prepare(
            'SELECT id, document_key, title
             FROM legal_documents
             WHERE document_key = :document_key
               AND is_active = 1
             LIMIT 1'
        );
        $stmt->execute([':document_key' => $databaseKey]);
        $document = $stmt->fetch();

        if (!is_array($document)) {
            return null;
        }

        $sectionStmt = $pdo->prepare(
            'SELECT id, title, content, section_type
             FROM legal_sections
             WHERE document_id = :document_id
             ORDER BY sort_order ASC, id ASC'
        );
        $sectionStmt->execute([':document_id' => (int) $document['id']]);

        $itemStmt = $pdo->prepare(
            'SELECT item_text
             FROM legal_section_items
             WHERE section_id = :section_id
             ORDER BY sort_order ASC, id ASC'
        );

        $sections = [];

        foreach ($sectionStmt->fetchAll() as $section) {
            $entry = [
                'title' => (string) $section['title'],
            ];

            if ((string) $section['section_type'] === 'list') {
                $itemStmt->execute([':section_id' => (int) $section['id']]);

                $entry['list'] = array_map(
                    static fn(array $row): string => (string) $row['item_text'],
                    $itemStmt->fetchAll()
                );
            } else {
                $entry['content'] = (string) ($section['content'] ?? '');
            }

            $sections[] = $entry;
        }

        return [
            'title' => (string) $document['title'],
            'sections' => $sections,
        ];
    }
}
