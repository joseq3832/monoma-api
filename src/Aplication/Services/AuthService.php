<?php

namespace Src\Aplication\Services;

use Illuminate\Http\Request;
use Src\Aplication\Contracts\IAuthService;
use Src\Infraestructure\Contracts\IAuthRepository;

class AuthService implements IAuthService
{
    protected $authRepository;

    public function __construct(IAuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login(Request $request)
    {
        return $this->authRepository->login($request);
    }
}
