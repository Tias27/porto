<?php $adminPath = '/' . ADMIN_AREA; ?>
<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="page-head">
    <div>
        <h1>Projects</h1>
        <p>Data di sini otomatis muncul di bagian karya terbaru halaman depan</p>
    </div>
    <a class="btn-admin" href="<?= esc($adminPath) ?>/projects/create"><i class="bi bi-plus-lg"></i>Tambah Project</a>
</div>

<div class="cardx table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Status</th>
                <th>Teknologi</th>
                <th>Featured</th>
                <th class="text-end">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($projects === []): ?>
                <tr><td colspan="5" class="text-center table-muted py-4">Belum ada project</td></tr>
            <?php endif; ?>

            <?php foreach ($projects as $project): ?>
                <tr>
                    <td class="fw-bold"><?= esc($project['title']) ?></td>
                    <td><span class="badge-soft"><?= esc($project['status']) ?></span></td>
                    <td class="table-muted"><?= esc($project['technologies']) ?></td>
                    <td><?= (int) $project['is_featured'] === 1 ? 'Ya' : 'Tidak' ?></td>
                    <td class="text-end">
                        <a class="btn-ghost btn-sm" href="<?= esc($adminPath) ?>/projects/<?= $project['id'] ?>/edit"><i class="bi bi-pencil"></i>Edit</a>
                        <form class="d-inline" action="<?= esc($adminPath) ?>/projects/<?= $project['id'] ?>/delete" method="post" onsubmit="return confirm('Hapus project ini?')">
                            <?= csrf_field() ?>
                            <button class="btn-ghost btn-danger-soft btn-sm"><i class="bi bi-trash"></i>Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
