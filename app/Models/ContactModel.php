<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactModel extends Model
{
    protected $table = 'contacts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['type', 'label', 'value', 'url', 'icon', 'sort_order'];
    protected $useTimestamps = true;
}
