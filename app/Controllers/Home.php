<?php

namespace App\Controllers;

use App\Models\ContactModel;
use App\Models\ExperienceModel;
use App\Models\ProjectModel;
use App\Models\SettingModel;
use App\Models\SkillModel;
use Throwable;

class Home extends BaseController
{
    public function index(): string
    {
        $settings = $this->sanitizeSettings($this->settings());

        return view('portfolio', [
            'profile' => $this->profile($settings),
            'projects' => $this->sanitizeProjects($this->records(ProjectModel::class, $this->fallbackProjects(), ['is_featured' => 1])),
            'experiences' => $this->records(ExperienceModel::class, $this->fallbackExperiences()),
            'skills' => $this->groupSkills($this->records(SkillModel::class, $this->fallbackSkills())),
            'contacts' => $this->sanitizeContacts($this->records(ContactModel::class, $this->fallbackContacts())),
            'settings' => $settings,
        ]);
    }

    public function sitemap()
    {
        $this->response->setContentType('application/xml');

        return view('sitemap', [
            'baseUrl' => rtrim(base_url(), '/'),
            'projects' => $this->records(ProjectModel::class, []),
        ]);
    }

    private function records(string $modelClass, array $fallback, array $where = []): array
    {
        try {
            $model = new $modelClass();

            if ($where !== []) {
                $model->where($where);
            }

            $records = $model->orderBy('sort_order', 'ASC')->findAll();

            return $records ?: $fallback;
        } catch (Throwable) {
            return $fallback;
        }
    }

    private function settings(): array
    {
        try {
            $settings = [];
            foreach ((new SettingModel())->findAll() as $setting) {
                $settings[$setting['setting_key']] = $setting['setting_value'];
            }

            return $settings;
        } catch (Throwable) {
            return ['cv_file' => '', 'seo_title' => 'M Tias Anggara Putra - Backend Developer Portfolio'];
        }
    }

    private function sanitizeSettings(array $settings): array
    {
        $settings['cv_file'] = $this->safeLocalFile((string) ($settings['cv_file'] ?? ''), 'uploads/cv', ['pdf', 'docx']);

        return $settings;
    }

    private function sanitizeProjects(array $projects): array
    {
        foreach ($projects as &$project) {
            $project['thumbnail'] = $this->safeLocalFile((string) ($project['thumbnail'] ?? ''), 'uploads/projects', ['jpg', 'jpeg', 'png', 'webp']);
            $project['demo_url'] = $this->safeUrl((string) ($project['demo_url'] ?? ''), ['http', 'https'], '#');
            $project['github_url'] = $this->safeUrl((string) ($project['github_url'] ?? ''), ['http', 'https'], '#');
        }

        unset($project);

        return $projects;
    }

    private function sanitizeContacts(array $contacts): array
    {
        foreach ($contacts as &$contact) {
            $contact['url'] = $this->safeUrl((string) ($contact['url'] ?? ''), ['http', 'https', 'mailto', 'tel'], '#');
            $contact['icon'] = preg_match('/^bi-[a-z0-9-]+$/i', (string) ($contact['icon'] ?? ''))
                ? $contact['icon']
                : 'bi-link-45deg';
        }

        unset($contact);

        return $contacts;
    }

    private function safeUrl(string $url, array $allowedSchemes, string $fallback = ''): string
    {
        $url = trim($url);

        if ($url === '' || $url === '#') {
            return $fallback;
        }

        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));

        return $scheme !== ''
            && in_array($scheme, $allowedSchemes, true)
            && filter_var($url, FILTER_VALIDATE_URL)
            ? $url
            : $fallback;
    }

    private function safeLocalFile(string $path, string $directory, array $extensions): string
    {
        $path = ltrim(trim(str_replace('\\', '/', $path)), '/');
        $directory = trim($directory, '/');

        if ($path === '' || str_contains($path, '..')) {
            return '';
        }

        $extensionPattern = implode('|', array_map('preg_quote', $extensions));
        $pattern = '#^' . preg_quote($directory, '#') . '/[A-Za-z0-9._-]+\.(' . $extensionPattern . ')$#i';

        return preg_match($pattern, $path) ? $path : '';
    }

    private function profile(array $settings): array
    {
        return [
            'name' => $settings['profile_name'] ?? 'M Tias Anggara Putra',
            'short_name' => $settings['profile_short_name'] ?? 'M Tias',
            'role' => $settings['profile_role'] ?? 'Backend Developer & Web Developer',
            'location' => $settings['profile_location'] ?? 'Indonesia',
            'tagline' => $settings['profile_tagline'] ?? 'Membangun aplikasi web yang rapi, cepat, dan mudah digunakan',
            'description' => $settings['profile_description'] ?? 'Saya mahasiswa informatika yang fokus membangun website, backend, database, dan sistem digital yang praktis dipakai',
            'email' => $settings['profile_email'] ?? 'mtias@example.com',
            'years_learning' => $settings['profile_years_learning'] ?? '3+',
            'about_title' => $settings['about_title'] ?? 'Beyond Just Coding',
            'about_description' => $settings['about_description'] ?? 'Saya membangun solusi web dari struktur database, backend, sampai tampilan yang nyaman digunakan',
            'photo_caption' => $settings['profile_photo_caption'] ?? 'Mahasiswa informatika yang ingin menguasai Jerman',
        ];
    }

    private function groupSkills(array $skills): array
    {
        $grouped = [];

        foreach ($skills as $skill) {
            $grouped[$skill['category']][] = $skill;
        }

        return $grouped;
    }

    private function fallbackProjects(): array
    {
        return [
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
            ],
            [
                'title' => 'Bot Absensi Telegram',
                'slug' => 'bot-absensi-telegram',
                'thumbnail' => '',
                'description' => 'Bot otomatisasi absensi mahasiswa dengan validasi data dan enkripsi payload',
                'features' => "Telegram bot\nAES Encryption\nAutomated attendance",
                'technologies' => 'Python, Telegram API, AES Encryption',
                'demo_url' => '#',
                'github_url' => '#',
                'status' => 'Prototype',
            ],
            [
                'title' => 'Sistem Informasi Waris',
                'slug' => 'sistem-informasi-waris',
                'thumbnail' => '',
                'description' => 'Platform konsultasi dan pengelolaan data ahli waris berbasis web',
                'features' => "CRUD data ahli waris\nKonsultasi\nManajemen laporan",
                'technologies' => 'CodeIgniter, MySQL, Bootstrap',
                'demo_url' => '#',
                'github_url' => '#',
                'status' => 'Completed',
            ],
        ];
    }

    private function fallbackExperiences(): array
    {
        return [
            ['year' => '2026', 'title' => 'CampusGPT', 'description' => 'Mengembangkan platform pendukung belajar mahasiswa dengan dokumen dan latihan otomatis'],
            ['year' => '2025', 'title' => 'Bot Absensi Telegram', 'description' => 'Membangun otomasi absensi berbasis Telegram API dan enkripsi AES'],
            ['year' => '2024', 'title' => 'Sistem Informasi Waris', 'description' => 'Membangun aplikasi web berbasis CodeIgniter dan MySQL'],
        ];
    }

    private function fallbackSkills(): array
    {
        return [
            ['category' => 'Backend', 'name' => 'PHP'], ['category' => 'Backend', 'name' => 'CodeIgniter 4'],
            ['category' => 'Backend', 'name' => 'Laravel'], ['category' => 'Backend', 'name' => 'Node.js'],
            ['category' => 'Database', 'name' => 'MySQL'], ['category' => 'Database', 'name' => 'PostgreSQL'],
            ['category' => 'Integrasi', 'name' => 'API Integration'], ['category' => 'Integrasi', 'name' => 'Prompting'], ['category' => 'Integrasi', 'name' => 'Pencarian Dokumen'],
            ['category' => 'Security', 'name' => 'Burp Suite'], ['category' => 'Security', 'name' => 'Nessus'], ['category' => 'Security', 'name' => 'Nmap'],
            ['category' => 'Tools', 'name' => 'Git'], ['category' => 'Tools', 'name' => 'GitHub'], ['category' => 'Tools', 'name' => 'Linux'], ['category' => 'Tools', 'name' => 'Docker'],
        ];
    }

    private function fallbackContacts(): array
    {
        return [
            ['type' => 'email', 'label' => 'Email', 'value' => 'mtias@example.com', 'url' => 'mailto:mtias@example.com', 'icon' => 'bi-envelope'],
            ['type' => 'whatsapp', 'label' => 'WhatsApp', 'value' => '+62 812 0000 0000', 'url' => 'https://wa.me/6281200000000', 'icon' => 'bi-whatsapp'],
            ['type' => 'github', 'label' => 'GitHub', 'value' => 'github.com/mtias', 'url' => 'https://github.com/mtias', 'icon' => 'bi-github'],
            ['type' => 'linkedin', 'label' => 'LinkedIn', 'value' => 'linkedin.com/in/mtias', 'url' => 'https://linkedin.com/in/mtias', 'icon' => 'bi-linkedin'],
        ];
    }
}
