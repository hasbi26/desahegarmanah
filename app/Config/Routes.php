<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(false);
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
    // Terima POST (lama) dan juga PUT/PATCH (method spoofing) untuk update
    $routes->post('penduduk/(:num)/update', 'PendudukController::update/$1');
    $routes->put('penduduk/(:num)/update', 'PendudukController::update/$1');
    $routes->patch('penduduk/(:num)/update', 'PendudukController::update/$1');
    $routes->post('penduduk/(:num)/delete', 'PendudukController::delete/$1');
    $routes->get('penduduk/export/pdf', 'PendudukController::exportPdf');
    $routes->get('penduduk/export/excel', 'PendudukController::exportExcel');
    $routes->get('penduduk/search', 'PendudukController::search');
    $routes->get('penduduk/list-data', 'PendudukController::ajaxList');

    // Musiman
    $routes->get('musiman', 'MusimanController::index');
    $routes->get('musiman/create', 'MusimanController::create');
    $routes->post('musiman', 'MusimanController::store');
    $routes->get('musiman/(:num)/edit', 'MusimanController::edit/$1');
    $routes->post('musiman/(:num)/update', 'MusimanController::update/$1');
    $routes->post('musiman/(:num)/delete', 'MusimanController::delete/$1');
    $routes->get('musiman/export/pdf', 'MusimanController::exportPdf');
    $routes->get('musiman/export/excel', 'MusimanController::exportExcel');
    $routes->get('musiman/(:num)', 'MusimanController::show/$1');
    $routes->get('musiman/(:num)/detail', 'MusimanController::detail/$1');
    $routes->get('musiman/ajaxList', 'MusimanController::ajaxList');

    // Users (Admin only)
    $routes->get('users', 'UsersController::index');
    $routes->get('users/create', 'UsersController::create');
    $routes->post('users', 'UsersController::store');
    $routes->get('users/(:num)/edit', 'UsersController::edit/$1');
    $routes->post('users/(:num)/update', 'UsersController::update/$1');
    $routes->post('users/(:num)/delete', 'UsersController::delete/$1');
    $routes->get('users/form', 'UsersController::create');

    $routes->post('kuesioner/getData', 'KuesionerController::getData');
    $routes->get('kuesioner/create', 'KuesionerController::create');

    $routes->post('survey/simpan', 'SurveyController::simpanDataSurvey');

    // API routes (JSON)
    $routes->group('api', ['filter' => 'auth'], static function ($routes) {
        // Penduduk
        $routes->get('penduduk', 'Api\Penduduk::index');
        $routes->get('penduduk/(:num)', 'Api\Penduduk::show/$1');
        $routes->post('penduduk', 'Api\Penduduk::create');
        $routes->put('penduduk/(:num)', 'Api\Penduduk::update/$1');
        $routes->delete('penduduk/(:num)', 'Api\Penduduk::delete/$1');

        // Musiman
        $routes->get('musiman', 'Api\Musiman::index');
        $routes->get('musiman/(:num)', 'Api\Musiman::show/$1');
        $routes->post('musiman', 'Api\Musiman::create');
        $routes->put('musiman/(:num)', 'Api\Musiman::update/$1');
        $routes->delete('musiman/(:num)', 'Api\Musiman::delete/$1');

        // Enumerator
        $routes->get('enumerator', 'Api\Enumerator::index');
        $routes->get('enumerator/(:num)', 'Api\Enumerator::show/$1');
        $routes->post('enumerator', 'Api\Enumerator::create');
        $routes->put('enumerator/(:num)', 'Api\Enumerator::update/$1');
        $routes->delete('enumerator/(:num)', 'Api\Enumerator::delete/$1');
        $routes->get('enumerator/options', 'Api\Enumerator::options');
    });
});

// REST API routes
$routes->group('api', static function ($routes) {

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
