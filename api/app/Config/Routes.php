<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Example Usage: Test Module
// $routes->group('test', function ($routes) {
//     $routes->get('/', 'TestController::index');
//     $routes->get('show/(:num)', 'TestController::show/$1');
//     $routes->post('create', 'TestController::create');
//     $routes->put('update/(:num)', 'TestController::update/$1');
//     $routes->delete('delete/(:num)', 'TestController::delete/$1');
// });
// $routes->resource('test', ['controller' => 'TestController']);

$routes->group('api', ['namespace' => 'App\Controllers\Api'], function ($routes) {
    $routes->resource('test', ['controller' => 'TestController']);
});

$routes->group('/', ['namespace' => 'App\Controllers\Web'], function ($routes) {
    $routes->group('test', function ($routes) {
        $routes->get('/', 'TestController::index');
    });
});

/**
 * Dynamically loads all module route files from the Modules directory.
 *
 * This function scans the `Modules` directory and automatically includes
 * the `Config/Routes.php` file for each module if it exists. This approach
 * eliminates the need to manually update `app/Config/Routes.php` every time
 * a new module is created.
 *
 * @param RouteCollection $routes The route collection instance.
 */
$routes->group('', function ($routes) {
    $modulesPath = ROOTPATH . 'Modules/';

    // Check if the Modules directory exists
    if (is_dir($modulesPath)) {
        // Scan the Modules directory for available modules
        $modules = scandir($modulesPath);

        foreach ($modules as $module) {
            // Ignore the default '.' and '..' directories
            if ($module === '.' || $module === '..') {
                continue;
            }

            // Define the expected path for the module's Routes.php file
            $routeFile = $modulesPath . $module . '/Config/Routes.php';

            // If the Routes.php file exists, require it
            if (file_exists($routeFile)) {
                require $routeFile;
            }
        }
    }
});
