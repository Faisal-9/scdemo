<?php

declare(strict_types=1);

/*
 * CLI-only bootstrap for the first Admin account.
 * Never make this reachable from the browser.
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("CLI only.\n");
}

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/core/Database.php';

function prompt(string $message): string
{
    echo $message;
    return trim((string) fgets(STDIN));
}

function promptHidden(string $message): string
{
    echo $message;

    if (DIRECTORY_SEPARATOR === '\\') {
        $value = trim((string) fgets(STDIN));
        echo PHP_EOL;
        return $value;
    }

    $command = '/usr/bin/env bash -c ' . escapeshellarg(
        'read -s value; printf "%s" "$value"'
    );

    $value = shell_exec($command);
    echo PHP_EOL;

    return trim((string) $value);
}

$pdo = Database::connection();

$adminCount = (int) $pdo->query(
    "SELECT COUNT(*) FROM users WHERE role = 'admin'"
)->fetchColumn();

if ($adminCount >= 1) {
    exit("An Admin already exists. No new Admin was created.\n");
}

$username = prompt('Admin username: ');
$displayName = prompt('Admin display name: ');
$password = promptHidden('Admin password (minimum 12 characters): ');
$password2 = promptHidden('Confirm password: ');

if ($username === '' || $displayName === '') {
    exit("Username and display name are required.\n");
}

if (strlen($password) < PASSWORD_MIN_LENGTH) {
    exit("Password must be at least " . PASSWORD_MIN_LENGTH . " characters.\n");
}

if (!hash_equals($password, $password2)) {
    exit("Passwords do not match.\n");
}

$duplicate = $pdo->prepare(
    'SELECT COUNT(*) FROM users WHERE username = :username'
);
$duplicate->execute([':username' => $username]);

if ((int) $duplicate->fetchColumn() > 0) {
    exit("That username is already in use.\n");
}

$stmt = $pdo->prepare(
    'INSERT INTO users
        (username, display_name, password_hash, role, status)
     VALUES
        (:username, :display_name, :password_hash, \'admin\', \'active\')'
);

$stmt->execute([
    ':username' => $username,
    ':display_name' => $displayName,
    ':password_hash' => password_hash($password, PASSWORD_DEFAULT),
]);

echo "Admin account created successfully.\n";
echo "You may now sign in at: " . adminUrl() . PHP_EOL;
