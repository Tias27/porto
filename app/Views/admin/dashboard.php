<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="page-head">
    <div>
        <h1>Dashboard</h1>
        <p>Ringkasan konten yang tampil di halaman portfolio</p>
    </div>
    <a class="btn-admin" href="/<?= ADMIN_AREA ?>/projects/create"><i class="bi bi-plus-lg"></i>Tambah Project</a>
</div>

<div class="row g-3">
    <?php foreach ($counts as $label => $count): ?>
        <div class="col-md-6 col-xl-3">
            <article class="admin-card stat-card">
                <span><i class="bi bi-layers"></i><?= esc(ucfirst($label)) ?></span>
                <h2><?= esc((string) $count) ?></h2>
            </article>
        </div>
    <?php endforeach; ?>
</div>
<?= $this->endSection() ?>
