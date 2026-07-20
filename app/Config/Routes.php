<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

// Routes Opérateur
$routes->get('/operateur', 'OperateurController::index');
$routes->post('/operateur/prefixe/ajouter', 'OperateurController::ajouterPrefixe');
$routes->get('/operateur/prefixe/supprimer/(:num)', 'OperateurController::supprimerPrefixe/$1');

$routes->post('/operateur/bareme/ajouter', 'OperateurController::ajouterBareme');
$routes->get('/operateur/bareme/supprimer/(:num)', 'OperateurController::supprimerBareme/$1');
