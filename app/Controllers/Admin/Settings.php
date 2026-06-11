<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingModel;

class Settings extends BaseController
{
    public function index(): string
    {
        $settings = [];
        foreach ((new SettingModel())->findAll() as $setting) {
            $settings[$setting['setting_key']] = $setting['setting_value'];
        }

        return view('admin/settings/index', ['settings' => $settings]);
    }

    public function update()
    {
        $model = new SettingModel();
        $data = $this->request->getPost([
            'profile_name',
            'profile_short_name',
            'profile_role',
            'profile_location',
            'profile_tagline',
            'profile_description',
            'profile_email',
            'profile_years_learning',
            'profile_photo_caption',
            'about_title',
            'about_description',
            'seo_title',
            'seo_description',
            'cv_file',
        ]);
        $file = $this->request->getFile('cv_upload');

        if ($file && $file->isValid() && ! $file->hasMoved()) {
            if (! $this->isAllowedCv($file)) {
                return redirect()->back()->withInput()->with('error', 'CV harus PDF atau DOCX maksimal 5MB.');
            }

            $name = $file->getRandomName();
            if (! is_dir(FCPATH . 'uploads/cv')) {
                mkdir(FCPATH . 'uploads/cv', 0755, true);
            }
            $file->move(FCPATH . 'uploads/cv', $name, true);
            $data['cv_file'] = 'uploads/cv/' . $name;
        } else {
            $data['cv_file'] = $this->safeLocalFile((string) ($data['cv_file'] ?? ''));
        }

        foreach ($data as $key => $value) {
            $value = is_string($value) ? trim($value) : $value;
            $row = $model->where('setting_key', $key)->first();
            $row ? $model->update($row['id'], ['setting_value' => $value]) : $model->insert(['setting_key' => $key, 'setting_value' => $value]);
        }

        return redirect()->to('/' . ADMIN_AREA . '/settings')->with('success', 'Settings diperbarui.');
    }

    private function isAllowedCv($file): bool
    {
        $allowedMimes = [
            'application/pdf',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];
        $allowedExtensions = ['pdf', 'docx'];

        return $file->getSizeByUnit('mb') <= 5
            && in_array($file->getMimeType(), $allowedMimes, true)
            && in_array(strtolower($file->getClientExtension()), $allowedExtensions, true);
    }

    private function safeLocalFile(string $path): string
    {
        $path = trim(str_replace('\\', '/', $path));

        if ($path === '') {
            return '';
        }

        if (! str_starts_with($path, 'uploads/cv/')) {
            return '';
        }

        return preg_match('#^uploads/cv/[A-Za-z0-9._-]+\.(pdf|docx)$#i', $path) ? $path : '';
    }
}
