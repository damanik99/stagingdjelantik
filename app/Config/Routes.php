<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Auth::index');

$routes->get('auth', 'Auth::index');
$routes->post('auth/ceklogin', 'Auth::ceklogin');

$routes->get('StorageContainer', 'StorageContainer::index');
$routes->get('StorageContainer/create', 'StorageContainer::create');
$routes->post('StorageContainer/save', 'StorageContainer::save');
$routes->get('StorageContainer/detail/(:num)', 'StorageContainer::detail/$1');
$routes->get('StorageContainer/edit/(:num)', 'StorageContainer::edit/$1');
$routes->post('StorageContainer/update/(:num)', 'StorageContainer::update/$1');
$routes->post('storagecontainer/datatables', 'StorageContainer::datatables');
