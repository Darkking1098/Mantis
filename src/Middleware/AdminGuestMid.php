<?php

namespace Mantis\User\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mantis\Controllers\MantisController;

class AdminGuestMid
{
    public function handle(Request $request, Closure $next)
    {
        if (session('adminId')) return redirect('/');
        return $next($request);
    }
}
