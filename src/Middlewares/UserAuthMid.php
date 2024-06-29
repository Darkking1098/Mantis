<?php

namespace Mantis\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserAuthMid
{
    public function handle(Request $request, Closure $next, $restrict = false)
    {
        if (!session('userId') && $restrict) {
            return redirect()->route('user.login');
        }
        request()->merge(['isLogged' => !!session('userId')]);
        return $next($request);
    }
}
