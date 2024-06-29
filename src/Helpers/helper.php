<?php

use Mantis\Controllers\AdminControllers\WebUriController as URI;

function record($type, $con, $clear = false)
{
    $uri = URI::getUriData();
    if ($uri['state'] != "dev") return;
    $uri = $uri['uri'];

    $dir_path = __DIR__ . "/record.json";

    try {
        $content = json_decode(file_get_contents($dir_path), true);
    } catch (\Throwable $th) {
        $content = [];
    }

    if (!isset($content[$uri]))
        $content[$uri] = ['css' => ['base'], 'js' => ['base']];

    foreach ($type as $t) {
        if (!$clear) {
            $content[$uri][$t] = array_unique([...$content[$uri][$t], ...(is_array($con) ? $con : [$con])]);
        } else {
            $content[$uri][$t] = ['base'];
        }
    }

    file_put_contents($dir_path, json_encode($content));
}

function mantis($comp)
{
    record(['css', 'js'], $comp);
}

function mantisCss($comp)
{
    record(['css'], $comp);
}

function mantisJs($comp)
{
    record(['js'], $comp);
}

function dateformat($date)
{
    $dateTime = new DateTime($date);
    return $dateTime->format('d M Y, h:ia');
}
