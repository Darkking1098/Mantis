<?php

namespace Mantis\Controllers\AdminControllers;

use Illuminate\Http\Request;
use Mantis\Controllers\MantisController;
use Mantis\Helpers\Security\Encoder\OPENSSL;
use Mantis\Models\Employee;

class ProfileController extends MantisController
{
    protected const STORE = "images/employee/";

    protected const MODEL = Employee::class;

    private const NOT_EXISTS = "Profile does not exist !!!";
    private const UPDATED = "Profile has been updated !!!";

    private const VIEW = "Mantis::admin.employee.profile.";

    // CRUD Operation
    static function update($params)
    {
        if (!($Employee = self::MODEL::find(session('adminId'))))
            return self::error(self::NOT_EXISTS);
        try {
            $Employee->update($params);
            return self::success(["msg" => self::UPDATED]);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }

    // View Pages
    function ui_modify()
    {
        $data = ['emp' => EmployeeController::get_employee()];
        return view(self::VIEW . "update", $data);
    }

    function web_modify(Request $request)
    {
        return self::web(self::base_modify());
    }
    function api_modify(Request $request)
    {
        return self::web(self::base_modify());
    }
    function base_modify($params = null)
    {
        $params ??= [];
        if (request('profile_img')) {
            $params['profile_image'] = ["url" => self::move_file(request('profile_img'))['path']];
        }
        if (request('banner_img')) {
            $params['banner_image'] = ["url" => self::move_file(request('banner_img'))['path']];
        }
        if (request('password')) {
            $params["password"] = OPENSSL::encode(request('password'));
        }
        $params += [
            "name" => request('name'),
            "gender" => request('gender'),
            "about" => request('about'),
            "contact" => request('contact'),
            "email" => request('email'),
            "address" => request('address'),
        ];
        return self::update($params);
    }
}
