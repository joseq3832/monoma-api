<?php

namespace App\Http\Controllers\Api\Auth;

use App\DTOs\TokenDTO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only('username', 'password');

        try {
            if (! $token = auth()->attempt($credentials)) {
                return response()->json(['errors' => 'Password incorrect for: '.$request->username], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['errors' => $e], 500);
        }

        $reponse = ([
            'token' => $token,
            'minutes_to_expire' => auth()->factory()->getTTL(),
        ]);

        $response = TokenDTO::from($reponse);

        return response()->json($response);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return response()->json(auth()->user());
    }
}
