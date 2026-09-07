<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Auth.php';

final class EditorManager
{
    public static function editorCount(): int
    {
        $pdo = Database::connection();
        $stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'editor'");
        return (int) $stmt->fetchColumn();
    }

    public static function allEditors(): array
    {
        $pdo = Database::connection();
        $stmt = $pdo->query(
            "SELECT id, username, display_name, role, status, last_login_at, created_at, updated_at
             FROM users
             WHERE role = 'editor'
             ORDER BY id ASC"
        );

        return $stmt->fetchAll();
    }

    public static function findEditor(int $id): ?array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare(
            "SELECT id, username, display_name, role, status, last_login_at, created_at, updated_at
             FROM users
             WHERE id = :id AND role = 'editor'
             LIMIT 1"
        );
        $stmt->execute([':id' => $id]);

        $editor = $stmt->fetch();
        return is_array($editor) ? $editor : null;
    }

    public static function allPermissions(): array
    {
        $pdo = Database::connection();
        $stmt = $pdo->query(
            'SELECT id, permission_key, permission_name, description
             FROM permissions
             ORDER BY id ASC'
        );

        return $stmt->fetchAll();
    }

    public static function permissionIdsForEditor(int $editorId): array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare(
            'SELECT permission_id
             FROM user_permissions
             WHERE user_id = :user_id'
        );
        $stmt->execute([':user_id' => $editorId]);

        return array_map(
            static fn($id): int => (int) $id,
            $stmt->fetchAll(PDO::FETCH_COLUMN)
        );
    }

    public static function createEditor(
        string $username,
        string $displayName,
        string $password,
        array $permissionIds
    ): int {
        $pdo = Database::connection();

        if (self::editorCount() >= 3) {
            throw new RuntimeException('The maximum of 3 editor accounts has already been reached.');
        }

        $username = self::normalizeUsername($username);
        $displayName = trim($displayName);

        self::validateUsername($username);
        self::validateDisplayName($displayName);
        self::validatePassword($password);

        if (self::usernameExists($username)) {
            throw new RuntimeException('That username is already in use.');
        }

        $permissionIds = self::validatedPermissionIds($permissionIds);

        $pdo->beginTransaction();

        try {
            $stmt = $pdo->prepare(
                "INSERT INTO users
                    (username, display_name, password_hash, role, status)
                 VALUES
                    (:username, :display_name, :password_hash, 'editor', 'active')"
            );

            $stmt->execute([
                ':username' => $username,
                ':display_name' => $displayName,
                ':password_hash' => password_hash($password, PASSWORD_DEFAULT),
            ]);

            $editorId = (int) $pdo->lastInsertId();

            self::replacePermissionsInternal($pdo, $editorId, $permissionIds);

            $pdo->commit();

            return $editorId;
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }
    }

    public static function updateEditor(
        int $editorId,
        string $username,
        string $displayName,
        string $status,
        array $permissionIds,
        ?string $newPassword = null
    ): void {
        $pdo = Database::connection();

        $editor = self::findEditor($editorId);

        if ($editor === null) {
            throw new RuntimeException('Editor account not found.');
        }

        $username = self::normalizeUsername($username);
        $displayName = trim($displayName);

        self::validateUsername($username);
        self::validateDisplayName($displayName);
        self::validateStatus($status);

        if (
            self::usernameExists($username, $editorId)
        ) {
            throw new RuntimeException('That username is already in use.');
        }

        if ($newPassword !== null && $newPassword !== '') {
            self::validatePassword($newPassword);
        } else {
            $newPassword = null;
        }

        $permissionIds = self::validatedPermissionIds($permissionIds);

        $pdo->beginTransaction();

        try {
            if ($newPassword !== null) {
                $stmt = $pdo->prepare(
                    "UPDATE users
                     SET username = :username,
                         display_name = :display_name,
                         status = :status,
                         password_hash = :password_hash
                     WHERE id = :id AND role = 'editor'"
                );

                $stmt->execute([
                    ':username' => $username,
                    ':display_name' => $displayName,
                    ':status' => $status,
                    ':password_hash' => password_hash($newPassword, PASSWORD_DEFAULT),
                    ':id' => $editorId,
                ]);
            } else {
                $stmt = $pdo->prepare(
                    "UPDATE users
                     SET username = :username,
                         display_name = :display_name,
                         status = :status
                     WHERE id = :id AND role = 'editor'"
                );

                $stmt->execute([
                    ':username' => $username,
                    ':display_name' => $displayName,
                    ':status' => $status,
                    ':id' => $editorId,
                ]);
            }

            self::replacePermissionsInternal($pdo, $editorId, $permissionIds);
            $pdo->commit();
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }
    }

    public static function deleteEditor(int $editorId): void
    {
        $pdo = Database::connection();

        $editor = self::findEditor($editorId);

        if ($editor === null) {
            throw new RuntimeException('Editor account not found.');
        }

        $stmt = $pdo->prepare(
            "DELETE FROM users WHERE id = :id AND role = 'editor'"
        );
        $stmt->execute([':id' => $editorId]);

        if ($stmt->rowCount() !== 1) {
            throw new RuntimeException('Editor account could not be deleted.');
        }
    }

    private static function replacePermissionsInternal(PDO $pdo, int $editorId, array $permissionIds): void
    {
        $delete = $pdo->prepare(
            'DELETE FROM user_permissions WHERE user_id = :user_id'
        );
        $delete->execute([':user_id' => $editorId]);

        if ($permissionIds === []) {
            return;
        }

        $insert = $pdo->prepare(
            'INSERT INTO user_permissions (user_id, permission_id)
             VALUES (:user_id, :permission_id)'
        );

        foreach ($permissionIds as $permissionId) {
            $insert->execute([
                ':user_id' => $editorId,
                ':permission_id' => $permissionId,
            ]);
        }
    }

    private static function validatedPermissionIds(array $permissionIds): array
    {
        $permissionIds = array_values(array_unique(array_filter(
            array_map('intval', $permissionIds),
            static fn(int $id): bool => $id > 0
        )));

        if ($permissionIds === []) {
            return [];
        }

        $pdo = Database::connection();
        $placeholders = implode(',', array_fill(0, count($permissionIds), '?'));
        $stmt = $pdo->prepare(
            "SELECT id FROM permissions WHERE id IN ({$placeholders})"
        );
        $stmt->execute($permissionIds);

        $valid = array_map(
            static fn($id): int => (int) $id,
            $stmt->fetchAll(PDO::FETCH_COLUMN)
        );

        sort($valid);
        return $valid;
    }

    private static function usernameExists(string $username, ?int $exceptId = null): bool
    {
        $pdo = Database::connection();

        $sql = 'SELECT id FROM users WHERE username = :username';
        $params = [':username' => $username];

        if ($exceptId !== null) {
            $sql .= ' AND id != :except_id';
            $params[':except_id'] = $exceptId;
        }

        $sql .= ' LIMIT 1';

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchColumn() !== false;
    }

    private static function normalizeUsername(string $username): string
    {
        return strtolower(trim($username));
    }

    private static function validateUsername(string $username): void
    {
        if ($username === '' || strlen($username) < 3 || strlen($username) > 100) {
            throw new RuntimeException('Username must contain 3 to 100 characters.');
        }

        if (!preg_match('/^[a-z0-9][a-z0-9._-]*$/', $username)) {
            throw new RuntimeException(
                'Username may contain only lowercase letters, numbers, dots, underscores, and hyphens.'
            );
        }
    }

    private static function validateDisplayName(string $displayName): void
    {
        if ($displayName === '' || strlen($displayName) > 150) {
            throw new RuntimeException('Display name is required and must not exceed 150 characters.');
        }
    }

    private static function validatePassword(string $password): void
    {
        if (strlen($password) < PASSWORD_MIN_LENGTH) {
            throw new RuntimeException(
                'Password must contain at least ' . PASSWORD_MIN_LENGTH . ' characters.'
            );
        }
    }

    private static function validateStatus(string $status): void
    {
        if (!in_array($status, ['active', 'inactive'], true)) {
            throw new RuntimeException('Invalid editor status.');
        }
    }
}
