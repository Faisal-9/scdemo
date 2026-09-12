<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/AboutManager.php';
Auth::requirePermission('manage_about');

$section=trim((string)($_GET['section']??''));
$allowed=['overview','mission','hse','profile'];
if(!in_array($section,$allowed,true)){redirect(adminUrl('about/'));}

$record=null;
if($section==='overview'){$record=AboutManager::generalInfo();$title='Overview';$save=[AboutManager::class,'saveGeneralInfo'];}
elseif($section==='mission'){$record=AboutManager::missionVision();$title='Mission, Vision & Core Values';$save=[AboutManager::class,'saveMissionVision'];}
elseif($section==='hse'){$record=AboutManager::hse();$title='HSE';$save=[AboutManager::class,'saveHse'];}
else{$record=AboutManager::companyProfile();$title='Company Profile';$save=[AboutManager::class,'saveCompanyProfile'];}

$error=null;
if(isPost()){
    CSRF::verify($_POST['csrf_token']??null);
    try{call_user_func($save,$_POST);Auth::audit(Auth::id(),'update','about_'.$section,null,'Updated About '.$title);flash('success',$title.' saved.');redirect(adminUrl('about/content.php?section='.$section));}
    catch(Throwable $e){$error=APP_DEBUG?$e->getMessage():'The About content could not be saved.';$record=array_merge((array)$record,$_POST);}
}

$pageTitle=$title;$activeNav='about';require __DIR__.'/../partials/header.php';require __DIR__.'/../partials/sidebar.php';
?>
<main class="admin-content">
<?php $breadcrumbs=[['label'=>'Dashboard','url'=>adminUrl('dashboard.php')],['label'=>'About','url'=>adminUrl('about/')],['label'=>$title,'url'=>null]];require __DIR__.'/../partials/breadcrumbs.php';$heading=$title;$description='Edit the current content only; the public About markup remains unchanged.';$actionUrl=adminUrl('about/');$actionLabel='Back';require __DIR__.'/../partials/page-heading.php';require __DIR__.'/../partials/alerts.php';if($error):?><div class="alert alert-error"><?=e($error)?></div><?php endif;?>

<section class="form-card"><form method="post"><?=CSRF::field()?>
<?php if($section==='overview'): ?>
<div class="form-grid"><div class="form-field form-field-wide"><label>Title</label><input name="title" value="<?=e($record['title']??'')?>" required></div><div class="form-field form-field-wide"><label>Overview content</label><textarea name="content" rows="8" required><?=e($record['content']??'')?></textarea></div></div>
<?php elseif($section==='mission'): ?>
<div class="form-grid"><div class="form-field form-field-wide"><label>Section title</label><input name="title" value="<?=e($record['title']??'')?>" required></div><div class="form-field form-field-wide"><label>Mission</label><textarea name="mission" rows="6" required><?=e($record['mission']??'')?></textarea></div><div class="form-field form-field-wide"><label>Mission image path</label><input name="mission_img" value="<?=e($record['mission_img']??'')?>" required></div><div class="form-field form-field-wide"><label>Vision</label><textarea name="vision" rows="6" required><?=e($record['vision']??'')?></textarea></div><div class="form-field form-field-wide"><label>Vision image path</label><input name="vision_img" value="<?=e($record['vision_img']??'')?>" required></div><div class="form-field form-field-wide"><label>Core values image path</label><input name="core_values_img" value="<?=e($record['core_values_img']??'')?>" required></div></div>
<p class="form-note">Core values themselves are managed separately from the About dashboard.</p>
<?php elseif($section==='hse'): ?>
<div class="form-grid"><div class="form-field form-field-wide"><label>Title</label><input name="title" value="<?=e($record['title']??'')?>" required></div><div class="form-field form-field-wide"><label>Content</label><textarea name="content" rows="8" required><?=e($record['content']??'')?></textarea></div></div>
<?php else: ?>
<div class="form-grid"><div class="form-field form-field-wide"><label>Title</label><input name="title" value="<?=e($record['title']??'')?>" required></div><div class="form-field form-field-wide"><label>Content</label><textarea name="content" rows="8" required><?=e($record['content']??'')?></textarea></div><div class="form-field form-field-wide"><label>Company profile file path</label><input name="link" value="<?=e($record['link']??'')?>" required></div></div>
<?php endif; ?>
<div class="form-actions"><a class="button-link button-secondary" href="<?=e(adminUrl('about/'))?>">Cancel</a><button class="button-primary" type="submit">Save</button></div>
</form></section>
</main>
<?php require __DIR__.'/../partials/footer.php'; ?>
