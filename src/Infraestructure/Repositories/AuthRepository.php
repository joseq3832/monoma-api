<?php

namespace Src\Infraestructure\Repositories;

use Illuminate\Http\Request;
use Src\Infraestructure\Contracts\IAuthRepository;
use Src\Infraestructure\DTOs\TokenDTO;
use Tymon\JWTAuth\Exceptions\JWTException;

final class AuthRepository implements IAuthRepository
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
}
