<?php

namespace Mantis\Controllers\AdminControllers;

use Illuminate\Http\Request;
use Mantis\Controllers\MantisController;
use Mantis\Models\ProtectedPage;
use Mantis\Controllers\AdminControllers\WebUriController as URI;

class ProtectedPageController extends MantisController
{
    protected const MODEL = ProtectedPage::class;

    private const STATUS = [
        ["msg" => "Protected Page is now disabled !!!", "status" => "DISABLED"],
        ["msg" => "Protected Page is now active !!!", "status" => "ACTIVE"]
    ];

    private const NOT_EXISTS = "Protected Page does not exist !!!";
    private const EXISTS = "Protected Page uri already exists !!!";
    private const CREATED = "Protected Page has been created !!!";
    private const UPDATED = "Protected Page has been updated !!!";
    private const DELETED = "Protected Page has been deleted !!!";

    private const VIEW = "Mantis::admin.protected.page.";

    static function getPage($page = null)
    {
        $query = self::MODEL::with('page_group');
        return (($page && is_numeric($page)) ? $query->find($page) : $query->where('uri', $page ?? URI::getUri())->first())?->toArray();
    }
    static function getPages()
    {
        return self::MODEL::with('page_group')->active()->get()?->toArray();
    }
    static function getAllowedPages($panel)
    {
        return ProtectedPageGroupController::getGroupsWithPages($panel, RoleController::getPermits());
    }

    // CRUD Operation
    static function create($params)
    {
        $page = new (self::MODEL)($params);
        try {
            $page->save();
            return self::success(["msg" => self::CREATED]);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }
    static function update($page, $params)
    {
        if (!($page = self::MODEL::find($page)))
            return self::error(self::NOT_EXISTS);
        try {
            $page->update($params);
            return self::success(["msg" => self::UPDATED]);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }
    static function toggle($page)
    {
        if (!($page = self::MODEL::find($page)))
            return self::error(self::NOT_EXISTS);
        try {
            $page->status = !$page->status;
            $page->save();
            return self::success(self::STATUS[$page->status]);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }
    static function delete($page, $force)
    {
        if (!($page = self::MODEL::find($page)))
            return self::error(self::NOT_EXISTS);
        try {
            $page->delete();
            return self::success(static::DELETED);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }

    // View Pages
    function ui_view($page = null)
    {
        if ($page == null) {
            $data = ["pages" => self::MODEL::with('page_group')->get()->toArray()];
            return view(self::VIEW . "view_pages", $data);
        } else {
            $data = ["page" => self::getPage($page)];
            return view(self::VIEW . "view_pages", $data);
        }
    }
    function ui_modify($page = null)
    {
        $data = ["groups" => ProtectedPageGroupController::getGroups()];
        $data += $page ? ["page" => self::getPage($page)] : [];
        return view(self::VIEW . "modify_page", $data);
    }

    function web_delete(Request $request, $page)
    {
        return self::web(self::delete($page, $request->force));
    }
    function web_toggle($page)
    {
        return self::web(self::toggle($page));
    }

    function api_delete(Request $request, $page)
    {
        return self::api(self::delete($page, $request->force));
    }
    function api_toggle($page)
    {
        return self::api(self::toggle($page));
    }

    function web_modify(Request $request, $page = null)
    {
        return self::web(self::base_modify($page));
    }
    function api_modify(Request $request, $page = null)
    {
        return self::api(self::base_modify($page));
    }
    function base_modify($page, $params = null)
    {
        $params ??= [
            "group_id" => request('group'),
            "uri" => request('uri'),
            "title" => request('title'),
            "panel" => request('panel'),
            "inner_permits" => request('inner_permits', []),
            "visible" => request('visible', 0),
            "permission_required" => request('permission_required', 0),
            "status" => request('status') ?? 0,
        ];
        return $page == null ? self::create($params) : self::update($page, $params);
    }
}
