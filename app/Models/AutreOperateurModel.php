<?php

namespace App\Models;

use CodeIgniter\Model;

class AutreOperateurModel extends Model
{
    protected $table            = 'autres_operateurs';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nom_operateur', 'prefixe', 'commission_pourcentage'];
}