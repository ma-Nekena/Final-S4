<?php

namespace App\Services;

use App\Models\ClientModel;

class ClientService
{
    protected $clientModel;
    protected $prefixeService;

    public function __construct()
    {
        $this->clientModel = new ClientModel();
        $this->prefixeService = new PrefixeService();
    }
    public function getAll()
    {
        return $this->clientModel->findAll();
    }
    public function login($phone)
    {
        $phone = trim($phone ?? '');

        if ($phone == '') {
            return [
                'success' => false,
                'message' => 'Veuillez entrer un numéro de téléphone.'
            ];
        }

        if (!$this->prefixeService->verifierPrefixe($phone)) {
            return [
                'success' => false,
                'message' => 'Numéro invalide : préfixe non autorisé par l\'opérateur.'
            ];
        }

        $client = $this->clientModel
            ->where('numero_telephone', $phone)
            ->first();

        if (!$client) {

            $id = $this->clientModel->insert([
                'numero_telephone' => $phone,
                'solde' => 0
            ]);

            $client = $this->clientModel->find($id);
        }

        return [
            'success' => true,
            'client' => $client
        ];
    }
    public function getClient($phone)
    {
        return $this->clientModel
            ->where('numero_telephone', $phone)
            ->first();
    }
    public function getClientById($id)
    {
        return $this->clientModel->find($id);
    }
    public function updateSolde($id, $solde)
    {
        return $this->clientModel->update($id, [
            'solde' => $solde
        ]);
    }
    public function clientExiste($phone)
    {
        return $this->clientModel
            ->where('numero_telephone', $phone)
            ->first();
    }
}