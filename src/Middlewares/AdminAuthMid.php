<?php

namespace Mantis\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use Mantis\Controllers\AdminControllers\{
    WebPageController as URL,
    WebUriController as URI,
    EmployeeController as Employee,
    ProtectedPageController as Page,
    RoleController as Role
};

class AdminAuthMid
{
    public function handle(Request $request, Closure $next)
    {
        /** Redirecting to login if user is not logged in */
        if (!session()->has("adminId"))
            return redirect()->route("admin.employee.login");

        /** Getting Employee data */
        $admin = Employee::get_employee();
        /** Redirecting to logout if user  is disabled */
        if (!$admin || !$admin['status'])
            return Employee::web(['msg' => "Contact HR"]);

        // checking if page exixts or page is active
        $page = Page::getPage();
        if (strpos(URI::getUri(), "/") !== false) {
            if (!$page || !$page['status']) abort(404);
            if (!Role::hasUriPermit()) {
                return redirect()->route("admin.home");
            }
        }

        View::share(['admin' => $admin, "pageCont" => Page::class, "current" => ["uri" => URI::getUri(), "url" => URL::getUrl()] + ($page ?? []), "role" => Role::class]);

        return $next($request);
    }
}
