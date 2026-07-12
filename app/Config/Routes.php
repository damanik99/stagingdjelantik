<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Auth::index');

$routes->get('auth', 'Auth::index');
$routes->post('auth/ceklogin', 'Auth::ceklogin');
