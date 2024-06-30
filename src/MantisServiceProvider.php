<?php

namespace Mantis;

use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Mantis\Helpers\fs;
use Mantis\Middleware\AdminAjaxMid;
use Mantis\Middleware\AdminApiMid;
use Mantis\Middleware\AdminAuthMid;
use Mantis\Middleware\UriTrackMid;
use Mantis\Middleware\UserAjaxMid;
use Mantis\Middleware\UserApiMid;
use Mantis\Middleware\UserAuthMid;

class MantisServiceProvider extends ServiceProvider
{
    protected $public = [];

    protected $mids = [
        "web" => [UriTrackMid::class, UserAuthMid::class],
        "api" => [UserApiMid::class],
        "admin" => [AdminAuthMid::class],
        "admin-api" => [AdminApiMid::class],
    ];

    public function register()
    {
    }

    public function boot()
    {
        // Helper File
        include_once __DIR__ . "/Helpers/helper.php";

        // Public assets
        $this->public[__DIR__ . '/public'] =  public_path('Mantis');

        // Loading migratins
        $this->loadMigrationsFrom(__DIR__ . "/database/migrations");

        // Loading views
        $this->loadViewsFrom(__DIR__ . "/views", "Mantis");

        // Booting plugins
        $this->boot_plugins();

        // Booting middlewares
        $this->boot_middlewares();

        // Booting routes
        $this->boot_routes();

        // Copy resources to spider folder
        $this->publishes($this->public, 'mantis-public');

        // Publishing configuration file
        $this->publishes([
            __DIR__ . '/Helpers/mantis.php' => config_path('mantis.php'),
        ], 'mantis-config');
    }

    private function boot_plugins()
    {
        try {
            if (is_file($file = base_path("/plugins/plugins.json")))
                $plugins = json_decode(file_get_contents($file), true);
            else
                file_put_contents($file, '[]');
            if (!isset($plugins) || !$plugins) $plugins = [];
            foreach ($plugins as $i => $plugin) {
                $plugins[$i]['path'] = base_path("/plugins/{$plugin['plugin']}/");
                if ($boot = require_once $plugins[$i]['path'] . "boot.php")
                    $boot($this);
            }
        } finally {
            config(['mantis.plugins' => $plugins ?? []]);
        }
    }

    private function boot_middlewares()
    {
        $web = app()->router->getMiddlewareGroups()['web'];
        $this->mids['web'] = [...$web, ...$this->mids['web']];
        $this->mids['admin'] = [...$web, ...$this->mids['admin']];

        $api = app()->router->getMiddlewareGroups()['api'];
        $this->mids['api'] = [...$api, ...$this->mids['api']];
        $this->mids['admin-api'] = [...$api, ...$this->mids['admin-api']];
        
        foreach ($this->mids as $group => $middleware) {
            if ($group === 'web' || $group === 'api') {
                foreach ($middleware as $mid) {
                    $this->app['router']->pushMiddlewareToGroup($group, $mid);
                }
            } else {
                $this->app['router']->middlewareGroup($group, $middleware);
            }
        }
    }

    private function boot_routes()
    {
        // Web routes
        $route = __DIR__ . '/routes/web.php';
        fs::create_file($route);
        Route::middleware('web')->group($route);

        // Web routes
        $route = __DIR__ . '/routes/ajax.php';
        fs::create_file($route);
        Route::middleware(['web', UserAjaxMid::class])->withoutMiddleware([UriTrackMid::class, VerifyCsrfToken::class])->prefix('ajax')->group($route);

        // Api routes
        $route = __DIR__ . '/routes/api.php';
        fs::create_file($route);
        Route::middleware('api')->name('api')->prefix('api')->group($route);

        // Admin routes
        $route = __DIR__ . '/routes/admin.php';
        fs::create_file($route);
        Route::middleware(['admin'])
            ->withoutMiddleware([UriTrackMid::class])
            ->prefix('admin')->name('admin.')
            ->group($route);

        // Admin routes
        $route = __DIR__ . '/routes/admin-ajax.php';
        fs::create_file($route);
        Route::middleware(['admin', AdminAjaxMid::class])
            ->withoutMiddleware([UriTrackMid::class, VerifyCsrfToken::class])
            ->prefix('ajax/admin')->name('ajax.admin.')
            ->group($route);

        // Admin routes
        $route = __DIR__ . '/routes/admin-api.php';
        fs::create_file($route);
        Route::middleware('admin-api')
            ->prefix('ajax/admin')->name('ajax.admin.')
            ->group($route);
    }
}
