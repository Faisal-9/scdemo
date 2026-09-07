<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';

if (Auth::check()) {
    redirect(adminUrl('dashboard.php'));
}

$error = null;

if (isPost()) {
    CSRF::verify($_POST['csrf_token'] ?? null);

    $username = postString('username');
    $password = (string) ($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = 'Username and password are required.';
    } elseif (!Auth::attempt($username, $password)) {
        $error = 'Invalid credentials or login temporarily blocked.';
    } else {
        redirect(adminUrl('dashboard.php'));
    }
}

$loggedOut = isset($_GET['logout']);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(APP_NAME) ?> - Login</title>
    <link rel="stylesheet" href="<?= e(adminUrl('assets/css/admin.css')) ?>">
</head>
<body class="auth-body">
<main class="auth-card" aria-labelledby="login-title">
    <div class="brand-mark">STATE CORPS</div>
    <h1 id="login-title">CMS Administration</h1>
    <p class="muted">Authorized users only.</p>

    <?php if ($error !== null): ?>
        <div class="alert alert-error"><?= e($error) ?></div>
    <?php endif; ?>

    <?php if ($loggedOut): ?>
        <div class="alert alert-success">You have been logged out.</div>
    <?php endif; ?>

    <form method="post" action="" autocomplete="off">
        <?= CSRF::field() ?>

        <label for="username">Username</label>
        <input
            id="username"
            name="username"
            type="text"
            maxlength="100"
            autocomplete="username"
            required
            autofocus
        >

        <label for="password">Password</label>
        <input
            id="password"
            name="password"
            type="password"
            autocomplete="current-password"
            required
        >

        <button type="submit">Sign in</button>
    </form>
</main>
</body>
</html>
