<?php

namespace App\Controllers;

use App\Services\ClientService;
use App\Services\TransactionService;

class ClientController extends BaseController
{
    protected $clientService;
    protected $transactionService;

    public function __construct()
    {
        $this->clientService = new ClientService();
        $this->transactionService = new TransactionService();
    }
    public function loginView()
    {
        return view('client/login');
    }
    public function login()
    {
        $result = $this->clientService->login(
            $this->request->getPost('phone_number')
        );

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        session()->set(
            'client_phone',
            $result['client']['numero_telephone']
        );

        return redirect()->to('/client/dashboard');
    }
    public function logout()
    {
        session()->remove('client_phone');

        return redirect()->to('/client/login');
    }
    public function dashboard()
    {
        $phone = session()->get('client_phone');

        if (!$phone) {
            return redirect()->to('/client/login');
        }

        $data = $this->transactionService->dashboard($phone);

        return view('client/dashboard', $data);
    }

    public function depot()
    {
        $result = $this->transactionService->depot(
            session()->get('client_phone'),
            $this->request->getPost('montant')
        );

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return redirect()->back()->with('success', $result['message']);
    }

    public function retrait()
    {
        $result = $this->transactionService->retrait(
            session()->get('client_phone'),
            $this->request->getPost('montant')
        );

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return redirect()->back()->with('success', $result['message']);
    }

    public function transfert()
    {
        $result = $this->transactionService->transfert(
            session()->get('client_phone'),
            $this->request->getPost('telephone_destinataire'),
            $this->request->getPost('montant')
        );

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }

        return redirect()->back()->with('success', $result['message']);
    }
    public function transfertMultiple()
    {
        return view('client/transfert-multiple');
    }

    public function envoyerTransfertMultiple()
    {
        $expediteur = session()->get('client_phone');
        $destinatairesArray = $this->request->getPost('destinataires');
        
        $destinataires = is_array($destinatairesArray) ? implode(',', $destinatairesArray) : '';
        
        $montantTotal = $this->request->getPost('montant_total');
        $inclureFrais = (bool) $this->request->getPost('inclure_frais_retrait');

        $res = $this->transactionService->transfertMultiple($expediteur, $destinataires, $montantTotal, $inclureFrais);

        if ($res['success']) {
            return redirect()->to('/client/dashboard')->with('success', $res['message']);
        } else {
            return redirect()->back()->with('error', $res['message']);
        }
    }
}