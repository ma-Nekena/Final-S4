<?php
namespace App\Controllers;

use App\Services\PrefixeService;
use App\Services\BaremeService;
use App\Services\TransactionService;
use App\Services\ClientService;
class OperateurController extends BaseController
{
    protected $prefixeService;
    protected $baremeService;
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
            'clients' => $this->clientService->getAll(),
            'total_gains' => $this->transactionService->getTotalGains()
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
            'montant_min' => $this->request->getPost('montant_min'),
            'montant_max' => $this->request->getPost('montant_max'),
            'frais' => $this->request->getPost('frais')
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
}