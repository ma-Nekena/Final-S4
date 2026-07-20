<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table            = 'comptes_clients';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['numero_telephone', 'solde'];
}