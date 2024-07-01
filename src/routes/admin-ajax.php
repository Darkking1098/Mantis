<?php

use Illuminate\Support\Facades\Route;



use Mantis\Controllers\AdminControllers\{
    EmployeeController,
    ProtectedPageController,
    ProtectedPageGroupController,
    QueryController,
    RoleController,
    WebPageController,
    WebUriController,
};
use Mantis\Controllers\ExternalControllers\PluginController;

Route::prefix('page')->name("protected.")->group(function () {
    Route::controller(ProtectedPageGroupController::class)->prefix("group")->name('group.')->group(function () {
        Route::prefix('{group}')->group(function () {
            Route::get('toggle', 'api_toggle')->name('toggle');
            Route::get('delete', 'api_delete')->name('delete');
        })->whereNumber('group');
    });
    Route::prefix('{page}')->name('page.')->controller(ProtectedPageController::class)->group(function () {
        Route::get('toggle', 'api_toggle')->name('toggle');
        Route::get('delete', 'api_delete')->name('delete');
    })->whereNumber('page');
});

Route::controller(EmployeeController::class)->prefix('employee')->name('employee.')->group(function () {
    Route::prefix('{employee}')->group(function () {
        Route::get('toggle', 'api_toggle')->name('toggle');
        Route::get('delete', 'api_delete')->name('delete');
    })->whereNumber('employee');
});

Route::prefix('plugin')->name('plugin.')->controller(PluginController::class)->group(function () {
    Route::get('{plugin}/{version}/download', 'download_plugin');
});

Route::controller(QueryController::class)->prefix('query')->name('query.')->group(function () {
    Route::get('{query}/delete', 'api_delete')->name('delete');
});

Route::controller(RoleController::class)->prefix('role')->name('role.')->group(function () {
    Route::prefix('{role}')->group(function () {
        Route::get('delete', 'api_delete')->name('delete');
    })->whereNumber('role');
});

Route::prefix('webpage')->controller(WebPageController::class)->name("webpage.")->group(function () {
    Route::get('check', 'api_check')->name('check');
    Route::prefix('{webpage}')->group(function () {
        Route::get('toggle', 'api_toggle')->name('toggle');
        Route::get('delete', 'api_delete')->name('delete');
    })->whereNumber('webpage');
});

Route::prefix('weburi')->controller(WebUriController::class)->name("weburi.")->group(function () {
    Route::get('check', 'api_check')->name('check');
    Route::prefix('{weburi}')->group(function () {
        Route::get('toggle', 'api_toggle')->name('toggle');
        Route::get('delete', 'api_delete')->name('delete');
    })->whereNumber('weburi');
});


foreach (config('mantis.plugins') as $plugin)
    if (is_file($file = "{$plugin['path']}/routes/" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php"))
        include_once $file;
