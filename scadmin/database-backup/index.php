<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/DatabaseBackupManager.php';
require_once __DIR__ . '/../../app/core/BackupVaultManager.php';

function backupCenterAuthorize(): void
{
    $uid = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
    if ($uid < 1) {
        Auth::requirePermission('manage_backup_center');
        return;
    }
    try {
        $pdo = Database::connection();
        $stmt = $pdo->prepare("SELECT role, status FROM users WHERE id = ? LIMIT 1");
        $stmt->execute([$uid]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user || ($user['status'] ?? '') !== 'active') {
            http_response_code(403);
            exit('Access denied.');
        }
        if (($user['role'] ?? '') === 'admin') return;
        $sql = "SELECT 1 FROM user_permissions up INNER JOIN permissions p ON p.id=up.permission_id
                WHERE up.user_id=? AND p.permission_key IN ('manage_backup_center','manage_database_backups','manage_backup_vault') LIMIT 1";
        $q = $pdo->prepare($sql);
        $q->execute([$uid]);
        if (!$q->fetchColumn()) {
            http_response_code(403);
            exit('You do not have permission to access the backup center.');
        }
    } catch (Throwable $e) {
        Auth::requirePermission('manage_backup_center');
    }
}
backupCenterAuthorize();

$pageTitle = 'Database Backup Center';
$error = null;
$notice = null;
if (!isset($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token']) || $_SESSION['csrf_token'] === '') {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf = (string)$_SESSION['csrf_token'];

if (($_GET['saved'] ?? '') === '1') $notice = 'Backup saved and verified successfully.';
if (($_GET['deleted'] ?? '') === '1') $notice = 'Saved backup deleted.';
if (($_GET['refreshed'] ?? '') === '1') $notice = 'Backup integrity statuses refreshed.';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = (string)($_POST['csrf'] ?? '');
    if (!hash_equals($csrf, $token)) {
        $error = 'Invalid security token. Please refresh the page and try again.';
    } else {
        try {
            $action = (string)($_POST['action'] ?? '');
            $uid = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
            if ($action === 'create_saved') {
                BackupVaultManager::create((string)($_POST['type'] ?? 'full'), $uid);
                header('Location: index.php?saved=1');
                exit;
            }
            if ($action === 'delete_saved') {
                BackupVaultManager::delete((int)($_POST['id'] ?? 0));
                header('Location: index.php?deleted=1');
                exit;
            }
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }
    }
}

$overview = null;
$backups = [];
$storage = ['path' => '', 'writable' => false, 'files' => 0, 'bytes' => 0];
try {
    $overview = DatabaseBackupManager::overview();
} catch (Throwable $e) {
    $error = $error ?: $e->getMessage();
}
try {
    $backups = BackupVaultManager::listBackups();
    $storage['path'] = BackupVaultManager::storageDir();
    if (is_dir($storage['path'])) {
        $storage['writable'] = is_writable($storage['path']);
        $files = glob($storage['path'] . DIRECTORY_SEPARATOR . '*.sql') ?: [];
        $storage['files'] = count($files);
        foreach ($files as $f) {
            $storage['bytes'] += (int)@filesize($f);
        }
    }
} catch (Throwable $e) {
    $error = $error ?: $e->getMessage();
}

$totalBackupBytes = array_sum(array_map(static fn($b) => (int)$b['size_bytes'], $backups));
$ok = 0;
$missing = 0;
$failed = 0;
foreach ($backups as $b) {
    $status = BackupVaultManager::verify($b)['status'];
    if ($status === 'ok') $ok++;
    elseif ($status === 'missing') $missing++;
    elseif ($status === 'failed') $failed++;
}
$last = $backups[0] ?? null;
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main">
    <div class="admin-container">
        <?php require __DIR__ . '/../partials/alerts.php'; ?>
        <style>
            .bc-hero {
                padding: 1.35rem 1.5rem;
                border-radius: 22px;
                margin-bottom: 1rem;
                background: linear-gradient(135deg, #111 0%, #272727 58%, #3b3b3b 100%);
                color: #fff;
                box-shadow: 0 12px 30px rgba(0, 0, 0, .1)
            }

            .bc-hero-top {
                display: flex;
                justify-content: space-between;
                gap: 1rem;
                align-items: flex-start
            }

            .bc-hero h1 {
                margin: 0;
                font-size: 1.6rem
            }

            .bc-hero p {
                margin: .35rem 0 0;
                opacity: .74
            }

            .bc-actions {
                display: flex;
                gap: .5rem;
                flex-wrap: wrap
            }

            .bc-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: .35rem;
                padding: .62rem .82rem;
                border-radius: 10px;
                border: 1px solid rgba(255, 255, 255, .15);
                background: rgba(255, 255, 255, .06);
                color: #fff;
                text-decoration: none
            }

            .bc-btn:hover {
                color: #fff;
                background: rgba(255, 255, 255, .12)
            }

            .bc-btn.light {
                background: #fff;
                color: #181818;
                border-color: #fff
            }

            .bc-statgrid {
                display: grid;
                grid-template-columns: repeat(6, minmax(0, 1fr));
                gap: .8rem;
                margin-bottom: 1rem
            }

            .bc-stat,
            .bc-card {
                background: var(--bs-body-bg, #fff);
                border: 1px solid rgba(0, 0, 0, .08);
                border-radius: 16px;
                padding: 1rem
            }

            .bc-label {
                font-size: .76rem;
                opacity: .62;
                text-transform: uppercase;
                letter-spacing: .04em
            }

            .bc-num {
                font-size: 1.45rem;
                font-weight: 800;
                margin-top: .24rem;
                line-height: 1.15
            }

            .bc-muted {
                font-size: .78rem;
                opacity: .62;
                margin-top: .22rem
            }

            .bc-layout {
                display: grid;
                grid-template-columns: minmax(0, 1.55fr) minmax(300px, .8fr);
                gap: 1rem;
                align-items: start
            }

            .bc-card h2 {
                font-size: 1rem;
                margin: 0 0 .8rem
            }

            .bc-toolbar {
                display: flex;
                gap: .6rem;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                margin-bottom: .8rem
            }

            .bc-form {
                display: flex;
                gap: .55rem;
                align-items: center;
                flex-wrap: wrap
            }

            .bc-select {
                padding: .62rem .72rem;
                border: 1px solid rgba(0, 0, 0, .15);
                border-radius: 10px;
                background: #fff
            }

            .bc-table {
                width: 100%;
                border-collapse: collapse
            }

            .bc-table th,
            .bc-table td {
                padding: .68rem .55rem;
                border-bottom: 1px solid rgba(0, 0, 0, .06);
                text-align: left;
                vertical-align: top;
                font-size: .82rem
            }

            .bc-table th {
                font-size: .72rem;
                text-transform: uppercase;
                letter-spacing: .035em;
                opacity: .58
            }

            .bc-pill {
                display: inline-flex;
                align-items: center;
                padding: .22rem .5rem;
                border-radius: 999px;
                font-size: .7rem;
                font-weight: 700
            }

            .bc-ok {
                background: rgba(25, 135, 84, .1)
            }

            .bc-fail {
                background: rgba(220, 53, 69, .1)
            }

            .bc-warn {
                background: rgba(255, 193, 7, .13)
            }

            .bc-code {
                font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
                font-size: .69rem;
                opacity: .68;
                word-break: break-all
            }

            .bc-small {
                font-size: .76rem;
                opacity: .62
            }

            .bc-note {
                padding: .85rem .95rem;
                border-radius: 12px;
                background: rgba(13, 110, 253, .07);
                border: 1px solid rgba(13, 110, 253, .14);
                font-size: .8rem
            }

            .bc-alert {
                padding: .85rem 1rem;
                border-radius: 12px;
                background: rgba(220, 53, 69, .08);
                color: #8e2432;
                margin-bottom: 1rem
            }

            .bc-sidebox {
                padding: .8rem .9rem;
                border-radius: 12px;
                background: rgba(0, 0, 0, .025);
                margin-bottom: .65rem
            }

            .bc-sidebox strong {
                display: block;
                margin-bottom: .18rem
            }

            .bc-kv {
                display: flex;
                justify-content: space-between;
                gap: 1rem;
                padding: .45rem 0;
                border-bottom: 1px solid rgba(0, 0, 0, .05);
                font-size: .8rem
            }

            .bc-kv:last-child {
                border-bottom: 0
            }

            .bc-link {
                color: inherit;
                text-decoration: none
            }

            .bc-link:hover {
                text-decoration: underline
            }

            @media(max-width:1200px) {
                .bc-statgrid {
                    grid-template-columns: repeat(3, minmax(0, 1fr))
                }

                .bc-layout {
                    grid-template-columns: 1fr
                }
            }

            @media(max-width:650px) {
                .bc-statgrid {
                    grid-template-columns: repeat(2, minmax(0, 1fr))
                }

                .bc-hero-top {
                    flex-direction: column
                }

                .bc-actions,
                .bc-form {
                    width: 100%
                }

                .bc-actions .bc-btn,
                .bc-form .bc-btn {
                    flex: 1
                }

                .bc-table {
                    min-width: 720px
                }
            }
        </style>
        <div class="bc-hero">
            <div class="bc-hero-top">
                <div>
                    <h1>Database Backup Center</h1>
                    <p>One place for live SQL exports, saved backups, verification, and secure retention.</p>
                </div>
                <div class="bc-actions"><a class="bc-btn" href="../dashboard.php">← Dashboard</a><a class="bc-btn light" href="export.php?type=full">⬇ Download Full SQL</a></div>
            </div>
        </div>
        <?php if ($error): ?><div class="bc-alert"><?= e($error) ?></div><?php endif; ?>
        <div class="bc-statgrid">
            <div class="bc-stat">
                <div class="bc-label">Database</div>
                <div class="bc-num" style="font-size:1.03rem;word-break:break-word"><?= e((string)($overview['database'] ?? 'Unavailable')) ?></div>
                <div class="bc-muted"><?= e((string)($overview['server_version'] ?? '')) ?></div>
            </div>
            <div class="bc-stat">
                <div class="bc-label">Tables</div>
                <div class="bc-num"><?= e((string)($overview['table_count'] ?? 0)) ?></div>
                <div class="bc-muted">Live schema</div>
            </div>
            <div class="bc-stat">
                <div class="bc-label">Saved</div>
                <div class="bc-num"><?= e((string)count($backups)) ?></div>
                <div class="bc-muted"><?= e(BackupVaultManager::formatBytes((int)$totalBackupBytes)) ?></div>
            </div>
            <div class="bc-stat">
                <div class="bc-label">Verified</div>
                <div class="bc-num"><?= e((string)$ok) ?></div>
                <div class="bc-muted">Checksum matched</div>
            </div>
            <div class="bc-stat">
                <div class="bc-label">Attention</div>
                <div class="bc-num"><?= e((string)($failed + $missing)) ?></div>
                <div class="bc-muted"><?= e((string)$failed) ?> failed · <?= e((string)$missing) ?> missing</div>
            </div>
            <div class="bc-stat">
                <div class="bc-label">Vault Storage</div>
                <div class="bc-num"><?= $storage['writable'] ? 'Ready' : 'Check' ?></div>
                <div class="bc-muted"><?= e(BackupVaultManager::formatBytes((int)$storage['bytes'])) ?></div>
            </div>
        </div>
        <?php if ($notice): ?><div class="bc-note" style="margin-bottom:1rem"><?= e($notice) ?></div><?php endif; ?>
        <div class="bc-layout">
            <section class="bc-card">
                <div class="bc-toolbar">
                    <div>
                        <h2 style="margin-bottom:.15rem">Saved Backups</h2>
                        <div class="bc-small">Saved files are verified against their stored SHA-256 checksum before download.</div>
                    </div>
                    <form class="bc-form" method="post" action="index.php"><input type="hidden" name="csrf" value="<?= e($csrf) ?>"><input type="hidden" name="action" value="create_saved"><select class="bc-select" name="type">
                            <option value="full">Full — schema + data</option>
                            <option value="schema">Schema only</option>
                        </select><button class="bc-btn" style="background:#222;color:#fff;border-color:#222" type="submit">＋ Save Backup</button></form>
                </div>
                <div style="overflow:auto">
                    <table class="bc-table">
                        <thead>
                            <tr>
                                <th>Backup</th>
                                <th>Type</th>
                                <th>Size</th>
                                <th>Created</th>
                                <th>Integrity</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$backups): ?><tr>
                                    <td colspan="6" class="bc-small">No saved backups yet. Use “Save Backup” to create one in the protected vault.</td>
                                </tr>
                                <?php else: foreach ($backups as $backup): $check = BackupVaultManager::verify($backup);
                                    $cls = $check['status'] === 'ok' ? 'bc-ok' : ($check['status'] === 'missing' ? 'bc-warn' : 'bc-fail'); ?><tr>
                                        <td><strong><?= e($backup['filename']) ?></strong>
                                            <div class="bc-code">SHA-256: <?= e($backup['sha256']) ?></div>
                                        </td>
                                        <td><?= e(strtoupper($backup['backup_type'])) ?></td>
                                        <td><?= e(BackupVaultManager::formatBytes((int)$backup['size_bytes'])) ?></td>
                                        <td><?= e($backup['created_at']) ?><div class="bc-small"><?= e($backup['creator_name'] ?: ($backup['creator_username'] ?: 'System')) ?></div>
                                        </td>
                                        <td><span class="bc-pill <?= e($cls) ?>"><?= e(strtoupper($check['status'])) ?></span>
                                            <div class="bc-small"><?= e($check['message']) ?></div>
                                        </td>
                                        <td>
                                            <div class="bc-form"><a class="bc-btn" style="color:#222;background:#fff" href="../backup-vault/download.php?id=<?= (int)$backup['id'] ?>">Download</a>
                                                <form method="post" action="index.php" onsubmit="return confirm('Delete this saved backup? This cannot be undone.');"><input type="hidden" name="csrf" value="<?= e($csrf) ?>"><input type="hidden" name="action" value="delete_saved"><input type="hidden" name="id" value="<?= (int)$backup['id'] ?>"><button class="bc-btn" style="color:#8e2432;background:#fff" type="submit">Delete</button></form>
                                            </div>
                                        </td>
                                    </tr><?php endforeach;
                                    endif; ?></tbody>
                    </table>
                </div>
            </section>
            <aside>
                <div class="bc-card" style="margin-bottom:1rem">
                    <h2>On-demand Export</h2>
                    <div class="bc-sidebox"><strong>Full backup</strong><span class="bc-small">Schema and table data, streamed directly to your browser.</span></div>
                    <div class="bc-sidebox"><strong>Schema only</strong><span class="bc-small">Database structure without table data.</span></div>
                    <div class="bc-form"><a class="bc-btn" style="background:#222;color:#fff;border-color:#222" href="export.php?type=full">Download Full</a><a class="bc-btn" style="color:#222;background:#fff" href="export.php?type=schema">Download Schema</a></div>
                </div>
                <div class="bc-card" style="margin-bottom:1rem">
                    <h2>Database Details</h2><?php if ($overview): ?><div class="bc-kv"><span>Charset</span><strong><?= e((string)$overview['charset']) ?></strong></div>
                        <div class="bc-kv"><span>Collation</span><strong><?= e((string)$overview['collation']) ?></strong></div>
                        <div class="bc-kv"><span>Approx. rows</span><strong><?= e(number_format((int)$overview['total_rows'])) ?></strong></div>
                        <div class="bc-kv"><span>Estimated DB size</span><strong><?= e(DatabaseBackupManager::formatBytes((int)$overview['estimated_bytes'])) ?></strong></div><?php endif; ?>
                </div>
                <div class="bc-card">
                    <h2>Vault Status</h2>
                    <div class="bc-kv"><span>Folder</span><strong style="max-width:62%;text-align:right;word-break:break-word"><?= e($storage['path']) ?></strong></div>
                    <div class="bc-kv"><span>Writable</span><strong><?= $storage['writable'] ? 'Yes' : 'No' ?></strong></div>
                    <div class="bc-kv"><span>SQL files on disk</span><strong><?= e((string)$storage['files']) ?></strong></div>
                    <div class="bc-kv"><span>Latest saved</span><strong><?= e($last['created_at'] ?? 'None') ?></strong></div>
                    <div class="bc-note" style="margin-top:.75rem">Keep an independent off-server backup copy. A server-local vault is not a substitute for disaster recovery.</div>
                </div>
            </aside>
        </div>
        <div class="bc-card" style="margin-top:1rem;font-size:.77rem;opacity:.7">Unified Phase 27 interface. Phase 25 and Phase 26 metadata remain intact. Legacy backup URLs remain supported; the recommended entry point is this page.</div>
    </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>