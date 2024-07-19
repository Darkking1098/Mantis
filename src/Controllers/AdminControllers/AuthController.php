<?php

namespace Mantis\Controllers\AdminControllers;

use Illuminate\Http\Request;
use Mantis\Controllers\MantisController;
use Mantis\Helpers\Security\Encoder\OPENSSL;
use Mantis\Models\Employee;

class AuthController extends MantisController
{
    function login($username, $password)
    {
        if (!($employee = Employee::where('username', $username)->first()))
            return self::error("Invalid Credentials", 401);
        if (!$employee->status) {
            return self::error("Contact HR.", 403);
        } else if (OPENSSL::verify($employee->password, $password)) {
            return self::success(["adminId" => $employee->id]);
        }
        return self::error("Invalid Credentials", 401);
    }

    function ui_login()
    {
        return session('adminId') ? redirect()->route('admin.home') : view('Mantis::admin.employee.auth.login');
    }

    function api_login()
    {
    }
    function web_login(Request $request)
    {
        $request->validate([
            'username' => 'required', 'password' => 'required'
        ]);
        $result = self::login($request->username, $request->password);
        if (!$result['success']) return self::web($result);
        session()->put(["adminId" => $result['adminId'], "adminLogged" => true]);
        return redirect()->route('admin.home');
    }
    function api_logout()
    {
        // To-Do
    }
    function web_logout()
    {
        session()->forget(['adminId', 'adminLogged']);
        return redirect()->route('admin.employee.login');
    }
}
