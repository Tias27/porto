<?php
$adminPath = '/' . ADMIN_AREA;
$uri = '/' . trim(uri_string(), '/');
$navItems = [
    ['label' => 'Dashboard', 'icon' => 'bi-speedometer2', 'url' => $adminPath],
    ['label' => 'Projects', 'icon' => 'bi-grid', 'url' => $adminPath . '/projects'],
    ['label' => 'Timeline', 'icon' => 'bi-clock-history', 'url' => $adminPath . '/timeline'],
    ['label' => 'Skills', 'icon' => 'bi-stars', 'url' => $adminPath . '/skills'],
    ['label' => 'Contacts', 'icon' => 'bi-person-lines-fill', 'url' => $adminPath . '/contacts'],
    ['label' => 'Settings & CV', 'icon' => 'bi-gear', 'url' => $adminPath . '/settings'],
];
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Admin Portfolio') ?></title>
    <link rel="icon" type="image/svg+xml" href="/assets/img/favicon-cat.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
<div class="admin-shell">
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="admin-brand">
            <span class="admin-brand-mark">MT</span>
            <div>
                <strong>Portfolio Panel</strong>
                <span><?= esc(session('admin_name') ?? 'Admin') ?></span>
            </div>
        </div>

        <nav class="admin-nav">
            <?php foreach ($navItems as $item): ?>
                <?php $active = $uri === $item['url'] || str_starts_with($uri, $item['url'] . '/'); ?>
                <a class="<?= $active ? 'active' : '' ?>" href="<?= esc($item['url']) ?>">
                    <i class="bi <?= esc($item['icon']) ?>"></i>
                    <?= esc($item['label']) ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <div class="admin-sidebar-footer admin-nav">
            <a href="/" target="_blank"><i class="bi bi-box-arrow-up-right"></i>View Site</a>
            <a href="<?= esc($adminPath) ?>/logout"><i class="bi bi-door-open"></i>Logout</a>
        </div>
    </aside>

    <main class="admin-main">
        <div class="admin-topbar">
            <div>
                <small>Admin Area</small>
                <strong>Kelola konten portfolio dari satu tempat</strong>
            </div>
            <button class="mobile-nav-toggle" id="adminMenuToggle" type="button" aria-label="Toggle admin menu">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <?php if (session('success')): ?>
            <div class="alert alert-success"><?= esc(session('success')) ?></div>
        <?php endif; ?>
        <?php if (session('error')): ?>
            <div class="alert alert-danger"><?= esc(session('error')) ?></div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </main>
</div>

<script>
    document.getElementById('adminMenuToggle')?.addEventListener('click', () => {
        document.body.classList.toggle('admin-menu-open');
    });

    document.querySelectorAll('.admin-sidebar a').forEach((link) => {
        link.addEventListener('click', () => document.body.classList.remove('admin-menu-open'));
    });
</script>
</body>
</html>
