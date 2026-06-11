<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between mb-4"><h1 class="fw-bold">Skills</h1><a class="btn btn-info fw-bold" href="/<?= ADMIN_AREA ?>/skills/create">Tambah</a></div>
<div class="cardx table-responsive"><table class="table"><tbody><?php foreach ($skills as $skill): ?><tr><td><?= esc($skill['category']) ?></td><td><?= esc($skill['name']) ?></td><td class="text-end"><a class="btn btn-sm btn-outline-light" href="/<?= ADMIN_AREA ?>/skills/<?= $skill['id'] ?>/edit">Edit</a><form class="d-inline" method="post" action="/<?= ADMIN_AREA ?>/skills/<?= $skill['id'] ?>/delete"><?= csrf_field() ?><button class="btn btn-sm btn-outline-danger">Hapus</button></form></td></tr><?php endforeach; ?></tbody></table></div>
<?= $this->endSection() ?>
