<?php

use Illuminate\Support\Facades\Route;
use Mantis\Controllers\ExternalControllers\MantisUiController;
use Mantis\Helpers\Security\Encoder\OPENSSL;

// Loading CSS from server
Route::get('mantis-css', [MantisUiController::class, 'fetch_css']);

// Loading JS from server
Route::get('mantis-js', [MantisUiController::class, 'fetch_js']);

Route::get('developer', function () {
    return view('Mantis::user.developer');
});


Route::prefix()->name()->group(function () {
});


foreach (config('mantis.plugins') as $plugin)
    if (is_file($file = "{$plugin['path']}/routes/" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php"))
        include_once $file;
