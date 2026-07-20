<?php

namespace App\Services;

use App\Models\AutreOperateurModel;

class AutreOperateurService
{
    protected $autreOperateurModel;

    public function __construct()
    {
        $this->autreOperateurModel = new AutreOperateurModel();
    }

    public function getAll()
    {
        return $this->autreOperateurModel->findAll();
    }

    public function ajouter($data)
    {
        return $this->autreOperateurModel->save($data);
    }

    public function supprimer($id)
    {
        return $this->autreOperateurModel->delete($id);
    }
}