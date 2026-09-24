<?php

declare(strict_types=1);

require_once __DIR__ . '/app/public_bootstrap.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if (!$id) {
    http_response_code(404);
    exit;
}

$stmt = Database::connection()->prepare(
    'SELECT mime_type, file_size, checksum, relative_path FROM media_library WHERE id = ? AND status = \'active\' LIMIT 1'
);
$stmt->execute([(int)$id]);
$asset = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$asset || !str_starts_with((string)$asset['relative_path'], 'uploads/')) {
    http_response_code(404);
    exit;
}

$filename = basename((string)$asset['relative_path']);
$path = __DIR__ . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $filename;
if (!is_file($path)) {
    http_response_code(404);
    exit;
}

header('Content-Type: ' . (string)$asset['mime_type']);
header('Content-Length: ' . (string)filesize($path));
header('Cache-Control: public, max-age=86400');
header('ETag: "' . (string)$asset['checksum'] . '"');
header('X-Content-Type-Options: nosniff');
readfile($path);