<?php

namespace Mantis\Controllers\AdminControllers;

use Illuminate\Http\Request;
use Mantis\Controllers\MantisController;

use Mantis\Controllers\AdminControllers\ProtectedPageController as PAGE;
use Mantis\Controllers\AdminControllers\WebPageController as URL;
use Mantis\Controllers\AdminControllers\WebUriController as URI;
use Mantis\Models\Role;

class RoleController extends MantisController
{
    protected const STORE = "";

    protected const MODEL = Role::class;

    private const STATUS = [
        ["msg" => "Job role is now disabled !!!", "status" => "DISABLED"],
        ["msg" => "Job role is now active !!!", "status" => "ACTIVE"]
    ];

    private const NOT_EXISTS = "Job role does not exist !!!";
    private const EXISTS = "Job role already exists !!!";
    private const CREATED = "Job role has been created !!!";
    private const UPDATED = "Job role has been updated !!!";
    private const DELETED = "Job role has been deleted !!!";

    private const VIEW = "Mantis::admin.employee.role.";

    static function getPermits($role = null)
    {
        return EmployeeController::get_employee($role)['role']['permissions'];
    }
    static function hasUrlPermit($url = null)
    {
        $uri = URI::getUri($url ?? URL::getUrl());
        if (str_starts_with($uri, "api")) $uri = substr($uri, 4);
        return self::hasUriPermit($uri);
    }
    static function hasUriPermit($uri = null)
    {
        $permits = self::getPermits();
        $page = PAGE::getPage($uri ?? URI::getUri());
        return (($permits[0] ?? 'x') == '*' || in_array(($uri != null && is_numeric($uri)) ? $uri : $page['id'], $permits) || !($page['permission_required'] ?? true));
    }


    // CRUD Operation
    static function create($params)
    {
        $role = new (self::MODEL)($params);
        try {
            $role->save();
            return self::success(["msg" => self::CREATED]);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }
    static function update($role, $params)
    {
        if (!($role = self::MODEL::find($role)))
            return self::error(self::NOT_EXISTS);
        try {
            $role->update($params);
            return self::success(["msg" => self::UPDATED]);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }
    static function toggle($role)
    {
        if (!($role = self::MODEL::find($role)))
            return self::error(self::NOT_EXISTS);
        try {
            $role->status = !$role->status;
            $role->save();
            return self::success(self::STATUS[$role->status]);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }
    static function delete($role, $force)
    {
        if (!($role = self::MODEL::find($role)))
            return self::error(self::NOT_EXISTS);
        try {
            $role->delete();
            return self::success(static::DELETED);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }

    // View Pages
    function ui_view($role = null)
    {
        if ($role == null) {
            $data = ['roles' => self::MODEL::withCount('employees')->get()->toArray()];
            return view(self::VIEW . "view_roles", $data);
        } else {
            $data = [];
            return view(self::VIEW . "view_role", $data);
        }
    }
    function ui_modify(Role $role = null)
    {
        $data = ['groups' => ProtectedPageGroupController::getGroupsWithAllPages()];
        if ($role == null) {
            $data += $data;
        } else {
            $data += [...$data, "role" => $role->toArray()];
        }
        return view(self::VIEW . "modify_role", $data);
    }

    function web_delete(Request $request, $role)
    {
        return self::web(self::delete($role, $request->force));
    }
    function web_toggle($role)
    {
        return self::web(self::toggle($role));
    }

    function api_delete(Request $request, $role)
    {
        return self::api(self::delete($role, $request->force));
    }
    function api_toggle($role)
    {
        return self::api(self::toggle($role));
    }

    function web_modify(Request $request, $role = null)
    {
        return self::web(self::base_modify($role));
    }
    function api_modify(Request $request, $role = null)
    {
        return self::web(self::base_modify($role));
    }
    function base_modify($role, $params = null)
    {
        $params ??= [
            "title" => request("title"),
            "description" => request("description"),
            "permissions" => request("permissions"),
        ];
        return $role == null ? self::create($params) : self::update($role, $params);
    }
}
