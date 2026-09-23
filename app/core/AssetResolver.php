<?php

declare(strict_types=1);

final class AssetResolver
{
    private static array $paths = [];
    private static array $relativePaths = [];

    public static function id(mixed $value): ?int
    {
        $id = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        return $id === false ? null : (int)$id;
    }

    public static function path(mixed $value): string
    {
        $id = self::id($value);
        if ($id === null) return '';
        if (array_key_exists($id, self::$paths)) return self::$paths[$id];
        $stmt = Database::connection()->prepare('SELECT relative_path FROM media_library WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return self::$paths[$id] = self::resolveRelativePath((string)($stmt->fetchColumn() ?: ''));
    }

    public static function resolveRelativePath(string $relative): string
    {
        $relative = ltrim(str_replace('\\', '/', $relative), '/');
        if ($relative === '' || str_starts_with($relative, 'assets/')) {
            return $relative;
        }
        if (isset(self::$relativePaths[$relative])) {
            return self::$relativePaths[$relative];
        }

        if (str_starts_with($relative, 'uploads/')) {
            $filename = basename($relative);
            $root = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'uploads';
            $directPath = $root . DIRECTORY_SEPARATOR . $filename;
            if (is_file($directPath)) {
                return self::$relativePaths[$relative] = 'assets/uploads/' . $filename;
            }
            if (is_dir($root)) {
                $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS));
                foreach ($files as $file) {
                    if ($file->isFile() && $file->getFilename() === $filename) {
                        $rootPrefix = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR;
                        return self::$relativePaths[$relative] = ltrim(str_replace(DIRECTORY_SEPARATOR, '/', substr($file->getPathname(), strlen($rootPrefix))), '/');
                    }
                }
            }
        }

        return self::$relativePaths[$relative] = $relative;
    }

    public static function hydrate(array $row, array $map): array
    {
        foreach ($map as $idKey => $pathKey) {
            if (array_key_exists($idKey, $row)) $row[$pathKey] = self::path($row[$idKey]);
        }
        return $row;
    }
}
