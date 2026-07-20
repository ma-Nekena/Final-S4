<?php

namespace App\Services;

use App\Models\PrefixeModel;

class PrefixeService
{
    protected $prefixeModel;

    public function __construct()
    {
        $this->prefixeModel = new PrefixeModel();
    }
    public function getAll()
    {
        return $this->prefixeModel->findAll();
    }
    public function ajouterPrefixe($prefixe)
    {
        $prefixe = trim($prefixe ?? '');

        if ($prefixe === '') {
            return false;
        }

        return $this->prefixeModel->save([
            'prefixe' => $prefixe
        ]);
    }
    public function supprimerPrefixe($id)
    {
        return $this->prefixeModel->delete($id);
    }
    public function verifierPrefixe($numero)
    {
        $prefixes = $this->prefixeModel->findAll();

        foreach ($prefixes as $prefixe) {
            if (strpos($numero, $prefixe['prefixe']) === 0) {
                return true;
            }
        }

        return false;
    }
}