<?php

declare(strict_types=1);

/*
 * Phase 11 one-time migration.
 * Uses the branch's existing static aboutdata.php as the source of truth,
 * so the exact existing content remains unchanged during migration.
 */

require_once __DIR__ . '/../app/bootstrap.php';

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("CLI only.\n");
}

if (!is_file(__DIR__ . '/phase11_about.sql')) {
    throw new RuntimeException('phase11_about.sql not found.');
}

require __DIR__ . '/../includes/data/aboutdata.php';

$pdo = Database::connection();

$tables = [
    'about_sections','about_general','about_timeline','about_mission_vision',
    'about_core_values','about_clients','about_certificates','about_awards',
    'about_sister_companies','about_hse','about_company_profile'
];

foreach ($tables as $table) {
    $count = (int)$pdo->query("SELECT COUNT(*) FROM {$table}")->fetchColumn();
    if ($count > 0) {
        throw new RuntimeException("Refusing to rerun: {$table} already contains data.");
    }
}

$sections = [
    ['general-info', $generalInfo['title']],
    ['mission-vision', $missionVision['title']],
    ['clients', $clients['title']],
    ['certificates', $certificates['title']],
    ['awards', $awards['title']],
    ['sister', $sisterCompanies['title']],
    ['hse', $hse['title']],
    ['cprofile', $cprofile['title']],
];

$pdo->beginTransaction();
try {
    $st = $pdo->prepare('INSERT INTO about_sections (legacy_id,title,sort_order,is_active) VALUES (:legacy_id,:title,:sort_order,1)');
    foreach ($sections as $i => [$id, $title]) {
        $st->execute([':legacy_id'=>$id, ':title'=>$title, ':sort_order'=>$i]);
    }

    $st=$pdo->prepare('INSERT INTO about_general (id,title,content) VALUES (1,:title,:content)');
    $st->execute([':title'=>$generalInfo['title'], ':content'=>$generalInfo['content']]);

    $st=$pdo->prepare('INSERT INTO about_timeline (year,title,description,image_path,sort_order,is_active) VALUES (:year,:title,:description,:image_path,:sort_order,1)');
    foreach ($generalInfo['items'] as $i=>$item) {
        $st->execute([':year'=>$item['year'],':title'=>$item['title'],':description'=>$item['description'],':image_path'=>$item['img'],':sort_order'=>$i]);
    }

    $st=$pdo->prepare('INSERT INTO about_mission_vision (id,title,mission,mission_img,vision,vision_img,core_values_img) VALUES (1,:title,:mission,:mission_img,:vision,:vision_img,:core_values_img)');
    $st->execute([
        ':title'=>$missionVision['title'], ':mission'=>$missionVision['mission'], ':mission_img'=>$missionVision['mission_img'],
        ':vision'=>$missionVision['vision'], ':vision_img'=>$missionVision['vision_img'], ':core_values_img'=>$missionVision['core_values_img']
    ]);

    $st=$pdo->prepare('INSERT INTO about_core_values (value_text,sort_order,is_active) VALUES (:value_text,:sort_order,1)');
    foreach($missionVision['core_values'] as $i=>$value){$st->execute([':value_text'=>$value,':sort_order'=>$i]);}

    $st=$pdo->prepare('INSERT INTO about_clients (name,logo_path,sort_order,is_active) VALUES (:name,:logo_path,:sort_order,1)');
    foreach($clients['items'] as $i=>$item){$st->execute([':name'=>null,':logo_path'=>$item['logo'],':sort_order'=>$i]);}

    $mappings=[
        'certificates'=>[$certificates['items'],'about_certificates'],
        'awards'=>[$awards['items'],'about_awards'],
        'sister'=>[$sisterCompanies['items'],'about_sister_companies'],
    ];
    foreach($mappings as $type=>[$items,$table]){
        $st=$pdo->prepare("INSERT INTO {$table} (name,logo_path,sort_order,is_active) VALUES (:name,:logo_path,:sort_order,1)");
        foreach($items as $i=>$item){$st->execute([':name'=>$item['name'],':logo_path'=>$item['logo'],':sort_order'=>$i]);}
    }

    $st=$pdo->prepare('INSERT INTO about_hse (id,title,content) VALUES (1,:title,:content)');
    $st->execute([':title'=>$hse['title'],':content'=>$hse['content']]);

    $st=$pdo->prepare('INSERT INTO about_company_profile (id,title,content,link) VALUES (1,:title,:content,:link)');
    $st->execute([':title'=>$cprofile['title'],':content'=>$cprofile['content'],':link'=>$cprofile['link']]);

    $pdo->commit();
    echo "Phase 11 About migration completed successfully.\n";
} catch(Throwable $e){
    if($pdo->inTransaction())$pdo->rollBack();
    throw $e;
}
