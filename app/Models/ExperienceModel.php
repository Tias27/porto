<?php

namespace App\Models;

use CodeIgniter\Model;

class ExperienceModel extends Model
{
    protected $table = 'experiences';
    protected $primaryKey = 'id';
    protected $allowedFields = ['year', 'title', 'description', 'sort_order'];
    protected $useTimestamps = true;
}
