<?php

namespace Mantis\Controllers\AdminControllers;

use Illuminate\Http\Request;
use Mantis\Controllers\MantisController;
use Mantis\Models\WebPage;

class WebPageController extends MantisController
{
    protected const MODEL = WebPage::class;

    private const STATUS = [
        ["msg" => "Web Page is now disabled !!!", "status" => "DISABLED"],
        ["msg" => "Web Page is now active !!!", "status" => "ACTIVE"]
    ];

    private const NOT_EXISTS = "Web Page does not exist !!!";
    private const EXISTS = "Web Page already exists !!!";
    private const CREATED = "Web Page has been created !!!";
    private const UPDATED = "Web Page has been updated !!!";
    private const DELETED = "Web Page has been deleted !!!";

    private const VIEW = "Mantis::admin.seo.page.";

    // Reading operations
    static function getUrl()
    {
        return request()->path();
    }
    static function getUrlData($url = null)
    {
        return (is_numeric($url) ? self::MODEL::find($url) : self::MODEL::where('slug', $url ?? self::getUrl())->first())?->toArray();
    }
    static function increment()
    {
        self::MODEL::where('slug', self::getUrl())->first()->increment('load_count');
    }

    // CRUD Operation
    static function create($params)
    {
        if (self::getUrlData(!is_numeric($params['slug']) ?: null))
            return self::error(self::EXISTS);
        try {
            $webpage = new (self::MODEL)($params);
            $webpage->save();
            return self::success(['msg' => self::CREATED, "page" => self::getUrlData($webpage->id)]);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }
    static function update($webpage, $params)
    {
        if (!($webpage = self::MODEL::find($webpage)))
            return self::error(self::NOT_EXISTS);
        try {
            unset($params['slug']);
            $webpage->update($params);
            return self::success(['msg' => self::UPDATED, "page" => self::getUrlData($webpage->id)]);
        } catch (\Throwable $th) {
            return self::error(self::SERVER_ERROR + ["error" => $th->getMessage()]);
        }
    }
    static function toggle($webpage)
    {
        if (!($webpage = self::MODEL::find($webpage)))
            return self::error(self::NOT_EXISTS);
        try {
            $webpage->status = !$webpage->status;
            $webpage->save();
            return self::success(self::STATUS[$webpage->status]);
        } catch (\Throwable $th) {
            return self::error(["msg" => self::SERVER_ERROR, "error" => $th->getMessage()]);
        }
    }
    static function delete($webpage)
    {
        if (!($webpage = self::MODEL::find($webpage)))
            return self::error(self::NOT_EXISTS);
        try {
            $webpage->delete();
            return self::success(static::DELETED);
        } catch (\Throwable $th) {
            return self::error(["msg" => self::SERVER_ERROR, "error" => $th->getMessage()]);
        }
    }

    // View Pages
    function ui_view($webpage = null)
    {
        if ($webpage == null) {
            $data = ["webpages" => self::MODEL::all()->toArray()];
            return view(self::VIEW . "view_webpages", $data);
        } else {
            $data = ["webpage" => self::getUrlData($webpage)];
            return view(self::VIEW . "view_webpage", $data);
        }
    }
    function ui_modify($webpage = null)
    {
        $data = $webpage == null ? [] : ["webpage" => self::getUrlData($webpage)];
        return view(self::VIEW . "modify_webpage", $data);
    }

    function web_check()
    {
        return self::web(['isExist' => !!self::getUrlData(request('webpage'))]);
    }
    function web_toggle($webpage)
    {
        return self::web(self::toggle($webpage));
    }
    function web_delete($webpage)
    {
        return self::web(self::delete($webpage));
    }

    function api_check()
    {
        return self::api(['isExist' => !!self::getUrlData(request('webpage'))]);
    }
    function api_toggle($webpage)
    {
        return self::api(self::toggle($webpage));
    }
    function api_delete($webpage)
    {
        return self::api(self::delete($webpage));
    }

    function web_modify(Request $request, $webpage = null)
    {
        return self::web(self::base_modify($webpage));
    }
    function api_modify(Request $request, $webpage = null)
    {
        return self::api(self::base_modify($webpage));
    }
    function base_modify($webpage, $params = null)
    {
        $params ??= [
            "slug" => request('slug'),
            "title" => request('title'),
            "description" => request('description'),
            "keyword" => request('keyword'),
            "other_meta" => request('other_meta'),
            "load_count" => request('load_count') ?? 0,
            "status" => request('status') ?? 0,
        ];
        return $webpage == null ? self::create($params) : self::update($webpage, $params);
    }
}
