<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/DatabaseBackupManager.php';
Auth::requirePermission('manage_database_backups');
$pageTitle = 'Database Backup';
$overview = null;
$error = null;
try {
  $overview = DatabaseBackupManager::overview();
} catch (Throwable $e) {
  $error = $e->getMessage();
}
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<main class="admin-main">
  <div class="admin-container">
    <?php require __DIR__ . '/../partials/alerts.php'; ?>
    <style>
      .db-hero {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        align-items: flex-start;
        padding: 1.3rem 1.4rem;
        border-radius: 18px;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, #141414, #343434);
        color: #fff
      }

      .db-hero h1 {
        margin: 0;
        font-size: 1.55rem
      }

      .db-hero p {
        margin: .35rem 0 0;
        opacity: .76
      }

      .db-actions {
        display: flex;
        gap: .5rem;
        flex-wrap: wrap
      }

      .db-btn {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .58rem .78rem;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, .18);
        color: #fff;
        text-decoration: none;
        background: rgba(255, 255, 255, .06)
      }

      .db-btn.primary {
        background: rgba(255, 255, 255, .14)
      }

      .db-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1rem;
        margin-bottom: 1rem
      }

      .db-stat,
      .db-card {
        background: var(--bs-body-bg, #fff);
        border: 1px solid rgba(0, 0, 0, .08);
        border-radius: 15px;
        padding: 1rem 1.1rem
      }

      .db-label {
        font-size: .8rem;
        opacity: .68
      }

      .db-num {
        font-size: 1.65rem;
        font-weight: 800;
        margin-top: .25rem
      }

      .db-muted {
        font-size: .82rem;
        opacity: .68
      }

      .db-card h2 {
        font-size: 1rem;
        margin: 0 0 .7rem
      }

      .db-table {
        width: 100%;
        border-collapse: collapse
      }

      .db-table th,
      .db-table td {
        padding: .62rem .55rem;
        border-bottom: 1px solid rgba(0, 0, 0, .06);
        text-align: left;
        font-size: .86rem
      }

      .db-table th {
        font-size: .76rem;
        text-transform: uppercase;
        letter-spacing: .03em;
        opacity: .62
      }

      .db-note {
        padding: .8rem 1rem;
        border-radius: 12px;
        background: rgba(255, 193, 7, .1);
        border: 1px solid rgba(255, 193, 7, .25);
        font-size: .84rem;
        margin-bottom: 1rem
      }

      .db-empty {
        padding: 1rem;
        border-radius: 12px;
        background: rgba(220, 53, 69, .08);
        color: #9f2536
      }

      .db-actions-form {
        display: flex;
        gap: .6rem;
        flex-wrap: wrap;
        align-items: center
      }

      .db-select {
        padding: .6rem .7rem;
        border: 1px solid rgba(0, 0, 0, .15);
        border-radius: 10px;
        background: var(--bs-body-bg, #fff)
      }

      @media(max-width:1000px) {
        .db-grid {
          grid-template-columns: repeat(2, minmax(0, 1fr))
        }
      }

      @media(max-width:650px) {
        .db-grid {
          grid-template-columns: 1fr
        }

        .db-hero {
          flex-direction: column
        }
      }
    </style>
    <div class="db-hero">
      <div>
        <h1>Database Backup Center</h1>
        <p>Inspect the CMS database and download a portable SQL backup without requiring mysqldump.</p>
      </div>
      <div class="db-actions"><a class="db-btn" href="../dashboard.php">← Dashboard</a><a class="db-btn primary" href="export.php?type=full">⬇ Full SQL Backup</a></div>
    </div>
    <?php if ($error): ?><div class="db-empty">Database inspection failed. <?= e($error) ?></div>
    <?php elseif ($overview): ?>
      <div class="db-grid">
        <div class="db-stat">
          <div class="db-label">Database</div>
          <div class="db-num" style="font-size:1.05rem;word-break:break-word"><?= e($overview['database']) ?></div>
          <div class="db-muted"><?= e($overview['server_version']) ?></div>
        </div>
        <div class="db-stat">
          <div class="db-label">Tables</div>
          <div class="db-num"><?= e((string)$overview['table_count']) ?></div>
          <div class="db-muted">Current schema</div>
        </div>
        <div class="db-stat">
          <div class="db-label">Approx. Rows</div>
          <div class="db-num"><?= e(number_format((int)$overview['total_rows'])) ?></div>
          <div class="db-muted">Engine estimates</div>
        </div>
        <div class="db-stat">
          <div class="db-label">Estimated Size</div>
          <div class="db-num"><?= e(DatabaseBackupManager::formatBytes((int)$overview['estimated_bytes'])) ?></div>
          <div class="db-muted"><?= e($overview['charset'] ?: 'charset unknown') ?></div>
        </div>
      </div>
      <div class="db-note"><strong>Backup safety:</strong> the export is generated on demand and streamed directly to the browser. No backup copy is stored inside the web root. Keep downloaded database backups outside public hosting and protect them like production credentials.</div>
      <div class="db-card" style="margin-bottom:1rem">
        <h2>Create Backup</h2>
        <form class="db-actions-form" method="get" action="export.php">
          <select class="db-select" name="type" aria-label="Backup type">
            <option value="full">Full backup — schema + data</option>
            <option value="schema">Schema only — no table data</option>
          </select>
          <button class="db-btn" style="background:#202020;color:#fff" type="submit">Generate SQL Backup</button>
        </form>
      </div>
      <div class="db-card">
        <h2>Database Tables</h2>
        <div style="overflow:auto">
          <table class="db-table">
            <thead>
              <tr>
                <th>Table</th>
                <th>Engine</th>
                <th>Rows</th>
                <th>Size</th>
                <th>Updated</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($overview['tables'] as $table): ?><tr>
                  <td><?= e($table['name']) ?></td>
                  <td><?= e($table['engine'] ?: '—') ?></td>
                  <td><?= e(number_format((int)$table['rows'])) ?></td>
                  <td><?= e(DatabaseBackupManager::formatBytes((int)$table['data_bytes'] + (int)$table['index_bytes'])) ?></td>
                  <td><?= e($table['update_time'] ?: '—') ?></td>
                </tr><?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="db-card" style="margin-top:1rem">
        <h2>Largest Table</h2>
        <div><?= e((string)($overview['largest_table']['name'] ?? 'Not available')) ?> <span class="db-muted">· <?= e(DatabaseBackupManager::formatBytes((int)($overview['largest_table']['bytes'] ?? 0))) ?></span></div>
      </div>
    <?php endif; ?>
    <div class="admin-card" style="margin-top:.9rem;font-size:.78rem;opacity:.7">This module is administrative tooling only. It does not change public website content or schema.</div>
  </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>