<?php

namespace Mantis\Controllers\ExternalControllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

class MantisUiController
{
    private $server, $css, $js, $dir;

    public function __construct()
    {
        $this->dir = __DIR__ . "/../../Helpers/record.json";
        $this->server = config('mantis.server');
        if ($referer = request()->headers->get('referer'))
            $uri = Route::getRoutes()->match(Request::create($referer))->uri;
        try {
            $content = json_decode(file_get_contents($this->dir), true)[$uri];
        } catch (\Throwable $th) {
            $content = ['css' => ['base'], 'js' => ['base']];
        }
        $this->css = $content['css'];
        $this->js = $content['js'];
    }

    function fetch_css()
    {
        foreach ($this->css as $comp)
            $content[] = self::fetch('css', $comp);
        return Response::make(implode(' ', $content))->header('Content-Type', 'text/css');
    }
    function fetch_js()
    {
        foreach ($this->js as $comp)
            $content[] = self::fetch('js', $comp);
        return Response::make(implode(' ', $content))->header('Content-Type', 'text/javascript');
    }

    private function storage($file)
    {
        return public_path('mantis/' . $file);
    }

    private function fetch($type, $file = null)
    {
        // Creating directory if not exists to store files
        $dir = self::storage($type);
        if (!is_dir($dir)) mkdir($dir, 0777, true);

        $fn = $type . "/" . $file . '.' . $type;
        $f = self::storage($fn);
        if (is_file($f)) return file_get_contents($f);
        $content = file_get_contents($this->server . "$type?comp=$file");
        file_put_contents($f, $content);
        return $content;
    }
}
