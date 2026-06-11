<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table = 'projects';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title',
        'slug',
        'thumbnail',
        'description',
        'features',
        'technologies',
        'demo_url',
        'github_url',
        'status',
        'is_featured',
        'sort_order',
    ];
    protected $useTimestamps = true;
}
