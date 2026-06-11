<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<h1 class="fw-bold mb-4"><?= $contact ? 'Edit' : 'Tambah' ?> Contact</h1>
<form class="cardx" action="<?= esc($action) ?>" method="post"><?= csrf_field() ?>
<div class="row g-3">
<div class="col-md-6"><label class="form-label">Type</label><input class="form-control" name="type" value="<?= esc($contact['type'] ?? '') ?>"></div>
<div class="col-md-6"><label class="form-label">Label</label><input class="form-control" name="label" value="<?= esc($contact['label'] ?? '') ?>" required></div>
<div class="col-md-6"><label class="form-label">Value</label><input class="form-control" name="value" value="<?= esc($contact['value'] ?? '') ?>" required></div>
<div class="col-md-6"><label class="form-label">URL</label><input class="form-control" name="url" value="<?= esc($contact['url'] ?? '') ?>"></div>
<div class="col-md-6"><label class="form-label">Icon</label><input class="form-control" name="icon" value="<?= esc($contact['icon'] ?? 'bi-link-45deg') ?>"></div>
<div class="col-md-6"><label class="form-label">Urutan</label><input class="form-control" name="sort_order" type="number" value="<?= esc((string)($contact['sort_order'] ?? 0)) ?>"></div>
</div><button class="btn btn-info fw-bold mt-4">Simpan</button></form>
<?= $this->endSection() ?>
