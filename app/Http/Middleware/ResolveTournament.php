<?php

namespace App\Http\Middleware;

use App\Models\Tournament;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ResolveTournament
{
    public function handle(Request $request, Closure $next)
    {
        $param = $request->route('tournament');

        $tournament = match (true) {
            $param instanceof Tournament => $param,
            is_string($param) => Tournament::with('rulesets')->where('slug', $param)->firstOrFail(),
            default => Tournament::with('rulesets')->where('is_active', true)->first(),
        };

        View::share('tournament', $tournament);
    
        return $next($request);
    }
}