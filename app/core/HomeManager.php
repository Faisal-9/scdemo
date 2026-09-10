<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

final class HomeManager
{
    public static function heroSlides(): array
    {
        return Database::connection()->query(
            'SELECT * FROM home_hero_slides ORDER BY sort_order ASC, id ASC'
        )->fetchAll();
    }

    public static function slide(int $id): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM home_hero_slides WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return is_array($row) ? $row : null;
    }

    public static function saveSlide(array $data, ?int $id = null): int
    {
        $pdo = Database::connection();
        $title = trim((string) ($data['title'] ?? ''));
        $image = trim((string) ($data['image_path'] ?? ''));
        if ($title === '') throw new RuntimeException('Hero slide title is required.');
        if ($image === '') throw new RuntimeException('Hero slide image path is required.');

        if ($id === null) {
            $stmt = $pdo->prepare(
                'INSERT INTO home_hero_slides
                    (legacy_id, title, description, image_path, indicator, sort_order, is_active)
                 VALUES
                    (:legacy_id, :title, :description, :image_path, :indicator, :sort_order, :is_active)'
            );
            $stmt->execute([
                ':legacy_id' => self::nullable($data['legacy_id'] ?? null),
                ':title' => $title,
                ':description' => self::nullable($data['description'] ?? null),
                ':image_path' => $image,
                ':indicator' => self::nullable($data['indicator'] ?? null),
                ':sort_order' => max(0, (int) ($data['sort_order'] ?? 0)),
                ':is_active' => !empty($data['is_active']) ? 1 : 0,
            ]);
            return (int) $pdo->lastInsertId();
        }

        if (self::slide($id) === null) throw new RuntimeException('Hero slide not found.');
        $stmt = $pdo->prepare(
            'UPDATE home_hero_slides
             SET legacy_id = :legacy_id,
                 title = :title,
                 description = :description,
                 image_path = :image_path,
                 indicator = :indicator,
                 sort_order = :sort_order,
                 is_active = :is_active
             WHERE id = :id'
        );
        $stmt->execute([
            ':legacy_id' => self::nullable($data['legacy_id'] ?? null),
            ':title' => $title,
            ':description' => self::nullable($data['description'] ?? null),
            ':image_path' => $image,
            ':indicator' => self::nullable($data['indicator'] ?? null),
            ':sort_order' => max(0, (int) ($data['sort_order'] ?? 0)),
            ':is_active' => !empty($data['is_active']) ? 1 : 0,
            ':id' => $id,
        ]);
        return $id;
    }

    public static function stats(): array
    {
        return Database::connection()->query(
            'SELECT * FROM home_stats ORDER BY sort_order ASC, id ASC'
        )->fetchAll();
    }

    public static function statsBackground(): string
    {
        $stmt = Database::connection()->prepare('SELECT setting_value FROM site_settings WHERE setting_key = :key LIMIT 1');
        $stmt->execute([':key' => 'home_stats_background']);
        $value = $stmt->fetchColumn();
        return $value === false ? 'assets/images/home/whybg1.jpg' : (string) $value;
    }

    public static function saveStat(array $data, ?int $id = null): int
    {
        $pdo = Database::connection();
        $label = trim((string) ($data['label'] ?? ''));
        if ($label === '') throw new RuntimeException('Statistic label is required.');
        $number = (string) ($data['number_value'] ?? '0');
        if (!is_numeric($number)) throw new RuntimeException('Statistic number must be numeric.');

        $params = [
            ':prefix' => self::nullable($data['prefix'] ?? null),
            ':number_value' => (float) $number,
            ':suffix' => self::nullable($data['suffix'] ?? null),
            ':label' => $label,
            ':sort_order' => max(0, (int) ($data['sort_order'] ?? 0)),
            ':is_active' => !empty($data['is_active']) ? 1 : 0,
        ];
        if ($id === null) {
            $stmt = $pdo->prepare('INSERT INTO home_stats (prefix, number_value, suffix, label, sort_order, is_active) VALUES (:prefix,:number_value,:suffix,:label,:sort_order,:is_active)');
            $stmt->execute($params);
            return (int) $pdo->lastInsertId();
        }
        $params[':id'] = $id;
        $stmt = $pdo->prepare('UPDATE home_stats SET prefix=:prefix, number_value=:number_value, suffix=:suffix, label=:label, sort_order=:sort_order, is_active=:is_active WHERE id=:id');
        $stmt->execute($params);
        return $id;
    }

    public static function history(): array
    {
        return Database::connection()->query('SELECT * FROM home_history ORDER BY sort_order ASC, id ASC')->fetchAll();
    }

    public static function saveHistory(array $data, ?int $id = null): int
    {
        $pdo = Database::connection();
        $year = trim((string) ($data['year'] ?? ''));
        $title = trim((string) ($data['title'] ?? ''));
        if ($year === '' || $title === '') throw new RuntimeException('History year and title are required.');
        $params = [':year'=>$year, ':title'=>$title, ':sort_order'=>max(0,(int)($data['sort_order']??0)), ':is_active'=>!empty($data['is_active'])?1:0];
        if ($id === null) {
            $stmt=$pdo->prepare('INSERT INTO home_history (year,title,sort_order,is_active) VALUES (:year,:title,:sort_order,:is_active)'); $stmt->execute($params); return (int)$pdo->lastInsertId();
        }
        $params[':id']=$id; $stmt=$pdo->prepare('UPDATE home_history SET year=:year,title=:title,sort_order=:sort_order,is_active=:is_active WHERE id=:id'); $stmt->execute($params); return $id;
    }

    public static function whyTabs(): array
    {
        $pdo = Database::connection();
        $tabs = $pdo->query('SELECT * FROM home_why_tabs ORDER BY sort_order ASC, id ASC')->fetchAll();
        $itemsStmt = $pdo->prepare('SELECT * FROM home_why_items WHERE tab_id=:tab_id ORDER BY sort_order ASC, id ASC');
        foreach ($tabs as &$tab) {
            $itemsStmt->execute([':tab_id' => (int)$tab['id']]);
            $tab['items'] = $itemsStmt->fetchAll();
        }
        unset($tab);
        return $tabs;
    }

    public static function saveWhyTab(array $data, ?int $id = null): int
    {
        $pdo = Database::connection();
        $tabName = trim((string)($data['tab_name'] ?? ''));
        if ($tabName === '') throw new RuntimeException('Why State Corps tab name is required.');
        $pdo->beginTransaction();
        try {
            $params = [':legacy_id'=>self::nullable($data['legacy_id']??null), ':tab_name'=>$tabName, ':title'=>self::nullable($data['title']??null), ':image_path'=>self::nullable($data['image_path']??null), ':sort_order'=>max(0,(int)($data['sort_order']??0)), ':is_active'=>!empty($data['is_active'])?1:0];
            if ($id === null) {
                $stmt=$pdo->prepare('INSERT INTO home_why_tabs (legacy_id,tab_name,title,image_path,sort_order,is_active) VALUES (:legacy_id,:tab_name,:title,:image_path,:sort_order,:is_active)'); $stmt->execute($params); $id=(int)$pdo->lastInsertId();
            } else {
                $params[':id']=$id; $stmt=$pdo->prepare('UPDATE home_why_tabs SET legacy_id=:legacy_id,tab_name=:tab_name,title=:title,image_path=:image_path,sort_order=:sort_order,is_active=:is_active WHERE id=:id'); $stmt->execute($params);
            }
            $pdo->prepare('DELETE FROM home_why_items WHERE tab_id=:id')->execute([':id'=>$id]);
            $itemStmt=$pdo->prepare('INSERT INTO home_why_items (tab_id,item_text,sort_order) VALUES (:tab_id,:item_text,:sort_order)');
            foreach ((array)($data['items']??[]) as $order=>$text) { $text=trim((string)$text); if($text==='') continue; $itemStmt->execute([':tab_id'=>$id,':item_text'=>$text,':sort_order'=>$order]); }
            $pdo->commit(); return $id;
        } catch(Throwable $e){ if($pdo->inTransaction())$pdo->rollBack(); throw $e; }
    }

    public static function delete(string $table, int $id): void
    {
        $allowed = ['home_hero_slides','home_stats','home_history','home_why_tabs'];
        if (!in_array($table,$allowed,true)) throw new RuntimeException('Invalid homepage record type.');
        $stmt=Database::connection()->prepare("DELETE FROM {$table} WHERE id=:id"); $stmt->execute([':id'=>$id]);
        if($stmt->rowCount()!==1) throw new RuntimeException('Homepage record not found.');
    }

    public static function saveStatsBackground(string $path): void
    {
        $path=trim($path); if($path==='') throw new RuntimeException('Statistics background image path is required.');
        $pdo=Database::connection();
        $stmt=$pdo->prepare('INSERT INTO site_settings (setting_key,setting_value,setting_type,description) VALUES (:key,:value,\'image\',\'Homepage statistics background image\') ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value),setting_type=VALUES(setting_type),description=VALUES(description)');
        $stmt->execute([':key'=>'home_stats_background',':value'=>$path]);
    }

    private static function nullable(mixed $value): ?string { if($value===null)return null; $value=trim((string)$value); return $value===''?null:$value; }
}
