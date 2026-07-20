<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Authentification & Dashboard Client
$routes->get('/', 'ClientController::loginView');
$routes->get('/client/login', 'ClientController::loginView');
$routes->post('/client/login', 'ClientController::login');
$routes->get('/client/logout', 'ClientController::logout');
$routes->get('/client/dashboard', 'ClientController::dashboard');

// Transactions Client
$routes->post('/client/depot', 'ClientController::depot');
$routes->post('/client/retrait', 'ClientController::retrait');
$routes->post('/client/transfert', 'ClientController::transfert');

// Transfert Multiple (V2)
$routes->get('/client/transfert-multiple', 'ClientController::transfertMultiple');
$routes->post('/client/transfert-multiple/envoyer', 'ClientController::envoyerTransfertMultiple');

// Backoffice Opérateur / Admin
$routes->get('/operateur', 'OperateurController::index');

// Gestion des Préfixes
$routes->get('/operateur/prefixes', 'OperateurController::prefixes');
$routes->post('/operateur/prefixe/ajouter', 'OperateurController::ajouterPrefixe');
$routes->get('/operateur/prefixe/supprimer/(:num)', 'OperateurController::supprimerPrefixe/$1');

// Gestion des Barèmes de frais
$routes->get('/operateur/baremes', 'OperateurController::baremes');
$routes->post('/operateur/bareme/ajouter', 'OperateurController::ajouterBareme');
$routes->get('/operateur/bareme/supprimer/(:num)', 'OperateurController::supprimerBareme/$1');

// Liste des Clients
$routes->get('/operateur/clients', 'OperateurController::clients');

// Gestion des Autres Opérateurs (V2)
$routes->get('/operateur/autres-operateurs', 'OperateurController::autresOperateurs');
$routes->post('/operateur/autres-operateurs/ajouter', 'OperateurController::ajouterAutreOperateur');
$routes->get('/operateur/autres-operateurs/supprimer/(:num)', 'OperateurController::supprimerAutreOperateur/$1');