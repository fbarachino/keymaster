<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureLandlord
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->role !== 'landlord') {
            abort(403, 'Access denied: landlord only.');
        }

        return $next($request);
    }
}
