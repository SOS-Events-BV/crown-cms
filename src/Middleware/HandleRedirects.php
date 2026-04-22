<?php

namespace SOSEventsBV\CrownCms\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use SOSEventsBV\CrownCms\Models\Redirect;

class HandleRedirects
{
    public function handle(Request $request, Closure $next)
    {
        // Don't check for redirects on admin pages
        if ($request->is('admin') || $request->is('admin/*')) return $next($request);

        // Cache all redirects, if not done so
        $redirects = Cache::rememberForever(
            'redirects',
            fn() => Redirect::all()->keyBy('from')->toArray()
        );

        // Check if the path has a redirect
        $redirect = $redirects[$request->path()] ?? null;

        // If there is a redirect there, redirect to `to`
        if ($redirect) return redirect($redirect['to'], $redirect['status_code']);

        return $next($request);
    }
}
