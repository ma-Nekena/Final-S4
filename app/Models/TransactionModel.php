<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['type_transaction', 'telephone_expediteur', 'telephone_destinataire', 'montant', 'frais'];
}