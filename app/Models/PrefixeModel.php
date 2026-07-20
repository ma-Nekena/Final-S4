<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixeModel extends Model
{
    protected $table            = 'prefixes_operateurs';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['prefixe'];
}