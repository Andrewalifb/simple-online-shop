<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// User routes
$routes->post('/register', 'UserController::register');

// Item routes
$routes->post('/item/create', 'ItemController::create');
$routes->put('/item/update/(:num)', 'ItemController::update/$1');

// Cart routes
$routes->post('/cart/create', 'CartController::create');
$routes->put('/cart/checkout/(:num)', 'CartController::checkout/$1');
$routes->get('/cart/history/(:num)', 'CartController::history/$1');

// CartItem routes
$routes->post('/cartitem/create', 'CartItemController::create');
