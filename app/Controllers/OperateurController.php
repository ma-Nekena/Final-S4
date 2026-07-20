<?php

namespace App\Controllers;

use App\Services\PrefixeService;
use App\Services\BaremeService;
use App\Services\TransactionService;
use App\Services\ClientService;
use App\Models\TransactionModel;

class OperateurController extends BaseController
{
    protected $prefixeService;
    protected $baremeService;
    protected $transactionModel;
    protected $transactionService;
    protected $clientService;

    public function __construct()
    {
        $this->prefixeService = new PrefixeService();
        $this->baremeService = new BaremeService();
        $this->transactionService = new TransactionService();
        $this->clientService = new ClientService();
    }

    public function index()
    {
        $data = [
            'prefixes'    => $this->prefixeService->getAll(),
            'baremes'     => $this->baremeService->getAll(),
            'clients'     => $this->clientService->getAll(),
            'total_gains' => $this->transactionService->getTotalGains()
        ];

        return view('operateur/index', $data);
    }

    public function ajouterPrefixe()
    {
        $this->prefixeService->ajouterPrefixe(
            $this->request->getPost('prefixe')
        );

        return redirect()->to('/operateur');
    }

    public function supprimerPrefixe($id)
    {
        $this->prefixeService->supprimerPrefixe($id);

        return redirect()->to('/operateur');
    }

    public function ajouterBareme()
    {
        $data = [
            'type_operation' => $this->request->getPost('type_operation'),
            'montant_min'    => $this->request->getPost('montant_min'),
            'montant_max'    => $this->request->getPost('montant_max'),
            'frais'          => $this->request->getPost('frais')
        ];

        $this->baremeService->ajouterBareme($data);

        return redirect()->to('/operateur');
    }

    public function supprimerBareme($id)
    {
        $this->baremeService->supprimerBareme($id);

        return redirect()->to('/operateur');
    }
}