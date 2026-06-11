<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<h1 class="fw-bold mb-4"><?= $project ? 'Edit' : 'Tambah' ?> Project</h1>
<form class="cardx" action="<?= esc($action) ?>" method="post" enctype="multipart/form-data">
<?= csrf_field() ?>
<div class="row g-3">
<div class="col-md-8"><label class="form-label">Judul</label><input class="form-control" name="title" value="<?= esc($project['title'] ?? '') ?>" required></div>
<div class="col-md-4"><label class="form-label">Status</label><input class="form-control" name="status" value="<?= esc($project['status'] ?? 'In Development') ?>"></div>
<div class="col-12"><label class="form-label">Deskripsi</label><textarea class="form-control" name="description" rows="4" required><?= esc($project['description'] ?? '') ?></textarea></div>
<div class="col-md-6"><label class="form-label">Teknologi</label><input class="form-control" name="technologies" value="<?= esc($project['technologies'] ?? '') ?>"></div>
<div class="col-md-6"><label class="form-label">Thumbnail</label><input class="form-control" name="thumbnail" type="file" accept="image/*"></div>
<div class="col-12"><label class="form-label">Fitur, satu baris per item</label><textarea class="form-control" name="features" rows="4"><?= esc($project['features'] ?? '') ?></textarea></div>
<div class="col-md-6"><label class="form-label">Demo URL</label><input class="form-control" name="demo_url" value="<?= esc($project['demo_url'] ?? '') ?>"></div>
<div class="col-md-6"><label class="form-label">Github URL</label><input class="form-control" name="github_url" value="<?= esc($project['github_url'] ?? '') ?>"></div>
<div class="col-md-4"><label class="form-label">Urutan</label><input class="form-control" name="sort_order" type="number" value="<?= esc((string)($project['sort_order'] ?? 0)) ?>"></div>
<div class="col-md-4 d-flex align-items-end"><label class="form-check"><input class="form-check-input" name="is_featured" type="checkbox" value="1" <?= !isset($project) || ($project['is_featured'] ?? 1) ? 'checked' : '' ?>> Featured</label></div>
</div><button class="btn btn-info fw-bold mt-4">Simpan</button>
</form>
<?= $this->endSection() ?>
