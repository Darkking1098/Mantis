<?php

namespace Mantis\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mantis\Controllers\MantisController;
use Mantis\Helpers\Security\Token\JWT;
use Mantis\Models\Employee;
use Mantis\User\Models\User;

class ApiMid
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->token) return MantisController::api(MantisController::error("You are not logged in !!!"), 401);

        $data = JWT::validate($request->token);

        if (!$data['isValid']) return MantisController::api(MantisController::error("Invalid Token used !!!"), 498);

        $query = $data['data']['isAdmin'] ? Employee::query() : User::query();
        $user = $query->where('login_token', $data['data']['token'])->first();

        if (!$user) return MantisController::api(MantisController::error("Invalid Credentials !!!"));

        if (!$user->status) return MantisController::api(MantisController::error("Account has been disabled !!!"));

        $request->merge(["userData" => $data['data']]);

        return $next($request);
    }
}
