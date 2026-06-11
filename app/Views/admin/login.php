<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <link rel="icon" type="image/svg+xml" href="/assets/img/favicon-cat.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { min-height:100vh; display:grid; place-items:center; background:radial-gradient(circle at top,#172554,#05070b 50%); color:#fff; }
        .login-card { width:min(430px,92vw); padding:30px; border:1px solid rgba(255,255,255,.12); border-radius:24px; background:rgba(255,255,255,.08); backdrop-filter:blur(18px); }
        .form-control { background:#0f1720; border-color:rgba(255,255,255,.14); color:#fff; }
    </style>
</head>
<body>
    <form class="login-card" action="<?= site_url(ADMIN_AREA . '/login') ?>" method="post">
        <?= csrf_field() ?>
        <h1 class="h3 fw-bold">Admin Login</h1>
        <p class="text-secondary">Masuk untuk mengelola portfolio.</p>
        <?php if (session('error')): ?><div class="alert alert-danger"><?= esc(session('error')) ?></div><?php endif; ?>
        <label class="form-label">Email</label>
        <input class="form-control mb-3" name="email" type="email" value="<?= old('email') ?>" required>
        <label class="form-label">Password</label>
        <input class="form-control mb-4" name="password" type="password" required>
        <button class="btn btn-info w-100 fw-bold">Login</button>
        <p class="small text-secondary mt-3 mb-0">Default: admin@portfolio.test / admin123</p>
    </form>
</body>
</html>
