<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetUserLocale
{
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            App::setLocale(auth()->user()->language ?? 'it');
        }

        return $next($request);
    }
}
