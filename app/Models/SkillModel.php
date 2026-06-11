<?php

namespace App\Models;

use CodeIgniter\Model;

class SkillModel extends Model
{
    protected $table = 'skills';
    protected $primaryKey = 'id';
    protected $allowedFields = ['category', 'name', 'icon', 'sort_order'];
    protected $useTimestamps = true;
}
