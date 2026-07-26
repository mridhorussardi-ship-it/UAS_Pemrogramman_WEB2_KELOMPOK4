<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Web\Aspirasi::index');

// ============================================
// AUTH ROUTES
// ============================================
$routes->get('login', 'Web\Auth::login');
$routes->post('login', 'Web\Auth::processLogin');
$routes->get('register', 'Web\Auth::register');
$routes->post('register', 'Web\Auth::processRegister');
$routes->get('logout', 'Web\Auth::logout');

// JWT Routes (untuk web)
$routes->get('auth/get-token', 'Web\Auth::getToken');
$routes->get('auth/verify-token', 'Web\Auth::verifyToken');

// ============================================
// PROTECTED ROUTES (Semua User Login)
// ============================================
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Web\Dashboard::index');
    $routes->get('aspirasi', 'Web\Aspirasi::index');
    $routes->get('aspirasi/create', 'Web\Aspirasi::create');
    $routes->post('aspirasi/store', 'Web\Aspirasi::store');
    $routes->get('aspirasi/(:num)', 'Web\Aspirasi::detail/$1');
    $routes->get('aspirasi/edit/(:num)', 'Web\Aspirasi::edit/$1');
    $routes->post('aspirasi/update/(:num)', 'Web\Aspirasi::update/$1');
    $routes->get('aspirasi/delete/(:num)', 'Web\Aspirasi::delete/$1');
    $routes->post('aspirasi/komentar/(:num)', 'Web\Aspirasi::addKomentar/$1');
});

// ============================================
// ADMIN ROUTES
// ============================================
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
    $routes->get('aspirasi', 'Admin\Aspirasi::index');
    $routes->get('aspirasi/(:num)', 'Admin\Aspirasi::detail/$1');
    $routes->post('aspirasi/status/(:num)', 'Admin\Aspirasi::updateStatus/$1');
    
    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/(:num)', 'Admin\Users::detail/$1');
    $routes->get('users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\Users::update/$1');
    $routes->get('users/delete/(:num)', 'Admin\Users::delete/$1');
    $routes->get('users/toggle/(:num)', 'Admin\Users::toggleStatus/$1');
    
    $routes->get('laporan', 'Admin\Laporan::index');
    $routes->post('laporan/filter', 'Admin\Laporan::filter');
});

// ============================================
// DOSEN ROUTES
// ============================================
$routes->group('dosen', ['filter' => 'dosen'], function($routes) {
    $routes->get('dashboard', 'Dosen\Dashboard::index');
    $routes->get('aspirasi', 'Dosen\Aspirasi::index');
    $routes->get('aspirasi/(:num)', 'Dosen\Aspirasi::detail/$1');
    $routes->post('aspirasi/status/(:num)', 'Dosen\Aspirasi::updateStatus/$1');
    $routes->post('aspirasi/tanggapan/(:num)', 'Dosen\Aspirasi::addTanggapan/$1');
});

// ============================================
// MAHASISWA ROUTES
// ============================================
$routes->group('mahasiswa', ['filter' => 'mahasiswa'], function($routes) {
    $routes->get('dashboard', 'Mahasiswa\Dashboard::index');
    $routes->get('aspirasi', 'Mahasiswa\Aspirasi::index');
    $routes->get('aspirasi/create', 'Mahasiswa\Aspirasi::create');
    $routes->post('aspirasi/store', 'Mahasiswa\Aspirasi::store');
    $routes->get('aspirasi/(:num)', 'Mahasiswa\Aspirasi::detail/$1');
    $routes->get('profil', 'Mahasiswa\Profil::index');
    $routes->post('profil/update', 'Mahasiswa\Profil::update');
});

// ============================================
// API ROUTES (DENGAN JWT)
// ============================================
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    // Public API (tanpa token)
    $routes->post('auth/register', 'AuthController::register');
    $routes->post('auth/login', 'AuthController::login');
    
    // Protected API (pakai JWT)
    $routes->group('', ['filter' => 'jwt'], function($routes) {
        $routes->post('auth/logout', 'AuthController::logout');
        $routes->get('auth/me', 'AuthController::me');
        
        $routes->get('aspirasi', 'AspirasiController::index');
        $routes->get('aspirasi/(:num)', 'AspirasiController::show/$1');
        $routes->post('aspirasi', 'AspirasiController::create');
        $routes->put('aspirasi/(:num)', 'AspirasiController::update/$1');
        $routes->delete('aspirasi/(:num)', 'AspirasiController::delete/$1');
        
        $routes->get('kategori', 'KategoriController::index');
        $routes->post('aspirasi/(:num)/komentar', 'KomentarController::create/$1');
    });
});