<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="mb-4">
    <a class="text-secondary text-decoration-none" href="/<?= ADMIN_AREA ?>/timeline">
        <i class="bi bi-arrow-left"></i> Kembali ke Timeline
    </a>
    <h1 class="fw-bold mt-3 mb-1"><?= $experience ? 'Edit' : 'Tambah' ?> Timeline</h1>
    <p class="text-secondary mb-0">Isi data yang akan muncul di section Jejak Pengalaman pada halaman depan.</p>
</div>

<form class="cardx" action="<?= esc($action) ?>" method="post">
    <?= csrf_field() ?>

    <div class="row g-3">
        <div class="col-md-3">
            <label class="form-label">Tahun</label>
            <input class="form-control" name="year" value="<?= esc($experience['year'] ?? '') ?>" placeholder="2026" required>
        </div>
        <div class="col-md-7">
            <label class="form-label">Judul Timeline</label>
            <input class="form-control" name="title" value="<?= esc($experience['title'] ?? '') ?>" placeholder="Nama project / kegiatan" required>
        </div>
        <div class="col-md-2">
            <label class="form-label">Urutan</label>
            <input class="form-control" name="sort_order" type="number" value="<?= esc((string)($experience['sort_order'] ?? 0)) ?>">
        </div>
        <div class="col-12">
            <label class="form-label">Deskripsi Singkat</label>
            <textarea class="form-control" name="description" rows="5" placeholder="Ceritakan ringkas apa yang dikerjakan."><?= esc($experience['description'] ?? '') ?></textarea>
        </div>
    </div>

    <div class="d-flex gap-2 mt-4">
        <button class="btn btn-info fw-bold">Simpan Timeline</button>
        <a class="btn btn-outline-light" href="/<?= ADMIN_AREA ?>/timeline">Batal</a>
    </div>
</form>
<?= $this->endSection() ?>
