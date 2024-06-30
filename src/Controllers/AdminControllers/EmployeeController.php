<?php

namespace Mantis\Controllers\AdminControllers;

use Illuminate\Http\Request;
use Mantis\Controllers\MantisController;
use Mantis\Helpers\Security\Encoder\OPENSSL;
use Mantis\Models\Employee;
use Mantis\Models\Role;

class EmployeeController extends MantisController
{
    protected const STORE = "images/employee/";

    protected const MODEL = Employee::class;

    private const STATUS = [
        ["msg" => "Employee is now disabled !!!", "status" => "DISABLED"],
        ["msg" => "Employee is now active !!!", "status" => "ACTIVE"]
    ];

    private const NOT_EXISTS = "Employee does not exist !!!";
    private const EXISTS = "Employee already exists !!!";
    private const CREATED = "Employee has been created !!!";
    private const UPDATED = "Employee has been updated !!!";
    private const DELETED = "Employee has been deleted !!!";

    private const VIEW = "Mantis::admin.employee.";

    static function get_employee($employee = null)
    {
        $query = Employee::with('role');
        return (($employee == null || is_numeric($employee)) ? $query->find($employee ?? session('adminId')) : $query->where('username', $employee)->first())?->toArray();
    }

    // CRUD Operation
    static function create($params)
    {
        try {
            $employee = new (self::MODEL)($params);
            $employee->save();
            return self::success(["msg" => self::CREATED, "employee" => self::get_employee($employee->id)]);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }
    static function update($employee, $params)
    {
        if (!($employee = self::MODEL::find($employee)))
            return self::error(self::NOT_EXISTS);
        try {
            $employee->update($params);
            return self::success(["msg" => self::UPDATED, "employee" => self::get_employee($employee->id)]);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }
    static function toggle($employee)
    {
        if (!($employee = self::MODEL::find($employee)))
            return self::error(self::NOT_EXISTS);
        try {
            $employee->status = !$employee->status;
            $employee->save();
            return self::success(self::STATUS[$employee->status]);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }
    static function delete($employee, $force)
    {
        if (!($employee = self::MODEL::find($employee)))
            return self::error(self::NOT_EXISTS);
        try {
            $employee->delete();
            return self::success(static::DELETED);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }

    // View Pages
    function ui_view($employee = null)
    {
        if ($employee == null) {
            $data = ['employees' => Employee::with('role')->get()->toArray()];
            return view(self::VIEW . "view_employees", $data);
        } else {
            $data = [];
            return view(self::VIEW . "view_employee", $data);
        }
    }
    function ui_modify(Employee $employee = null)
    {
        $data = ["roles" => Role::all()->toArray()];
        if ($employee == null) {
            $data += [];
        } else {
            $data += ["emp" => $employee->toArray()];
        }
        return view(self::VIEW . "modify_employee", $data);
    }

    function web_delete(Request $request, $employee)
    {
        return self::web(self::delete($employee, $request->force));
    }
    function web_toggle($employee)
    {
        return self::web(self::toggle($employee));
    }

    function api_delete(Request $request, $employee)
    {
        return self::api(self::delete($employee, $request->force));
    }
    function api_toggle($employee)
    {
        return self::api(self::toggle($employee));
    }

    function web_modify(Request $request, $employee = null)
    {
        return self::web(self::base_modify($employee));
    }
    function api_modify(Request $request, $employee = null)
    {
        return self::web(self::base_modify($employee));
    }
    function base_modify($employee, $params = null)
    {
        $params ??= [];

        if (request('profile_img')) {
            $params['profile_image'] = ["url" => self::convertToWebp(request('profile_img'))['path']];
        }
        if (request('banner_img')) {
            $params['banner_image'] = ["url" => self::convertToWebp(request('banner_img'))['path']];
        }
        $params += [
            "role_id" => request('role'),
            "department_id" => request('dep'),
            "team_id" => request('team'),
            "name" => request('name'),
            "gender" => request('gender'),
            "about" => request('about'),
            "salary" => request('salary'),
            "contact" => request('contact'),
            "email" => request('email'),
            "address" => request('address'),
            "joined_at" => request('joined'),
            "status" => request('status') ?? 0,
            "can_join_teams" => request('can_join_teams') ?? 0,
        ];
        $extra = [
            "username" => request('username'),
            "password" => OPENSSL::encode(request('password')),
            "joined" => request('joined'),
        ];

        return $employee == null ? self::create($params + $extra) : self::update($employee, $params);
    }
}
