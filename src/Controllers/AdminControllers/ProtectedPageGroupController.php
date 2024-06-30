<?php

namespace Mantis\Controllers\AdminControllers;

use Illuminate\Http\Request;
use Mantis\Controllers\MantisController;
use Mantis\Models\ProtectedPageGroup;

class ProtectedPageGroupController extends MantisController
{
    protected const MODEL = ProtectedPageGroup::class;

    private const STATUS = [
        ["msg" => "Page Group is now disabled !!!", "status" => "DISABLED"],
        ["msg" => "Page Group is now active !!!", "status" => "ACTIVE"]
    ];

    private const NOT_EXISTS = "Page Group does not exist !!!";
    private const EXISTS = "Page Group already exists !!!";
    private const CREATED = "Page Group has been created !!!";
    private const UPDATED = "Page Group has been updated !!!";
    private const DELETED = "Page Group has been deleted !!!";

    private const VIEW = "Mantis::admin.protected.group.";

    // Reading operations
    static function getGroup($group)
    {
        return self::MODEL::withCount('pages')->find($group)?->toArray();
    }
    static function getGroupWithPages($group)
    {
        return self::MODEL::with('active_pages')->find($group)?->toArray();
    }
    static function getGroupWithAllPages($group)
    {
        return self::MODEL::with('pages')->find($group)?->toArray();
    }
    static function getGroups()
    {
        return self::MODEL::withCount('pages')->get()?->toArray();
    }
    static function getGroupsWithPages($panel = null, $pages = null)
    {
        $query = self::MODEL::query();

        if ($panel !== null) {
            $query->whereHas('display_pages', function ($q) use ($panel, $pages) {
                $q->where('panel', $panel);
                if (($pages[0] ?? 'x') != '*') $q->whereIn('id', $pages)->orWhere('permission_required', 0);
            });
        }

        $groups = $query->with(['display_pages' => function ($q) use ($panel, $pages) {
            if ($panel !== null) {
                $q->where('panel', $panel);
                if (($pages[0] ?? 'x') != '*') $q->whereIn('id', $pages)->orWhere('permission_required', 0);
            }
        }])->get()->toArray();

        return $groups;
    }
    static function getGroupsWithAllPages()
    {
        return self::MODEL::with('pages')->get()->toArray();
    }

    // CRUD Operation
    static function create($params)
    {
        $group = new (self::MODEL)($params);
        try {
            $group->save();
            return self::success(["msg" => self::CREATED]);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }
    static function update($group, $params)
    {
        if (!($group = self::MODEL::find($group)))
            return self::error(self::NOT_EXISTS);
        try {
            $group->update($params);
            return self::success(["msg" => self::UPDATED]);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }
    static function toggle($group)
    {
        if (!($group = self::MODEL::find($group)))
            return self::error(self::NOT_EXISTS);
        try {
            $group->status = !$group->status;
            $group->save();
            return self::success(self::STATUS[$group->status]);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }
    static function delete($group, $force)
    {
        if (!($group = self::MODEL::find($group)))
            return self::error(self::NOT_EXISTS);
        try {
            $group->delete();
            return self::success(static::DELETED);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }

    // View Pages
    function ui_view($group = null)
    {
        if ($group == null) {
            $data = ["groups" => self::getGroups()];
            return view(self::VIEW . "view_groups", $data);
        } else {
            $data = ["group" => self::getGroup($group)];
            return view(self::VIEW . "view_group", $data);
        }
    }
    function ui_modify($group = null)
    {
        $data = ($group == null) ? [] : ["group" => self::getGroup($group)];
        return view(self::VIEW . "modify_group", $data);
    }

    function web_delete(Request $request, $group)
    {
        return self::web(self::delete($group, $request->force));
    }
    function web_toggle($group)
    {
        return self::web(self::toggle($group));
    }

    function api_delete(Request $request, $group)
    {
        return self::api(self::delete($group, $request->force));
    }
    function api_toggle($group)
    {
        return self::api(self::toggle($group));
    }

    function web_modify(Request $request, $group = null)
    {
        return self::web(self::base_modify($group));
    }
    function api_modify(Request $request, $group = null)
    {
        return self::web(self::base_modify($group));
    }
    function base_modify($group, $params = null)
    {
        $params ??= [
            "title" => request('title'),
            "sort_order" => request('sort_order'),
            "status" => request('status', 0),
        ];
        return $group == null ? self::create($params) : self::update($group, $params);
    }
}
