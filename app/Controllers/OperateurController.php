<?php
namespace App\Controllers;

use App\Services\PrefixeService;
use App\Services\BaremeService;
use App\Services\TransactionService;
use App\Services\ClientService;
use App\Services\AutreOperateurService;
use App\Services\PromotionService;

class OperateurController extends BaseController
{
    protected $prefixeService;
    protected $baremeService;
    protected $transactionService;
    protected $clientService;
    protected $autreOperateurService;
    protected $promotionService;

    public function __construct()
    {
        $this->prefixeService = new PrefixeService();
        $this->baremeService = new BaremeService();
        $this->transactionService = new TransactionService();
        $this->clientService = new ClientService();
        $this->autreOperateurService = new AutreOperateurService();
        $this->promotionService = new PromotionService();
    }

    public function index()
    {
        $data = [
            'clients'           => $this->clientService->getAll(),
            'gains_internes'    => $this->transactionService->getGainsInternes(),
            'gains_commissions' => $this->transactionService->getGainsCommissions(),
            'total_gains'       => $this->transactionService->getTotalGains(),
            'operateurs_avec_montants' => $this->transactionService->getMontantsAEnvoyerParOperateur()
        ];
        return view('operateur/dashboard', $data);
    }

    public function prefixes()
    {
        $data = [
            'prefixes' => $this->prefixeService->getAll()
        ];
        return view('operateur/prefixes', $data);
    }

    public function ajouterPrefixe()
    {
        $this->prefixeService->ajouterPrefixe(
            $this->request->getPost('prefixe')
        );
        return redirect()->to('/operateur/prefixes');
    }

    public function supprimerPrefixe($id)
    {
        $this->prefixeService->supprimerPrefixe($id);
        return redirect()->to('/operateur/prefixes');
    }

    public function baremes()
    {
        $data = [
            'baremes' => $this->baremeService->getAll()
        ];
        return view('operateur/baremes', $data);
    }

    public function ajouterBareme()
    {
        $data = [
            'type_operation' => $this->request->getPost('type_operation'),
            'montant_min'     => $this->request->getPost('montant_min'),
            'montant_max'     => $this->request->getPost('montant_max'),
            'frais'           => $this->request->getPost('frais')
        ];
        $this->baremeService->ajouterBareme($data);
        return redirect()->to('/operateur/baremes');
    }

    public function supprimerBareme($id)
    {
        $this->baremeService->supprimerBareme($id);
        return redirect()->to('/operateur/baremes');
    }

    public function clients()
    {
        $data = [
            'clients' => $this->clientService->getAll()
        ];
        return view('operateur/clients', $data);
    }

    public function autresOperateurs()
    {
        $data = [
            'autres_operateurs'      => $this->autreOperateurService->getAll(),
            'operateurs_avec_montants' => $this->transactionService->getMontantsAEnvoyerParOperateur()
        ];
        return view('operateur/autres-operateurs', $data);
    }

    public function ajouterAutreOperateur()
    {
        $data = [
            'nom_operateur'          => $this->request->getPost('nom_operateur'),
            'prefixe'                => $this->request->getPost('prefixe'),
            'commission_pourcentage' => $this->request->getPost('commission_pourcentage')
        ];

        $this->autreOperateurService->ajouter($data);
        return redirect()->to('/operateur/autres-operateurs');
    }

    public function supprimerAutreOperateur($id)
    {
        $this->autreOperateurService->supprimer($id);
        return redirect()->to('/operateur/autres-operateurs');
    }

        public function promotions()
    {
        $data = [
            'promotions' => $this->promotionService->getAll()
        ];
        return view('operateur/promotions', $data);
    }

    public function ajouterPromotion()
    {
        $this->promotionService->ajouterPromotion(
            $this->request->getPost('promotion')
        );
        return redirect()->to('/operateur/promotions');
    }
}