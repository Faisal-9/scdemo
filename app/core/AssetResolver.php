<?php

declare(strict_types=1);

final class AssetResolver
{
    private static array $paths = [];

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
        return self::$paths[$id] = (string)($stmt->fetchColumn() ?: '');
    }

    public static function hydrate(array $row, array $map): array
    {
        foreach ($map as $idKey => $pathKey) {
            if (array_key_exists($idKey, $row)) $row[$pathKey] = self::path($row[$idKey]);
        }
        return $row;
    }
}
