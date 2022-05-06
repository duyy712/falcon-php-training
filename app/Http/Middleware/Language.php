<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Session()->has('applocale') && array_key_exists(Session()->get('applocale'), Config::get('languages'))) {
            App::setlocale(Session()->get('applocale'));
        } else {
            App::setlocale(config('app.fallback_locale'));
        }

        return $next($request);
    }
}
