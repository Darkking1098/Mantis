<?php

use Illuminate\Support\Facades\Route;

function render_routes($defaultRoutes, $name, $controller, array $config = [])
{
    if (isset($config['only'])) {
        $defaultRoutes = array_intersect_key($defaultRoutes, array_flip($config['only']));
    }
    if (isset($config['except'])) {
        $defaultRoutes = array_diff_key($defaultRoutes, array_flip($config['except']));
    }

    foreach ($config['routes'] ?? [] as $key => $routes) {
        $defaultRoutes[$key] = array_merge($defaultRoutes[$key] ?? [], $routes);
    }

    $view_route = ($config['name'] ?? $name) . ".view_all";

    Route::controller($controller)->prefix($name)->name($config['name'] ?? $name)->group(function () use ($defaultRoutes, $view_route) {
        foreach ($defaultRoutes as $controllerMethod => $method_config) {
            foreach ($method_config as $routeName => [$method, $uri]) {
                Route::$method($uri, $controllerMethod)->name(".$routeName");
            }
        }
        Route::get('', function () use ($view_route) {
            return redirect()->route($view_route);
        });
    });
}

Route::macro('MantisWebResource', function ($name, $controller, array $config = []) {
    render_routes([
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
    ], $name, $controller, $config ?? []);
});

Route::macro('MantisApiResource', function ($name, $controller, array $config = []) {
    render_routes([
        'api_view' => [
            "view_all" => ['get', 'view'],
            "view" => ['get', 'view/{id}'],
        ],
        'api_modify' => [
            "create" => ['post', 'create'],
            "update" => ['post', 'update/{id}'],
            "update.put" => ['put', 'update/{id}'],
            "update.patch" => ['patch', 'update/{id}']
        ],
        'api_toggle' => [
            "toggle" => ['get', 'toggle/{id}'],
            "toggle.put" => ['put', 'toggle/{id}'],
            "toggle.patch" => ['patch', 'toggle/{id}'],
        ],
        'api_delete' => [
            "delete" => ['get', 'delete/{id}'],
            "delete.delete" => ['delete', 'delete/{id}'],
        ],
    ], $name, $controller, $config ?? []);
});
