<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ContactModel;
use App\Models\ExperienceModel;
use App\Models\ProjectModel;
use App\Models\SkillModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        return view('admin/dashboard', [
            'counts' => [
                'projects' => (new ProjectModel())->countAll(),
                'experiences' => (new ExperienceModel())->countAll(),
                'skills' => (new SkillModel())->countAll(),
                'contacts' => (new ContactModel())->countAll(),
            ],
        ]);
    }
}
