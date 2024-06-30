<?php

namespace Mantis\Controllers\ExternalControllers;

use Illuminate\Support\Facades\Http;
use Mantis\Controllers\MantisController;
use Mantis\Helpers\fs;
use ZipArchive;
use Illuminate\Support\Str;


class PluginController extends MantisController
{
    private function plugin_path($path)
    {
        return base_path("plugins/$path");
    }

    function get_plugin_data($plugin, $version = null)
    {
        return self::fetch("plugin/$plugin/$version");
    }
    function view_plugins()
    {
        $plugins = self::fetch("plugin");
        dd($plugins);
    }
    function view_plugin($plugin, $version = null)
    {
        $plugins = self::get_plugin_data($plugin, $version);
        dd($plugins);
    }
    function download_plugin($plugin, $version = '1.0.0')
    {
        if (is_dir(self::plugin_path(ucfirst(Str::camel($plugin)))))
            return self::api(self::error("Plugin has already installed !!!"));

        $pluginData = self::get_plugin_data($plugin, $version);
        if (!$pluginData['success']) {
            return $pluginData;
        }

        $pluginData = $pluginData['plugin'];
        foreach ($pluginData['dependencies'] as $dep) {
            self::download_plugin($dep['name'], $dep['version']);
        }

        $response = Http::get(config('mantis.server') . "plugin/{$plugin}/{$version}/download");

        $contentType = $response->header('Content-Type');
        if ($contentType == "application/zip") {
            file_put_contents(self::plugin_path("{$plugin}-{$version}"), $response->body());
            if (self::extractZip($plugin, $version)) {
                self::register_plugin($pluginData);
            }
        } else if ($contentType == "application/json") {
            return $response;
        }
        return self::api(self::success("Plugin has been downloaded !!!"));
    }

    public function DeletePlugin($plugin)
    {
        $pp = self::plugin_path($plugin);
        if (is_dir($pp)) $this->deleteDirectory($pp);
        $this->unregister_plugin($plugin);
        return self::success("Plugin has been removed !!!");
    }

    function register_plugin($plugin)
    {
        $fp = self::plugin_path('plugins.json');
        $data = json_decode(file_get_contents($fp), true);
        $deps = [];
        foreach ($plugin['dependencies'] as $dep) {
            $deps[] = [...$dep, "plugin" => ucfirst(Str::camel($dep['name']))];
        }
        $data[$plugin['name']] = [
            "plugin" => ucfirst(Str::camel($plugin['name'])),
            "version" => $plugin['version'],
            "dependencies" => $deps,
        ];
        file_put_contents($fp, json_encode($data));
    }
    function unregister_plugin($plugin)
    {
        $fp = self::plugin_path('plugins.json');
        $data = json_decode(file_get_contents($fp), true);
        unset($data[$plugin['name']]);
        file_put_contents($fp, json_encode($data));
    }
    private function extractZip($plugin, $version)
    {
        $temp_path = self::plugin_path("{$plugin}-{$version}");
        $pp = self::plugin_path(null);
        $zip = new ZipArchive;
        if ($zip->open($temp_path) === TRUE) {
            fs::create_dir($pp);
            $zip->extractTo($pp);
            $zip->close();
            unlink($temp_path);
            return true;
        } else {
            return false;
        }
    }
    private function deleteDirectory($dir)
    {
        if (!file_exists($dir)) return true;
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') continue;
            if (!$this->deleteDirectory("{$dir}/{$item}")) return false;
        }
        return rmdir($dir);
    }
}
