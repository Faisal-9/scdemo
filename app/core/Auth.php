<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Session.php';
require_once __DIR__ . '/../helpers/functions.php';

final class Auth
{
    public static function attempt(string $username, string $password): bool
    {
        $pdo = Database::connection();
        $ip = clientIp();

        if (!self::canAttemptLogin($username, $ip)) {
            return false;
        }

        $stmt = $pdo->prepare(
            'SELECT id, username, display_name, password_hash, role, status
             FROM users
             WHERE username = :username
             LIMIT 1'
        );

        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch();

        $valid = is_array($user)
            && $user['status'] === 'active'
            && password_verify($password, (string) $user['password_hash']);

        if (!$valid) {
            self::recordLoginAttempt($username, $ip, false);
            return false;
        }

        Session::regenerate();

        $_SESSION['user'] = [
            'id' => (int) $user['id'],
            'username' => (string) $user['username'],
            'display_name' => (string) $user['display_name'],
            'role' => (string) $user['role'],
            'logged_in_at' => time(),
        ];

        $update = $pdo->prepare(
            'UPDATE users SET last_login_at = NOW() WHERE id = :id'
        );
        $update->execute([':id' => (int) $user['id']]);

        self::recordLoginAttempt($username, $ip, true);
        self::audit(
            (int) $user['id'],
            'login',
            'user',
            (int) $user['id'],
            'Successful CMS login.'
        );

        return true;
    }

    public static function logout(): void
    {
        $user = self::user();

        if ($user !== null) {
            self::audit(
                (int) $user['id'],
                'logout',
                'user',
                (int) $user['id'],
                'CMS logout.'
            );
        }

        Session::destroy();
    }

    public static function check(): bool
    {
        return isset($_SESSION['user']) && is_array($_SESSION['user']);
    }

    public static function user(): ?array
    {
        return self::check() ? $_SESSION['user'] : null;
    }

    public static function id(): ?int
    {
        $user = self::user();
        return $user === null ? null : (int) $user['id'];
    }

    public static function role(): ?string
    {
        $user = self::user();
        return $user === null ? null : (string) $user['role'];
    }

    public static function isAdmin(): bool
    {
        return self::role() === 'admin';
    }

    public static function hasPermission(string $permissionKey): bool
    {
        if (!self::check()) {
            return false;
        }

        if (self::isAdmin()) {
            return true;
        }

        $pdo = Database::connection();

        $stmt = $pdo->prepare(
            'SELECT 1
             FROM user_permissions up
             INNER JOIN permissions p ON p.id = up.permission_id
             INNER JOIN users u ON u.id = up.user_id
             WHERE up.user_id = :user_id
               AND p.permission_key = :permission_key
               AND u.status = \'active\'
             LIMIT 1'
        );

        $stmt->execute([
            ':user_id' => self::id(),
            ':permission_key' => $permissionKey,
        ]);

        return (bool) $stmt->fetchColumn();
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            redirect(adminUrl());
        }
    }

    public static function requireAdmin(): void
    {
        self::requireLogin();

        if (!self::isAdmin()) {
            http_response_code(403);
            exit('Access denied.');
        }
    }

    public static function requirePermission(string $permissionKey): void
    {
        self::requireLogin();

        if (!self::hasPermission($permissionKey)) {
            http_response_code(403);
            exit('You are not authorized to access this area.');
        }
    }

    private static function canAttemptLogin(string $username, string $ip): bool
    {
        $pdo = Database::connection();

        $since = date(
            'Y-m-d H:i:s',
            time() - LOGIN_WINDOW_SECONDS
        );

        $stmt = $pdo->prepare(
            'SELECT COUNT(*)
             FROM login_attempts
             WHERE success = 0
               AND attempted_at >= :since
               AND (username = :username OR ip_address = :ip)'
        );

        $stmt->execute([
            ':since' => $since,
            ':username' => $username,
            ':ip' => $ip,
        ]);

        return (int) $stmt->fetchColumn() < LOGIN_MAX_ATTEMPTS;
    }

    private static function recordLoginAttempt(
        string $username,
        string $ip,
        bool $success
    ): void {
        $pdo = Database::connection();

        $stmt = $pdo->prepare(
            'INSERT INTO login_attempts
                (username, ip_address, success, attempted_at)
             VALUES
                (:username, :ip_address, :success, NOW())'
        );

        $stmt->execute([
            ':username' => $username,
            ':ip_address' => $ip,
            ':success' => $success ? 1 : 0,
        ]);
    }

    public static function audit(
        ?int $userId,
        string $action,
        ?string $entityType = null,
        ?int $entityId = null,
        ?string $description = null
    ): void {
        $pdo = Database::connection();

        $stmt = $pdo->prepare(
            'INSERT INTO audit_logs
                (user_id, action, entity_type, entity_id, description, ip_address, user_agent)
             VALUES
                (:user_id, :action, :entity_type, :entity_id, :description, :ip_address, :user_agent)'
        );

        $stmt->execute([
            ':user_id' => $userId,
            ':action' => $action,
            ':entity_type' => $entityType,
            ':entity_id' => $entityId,
            ':description' => $description,
            ':ip_address' => clientIp(),
            ':user_agent' => substr(
                (string) ($_SERVER['HTTP_USER_AGENT'] ?? ''),
                0,
                500
            ),
        ]);
    }
}
