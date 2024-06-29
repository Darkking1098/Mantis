<?php

namespace Mantis\Controllers;

use Illuminate\Support\Str;
use Mantis\Helpers\fs;

class MantisController
{
    const SERVER_ERROR = ["msg" => "Some server issue. Contact Developer !!!", "code" => 500, "response_code" => "SERVER_ERROR"];
    const AVOID_GUEST = ["msg" => "You are not logged in !!!", "code" => 400, "response_code" => "AVOID_GUEST"];

    protected const STORE = 'images/';

    protected const MODEL = '';

    static function random($len)
    {
        return Str::random($len ?? 10);
    }

    // Error Response
    static function error($response)
    {
        return ['success' => false] + (is_array($response) ? $response : ['msg' => $response]);
    }

    // Success response
    static function success($response)
    {
        return ['success' => true] + (is_array($response) ? $response : ['msg' => $response]);
    }

    // Use to send web response
    static function web($result)
    {
        session()->flash('result', $result + ["timestamp" => time()]);
        return redirect()->back();
    }

    // Use to send api response with some default data
    static function api($result)
    {
        return response()->json($result + ["timestamp" => time()]);
    }

    static function store($path)
    {
        return static::STORE . $path;
    }

    // Move Files to a particular location
    static function move_file($file, $filename = null, $path = null)
    {
        $url = $path ?? static::STORE;
        $path = public_path($url);

        if ($url[-1] != "/") $url .= "/";

        // Create Directory if not exists
        fs::create_dir($path);

        // Rename file to new name
        $img = ($filename ?: self::random(10) . time()) . '.' . $file->getClientOriginalExtension();

        // Returning new filename with action status
        return [
            "success" => $file->move($path, $img),
            "filename" => $img,
            'path' => $url . $img,
        ];
    }

    //
    static function convertToWebp($file, $filename = null, $path = null, $quality = 100)
    {
        $image = $file->getPathname();

        // Get the image type
        $imageInfo = getimagesize($file);
        $mimeType = $imageInfo['mime'];

        // Create a new image from file
        switch ($mimeType) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($file);
                break;
            case 'image/png':
                $image = imagecreatefrompng($file);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($file);
                break;
            default:
                return self::move_file($file, $filename, $path);
        }

        $url = $path ?? static::STORE;
        $path = public_path($url);

        if ($url[-1] != "/") $url .= "/";

        // Create Directory if not exists
        fs::create_dir($path);

        $filename = (($filename ? ($filename . "-") : '') . self::random(10) . time()) . '.webp';

        // Save the image in WebP format
        if (!imagewebp($image, $url . $filename, $quality))
            return self::move_file($file, $filename, $path);

        // Free up memory
        imagedestroy($image);

        return ["success" => true, "filename" => $filename, "path" => $url . $filename];
    }

    function getFillable()
    {
        $model = new (static::MODEL);
        return $model->getFillable();
    }

    function fetch($slug)
    {
        return json_decode(file_get_contents(config('mantis.server') . $slug), true);
    }
}
