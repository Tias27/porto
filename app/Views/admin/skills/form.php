<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<h1 class="fw-bold mb-4"><?= $skill ? 'Edit' : 'Tambah' ?> Skill</h1>
<form class="cardx" action="<?= esc($action) ?>" method="post"><?= csrf_field() ?>
<label class="form-label">Kategori</label><input class="form-control mb-3" name="category" value="<?= esc($skill['category'] ?? '') ?>" required>
<label class="form-label">Nama Skill</label><input class="form-control mb-3" name="name" value="<?= esc($skill['name'] ?? '') ?>" required>
<label class="form-label">Bootstrap Icon Class</label><input class="form-control mb-3" name="icon" value="<?= esc($skill['icon'] ?? 'bi-stars') ?>">
<label class="form-label">Urutan</label><input class="form-control mb-3" name="sort_order" type="number" value="<?= esc((string)($skill['sort_order'] ?? 0)) ?>">
<button class="btn btn-info fw-bold">Simpan</button></form>
<?= $this->endSection() ?>
