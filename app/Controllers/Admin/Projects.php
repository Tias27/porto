<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProjectModel;

class Projects extends BaseController
{
    private ProjectModel $model;

    public function __construct()
    {
        $this->model = new ProjectModel();
    }

    public function index(): string
    {
        return view('admin/projects/index', ['projects' => $this->model->orderBy('sort_order', 'ASC')->findAll()]);
    }

    public function create(): string
    {
        return view('admin/projects/form', ['project' => null, 'action' => '/' . ADMIN_AREA . '/projects']);
    }

    public function store()
    {
        try {
            $this->model->insert($this->payload());
        } catch (\InvalidArgumentException $exception) {
            return redirect()->back()->withInput()->with('error', $exception->getMessage());
        }

        return redirect()->to('/' . ADMIN_AREA . '/projects')->with('success', 'Project ditambahkan.');
    }

    public function edit(int $id): string
    {
        return view('admin/projects/form', ['project' => $this->model->find($id), 'action' => '/' . ADMIN_AREA . "/projects/{$id}"]);
    }

    public function update(int $id)
    {
        try {
            $this->model->update($id, $this->payload($id));
        } catch (\InvalidArgumentException $exception) {
            return redirect()->back()->withInput()->with('error', $exception->getMessage());
        }

        return redirect()->to('/' . ADMIN_AREA . '/projects')->with('success', 'Project diperbarui.');
    }

    public function delete(int $id)
    {
        $this->model->delete($id);

        return redirect()->to('/' . ADMIN_AREA . '/projects')->with('success', 'Project dihapus.');
    }

    private function payload(?int $id = null): array
    {
        $thumbnail = $id ? ($this->model->find($id)['thumbnail'] ?? '') : '';
        $file = $this->request->getFile('thumbnail');

        if ($file && $file->isValid() && ! $file->hasMoved()) {
            if (! $this->isAllowedImage($file)) {
                throw new \InvalidArgumentException('Thumbnail harus JPG, PNG, atau WebP maksimal 2MB.');
            }

            $name = $file->getRandomName();
            if (! is_dir(FCPATH . 'uploads/projects')) {
                mkdir(FCPATH . 'uploads/projects', 0755, true);
            }
            $file->move(FCPATH . 'uploads/projects', $name, true);
            $thumbnail = 'uploads/projects/' . $name;
        }

        return [
            'title' => trim((string) $this->request->getPost('title')),
            'slug' => url_title((string) $this->request->getPost('title'), '-', true),
            'thumbnail' => $thumbnail,
            'description' => trim((string) $this->request->getPost('description')),
            'features' => trim((string) $this->request->getPost('features')),
            'technologies' => trim((string) $this->request->getPost('technologies')),
            'demo_url' => $this->safeUrl((string) $this->request->getPost('demo_url')),
            'github_url' => $this->safeUrl((string) $this->request->getPost('github_url')),
            'status' => trim((string) $this->request->getPost('status')),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'sort_order' => (int) $this->request->getPost('sort_order'),
        ];
    }

    private function isAllowedImage($file): bool
    {
        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

        return $file->getSizeByUnit('mb') <= 2
            && in_array($file->getMimeType(), $allowedMimes, true)
            && in_array(strtolower($file->getClientExtension()), $allowedExtensions, true);
    }

    private function safeUrl(string $url): string
    {
        $url = trim($url);

        if ($url === '' || $url === '#') {
            return '#';
        }

        return filter_var($url, FILTER_VALIDATE_URL)
            && in_array(parse_url($url, PHP_URL_SCHEME), ['http', 'https'], true)
            ? $url
            : '#';
    }
}
