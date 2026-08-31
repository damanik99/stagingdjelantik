<?php

use CodeIgniter\Router\RouteCollection;
use Config\DynamicRoutes;

/** @var RouteCollection $routes */

// =====================================================
// AUTH
// =====================================================

$routes->get('/', 'Auth::index');

$routes->get('auth', 'Auth::index');

$routes->post('auth/ceklogin', 'Auth::ceklogin');


// =====================================================
// DYNAMIC ROUTES
// =====================================================

DynamicRoutes::load();
