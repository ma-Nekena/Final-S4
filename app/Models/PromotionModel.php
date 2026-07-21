<?php

namespace App\Models;

use CodeIgniter\Model;

class PromotionModel extends Model
{
    protected $table            = 'promotion_pourcentage';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['promotion_pourcentage'];
}