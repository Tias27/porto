CREATE DATABASE IF NOT EXISTS `porto` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `porto`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(120) NOT NULL,
  `email` VARCHAR(180) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(40) NOT NULL DEFAULT 'admin',
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `projects` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(160) NOT NULL,
  `slug` VARCHAR(180) NOT NULL UNIQUE,
  `thumbnail` VARCHAR(255) NULL,
  `description` TEXT NOT NULL,
  `features` TEXT NULL,
  `technologies` VARCHAR(255) NOT NULL,
  `demo_url` VARCHAR(255) NULL,
  `github_url` VARCHAR(255) NULL,
  `status` VARCHAR(60) NOT NULL DEFAULT 'In Development',
  `is_featured` TINYINT(1) NOT NULL DEFAULT 1,
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `experiences` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `year` VARCHAR(20) NOT NULL,
  `title` VARCHAR(160) NOT NULL,
  `description` TEXT NOT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `skills` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category` VARCHAR(80) NOT NULL,
  `name` VARCHAR(120) NOT NULL,
  `icon` VARCHAR(80) NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `contacts` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(60) NOT NULL,
  `label` VARCHAR(120) NOT NULL,
  `value` VARCHAR(180) NOT NULL,
  `url` VARCHAR(255) NULL,
  `icon` VARCHAR(80) NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `settings` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `setting_key` VARCHAR(120) NOT NULL UNIQUE,
  `setting_value` TEXT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
('M Tias Anggara Putra', 'admin@portfolio.test', '$2y$10$ns531Hmpm8/Ea3T4YCgCn.yxPPkQnPZ2aVLxgEHHySiqoi0A8zYHe', 'admin', NOW(), NOW());

INSERT INTO `projects` (`title`, `slug`, `thumbnail`, `description`, `features`, `technologies`, `demo_url`, `github_url`, `status`, `is_featured`, `sort_order`, `created_at`, `updated_at`) VALUES
('CampusGPT', 'campusgpt', '', 'Platform pendukung belajar mahasiswa dengan pengelolaan materi, ringkasan, flashcard, dan latihan soal', 'Manajemen materi\nRingkasan belajar\nFlashcard\nSoal latihan', 'Laravel, MySQL, API Integration', '#', '#', 'In Development', 1, 1, NOW(), NOW()),
('Bot Absensi Telegram', 'bot-absensi-telegram', '', 'Bot otomatisasi absensi mahasiswa dengan integrasi Telegram API dan proteksi AES Encryption', 'Absensi otomatis\nTelegram command\nAES Encryption', 'Python, Telegram API, AES Encryption', '#', '#', 'Prototype', 1, 2, NOW(), NOW()),
('Sistem Informasi Waris', 'sistem-informasi-waris', '', 'Platform konsultasi dan pengelolaan data ahli waris berbasis CodeIgniter, MySQL, dan Bootstrap', 'Manajemen data ahli waris\nKonsultasi digital\nLaporan terstruktur', 'CodeIgniter, MySQL, Bootstrap', '#', '#', 'Completed', 1, 3, NOW(), NOW());

INSERT INTO `experiences` (`year`, `title`, `description`, `sort_order`, `created_at`, `updated_at`) VALUES
('2026', 'CampusGPT', 'Mengembangkan platform pendukung belajar mahasiswa dengan dokumen dan latihan otomatis', 1, NOW(), NOW()),
('2025', 'Bot Absensi Telegram', 'Membangun otomasi absensi berbasis Telegram API, validasi command, dan AES Encryption', 2, NOW(), NOW()),
('2024', 'Sistem Informasi Waris', 'Membangun platform konsultasi dan pengelolaan data ahli waris berbasis web', 3, NOW(), NOW());

INSERT INTO `skills` (`category`, `name`, `icon`, `sort_order`, `created_at`, `updated_at`) VALUES
('Backend','PHP','bi-code-slash',1,NOW(),NOW()),('Backend','CodeIgniter 4','bi-code-slash',2,NOW(),NOW()),('Backend','Laravel','bi-code-slash',3,NOW(),NOW()),('Backend','Node.js','bi-node-plus',4,NOW(),NOW()),
('Database','MySQL','bi-database',5,NOW(),NOW()),('Database','PostgreSQL','bi-database',6,NOW(),NOW()),
('Integrasi','API Integration','bi-plug',7,NOW(),NOW()),('Integrasi','Prompting','bi-chat-square-text',8,NOW(),NOW()),('Integrasi','Pencarian Dokumen','bi-file-earmark-text',9,NOW(),NOW()),
('Security','Burp Suite','bi-shield-lock',10,NOW(),NOW()),('Security','Nessus','bi-shield-check',11,NOW(),NOW()),('Security','Nmap','bi-terminal',12,NOW(),NOW()),
('Tools','Git','bi-git',13,NOW(),NOW()),('Tools','GitHub','bi-github',14,NOW(),NOW()),('Tools','Linux','bi-terminal',15,NOW(),NOW()),('Tools','Docker','bi-box',16,NOW(),NOW());

INSERT INTO `contacts` (`type`, `label`, `value`, `url`, `icon`, `sort_order`, `created_at`, `updated_at`) VALUES
('email','Email','mtias@example.com','mailto:mtias@example.com','bi-envelope',1,NOW(),NOW()),
('whatsapp','WhatsApp','+62 812 0000 0000','https://wa.me/6281200000000','bi-whatsapp',2,NOW(),NOW()),
('github','GitHub','github.com/mtias','https://github.com/mtias','bi-github',3,NOW(),NOW()),
('linkedin','LinkedIn','linkedin.com/in/mtias','https://linkedin.com/in/mtias','bi-linkedin',4,NOW(),NOW());

INSERT INTO `settings` (`setting_key`, `setting_value`, `created_at`, `updated_at`) VALUES
('profile_name','M Tias Anggara Putra',NOW(),NOW()),
('profile_short_name','M Tias',NOW(),NOW()),
('profile_role','Backend Developer & Web Developer',NOW(),NOW()),
('profile_location','Indonesia',NOW(),NOW()),
('profile_tagline','Membangun aplikasi web yang rapi, cepat, dan mudah digunakan',NOW(),NOW()),
('profile_description','Saya mahasiswa informatika yang fokus membangun website, backend, database, dan sistem digital yang praktis dipakai',NOW(),NOW()),
('profile_email','mtias@example.com',NOW(),NOW()),
('profile_years_learning','3+',NOW(),NOW()),
('profile_photo_caption','Mahasiswa informatika yang ingin menguasai Jerman',NOW(),NOW()),
('about_title','Lebih dari sekadar menulis kode',NOW(),NOW()),
('about_description','Saya membangun solusi web dari struktur database, backend, sampai tampilan yang nyaman digunakan',NOW(),NOW()),
('seo_title','M Tias Anggara Putra - Backend Developer Portfolio',NOW(),NOW()),
('seo_description','Portfolio pribadi M Tias Anggara Putra, Informatics Student, Backend Developer, dan Web Developer',NOW(),NOW()),
('cv_file','',NOW(),NOW());
