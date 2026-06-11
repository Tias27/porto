<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('admin_id')) {
            return redirect()->to('/' . ADMIN_AREA);
        }

        return view('admin/login');
    }

    public function attempt()
    {
        $user = (new UserModel())->where('email', $this->request->getPost('email'))->first();

        if (! $user || ! password_verify((string) $this->request->getPost('password'), $user['password'])) {
            usleep(300000);

            return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
        }

        session()->regenerate(true);
        session()->set([
            'admin_id' => $user['id'],
            'admin_name' => $user['name'],
        ]);

        return redirect()->to('/' . ADMIN_AREA);
    }

    public function logout()
    {
        session()->remove(['admin_id', 'admin_name']);
        session()->regenerate(true);

        return redirect()->to('/' . ADMIN_AREA . '/login')->with('success', 'Logout berhasil.');
    }
}
