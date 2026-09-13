<?php
declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/BackupVaultManager.php';
Auth::requirePermission('manage_backup_vault');
$pageTitle = 'Backup Vault';
$error = null; $notice = null;
if (($_GET['created'] ?? '') === '1') $notice = 'Backup created successfully.';
if (($_GET['deleted'] ?? '') === '1') $notice = 'Backup deleted.';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (($_POST['csrf'] ?? '') !== ($_SESSION['csrf_token'] ?? '')) {
        $error = 'Invalid security token. Please refresh and try again.';
    } else {
        try {
            $action = (string)($_POST['action'] ?? '');
            if ($action === 'create') {
                $userId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
                $backup = BackupVaultManager::create((string)($_POST['type'] ?? 'full'), $userId);
                header('Location: index.php?created=1'); exit;
            }
            if ($action === 'delete') {
                BackupVaultManager::delete((int)($_POST['id'] ?? 0));
                header('Location: index.php?deleted=1'); exit;
            }
        } catch (Throwable $e) { $error = $e->getMessage(); }
    }
}
try { $backups = BackupVaultManager::listBackups(); } catch (Throwable $e) { $backups = []; $error = $error ?: $e->getMessage(); }
require __DIR__ . '/../partials/header.php'; require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main"><div class="admin-container">
<?php require __DIR__ . '/../partials/alerts.php'; ?>
<style>
.vault-hero{display:flex;justify-content:space-between;gap:1rem;align-items:flex-start;padding:1.35rem 1.45rem;border-radius:20px;margin-bottom:1rem;background:linear-gradient(135deg,#111,#343434);color:#fff}.vault-hero h1{margin:0;font-size:1.55rem}.vault-hero p{margin:.38rem 0 0;opacity:.76}.vault-actions{display:flex;gap:.55rem;flex-wrap:wrap}.vault-btn{display:inline-flex;align-items:center;gap:.4rem;padding:.62rem .82rem;border-radius:10px;text-decoration:none;border:1px solid rgba(0,0,0,.12);background:#fff;color:#222}.vault-btn.dark{background:#222;color:#fff;border-color:#444}.vault-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:.9rem;margin-bottom:1rem}.vault-card{background:var(--bs-body-bg,#fff);border:1px solid rgba(0,0,0,.08);border-radius:16px;padding:1rem}.vault-label{font-size:.78rem;opacity:.62}.vault-num{font-size:1.5rem;font-weight:800;margin-top:.22rem}.vault-muted{font-size:.8rem;opacity:.65}.vault-note{padding:.85rem 1rem;border-radius:13px;background:rgba(13,110,253,.07);border:1px solid rgba(13,110,253,.16);font-size:.84rem;margin-bottom:1rem}.vault-table{width:100%;border-collapse:collapse}.vault-table th,.vault-table td{padding:.66rem .55rem;border-bottom:1px solid rgba(0,0,0,.06);text-align:left;font-size:.84rem;vertical-align:top}.vault-table th{font-size:.74rem;text-transform:uppercase;letter-spacing:.03em;opacity:.6}.vault-pill{display:inline-flex;padding:.2rem .48rem;border-radius:999px;background:rgba(25,135,84,.1);font-size:.72rem}.vault-form{display:flex;gap:.55rem;flex-wrap:wrap;align-items:center}.vault-select{padding:.58rem .7rem;border:1px solid rgba(0,0,0,.15);border-radius:10px;background:#fff}.vault-alert{padding:.8rem 1rem;border-radius:12px;background:rgba(220,53,69,.08);color:#922233;margin-bottom:1rem}.vault-code{font-family:ui-monospace,SFMono-Regular,Menlo,monospace;font-size:.72rem;word-break:break-all;opacity:.7}@media(max-width:1050px){.vault-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}@media(max-width:650px){.vault-grid{grid-template-columns:1fr}.vault-hero{flex-direction:column}}
</style>
<div class="vault-hero"><div><h1>Secure Backup Vault</h1><p>Saved database backups with checksum verification and authenticated access.</p></div><div class="vault-actions"><a class="vault-btn" href="../database-backup/">Database Backup Center</a><a class="vault-btn" href="../dashboard.php">← Dashboard</a></div></div>
<?php if ($error): ?><div class="vault-alert"><?= e($error) ?></div><?php endif; ?>
<div class="vault-grid">
<div class="vault-card"><div class="vault-label">Saved Backups</div><div class="vault-num"><?= e((string)count($backups)) ?></div><div class="vault-muted">Metadata records in vault</div></div>
<div class="vault-card"><div class="vault-label">Total Stored</div><div class="vault-num"><?= e(BackupVaultManager::formatBytes(array_sum(array_map(static fn($b)=>(int)$b['size_bytes'],$backups)))) ?></div><div class="vault-muted">Backup files on disk</div></div>
<div class="vault-card"><div class="vault-label">Latest Backup</div><div class="vault-num" style="font-size:1rem"><?= e($backups[0]['created_at'] ?? 'None') ?></div><div class="vault-muted"><?= e($backups[0]['backup_type'] ?? '') ?></div></div>
<div class="vault-card"><div class="vault-label">Storage Location</div><div class="vault-num" style="font-size:.9rem;word-break:break-word">Protected</div><div class="vault-muted">Outside public web root by default</div></div>
</div>
<?php if ($notice): ?><div class="vault-note"><?= e($notice) ?></div><?php endif; ?>
<div class="vault-card" style="margin-bottom:1rem"><h2 style="font-size:1rem;margin:0 0 .65rem">Create Saved Backup</h2><form class="vault-form" method="post" action="index.php"><input type="hidden" name="csrf" value="<?= e($_SESSION['csrf_token'] ?? '') ?>"><input type="hidden" name="action" value="create"><select class="vault-select" name="type"><option value="full">Full — schema + data</option><option value="schema">Schema only</option></select><button class="vault-btn dark" type="submit">Create &amp; Verify Backup</button></form></div>
<div class="vault-card"><h2 style="font-size:1rem;margin:0 0 .75rem">Backup Files</h2><div style="overflow:auto"><table class="vault-table"><thead><tr><th>File</th><th>Type</th><th>Size</th><th>Created By</th><th>Integrity</th><th>Actions</th></tr></thead><tbody>
<?php if (!$backups): ?><tr><td colspan="6" style="opacity:.65">No saved backups yet.</td></tr><?php else: foreach ($backups as $backup): $check = BackupVaultManager::verify($backup); ?><tr><td><strong><?= e($backup['filename']) ?></strong><div class="vault-code">SHA-256: <?= e($backup['sha256']) ?></div></td><td><?= e(strtoupper($backup['backup_type'])) ?></td><td><?= e(BackupVaultManager::formatBytes((int)$backup['size_bytes'])) ?></td><td><?= e($backup['creator_name'] ?: ($backup['creator_username'] ?: 'System')) ?><div class="vault-muted"><?= e($backup['created_at']) ?></div></td><td><span class="vault-pill"><?= e(strtoupper($check['status'])) ?></span><div class="vault-muted"><?= e($check['message']) ?></div></td><td><div class="vault-actions"><a class="vault-btn" href="download.php?id=<?= (int)$backup['id'] ?>">Download</a><form method="post" action="index.php" onsubmit="return confirm('Delete this saved backup? This cannot be undone.');"><input type="hidden" name="csrf" value="<?= e($_SESSION['csrf_token'] ?? '') ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$backup['id'] ?>"><button class="vault-btn" type="submit">Delete</button></form></div></td></tr><?php endforeach; endif; ?>
</tbody></table></div></div>
<div class="vault-card" style="margin-top:.9rem;font-size:.78rem;opacity:.72">Backups are private administrative files. Keep independent off-server copies for disaster recovery. The vault refuses downloads when a stored backup fails checksum verification.</div>
</div></main>
<?php require __DIR__ . '/../partials/footer.php'; ?>
