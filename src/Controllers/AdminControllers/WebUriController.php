<?php

namespace Mantis\Controllers\AdminControllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mantis\Controllers\MantisController;
use Mantis\Models\WebUri;

class WebUriController extends MantisController
{
    protected const MODEL = WebUri::class;

    private const URI_STATES = ['dev', 'test', 'prod'];

    private const STATUS = [
        ["msg" => "Web Uri is now disabled !!!", "status" => "DISABLED"],
        ["msg" => "Web Uri is now active !!!", "status" => "ACTIVE"]
    ];

    private const NOT_EXISTS = "Web Uri does not exist !!!";
    private const EXISTS = "Web Uri already exists !!!";
    private const CREATED = "Web Uri has been created !!!";
    private const UPDATED = "Web Uri has been updated !!!";
    private const DELETED = "Web Uri has been deleted !!!";
    protected const STATE_CHANGE = "Web Uri state has been changed !!!";

    private const VIEW = "Mantis::admin.seo.uri.";

    // Reading operations
    static function isExist($uri = null)
    {
        return !!self::getUriData($uri);
    }
    static function getUri($url = null)
    {
        return ($url ? Route::getRoutes()->match(Request::create($url)) : request()->route())->uri();
    }
    static function getUriData($uri = null)
    {
        return (($uri != null && is_numeric($uri)) ? self::MODEL::find($uri) : self::MODEL::where('uri', $uri ?? self::getUri())->first())?->toArray();
    }

    // CRUD Operation
    static function create($params)
    {
        if (self::getUriData($params['uri']))
            return self::error(self::EXISTS);
        try {
            $uri = new (self::MODEL)($params);
            $uri->save();
            return self::success(["msg" => self::CREATED, "uri" => self::getUriData($uri->id)]);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }
    static function update($uri, $params)
    {
        if (!($uri = self::MODEL::find($uri)))
            return self::error(self::NOT_EXISTS);
        unset($params['uri']);
        try {
            $uri->update($params);
            return self::success(["msg" => self::UPDATED, "uri" => self::getUriData($uri->id)]);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }
    static function toggle($uri)
    {
        if (!($uri = self::MODEL::find($uri)))
            return self::error(self::NOT_EXISTS);
        try {
            $uri->status = !$uri->status;
            $uri->save();
            return self::success(self::STATUS[$uri->status]);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }
    static function change_state($uri, $state)
    {
        if (!($uri = self::MODEL::find($uri)))
            return self::error(self::NOT_EXISTS);
        try {
            $uri->state = $state;
            $uri->save();
            return self::success(self::STATE_CHANGE);
        } catch (\Throwable $th) {
            return self::error(['msg' => self::SERVER_ERROR, "error" => $th->getMessage()]);
        }
    }
    static function delete($uri)
    {
        if (!($uri = self::MODEL::find($uri)))
            return self::error(self::NOT_EXISTS);
        try {
            $uri->delete();
            return self::success(static::DELETED);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }

    // View Pages
    function ui_view($uri = null)
    {
        if ($uri) {
            $data = ['weburi' => self::getUriData($uri)];
            return view(self::VIEW . "view_uri", $data);
        } else {
            $data = ['weburis' => self::MODEL::all()->toArray()];
            return view(self::VIEW . "view_uris", $data);
        }
    }
    function ui_modify($uri = null)
    {
        $data = $uri ? ['weburi' => self::getUriData($uri)] : [];
        return view(self::VIEW . "modify_uri", $data);
    }

    function web_check()
    {
        return self::web(['isExist' => self::isExist(request('uri'))]);
    }
    function web_toggle($uri)
    {
        return self::web(self::toggle($uri));
    }
    function web_change_state($uri)
    {
        return self::web(self::change_state($uri, request('state') ?? 0));
    }
    function web_delete($uri)
    {
        return self::web(self::delete($uri));
    }

    function api_check()
    {
        return self::api(['isExist' => self::isExist(request('uri'))]);
    }
    function api_toggle($uri)
    {
        return self::api(self::toggle($uri));
    }
    function api_change_state($uri)
    {
        return self::api(self::change_state($uri, request('state') ?? 0));
    }
    function api_delete($uri)
    {
        return self::api(self::delete($uri));
    }

    function web_modify(Request $request, $uri = null)
    {
        return self::web(self::base_modify($uri));
    }
    function api_modify(Request $request, $uri = null)
    {
        return self::web(self::base_modify($uri));
    }
    function base_modify($uri, $params = null)
    {
        $state = request('state') ?? 'dev';
        $params ??= [
            'uri' => request('uri'),
            'state' => in_array($state, self::URI_STATES) ? $state : self::URI_STATES[0],
            'status' => request('status') ?? false,
            'track' => request('track') ?? false
        ];
        return $uri == null ? self::create($params) : self::update($uri, $params);
    }
}
