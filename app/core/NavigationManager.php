<?php

declare(strict_types=1);

final class NavigationManager
{
    public static function rows(string $location): array
    {
        $location = self::normalizeLocation($location);
        $stmt = Database::connection()->prepare(
            'SELECT n.*, p.label AS parent_label
             FROM site_navigation n
             LEFT JOIN site_navigation p ON p.id = n.parent_id
             WHERE n.location = ?
             ORDER BY n.sort_order ASC, n.id ASC'
        );
        $stmt->execute([$location]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM site_navigation WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function save(?int $id, array $data): int
    {
        $pdo = Database::connection();
        $data = self::validate($data, $id);
        $userId = Auth::id();

        if ($id !== null) {
            $stmt = $pdo->prepare(
                'UPDATE site_navigation
                 SET parent_id = ?, location = ?, label = ?, url = ?, target = ?, icon_class = ?, sort_order = ?, is_active = ?, updated_by = ?, updated_at = NOW()
                 WHERE id = ?'
            );
            $stmt->execute([
                $data['parent_id'],
                $data['location'],
                $data['label'],
                $data['url'],
                $data['target'],
                $data['icon_class'],
                $data['sort_order'],
                $data['is_active'],
                $userId,
                $id
            ]);
            $savedId = $id;
            $action = 'update';
        } else {
            $stmt = $pdo->prepare(
                'INSERT INTO site_navigation
                 (parent_id, location, label, url, target, icon_class, sort_order, is_active, created_by, updated_by)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
            );
            $stmt->execute([
                $data['parent_id'],
                $data['location'],
                $data['label'],
                $data['url'],
                $data['target'],
                $data['icon_class'],
                $data['sort_order'],
                $data['is_active'],
                $userId,
                $userId
            ]);
            $savedId = (int)$pdo->lastInsertId();
            $action = 'create';
        }

        Navigation::clearCache();
        if (class_exists('AuditLogger')) {
            AuditLogger::log($action, 'site_navigation', $savedId, ucfirst($action) . ' navigation item: ' . $data['label']);
        }
        return $savedId;
    }

    public static function toggle(int $id): void
    {
        $row = self::find($id);
        if (!$row) {
            throw new RuntimeException('Navigation item not found.');
        }
        $stmt = Database::connection()->prepare('UPDATE site_navigation SET is_active = ?, updated_by = ?, updated_at = NOW() WHERE id = ?');
        $userId = Auth::id();
        $stmt->execute([(int)$row['is_active'] === 1 ? 0 : 1, $userId, $id]);
        Navigation::clearCache();
        if (class_exists('AuditLogger')) {
            AuditLogger::log('update', 'site_navigation', $id, 'Toggled navigation item: ' . $row['label']);
        }
    }

    public static function delete(int $id): void
    {
        $pdo = Database::connection();
        $row = self::find($id);
        if (!$row) {
            throw new RuntimeException('Navigation item not found.');
        }

        $childStmt = $pdo->prepare('SELECT COUNT(*) FROM site_navigation WHERE parent_id = ?');
        $childStmt->execute([$id]);
        if ((int)$childStmt->fetchColumn() > 0) {
            throw new RuntimeException('Remove or re-parent child navigation items before deleting this item.');
        }

        $stmt = $pdo->prepare('DELETE FROM site_navigation WHERE id = ?');
        $stmt->execute([$id]);
        Navigation::clearCache();
        if (class_exists('AuditLogger')) {
            AuditLogger::log('delete', 'site_navigation', $id, 'Deleted navigation item: ' . $row['label']);
        }
    }

    public static function parents(string $location, ?int $excludeId = null): array
    {
        $location = self::normalizeLocation($location);
        $sql = 'SELECT id, label FROM site_navigation WHERE location = ? AND parent_id IS NULL';
        $params = [$location];
        if ($excludeId !== null) {
            $sql .= ' AND id <> ?';
            $params[] = $excludeId;
        }
        $sql .= ' ORDER BY sort_order ASC, id ASC';
        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private static function validate(array $data, ?int $id): array
    {
        $location = strtolower(trim((string)($data['location'] ?? 'header')));
        if (!in_array($location, ['header', 'footer'], true)) {
            throw new InvalidArgumentException('Invalid navigation location.');
        }

        $label = trim((string)($data['label'] ?? ''));
        if ($label === '' || mb_strlen($label) > 150) {
            throw new InvalidArgumentException('Label is required and must be 150 characters or fewer.');
        }

        $url = trim((string)($data['url'] ?? '#'));
        if ($url === '') {
            $url = '#';
        }
        if (preg_match('/\s|javascript:/i', $url)) {
            throw new InvalidArgumentException('Invalid navigation URL.');
        }

        $target = (string)($data['target'] ?? '_self');
        if (!in_array($target, ['_self', '_blank'], true)) {
            $target = '_self';
        }

        $parentId = $data['parent_id'] === '' || $data['parent_id'] === null ? null : (int)$data['parent_id'];
        if ($parentId !== null) {
            $parent = self::find($parentId);
            if (!$parent || $parent['location'] !== $location || ($id !== null && $parentId === $id)) {
                throw new InvalidArgumentException('Invalid parent navigation item.');
            }
        }

        return [
            'parent_id' => $parentId,
            'location' => $location,
            'label' => $label,
            'url' => $url,
            'target' => $target,
            'icon_class' => trim((string)($data['icon_class'] ?? '')),
            'sort_order' => max(0, (int)($data['sort_order'] ?? 0)),
            'is_active' => !empty($data['is_active']) ? 1 : 0,
        ];
    }

    private static function normalizeLocation(string $location): string
    {
        $location = strtolower(trim($location));
        if (!in_array($location, ['header', 'footer'], true)) {
            throw new InvalidArgumentException('Invalid navigation location.');
        }
        return $location;
    }
}
