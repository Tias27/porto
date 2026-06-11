<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ExperienceModel;

class Experiences extends BaseController
{
    private ExperienceModel $model;

    public function __construct()
    {
        $this->model = new ExperienceModel();
    }

    public function index(): string
    {
        return view('admin/experiences/index', ['experiences' => $this->model->orderBy('sort_order', 'ASC')->findAll()]);
    }

    public function create(): string
    {
        return view('admin/experiences/form', ['experience' => null, 'action' => '/' . ADMIN_AREA . '/timeline']);
    }

    public function store()
    {
        $this->model->insert($this->payload());

        return redirect()->to('/' . ADMIN_AREA . '/timeline')->with('success', 'Timeline ditambahkan.');
    }

    public function edit(int $id): string
    {
        return view('admin/experiences/form', ['experience' => $this->model->find($id), 'action' => '/' . ADMIN_AREA . "/timeline/{$id}"]);
    }

    public function update(int $id)
    {
        $this->model->update($id, $this->payload());

        return redirect()->to('/' . ADMIN_AREA . '/timeline')->with('success', 'Timeline diperbarui.');
    }

    public function delete(int $id)
    {
        $this->model->delete($id);

        return redirect()->to('/' . ADMIN_AREA . '/timeline')->with('success', 'Timeline dihapus.');
    }

    private function payload(): array
    {
        return [
            'year' => trim((string) $this->request->getPost('year')),
            'title' => trim((string) $this->request->getPost('title')),
            'description' => trim((string) $this->request->getPost('description')),
            'sort_order' => (int) $this->request->getPost('sort_order'),
        ];
    }
}
