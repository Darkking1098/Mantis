<?php

namespace Mantis\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mantis\Controllers\MantisController;

class UserAjaxMid
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->isLogged) {
            return MantisController::api(MantisController::AVOID_GUEST, 401);
        }
        return $next($request);
    }
}
