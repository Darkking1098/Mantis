<?php

use Illuminate\Support\Facades\Route;

use Mantis\Controllers\AdminControllers\{
    AuthController,
    EmployeeController,
    ProfileController,
    ProtectedPageController,
    ProtectedPageGroupController,
    QueryController,
    RoleController,
    WebPageController,
    WebUriController,
};

use Mantis\Controllers\ExternalControllers\PluginController;

Route::get('', fn () => view('Mantis::admin.index'))->name('home');
Route::get('index', fn () => redirect()->route('home'));

Route::controller(AuthController::class)->withoutMiddleware('admin-auth')->prefix('employee')->name('employee.')->group(function () {
    Route::prefix('login')->name('login')->group(function () {
        Route::get('', 'ui_login');
        Route::post('', 'web_login');
    });
    Route::prefix('forget-password')->name('forget')->group(function () {
        Route::get('', 'ui_forget');
        Route::post('', 'web_forget');
    });
    Route::prefix('reset-password')->name('reset')->group(function () {
        Route::get('', 'ui_reset');
        Route::post('', 'web_reset');
    });
    Route::any('logout', 'web_logout')->name('logout');
});

Route::controller(EmployeeController::class)->prefix('employee')->name('employee.')->group(function () {
    Route::get('', 'ui_view');
    Route::prefix('create')->name('create')->group(function () {
        Route::get('', 'ui_modify');
        Route::post('', 'web_modify');
    });
    Route::prefix('{employee}')->whereNumber('employee')->group(function () {
        Route::get('', 'ui_view')->name('view');
        Route::prefix('update')->name('update')->group(function () {
            Route::get('', 'ui_modify');
            Route::post('', 'web_modify');
        });
    });
});

Route::prefix('page')->name("protected.")->group(function () {
    Route::controller(ProtectedPageGroupController::class)->prefix("group")->name('group.')->group(function () {
        Route::get('', 'ui_view');
        Route::prefix("create")->name("create")->group(function () {
            Route::get('', 'ui_modify');
            Route::post('', 'web_modify');
        });
        Route::prefix('{group}')->group(function () {
            Route::get('', 'ui_view')->name('view');
            Route::prefix("update")->name('update')->group(function () {
                Route::get('', 'ui_modify');
                Route::post('', 'web_modify');
            });
        })->whereNumber('group');
    });
    Route::controller(ProtectedPageController::class)->name('page.')->group(function () {
        Route::get('', 'ui_view');
        Route::prefix('create')->name("create")->group(function () {
            Route::get('', 'ui_modify');
            Route::post('', 'web_modify');
        });
        Route::prefix('{page}')->group(function () {
            Route::get('', 'ui_view')->name('view');
            Route::prefix('update')->name('update')->group(function () {
                Route::get('', 'ui_modify');
                Route::post('', 'web_modify');
            });
        })->whereNumber('page');
    });
});

Route::controller(QueryController::class)->prefix('query')->name('query.')->group(function () {
    Route::get('', 'ui_view')->name('viewAll');
    Route::get('{query}', 'ui_view')->name('view');
});

Route::controller(PluginController::class)->prefix('plugin')->name('plugin.')->group(function () {
    Route::get('', 'view_plugins');
    Route::get('{plugin}/{version?}', 'view_plugin');
});

Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
    Route::prefix('update')->name('update')->group(function () {
        Route::get('', 'ui_modify');
        Route::post('', 'web_modify');
    });
});

Route::controller(RoleController::class)->prefix('role')->name('role.')->group(function () {
    Route::get('', 'ui_view');
    Route::prefix('create')->name('create')->group(function () {
        Route::get('', 'ui_modify');
        Route::post('', 'web_modify');
    });
    Route::prefix('{role}')->whereNumber('role')->group(function () {
        Route::get('', 'ui_view')->name('view');
        Route::prefix('update')->name('update')->group(function () {
            Route::get('', 'ui_modify');
            Route::post('', 'web_modify');
        });
    });
});

Route::controller(WebPageController::class)->prefix('webpage')->name('webpage.')->group(function () {
    Route::get('', 'ui_view');
    Route::prefix('create')->name('create')->group(function () {
        Route::get('', 'ui_modify');
        Route::post('', 'web_modify');
    });
    Route::prefix('{webpage}')->whereNumber('webpage')->group(function () {
        Route::get('', 'ui_view')->name('view');
        Route::prefix('update')->name('update')->group(function () {
            Route::get('', 'ui_modify');
            Route::post('', 'web_modify');
        });
    });
});

Route::controller(WebUriController::class)->prefix('weburi')->name('weburi.')->group(function () {
    Route::get('', 'ui_view');
    Route::prefix('create')->name('create')->group(function () {
        Route::get('', 'ui_modify');
        Route::post('', 'web_modify');
    });
    Route::prefix('{weburi}')->whereNumber('weburi')->group(function () {
        Route::get('', 'ui_view')->name('view');
        Route::prefix('update')->name('update')->group(function () {
            Route::get('', 'ui_modify');
            Route::post('', 'web_modify');
        });
    });
});


foreach (config('mantis.plugins') as $plugin)
    if (is_file($file = "{$plugin['path']}/routes/" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php"))
        include_once $file;
