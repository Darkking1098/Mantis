<?php

namespace Mantis\Helpers;

use Illuminate\Support\Facades\File;

class fs
{
    static function folders($path)
    {
        $temp = [];
        foreach (File::directories($path) as $folder)
            $temp[] = basename($folder);
        return $temp;
    }
    static function files($path)
    {
        $temp = [];
        foreach (File::files($path) as $file)
            $temp[] = basename($file);
        return $temp;
    }
    static function create_dir($path)
    {
        if (!is_dir($path)) mkdir($path, 0777, true);
    }
    static function create_file($file, $content = null)
    {
        if(!is_file($file)){
            self::create_dir(dirname($file));
            $file = fopen($file, 'w');
            if ($content) fwrite($file, $content);
            fclose($file);;
        }
    }
}
