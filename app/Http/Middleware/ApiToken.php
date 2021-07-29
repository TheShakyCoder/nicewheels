<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class ApiToken
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
        $user = User::query()->where('api_token', $request->api_token)->first();
        if(!$user) {
            return response()->json('Unauthorized', 401);
        }

        //  set user in request
        $request->merge(['user' => $user ]);
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        //  update session
        $period = config('session.lifetime') * 60;
        \DB::table('sessions')->where('user_id', '=', $user->id)->update(['last_activity' => time() + $period]);

        return $next($request);
    }
}
