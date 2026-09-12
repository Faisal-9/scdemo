<?php
declare(strict_types=1);

require_once __DIR__ . '/Database.php';

final class ContactMessageManager
{
    public static function create(array $input): int
    {
        $name=trim((string)($input['name']??''));
        $email=trim((string)($input['email']??''));
        $phone=trim((string)($input['phone']??''));
        $subject=trim((string)($input['subject']??''));
        $message=trim((string)($input['message']??''));
        if($name===''||$message===''||!filter_var($email,FILTER_VALIDATE_EMAIL)) throw new InvalidArgumentException('Please provide a valid name, email address, and message.');
        foreach([['name',$name,255],['email',$email,255],['phone',$phone,100],['subject',$subject,500]] as [$field,$value,$max]) if(mb_strlen($value)>$max) throw new InvalidArgumentException('The '.$field.' field is too long.');
        $db=Database::connection();
        $st=$db->prepare('INSERT INTO contact_messages (name,email,phone,company,subject,message,status,ip_address,user_agent) VALUES (:name,:email,:phone,:company,:subject,:message,\'unread\',:ip,:ua)');
        $st->execute(['name'=>$name,'email'=>$email,'phone'=>$phone!==''?$phone:null,'company'=>null,'subject'=>$subject!==''?$subject:null,'message'=>$message,'ip'=>$_SERVER['REMOTE_ADDR']??null,'ua'=>isset($_SERVER['HTTP_USER_AGENT'])?mb_substr((string)$_SERVER['HTTP_USER_AGENT'],0,500):null]);
        return (int)$db->lastInsertId();
    }
    public static function paginate(int $page=1,int $perPage=20,string $search='',string $status=''):array { $page=max(1,$page);$perPage=max(5,min(100,$perPage));$params=[];$where=[];if($search!==''){ $where[]='(name LIKE :q OR email LIKE :q OR subject LIKE :q OR message LIKE :q)';$params['q']='%'.$search.'%'; }if(in_array($status,['unread','read','archived'],true)){ $where[]='status=:status';$params['status']=$status; }$ws=$where?' WHERE '.implode(' AND ',$where):'';$db=Database::connection();$st=$db->prepare('SELECT COUNT(*) FROM contact_messages'.$ws);$st->execute($params);$total=(int)$st->fetchColumn();$pages=max(1,(int)ceil($total/$perPage));$page=min($page,$pages);$st=$db->prepare('SELECT * FROM contact_messages'.$ws.' ORDER BY created_at DESC,id DESC LIMIT :lim OFFSET :off');foreach($params as $k=>$v)$st->bindValue(':'.$k,$v);$st->bindValue(':lim',$perPage,PDO::PARAM_INT);$st->bindValue(':off',($page-1)*$perPage,PDO::PARAM_INT);$st->execute();return ['items'=>$st->fetchAll(PDO::FETCH_ASSOC),'total'=>$total,'page'=>$page,'pages'=>$pages]; }
    public static function find(int $id):?array{$st=Database::connection()->prepare('SELECT * FROM contact_messages WHERE id=:id LIMIT 1');$st->execute(['id'=>$id]);$r=$st->fetch(PDO::FETCH_ASSOC);return $r?:null;}
    public static function setStatus(int $id,string $status):void{if(!in_array($status,['unread','read','archived'],true))throw new InvalidArgumentException('Invalid status.');$st=Database::connection()->prepare('UPDATE contact_messages SET status=:status WHERE id=:id');$st->execute(['status'=>$status,'id'=>$id]);}

    public static function page():array{return self::single('contact_page');}
    public static function qrCodes():array{return Database::connection()->query('SELECT * FROM contact_qr_codes ORDER BY sort_order ASC,id ASC')->fetchAll(PDO::FETCH_ASSOC);}
    public static function offices():array{return Database::connection()->query('SELECT * FROM contact_offices ORDER BY sort_order ASC,id ASC')->fetchAll(PDO::FETCH_ASSOC);}

    public static function savePage(array $d):void{
        foreach(['section_title','head_office_title','head_office_phone','head_office_email','head_office_address','map_label','form_title','overseas_title','overseas_subtitle'] as $k) if(trim((string)($d[$k]??''))==='') throw new InvalidArgumentException($k.' is required.');
        if(!is_numeric($d['map_lat']??null)||!is_numeric($d['map_lng']??null)) throw new InvalidArgumentException('Map coordinates must be numeric.');
        $st=Database::connection()->prepare('INSERT INTO contact_page (id,section_title,head_office_title,head_office_phone,head_office_whatsapp,head_office_email,head_office_address,map_label,map_lat,map_lng,map_zoom,form_title,overseas_title,overseas_subtitle) VALUES (1,:section_title,:head_office_title,:head_office_phone,:head_office_whatsapp,:head_office_email,:head_office_address,:map_label,:map_lat,:map_lng,:map_zoom,:form_title,:overseas_title,:overseas_subtitle) ON DUPLICATE KEY UPDATE section_title=VALUES(section_title),head_office_title=VALUES(head_office_title),head_office_phone=VALUES(head_office_phone),head_office_whatsapp=VALUES(head_office_whatsapp),head_office_email=VALUES(head_office_email),head_office_address=VALUES(head_office_address),map_label=VALUES(map_label),map_lat=VALUES(map_lat),map_lng=VALUES(map_lng),map_zoom=VALUES(map_zoom),form_title=VALUES(form_title),overseas_title=VALUES(overseas_title),overseas_subtitle=VALUES(overseas_subtitle)');$st->execute(['section_title'=>$d['section_title'],'head_office_title'=>$d['head_office_title'],'head_office_phone'=>$d['head_office_phone'],'head_office_whatsapp'=>$d['head_office_whatsapp']??null,'head_office_email'=>$d['head_office_email'],'head_office_address'=>$d['head_office_address'],'map_label'=>$d['map_label'],'map_lat'=>$d['map_lat'],'map_lng'=>$d['map_lng'],'map_zoom'=>max(1,min(20,(int)($d['map_zoom']??14))),'form_title'=>$d['form_title'],'overseas_title'=>$d['overseas_title'],'overseas_subtitle'=>$d['overseas_subtitle']]);
    }
    public static function saveQr(array $d,?int $id=null):int{$path=trim((string)($d['image_path']??''));$label=trim((string)($d['label']??''));if($path===''||$label==='')throw new InvalidArgumentException('QR image path and label are required.');$p=['image_path'=>$path,'label'=>$label,'sort_order'=>max(0,(int)($d['sort_order']??0)),'is_active'=>!empty($d['is_active'])?1:0];$db=Database::connection();if($id===null){$st=$db->prepare('INSERT INTO contact_qr_codes (image_path,label,sort_order,is_active) VALUES (:image_path,:label,:sort_order,:is_active)');$st->execute($p);return(int)$db->lastInsertId();}$p['id']=$id;$st=$db->prepare('UPDATE contact_qr_codes SET image_path=:image_path,label=:label,sort_order=:sort_order,is_active=:is_active WHERE id=:id');$st->execute($p);return$id;}
    public static function saveOffice(array $d,?int $id=null):int{$title=trim((string)($d['title']??''));$address=trim((string)($d['address']??''));if($title===''||$address==='')throw new InvalidArgumentException('Office title and address are required.');$p=['title'=>$title,'phone'=>trim((string)($d['phone']??''))?:null,'whatsapp'=>trim((string)($d['whatsapp']??''))?:null,'email'=>trim((string)($d['email']??''))?:null,'address'=>$address,'sort_order'=>max(0,(int)($d['sort_order']??0)),'is_active'=>!empty($d['is_active'])?1:0];$db=Database::connection();if($id===null){$st=$db->prepare('INSERT INTO contact_offices (title,phone,whatsapp,email,address,sort_order,is_active) VALUES (:title,:phone,:whatsapp,:email,:address,:sort_order,:is_active)');$st->execute($p);return(int)$db->lastInsertId();}$p['id']=$id;$st=$db->prepare('UPDATE contact_offices SET title=:title,phone=:phone,whatsapp=:whatsapp,email=:email,address=:address,sort_order=:sort_order,is_active=:is_active WHERE id=:id');$st->execute($p);return$id;}
    public static function delete(string $type,int $id):void{$table=['qr'=>'contact_qr_codes','office'=>'contact_offices'][$type]??null;if(!$table)throw new InvalidArgumentException('Invalid contact record.');$st=Database::connection()->prepare("DELETE FROM {$table} WHERE id=:id");$st->execute(['id'=>$id]);}
    private static function single(string $table):array{$r=Database::connection()->query("SELECT * FROM {$table} WHERE id=1 LIMIT 1")->fetch(PDO::FETCH_ASSOC);return$r?:[];}
}
