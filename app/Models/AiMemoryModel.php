<?php

namespace App\Models;

use CodeIgniter\Model;

class AiMemoryModel extends Model
{
    protected $table = 'ai_memories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['memory_key', 'content'];
    protected $useTimestamps = true;
}
