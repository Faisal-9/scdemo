<?php

declare(strict_types=1);

require_once __DIR__ . '/Database.php';

final class AboutManager
{
    private const SECTION_ORDER = [
        'general-info', 'mission-vision', 'clients', 'certificates',
        'awards', 'sister', 'hse', 'cprofile'
    ];

    public static function sections(): array
    {
        return Database::connection()->query(
            'SELECT * FROM about_sections ORDER BY sort_order ASC, id ASC'
        )->fetchAll();
    }

    public static function section(string $legacyId): ?array
    {
        $stmt = Database::connection()->prepare(
            'SELECT * FROM about_sections WHERE legacy_id = :legacy_id LIMIT 1'
        );
        $stmt->execute([':legacy_id' => $legacyId]);
        $row = $stmt->fetch();
        return is_array($row) ? $row : null;
    }

    public static function saveSection(array $data, ?int $id = null): int
    {
        $pdo = Database::connection();
        $legacyId = trim((string)($data['legacy_id'] ?? ''));
        $title = trim((string)($data['title'] ?? ''));
        if ($legacyId === '' || $title === '') {
            throw new RuntimeException('Section ID and title are required.');
        }

        $params = [
            ':legacy_id' => $legacyId,
            ':title' => $title,
            ':sort_order' => max(0, (int)($data['sort_order'] ?? 0)),
            ':is_active' => !empty($data['is_active']) ? 1 : 0,
        ];

        if ($id === null) {
            $stmt = $pdo->prepare(
                'INSERT INTO about_sections (legacy_id, title, sort_order, is_active)
                 VALUES (:legacy_id, :title, :sort_order, :is_active)'
            );
            $stmt->execute($params);
            return (int)$pdo->lastInsertId();
        }

        $params[':id'] = $id;
        $stmt = $pdo->prepare(
            'UPDATE about_sections
             SET legacy_id=:legacy_id, title=:title, sort_order=:sort_order, is_active=:is_active
             WHERE id=:id'
        );
        $stmt->execute($params);
        return $id;
    }

    public static function generalInfo(): ?array
    {
        $row = Database::connection()->query('SELECT * FROM about_general WHERE id=1')->fetch();
        return is_array($row) ? $row : null;
    }

    public static function saveGeneralInfo(array $data): void
    {
        $title = trim((string)($data['title'] ?? ''));
        $content = trim((string)($data['content'] ?? ''));
        if ($title === '' || $content === '') throw new RuntimeException('Overview title and content are required.');
        $stmt = Database::connection()->prepare(
            'INSERT INTO about_general (id,title,content) VALUES (1,:title,:content)
             ON DUPLICATE KEY UPDATE title=VALUES(title),content=VALUES(content)'
        );
        $stmt->execute([':title'=>$title, ':content'=>$content]);
    }

    public static function timeline(): array
    {
        return Database::connection()->query(
            'SELECT * FROM about_timeline ORDER BY sort_order ASC, id ASC'
        )->fetchAll();
    }

    public static function timelineItem(int $id): ?array
    {
        $stmt=Database::connection()->prepare('SELECT * FROM about_timeline WHERE id=:id LIMIT 1');
        $stmt->execute([':id'=>$id]); $row=$stmt->fetch();
        return is_array($row)?$row:null;
    }

    public static function saveTimeline(array $data, ?int $id=null): int
    {
        $pdo=Database::connection();
        $year=trim((string)($data['year']??''));
        $title=trim((string)($data['title']??''));
        $description=trim((string)($data['description']??''));
        $image=trim((string)($data['image_path']??''));
        if($year===''||$title===''||$description===''||$image==='') throw new RuntimeException('All timeline fields are required.');
        $params=[':year'=>$year,':title'=>$title,':description'=>$description,':image_path'=>$image,':sort_order'=>max(0,(int)($data['sort_order']??0)),':is_active'=>!empty($data['is_active'])?1:0];
        if($id===null){
            $st=$pdo->prepare('INSERT INTO about_timeline (year,title,description,image_path,sort_order,is_active) VALUES (:year,:title,:description,:image_path,:sort_order,:is_active)');
            $st->execute($params); return (int)$pdo->lastInsertId();
        }
        $params[':id']=$id;
        $st=$pdo->prepare('UPDATE about_timeline SET year=:year,title=:title,description=:description,image_path=:image_path,sort_order=:sort_order,is_active=:is_active WHERE id=:id');
        $st->execute($params); return $id;
    }

    public static function missionVision(): ?array
    {
        $row=Database::connection()->query('SELECT * FROM about_mission_vision WHERE id=1')->fetch();
        return is_array($row)?$row:null;
    }

    public static function saveMissionVision(array $data): void
    {
        $required=['title','mission','mission_img','vision','vision_img','core_values_img'];
        foreach($required as $key){ if(trim((string)($data[$key]??''))==='') throw new RuntimeException('Mission & Vision: '.$key.' is required.'); }
        $pdo=Database::connection();
        $st=$pdo->prepare('INSERT INTO about_mission_vision (id,title,mission,mission_img,vision,vision_img,core_values_img) VALUES (1,:title,:mission,:mission_img,:vision,:vision_img,:core_values_img) ON DUPLICATE KEY UPDATE title=VALUES(title),mission=VALUES(mission),mission_img=VALUES(mission_img),vision=VALUES(vision),vision_img=VALUES(vision_img),core_values_img=VALUES(core_values_img)');
        $st->execute([':title'=>trim((string)$data['title']),':mission'=>trim((string)$data['mission']),':mission_img'=>trim((string)$data['mission_img']),':vision'=>trim((string)$data['vision']),':vision_img'=>trim((string)$data['vision_img']),':core_values_img'=>trim((string)$data['core_values_img'])]);
    }

    public static function coreValues(): array { return Database::connection()->query('SELECT * FROM about_core_values ORDER BY sort_order ASC,id ASC')->fetchAll(); }
    public static function coreValue(int $id): ?array { $st=Database::connection()->prepare('SELECT * FROM about_core_values WHERE id=:id LIMIT 1');$st->execute([':id'=>$id]);$r=$st->fetch();return is_array($r)?$r:null; }
    public static function saveCoreValue(array $data, ?int $id=null): int {
        $text=trim((string)($data['value_text']??'')); if($text==='') throw new RuntimeException('Core value text is required.');
        $p=[':value_text'=>$text,':sort_order'=>max(0,(int)($data['sort_order']??0)),':is_active'=>!empty($data['is_active'])?1:0]; $pdo=Database::connection();
        if($id===null){$st=$pdo->prepare('INSERT INTO about_core_values (value_text,sort_order,is_active) VALUES (:value_text,:sort_order,:is_active)');$st->execute($p);return (int)$pdo->lastInsertId();}
        $p[':id']=$id;$st=$pdo->prepare('UPDATE about_core_values SET value_text=:value_text,sort_order=:sort_order,is_active=:is_active WHERE id=:id');$st->execute($p);return $id;
    }

    public static function items(string $type): array
    {
        $table = self::tableFor($type);
        return Database::connection()->query("SELECT * FROM {$table} ORDER BY sort_order ASC,id ASC")->fetchAll();
    }

    public static function item(string $type,int $id): ?array
    {
        $table=self::tableFor($type);$st=Database::connection()->prepare("SELECT * FROM {$table} WHERE id=:id LIMIT 1");$st->execute([':id'=>$id]);$r=$st->fetch();return is_array($r)?$r:null;
    }

    public static function saveItem(string $type,array $data,?int $id=null): int
    {
        $pdo=Database::connection(); $table=self::tableFor($type);
        if($type==='clients'){$name=null;$path='logo_path';$title=null;}
        else {$name=trim((string)($data['name']??''));$path='logo_path';$title=null;}
        if($type==='clients'){$logo=trim((string)($data['logo_path']??''));if($logo==='')throw new RuntimeException('Client logo path is required.');}
        else {$logo=trim((string)($data['logo_path']??''));if($name===''||$logo==='')throw new RuntimeException('Name and logo path are required.');}
        $p=[':name'=>$name,':logo_path'=>$logo,':sort_order'=>max(0,(int)($data['sort_order']??0)),':is_active'=>!empty($data['is_active'])?1:0];
        if($type==='clients'){$sqlInsert="INSERT INTO {$table} (name,logo_path,sort_order,is_active) VALUES (:name,:logo_path,:sort_order,:is_active)";$sqlUpdate="UPDATE {$table} SET name=:name,logo_path=:logo_path,sort_order=:sort_order,is_active=:is_active WHERE id=:id";}
        else {$sqlInsert="INSERT INTO {$table} (name,logo_path,sort_order,is_active) VALUES (:name,:logo_path,:sort_order,:is_active)";$sqlUpdate="UPDATE {$table} SET name=:name,logo_path=:logo_path,sort_order=:sort_order,is_active=:is_active WHERE id=:id";}
        if($id===null){$st=$pdo->prepare($sqlInsert);$st->execute($p);return (int)$pdo->lastInsertId();}
        $p[':id']=$id;$st=$pdo->prepare($sqlUpdate);$st->execute($p);return $id;
    }

    public static function hse(): ?array { $r=Database::connection()->query('SELECT * FROM about_hse WHERE id=1')->fetch();return is_array($r)?$r:null; }
    public static function saveHse(array $data): void { $title=trim((string)($data['title']??''));$content=trim((string)($data['content']??''));if($title===''||$content==='')throw new RuntimeException('HSE title and content are required.');$st=Database::connection()->prepare('INSERT INTO about_hse (id,title,content) VALUES (1,:title,:content) ON DUPLICATE KEY UPDATE title=VALUES(title),content=VALUES(content)');$st->execute([':title'=>$title,':content'=>$content]); }

    public static function companyProfile(): ?array { $r=Database::connection()->query('SELECT * FROM about_company_profile WHERE id=1')->fetch();return is_array($r)?$r:null; }
    public static function saveCompanyProfile(array $data): void { foreach(['title','content','link'] as $k){if(trim((string)($data[$k]??''))==='')throw new RuntimeException('Company Profile '.$k.' is required.');}$st=Database::connection()->prepare('INSERT INTO about_company_profile (id,title,content,link) VALUES (1,:title,:content,:link) ON DUPLICATE KEY UPDATE title=VALUES(title),content=VALUES(content),link=VALUES(link)');$st->execute([':title'=>trim((string)$data['title']),':content'=>trim((string)$data['content']),':link'=>trim((string)$data['link'])]); }

    public static function deleteItem(string $type,int $id): void
    {
        $table=self::tableFor($type); $st=Database::connection()->prepare("DELETE FROM {$table} WHERE id=:id");$st->execute([':id'=>$id]);if($st->rowCount()!==1)throw new RuntimeException('About record not found.');
    }

    private static function tableFor(string $type): string
    {
        $map=['clients'=>'about_clients','certificates'=>'about_certificates','awards'=>'about_awards','sister'=>'about_sister_companies','timeline'=>'about_timeline','values'=>'about_core_values'];
        if(!isset($map[$type]))throw new RuntimeException('Invalid About item type.');
        return $map[$type];
    }
}
