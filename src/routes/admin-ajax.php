<?php

use Illuminate\Support\Facades\Route;


Route::prefix()->name()->group(function () {
});


foreach (config('mantis.plugins') as $plugin)
    if (is_file($file = "{$plugin['path']}/routes/" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php"))
        include_once $file;
