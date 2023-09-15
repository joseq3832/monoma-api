<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'max:50'],
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('access_token');
            $expiresAt = Carbon::parse($token->token->expires_at);
            $now = Carbon::now();
            $minutesToExpire = $now->diffInMinutes($expiresAt);

            return response()->json([
                'meta' => [
                    'success' => true,
                    'errors' => [],
                ],
                'data' => [
                    'token' => $token->accessToken,
                    'minutes_to_expire' => $minutesToExpire + 1,
                ],
            ], 200);
        } else {
            return response()->json([
                'meta' => [
                    'success' => false,
                    'errors' => ['Password incorrect for: '.$request->username],
                ],
                'data' => null,
            ], 200);
        }
    }
}
