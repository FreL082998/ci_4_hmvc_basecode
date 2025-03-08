<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', ['namespace' => 'App\Controllers\Api'], function ($routes) {
    // Example Usage: Test Module
    // $routes->group('test', function ($routes) {
    //     $routes->get('/', 'TestController::index');
    //     $routes->get('show/(:num)', 'TestController::show/$1');
    //     $routes->post('create', 'TestController::create');
    //     $routes->put('update/(:num)', 'TestController::update/$1');
    //     $routes->delete('delete/(:num)', 'TestController::delete/$1');
    // });
    $routes->resource('test', ['controller' => 'TestController']);
});