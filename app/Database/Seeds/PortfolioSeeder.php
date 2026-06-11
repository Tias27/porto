<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $this->db->table('users')->insert([
            'name' => 'M Tias Anggara Putra',
            'email' => 'admin@portfolio.test',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role' => 'admin',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->db->table('projects')->insertBatch([
            [
                'title' => 'CampusGPT',
                'slug' => 'campusgpt',
                'thumbnail' => '',
                'description' => 'Platform pendukung belajar mahasiswa dengan pengelolaan materi, ringkasan, flashcard, dan latihan soal',
                'features' => "Manajemen materi\nRingkasan belajar\nFlashcard\nSoal latihan",
                'technologies' => 'Laravel, MySQL, API Integration',
                'demo_url' => '#',
                'github_url' => '#',
                'status' => 'In Development',
                'is_featured' => 1,
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Bot Absensi Telegram',
                'slug' => 'bot-absensi-telegram',
                'thumbnail' => '',
                'description' => 'Bot otomatisasi absensi mahasiswa dengan integrasi Telegram API dan proteksi AES Encryption',
                'features' => "Absensi otomatis\nTelegram command\nAES Encryption",
                'technologies' => 'Python, Telegram API, AES Encryption',
                'demo_url' => '#',
                'github_url' => '#',
                'status' => 'Prototype',
                'is_featured' => 1,
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Sistem Informasi Waris',
                'slug' => 'sistem-informasi-waris',
                'thumbnail' => '',
                'description' => 'Platform konsultasi dan pengelolaan data ahli waris berbasis CodeIgniter, MySQL, dan Bootstrap',
                'features' => "Manajemen data ahli waris\nKonsultasi digital\nLaporan terstruktur",
                'technologies' => 'CodeIgniter, MySQL, Bootstrap',
                'demo_url' => '#',
                'github_url' => '#',
                'status' => 'Completed',
                'is_featured' => 1,
                'sort_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        $skills = [
            ['Backend', 'PHP'], ['Backend', 'CodeIgniter 4'], ['Backend', 'Laravel'], ['Backend', 'Node.js'],
            ['Database', 'MySQL'], ['Database', 'PostgreSQL'],
            ['Integrasi', 'API Integration'], ['Integrasi', 'Prompting'], ['Integrasi', 'Pencarian Dokumen'],
            ['Security', 'Burp Suite'], ['Security', 'Nessus'], ['Security', 'Nmap'],
            ['Tools', 'Git'], ['Tools', 'GitHub'], ['Tools', 'Linux'], ['Tools', 'Docker'],
        ];

        foreach ($skills as $index => $skill) {
            $this->db->table('skills')->insert([
                'category' => $skill[0],
                'name' => $skill[1],
                'icon' => 'bi-stars',
                'sort_order' => $index + 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $this->db->table('experiences')->insertBatch([
            ['year' => '2026', 'title' => 'CampusGPT', 'description' => 'Mengembangkan platform pendukung belajar mahasiswa dengan dokumen dan latihan otomatis', 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['year' => '2025', 'title' => 'Bot Absensi Telegram', 'description' => 'Membangun otomasi absensi berbasis Telegram API, validasi command, dan AES Encryption', 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['year' => '2024', 'title' => 'Sistem Informasi Waris', 'description' => 'Membangun platform konsultasi dan pengelolaan data ahli waris berbasis web', 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->db->table('contacts')->insertBatch([
            ['type' => 'email', 'label' => 'Email', 'value' => 'mtias@example.com', 'url' => 'mailto:mtias@example.com', 'icon' => 'bi-envelope', 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'whatsapp', 'label' => 'WhatsApp', 'value' => '+62 812 0000 0000', 'url' => 'https://wa.me/6281200000000', 'icon' => 'bi-whatsapp', 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'github', 'label' => 'GitHub', 'value' => 'github.com/mtias', 'url' => 'https://github.com/mtias', 'icon' => 'bi-github', 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'linkedin', 'label' => 'LinkedIn', 'value' => 'linkedin.com/in/mtias', 'url' => 'https://linkedin.com/in/mtias', 'icon' => 'bi-linkedin', 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->db->table('settings')->insertBatch([
            ['setting_key' => 'profile_name', 'setting_value' => 'M Tias Anggara Putra', 'created_at' => $now, 'updated_at' => $now],
            ['setting_key' => 'profile_short_name', 'setting_value' => 'M Tias', 'created_at' => $now, 'updated_at' => $now],
            ['setting_key' => 'profile_role', 'setting_value' => 'Backend Developer & Web Developer', 'created_at' => $now, 'updated_at' => $now],
            ['setting_key' => 'profile_location', 'setting_value' => 'Indonesia', 'created_at' => $now, 'updated_at' => $now],
            ['setting_key' => 'profile_tagline', 'setting_value' => 'Membangun aplikasi web yang rapi, cepat, dan mudah digunakan', 'created_at' => $now, 'updated_at' => $now],
            ['setting_key' => 'profile_description', 'setting_value' => 'Saya mahasiswa informatika yang fokus membangun website, backend, database, dan sistem digital yang praktis dipakai', 'created_at' => $now, 'updated_at' => $now],
            ['setting_key' => 'profile_email', 'setting_value' => 'mtias@example.com', 'created_at' => $now, 'updated_at' => $now],
            ['setting_key' => 'profile_years_learning', 'setting_value' => '3+', 'created_at' => $now, 'updated_at' => $now],
            ['setting_key' => 'profile_photo_caption', 'setting_value' => 'Mahasiswa informatika yang ingin menguasai Jerman', 'created_at' => $now, 'updated_at' => $now],
            ['setting_key' => 'about_title', 'setting_value' => 'Lebih dari sekadar menulis kode', 'created_at' => $now, 'updated_at' => $now],
            ['setting_key' => 'about_description', 'setting_value' => 'Saya membangun solusi web dari struktur database, backend, sampai tampilan yang nyaman digunakan', 'created_at' => $now, 'updated_at' => $now],
            ['setting_key' => 'seo_title', 'setting_value' => 'M Tias Anggara Putra - Backend Developer Portfolio', 'created_at' => $now, 'updated_at' => $now],
            ['setting_key' => 'seo_description', 'setting_value' => 'Portfolio pribadi M Tias Anggara Putra, Informatics Student, Backend Developer, dan Web Developer', 'created_at' => $now, 'updated_at' => $now],
            ['setting_key' => 'cv_file', 'setting_value' => '', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
