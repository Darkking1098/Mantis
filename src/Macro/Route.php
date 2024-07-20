<?php

use Illuminate\Support\Facades\Route;

Route::macro('MantisWebResource', function ($name, $controller, array $config = []) {
    $defaultRoutes = [
        'ui_modify' => [
            "create" => ['get', 'create'],
            "update" => ['get', '{id}/update']
        ],
        'ui_view' => [
            "view_all" => ['get', ''],
            "view" => ['get', '{id}'],
        ],
        'web_modify' => [
            "create" => ['post', 'create'],
            "update" => ['post', '{id}/update'],
            "update.put" => ['put', '{id}/update'],
            "update.patch" => ['patch', '{id}/update']
        ],
        'web_toggle' => [
            "toggle" => ['get', '{id}/toggle'],
            "toggle.put" => ['put', '{id}/toggle'],
            "toggle.patch" => ['patch', '{id}/toggle'],
        ],
        'web_delete' => [
            "delete" => ['get', '{id}/delete'],
            "delete.delete" => ['delete', '{id}/delete'],
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
                if (strpos($uri, "{id}") !== false) {
                    Route::whereNumber('id')->$method($uri, $controllerMethod)->name(".$routeName");
                } else {
                    Route::$method($uri, $controllerMethod)->name(".$routeName");
                }
            }
        }
    });
});
