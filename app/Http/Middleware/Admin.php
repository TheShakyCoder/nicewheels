<?php

namespace App\Http\Middleware;

use App\Models\Team;
use Closure;
use Illuminate\Http\Request;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
//        $admin = Team::query()->where('name', 'Admin')->first();

//        if (!$request->user() || !$request->user()->belongsToTeam($admin)) {
        if (!$request->user() || !$request->user()->admin) {
            return response()->redirectTo('/');
        }

        return $next($request);
    }
}
