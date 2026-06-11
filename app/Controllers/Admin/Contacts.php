<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ContactModel;

class Contacts extends BaseController
{
    private ContactModel $model;

    public function __construct()
    {
        $this->model = new ContactModel();
    }

    public function index(): string
    {
        return view('admin/contacts/index', ['contacts' => $this->model->orderBy('sort_order', 'ASC')->findAll()]);
    }

    public function create(): string
    {
        return view('admin/contacts/form', ['contact' => null, 'action' => '/' . ADMIN_AREA . '/contacts']);
    }

    public function store()
    {
        $this->model->insert($this->payload());

        return redirect()->to('/' . ADMIN_AREA . '/contacts')->with('success', 'Contact ditambahkan.');
    }

    public function edit(int $id): string
    {
        return view('admin/contacts/form', ['contact' => $this->model->find($id), 'action' => '/' . ADMIN_AREA . "/contacts/{$id}"]);
    }

    public function update(int $id)
    {
        $this->model->update($id, $this->payload());

        return redirect()->to('/' . ADMIN_AREA . '/contacts')->with('success', 'Contact diperbarui.');
    }

    public function delete(int $id)
    {
        $this->model->delete($id);

        return redirect()->to('/' . ADMIN_AREA . '/contacts')->with('success', 'Contact dihapus.');
    }

    private function payload(): array
    {
        return [
            'type' => trim((string) $this->request->getPost('type')),
            'label' => trim((string) $this->request->getPost('label')),
            'value' => trim((string) $this->request->getPost('value')),
            'url' => $this->safeContactUrl((string) $this->request->getPost('url')),
            'icon' => trim((string) $this->request->getPost('icon')),
            'sort_order' => (int) $this->request->getPost('sort_order'),
        ];
    }

    private function safeContactUrl(string $url): string
    {
        $url = trim($url);

        if ($url === '') {
            return '';
        }

        $scheme = parse_url($url, PHP_URL_SCHEME);

        return filter_var($url, FILTER_VALIDATE_URL)
            && in_array($scheme, ['http', 'https', 'mailto', 'tel'], true)
            ? $url
            : '';
    }
}
