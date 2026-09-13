<?php

declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
require_once __DIR__ . '/../../app/core/SystemHealthManager.php';
Auth::requirePermission('manage_system_health');
$report = SystemHealthManager::report();
$pageTitle = 'System Health';
require __DIR__ . '/../partials/header.php';
require __DIR__ . '/../partials/sidebar.php';
function shStatusClass(string $status): string
{
  return $status === 'ok' ? 'success' : ($status === 'warning' ? 'warning' : 'danger');
}
function shStatusIcon(string $status): string
{
  return $status === 'ok' ? '✓' : ($status === 'warning' ? '!' : '×');
}
?>
<main class="admin-main">
  <div class="admin-container">
    <?php require __DIR__ . '/../partials/alerts.php'; ?>
    <style>
      .sh-hero {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem 1.4rem;
        border-radius: 18px;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, rgba(25, 25, 25, .97), rgba(55, 55, 55, .9));
        color: #fff
      }

      .sh-hero h1 {
        margin: 0;
        font-size: 1.55rem
      }

      .sh-hero p {
        margin: .35rem 0 0;
        opacity: .78
      }

      .sh-actions {
        display: flex;
        gap: .5rem;
        align-items: center
      }

      .sh-btn {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        border: 1px solid rgba(255, 255, 255, .2);
        border-radius: 10px;
        padding: .55rem .8rem;
        color: #fff;
        text-decoration: none
      }

      .sh-score {
        min-width: 120px;
        text-align: right
      }

      .sh-score-num {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1
      }

      .sh-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1rem;
        margin-bottom: 1rem
      }

      .sh-stat {
        padding: 1rem 1.1rem;
        border-radius: 15px;
        background: var(--bs-body-bg, #fff);
        border: 1px solid rgba(0, 0, 0, .08)
      }

      .sh-stat .muted {
        font-size: .82rem
      }

      .sh-stat-num {
        font-size: 1.75rem;
        font-weight: 800;
        margin-top: .25rem
      }

      .sh-dot {
        display: inline-flex;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        margin-right: .45rem
      }

      .sh-dot.success {
        background: rgba(25, 135, 84, .12);
        color: #198754
      }

      .sh-dot.warning {
        background: rgba(255, 193, 7, .14);
        color: #9a7400
      }

      .sh-dot.danger {
        background: rgba(220, 53, 69, .12);
        color: #dc3545
      }

      .sh-group {
        margin-bottom: 1rem
      }

      .sh-group-title {
        display: flex;
        align-items: center;
        gap: .55rem;
        margin: 0 0 .65rem;
        font-size: 1rem
      }

      .sh-group-title .icon {
        width: 30px;
        height: 30px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, .05)
      }

      .sh-check {
        border: 1px solid rgba(0, 0, 0, .08);
        border-radius: 14px;
        background: var(--bs-body-bg, #fff);
        margin-bottom: .65rem;
        overflow: hidden
      }

      .sh-check-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding: .9rem 1rem;
        cursor: pointer
      }

      .sh-check-main {
        display: flex;
        align-items: flex-start;
        gap: .65rem
      }

      .sh-check-title {
        font-weight: 700
      }

      .sh-check-message {
        font-size: .9rem;
        margin-top: .15rem;
        opacity: .78
      }

      .sh-badge {
        font-size: .72rem;
        font-weight: 800;
        padding: .32rem .55rem;
        border-radius: 999px
      }

      .sh-badge.success {
        background: rgba(25, 135, 84, .11);
        color: #198754
      }

      .sh-badge.warning {
        background: rgba(255, 193, 7, .15);
        color: #8a6900
      }

      .sh-badge.danger {
        background: rgba(220, 53, 69, .1);
        color: #c02b3d
      }

      .sh-details {
        display: none;
        padding: 0 1rem 1rem 3.25rem
      }

      .sh-details.open {
        display: block
      }

      .sh-details ul {
        margin: 0;
        padding-left: 1.05rem
      }

      .sh-footer {
        font-size: .78rem;
        opacity: .7;
        margin-top: .75rem
      }

      @media(max-width:1100px) {
        .sh-grid {
          grid-template-columns: repeat(2, minmax(0, 1fr))
        }
      }

      @media(max-width:650px) {
        .sh-grid {
          grid-template-columns: 1fr
        }

        .sh-hero {
          align-items: flex-start;
          flex-direction: column
        }

        .sh-score {
          text-align: left
        }

        .sh-check-head {
          align-items: flex-start;
          flex-direction: column
        }
      }
    </style>
    <div class="sh-hero">
      <div>
        <h1>System Health</h1>
        <p>Extended read-only diagnostics for the CMS runtime, database, accounts, activity logs, assets, storage and security.</p>
      </div>
      <div class="sh-actions"><span class="muted" style="color:rgba(255,255,255,.68)">Checked <?= e($report['generated_at']) ?></span><a class="sh-btn" href="<?= e($_SERVER['REQUEST_URI'] ?? '') ?>">↻ Refresh</a>
        <div class="sh-score">
          <div class="sh-score-num"><?= e((string)$report['score']) ?>%</div>
          <div style="opacity:.72;font-size:.78rem">health score</div>
        </div>
      </div>
    </div>
    <div class="sh-grid">
      <div class="sh-stat">
        <div class="muted">Overall Status</div>
        <div class="sh-stat-num"><?= e(strtoupper($report['overall'])) ?></div>
      </div>
      <div class="sh-stat">
        <div class="muted">Checks Passed</div>
        <div class="sh-stat-num"><?= e((string)$report['summary']['ok']) ?></div>
      </div>
      <div class="sh-stat">
        <div class="muted">Warnings</div>
        <div class="sh-stat-num"><?= e((string)$report['summary']['warning']) ?></div>
      </div>
      <div class="sh-stat">
        <div class="muted">Critical</div>
        <div class="sh-stat-num"><?= e((string)$report['summary']['critical']) ?></div>
      </div>
    </div>
    <?php foreach ($report['groups'] as $group): ?>
      <section class="sh-group">
        <h2 class="sh-group-title"><span class="icon"><?= e($group['icon']) ?></span><?= e($group['title']) ?></h2>
        <?php foreach ($group['checks'] as $check): $status = (string)$check['status'];
          $cls = shStatusClass($status); ?>
          <div class="sh-check">
            <div class="sh-check-head" onclick="this.nextElementSibling.classList.toggle('open')">
              <div class="sh-check-main"><span class="sh-dot <?= e($cls) ?>"><?= e(shStatusIcon($status)) ?></span>
                <div>
                  <div class="sh-check-title"><?= e((string)$check['title']) ?></div>
                  <div class="sh-check-message"><?= e((string)$check['message']) ?></div>
                </div>
              </div>
              <span class="sh-badge <?= e($cls) ?>"><?= e(strtoupper($status)) ?></span>
            </div>
            <div class="sh-details">
              <ul><?php foreach ($check['details'] as $detail): ?><li><?= e((string)$detail) ?></li><?php endforeach; ?></ul>
            </div>
          </div>
        <?php endforeach; ?>
      </section>
    <?php endforeach; ?>
    <div class="admin-card sh-footer">Diagnostics are read-only. Nothing in this screen modifies CMS content, users, assets, database rows, or public files.</div>
  </div>
</main>
<?php require __DIR__ . '/../partials/footer.php'; ?>