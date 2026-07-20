<?php

namespace App\Controllers;

use App\Models\PrefixeModel;
use App\Models\BaremeModel;
use App\Models\ClientModel;
use App\Models\TransactionModel;

class OperateurController extends BaseController
{
    protected $prefixeModel;
    protected $baremeModel;
    protected $clientModel;
    protected $transactionModel;

    public function __construct()
    {
        $this->prefixeModel     = new PrefixeModel();
        $this->baremeModel      = new BaremeModel();
        $this->clientModel       = new ClientModel();
        $this->transactionModel = new TransactionModel();
    }

    // Tableau de bord de l'Opérateur
    public function index()
    {
        $data = [
            'prefixes' => $this->prefixeModel->findAll(),
            'baremes'  => $this->baremeModel->orderBy('type_operation, montant_min', 'ASC')->findAll(),
            'clients'  => $this->clientModel->findAll(),
            // Calcul du gain total via les frais collectés (retrait & transfert)
            'total_gains' => $this->transactionModel->selectSum('frais')->first()['frais'] ?? 0
        ];

        return view('operateur/index', $data);
    }

    // Ajouter un nouveau préfixe
    public function ajouterPrefixe()
    {
        $prefixe = trim($this->request->getPost('prefixe'));

        if (!empty($prefixe)) {
            $this->prefixeModel->save(['prefixe' => $prefixe]);
        }

        return redirect()->to('/operateur');
    }

    // Supprimer un préfixe
    public function supprimerPrefixe($id)
    {
        $this->prefixeModel->delete($id);
        return redirect()->to('/operateur');
    }

    // Ajouter / Modifier une tranche de barème
    public function ajouterBareme()
    {
        $data = [
            'type_operation' => $this->request->getPost('type_operation'),
            'montant_min'    => $this->request->getPost('montant_min'),
            'montant_max'    => $this->request->getPost('montant_max'),
            'frais'          => $this->request->getPost('frais')
        ];

        $this->baremeModel->save($data);
        return redirect()->to('/operateur');
    }

    // Supprimer une tranche de barème
    public function supprimerBareme($id)
    {
        $this->baremeModel->delete($id);
        return redirect()->to('/operateur');
    }
}