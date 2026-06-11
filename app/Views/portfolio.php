<?php
$skillLogos = [
    'PHP' => ['simple' => 'php'],
    'CodeIgniter' => ['simple' => 'codeigniter'],
    'Laravel' => ['simple' => 'laravel'],
    'Node.js' => ['simple' => 'nodedotjs'],
    'MySQL' => ['simple' => 'mysql'],
    'PostgreSQL' => ['simple' => 'postgresql'],
    'API Integration' => ['local' => '/assets/img/tech/prompt.svg'],
    'Prompting' => ['local' => '/assets/img/tech/prompt.svg'],
    'Pencarian Dokumen' => ['local' => '/assets/img/tech/rag.svg'],
    'Burp Suite' => ['simple' => 'burpsuite'],
    'Nessus' => ['local' => '/assets/img/tech/nessus.svg'],
    'Nmap' => ['local' => '/assets/img/tech/nmap.svg'],
    'Git' => ['simple' => 'git'],
    'GitHub' => ['simple' => 'github'],
    'Linux' => ['simple' => 'linux'],
    'Docker' => ['simple' => 'docker'],
];
?>
<!doctype html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= esc($settings['seo_description'] ?? $profile['tagline']) ?>">
    <meta name="keywords" content="M Tias Anggara Putra, Backend Developer, Web Developer, CodeIgniter, Laravel, Portfolio">
    <meta name="author" content="M Tias Anggara Putra">
    <meta property="og:title" content="<?= esc($settings['seo_title'] ?? 'M Tias Anggara Putra Portfolio') ?>">
    <meta property="og:description" content="<?= esc($profile['tagline']) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= esc(current_url(), 'attr') ?>">
    <meta property="og:image" content="<?= esc(base_url('assets/img/hero-workspace.png'), 'attr') ?>">
    <title><?= esc($settings['seo_title'] ?? 'M Tias Anggara Putra - Backend Developer Portfolio') ?></title>
    <link rel="canonical" href="<?= esc(current_url(), 'attr') ?>">
    <link rel="icon" type="image/svg+xml" href="/assets/img/favicon-cat.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/portfolio.css?v=20260611-chat-drag">
</head>
<body>
    <div class="loader" id="loader"><span></span></div>
    <div class="scroll-progress" id="scrollProgress"></div>

    <nav class="navbar navbar-expand-lg fixed-top portfolio-nav">
        <div class="container">
            <a class="navbar-brand" href="#home"><span class="brand-mark">MT</span><?= esc($profile['short_name']) ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <div class="navbar-nav ms-auto align-items-lg-center">
                    <a class="nav-link" href="#home">Beranda</a>
                    <a class="nav-link" href="#foundation">Stack</a>
                    <a class="nav-link" href="#projects">Portfolio</a>
                    <a class="nav-link" href="#experience">Pengalaman</a>
                    <a class="nav-link" href="#contact">Kontak</a>
                    <button class="theme-toggle ms-lg-2" id="themeToggle" type="button" aria-label="Toggle dark mode"><i class="bi bi-sun"></i></button>
                </div>
            </div>
        </div>
    </nav>

    <main id="home">
        <section class="hero-section">
            <div class="mesh mesh-left"></div>
            <div class="mesh mesh-right"></div>
            <div class="container position-relative">
                <div class="row align-items-center hero-row min-vh-100 py-5">
                    <div class="col-lg-7" data-aos="fade-up">
                        <div class="availability"><span></span> Siap untuk project baru</div>
                        <h1 class="hero-title">Halo, saya<br><span>M Tias</span></h1>
                        <p class="hero-subtitle"><?= esc($profile['role']) ?> dari <?= esc($profile['location']) ?></p>
                        <p class="hero-description"><?= esc($profile['description']) ?></p>
                        <div class="d-flex flex-wrap gap-3 mt-4">
                            <a class="btn btn-glow" href="#contact">Hubungi Saya <i class="bi bi-arrow-up-right"></i></a>
                            <a class="btn btn-soft" href="<?= ! empty($settings['cv_file']) ? esc(base_url($settings['cv_file']), 'attr') : '#' ?>">Unduh CV <i class="bi bi-download"></i></a>
                            <a class="btn btn-soft" href="#projects">Lihat Project <i class="bi bi-grid-1x2"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-5" data-aos="zoom-in" data-aos-delay="120">
                        <div class="portrait-frame">
                            <div class="portrait-glow"></div>
                            <div class="portrait-avatar">
                                <img src="/assets/img/fotosaya.jpeg" alt="Foto M Tias Anggara Putra" loading="eager">
                            </div>
                            <div class="portrait-badge"><i class="bi bi-stars"></i></div>
                            <div class="portrait-meta">
                                <span><?= esc($profile['name']) ?></span>
                                <strong><?= esc($profile['photo_caption']) ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="foundation-section" id="foundation">
            <div class="container">
                <div class="compact-heading text-center" data-aos="fade-up">
                    <h2>Fondasi Teknologi</h2>
                    <p>Stack yang saya pakai untuk membangun website, backend, database, dan sistem digital</p>
                </div>
                <div class="tech-wall" data-aos="fade-up" data-aos-delay="80">
                    <?php foreach ($skills as $items): ?>
                        <?php foreach ($items as $skill): ?>
                            <span>
                                <?php if (isset($skillLogos[$skill['name']]['simple'])): ?>
                                    <img src="https://cdn.simpleicons.org/<?= esc($skillLogos[$skill['name']]['simple'], 'attr') ?>/d8a657" alt="" loading="lazy">
                                <?php elseif (isset($skillLogos[$skill['name']]['local'])): ?>
                                    <img src="<?= esc($skillLogos[$skill['name']]['local'], 'attr') ?>" alt="" loading="lazy">
                                <?php else: ?>
                                    <i class="bi <?= esc($skill['icon'] ?? 'bi-stars') ?>"></i>
                                <?php endif; ?>
                                <?= esc($skill['name']) ?>
                            </span>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="section-wrap" id="about">
            <div class="container">
                <div class="compact-heading text-center" data-aos="fade-up">
                    <h2><?= esc($profile['about_title']) ?></h2>
                    <p><?= esc($profile['about_description']) ?></p>
                </div>
                <div class="service-grid">
                    <article class="service-card" data-aos="fade-up">
                        <i class="bi bi-code-square"></i>
                        <h3>Backend Engineering</h3>
                        <p>Membangun API, struktur database, autentikasi, dan arsitektur server-side yang mudah dirawat</p>
                    </article>
                    <article class="service-card" data-aos="fade-up" data-aos-delay="80">
                        <i class="bi bi-cpu"></i>
                        <h3>Integrasi Sistem</h3>
                        <p>Menghubungkan aplikasi dengan API, layanan eksternal, dan alur kerja sederhana</p>
                    </article>
                    <article class="service-card" data-aos="fade-up" data-aos-delay="120">
                        <i class="bi bi-window-sidebar"></i>
                        <h3>Web Development</h3>
                        <p>Membuat aplikasi web responsif dengan CodeIgniter, Laravel, Bootstrap, dan MySQL</p>
                    </article>
                    <article class="service-card" data-aos="fade-up" data-aos-delay="160">
                        <i class="bi bi-shield-check"></i>
                        <h3>Security Mindset</h3>
                        <p>Memahami dasar pengujian keamanan dengan Burp Suite, Nmap, dan Nessus</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="section-wrap" id="projects">
            <div class="container">
                <div class="section-heading" data-aos="fade-up">
                    <span>Project Unggulan</span>
                    <h2>Karya Terbaru</h2>
                    <p>Beberapa project yang merepresentasikan pengalaman saya di web development, backend, dan sistem informasi</p>
                </div>
                <div class="project-bento">
                    <?php foreach ($projects as $index => $project): ?>
                        <article class="project-card <?= $index === 0 ? 'featured' : '' ?>" data-aos="fade-up" data-aos-delay="<?= esc((string) ($index * 80), 'attr') ?>">
                            <div class="project-thumb">
                                <?php if (! empty($project['thumbnail'])): ?>
                                    <img src="<?= esc(base_url($project['thumbnail']), 'attr') ?>" alt="<?= esc($project['title'], 'attr') ?>" loading="lazy">
                                <?php else: ?>
                                    <div class="project-mock">
                                        <span></span><span></span><span></span>
                                        <i class="bi bi-stars"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="project-body">
                                <div class="project-meta">
                                    <span><?= esc($project['status']) ?></span>
                                    <span><?= esc($project['technologies']) ?></span>
                                </div>
                                <h3><?= esc($project['title']) ?></h3>
                                <p><?= esc($project['description']) ?></p>
                                <?php if (! empty($project['features'])): ?>
                                    <ul>
                                        <?php foreach (array_filter(explode("\n", $project['features'])) as $feature): ?>
                                            <li><?= esc($feature) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                                <div class="project-actions">
                                    <a href="<?= esc($project['demo_url'] ?: '#', 'attr') ?>">Demo <i class="bi bi-box-arrow-up-right"></i></a>
                                    <a href="<?= esc($project['github_url'] ?: '#', 'attr') ?>">GitHub <i class="bi bi-github"></i></a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="section-wrap" id="experience">
            <div class="container">
                <div class="section-heading" data-aos="fade-up">
                    <span>Timeline Terbaru</span>
                    <h2>Catatan perjalanan project Terbaru</h2>
                </div>
                <div class="timeline">
                    <?php foreach ($experiences as $experience): ?>
                        <article data-aos="fade-left">
                            <span><?= esc($experience['year']) ?></span>
                            <h3><?= esc($experience['title']) ?></h3>
                            <p><?= esc($experience['description']) ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="section-wrap" id="skills">
            <div class="container">
                <div class="section-heading" data-aos="fade-up">
                    <span>Peta Skill</span>
                    <h2>Stack yang saya pakai saat membangun produk web</h2>
                </div>
                <div class="row g-3">
                    <?php foreach ($skills as $category => $items): ?>
                        <div class="col-md-6 col-xl-4" data-aos="fade-up">
                            <article class="skill-card">
                                <h3><?= esc($category) ?></h3>
                                <div class="skill-tags">
                                    <?php foreach ($items as $skill): ?>
                                        <span>
                                            <?php if (isset($skillLogos[$skill['name']]['simple'])): ?>
                                                <img src="https://cdn.simpleicons.org/<?= esc($skillLogos[$skill['name']]['simple'], 'attr') ?>/d8a657" alt="" loading="lazy">
                                            <?php elseif (isset($skillLogos[$skill['name']]['local'])): ?>
                                                <img src="<?= esc($skillLogos[$skill['name']]['local'], 'attr') ?>" alt="" loading="lazy">
                                            <?php else: ?>
                                                <i class="bi <?= esc($skill['icon'] ?? 'bi-stars') ?>"></i>
                                            <?php endif; ?>
                                            <?= esc($skill['name']) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="section-wrap" id="contact">
            <div class="container">
                <div class="section-heading" data-aos="fade-up">
                    <span>Mari Kolaborasi</span>
                    <h2>Mari ngobrol soal backend, website, atau project digital berikutnya</h2>
                </div>
                <div class="contact-grid">
                    <?php foreach ($contacts as $contact): ?>
                        <a class="contact-card" href="<?= esc($contact['url'] ?: '#', 'attr') ?>" data-aos="fade-up">
                            <i class="bi <?= esc($contact['icon'] ?: 'bi-link-45deg') ?>"></i>
                            <span><?= esc($contact['label']) ?></span>
                            <strong><?= esc($contact['value']) ?></strong>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>

    <div class="ai-chat-widget" id="aiChatWidget">
        <button class="ai-chat-toggle" id="aiChatToggle" type="button" aria-label="Buka chat AI">
            <i class="bi bi-chat-dots"></i>
        </button>
        <section class="ai-chat-panel" id="aiChatPanel" aria-label="Chat AI portfolio">
            <div class="ai-chat-head">
                <div>
                    <span>AI Portfolio</span>
                    <strong>Tanya soal project saya</strong>
                </div>
                <button id="aiChatClose" type="button" aria-label="Tutup chat"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="ai-chat-messages" id="aiChatMessages">
                <div class="ai-message bot">Halo, mau tanya soal project, skill, atau kontak?</div>
            </div>
            <form class="ai-chat-form" id="aiChatForm">
                <input id="aiChatInput" name="message" autocomplete="off" maxlength="800" placeholder="Tulis pertanyaan..." required>
                <button type="submit" aria-label="Kirim pesan"><i class="bi bi-send"></i></button>
            </form>
        </section>
    </div>

    <button class="back-to-top" id="backToTop" type="button" aria-label="Back to top"><i class="bi bi-arrow-up"></i></button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="/assets/js/portfolio.js?v=20260611-chat-drag"></script>
</body>
</html>
