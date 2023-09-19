<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only('username', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('access_token');
            $minutesToExpire = $token->token->expires_at->diffInMinutes(now());

            return response()->json([
                'token' => $token->accessToken,
                'minutes_to_expire' => $minutesToExpire + 1,
            ], 200);

        } else {
            return response()->json([
                'errors' => 'Password incorrect for: '.$request->username,
            ], 401);
        }
    }
}
