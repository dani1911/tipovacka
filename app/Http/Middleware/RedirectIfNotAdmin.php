<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->hasRole(['admin', 'super_admin'])) {
            return redirect('/');
        }

        return $next($request);
    }
}