<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<h1 class="fw-bold mb-4">Settings & CV</h1>
<form class="cardx" action="/<?= ADMIN_AREA ?>/settings" method="post" enctype="multipart/form-data"><?= csrf_field() ?>
<h5 class="fw-bold mb-3">Profile Home</h5>
<div class="row g-3 mb-4">
<div class="col-md-8"><label class="form-label">Nama Lengkap</label><input class="form-control" name="profile_name" value="<?= esc($settings['profile_name'] ?? 'M Tias Anggara Putra') ?>"></div>
<div class="col-md-4"><label class="form-label">Nama Pendek</label><input class="form-control" name="profile_short_name" value="<?= esc($settings['profile_short_name'] ?? 'M Tias') ?>"></div>
<div class="col-md-6"><label class="form-label">Role / Subtitle</label><input class="form-control" name="profile_role" value="<?= esc($settings['profile_role'] ?? 'Backend Developer & Web Developer') ?>"></div>
<div class="col-md-3"><label class="form-label">Lokasi</label><input class="form-control" name="profile_location" value="<?= esc($settings['profile_location'] ?? 'Indonesia') ?>"></div>
<div class="col-md-3"><label class="form-label">Tahun Belajar</label><input class="form-control" name="profile_years_learning" value="<?= esc($settings['profile_years_learning'] ?? '3+') ?>"></div>
<div class="col-md-6"><label class="form-label">Email Profile</label><input class="form-control" name="profile_email" value="<?= esc($settings['profile_email'] ?? 'mtias@example.com') ?>"></div>
<div class="col-md-6"><label class="form-label">Tagline</label><input class="form-control" name="profile_tagline" value="<?= esc($settings['profile_tagline'] ?? 'Membangun aplikasi web yang rapi, cepat, dan mudah digunakan.') ?>"></div>
<div class="col-12"><label class="form-label">Deskripsi Hero</label><textarea class="form-control" name="profile_description" rows="4"><?= esc($settings['profile_description'] ?? 'Saya adalah mahasiswa informatika yang berfokus pada pengembangan aplikasi web, backend, database, dan sistem digital yang membantu pekerjaan jadi lebih efisien.') ?></textarea></div>
<div class="col-12"><label class="form-label">Caption Foto</label><input class="form-control" name="profile_photo_caption" value="<?= esc($settings['profile_photo_caption'] ?? 'Mahasiswa informatika yang ingin menguasai Jerman.') ?>"></div>
<div class="col-md-5"><label class="form-label">Judul About</label><input class="form-control" name="about_title" value="<?= esc($settings['about_title'] ?? 'Beyond Just Coding') ?>"></div>
<div class="col-md-7"><label class="form-label">Deskripsi About</label><input class="form-control" name="about_description" value="<?= esc($settings['about_description'] ?? 'Saya membangun solusi web secara menyeluruh, dari struktur database, backend, sampai tampilan yang nyaman digunakan.') ?>"></div>
</div>
<h5 class="fw-bold mb-3">SEO & CV</h5>
<label class="form-label">SEO Title</label><input class="form-control mb-3" name="seo_title" value="<?= esc($settings['seo_title'] ?? '') ?>">
<label class="form-label">SEO Description</label><textarea class="form-control mb-3" name="seo_description" rows="4"><?= esc($settings['seo_description'] ?? '') ?></textarea>
<label class="form-label">CV File Saat Ini</label><input class="form-control mb-3" name="cv_file" value="<?= esc($settings['cv_file'] ?? '') ?>">
<label class="form-label">Upload CV Baru</label><input class="form-control mb-4" type="file" name="cv_upload" accept=".pdf,.docx">
<button class="btn btn-info fw-bold">Simpan Settings</button></form>
<?= $this->endSection() ?>
