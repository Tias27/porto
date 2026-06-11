<?php

namespace App\Controllers;

use App\Models\AiMemoryModel;
use App\Models\ContactModel;
use App\Models\ExperienceModel;
use App\Models\ProjectModel;
use App\Models\SettingModel;
use App\Models\SkillModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Throwable;

class Chat extends BaseController
{
    public function send(): ResponseInterface
    {
        $message = trim((string) $this->request->getPost('message'));
        $history = $this->request->getPost('history') ?? [];

        if (is_string($history)) {
            $decodedHistory = json_decode($history, true);
            $history = is_array($decodedHistory) ? $decodedHistory : [];
        }

        if ($message === '') {
            return $this->response->setStatusCode(422)->setJSON([
                'reply' => 'Tulis pertanyaannya dulu ya',
            ]);
        }

        if (mb_strlen($message) > 3000) {
            return $this->response->setStatusCode(422)->setJSON([
                'reply' => 'Pertanyaannya kepanjangan, coba pendekin sedikit',
            ]);
        }

        if (! $this->allowChatRequest()) {
            return $this->response->setStatusCode(429)->setJSON([
                'reply' => 'Chat lagi dibatasi sebentar. Coba lagi beberapa saat ya',
            ]);
        }

        try {
            $memoryReply = $this->handleMemoryCommand($message);

            if ($memoryReply !== null) {
                return $this->response->setJSON(['reply' => $memoryReply]);
            }

            $quickReply = $this->quickReply($message);

            if ($quickReply !== null) {
                return $this->response->setJSON(['reply' => $quickReply]);
            }

            $reply = $this->askProvider($message, is_array($history) ? $history : []);

            return $this->response->setJSON(['reply' => $reply]);
        } catch (Throwable $exception) {
            log_message('error', 'AI chat failed: {message}', ['message' => $exception->getMessage()]);

            return $this->response->setJSON([
                'reply' => 'AI-nya lagi belum bisa dihubungi. Tapi kamu tetap bisa tanya lewat WhatsApp atau email di bagian kontak',
            ]);
        }
    }

    private function askProvider(string $message, array $history): string
    {
        $provider = strtolower((string) env('AI_PROVIDER', 'kimchi'));

        if ($provider !== 'kimchi') {
            throw new \RuntimeException('Unsupported AI provider');
        }

        $baseUrl = rtrim((string) env('KIMCHI_BASE_URL'), '/');
        $model = (string) env('KIMCHI_CHAT_MODEL', env('KIMCHI_MODEL', 'kimi2.6'));

        if ($baseUrl === '' || $model === '') {
            throw new \RuntimeException('AI provider is not configured');
        }

        $messages = [
            ['role' => 'system', 'content' => $this->systemPrompt()],
        ];

        foreach (array_slice($history, -10) as $item) {
            $role = ($item['role'] ?? '') === 'assistant' ? 'assistant' : 'user';
            $content = trim((string) ($item['content'] ?? ''));

            if ($content !== '') {
                $messages[] = ['role' => $role, 'content' => mb_substr($content, 0, 1200)];
            }
        }

        $messages[] = ['role' => 'user', 'content' => $message];

        $headers = ['Content-Type' => 'application/json'];
        $apiKey = (string) env('KIMCHI_API_KEY');

        if ($apiKey !== '') {
            $headers['Authorization'] = 'Bearer ' . $apiKey;
        }

        putenv('HTTP_PROXY=');
        putenv('HTTPS_PROXY=');
        putenv('ALL_PROXY=');
        putenv('http_proxy=');
        putenv('https_proxy=');
        putenv('all_proxy=');
        unset($_SERVER['HTTP_PROXY'], $_SERVER['HTTPS_PROXY'], $_SERVER['ALL_PROXY']);

        $client = Services::curlrequest([
            'timeout' => (int) env('KIMCHI_TIMEOUT', 25),
            'connect_timeout' => (int) env('KIMCHI_CONNECT_TIMEOUT', 8),
            'verify' => filter_var(env('KIMCHI_VERIFY_SSL', true), FILTER_VALIDATE_BOOLEAN),
            'http_errors' => false,
        ]);

        $response = $client->post($baseUrl . '/chat/completions', [
            'headers' => $headers,
            'json' => [
                'model' => $model,
                'messages' => $messages,
                'temperature' => 0.25,
                'max_tokens' => 900,
            ],
            'curl' => [
                CURLOPT_PROXY => '',
                CURLOPT_NOPROXY => '*',
            ],
        ]);

        if ($response->getStatusCode() >= 400) {
            throw new \RuntimeException('AI provider returned HTTP ' . $response->getStatusCode() . ': ' . mb_substr((string) $response->getBody(), 0, 500));
        }

        $payload = json_decode((string) $response->getBody(), true);
        $reply = $this->cleanReply((string) ($payload['choices'][0]['message']['content'] ?? ''));

        if ($reply === '') {
            throw new \RuntimeException('AI provider returned an empty reply');
        }

        return $reply;
    }

    private function allowChatRequest(): bool
    {
        $cache = Services::cache();
        $ip = $this->request->getIPAddress();
        $memoryKey = $this->request->getCookie('ai_memory_key') ?: 'guest';
        $key = 'chat_rate_' . sha1($ip . '|' . $memoryKey);
        $count = (int) ($cache->get($key) ?? 0);

        if ($count >= 30) {
            return false;
        }

        $cache->save($key, $count + 1, 60);

        return true;
    }

    private function systemPrompt(): string
    {
        $settings = $this->settings();
        $projects = $this->projectsSummary();
        $contacts = $this->contactsSummary();
        $skills = $this->skillsSummary();
        $experiences = $this->experiencesSummary();
        $memories = $this->memoriesSummary();
        $timeContext = $this->timeContext();

        return implode("\n", [
            'Kamu adalah asisten AI umum yang dipasang di website portfolio M Tias Anggara Putra.',
            'Tugasmu membantu user untuk hampir semua hal yang wajar: belajar, brainstorming, menulis, merapikan kalimat, menerjemahkan, membuat rencana, memberi ide, menjelaskan konsep, matematika sederhana, produktivitas, karier, coding, debug error, arsitektur sistem, database, security dasar, dan problem solving sehari-hari.',
            'Jangan memaksa semua jawaban dikaitkan ke Tias atau portfolio. Pakai konteks portfolio hanya saat pertanyaan memang menyangkut Tias, project, skill, pengalaman, kontak, atau website ini.',
            'Kalau user bertanya hal umum di luar portfolio, jawab seperti AI assistant biasa yang helpful dan langsung ke inti.',
            'Kalau user minta langkah praktis, berikan langkah yang bisa dilakukan. Kalau user minta ide, beri beberapa opsi singkat.',
            'Jawab dalam bahasa Indonesia yang santai, natural, dan tidak seperti template AI.',
            'Gunakan bahasa Indonesia saja kecuali user jelas meminta bahasa lain.',
            'Untuk pertanyaan sederhana, jawab maksimal 2-4 kalimat. Untuk pertanyaan yang meminta analisis/perbandingan/saran/tutorial, boleh lebih detail tapi tetap rapi.',
            'Boleh memberi saran atau inferensi ringan dari konteks, tapi bedakan fakta dari perkiraan.',
            'Kamu tidak punya live browsing web. Kalau user minta info yang harus paling terbaru, bilang perlu dicek ke sumber terbaru.',
            'Untuk topik medis, hukum, finansial, keamanan, atau keputusan berisiko, jawab hati-hati dan sarankan cek ke ahli/sumber resmi bila perlu.',
            'Jangan mulai dengan kata seperti "Siap", "Siapp", "Tentu", atau "Berikut".',
            'Jangan pakai markdown tebal, bullet list, numbering, atau emoji kecuali user jelas meminta daftar.',
            'Jawab langsung tanpa menampilkan reasoning, chain-of-thought, tag <think>, atau catatan proses.',
            'Kontak yang ada di konteks adalah kontak publik yang memang tampil di website, jadi boleh disebutkan saat user menanyakan cara menghubungi.',
            'Kalau user minta nomor WhatsApp, email, GitHub, atau LinkedIn, jawab langsung dari bagian Kontak.',
            'Kalau user bertanya sekarang pagi, siang, sore, atau malam, jawab memakai bagian Waktu Sekarang saja.',
            'Jangan menebak cuaca, lokasi detail, atau suasana yang tidak ada di konteks.',
            'Jangan mengarang detail yang tidak ada di konteks. Kalau tidak tahu, bilang singkat bahwa datanya belum tersedia.',
            'Kalau ditanya "siapa Tias", jawab ringkas seperti teman yang menjelaskan, bukan CV panjang.',
            'Kalau user bertanya apakah Tias cocok untuk project tertentu, jawab dengan menghubungkan kebutuhan user ke skill/project yang ada.',
            'Waktu Sekarang:',
            $timeContext,
            'Memori User Saat Ini:',
            $memories,
            'Profil:',
            'Nama: ' . ($settings['profile_name'] ?? 'M Tias Anggara Putra'),
            'Role: ' . ($settings['profile_role'] ?? 'Backend Developer & Web Developer'),
            'Lokasi: ' . ($settings['profile_location'] ?? 'Indonesia'),
            'Tagline: ' . ($settings['profile_tagline'] ?? ''),
            'Deskripsi: ' . ($settings['profile_description'] ?? ''),
            'Project:',
            $projects,
            'Skill:',
            $skills,
            'Timeline/Pengalaman:',
            $experiences,
            'Kontak:',
            $contacts,
        ]);
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
            return [];
        }
    }

    private function cleanReply(string $reply): string
    {
        $reply = preg_replace('/<think\b[^>]*>.*?<\/think>/is', '', $reply) ?? $reply;
        $reply = preg_replace('/^\s*(reasoning|analysis|catatan)\s*:\s*/iu', '', $reply) ?? $reply;
        $reply = preg_replace('/^\s*(siap+|tentu|berikut)[,!\.\s]+/iu', '', $reply) ?? $reply;
        $reply = preg_replace('/[\x{1F300}-\x{1FAFF}\x{2600}-\x{27BF}]/u', '', $reply) ?? $reply;
        $reply = preg_replace('/\*\*(.*?)\*\*/s', '$1', $reply) ?? $reply;
        $reply = preg_replace('/__(.*?)__/s', '$1', $reply) ?? $reply;
        $reply = preg_replace('/`([^`]*)`/', '$1', $reply) ?? $reply;
        $reply = preg_replace('/^\s*[-*]\s+/m', '', $reply) ?? $reply;
        $reply = preg_replace('/^\s*\d+\.\s+/m', '', $reply) ?? $reply;
        $reply = preg_replace('/[\x{4E00}-\x{9FFF}\x{3040}-\x{30FF}\x{AC00}-\x{D7AF}]/u', '', $reply) ?? $reply;
        $reply = preg_replace('/[ \t]{2,}/', ' ', $reply) ?? $reply;

        return trim($reply);
    }

    private function quickReply(string $message): ?string
    {
        $normalized = mb_strtolower($message);

        if (preg_match('/\b(pagi|siang|sore|malam|jam|waktu)\b/u', $normalized)) {
            return $this->timeContext();
        }

        if (preg_match('/\b(wa|whatsapp|nomor|no hp|no wa|kontak)\b/u', $normalized)) {
            return $this->contactValue(['whatsapp', 'wa'], 'WhatsApp');
        }

        if (preg_match('/\b(email|gmail|mail)\b/u', $normalized)) {
            return $this->contactValue(['email'], 'Email');
        }

        if (preg_match('/\b(github|git hub)\b/u', $normalized)) {
            return $this->contactValue(['github'], 'GitHub');
        }

        if (preg_match('/\b(linkedin|linked in)\b/u', $normalized)) {
            return $this->contactValue(['linkedin'], 'LinkedIn');
        }

        return null;
    }

    private function handleMemoryCommand(string $message): ?string
    {
        $normalized = mb_strtolower($message);

        if (preg_match('/\b(lupain|hapus memori|hapus memory|forget)\b/u', $normalized)) {
            try {
                (new AiMemoryModel())->where('memory_key', $this->memoryKey())->delete();

                return 'Oke, memory percakapan ini sudah aku hapus';
            } catch (Throwable) {
                return 'Aku belum bisa hapus memory-nya sekarang';
            }
        }

        if (preg_match('/\b(apa|coba|sebutin|lihat).*\b(ingat|inget|memori|memory)\b|\b(kamu|lu|loe|kau)\s+(ingat|inget)\b|\b(memory kamu|memori kamu|kamu ingat apa|kamu inget apa)\b/u', $normalized)) {
            $memories = $this->memories();

            if ($memories === []) {
                return 'Belum ada yang aku simpan dari percakapan ini';
            }

            return 'Yang aku ingat dari percakapan ini: ' . implode('; ', array_column($memories, 'content'));
        }

        if (preg_match('/\b(catat|remember|simpan)\b(?:\s+(?:bahwa|kalau|ini|:))?\s*(.+)$/iu', $message, $matches)
            || preg_match('/\b(ingat|inget)\b\s+(?:bahwa|kalau|ini|:)\s*(.+)$/iu', $message, $matches)
        ) {
            $content = trim($matches[2]);

            if (mb_strlen($content) < 3) {
                return 'Mau aku ingat apa? Tulis misalnya: ingat bahwa aku suka Laravel';
            }

            $content = mb_substr($content, 0, 500);

            try {
                (new AiMemoryModel())->insert([
                    'memory_key' => $this->memoryKey(),
                    'content' => $content,
                ]);

                return 'Oke, aku ingat: ' . $content;
            } catch (Throwable) {
                return 'Aku belum bisa menyimpan memory-nya sekarang';
            }
        }

        return null;
    }

    private function memoryKey(): string
    {
        $key = $this->request->getCookie('ai_memory_key');

        if (! is_string($key) || $key === '') {
            $key = bin2hex(random_bytes(16));
            $this->response->setCookie([
                'name' => 'ai_memory_key',
                'value' => $key,
                'expire' => YEAR,
                'path' => '/',
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
        }

        return $key;
    }

    private function memories(): array
    {
        try {
            return (new AiMemoryModel())
                ->where('memory_key', $this->memoryKey())
                ->orderBy('id', 'DESC')
                ->findAll(12);
        } catch (Throwable) {
            return [];
        }
    }

    private function memoriesSummary(): string
    {
        $memories = array_reverse($this->memories());

        if ($memories === []) {
            return '- Belum ada memory untuk user ini';
        }

        return implode("\n", array_map(static function (array $memory): string {
            return '- ' . $memory['content'];
        }, $memories));
    }

    private function contactValue(array $types, string $label): string
    {
        try {
            $contacts = (new ContactModel())->orderBy('sort_order', 'ASC')->findAll();

            foreach ($contacts as $contact) {
                $type = mb_strtolower((string) ($contact['type'] ?? ''));
                $contactLabel = mb_strtolower((string) ($contact['label'] ?? ''));

                foreach ($types as $needle) {
                    if (str_contains($type, $needle) || str_contains($contactLabel, $needle)) {
                        $url = trim((string) ($contact['url'] ?? ''));
                        $suffix = $url !== '' ? ', linknya ' . $url : '';

                        return $label . ' Tias: ' . $contact['value'] . $suffix;
                    }
                }
            }
        } catch (Throwable) {
        }

        return $label . ' Tias belum tersedia di data kontak';
    }

    private function contactsSummary(): string
    {
        try {
            $contacts = (new ContactModel())->orderBy('sort_order', 'ASC')->findAll();

            if ($contacts === []) {
                return '- Data kontak belum tersedia';
            }

            return implode("\n", array_map(static function (array $contact): string {
                $url = trim((string) ($contact['url'] ?? ''));
                $suffix = $url !== '' ? ' (' . $url . ')' : '';

                return '- ' . $contact['label'] . ': ' . $contact['value'] . $suffix;
            }, $contacts));
        } catch (Throwable) {
            return '- Data kontak belum tersedia';
        }
    }

    private function timeContext(): string
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Jakarta'));
        $hour = (int) $now->format('G');
        $period = match (true) {
            $hour >= 4 && $hour < 11 => 'pagi',
            $hour >= 11 && $hour < 15 => 'siang',
            $hour >= 15 && $hour < 18 => 'sore',
            default => 'malam',
        };

        return 'Sekarang ' . $period . ', jam ' . $now->format('H:i') . ' WIB, tanggal ' . $now->format('d-m-Y') . '.';
    }

    private function skillsSummary(): string
    {
        try {
            $skills = (new SkillModel())->orderBy('category', 'ASC')->orderBy('sort_order', 'ASC')->findAll();

            if ($skills === []) {
                return '- Data skill belum tersedia';
            }

            $grouped = [];
            foreach ($skills as $skill) {
                $grouped[$skill['category']][] = $skill['name'];
            }

            $lines = [];
            foreach ($grouped as $category => $items) {
                $lines[] = '- ' . $category . ': ' . implode(', ', $items);
            }

            return implode("\n", $lines);
        } catch (Throwable) {
            return '- Data skill belum tersedia';
        }
    }

    private function experiencesSummary(): string
    {
        try {
            $experiences = (new ExperienceModel())->orderBy('sort_order', 'ASC')->findAll(8);

            if ($experiences === []) {
                return '- Data pengalaman belum tersedia';
            }

            return implode("\n", array_map(static function (array $experience): string {
                return '- ' . $experience['year'] . ' - ' . $experience['title'] . ': ' . $experience['description'];
            }, $experiences));
        } catch (Throwable) {
            return '- Data pengalaman belum tersedia';
        }
    }

    private function projectsSummary(): string
    {
        try {
            $projects = (new ProjectModel())->orderBy('sort_order', 'ASC')->findAll(10);

            if ($projects === []) {
                return '- Belum ada data project';
            }

            return implode("\n", array_map(static function (array $project): string {
                $features = trim((string) ($project['features'] ?? ''));
                $featuresText = $features !== '' ? ' Fitur: ' . str_replace("\n", ', ', $features) . '.' : '';

                return '- ' . $project['title'] . ': ' . $project['description'] . ' Status: ' . $project['status'] . '. Tech: ' . $project['technologies'] . '.' . $featuresText;
            }, $projects));
        } catch (Throwable) {
            return '- Data project belum tersedia';
        }
    }
}
