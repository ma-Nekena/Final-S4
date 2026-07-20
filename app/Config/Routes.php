<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'ClientController::loginView');

$routes->get('/client/login', 'ClientController::loginView');
$routes->post('/client/login', 'ClientController::login');
$routes->get('/client/logout', 'ClientController::logout');

$routes->get('/client/dashboard', 'ClientController::dashboard');

$routes->post('/client/depot', 'ClientController::depot');
$routes->post('/client/retrait', 'ClientController::retrait');
$routes->post('/client/transfert', 'ClientController::transfert');


// $routes->get('/operateur', 'OperateurController::index');

// $routes->post('/operateur/prefixe/ajouter', 'OperateurController::ajouterPrefixe');
// $routes->get('/operateur/prefixe/supprimer/(:num)', 'OperateurController::supprimerPrefixe/$1');

// $routes->post('/operateur/bareme/ajouter', 'OperateurController::ajouterBareme');
// $routes->get('/operateur/bareme/supprimer/(:num)', 'OperateurController::supprimerBareme/$1');


// Dashboard opérateur
$routes->get('/operateur', 'OperateurController::index');
$routes->get('/operateur/prefixes', 'OperateurController::prefixes');
$routes->post('/operateur/prefixe/ajouter', 'OperateurController::ajouterPrefixe');
$routes->get('/operateur/prefixe/supprimer/(:num)', 'OperateurController::supprimerPrefixe/$1');
$routes->get('/operateur/baremes', 'OperateurController::baremes');
$routes->post('/operateur/bareme/ajouter', 'OperateurController::ajouterBareme');
$routes->get('/operateur/bareme/supprimer/(:num)', 'OperateurController::supprimerBareme/$1');
$routes->get('/operateur/clients', 'OperateurController::clients');