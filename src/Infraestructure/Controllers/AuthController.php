<?php

namespace Src\Infraestructure\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Aplication\Contracts\IAuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(IAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        return $this->authService->login($request);
    }
}
