<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureTenant
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->role !== 'tenant') {
            abort(403, 'Access denied: tenant only.');
        }

        return $next($request);
    }
}
