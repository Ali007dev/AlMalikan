<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)

    {


        if (!in_array($request->header("lang"), config('app.available_locales'))) {

            App::setLocale('en');
        } elseif ($request->header("lang") == 'ar') {

            App::setLocale('ar');
        } elseif ($request->header("lang") == 'en') {

            App::setLocale('en');
        }


        return $next($request);
    }
}
