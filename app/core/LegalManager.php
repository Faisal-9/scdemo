<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

final class LegalManager
{
    public static function documents(bool $activeOnly = false): array
    {
        $pdo = Database::connection();
        $sql = 'SELECT * FROM legal_documents';
        if ($activeOnly) {
            $sql .= ' WHERE is_active = 1';
        }
        $sql .= ' ORDER BY sort_order ASC, id ASC';
        return $pdo->query($sql)->fetchAll();
    }

    public static function findDocument(int $id): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM legal_documents WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function findDocumentByKey(string $key): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM legal_documents WHERE document_key = :key LIMIT 1');
        $stmt->execute([':key' => $key]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function sections(int $documentId): array
    {
        $stmt = Database::connection()->prepare(
            'SELECT * FROM legal_sections WHERE document_id = :document_id ORDER BY sort_order ASC, id ASC'
        );
        $stmt->execute([':document_id' => $documentId]);
        $rows = $stmt->fetchAll();
        $items = Database::connection()->prepare(
            'SELECT * FROM legal_section_items WHERE section_id = :section_id ORDER BY sort_order ASC, id ASC'
        );
        foreach ($rows as &$row) {
            $items->execute([':section_id' => (int)$row['id']]);
            $row['items'] = $items->fetchAll();
        }
        unset($row);
        return $rows;
    }

    public static function findSection(int $id): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM legal_sections WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function saveDocument(array $data, int $id): void
    {
        $title = trim((string)($data['title'] ?? ''));
        if ($title === '') {
            throw new RuntimeException('Document title is required.');
        }
        $sort = max(0, (int)($data['sort_order'] ?? 0));
        $active = !empty($data['is_active']) ? 1 : 0;

        $stmt = Database::connection()->prepare(
            'UPDATE legal_documents SET title = :title, sort_order = :sort_order, is_active = :is_active WHERE id = :id'
        );
        $stmt->execute([
            ':title' => $title,
            ':sort_order' => $sort,
            ':is_active' => $active,
            ':id' => $id,
        ]);
        self::audit('update', $id, $title);
    }

    public static function saveSection(int $documentId, array $data, ?int $id = null): int
    {
        $title = trim((string)($data['title'] ?? ''));
        if ($title === '') {
            throw new RuntimeException('Section title is required.');
        }
        $type = (string)($data['section_type'] ?? 'content');
        if (!in_array($type, ['content', 'list'], true)) {
            throw new RuntimeException('Invalid section type.');
        }
        $content = (string)($data['content'] ?? '');
        $sort = max(0, (int)($data['sort_order'] ?? 0));
        $pdo = Database::connection();
        $pdo->beginTransaction();
        try {
            if ($id === null) {
                $stmt = $pdo->prepare(
                    'INSERT INTO legal_sections (document_id, title, content, section_type, sort_order) VALUES (:document_id,:title,:content,:type,:sort)'
                );
                $stmt->execute([
                    ':document_id' => $documentId, ':title' => $title, ':content' => $content,
                    ':type' => $type, ':sort' => $sort,
                ]);
                $id = (int)$pdo->lastInsertId();
                $action = 'create';
            } else {
                $stmt = $pdo->prepare(
                    'UPDATE legal_sections SET title=:title, content=:content, section_type=:type, sort_order=:sort WHERE id=:id AND document_id=:document_id'
                );
                $stmt->execute([
                    ':title' => $title, ':content' => $content, ':type' => $type, ':sort' => $sort,
                    ':id' => $id, ':document_id' => $documentId,
                ]);
                if ($stmt->rowCount() === 0 && !self::sectionBelongsTo($id, $documentId)) {
                    throw new RuntimeException('Section not found.');
                }
                $action = 'update';
            }
            $pdo->commit();
            self::audit($action, $id, $title);
            return $id;
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            throw $e;
        }
    }

    public static function replaceSectionItems(int $sectionId, array $texts): void
    {
        $pdo = Database::connection();
        $pdo->beginTransaction();
        try {
            $pdo->prepare('DELETE FROM legal_section_items WHERE section_id = :id')->execute([':id' => $sectionId]);
            $stmt = $pdo->prepare(
                'INSERT INTO legal_section_items (section_id, item_text, sort_order) VALUES (:section_id,:item_text,:sort_order)'
            );
            $order = 0;
            foreach ($texts as $text) {
                $text = trim((string)$text);
                if ($text === '') continue;
                $stmt->execute([':section_id' => $sectionId, ':item_text' => $text, ':sort_order' => $order++]);
            }
            $pdo->commit();
            self::audit('update', $sectionId, 'Updated legal section items');
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            throw $e;
        }
    }

    public static function deleteSection(int $documentId, int $sectionId): void
    {
        $section = self::findSection($sectionId);
        if (!$section || (int)$section['document_id'] !== $documentId) {
            throw new RuntimeException('Section not found.');
        }
        $pdo = Database::connection();
        $pdo->beginTransaction();
        try {
            $pdo->prepare('DELETE FROM legal_section_items WHERE section_id=:id')->execute([':id'=>$sectionId]);
            $pdo->prepare('DELETE FROM legal_sections WHERE id=:id AND document_id=:document_id')->execute([
                ':id'=>$sectionId, ':document_id'=>$documentId,
            ]);
            $pdo->commit();
            self::audit('delete', $sectionId, (string)$section['title']);
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            throw $e;
        }
    }

    private static function sectionBelongsTo(int $id, int $documentId): bool
    {
        $stmt = Database::connection()->prepare('SELECT 1 FROM legal_sections WHERE id=:id AND document_id=:document_id LIMIT 1');
        $stmt->execute([':id'=>$id, ':document_id'=>$documentId]);
        return (bool)$stmt->fetchColumn();
    }

    private static function audit(string $action, int $id, string $label): void
    {
        try {
            $stmt = Database::connection()->prepare(
                'INSERT INTO audit_logs (user_id, action, entity_type, entity_id, description, ip_address, user_agent) VALUES (:uid,:action,\'legal\',:id,:description,:ip,:ua)'
            );
            $stmt->execute([
                ':uid' => class_exists('Auth') ? (Auth::id() ?: null) : null,
                ':action' => $action,
                ':id' => $id,
                ':description' => ucfirst($action) . ' legal content: ' . $label,
                ':ip' => $_SERVER['REMOTE_ADDR'] ?? null,
                ':ua' => $_SERVER['HTTP_USER_AGENT'] ?? null,
            ]);
        } catch (Throwable $e) {
            // Audit failure must not break content management.
        }
    }
}
