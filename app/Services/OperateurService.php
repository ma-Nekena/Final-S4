<?php

namespace App\Services;

use App\Models\PrefixeModel;
use App\Models\BaremeModel;
use App\Models\ClientModel;
use App\Models\TransactionModel;

class OperateurService
{
    protected $prefixeModel;
    protected $baremeModel;
    protected $clientModel;
    protected $transactionModel;

    public function __construct()
    {
        $this->prefixeModel = new PrefixeModel();
        $this->baremeModel = new BaremeModel();
        $this->clientModel = new ClientModel();
        $this->transactionModel = new TransactionModel();
    }

    public function getDashboardData(){
        return[
            'prefixes' => $this->prefixeModel->findAll(),
            'baremes' => $this->baremeModel
                                    ->orderBy('type_operation, montant_min', 'ASC')
                                    ->findAll(),
            'clients' => $this->clientModel->findAll(),
            'total_gains' => $this->transactionModel
                                    ->selectSum('frais')
                                    ->first()['frais'] ?? 0
        ];
    }

    public function ajouterPrefixe($prefixe){
        $prefixe = trim($prefixe);

        if (!empty($prefixe)){
            $this->prefixeModel->save([
                'prefixe' => $prefixe
            ]);
        }
    }

    public function supprimerPrefixe($id){
        $this->prefixeModel->delete($id);
    }

    public function ajouterBareme($data){
        $this->baremeModel->save($data);
    }

    public function supprimerBareme($id){
        $this->baremeModel->delete($id);
    }
}