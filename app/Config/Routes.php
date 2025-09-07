<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::index');
$routes->post('/auth/login', 'AuthController::auth');
$routes->get('/auth/logout', 'AuthController::logout');

$routes->get('/dashboard', 'DashboardController::index');
$routes->get('/settings', 'DashboardController::settings');
$routes->get('/keluarga', 'DashboardController::keluarga');
$routes->get('/form-individu', 'DashboardController::formIndividu');

$routes->post('kuesioner/getData', 'KuesionerController::getData');
$routes->get('kuesioner/create', 'KuesionerController::create');
$routes->post('enumerator/store', 'EnumeratorController::store');
$routes->get('enumerator/read', 'EnumeratorController::read');
$routes->get('enumerator/(:num)', 'EnumeratorController::getById/$1');
$routes->post('enumerator/update/(:num)', 'EnumeratorController::update/$1');
$routes->delete('enumerator/(:num)', 'EnumeratorController::delete/$1');
$routes->get('enumerator/options', 'EnumeratorController::getEnumerators');


$routes->post('survey/simpan', 'SurveyController::simpanDataSurvey');