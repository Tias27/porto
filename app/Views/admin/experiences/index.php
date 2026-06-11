<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <h1 class="fw-bold mb-1">Timeline</h1>
        <p class="text-secondary mb-0">Data di sini tampil otomatis pada section Jejak Pengalaman di halaman depan.</p>
    </div>
    <a class="btn btn-info fw-bold" href="/<?= ADMIN_AREA ?>/timeline/create">
        <i class="bi bi-plus-lg"></i> Tambah Timeline
    </a>
</div>

<div class="cardx table-responsive">
    <table class="table align-middle mb-0">
        <thead>
            <tr>
                <th style="width: 110px;">Tahun</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th style="width: 90px;">Urutan</th>
                <th class="text-end" style="width: 170px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($experiences === []): ?>
                <tr>
                    <td colspan="5" class="text-center text-secondary py-4">Belum ada data timeline.</td>
                </tr>
            <?php endif; ?>

            <?php foreach ($experiences as $item): ?>
                <tr>
                    <td><span class="badge text-bg-info"><?= esc($item['year']) ?></span></td>
                    <td class="fw-bold"><?= esc($item['title']) ?></td>
                    <td class="text-secondary"><?= esc($item['description']) ?></td>
                    <td><?= esc((string) $item['sort_order']) ?></td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-light" href="/<?= ADMIN_AREA ?>/timeline/<?= $item['id'] ?>/edit">Edit</a>
                        <form class="d-inline" method="post" action="/<?= ADMIN_AREA ?>/timeline/<?= $item['id'] ?>/delete" onsubmit="return confirm('Hapus item timeline ini?')">
                            <?= csrf_field() ?>
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
