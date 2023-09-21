<?php

namespace Src\Aplication\Contracts;

use Illuminate\Http\Request;

interface IAuthService
{
    public function login(Request $request);
}
