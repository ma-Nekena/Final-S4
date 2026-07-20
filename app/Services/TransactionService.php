<?php

namespace App\Services;

use App\Models\ClientModel;
use App\Models\TransactionModel;
use App\Models\AutreOperateurModel;

class TransactionService
{
    protected $clientModel;
    protected $transactionModel;
    protected $fraisService;
    protected $autreOperateurModel;

    public function __construct()
    {
        $this->clientModel         = new ClientModel();
        $this->transactionModel    = new TransactionModel();
        $this->fraisService        = new FraisService();
        $this->autreOperateurModel = new AutreOperateurModel();
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
            'type_transaction'       => 'depot',
            'telephone_destinataire' => $phone,
            'montant'                => $montant,
            'frais'                  => 0
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
            'type_transaction'     => 'retrait',
            'telephone_expediteur' => $phone,
            'montant'              => $montant,
            'frais'                => $frais
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
            'type_transaction'       => 'transfert',
            'telephone_expediteur'   => $expediteurPhone,
            'telephone_destinataire' => $destinatairePhone,
            'montant'                => $montant,
            'frais'                  => $frais
        ]);

        return [
            'success' => true,
            'message' => "Transfert de {$montant} Ar envoyé à {$destinatairePhone} (Frais : {$frais} Ar)."
        ];
    }

    public function transfertMultiple($expediteurPhone, $destinatairesInput, $montantTotal, $inclureFraisRetrait = false)
    {
        $montantTotal = (float) $montantTotal;

        $destinataires = array_map('trim', explode(',', $destinatairesInput));
        $destinataires = array_filter($destinataires);

        $nbDestinataires = count($destinataires);

        if ($montantTotal <= 0 || $nbDestinataires === 0) {
            return [
                'success' => false,
                'message' => 'Destinataire(s) ou montant invalide.'
            ];
        }

        $montantParPersonne = $montantTotal / $nbDestinataires;

        $expediteur = $this->clientModel
            ->where('numero_telephone', $expediteurPhone)
            ->first();

        if (!$expediteur) {
            return [
                'success' => false,
                'message' => 'Expéditeur introuvable.'
            ];
        }

        $totalAController = 0;
        $detailsTransactions = [];

    foreach ($destinataires as $destinatairePhone) {

        if ($expediteurPhone == $destinatairePhone) {
            return [
                'success' => false,
                'message' => "Vous ne pouvez pas effectuer un transfert vers votre propre numéro."
            ];
        }
        $fraisTransfert = $this->fraisService->getFrais('transfert', $montantParPersonne);

        $fraisRetraitInclus = 0;
        if ($inclureFraisRetrait) {
            $fraisRetraitInclus = $this->fraisService->getFrais('retrait', $montantParPersonne);
        }

        $autreOp = $this->detecterAutreOperateur($destinatairePhone);
        $commissionAutreOp = 0;
        $autreOpId = null;

        if ($autreOp) {
            $autreOpId = $autreOp['id'];
            $commissionAutreOp = ($montantParPersonne * $autreOp['commission_pourcentage']) / 100;
        } else {
            $destinataireClient = $this->clientModel->where('numero_telephone', $destinatairePhone)->first();
            if (!$destinataireClient) {
                return [
                    'success' => false,
                    'message' => "Le numéro {$destinatairePhone} n'est associé à aucun opérateur."
                ];
            }
        }
        $fraisTotauxTransaction = $fraisTransfert + $fraisRetraitInclus;
        
        $montantCreditDestinataire = $montantParPersonne + $fraisRetraitInclus;

        $montantDebiteTransaction = $montantParPersonne + $fraisTotauxTransaction + $commissionAutreOp;

        $totalAController += $montantDebiteTransaction;

        $detailsTransactions[] = [
            'destinataire'         => $destinatairePhone,
            'montant_net'          => $montantParPersonne,
            'frais_transfert'      => $fraisTotauxTransaction,
            'commission_autre_op'  => $commissionAutreOp,
            'autre_op_id'          => $autreOpId,
            'montant_recu_client'  => $montantCreditDestinataire 
        ];
    }

        if ($expediteur['solde'] < $totalAController) {
            return [
                'success' => false,
                'message' => "Solde insuffisant ! Montant total requis : " . number_format($totalAController, 2, ',', ' ') . " Ar."
            ];
        }

        foreach ($detailsTransactions as $dt) {
            $destinataireClient = $this->clientModel->where('numero_telephone', $dt['destinataire'])->first();
            if ($destinataireClient) {
                $this->clientModel->update($destinataireClient['id'], [
                    'solde' => $destinataireClient['solde'] + $dt['montant_recu_client']
                ]);
            }

            $this->transactionModel->insert([
                'type_transaction'           => 'transfert',
                'telephone_expediteur'       => $expediteurPhone,
                'telephone_destinataire'     => $dt['destinataire'],
                'montant'                    => $dt['montant_net'],
                'frais'                      => $dt['frais_transfert'],
                'commission_autre_operateur' => $dt['commission_autre_op'],
                'autre_operateur_id'         => $dt['autre_op_id']
            ]);
        }

        $this->clientModel->update($expediteur['id'], [
            'solde' => $expediteur['solde'] - $totalAController
        ]);

        return [
            'success' => true,
            'message' => "Transfert multiple envoyé avec succès à {$nbDestinataires} destinataire(s) !"
        ];
    }

    private function detecterAutreOperateur($phone)
    {
        $autresOperateurs = $this->autreOperateurModel->findAll();
        foreach ($autresOperateurs as $op) {
            if (strpos($phone, $op['prefixe']) === 0) {
                return $op;
            }
        }
        return null;
    }

    public function getGainsInternes()
    {
        return $this->transactionModel
            ->selectSum('frais')
            ->first()['frais'] ?? 0;
    }

    public function getGainsCommissions()
    {
        return $this->transactionModel
            ->selectSum('commission_autre_operateur')
            ->first()['commission_autre_operateur'] ?? 0;
    }

    public function getTotalGains()
    {
        return $this->getGainsInternes() + $this->getGainsCommissions();
    }

    public function getMontantsAEnvoyerParOperateur()
    {
        $operateurs = $this->autreOperateurModel->findAll();

        foreach ($operateurs as &$op) {
            $total = $this->transactionModel
                ->where('autre_operateur_id', $op['id'])
                ->selectSum('montant')
                ->first()['montant'] ?? 0;

            $op['montant_a_envoyer'] = $total;
        }

        return $operateurs;
    }
}