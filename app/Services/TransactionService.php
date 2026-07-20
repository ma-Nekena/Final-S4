<?php

namespace App\Services;

use App\Models\ClientModel;
use App\Models\TransactionModel;

class TransactionService
{
    protected $clientModel;
    protected $transactionModel;
    protected $fraisService;

    public function __construct()
    {
        $this->clientModel = new ClientModel();
        $this->transactionModel = new TransactionModel();
        $this->fraisService = new FraisService();
    }
    public function dashboard($phone)
    {
        $client = $this->clientModel
            ->where('numero_telephone', $phone)
            ->first();

        $history = $this->historique($phone);

        return [
            'client'  => $client,
            'history' => $history
        ];
    }
    public function historique($phone)
    {
        return $this->transactionModel
            ->groupStart()
                ->where('telephone_expediteur', $phone)
                ->orWhere('telephone_destinataire', $phone)
            ->groupEnd()
            ->orderBy('id', 'DESC')
            ->findAll();
    }
    public function depot($phone, $montant)
    {
        $montant = (float) $montant;

        if ($montant <= 0) {
            return [
                'success' => false,
                'message' => 'Montant invalide.'
            ];
        }

        $client = $this->clientModel
            ->where('numero_telephone', $phone)
            ->first();

        if (!$client) {
            return [
                'success' => false,
                'message' => 'Client introuvable.'
            ];
        }

        $this->clientModel->update($client['id'], [
            'solde' => $client['solde'] + $montant
        ]);

        $this->transactionModel->insert([
            'type_transaction'        => 'depot',
            'telephone_destinataire'  => $phone,
            'montant'                 => $montant,
            'frais'                   => 0
        ]);

        return [
            'success' => true,
            'message' => 'Dépôt effectué avec succès !'
        ];
    }
    public function retrait($phone, $montant)
    {
        $montant = (float) $montant;

        if ($montant <= 0) {
            return [
                'success' => false,
                'message' => 'Montant invalide.'
            ];
        }

        $frais = $this->fraisService->getFrais('retrait', $montant);
        $totalADebiter = $montant + $frais;

        $client = $this->clientModel
            ->where('numero_telephone', $phone)
            ->first();

        if (!$client) {
            return [
                'success' => false,
                'message' => 'Client introuvable.'
            ];
        }

        if ($client['solde'] < $totalADebiter) {
            return [
                'success' => false,
                'message' => "Solde insuffisant ! Montant : {$montant} Ar + Frais : {$frais} Ar = Total requis : {$totalADebiter} Ar."
            ];
        }

        $this->clientModel->update($client['id'], [
            'solde' => $client['solde'] - $totalADebiter
        ]);
        $this->transactionModel->insert([
            'type_transaction'      => 'retrait',
            'telephone_expediteur'  => $phone,
            'montant'               => $montant,
            'frais'                 => $frais
        ]);

        return [
            'success' => true,
            'message' => "Retrait de {$montant} Ar effectué (Frais : {$frais} Ar)."
        ];
    }
    public function transfert($expediteurPhone, $destinatairePhone, $montant)
    {
        $destinatairePhone = trim($destinatairePhone);
        $montant = (float) $montant;

        if ($montant <= 0 || $expediteurPhone == $destinatairePhone) {
            return [
                'success' => false,
                'message' => 'Numéro destinataire ou montant invalide.'
            ];
        }

        $destinataire = $this->clientModel
            ->where('numero_telephone', $destinatairePhone)
            ->first();

        if (!$destinataire) {
            return [
                'success' => false,
                'message' => 'Numéro du destinataire introuvable.'
            ];
        }

        $expediteur = $this->clientModel
            ->where('numero_telephone', $expediteurPhone)
            ->first();

        if (!$expediteur) {
            return [
                'success' => false,
                'message' => 'Expéditeur introuvable.'
            ];
        }

        $frais = $this->fraisService->getFrais('transfert', $montant);
        $totalADebiter = $montant + $frais;

        if ($expediteur['solde'] < $totalADebiter) {
            return [
                'success' => false,
                'message' => "Solde insuffisant ! Montant : {$montant} Ar + Frais : {$frais} Ar."
            ];
        }

        $this->clientModel->update($expediteur['id'], [
            'solde' => $expediteur['solde'] - $totalADebiter
        ]);

        $this->clientModel->update($destinataire['id'], [
            'solde' => $destinataire['solde'] + $montant
        ]);

        $this->transactionModel->insert([
            'type_transaction'        => 'transfert',
            'telephone_expediteur'    => $expediteurPhone,
            'telephone_destinataire'  => $destinatairePhone,
            'montant'                 => $montant,
            'frais'                   => $frais
        ]);

        return [
            'success' => true,
            'message' => "Transfert de {$montant} Ar envoyé à {$destinatairePhone} (Frais : {$frais} Ar)."
        ];
    }
    public function getTotalGains()
    {
        return $this->transactionModel
            ->selectSum('frais')
            ->first()['frais'] ?? 0;
    }
}