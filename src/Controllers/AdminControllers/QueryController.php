<?php

namespace Mantis\Controllers\AdminControllers;

use Illuminate\Http\Request;
use Mantis\Controllers\MantisController;
use Mantis\Models\Query;

class QueryController extends MantisController
{
    protected const STORE = "";

    protected const MODEL = Query::class;

    private const STATUS = [
        ["msg" => "Query is now disabled !!!", "status" => "DISABLED"],
        ["msg" => "Query is now active !!!", "status" => "ACTIVE"]
    ];

    private const NOT_EXISTS = "Query does not exist !!!";
    private const EXISTS = "Query uri already exists !!!";
    private const CREATED = "Query has been created !!!";
    private const UPDATED = "Query has been updated !!!";
    private const DELETED = "Query has been deleted !!!";

    private const VIEW = "Mantis::admin.query.";

    // CRUD Operation
    static function create($params)
    {
        $Query = new (self::MODEL)($params);
        try {
            $Query->save();
            return self::success(["msg" => self::CREATED]);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }
    static function update($Query, $params)
    {
        if (!($Query = self::MODEL::find($Query)))
            return self::error(self::NOT_EXISTS);
        try {
            $Query->update($params);
            return self::success(["msg" => self::UPDATED]);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }
    static function toggle($Query)
    {
        if (!($Query = self::MODEL::find($Query)))
            return self::error(self::NOT_EXISTS);
        try {
            $Query->status = !$Query->status;
            $Query->save();
            return self::success(self::STATUS[$Query->status]);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }
    static function delete($Query, $force)
    {
        if (!($Query = self::MODEL::find($Query)))
            return self::error(self::NOT_EXISTS);
        try {
            $Query->delete();
            return self::success(static::DELETED);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }

    // View Pages
    function ui_view($query = null)
    {
        if ($query == null) {
            $data = ['queries' => self::MODEL::all()->toArray()];
            return view(self::VIEW . "view_queries", $data);
        } else {
            $data = ['query' => self::MODEL::find($query)->toArray()];
            return view(self::VIEW . "view_query", $data);
        }
    }
    function ui_modify($query = null)
    {
        if ($query == null) {
            $data = [];
        } else {
            $data = [];
        }
        return view(self::VIEW . "modify_", $data);
    }

    function web_delete($Query)
    {
        return self::web(self::delete($Query, request('force')));
    }
    function web_toggle($Query)
    {
        return self::web(self::toggle($Query));
    }

    function api_delete($Query)
    {
        return self::api(self::delete($Query, request('force')));
    }
    function api_toggle($Query)
    {
        return self::api(self::toggle($Query));
    }

    function web_modify(Request $request, $Query = null)
    {
        return self::web(self::base_modify($Query));
    }
    function api_modify(Request $request, $Query = null)
    {
        return self::api(self::base_modify($Query));
    }
    function base_modify($Query, $params = null)
    {
        $params ??= [
            "name" => request('name'),
            "email" => request('email'),
            "subject" => request('subject'),
            "message" => request('message'),
        ];
        return $Query == null ? self::create($params) : self::update($Query, $params);
    }
}
