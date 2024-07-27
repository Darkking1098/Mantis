<?php

namespace Mantis\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mantis\Controllers\MantisController;

class GuestMid
{
    public function handle(Request $request, Closure $next)
    {
        if (session('userId')) return redirect('/');
        return $next($request);
    }
}
