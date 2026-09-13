<?php
declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';
$target = '../database-backup/';
header('Location: ' . $target, true, 302); exit;
