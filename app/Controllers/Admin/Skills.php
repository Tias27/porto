<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SkillModel;

class Skills extends BaseController
{
    private SkillModel $model;

    public function __construct()
    {
        $this->model = new SkillModel();
    }

    public function index(): string
    {
        return view('admin/skills/index', ['skills' => $this->model->orderBy('category', 'ASC')->orderBy('sort_order', 'ASC')->findAll()]);
    }

    public function create(): string
    {
        return view('admin/skills/form', ['skill' => null, 'action' => '/' . ADMIN_AREA . '/skills']);
    }

    public function store()
    {
        $this->model->insert($this->payload());

        return redirect()->to('/' . ADMIN_AREA . '/skills')->with('success', 'Skill ditambahkan.');
    }

    public function edit(int $id): string
    {
        return view('admin/skills/form', ['skill' => $this->model->find($id), 'action' => '/' . ADMIN_AREA . "/skills/{$id}"]);
    }

    public function update(int $id)
    {
        $this->model->update($id, $this->payload());

        return redirect()->to('/' . ADMIN_AREA . '/skills')->with('success', 'Skill diperbarui.');
    }

    public function delete(int $id)
    {
        $this->model->delete($id);

        return redirect()->to('/' . ADMIN_AREA . '/skills')->with('success', 'Skill dihapus.');
    }

    private function payload(): array
    {
        $icon = trim((string) $this->request->getPost('icon'));

        return [
            'category' => trim((string) $this->request->getPost('category')),
            'name' => trim((string) $this->request->getPost('name')),
            'icon' => preg_match('/^bi-[a-z0-9-]+$/i', $icon) ? $icon : 'bi-stars',
            'sort_order' => (int) $this->request->getPost('sort_order'),
        ];
    }
}
