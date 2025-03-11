<?php

$routes->group('api', ['namespace' => 'Modules\User\Controllers\Api'], function ($routes) {
    $routes->resource('user', ['controller' => 'UserController']);
});

$routes->group('/', ['namespace' => 'Modules\User\Controllers\Web'], function ($routes) {
    $routes->group('user', function ($routes) {
        $routes->get('/', 'UserController::index');
    });
});