<?php

use Illuminate\Support\Facades\Route;

Route::macro('MantisWebResource', function ($name, $controller, array $config = []) {
    $defaultRoutes = [
        'ui_modify' => [
            "create" => ['get', 'create'],
            "update" => ['get', 'update/{id}']
        ],
        'ui_view' => [
            "view_all" => ['get', 'view'],
            "view" => ['get', 'view/{id}'],
        ],
        'web_modify' => [
            "create" => ['post', 'create'],
            "update" => ['post', 'update/{id}'],
            "update.put" => ['put', 'update/{id}'],
            "update.patch" => ['patch', 'update/{id}']
        ],
        'web_toggle' => [
            "toggle" => ['get', 'toggle/{id}'],
            "toggle.put" => ['put', 'toggle/{id}'],
            "toggle.patch" => ['patch', 'toggle/{id}'],
        ],
        'web_delete' => [
            "delete" => ['get', 'delete/{id}'],
            "delete.delete" => ['delete', 'delete/{id}'],
        ],
    ];

    if (isset($config['only'])) {
        $defaultRoutes = array_intersect_key($defaultRoutes, array_flip($config['only']));
    }
    if (isset($config['except'])) {
        $defaultRoutes = array_diff_key($defaultRoutes, array_flip($config['except']));
    }

    foreach ($config['routes'] ?? [] as $key => $routes) {
        $defaultRoutes[$key] = array_merge($defaultRoutes[$key] ?? [], $routes);
    }

    Route::controller($controller)->prefix($name)->name($config['name'] ?? $name)->group(function () use ($defaultRoutes) {
        foreach ($defaultRoutes as $controllerMethod => $method_config) {
            foreach ($method_config as $routeName => [$method, $uri]) {
                Route::$method($uri, $controllerMethod)->name(".$routeName");
            }
        }
    });
});
