<?php

declare(strict_types=1);

final class AssetManager
{
    private const ALLOWED = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
        'application/pdf' => 'pdf',
    ];

    private const MAX_IMAGE_BYTES = 8 * 1024 * 1024;
    private const MAX_PDF_BYTES   = 15 * 1024 * 1024;

    public static function all(string $search = '', string $type = ''): array
    {
        $pdo = Database::connection();
        $where = [];
        $params = [];

        if ($search !== '') {
            $where[] = '(original_name LIKE :q OR alt_text LIKE :q OR category LIKE :q)';
            $params['q'] = '%' . $search . '%';
        }
        if ($type === 'image') {
            $where[] = "mime_type LIKE 'image/%'";
        } elseif ($type === 'pdf') {
            $where[] = "mime_type = 'application/pdf'";
        }

        $sql = 'SELECT * FROM media_library';
        if ($where) $sql .= ' WHERE ' . implode(' AND ', $where);
        $sql .= ' ORDER BY created_at DESC, id DESC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM media_library WHERE id=? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function upload(array $file, string $category = '', string $altText = ''): int
    {
        if (!isset($file['error']) || is_array($file['error'])) {
            throw new InvalidArgumentException('Invalid upload payload.');
        }
        if ((int)$file['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException(self::uploadError((int)$file['error']));
        }
        if (!isset($file['tmp_name'], $file['name'], $file['size'])) {
            throw new InvalidArgumentException('Incomplete upload information.');
        }

        $size = (int)$file['size'];
        if ($size <= 0) throw new InvalidArgumentException('The uploaded file is empty.');

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = (string)$finfo->file($file['tmp_name']);
        if (!isset(self::ALLOWED[$mime])) {
            throw new InvalidArgumentException('File type is not allowed. Upload JPG, PNG, WEBP, GIF, or PDF only.');
        }

        $extension = self::ALLOWED[$mime];
        $limit = $mime === 'application/pdf' ? self::MAX_PDF_BYTES : self::MAX_IMAGE_BYTES;
        if ($size > $limit) {
            throw new InvalidArgumentException('The uploaded file exceeds the permitted size.');
        }

        if (str_starts_with($mime, 'image/')) {
            $imageInfo = @getimagesize($file['tmp_name']);
            if ($imageInfo === false || empty($imageInfo[0]) || empty($imageInfo[1])) {
                throw new InvalidArgumentException('The uploaded image could not be validated.');
            }
        }

        $original = basename((string)$file['name']);
        $original = mb_substr($original, 0, 255);
        $category = self::cleanCategory($category);
        $altText = mb_substr(trim($altText), 0, 500);

        if (!is_uploaded_file($file['tmp_name'])) throw new RuntimeException('Upload validation failed.');
        $stored = bin2hex(random_bytes(16)) . '.' . $extension;
        $relative = 'uploads/' . $stored;
        $root = self::uploadRoot();
        if (!is_dir($root) && !@mkdir($root, 0775, true) && !is_dir($root)) {
            throw new RuntimeException('The upload directory could not be created.');
        }
        $absolute = $root . DIRECTORY_SEPARATOR . $stored;
        if (!@move_uploaded_file($file['tmp_name'], $absolute)) {
            throw new RuntimeException('The uploaded file could not be stored.');
        }
        $userId = Auth::id();

        try {
            $stmt = Database::connection()->prepare(
                 'INSERT INTO media_library (original_name, stored_name, relative_path, mime_type, file_size, alt_text, category, created_by)
                  VALUES (?,?,?,?,?,?,?,?)'
            );
              $stmt->execute([$original, $stored, $relative, $mime, $size, $altText ?: null, $category ?: null, $userId]);
            $id = (int)Database::connection()->lastInsertId();
        } catch (Throwable $e) {
            @unlink($absolute);
            throw $e;
        }

        self::audit('create', $id, 'Uploaded asset: ' . $original);
        return $id;
    }

    public static function updateMeta(int $id, string $altText, string $category): void
    {
        $row = self::find($id);
        if (!$row) throw new RuntimeException('Asset not found.');
        $altText = mb_substr(trim($altText), 0, 500);
        $category = self::cleanCategory($category);
        $stmt = Database::connection()->prepare('UPDATE media_library SET alt_text=?, category=?, updated_at=NOW() WHERE id=?');
        $stmt->execute([$altText ?: null, $category ?: null, $id]);
        self::audit('update', $id, 'Updated asset metadata: ' . $row['original_name']);
    }

    public static function delete(int $id): void
    {
        $row = self::find($id);
        if (!$row) throw new RuntimeException('Asset not found.');

        $path = self::absoluteFromRelative((string)$row['relative_path']);
        $stmt = Database::connection()->prepare('DELETE FROM media_library WHERE id=?');
        $stmt->execute([$id]);
        if ($stmt->rowCount() !== 1) throw new RuntimeException('Asset could not be deleted.');
        if (is_file($path)) @unlink($path);
        self::audit('delete', $id, 'Deleted asset: ' . $row['original_name']);
    }

    public static function relativePath(int $id): string
    {
        $row = self::find($id);
        if (!$row) throw new RuntimeException('Asset not found.');
        return (string)$row['relative_path'];
    }

    private static function uploadRoot(): string
    {
        return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'uploads';
    }

    private static function absoluteFromRelative(string $relative): string
    {
        $relative = ltrim(str_replace(['\\', '..'], ['/', ''], $relative), '/');
        if (!str_starts_with($relative, 'assets/uploads/')) {
            throw new RuntimeException('Refusing to delete a file outside the upload library.');
        }
        return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);
    }

    private static function cleanCategory(string $category): string
    {
        $category = trim($category);
        if ($category === '') return '';
        if (!preg_match('/^[a-zA-Z0-9 _-]{1,80}$/', $category)) {
            throw new InvalidArgumentException('Category contains invalid characters.');
        }
        return $category;
    }

    private static function uploadError(int $code): string
    {
        return match ($code) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'The uploaded file is too large.',
            UPLOAD_ERR_PARTIAL => 'The upload was incomplete.',
            UPLOAD_ERR_NO_FILE => 'Please choose a file.',
            UPLOAD_ERR_NO_TMP_DIR => 'Temporary upload directory is unavailable.',
            UPLOAD_ERR_CANT_WRITE => 'The server could not write the uploaded file.',
            UPLOAD_ERR_EXTENSION => 'The upload was blocked by a server extension.',
            default => 'The upload failed.',
        };
    }

    private static function audit(string $action, int $id, string $description): void
    {
        if (class_exists('AuditLogger')) {
            AuditLogger::log($action, 'media_asset', $id, $description);
        }
    }
}
