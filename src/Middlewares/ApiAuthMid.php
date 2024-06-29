<?php

namespace Mantis\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mantis\Controllers\MantisController;
use Mantis\Helpers\Security\Token\JWT;

class ApiAuthMid
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->token) {
            return MantisController::api(MantisController::error("You are not logged in !!!"), 401);
        }

        $data = JWT::validate($request->token);

        if (!$data['isValid']) {
            return MantisController::api(MantisController::error("Invalid Token used !!!"), 498);
        }

        $user = User::where('login_token', $request->userdata['token'])->first();

        if (!$user)
            return MantisController::api(MantisController::error("Invalid Credentials !!!"));

        if (!$user->user_status)
            return MantisController::api(MantisController::error("Account has been disabled !!!"));

        $request->merge(["userdata" => $data['data']]);

        return $next($request);
    }
}
