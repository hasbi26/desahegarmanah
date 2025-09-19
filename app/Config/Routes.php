<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::index');
$routes->post('/auth/login', 'AuthController::auth');
$routes->get('/auth/logout', 'AuthController::logout');


// Protected routes
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/dashboard', 'DashboardController::index');
    $routes->get('/settings', 'DashboardController::settings');
    $routes->get('/keluarga', 'DashboardController::keluarga');
    $routes->get('/form-individu', 'DashboardController::formIndividu');

    // Penduduk
    $routes->get('penduduk', 'PendudukController::index');
    $routes->get('penduduk/create', 'PendudukController::create');
    $routes->post('penduduk', 'PendudukController::store');
    $routes->get('penduduk/(:num)', 'PendudukController::show/$1');
    $routes->get('penduduk/(:num)/edit', 'PendudukController::edit/$1');
    $routes->post('penduduk/(:num)/update', 'PendudukController::update/$1');
    $routes->post('penduduk/(:num)/delete', 'PendudukController::delete/$1');
    $routes->get('penduduk/export/pdf', 'PendudukController::exportPdf');
    $routes->get('penduduk/export/excel', 'PendudukController::exportExcel');

    // Musiman
    $routes->get('musiman', 'MusimanController::index');
    $routes->get('musiman/create', 'MusimanController::create');
    $routes->post('musiman', 'MusimanController::store');
    $routes->get('musiman/(:num)/edit', 'MusimanController::edit/$1');
    $routes->post('musiman/(:num)/update', 'MusimanController::update/$1');
    $routes->post('musiman/(:num)/delete', 'MusimanController::delete/$1');
    $routes->get('musiman/export/pdf', 'MusimanController::exportPdf');
    $routes->get('musiman/export/excel', 'MusimanController::exportExcel');

    // Users (Admin only)
    $routes->get('users', 'UsersController::index');
    $routes->get('users/create', 'UsersController::create');
    $routes->post('users', 'UsersController::store');
    $routes->get('users/(:num)/edit', 'UsersController::edit/$1');
    $routes->post('users/(:num)/update', 'UsersController::update/$1');
    $routes->post('users/(:num)/delete', 'UsersController::delete/$1');

    // Enumerator (tetap)
    // $routes->post('enumerator/store', 'EnumeratorController::store');
    // $routes->get('enumerator/read', 'EnumeratorController::read');
    // $routes->get('enumerator/(:num)', 'EnumeratorController::getById/$1');
    // $routes->post('enumerator/update/(:num)', 'EnumeratorController::update/$1');
    // $routes->delete('enumerator/(:num)', 'EnumeratorController::delete/$1');
    // $routes->get('enumerator/options', 'EnumeratorController::getEnumerators');

    $routes->post('kuesioner/getData', 'KuesionerController::getData');
    $routes->get('kuesioner/create', 'KuesionerController::create');

    $routes->post('survey/simpan', 'SurveyController::simpanDataSurvey');
});

// REST API routes
$routes->group('api', static function ($routes) {
    // Akses Kesehatan CRUD
    $routes->get('akses-kesehatan', 'Api\AksesKesehatanController::index');
    $routes->get('akses-kesehatan/(:num)', 'Api\AksesKesehatanController::show/$1');
    $routes->post('akses-kesehatan', 'Api\AksesKesehatanController::create');
    $routes->put('akses-kesehatan/(:num)', 'Api\AksesKesehatanController::update/$1');
    $routes->patch('akses-kesehatan/(:num)', 'Api\AksesKesehatanController::update/$1');
    $routes->delete('akses-kesehatan/(:num)', 'Api\AksesKesehatanController::delete/$1');

    // Penduduk Tetap (penduduk_new + penduduk_tinggal)
    $routes->get('penduduk-tetap', 'Api\PendudukTetapController::index');
    $routes->get('penduduk-tetap/search', 'Api\PendudukTetapController::search');
    $routes->get('penduduk-tetap/(:num)', 'Api\PendudukTetapController::show/$1');
    $routes->post('penduduk-tetap', 'Api\PendudukTetapController::create');
    $routes->put('penduduk-tetap/(:num)', 'Api\PendudukTetapController::update/$1');
    $routes->patch('penduduk-tetap/(:num)', 'Api\PendudukTetapController::update/$1');
    $routes->delete('penduduk-tetap/(:num)', 'Api\PendudukTetapController::delete/$1');

    // Penduduk Musiman
    $routes->get('penduduk-musiman', 'Api\PendudukMusimanController::index');
    $routes->get('penduduk-musiman/(:num)', 'Api\PendudukMusimanController::show/$1');
    $routes->post('penduduk-musiman', 'Api\PendudukMusimanController::create');
    // Update fleksibel: bisa tanpa ID di URL
    $routes->put('penduduk-musiman/(:num)', 'Api\PendudukMusimanController::update/$1');
    $routes->patch('penduduk-musiman/(:num)', 'Api\PendudukMusimanController::update/$1');
    $routes->post('penduduk-musiman/save', 'Api\PendudukMusimanController::save');
    $routes->put('penduduk-musiman', 'Api\PendudukMusimanController::update');
    $routes->patch('penduduk-musiman', 'Api\PendudukMusimanController::update');
    $routes->delete('penduduk-musiman/(:num)', 'Api\PendudukMusimanController::delete/$1');

    // Dashboard data
    $routes->get('dashboard/summary', 'Api\DashboardController::summary');
    $routes->get('dashboard/distribusi-rt', 'Api\DashboardController::distribusiPerRT');
    $routes->get('dashboard/komposisi-jenis-kelamin', 'Api\DashboardController::komposisiJenisKelamin');
});
