<?php

namespace Mantis\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Mantis\Controllers\AdminControllers\WebPageController as URL;
use Mantis\Controllers\AdminControllers\WebUriController as URI;
use Symfony\Component\HttpFoundation\Response;

class UriTrackMid
{
    public function handle(Request $request, Closure $next): Response
    {
        if (str_starts_with(URL::getUrl(), 'admin')) $track = false;

        // Tracking URI
        $uri = URI::getUriData() ?? URI::create(['uri' => URI::getUri(), 'status' => 1, "track" => $track ?? 1])['uri'];
        // Checking if uri is disabled
        if (!$uri['status']) abort(404);
        // Clearing previous stored data if state is TEST
        if ($uri['state'] == "dev") record(['css', 'js'], [], true);

        if (!str_starts_with(URL::getUrl(), 'admin')) {
            // Tracking URL
            $url = URL::getUrlData() ?? URL::create(["slug" => URL::getUrl(), "status" => 1])['page'];
            $path = $url['slug'];

            // Checking if url is disabled
            if (!$url['status']) abort(404);

            // Increase load count
            if (!in_array($path, ($visited = session('visited') ?? []))) {
                session()->put('visited', [...$visited, $path]);
                URL::increment();
            } else {
                $revisit = true;
            }
        }

        View::share(['metaCont' => URL::class, "isRevisit" => $revisit ?? false]);
        $request->merge(["isRevisit" => $revisit ?? false]);

        return $next($request);
    }
}
