<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            return response()->json([
                'user' => $user
            ], 200);
        }
    }

    public function logout(Request $request)
    {
        \Log::info($request->user());
        \DB::table('sessions')->where('user_id', $request->user()->id)->delete();
        \Session::flush();
        return response()->json([], 200);
    }
}
