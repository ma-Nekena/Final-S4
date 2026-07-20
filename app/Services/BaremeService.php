<?php

namespace App\Services;

use App\Models\BaremeModel;

class BaremeService
{
    protected $baremeModel;

    public function __construct()
    {
        $this->baremeModel = new BaremeModel();
    }
    public function getAll()
    {
        return $this->baremeModel
            ->orderBy('type_operation, montant_min', 'ASC')
            ->findAll();
    }
    public function getById($id)
    {
        return $this->baremeModel->find($id);
    }
    public function ajouterBareme($data)
    {
        return $this->baremeModel->save([
            'type_operation' => $data['type_operation'],
            'montant_min'    => $data['montant_min'],
            'montant_max'    => $data['montant_max'],
            'frais'          => $data['frais']
        ]);
    }
    public function supprimerBareme($id)
    {
        return $this->baremeModel->delete($id);
    }
    public function getBareme($typeOperation, $montant)
    {
        return $this->baremeModel
            ->where('type_operation', $typeOperation)
            ->where('montant_min <=', $montant)
            ->where('montant_max >=', $montant)
            ->first();
    }
}